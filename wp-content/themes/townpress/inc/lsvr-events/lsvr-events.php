<?php

// Include additional files
require_once( get_template_directory() . '/inc/lsvr-events/actions.php' );
require_once( get_template_directory() . '/inc/lsvr-events/frontend-functions.php' );
require_once( get_template_directory() . '/inc/lsvr-events/customizer-config.php' );

// Is event page
if ( ! function_exists( 'lsvr_townpress_is_event' ) ) {
	function lsvr_townpress_is_event() {

		if ( is_post_type_archive( 'lsvr_event' ) || is_tax( 'lsvr_event_cat' ) || is_tax( 'lsvr_event_tag' ) ||
			is_tax( 'lsvr_event_location' ) || is_singular( 'lsvr_event' ) ) {
			return true;
		} else {
			return false;
		}

	}
}

// Get event archive layout
if ( ! function_exists( 'lsvr_townpress_get_event_archive_layout' ) ) {
	function lsvr_townpress_get_event_archive_layout() {

		return 'default';

	}
}

// Get event archive title
if ( ! function_exists( 'lsvr_townpress_get_event_archive_title' ) ) {
	function lsvr_townpress_get_event_archive_title() {

		return get_theme_mod( 'lsvr_event_archive_title', esc_html__( 'Events', 'townpress' ) );

	}
}

// Get event archive
if ( ! function_exists( 'lsvr_townpress_get_event_archive' ) ) {
	function lsvr_townpress_get_event_archive() {
		if ( function_exists( 'lsvr_events_get' ) ) {

			// Pagination offset
			$posts_per_page = get_theme_mod( 'lsvr_event_archive_posts_per_page', 12 );
			$current_page = ! empty( $_GET[ 'page' ] ) ? (int) $_GET[ 'page' ] : 1;
			$current_page = $current_page > 0 ? $current_page - 1 : $current_page;
			$pagination_offset = $posts_per_page * $current_page;

			// Main args
			$event_occurrences_args = array(
				'limit' => $posts_per_page,
				'orderby' => 'start',
				'offset' => $pagination_offset,
				'to_return' => 'occurrences',
			);

			// If category tax
			if ( is_tax( 'lsvr_event_cat' ) ) {
				$event_occurrences_args['category'] = get_queried_object_id();
			}

			// If location tax
			else if ( is_tax( 'lsvr_event_location' ) ) {
				$event_occurrences_args['location'] = get_queried_object_id();
			}

			// If tag tax
			else if ( is_tax( 'lsvr_event_tag' ) ) {
				$event_occurrences_args['tag'] = get_queried_object_id();
			}

			// Date from arg
			if ( ! empty( $_GET['date_from'] ) ) {
				$event_occurrences_args['date_from'] = date( 'Y-m-d 00:00:00', strtotime( $_GET['date_from'] ) );
			}

			// Order arg
			if ( ! empty( $_GET['order'] ) ) {
				$event_occurrences_args['order'] = 'asc' === strtolower( $_GET['order'] ) ? 'ASC' : 'DESC';
			}

			// If no date from and date to are defined, display upcoming events
			if ( empty( $_GET['date_from'] ) && empty( $_GET['date_to'] ) && empty( $_GET['period'] ) ) {
				$event_occurrences_args['period'] = 'future';
			} else if ( ! empty( $_GET['period'] ) ) {
				$event_occurrences_args['period'] = 'past' === $_GET['period'] ? 'past' : 'future';
			}

			// Get occurrences
			$occurences = lsvr_events_get( $event_occurrences_args );

			return ! empty( $occurences['occurrences'] ) ? $occurences['occurrences'] : array();

		}
	}
}

// Has events
if ( ! function_exists( 'lsvr_townpress_has_events' ) ) {
	function lsvr_townpress_has_events() {

		$events = lsvr_townpress_get_event_archive();
		return ! empty( $events ) ? true : false;

	}
}

