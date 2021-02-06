<?php

// Listing archive map
if ( ! function_exists( 'lsvr_townpress_the_listing_archive_map' ) ) {
	function lsvr_townpress_the_listing_archive_map() {

		if ( true === get_theme_mod( 'lsvr_listing_archive_map_enable', true ) ) { ?>

			<!-- LISTING ARCHIVE MAP : begin -->
			<div class="lsvr_listing-map">
				<div class="lsvr_listing-map__canvas lsvr_listing-map__canvas--loading"
					id="lsvr_listing-map__canvas"
					<?php if ( ! empty( lsvr_townpress_get_listing_archive_map_query_json() ) ) : ?>
						data-query="<?php echo esc_attr( lsvr_townpress_get_listing_archive_map_query_json() ); ?>"
					<?php endif; ?>
					data-maptype="<?php echo esc_attr( get_theme_mod( 'lsvr_listing_archive_map_type', 'roadmap' ) ); ?>"
					data-zoom="<?php echo esc_attr( get_theme_mod( 'lsvr_listing_archive_map_zoom', 16 ) ); ?>"
					data-mousewheel="false"></div>
				<div class="c-spinner lsvr_listing-map__spinner"></div>
			</div>
			<!-- LISTING ARCHIVE MAP : end -->

		<?php }

	}
}

// Listing archive grid class
if ( ! function_exists( 'lsvr_townpress_the_listing_archive_grid_class' ) ) {
	function lsvr_townpress_the_listing_archive_grid_class() {

		$number_of_columns = ! empty( get_theme_mod( 'lsvr_listing_archive_grid_columns', 2 ) ) ? (int) get_theme_mod( 'lsvr_listing_archive_grid_columns', 2 ) : 2;
		$span = 12 / $number_of_columns;
		$md_cols = $span > 2 ? 2 : $span;
		$sm_cols = $span > 2 ? 2 : $span;
		$masonry = true === get_theme_mod( 'lsvr_listing_archive_masonry_enable', false ) ? ' lsvr-grid--masonry' : '';

		echo 'lsvr-grid lsvr-grid--' . esc_attr( $number_of_columns ) . '-cols lsvr-grid--md-' . esc_attr( $md_cols ) . '-cols lsvr-grid--sm-' . esc_attr( $sm_cols ) . '-cols' . esc_attr( $masonry );

	}
}

// Listing archive grid column class
if ( ! function_exists( 'lsvr_townpress_the_listing_archive_grid_column_class' ) ) {
	function lsvr_townpress_the_listing_archive_grid_column_class() {

		$number_of_columns = ! empty( get_theme_mod( 'lsvr_listing_archive_grid_columns', 2 ) ) ? (int) get_theme_mod( 'lsvr_listing_archive_grid_columns', 2 ) : 2;
		$span = 12 / $number_of_columns;

		// Get medium span class
		$span_md_class = 3 === $span || 4 === $span || 6 === $span ? ' lsvr-grid__col--md-span-6' : '';

		// Get small span class
		$span_sm_class = 3 === $span || 4 === $span || 6 === $span ? ' lsvr-grid__col--sm-span-6' : '';

		echo 'lsvr-grid__col lsvr-grid__col--span-' . esc_attr( $span . $span_md_class . $span_sm_class );

	}
}

