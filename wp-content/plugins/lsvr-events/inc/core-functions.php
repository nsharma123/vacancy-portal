<?php
/**
 * Main function to retrieve events from DB.
 *
 * @param array $args {
 *		Optional. An array of arguments. If not defined, function will return all events from DB.
 *
 *		@type int|array		$event_id		Single ID or array of IDs of lsvr_event post(s).
 *											Only occurrences of these events will be retrieved from DB.
 *											Leave blank to retrieve occurrences of any lsvr_event posts.
 *
 *		@type int|array		$category		lsvr_event_cat term ID to retrieve events from.
 *
 *		@type int|array		$tag			lsvr_event_tag term ID to retrieve events from.
 *
 *		@type int|array		$location		lsvr_event_location term ID to retrieve events from.
 *
 *		@type string		$period			Narrow the SQL query to retrieve only past occurrences
 *											(ones which already occurred) or future ones
 *											(ones which haven't happended yet).
 *											Accepts 'past', 'future'.
 *
 *		@type string		$keyword		Retrieve occurrences based on keyword.
 *
 *		@type string		$date_from		Retrieve occurrences from this date onwards. Can be affected by $period.
 *											Use a local date. Date gets converted to UTC inside the function.
 *											Format 'Y-m-d H:i:s'.
 *
 *		@type string		$date_to		Retrieve occurrences to this date. Can be affected by $period.
 *											Use a local date. Date gets converted to UTC inside the function.
 *											Format 'Y-m-d H:i:s'
 *
 *		@type int			$limit			Max number of occurrences to retrieve.
 *
 *		@type int			$offset			Retrieve results with offset.
 *
 *		@type string		$orderby		Set which DB column will be used for ordering.
 *											Accepts 'postid', 'start', 'end'.
 *											Default: 'start'.
 *
 *		@type string		$order			Set order of retrieved occurrences as ascending or descending.
 *											Accepts 'ASC', 'DESC'.
 *											Default 'ASC'.
 *
 *		@type bool			$return_utc		If true, retrieved occurrence dates (start and end) will be returned
 *											in UTC format as they are stored in database.
 *											Otherwise they will be converted to local time before returning.
 *											Default: false.
 *
 *		@type array			$to_return		Which data should be returned.
 *											Values 'occurrences', 'events', 'event_id'.
 *											Default 'occurrences'.
 * }
 * @return array 	Retrieved occurrences ('occurrences'),
 *					lsvr_event posts associated with the retrieved occurrences ('events'),
 *					lsvr_event posts IDs associated with the retrieved occurrences ('event_ids').
 *
 *					Returned data can be altered via $arg['to_return'] parameter.
 */