// Get event archive grid class
if ( ! function_exists( 'lsvr_townpress_get_event_post_archive_grid_class' ) ) {
	function lsvr_townpress_get_event_post_archive_grid_class() {

		$number_of_columns = ! empty( get_theme_mod( 'lsvr_event_archive_grid_columns', 2 ) ) ? (int) get_theme_mod( 'lsvr_event_archive_grid_columns', 2 ) : 2;
		$span = 12 / $number_of_columns;
		$md_cols = $span > 2 ? 2 : $span;
		$sm_cols = $span > 2 ? 2 : $span;
		$masonry = true === get_theme_mod( 'lsvr_event_archive_masonry_enable', false ) ? ' lsvr-grid--masonry' : '';

		return 'lsvr-grid lsvr-grid--' . esc_attr( $number_of_columns ) . '-cols lsvr-grid--md-' . esc_attr( $md_cols ) . '-cols lsvr-grid--sm-' . esc_attr( $sm_cols ) . '-cols' . esc_attr( $masonry );

	}
}

// Is recurring event
if ( ! function_exists( 'lsvr_townpress_is_recurring_event' ) ) {
	function lsvr_townpress_is_recurring_event( $post_id ) {

		$repeat_meta = get_post_meta( $post_id, 'lsvr_event_repeat', true );
		return empty( $repeat_meta ) || 'false' === $repeat_meta ? false : true;

	}
}

// Get next event occurrences
if ( ! function_exists( 'lsvr_townpress_get_next_event_occurrences' ) ) {
	function lsvr_townpress_get_next_event_occurrences( $post_id, $limit = 100, $offset = 0 ) {
		if ( function_exists( 'lsvr_events_get_next_occurrences' ) ) {

			return lsvr_events_get_next_occurrences( $post_id, $limit, $offset );

		}
	}
}

// Has next event occurrences
if ( ! function_exists( 'lsvr_townpress_has_next_event_occurrences' ) ) {
	function lsvr_townpress_has_next_event_occurrences( $post_id ) {

		$next_occurrences = lsvr_townpress_get_next_event_occurrences( $post_id, 1 );
		return ! empty( $next_occurrences ) ? true : false;

	}
}

// Get next event occurrence start date
if ( ! function_exists( 'lsvr_townpress_get_next_event_occurrence_start' ) ) {
	function lsvr_townpress_get_next_event_occurrence_start( $post_id, $format = 'c', $offset = 0 ) {

		$next_occurrence = lsvr_townpress_get_next_event_occurrences( get_the_ID(), 1, $offset );
		$next_occurrence = ! empty( $next_occurrence[0]['start'] ) ? new DateTime( $next_occurrence[0]['start'] ) : false;
		return ! empty( $next_occurrence ) ? $next_occurrence->format( $format ) : false;

	}
}

// Get next event occurrence end date
if ( ! function_exists( 'lsvr_townpress_get_next_event_occurrence_end' ) ) {
	function lsvr_townpress_get_next_event_occurrence_end( $post_id, $format = 'c', $offset = 0 ) {

		$next_occurrence = lsvr_townpress_get_next_event_occurrences( get_the_ID(), 1, $offset );
		$next_occurrence = ! empty( $next_occurrence[0]['end'] ) ? new DateTime( $next_occurrence[0]['end'] ) : false;
		return ! empty( $next_occurrence ) ? $next_occurrence->format( $format ) : false;

	}
}

// Get recent event occurrences
if ( ! function_exists( 'lsvr_townpress_get_recent_event_occurrences' ) ) {
	function lsvr_townpress_get_recent_event_occurrences( $post_id, $limit = 1, $offset = 0 ) {
		if ( function_exists( 'lsvr_events_get_recent_occurrences' ) ) {

			return lsvr_events_get_recent_occurrences( $post_id, $limit, $offset );

		}
	}
}

