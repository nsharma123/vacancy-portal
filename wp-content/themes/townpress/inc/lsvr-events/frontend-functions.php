<?php

// Event archive categories
if ( ! function_exists( 'lsvr_townpress_the_event_archive_categories' ) ) {
	function lsvr_townpress_the_event_archive_categories() {

		$url_args = array();

		// Add date from and date to params to URL
		if ( isset( $_GET['date_from'] ) ) {
			$url_args['date_from'] = preg_replace( '/[^0-9-]/', '', $_GET['date_from'] );
		}
		if ( isset( $_GET['date_to'] ) ) {
			$url_args['date_to'] = preg_replace( '/[^0-9-]/', '', $_GET['date_to'] );
		}

		$terms = get_terms( 'lsvr_event_cat' );
		if ( ! empty( $terms ) ) { ?>

			<!-- POST ARCHIVE CATEGORIES : begin -->
			<div class="post-archive-categories">
				<div class="c-content-box">
					<h6 class="screen-reader-text"><?php esc_html_e( 'Categories:', 'townpress' ); ?></h6>
					<ul class="post-archive-categories__list">

						<li class="post-archive-categories__item">
							<?php if ( is_tax( 'lsvr_event_cat' ) ) : ?>
								<a href="<?php echo esc_url( add_query_arg( $url_args, get_post_type_archive_link( 'lsvr_event' ) ) ); ?>" class="post-archive-categories__item-link"><?php esc_html_e( 'All', 'townpress' ); ?></a>
							<?php else : ?>
								<?php esc_html_e( 'All', 'townpress' ); ?>
							<?php endif; ?>
						</li>

						<?php foreach ( $terms as $term ) : ?>
							<li class="post-archive-categories__item">
								<?php if ( get_queried_object_id() === $term->term_id ) : ?>
									<?php echo esc_html( $term->name ); ?>
								<?php else : ?>
									<a href="<?php echo esc_url( add_query_arg( $url_args, get_term_link( $term->term_id, 'lsvr_event_cat' ) ) ); ?>" class="post-archive-categories__item-link"><?php echo esc_html( $term->name ); ?></a>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>

					</ul>
				</div>
			</div>
			<!-- POST ARCHIVE CATEGORIES : end -->

		<?php }

	}
}

// Event archive grid begin
if ( ! function_exists( 'lsvr_townpress_the_event_post_archive_grid_begin' ) ) {
	function lsvr_townpress_the_event_post_archive_grid_begin( $event_occurrence, $i ) {

		global $lsvr_townpress_event_archive_group_date;
		$lsvr_townpress_event_archive_group_date = empty( $lsvr_townpress_event_archive_group_date ) ? false : $lsvr_townpress_event_archive_group_date;

		// No date grouping
		if ( false === get_theme_mod( 'lsvr_event_archive_group_enable', true ) && $i === 1 ) {
			echo '<div class="' . lsvr_townpress_get_event_post_archive_grid_class() . '">';
		}

		// Date grouping
		elseif ( true === get_theme_mod( 'lsvr_event_archive_group_enable', true ) &&
			$lsvr_townpress_event_archive_group_date !== date_i18n( 'Y-m', strtotime( $event_occurrence['start'] ) ) ) {

			$lsvr_townpress_event_archive_group_date = date_i18n( 'Y-m', strtotime( $event_occurrence['start'] ) );
			if ( $i > 1 ) {
				echo '</div>';
			}

			echo '<h2 class="post-archive__date">' . esc_html( date_i18n( 'F Y', strtotime( $event_occurrence['start'] ) ) ) . '</h2><div class="' . lsvr_townpress_get_event_post_archive_grid_class() . '">';

		}

	}
}

// Event archive grid end
if ( ! function_exists( 'lsvr_townpress_the_event_post_archive_grid_end' ) ) {
	function lsvr_townpress_the_event_post_archive_grid_end( $i, $count ) {

		if ( $i === $count ) {
			echo '</div>';
		}

	}
}