if ( ! function_exists( 'lsvr_events_get' ) ) {
	function lsvr_events_get( $args = array() ) {

		// Get event IDs via post params
		if ( ! empty( $args['event_id'] ) || ! empty( $args['keyword'] ) ||
			! empty( $args['category'] ) || ! empty( $args['tag'] ) || ! empty( $args['location'] ) ) {

			$post_query_active = true;
			$tax_query = array();

			// Default query args
			$query_args = array(
				'post_type' => 'lsvr_event',
				'posts_per_page' => 1000,
				'fields' => 'ids',
			);

			// Include post IDs
			if ( ! empty( $args['event_id'] ) ) {
				if ( is_array( $args['event_id'] ) ) {
					$event_id = array_map( 'intval', $args['event_id'] );
				} else {
					$event_id = array( (int) $args['event_id'] );
				}
				$query_args['post__in'] = $event_id;
			}

			// Keyword search
			if ( ! empty( $args['keyword'] ) ) {
				$query_args['s'] = wp_strip_all_tags( $args['keyword'] );
			}

			// Category taxonomy
			if ( ! empty( $args['category'] ) ) {
				if ( is_array( $args['category'] ) ) {
					$category = array_map( 'intval', $args['category'] );
				} else {
					$category = array( (int) $args['category'] );
				}
				array_push( $tax_query, array(
					'taxonomy' => 'lsvr_event_cat',
					'field' => 'term_id',
					'terms' => $category,
				));
			}

			// Tag taxonomy
			if ( ! empty( $args['tag'] ) ) {
				if ( is_array( $args['tag'] ) ) {
					$tag = array_map( 'intval', $args['tag'] );
				} else {
					$tag = array( (int) $args['tag'] );
				}
				array_push( $tax_query, array(
					'taxonomy' => 'lsvr_event_tag',
					'field' => 'term_id',
					'terms' => $tag,
				));
			}

			// Location taxonomy
			if ( ! empty( $args['location'] ) ) {
				if ( is_array( $args['location'] ) ) {
					$location = array_map( 'intval', $args['location'] );
				} else {
					$location = array( (int) $args['location'] );
				}
				array_push( $tax_query, array(
					'taxonomy' => 'lsvr_event_location',
					'field' => 'term_id',
					'terms' => $location,
				));
			}

			// Pass tax query into query args
			if ( ! empty( $tax_query ) ) {
				$query_args['tax_query'] = $tax_query;
			}

			// Run query
			$event_id = get_posts( $query_args );

		}

		// Continue only if no tax query args were passed or if tax query args returned event post IDs
		if ( ! isset( $post_query_active ) ||
			( isset( $post_query_active ) && true === $post_query_active && ! empty( $event_id ) ) ) {

			// Current time
			$current_time_utc = current_time( 'Y-m-d H:i:00', true );

			// Period
			$period = false;
			if ( ! empty( $args['period'] ) ) {
				if ( 'past' === $args['period'] ) {
					$period = 'past';
				}
				else if ( 'future' === $args['period'] ) {
					$period = 'future';
				}
			}

			// Get date_from
			if ( ! empty( $args['date_from'] ) && strtotime( $args['date_from'] ) ) {
				$date_from = date( 'Y-m-d H:i:00', strtotime( $args['date_from'] ) );
				$date_from_utc = get_gmt_from_date( $date_from, 'Y-m-d H:i:00' );
			} else {
				$date_from_utc = false;
			}

			// If period is set to past but date_from is set to future, reset the date_from value
			if ( 'past' === $period && strtotime( $date_from_utc ) && strtotime( $date_from_utc ) > strtotime( $current_time_utc ) ) {
				$date_from_utc = false;
			}

			// If period is set to future but date_from is set to past (or not set at all), set the date_from value to current time
			else if ( 'future' === $period && ( false === $date_from_utc ||
				( strtotime( $date_from_utc ) && strtotime( $date_from_utc ) < strtotime( $current_time_utc ) ) ) ) {
				$date_from_utc = $current_time_utc;
			}

			// Get date_to
			if ( ! empty( $args['date_to'] ) && strtotime( $args['date_to'] ) ) {
				$date_to = date( 'Y-m-d H:i:00', strtotime( $args['date_to'] ) );
				$date_to_utc = get_gmt_from_date( $date_to, 'Y-m-d H:i:00' );
			} else {
				$date_to_utc = false;
			}

			// If period is set to past but date_to is set to future (or not set), set the date_to value to current time
			if ( 'past' === $period ) {
				if ( false === $date_to_utc ||
					( strtotime( $date_to_utc ) && strtotime( $date_to_utc ) > strtotime( $current_time_utc ) ) ) {
					$date_to_utc = $current_time_utc;
				}
			}

			// If period is set to future but date_to is set to past, reset the date_to value
			else if ( 'future' === $period ) {
				if ( strtotime( $date_to_utc ) && strtotime( $date_to_utc ) < strtotime( $current_time_utc ) ) {
					$date_to_utc = false;
				}
			}

			// Check if date_from is lower than date_to
			if ( ( strtotime( $date_from_utc ) && strtotime( $date_to_utc ) ) &&
				( strtotime( $date_from_utc ) > strtotime( $date_to_utc ) ) ) {
				$date_to_utc = false;
			}

			// Get number of events
			if ( ! empty( $args['limit'] ) && is_numeric( $args['limit'] ) ) {
				$limit = (int) apply_filters( 'lsvr_events_get_limit', $args['limit'] );
			} else {
				$limit = false;
			}

			// Get offset
			if ( ! empty( $args['offset'] ) && is_numeric( $args['offset'] ) ) {
				$offset = (int) apply_filters( 'lsvr_events_get_offset', $args['offset'] );
			} else {
				$offset = false;
			}

			// Get orderby of events
			if ( ! empty( $args['orderby'] ) && in_array( $args['orderby'], array( 'postid', 'start', 'end' ) ) ) {
				$orderby = $args['orderby'];
			} else {
				$orderby = 'start';
			}

			// Get order of events
			$order = ! empty( $args['order'] ) && 'DESC' === strtoupper( $args['order'] ) ? 'DESC' : 'ASC';

			// Get format of retrieved occurences
			$return_utc = ! empty( $args['return_utc'] ) && true === $args['return_utc'] ? true : false;

			// Which data should be returned
			$to_return = ! empty( $args['to_return'] ) && is_array( $args['to_return'] ) ? $args['to_return'] : array( 'occurrences' );

			// Prepare SQL query
			global $wpdb;
			$occurrences_table_name = esc_attr( $wpdb->prefix ) . 'lsvr_event_occurrences';

			// Prepare query with events between dates
			if ( ! empty( $date_from_utc ) && ! empty( $date_to_utc ) ) {
				$sql_query = $wpdb->prepare(
					"
					SELECT * FROM $occurrences_table_name
					WHERE ( ( start >= %s AND end <= %s )
					OR ( start <= %s AND end >= %s )
					OR ( start <= %s AND end >= %s ) )
					",
					$date_from_utc, $date_to_utc,
					$date_from_utc, $date_from_utc,
					$date_to_utc, $date_to_utc
				);
			}

			// Prepare query with events from date
			else if ( ! empty( $date_from_utc ) ) {
				$sql_query = $wpdb->prepare(
					"
					SELECT * FROM $occurrences_table_name
					WHERE ( start >= %s
					OR ( start <= %s AND end >= %s ) )
					",
					$date_from_utc,
					$date_from_utc ,$date_from_utc
				);
			}

			// Prepare query with events to date
			else if ( ! empty( $date_to_utc ) ) {
				$sql_query = $wpdb->prepare(
					"
					SELECT * FROM $occurrences_table_name
					WHERE ( end <= %s
					OR ( start <= %s AND end >= %s ) )
					",
					$date_to_utc,
					$date_to_utc, $date_to_utc
				);
			}

			// Prepare query with events regardless of start or end date
			else {
				$sql_query =
					"
					SELECT * FROM $occurrences_table_name
					";
			}

			// Retrieve occurrences by event IDs
			if ( ! empty( $event_id ) && is_array( $event_id ) ) {

				$event_id = array_unique( $event_id );
				$operator = ! empty( $date_from_utc ) || ! empty( $date_to_utc ) ? ' AND ' : ' WHERE ';
				$placeholders = '';
				foreach ( $event_id as $id ) {
					$placeholders .= '%d,';
				}
				$placeholders = rtrim( $placeholders, ',' );
				$sql_query = $wpdb->prepare( $sql_query . $operator . ' postid IN ( ' . $placeholders . ' )', $event_id );

			}

			// Order of retrieved events
			switch ( $orderby ) {
				case 'postid':
					$sql_query .= ' ORDER BY postid';
					break;
				case 'start':
					$sql_query .= ' ORDER BY start';
					break;
				case 'end':
					$sql_query .= ' ORDER BY end';
					break;
			}
			$sql_query .= 'DESC' === $order ? ' DESC' : ' ASC';

			// Number of events to be retrieved
			if ( false !== $limit ) {
				$sql_query = $wpdb->prepare( $sql_query . ' LIMIT %d', $limit );
			}

			// Set offset
			if ( false !== $offset ) {
				$sql_query = $wpdb->prepare( $sql_query . ' OFFSET %d', $offset );
			}

			// Do not cache admin queries
			if ( is_admin() ) {
				$retrieved_occurrences = $wpdb->get_results( $sql_query, ARRAY_A );
			}

			// Cache frontend queries
			else {
				$sql_query_hash = 'lsvr_events_get_t_' . md5( $sql_query );
				$transient = get_transient( $sql_query_hash );
				if ( ! empty( $transient ) ) {
					$retrieved_occurrences = $transient;
				}
				else {
					$retrieved_occurrences = $wpdb->get_results( $sql_query, ARRAY_A );
					set_transient( $sql_query_hash, $retrieved_occurrences, HOUR_IN_SECONDS );
				}
			}

			// At least one occurrence was retrieved
			if ( ! empty( $retrieved_occurrences ) ) {

				// Prepare array for event IDs found in retrieved occurrences
				$retrieved_event_ids = array();

				// Check if it's currently DST
				$current_date = new DateTime( current_time( 'Y-m-d' ) . ' ' . get_option( 'timezone_string' ) );
				$current_date_is_dst = (bool) $current_date->format( 'I' );

				// Parse retrieved occurrrences to make additional operations
				foreach ( $retrieved_occurrences as $key => $occurrence ) {

					// Fill the array with unique event IDs found in retrieved occurrences
					if ( ! empty( $occurrence['postid'] ) ) {
						array_push( $retrieved_event_ids, (int) $occurrence['postid'] );
					}

					// Convert dates to local time
					if ( false === $return_utc && ! empty( $occurrence['start'] ) && ! empty( $occurrence['end'] ) )  {
						$retrieved_occurrences[ $key ]['start'] = get_date_from_gmt( $occurrence['start'] );
						$retrieved_occurrences[ $key ]['end'] = get_date_from_gmt( $occurrence['end'] );
					}

					// Convert allday value to bool
					if ( ! empty( $occurrence['allday'] ) && 1 === intval( $occurrence['allday'] ) )  {
						$retrieved_occurrences[ $key ]['allday'] = true;
					} else {
						$retrieved_occurrences[ $key ]['allday'] = false;
					}

				}

				// Remove redundant event IDs if those IDs will be needed to retrieve event posts
				// or if they will be returned
				if ( in_array( 'events', $to_return ) || in_array( 'event_ids', $to_return ) ) {
					$retrieved_event_ids = array_values( array_unique( $retrieved_event_ids ) );
				}

				// Create an array with event posts found in retrieved occurrences
				$retrieved_events = array();
				if ( ! empty( $retrieved_event_ids ) && in_array( 'events', $to_return ) ) {

					// Get all event posts
					$event_posts = get_posts(array(
						'post_type' => 'lsvr_event',
						'post__in' => $retrieved_event_ids,
						'posts_per_page' => 1000,
					));

					// Create an array with event IDs used as keys and event objects as values
					$event_posts_parsed = array();
					foreach ( $event_posts as $event_post ) {
						$event_posts_parsed[ $event_post->ID ] = $event_post;
					}
					$retrieved_events = $event_posts_parsed;

				}

				// Return requested data
				$return = array();
				if ( in_array( 'occurrences', $to_return ) ) {
					$return['occurrences'] = $retrieved_occurrences;
				}
				if ( in_array( 'events', $to_return ) ) {
					$return['events'] = $retrieved_events;
				}
				if ( in_array( 'event_ids', $to_return ) ) {
					$return['event_ids'] = $retrieved_event_ids;
				}

				// Return meta data
				$return['meta'] = array(
					'args' => $args,
				);

				return apply_filters( 'lsvr_events_get_return', $return );

			}

			// No occurrences were retrieved
			else {
				return false;
			}

		}

		// No occurrences were retrieved
		else {
			return false;
		}

	}
}