// Get event occurence pattern text
if ( ! function_exists( 'lsvr_townpress_get_event_recurrence_pattern_text' ) ) {
	function lsvr_townpress_get_event_recurrence_pattern_text( $post_id , $template = '%s' ) {

		if ( lsvr_townpress_is_recurring_event( $post_id ) ) {

			$pattern = get_post_meta( $post_id, 'lsvr_event_repeat', true );
			$pattern_xth = get_post_meta( $post_id, 'lsvr_event_repeat_xth', true );

			if ( 'day' === $pattern ) {

				$pattern_day = get_post_meta( $post_id, 'lsvr_event_repeat_day', true );

				if ( empty( $pattern_day ) ) {
					$pattern = esc_html__( 'day', 'townpress' );
				}
				else {
					$days = explode( ',', $pattern_day );
					$pattern = implode( ', ', array_map( 'lsvr_townpress_get_day_name', $days ) );
				}

			}

			else if ( 'first' === $pattern || 'second' === $pattern || 'third' === $pattern || 'fourth' === $pattern || 'last' === $pattern ) {
				$pattern_labels = array(
					'first' => esc_html__( '1st', 'townpress' ),
					'second' => esc_html__( '2nd', 'townpress' ),
					'third' => esc_html__( '3rd', 'townpress' ),
					'fourth' => esc_html__( '4th', 'townpress' ),
					'last' => esc_html__( 'last', 'townpress' ),
				);
				$day_labels = array(
					'mon' => esc_html__( 'Monday', 'townpress' ),
					'tue' => esc_html__( 'Tuesday', 'townpress' ),
					'wed' => esc_html__( 'Wednesday', 'townpress' ),
					'thu' => esc_html__( 'Thursday', 'townpress' ),
					'fri' => esc_html__( 'Friday', 'townpress' ),
					'sat' => esc_html__( 'Saturday', 'townpress' ),
					'sun' => esc_html__( 'Sunday', 'townpress' ),
				);
				$pattern_label = ! empty( $pattern_labels[ $pattern ] ) ? $pattern_labels[ $pattern ] : $pattern;
				$day_label = ! empty( $day_labels[ $pattern_xth ] ) ? $day_labels[ $pattern_xth ] : $pattern_xth;
				$pattern = sprintf( esc_html__( '%s %s', 'townpress' ), $pattern_label, $day_label );
			}

			else if ( 'weekday' === $pattern ) {
				$pattern = esc_html__( 'weekday', 'townpress' );
			}
			else if ( 'week' === $pattern ) {
				$pattern = esc_html__( 'week', 'townpress' );
			}
			else if ( 'biweek' === $pattern ) {
				$pattern = esc_html__( 'two weeks', 'townpress' );
			}
			else if ( 'month' === $pattern ) {
				$pattern = esc_html__( 'month', 'townpress' );
			}
			else if ( 'bimonth' === $pattern ) {
				$pattern = esc_html__( 'two months', 'townpress' );
			}
			else if ( 'year' === $pattern ) {
				$pattern = esc_html__( 'year', 'townpress' );
			}

			return sprintf( $template, $pattern );

		}

	}
}

// Is all-day event
if ( ! function_exists( 'lsvr_townpress_is_allday_event' ) ) {
	function lsvr_townpress_is_allday_event( $post_id ) {

		$allday_meta = get_post_meta( $post_id, 'lsvr_event_allday', true );
		return empty( $allday_meta ) || 'false' === $allday_meta ? false : true;

	}
}

// Is multi-day event
if ( ! function_exists( 'lsvr_townpress_is_multiday_event' ) ) {
	function lsvr_townpress_is_multiday_event( $post_id ) {

		$start_date = get_post_meta( $post_id, 'lsvr_event_start_date_utc', true );
		$end_date = get_post_meta( $post_id, 'lsvr_event_end_date_utc', true );

		if ( ! empty( $start_date ) && ! empty( $end_date ) ) {

			$start_date_local = get_date_from_gmt( $start_date, 'Y-m-d ' );
			$end_date_local = get_date_from_gmt( $end_date, 'Y-m-d' );
			return strtotime( $start_date_local ) < strtotime( $end_date_local ) ? true : false;

		} else {
			return false;
		}

	}
}