// Listing post thumbnail
if ( ! function_exists( 'lsvr_townpress_the_listing_archive_thumbnail' ) ) {
	function lsvr_townpress_the_listing_archive_thumbnail( $post_id ) {

		if ( has_post_thumbnail( $post_id ) ) {

			$thumb_size = (int) get_theme_mod( 'lsvr_listing_archive_grid_columns', 3 ) < 4 ? 'large' : 'medium';

			// Cropped thumbnail
			if ( true === get_theme_mod( 'lsvr_listing_archive_cropped_thumb_enable', true ) ) {
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

// Listing post background thumbnail
if ( ! function_exists( 'lsvr_townpress_the_listing_post_archive_background_thumbnail' ) ) {
	function lsvr_townpress_the_listing_post_archive_background_thumbnail( $post_id ) {

		if ( has_post_thumbnail( $post_id ) ) {
			$thumb_size = (int) get_theme_mod( 'lsvr_listing_archive_grid_columns', 3 ) < 4 ? 'large' : 'medium';
			echo ' style="background-image: url( \'' . esc_url( get_the_post_thumbnail_url( $post_id, $thumb_size ) ) . '\' );"';
		}

	}
}

// Listing address
if ( ! function_exists( 'lsvr_townpress_the_listing_address' ) ) {
	function lsvr_townpress_the_listing_address( $post_id, $nl2br = true ) {

		$location_address = lsvr_townpress_get_listing_address( $post_id );
		if ( ! empty( $location_address ) ) {
			echo true === $nl2br ? nl2br( esc_html( $location_address ) ) : esc_html( $location_address );
		}

	}
}

// Listing single gallery
if ( ! function_exists( 'lsvr_townpress_the_listing_gallery' ) ) {
	function lsvr_townpress_the_listing_gallery( $post_id ) {

		$gallery_images = get_post_meta( $post_id, 'lsvr_listing_gallery', true );
		$gallery_images = ! empty( $gallery_images ) ? explode( ',', $gallery_images ) : false;  ?>

		<?php // If listing has gallery, show it
		if ( ! empty( $gallery_images ) ) : ?>

			<!-- LISTING GALLERY : begin -->
			<ul class="post__gallery-list">

				<?php foreach ( $gallery_images as $image_id ) : ?>

					<li class="post__gallery-item">
						<a href="<?php echo esc_url( lsvr_townpress_get_image_url( $image_id, 'full' ) ); ?>" class="post__gallery-item-link lsvr-open-in-lightbox"
							title="<?php echo esc_attr( lsvr_townpress_get_image_title( $image_id ) ); ?>">
							<img src="<?php echo esc_url( lsvr_townpress_get_image_url( $image_id, 'thumbnail' ) ); ?>"
								class="post__gallery-item-image" alt="<?php echo esc_attr( lsvr_townpress_get_image_alt( $image_id ) ); ?>">
						</a>
					</li>

				<?php endforeach; ?>

			</ul>
			<!-- LISTING GALLERY : end -->

		<?php endif; ?>

	<?php }
}

// Listing contact info
if ( ! function_exists( 'lsvr_townpress_the_listing_contact_info' ) ) {
	function lsvr_townpress_the_listing_contact_info( $post_id ) {

		$contact_info = lsvr_townpress_get_listing_contact_info( $post_id );
		if ( ! empty( $contact_info ) ) : ?>

			<ul class="post__contact-list">

				<?php foreach ( $contact_info as $profile => $contact ) : ?>

					<li class="post__contact-item post__contact-item--<?php echo esc_attr( $profile ); ?>">
						<?php if ( 'email' === $profile ) : ?>
							<a href="mailto:<?php echo esc_attr( $contact ); ?>" class="post__contact-item-link"><?php echo esc_html( $contact ); ?></a>
						<?php elseif ( 'website' === $profile ) : ?>
							<a href="<?php echo esc_url( $contact ); ?>" class="post__contact-item-link" target="_blank"><?php echo esc_html( $contact ); ?></a>
						<?php elseif ( 'phone' === $profile ) : ?>
							<a href="tel:<?php echo esc_html( $contact ); ?>" class="post__contact-item-link" target="_blank"><?php echo esc_html( $contact ); ?></a>
						<?php else : ?>
							<?php echo wp_kses( nl2br( $contact ), array(
									'a' => array(
										'href' => array(),
									),
									'br' => array(),
								)
							); ?>
						<?php endif; ?>
					</li>

				<?php endforeach; ?>

			</ul>

		<?php endif;

	}
}

// Listing social links
if ( ! function_exists( 'lsvr_townpress_the_listing_social_links' ) ) {
	function lsvr_townpress_the_listing_social_links( $post_id ) {

		$social_links = lsvr_townpress_get_listing_social_links( $post_id );
		if ( ! empty( $social_links ) ) : ?>

			<ul class="post__social-links">

				<?php foreach ( $social_links as $profile => $link ) : ?>

					<li class="post__social-links-item">
						<a href="<?php echo esc_url( $link ); ?>"
							class="post__social-links-link post__social-links-link--<?php echo esc_attr( $profile ); ?>"
							target="_blank"><span class="screen-reader-text"><?php echo esc_html( $link ); ?></span></a>
					</li>

				<?php endforeach; ?>

			</ul>

		<?php endif;

	}
}

// Listing single map
if ( ! function_exists( 'lsvr_townpress_the_listing_map' ) ) {
	function lsvr_townpress_the_listing_map( $post_id ) {
		if ( function_exists( 'lsvr_directory_get_listing_meta' ) ) {

			$listing_meta = lsvr_directory_get_listing_meta( $post_id );

			if ( true === get_theme_mod( 'lsvr_listing_single_map_enable', true ) &&
				! empty( $listing_meta['locating_method'] ) ) { ?>

				<!-- LISTING MAP : begin -->
				<div class="c-gmap post__map">
					<div class="c-gmap__canvas c-gmap__canvas--loading post__map-canvas"
					id="lsvr_listing-post-single-map__canvas"
					<?php if ( 'latlong' === $listing_meta['locating_method'] &&
						! empty( $listing_meta['latitude'] ) && ! empty( $listing_meta['longitude'] ) ) : ?>
						data-latlong="<?php echo esc_attr( $listing_meta['latitude'] . ',' . $listing_meta['longitude'] ); ?>"
						data-locating-method="latlong"
					<?php elseif ( 'address' === $listing_meta['locating_method'] &&
						! empty( $listing_meta['latitude_geocoded'] ) && ! empty( $listing_meta['longitude_geocoded'] ) ) : ?>
						data-latlong="<?php echo esc_attr( $listing_meta['latitude_geocoded'] . ',' . $listing_meta['longitude_geocoded'] ); ?>"
						data-locating-method="address"
					<?php elseif ( ! empty( $listing_meta['accurate_address'] ) ) : ?>
						data-address="<?php echo esc_attr( $listing_meta['accurate_address'] ); ?>"
					<?php endif; ?>
					data-maptype="<?php echo esc_attr( get_theme_mod( 'lsvr_listing_single_map_type', 'roadmap' ) ); ?>"
					data-zoom="<?php echo esc_attr( get_theme_mod( 'lsvr_listing_single_map_zoom', 17 ) ); ?>"
					data-mousewheel="false"></div>
				</div>
				<!-- LISTING MAP : end -->

			<?php }

		}
	}
}

// Opening hours
if ( ! function_exists( 'lsvr_townpress_the_listing_opening_hours' ) ) {
	function lsvr_townpress_the_listing_opening_hours( $post_id ) {

		$opening_hours_type = get_post_meta( $post_id, 'lsvr_listing_opening_hours', true );
		$opening_hours_custom = get_post_meta( $post_id, 'lsvr_listing_opening_hours_custom', true );
		$opening_hours_select = get_post_meta( $post_id, 'lsvr_listing_opening_hours_select', true );
		$opening_hours_note = get_post_meta( $post_id, 'lsvr_listing_opening_hours_note', true );

		if ( 'custom' == $opening_hours_type && ! empty( $opening_hours_custom ) ) {

			echo '<p class="post__hours-custom">' . nl2br( wp_kses( $opening_hours_custom, array(
				'strong' => array(),
			)) ) . '</p>';

		}
		else if ( 'select' == $opening_hours_type && ! empty( $opening_hours_select ) ) {

			$opening_hours = @json_decode( $opening_hours_select );

			if ( is_object( $opening_hours ) ) : ?>

				<ul class="post__hours-list">

					<?php foreach ( $opening_hours as $day => $hours ) : ?>

						<li class="post__hours-item post__hours-item--<?php echo strtolower( date( 'D', strtotime( $day ) ) ); ?>">
							<div class="post__hours-item-day">
								<?php echo date_i18n( 'l', strtotime( $day ) ); ?>
							</div>
							<div class="post__hours-item-value">

								<?php if ( 'closed' === $hours ) {

									esc_html_e( 'Closed', 'townpress' );

								} else {

									$time_from = substr( $hours, 0, strpos( $hours, '-' ) );
									$time_to = substr( $hours, strpos( $hours, '-' ) + 1, strlen( $hours ) );
									echo '<span class="opening-hours__day-from">' . esc_html( date_i18n( get_option( 'time_format' ), strtotime( $time_from ) ) ) . '</span>';
									echo ' - <span class="opening-hours__day-to">' . esc_html( date_i18n( get_option( 'time_format' ), strtotime( $time_to ) ) ) . '</span>';

								} ?>

							</div>
						</li>

					<?php endforeach; ?>

				</ul>

				<?php // Note
				if ( ! empty( $opening_hours_note ) ) : ?>
					<p class="post__hours-note">
						<?php echo nl2br( wp_kses( $opening_hours_note, array(
							'strong' => array(),
						)) ); ?>
					</p>
				<?php endif; ?>

			<?php endif;

		}

	}
}

?>