/**
 * It takes the same arguments as lsvr_events_get_count() function,
 * but it returns only the number of results.
 *
 * @return integer 	Number of results.
 */
if ( ! function_exists( 'lsvr_events_get_count' ) ) {
	function lsvr_events_get_count( $args = array() ) {

		$query_args = array(
			'to_return' => array( 'occurrences' ),
		);
		$query_args = array_merge( $query_args, $args );

		$results = lsvr_events_get( $query_args );

		if ( ! empty( $results['occurrences'] ) ) {
			return count( $results['occurrences'] );
		} else {
			return 0;
		}

	}
}

/**
 * Retrieve today events. It generates correct $date_from and $date_to values
 * and passes them to lsvr_events_get function along with any other arguments.
 *
 * @param array $args 	It takes same arguments as lsvr_events_get function.
 * @return array 		It returns same values as lsvr_events_get function.
 *
 */
if ( ! function_exists( 'lsvr_events_get_today' ) ) {
	function lsvr_events_get_today( $args = array() ) {

		// Show only upcoming today events
		if ( ! empty( $args['period'] ) && 'future' === $args['period'] ) {
			$query_args = array(
				'date_from' => current_time( 'Y-m-d H:i:s' ),
				'date_to' => current_time( 'Y-m-d' ) . ' 23:59:59',
			);
		}

		// Show only past today events
		else if ( ! empty( $args['period'] ) && 'past' === $args['period'] ) {
			$query_args = array(
				'date_from' => current_time( 'Y-m-d' ) . ' 00:00:00',
				'date_to' => current_time( 'Y-m-d H:i:s' ),
			);
		}

		// Show all today events
		else {
			$query_args = array(
				'date_from' => current_time( 'Y-m-d' ) . ' 00:00:00',
				'date_to' => current_time( 'Y-m-d' ) . ' 23:59:59',
			);
		}

		// Merge args to be sent to main function
		if ( ! empty( $args ) ) {
			$query_args = array_merge( $args, $query_args );
		}

		// Retrieve events
		return lsvr_events_get( $query_args );

	}
}