// Event archive grid column class
if ( ! function_exists( 'lsvr_townpress_the_event_post_archive_grid_column_class' ) ) {
	function lsvr_townpress_the_event_post_archive_grid_column_class() {

		$number_of_columns = ! empty( get_theme_mod( 'lsvr_event_archive_grid_columns', 2 ) ) ? (int) get_theme_mod( 'lsvr_event_archive_grid_columns', 2 ) : 2;
		$span = 12 / $number_of_columns;

		// Get medium span class
		$span_md_class = 3 === $span || 4 === $span || 6 === $span ? ' lsvr-grid__col--md-span-6' : '';

		// Get small span class
		$span_sm_class = 3 === $span || 4 === $span || 6 === $span ? ' lsvr-grid__col--sm-span-6' : '';

		echo 'lsvr-grid__col lsvr-grid__col--span-' . esc_attr( $span . $span_md_class . $span_sm_class );

	}
}

// Event post class
if ( ! function_exists( 'lsvr_townpress_the_event_post_class' ) ) {
	function lsvr_townpress_the_event_post_class( $post_id, $class = '' ) {

		$classes = [ 'post', 'lsvr_event', 'post-' . $post_id ];

		if ( has_post_thumbnail( $post_id ) ) {
			array_push( $classes, 'has-post-thumbnail' );
		}

		if ( ! empty( $class ) ) {
			array_push( $classes, $class );
		}

		echo ' class="' . esc_attr( implode( ' ', $classes ) ) . '"';

	}
}

// Event post thumbnail
if ( ! function_exists( 'lsvr_townpress_the_event_post_archive_thumbnail' ) ) {
	function lsvr_townpress_the_event_post_archive_thumbnail( $post_id ) {

		if ( has_post_thumbnail( $post_id ) ) {

			$thumb_size = (int) get_theme_mod( 'lsvr_event_archive_grid_columns', 2 ) < 4 ? 'large' : 'medium';

			// Cropped thumbnail
			if ( true === get_theme_mod( 'lsvr_event_archive_cropped_thumb_enable', true ) ) {
				echo '<p class="post__thumbnail"><a href="' . esc_url( get_permalink( $post_id ) ) . '" class="post__thumbnail-link post__thumbnail-link--cropped"';
				echo ' style="background-image: url( \'' . esc_url( get_the_post_thumbnail_url( $post_id, $thumb_size ) ) . '\' );">';
				echo '</a></p>';
			}

			// Regular thumbnail
			else {
				echo '<p class="post__thumbnail"><a href="' . esc_url( get_permalink( $post_id ) ) . '" class="post__thumbnail-link">';
				echo get_the_post_thumbnail( $post_id, $thumb_size );
				echo '</a></p>';
			}

		}

	}
}

// Event post background thumbnail
if ( ! function_exists( 'lsvr_townpress_the_event_post_archive_background_thumbnail' ) ) {
	function lsvr_townpress_the_event_post_archive_background_thumbnail( $post_id ) {

		if ( has_post_thumbnail( $post_id ) ) {
			$thumb_size = (int) get_theme_mod( 'lsvr_event_archive_grid_columns', 2 ) < 4 ? 'large' : 'medium';
			echo ' style="background-image: url( \'' . esc_url( get_the_post_thumbnail_url( $post_id, $thumb_size ) ) . '\' );"';
		}

	}
}

// Event post archive timeline thumbnail
if ( ! function_exists( 'lsvr_townpress_the_event_post_archive_timeline_thumbnail' ) ) {
	function lsvr_townpress_the_event_post_archive_timeline_thumbnail( $post_id ) {

		if ( has_post_thumbnail( $post_id ) ) {
			echo '<p class="post__thumbnail"><a href="' . esc_url( get_permalink( $post_id ) ) . '" class="post__thumbnail-link"';
			echo ' style="background-image: url( \'' . esc_url( get_the_post_thumbnail_url( $post_id, 'thumbnail' ) ) . '\' );">';
			echo '</a></p>';
		}

	}
}

// Event upcoming occurrences
if ( ! function_exists( 'lsvr_townpress_the_event_upcoming_occurrences' ) ) {
	function lsvr_townpress_the_event_upcoming_occurrences( $post_id ) {

		if ( lsvr_townpress_is_recurring_event( $post_id ) ) {
			$next_occurrences = lsvr_townpress_get_next_event_occurrences( $post_id, apply_filters( 'lsvr_townpress_event_detail_upcoming_occurrences_count', 30 ) );
			if ( ! empty( $next_occurrences ) ) { ?>

				<div class="post__dates-list-wrapper post__dates-list-wrapper--<?php echo esc_attr( count( $next_occurrences ) ); ?>-items">
					<ul class="post__dates-list">
						<?php foreach ( $next_occurrences as $occurrence ) : if ( ! empty( $occurrence['start'] ) ) : ?>
							<li class="post__dates-item">
								<?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $occurrence['start'] ) ) ); ?>
							</li>
						<?php endif; endforeach; ?>
					</ul>
				</div>

			<?php }

		}

	}
}

