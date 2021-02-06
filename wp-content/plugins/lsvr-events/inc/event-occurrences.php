<?php
/**
 * Create custom DB table to hold all event occurrences. Should be fired on plugin activation only.
 */
if ( ! function_exists( 'lsvr_events_create_event_occurrences_db_table' ) ) {
	function lsvr_events_create_event_occurrences_db_table() {

		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		// Create event occurrences table
		$occurrences_table_name = esc_attr( $wpdb->prefix ) . 'lsvr_event_occurrences';
		$occurrences_table_sql = "CREATE TABLE $occurrences_table_name (
			postid mediumint(9) NOT NULL,
			start datetime NOT NULL,
			end datetime NOT NULL,
			allday tinyint(1) NOT NULL,
			CONSTRAINT pk_event PRIMARY KEY (postid,start,end,allday)
		) $charset_collate;";
		dbDelta( $occurrences_table_sql );

	}
}

/**
 * Remove all event occurrences from DB when event post is being trashed or removed
 */
add_action( 'before_delete_post', 'lsvr_events_remove_event_occurrences', 100, 1 );
add_action( 'trashed_post', 'lsvr_events_remove_event_occurrences', 100, 1 );
if ( ! function_exists( 'lsvr_events_remove_event_occurrences' ) ) {
	function lsvr_events_remove_event_occurrences( $postid ) {
		if ( 'lsvr_event' === get_post_type( $postid ) ) {

			global $wpdb;
			$occurrences_table_name = esc_attr( $wpdb->prefix ) . 'lsvr_event_occurrences';
			$wpdb->delete( $occurrences_table_name,
				array( 'postid' => $postid ),
				array( '%d' )
			);

			// Remove transients
			lsvr_events_remove_transients();

		}
	}
}

/**
 * Function which handles generating and saving to DB of event occurrences.
 * Gets fired everytime an event (lsvr_event post type) is saved.
 */