/**
 * Retrieve current week events. It generates correct $date_from and $date_to values
 * and passes them to lsvr_events_get function along with any other arguments.
 *
 * @param array $args 	It takes same arguments as lsvr_events_get function.
 * @return array 		It returns same values as lsvr_events_get function.
 *
 */
if ( ! function_exists( 'lsvr_events_get_this_week' ) ) {
	function lsvr_events_get_this_week( $args = array() ) {
		if ( function_exists( 'get_weekstartend' ) ) {

			$week_start_end = get_weekstartend( current_time( 'mysql' ) );

			// Get week start date
			if ( ! empty( $week_start_end['start'] ) && is_numeric( $week_start_end['start'] ) ) {
				$week_start_date = date( 'Y-m-d H:i:s', (int) $week_start_end['start'] );
			} else {
				$week_start_date = false;
			}

			// Get week end date
			if ( ! empty( $week_start_end['end'] ) && is_numeric( $week_start_end['end'] ) ) {
				$week_end_date = date( 'Y-m-d H:i:s', (int) $week_start_end['end'] );
			} else {
				$week_end_date = false;
			}

			if ( ! empty( $week_start_date ) && ! empty( $week_end_date ) ) {

				// Show only upcoming current week events
				if ( ! empty( $args['period'] ) && 'future' === $args['period'] ) {
					$query_args = array(
						'date_from' => current_time( 'Y-m-d H:i:s' ),
						'date_to' => $week_end_date,
					);
				}

				// Show only past current week events
				else if ( ! empty( $args['period'] ) && 'past' === $args['period'] ) {
					$query_args = array(
						'date_from' => $week_start_date,
						'date_to' => current_time( 'Y-m-d H:i:s' ),
					);
				}

				// Show all events for current week
				else {
					$query_args = array(
						'date_from' => $week_start_date,
						'date_to' => $week_end_date,
					);
				}

				// Merge args to be sent to main function
				if ( ! empty( $args ) ) {
					$query_args = array_merge( $args, $query_args );
				}

				// Retrieve events
				return lsvr_events_get( $query_args );

			}

		}
	}
}