// Event start date
if ( ! function_exists( 'lsvr_townpress_the_event_start_date' ) ) {
	function lsvr_townpress_the_event_start_date( $post_id ) {

		// Recurring event
		if ( lsvr_townpress_is_recurring_event( $post_id ) && lsvr_townpress_has_next_event_occurrences( $post_id ) ) {
			$next_occurrence = lsvr_townpress_get_next_event_occurrences( $post_id, 1 );
			if ( ! empty( $next_occurrence[0]['start'] ) ) {
				$start_date =$next_occurrence[0]['start'];
			}
		}

		// Ended recurring event
		else if ( lsvr_townpress_is_recurring_event( $post_id ) ) {
			$last_occurrence = lsvr_townpress_get_recent_event_occurrences( $post_id, 1 );
			if ( ! empty( $last_occurrence[0]['start'] ) ) {
				$start_date = $last_occurrence[0]['start'];
			}
		}

		// Standard event
		else {
			$start_date = get_date_from_gmt( get_post_meta( $post_id, 'lsvr_event_start_date_utc', true ) );
		}

		echo ! empty( $start_date ) ? esc_html( date_i18n( get_option( 'date_format' ), strtotime( $start_date ) ) ) : '';


	}
}

// Event end date
if ( ! function_exists( 'lsvr_townpress_the_event_end_date' ) ) {
	function lsvr_townpress_the_event_end_date( $post_id ) {

		// Recurring event
		if ( lsvr_townpress_is_recurring_event( $post_id ) && lsvr_townpress_has_next_event_occurrences( $post_id ) ) {
			$next_occurrence = lsvr_townpress_get_next_event_occurrences( $post_id, 1 );
			if ( ! empty( $next_occurrence[0]['end'] ) ) {
				$end_date = $next_occurrence[0]['end'];
			}
		}

		// Ended recurring event
		else if ( lsvr_townpress_is_recurring_event( $post_id ) ) {
			$last_occurrence = lsvr_townpress_get_recent_event_occurrences( $post_id, 1 );
			if ( ! empty( $last_occurrence[0]['end'] ) ) {
				$end_date = $last_occurrence[0]['end'];
			}
		}

		// Standard event
		else {
			$end_date = get_date_from_gmt( get_post_meta( $post_id, 'lsvr_event_end_date_utc', true ) );
		}

		echo ! empty( $end_date ) ? esc_html( date_i18n( get_option( 'date_format' ), strtotime( $end_date ) ) ) : '';

	}
}

// Event start time
if ( ! function_exists( 'lsvr_townpress_the_event_start_time' ) ) {
	function lsvr_townpress_the_event_start_time( $post_id , $template = '%s' ) {
		if ( function_exists( 'lsvr_events_get_event_local_start_time' ) ) {

			echo sprintf( $template, lsvr_events_get_event_local_start_time( $post_id ) );

		}
	}
}

// Event end time
if ( ! function_exists( 'lsvr_townpress_the_event_end_time' ) ) {
	function lsvr_townpress_the_event_end_time( $post_id, $template = '%s' ) {
		if ( function_exists( 'lsvr_events_get_event_local_end_time' ) ) {

			echo sprintf( $template, lsvr_events_get_event_local_end_time( $post_id ) );

		}
	}
}

// Event time
if ( ! function_exists( 'lsvr_townpress_the_event_time' ) ) {
	function lsvr_townpress_the_event_time( $post_id, $template = '%s - %s' ) {
		if ( function_exists( 'lsvr_events_get_event_local_start_time' ) &&
			function_exists( 'lsvr_events_get_event_local_end_time' ) ) {

			$allday_event = 'true' === get_post_meta( $post_id, 'lsvr_event_allday', true ) ? true : false;
			$endtime_enable = 'true' === get_post_meta( $post_id, 'lsvr_event_end_time_enable', true ) ? true : false;

			// All-day
			if ( true === $allday_event ) {
				esc_html_e( 'All-day event', 'townpress' );
			}

			// Display both start and end
			else if ( true === $endtime_enable ) {

				echo sprintf( $template,
					lsvr_events_get_event_local_start_time( $post_id ),
	                lsvr_events_get_event_local_end_time( $post_id )
				);

			}

			// Do not display end time
			else {
				echo lsvr_events_get_event_local_start_time( $post_id );
			}

		}
	}
}