add_action( 'save_post', 'lsvr_events_save_event_occurrences', 100, 2 );
if ( ! function_exists( 'lsvr_events_save_event_occurrences' ) ) {
	function lsvr_events_save_event_occurrences( $post_id, $post ) {
		if ( 'lsvr_event' === $post->post_type ) {

			global $wpdb;
			$occurrences_table_name = esc_attr( $wpdb->prefix ) . 'lsvr_event_occurrences';

			// Check if event is all-day event
			$event_allday = 'true' === get_post_meta( $post->ID, 'lsvr_event_allday', true ) ? true : false;

			// Get event start date & time
			$event_start_date_utc = get_post_meta( $post->ID, 'lsvr_event_start_date_utc', true );
			if ( strtotime( $event_start_date_utc ) ) {
				$event_start_date_utc = date( 'Y-m-d H:i:s', strtotime( $event_start_date_utc ) );
				$event_start_time = date( 'H:i:s', strtotime( $event_start_date_utc ) );
			} else {
				$event_start_date_utc = false;
				$event_start_time = false;
			}

			// Get event end date
			$event_end_date_utc = get_post_meta( $post->ID, 'lsvr_event_end_date_utc', true );
			if ( strtotime( $event_end_date_utc ) ) {
				$event_end_date_utc = date( 'Y-m-d H:i:s', strtotime( $event_end_date_utc ) );
				$event_end_time = date( 'H:i:s', strtotime( $event_end_date_utc ) );
			}

			// If end date is not defined set it to the same date as start date
			else {
				$event_end_date_utc = $event_start_date_utc;
				$event_end_time = $event_start_time;
			}

			// Get local start and end times
			$event_start_time_local = get_date_from_gmt( $event_start_date_utc, 'H:i:s' );
			$event_end_time_local = get_date_from_gmt( $event_end_date_utc, 'H:i:s' );

			// Get event recurrence
			$event_repeat = get_post_meta( $post->ID, 'lsvr_event_repeat', true );
			if ( ! empty( $event_repeat ) && 'false' !== $event_repeat ) {
				$event_repeat_day = get_post_meta( $post->ID, 'lsvr_event_repeat_day', true );
				$event_repeat_xth = get_post_meta( $post->ID, 'lsvr_event_repeat_xth', true );
			} else {
				$event_repeat = false;
				$event_repeat_day = false;
				$event_repeat_xth = false;
			}

			// Get maximum occurrence date
			$event_repeat_until = get_post_meta( $post->ID, 'lsvr_event_repeat_until', true );
			if ( ! empty( $event_repeat_until ) && strtotime( $event_repeat_until ) ) {
				$event_repeat_until = date( 'Y-m-d 23:59:59', strtotime( $event_repeat_until ) );
			} else {
				$event_repeat_until = false;
			}

			// Preserve past occurrences
			$event_preserve_past = true === apply_filters( 'lsvr_events_preserve_old_event_occurrences_on_save', false );

			// Proceed only if the start date is defined
			if ( false !== $event_start_date_utc ) {

				// Prepare array for event occurrences
				$occurrences = array();

				// Event has only single occurrence
				if ( false === $event_repeat ) {

					$occurrences[] = array(
						'start' => $event_start_date_utc,
						'end' => $event_end_date_utc,
						'allday' => intval( $event_allday ),
					);

				}

				// Event has multiple occurrences
				else if ( false !== $event_repeat && false !== $event_repeat_until ) {

					// Daily recurrence
					if ( 'day' === $event_repeat ) {

						// Repeat on specific days
						if ( ! empty( $event_repeat_day ) ) {
							$recurrence_days = explode( ',', $event_repeat_day );
						}
						// Repeat each day
						else {
							$recurrence_interval = '+1 day';
						}

					}

					// Every xth recurrence
					else if ( ! empty( $event_repeat_xth ) &&
						( 'first' === $event_repeat || 'second' === $event_repeat || 'third' === $event_repeat || 'fourth' === $event_repeat || 'last' === $event_repeat ) ) {
						$recurrence_interval_xth = $event_repeat . ' ' . $event_repeat_xth;
					}

					// Every weekday recurrence
					else if ( 'weekday' === $event_repeat ) {
						$recurrence_days = array( 'mon', 'tue', 'wed', 'thu', 'fri' );
					}

					// Weekly recurrence
					else if ( 'week' === $event_repeat ) {
						$recurrence_interval = '+1 week';
					}

					// Every two weeks recurrence
					else if ( 'biweek' === $event_repeat ) {
						$recurrence_interval = '+2 week';
					}

					// Monthly recurrence
					else if ( 'month' === $event_repeat ) {
						$recurrence_interval = '+1 month';
					}

					// Every two months recurrence
					else if ( 'bimonth' === $event_repeat ) {
						$recurrence_interval = '+2 month';
					}

					// Yearly recurrence
					else if ( 'year' === $event_repeat ) {
						$recurrence_interval = '+1 year';
					}

					// Create occurrences
					if ( ! empty( $recurrence_interval ) || ! empty( $recurrence_days ) || ! empty( $recurrence_interval_xth ) ) {

						// Repeat until timestamp
						$event_repeat_until_timestamp = strtotime( $event_repeat_until );

						// Initial occurence
						$occurrence_start_timestamp = strtotime( $event_start_date_utc );
						$occurrence_end_timestamp = strtotime( $event_end_date_utc );

						// Get length of single occurrence
						$occurrence_length_timestamp = $occurrence_end_timestamp - $occurrence_start_timestamp;

						// Standard occurrence loop
						if ( ! empty( $recurrence_interval ) ) {
							while ( $occurrence_start_timestamp <= $event_repeat_until_timestamp ) {

								// Convert timestamp to date
								$occurrence_start = date( 'Y-m-d ' . $event_start_time, $occurrence_start_timestamp );
								$occurrence_end = date( 'Y-m-d ' . $event_end_time, $occurrence_end_timestamp );

								// Add occurrence
								$occurrences[] = array(
									'start' => $occurrence_start,
									'end' => $occurrence_end,
									'allday' => intval( $event_allday ),
								);

								// Prepare next occurrence
								$occurrence_start_timestamp = strtotime( $occurrence_start . ' ' . $recurrence_interval );
								$occurrence_end_timestamp = $occurrence_start_timestamp + $occurrence_length_timestamp;

							}
						}

						// Specific every Xth occurrence
						else if ( ! empty( $recurrence_interval_xth ) ) {
							while ( $occurrence_start_timestamp <= $event_repeat_until_timestamp ) {

								// Prepare relative format
								$relative_format = $recurrence_interval_xth . ' of ' . date( 'F Y', $occurrence_start_timestamp );

								// Convert timestamp to date
								$occurrence_start = date( 'Y-m-d ' . $event_start_time, strtotime( $relative_format ) );
								$occurrence_end = date( 'Y-m-d ' . $event_end_time, strtotime( $relative_format ) + $occurrence_length_timestamp );

								// Add occurrence
								if ( strtotime( $occurrence_start ) <= $event_repeat_until_timestamp ) {
									$occurrences[] = array(
										'start' => $occurrence_start,
										'end' => $occurrence_end,
										'allday' => intval( $event_allday ),
									);
								}

								// Prepare next occurrence
								$occurrence_start_timestamp = strtotime( get_gmt_from_date( $occurrence_start, 'Y-m-01 00:00:00' ) . ' +1 month' );

							}
						}

						// Specific weekday occurrence
						else if ( ! empty( $recurrence_days ) ) {

							// Add first occurrence (can be set to any day, not only those on which it will be repeated)
							$occurrences[] = array(
								'start' => date( 'Y-m-d ' . $event_start_time, $occurrence_start_timestamp ),
								'end' => date( 'Y-m-d ' . $event_end_time, $occurrence_end_timestamp ),
								'allday' => intval( $event_allday ),
							);

							// Array with all weekdays
							$weekdays = array( 'mon', 'tue', 'wed', 'thu', 'fri', 'sun', 'sat' );

							// Initial occurrence day
							$initial_occurrence_dayname = strtolower( date( 'D', $occurrence_start_timestamp ) );
							$initial_occurrence_dayname_index = array_search( $initial_occurrence_dayname, $weekdays );

							// Initial iteration
							$initial_iteration = true;

							// Additional occurrences
							while ( $occurrence_start_timestamp <= $event_repeat_until_timestamp ) {
								foreach ( $recurrence_days as $dayname ) {

									// On the first iteration, skip to the next week day relative to initial occurrence day
									if ( true === $initial_iteration ) {
										$dayname_index = array_search( $dayname, $weekdays );
										if ( $dayname_index <= $initial_occurrence_dayname_index ) {
											continue;
										}
									}

									// Prepare next occurrence
									$occurrence_start = date( 'Y-m-d H:i:s', $occurrence_start_timestamp );
									$occurrence_start_time = date( 'H:i:s', $occurrence_start_timestamp );
									$occurrence_start_timestamp = strtotime( $occurrence_start . ' next ' . $dayname );

									// When recurring via weekdays, time resets to 00:00, so let's make sure the correct time gets saved to DB
									$occurrence_start_fix = date( 'Y-m-d', $occurrence_start_timestamp ) . ' ' . $occurrence_start_time;
									$occurrence_start_timestamp = strtotime( $occurrence_start_fix );

									// Generate occurrence end date
									$occurrence_end_timestamp = $occurrence_start_timestamp + $occurrence_length_timestamp;

									// Add next occurrence
									if ( $occurrence_start_timestamp <= $event_repeat_until_timestamp ) {
										$occurrences[] = array(
											'start' => date( 'Y-m-d ' . $event_start_time, $occurrence_start_timestamp ),
											'end' => date( 'Y-m-d ' . $event_end_time, $occurrence_end_timestamp ),
											'allday' => intval( $event_allday ),
										);
									}

								}
								$initial_iteration = false;
							}

						}

					}

				}

				// If set, remove only future occurrences (keep past ones) before inserting new ones
				if ( true === $event_preserve_past ) {
					$current_time = current_time( 'mysql', true );
					$wpdb->query(
						$wpdb->prepare(
							"
							DELETE FROM $occurrences_table_name
							WHERE postid = %d
							AND start > %s
							",
							$post_id, $current_time
						)
					);
				}

				// Remove all existing event occurrences before inserting new ones
				else {
					$wpdb->delete( $occurrences_table_name,
						array( 'postid' => $post_id ),
						array( '%d' )
					);
				}

				// Proceed to insert occurrences into DB
				if ( ! empty( $occurrences ) ) {

					// Prepare query
					$query_values = array();
					$query_place_holders = array();
					$query = "
						INSERT IGNORE INTO $occurrences_table_name
						( postid, start, end, allday )
						VALUES ";
					foreach ( $occurrences as $occurrence ) {
						array_push( $query_values, $post_id, $occurrence['start'], $occurrence['end'], $occurrence['allday'] );
						$query_place_holders[] = '( %d, %s, %s, %d )';
					}
					$query .= implode( ', ', $query_place_holders );

					// Run query
					$wpdb->query( $wpdb->prepare( $query, $query_values ) );

				}

				// Remove transients
				lsvr_events_remove_transients();

			}

        }
	}
}

?>