/**
 * Retrieve current month events. It generates correct $date_from and $date_to values
 * and passes them to lsvr_events_get function along with any other arguments.
 *
 * @param array $args 	It takes same arguments as lsvr_events_get function.
 * @return array 		It returns same values as lsvr_events_get function.
 *
 */
if ( ! function_exists( 'lsvr_events_get_this_month' ) ) {
	function lsvr_events_get_this_month( $args = array() ) {

		// Show only upcoming current month events
		if ( ! empty( $args['period'] ) && 'future' === $args['period'] ) {
			$query_args = array(
				'date_from' => current_time( 'Y-m-d H:i:s' ),
				'date_to' => current_time( 'Y-m-t' ) . ' 23:59:59',
			);
		}

		// Show only past current month events
		else if ( ! empty( $args['period'] ) && 'past' === $args['period'] ) {
			$query_args = array(
				'date_from' => current_time( 'Y-m-01' ) . ' 00:00:00',
				'date_to' => current_time( 'Y-m-d H:i:s' ),
			);
		}

		// Show all events for current month
		else {
			$query_args = array(
				'date_from' => current_time( 'Y-m-01' ) . ' 00:00:00',
				'date_to' => current_time( 'Y-m-t' ) . ' 23:59:59',
			);
		}

		// Merge args to be sent to main function
		if ( ! empty( $args ) ) {
			$query_args = array_merge( $args, $query_args );
		}

		// Retrieve events
		return lsvr_events_get( $query_args );

	}
}

/**
 * Retrieve current year events. It generates correct $date_from and $date_to values
 * and passes them to lsvr_events_get function along with any other arguments.
 *
 * @param array $args 	It takes same arguments as lsvr_events_get function.
 * @return array 		It returns same values as lsvr_events_get function.
 *
 */
if ( ! function_exists( 'lsvr_events_get_this_year' ) ) {
	function lsvr_events_get_this_year( $args = array() ) {

		// Show only upcoming current year events
		if ( ! empty( $args['period'] ) && 'future' === $args['period'] ) {
			$query_args = array(
				'date_from' => current_time( 'Y-m-d H:i:s' ),
				'date_to' => current_time( 'Y-12-31' ) . ' 23:59:59',
			);
		}

		// Show only past current year events
		else if ( ! empty( $args['period'] ) && 'past' === $args['period'] ) {
			$query_args = array(
				'date_from' => current_time( 'Y-01-01' ) . ' 00:00:00',
				'date_to' => current_time( 'Y-m-d H:i:s' ),
			);
		}

		// Show all events for current year
		else {
			$query_args = array(
				'date_from' => current_time( 'Y-01-01' ) . ' 00:00:00',
				'date_to' => current_time( 'Y-12-31' ) . ' 23:59:59',
			);
		}

		// Merge args to be sent to main function
		if ( ! empty( $args ) ) {
			$query_args = array_merge( $args, $query_args );
		}

		// Retrieve events
		return lsvr_events_get( $query_args );

	}
}