// Event archive time
if ( ! function_exists( 'lsvr_townpress_the_event_archive_time' ) ) {
	function lsvr_townpress_the_event_archive_time( $occurrence, $template = '%s - %s' ) {
		if ( function_exists( 'lsvr_events_get_event_local_start_time' ) &&
			function_exists( 'lsvr_events_get_event_local_end_time' ) ) {

			// All-day
			if ( ! empty( $occurrence['allday'] ) && true === $occurrence['allday'] ) {
				esc_html_e( 'All-day event', 'townpress' );
			}

			// Display both start and end
			else if ( ! empty( $occurrence['postid'] ) && lsvr_townpress_has_event_end_time( $occurrence['postid'] ) ) {
				echo sprintf( $template,
					lsvr_events_get_event_local_start_time( $occurrence['postid'] ),
                    lsvr_events_get_event_local_end_time( $occurrence['postid'] )
				);
			}

			// Do not display end time
			else {
				echo esc_html( lsvr_events_get_event_local_start_time( $occurrence['postid'] ) );
			}

		}
	}
}

// Event location linked
if ( ! function_exists( 'lsvr_townpress_the_event_location_linked' ) ) {
	function lsvr_townpress_the_event_location_linked( $post_id, $template = '%s' ) {

		$event_location_term = wp_get_post_terms( $post_id, 'lsvr_event_location' );
		if ( ! empty( $event_location_term[0]->term_id ) ) {

			// Get location term ID
			$location_term_id = $event_location_term[0]->term_id;

			// Get term data
			$location_data = get_term( $location_term_id, 'lsvr_event_location' );
			$location_permalink = get_term_link( $location_term_id, 'lsvr_event_location' );

			if ( ! empty( $location_data->name ) ) {
				echo sprintf( $template, '<a href="' . esc_attr( $location_permalink ) . '" class="post__location-link">' . esc_html( $location_data->name ) . '</a>' );
			}

		}

	}
}

// Event location address
if ( ! function_exists( 'lsvr_townpress_the_event_location_address' ) ) {
	function lsvr_townpress_the_event_location_address( $post_id, $nl2br = true ) {

		$location_address = lsvr_townpress_get_event_location_address( $post_id );
		if ( ! empty( $location_address ) ) {
			echo true === $nl2br ? nl2br( esc_html( $location_address ) ) : esc_html( $location_address );
		}

	}
}

// Event location map
if ( ! function_exists( 'lsvr_townpress_the_event_location_map' ) ) {
	function lsvr_townpress_the_event_location_map( $post_id ) {
		if ( function_exists( 'lsvr_events_get_event_location_meta' ) ) {

			$event_location_meta = lsvr_events_get_event_location_meta( $post_id );

			if ( true === get_theme_mod( 'lsvr_event_single_map_enable', true ) &&
				! empty( $event_location_meta['accurate_address'] ) ||
				( ! empty( $event_location_meta['latitude'] ) && ! empty( $event_location_meta['longitude'] ) ) ) { ?>

				<!-- GOOGLE MAP : begin -->
				<div class="c-gmap post__map">
					<div class="c-gmap__canvas c-gmap__canvas--loading post__map-canvas"
					id="lsvr_event-post-single__map-canvas"
					<?php if ( ! empty( $event_location_meta['latitude'] ) && ! empty( $event_location_meta['longitude'] ) ) : ?>
						data-latlong="<?php echo esc_attr( $event_location_meta['latitude'] . ',' . $event_location_meta['longitude'] ); ?>"
					<?php elseif ( ! empty( $event_location_meta['accurate_address'] ) ) : ?>
						data-address="<?php echo esc_attr( $event_location_meta['accurate_address'] ); ?>"
					<?php endif; ?>
					data-maptype="<?php echo esc_attr( get_theme_mod( 'lsvr_event_single_map_type', 'roadmap' ) ); ?>"
					data-zoom="<?php echo esc_attr( get_theme_mod( 'lsvr_event_single_map_zoom', 17 ) ); ?>"
					data-mousewheel="false"></div>
				</div>
				<!-- GOOGLE MAP : end -->

			<?php }

		}
	}
}