// Has event end time
if ( ! function_exists( 'lsvr_townpress_has_event_end_time' ) ) {
	function lsvr_townpress_has_event_end_time( $post_id ) {

		$endtime_enable = get_post_meta( $post_id, 'lsvr_event_end_time_enable', true );
		return 'true' === $endtime_enable ? true : false;

	}
}

// Has location
if ( ! function_exists( 'lsvr_townpress_has_event_location' ) ) {
	function lsvr_townpress_has_event_location( $post_id ) {
		if ( function_exists( 'lsvr_events_get_event_location_meta' ) ) {

			$location_meta = lsvr_events_get_event_location_meta( $post_id );
			return ! empty( $location_meta ) ? true : false;

		}
	}
}

// Get event location name
if ( ! function_exists( 'lsvr_townpress_get_event_location_name' ) ) {
	function lsvr_townpress_get_event_location_name( $post_id ) {

		$event_location_term = wp_get_post_terms( $post_id, 'lsvr_event_location' );
		if ( ! empty( $event_location_term[0]->term_id ) ) {

			// Get location term ID
			$location_term_id = $event_location_term[0]->term_id;

			// Get term data
			$location_data = get_term( $location_term_id, 'lsvr_event_location' );
			$location_permalink = get_term_link( $location_term_id, 'lsvr_event_location' );

			if ( ! empty( $location_data->name ) ) {
				return $location_data->name;
			}

		}

	}
}

// Has event location map
if ( ! function_exists( 'lsvr_townpress_has_event_location_map' ) ) {
	function lsvr_townpress_has_event_location_map( $post_id ) {
		if ( function_exists( 'lsvr_events_get_event_location_meta' ) ) {

			$event_location_meta = lsvr_events_get_event_location_meta( $post_id );
			if ( ! empty( $event_location_meta['accurate_address'] ) ||
				( ! empty( $event_location_meta['latitude'] ) && ! empty( $event_location_meta['longitude'] ) ) ) {
				return true;
			} else {
				return false;
			}

		}
	}
}

// Get event location address
if ( ! function_exists( 'lsvr_townpress_get_event_location_address' ) ) {
	function lsvr_townpress_get_event_location_address( $post_id ) {
		if ( function_exists( 'lsvr_events_get_event_location_meta' ) ) {

			$location_meta = lsvr_events_get_event_location_meta( $post_id );
			if ( ! empty( $location_meta['address'] ) ) {
				return $location_meta['address'];
			}

		}
	}
}

// Has event location address
if ( ! function_exists( 'lsvr_townpress_has_event_location_address' ) ) {
	function lsvr_townpress_has_event_location_address( $post_id ) {

		$location_address = lsvr_townpress_get_event_location_address( $post_id );
		return ! empty( $location_address ) ? true : false;

	}
}

// Get event location accurate address
if ( ! function_exists( 'lsvr_townpress_get_event_location_accurate_address' ) ) {
	function lsvr_townpress_get_event_location_accurate_address( $post_id ) {
		if ( function_exists( 'lsvr_events_get_event_location_meta' ) ) {

			$location_meta = lsvr_events_get_event_location_meta( $post_id );
			if ( ! empty( $location_meta['accurate_address'] ) ) {
				return $location_meta['accurate_address'];
			}

		}
	}
}

// Has event location accurate address
if ( ! function_exists( 'lsvr_townpress_has_event_location_acurrate_address' ) ) {
	function lsvr_townpress_has_event_location_acurrate_address( $post_id ) {

		$location_address = lsvr_townpress_get_event_location_accurate_address( $post_id );
		return ! empty( $location_address ) ? $location_address : false;

	}
}

?>