/**
 * Retrieve next occurrences of given event.
 * It passes arguments to lsvr_events_get function.
 *
 * @param int $event_id		ID of event post (lsvr_event post type)
 * @param int $limit		Number of occurrences
 * @param int $offset		Record offset
 * @return array 			Array with single occurrence (postid,start,end,allday). It return dates in local format.
 *
 */
if ( ! function_exists( 'lsvr_events_get_next_occurrences' ) ) {
	function lsvr_events_get_next_occurrences( $event_id, $limit = 1, $offset = 0 ) {

		$query_args = array(
			'event_id' => $event_id,
			'period' => 'future',
			'orderby' => 'start',
			'order' => 'ASC',
			'limit' => $limit,
			'offset' => $offset,
			'to_return' => array( 'occurrences' ),
		);
		$occurrences = lsvr_events_get( $query_args );
		if ( ! empty( $occurrences['occurrences'] ) ){
			return $occurrences['occurrences'];
		} else {
			return false;
		}

	}
}

/**
 * Retrieve recent occurrences of given event.
 * It passes arguments to lsvr_events_get function.
 *
 * @param int $event_id		ID of event post (lsvr_event post type)
 * @param int $limit		Number of occurrences
 * @param int $offset		Record offset
 * @return array 			Array with single occurrence (postid,start,end,allday). It return dates in local format.
 *
 */
if ( ! function_exists( 'lsvr_events_get_recent_occurrences' ) ) {
	function lsvr_events_get_recent_occurrences( $event_id, $limit = 1, $offset = 0 ) {

		$query_args = array(
			'event_id' => $event_id,
			'period' => 'past',
			'orderby' => 'start',
			'order' => 'DESC',
			'limit' => $limit,
			'offset' => $offset,
			'to_return' => array( 'occurrences' ),
		);
		$occurrences = lsvr_events_get( $query_args );
		if ( ! empty( $occurrences['occurrences'] ) ){
			return $occurrences['occurrences'];
		}
		else {
			return false;
		}

	}
}

/**
 * Retrieve first occurrence of given event.
 * It passes arguments to lsvr_events_get function.
 *
 * @param int $event_id		ID of event post (lsvr_event post type)
 * @return array 			Array with single occurrence (postid,start,end,allday). It return dates in local format.
 *
 */
if ( ! function_exists( 'lsvr_events_get_first_occurrence' ) ) {
	function lsvr_events_get_first_occurrence( $event_id ) {

		$query_args = array(
			'event_id' => $event_id,
			'orderby' => 'start',
			'order' => 'ASC',
			'limit' => 1,
			'to_return' => array( 'occurrences' ),
		);
		$occurrence = lsvr_events_get( $query_args );
		if ( ! empty( $occurrence['occurrences'][0] ) ){
			return $occurrence['occurrences'][0];
		}

	}
}

/**
 * Retrieve meta data for event location.
 *
 * @param int $event_id		ID of event post (lsvr_event post type)
 * @return array 			Array with event location meta (address,latitude,longitude).
 *
 */