// Event pagination
if ( ! function_exists( 'lsvr_townpress_the_event_archive_pagination' ) ) {
	function lsvr_townpress_the_event_archive_pagination() {
		if ( function_exists( 'lsvr_events_get_event_archive_pagination' ) ) {

			$args = array();

			// Pass "date from" attribute
			if ( ! empty( $_GET['date_from'] ) ) {
				$args['date_from'] = $_GET['date_from'];
			}

			// Pass "date to" attribute
			if ( ! empty( $_GET['date_to'] ) ) {
				$args['date_to'] = $_GET['date_to'];
			}

			// Pass "keyword" attribute
			if ( ! empty( $_GET['keyword'] ) ) {
				$args['keyword'] = $_GET['keyword'];
			}

			// If "date from" and "date to" are not defined, show upcoming events
			if ( empty( $_GET['date_from'] ) && empty( $_GET['date_to'] ) ) {
				$args['period'] = 'future';
			}

			// Get pagination data
			$pagination = lsvr_events_get_event_archive_pagination(
				$args,
				get_theme_mod( 'lsvr_event_archive_posts_per_page', 12 ), // Number of posts per page
				2 // Range of displayed page numbers relative to current page number
			);

			if ( ! empty( $pagination ) ) { ?>

				<!-- PAGINATION : begin -->
				<nav class="post-pagination">
					<h6 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'townpress' ); ?></h6>
					<ul class="post-pagination__list">

						<?php // Prev link
						if ( ! empty( $pagination['prev'] ) ) : ?>
							<li class="post-pagination__item post-pagination__prev">
								<a href="<?php echo esc_url( $pagination['prev'] ); ?>"
									class="post-pagination__item-link">
									<?php esc_html_e( 'Previous', 'townpress' ); ?>
								</a>
							</li>
						<?php endif; ?>

						<?php // First page
						if ( ! empty( $pagination['page_first'] ) ) : ?>
							<li class="post-pagination__item post-pagination__number post-pagination__number--first<?php if ( 1 === $pagination['current_page'] ) { echo ' post-pagination__number--active'; } ?>">
								<a href="<?php echo esc_url( $pagination['page_first'] ); ?>"
									class="post-pagination__number-link">1</a>
							</li>
						<?php endif; ?>

						<?php // Page numbers
						if ( ! empty( $pagination['page_numbers'] ) ) : ?>

							<?php // Dots before
							if ( (int) key( $pagination['page_numbers'] ) > 2 ) : ?>
								<li class="post-pagination__item post-pagination__dots">&hellip;</li>
							<?php endif; ?>

							<?php // Page numbers
							foreach ( $pagination['page_numbers'] as $number => $permalink ) : ?>
								<li class="post-pagination__item post-pagination__number<?php if ( (int) $number === $pagination['current_page'] ) { echo ' post-pagination__number--active'; } ?>">
									<a href="<?php echo esc_url( $permalink ); ?>"
										class="post-pagination__number-link">
										<?php echo esc_html( $number ); ?>
									</a>
								</li>
							<?php endforeach; ?>

							<?php // Dots after
							end( $pagination['page_numbers'] );
							if ( (int) key( $pagination['page_numbers'] ) < (int) $pagination['pages_count'] - 1 ) : ?>
								<li class="post-pagination__item post-pagination__dots">&hellip;</li>
							<?php endif; ?>

						<?php endif; ?>

						<?php // Last page
						if ( ! empty( $pagination['page_last'] ) && ! empty( $pagination['pages_count'] ) ) : ?>
							<li class="post-pagination__item post-pagination__number post-pagination__number--last<?php if ( (int) $pagination['pages_count'] === (int) $pagination['current_page'] ) { echo ' post-pagination__number--active'; } ?>">
								<a href="<?php echo esc_url( $pagination['page_last'] ); ?>"
									class="post-pagination__number-link">
									<?php echo (int) $pagination['pages_count']; ?>
								</a>
							</li>
						<?php endif; ?>

						<?php // Next link
						if ( ! empty( $pagination['next'] ) ) : ?>
							<li class="post-pagination__item post-pagination__next">
								<a href="<?php echo esc_url( $pagination['next'] ); ?>"
									class="post-pagination__item-link">
									<?php esc_html_e( 'Next', 'townpress' ); ?>
								</a>
							</li>
						<?php endif; ?>

					</ul>
				</nav>
				<!-- PAGINATION : end -->

			<?php }

		}
	}
}

?>