if ( ! function_exists( 'lsvr_events_get_event_location_meta' ) ) {
	function lsvr_events_get_event_location_meta( $event_id ) {

		$return = array();

		// Get location meta
		$event_location_term = wp_get_post_terms( $event_id, 'lsvr_event_location' );
		if ( ! empty( $event_location_term[0]->term_id ) ) {

			// Get location term ID
			$location_term_id = $event_location_term[0]->term_id;

			// Get location meta
			$location_meta = get_option( 'lsvr_event_location_term_' . $location_term_id . '_meta' );

			// Get linked directory listing
			if ( ! empty( $location_meta['directory_listing_id'] ) ) {
				$directory_listing_id = $location_meta['directory_listing_id'];
			}

			// If location is linked to a directory, pull its data instead
			if ( ! empty( $directory_listing_id ) && 'false' !== $directory_listing_id &&
				function_exists( 'lsvr_directory_get_listing_meta' ) ) {

				// Get listing permalink
				$listing_permalink = get_permalink( (int) $directory_listing_id );
				if ( ! empty( $listing_permalink ) ) {
					$return['listing_permalink'] = $listing_permalink;
				}

				// Get meta data
				$listing_meta = lsvr_directory_get_listing_meta( (int) $directory_listing_id );
				if ( ! empty( $listing_meta ) ) {

					// Get address
					if ( ! empty( $listing_meta['address'] ) ) {
						$return['address'] = $listing_meta['address'];
					}

					// Get accurate address
					if ( ! empty( $listing_meta['accurate_address'] ) ) {
						$return['accurate_address'] = $listing_meta['accurate_address'];
					}

					// Get locating method
					if ( ! empty( $listing_meta['locating_method'] ) &&
						( 'latlong' === $listing_meta['locating_method'] || 'address' === $listing_meta['locating_method'] ) ) {
						$listing_locating_method = $listing_meta['locating_method'];
					} else {
						$listing_locating_method = false;
					}

					// Get geocoded latitude and longitude
					if ( ! empty( $listing_locating_method ) && 'address' === $listing_locating_method &&
						! empty( $listing_meta['latitude_geocoded'] ) && ! empty( $listing_meta['longitude_geocoded'] ) ) {
						$return['latitude'] = $listing_meta['latitude_geocoded'];
						$return['longitude'] = $listing_meta['longitude_geocoded'];
					}

					// Get defined latitude and longitude
					else if ( ! empty( $listing_locating_method ) && 'latlong' === $listing_locating_method &&
						! empty( $listing_meta['latitude'] ) && ! empty( $listing_meta['longitude'] ) ) {
						$return['latitude'] = $listing_meta['latitude'];
						$return['longitude'] = $listing_meta['longitude'];
					}

				}

			}

			// If no data were obtained via directory linking, use data from location meta
			if ( empty( $return ) ) {

				// Get address
				if ( ! empty( $location_meta['address'] ) ) {
					$return['address'] = $location_meta['address'];
				}

				// Get accurate address
				if ( ! empty( $location_meta['accurate_address'] ) ) {
					$return['accurate_address'] = $location_meta['accurate_address'];
				}

				// Get either user defined latitude and longitude or geocoded ones
				if ( ! empty( $location_meta['latlong'] ) ) {
					$latlong = $location_meta['latlong'];
				} else if ( ! empty( $location_meta['latlong_geocoded'] ) ) {
					$latlong = $location_meta['latlong_geocoded'];
				}

				// Parse latitude and longitude
				if ( ! empty( $latlong ) ) {
					$latlong = array_map( 'trim', explode( ',', $latlong ) );
					if ( ! empty( $latlong[0] ) && ! empty( $latlong[1] ) ) {
						$return['latitude'] = $latlong[0];
						$return['longitude'] = $latlong[1];
					}
				}

			}

		}

		return ! empty( $return ) ? $return : false;

	}
}

/**
 * Create array with lsvr_event archive pagination links
 *
 * @param int 		$posts_per_page			Number of lsvr_events posts per page.
 * @param string 	$page_get_var_name		Name of GET variable used to store current page number. Default: 'page'.
 * @param int 		$range					Range of displayed page numbers relative to current page number. Default: 2.
 * @return array 	Array with all pagination data.
 *
 */
if ( ! function_exists( 'lsvr_events_get_event_archive_pagination' ) ) {
	function lsvr_events_get_event_archive_pagination( $args, $posts_per_page = 20, $range = 2 ) {

		$pagination = array();
		$query_args = array();
		$url_args = array();
		$posts_per_page = (int) $posts_per_page > 0 ? (int) $posts_per_page : 1000;
		$range = (int) $range;

		// Get archive URL and alter args
		if ( is_post_type_archive( 'lsvr_event' ) ) {
			$archive_url = get_post_type_archive_link( 'lsvr_event' );
		}
		else if ( is_tax( 'lsvr_event_cat' ) ) {
			$archive_url = get_term_link( get_queried_object_id(), 'lsvr_event_cat' );
			$query_args['category'] = get_queried_object_id();
		}
		else if ( is_tax( 'lsvr_event_tag' ) ) {
			$archive_url = get_term_link( get_queried_object_id(), 'lsvr_event_tag' );
			$query_args['tag'] = get_queried_object_id();
		}
		else if ( is_tax( 'lsvr_event_location' ) ) {
			$archive_url = get_term_link( get_queried_object_id(), 'lsvr_event_location' );
			$query_args['location'] = get_queried_object_id();
		}

		// Merge passed args
		if ( ! empty( $args ) && is_array( $args ) ) {
			$query_args = array_merge( $query_args, $args );
			$url_args = array_merge( $url_args, $args );
		}

		// Get current page
		$current_page = ! empty( $_GET[ 'page' ] ) ? (int) $_GET[ 'page' ] : 1;

		// Get posts count
		$posts_count = lsvr_events_get_count( $query_args );

		// Get pages count
		$pages_count = ceil( $posts_count / $posts_per_page );

		if ( $pages_count > 1 ) {

			$pagination['current_page'] = $current_page;
			$pagination['posts_per_page'] = $posts_per_page;
			$pagination['posts_count'] = $posts_count;
			$pagination['pages_count'] = $pages_count;

			// Prev link
			if ( $current_page > 1 ) {
				$url_args['page'] = $current_page - 1;
				$pagination['prev'] = add_query_arg( $url_args, $archive_url );
			}

			// Next link
			if ( $current_page < $pages_count ) {
				$url_args['page'] = $current_page + 1;
				$pagination['next'] = add_query_arg( $url_args, $archive_url );
			}

			// First link
			$url_args['page'] = 1;
			$pagination['page_first'] = add_query_arg( $url_args, $archive_url );

			// Last link
			$url_args['page'] = $pages_count;
			$pagination['page_last'] = add_query_arg( $url_args, $archive_url );

			// Pages
			if ( $pages_count > 2 ) {

				$pagination['page_numbers'] = array();

				// Get all page numbers based on current page and range
				$page_numbers = array();
				for ( $i = $current_page - $range; $i <= $current_page + $range; $i++ ) {
					array_push( $page_numbers, $i );
				}

				// Add all valid page numbers to output array
				foreach ( $page_numbers as $index => $number ) {
					if ( $number > 1 && $number < $pages_count ) {
						$url_args['page'] = $number;
						$pagination['page_numbers'][ $number ] = add_query_arg( $url_args, $archive_url );
					}
				}
			}

			return $pagination;

		} else {
			return false;
		}

	}
}

/**
 * Remove transients
 *
 * @param string 	$prefix		Prefix of transient which should be deleted
 *
 * @link https://webdevstudios.com/2016/07/19/working-transients-like-boss/
 */
if ( ! function_exists( 'lsvr_events_remove_transients' ) ) {
	function lsvr_events_remove_transients( $prefix = '_transient_lsvr_events_get_t_' ) {

	    global $wpdb;

	    // SQL query
	    $sql = "SELECT `option_name` FROM $wpdb->options WHERE `option_name` LIKE '%s'";
	    $transients = $wpdb->get_results( $wpdb->prepare( $sql, $prefix . '%' ), ARRAY_A );

	    // If found transients
	    if ( $transients && ! is_wp_error( $transients ) ) {

		    if ( is_string( $transients ) ) {
		        $transients = array( array( 'option_name' => $transients ) );
		    }
		    if ( ! is_array( $transients ) ) {
		        return false;
		    }

		    // Loop through transients and remove them
		    foreach ( $transients as $transient ) {
		        if ( is_array( $transient ) ) {
		            $transient = current( $transient );
		        }
		        delete_transient( str_replace( '_transient_', '', $transient ) );
		    }

	    }

	}
}

/**
 * Get localized day name
 */
if ( ! function_exists( 'lsvr_events_get_i18n_day_name' ) ) {
	function lsvr_events_get_i18n_day_name( $day, $format = 'l' ) {

		return date_i18n( $format, strtotime( $day ) );

	}
}

/**
 * Get local start event time
 */
if ( ! function_exists( 'lsvr_events_get_event_local_start_time' ) ) {
	function lsvr_events_get_event_local_start_time( $post_id ) {

		$start_date_utc = get_post_meta( $post_id, 'lsvr_event_start_date_utc', true );
		$start_time_local = get_date_from_gmt( $start_date_utc, get_option( 'time_format' ) );

		return $start_time_local;

	}
}

/**
 * Get local end event time
 */
if ( ! function_exists( 'lsvr_events_get_event_local_end_time' ) ) {
	function lsvr_events_get_event_local_end_time( $post_id ) {

		$end_date_utc = get_post_meta( $post_id, 'lsvr_event_end_date_utc', true );
		$end_time_local = get_date_from_gmt( $end_date_utc, get_option( 'time_format' ) );

		return $end_time_local;

	}
}

?>