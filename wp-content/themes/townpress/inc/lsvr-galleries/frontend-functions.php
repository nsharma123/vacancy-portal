<?php

// Gallery archive grid class
if ( ! function_exists( 'lsvr_townpress_the_gallery_post_archive_grid_class' ) ) {
	function lsvr_townpress_the_gallery_post_archive_grid_class() {

		$number_of_columns = ! empty( get_theme_mod( 'lsvr_gallery_archive_grid_columns', 2 ) ) ? (int) get_theme_mod( 'lsvr_gallery_archive_grid_columns', 2 ) : 2;
		$span = 12 / $number_of_columns;
		$md_cols = $span > 2 ? 2 : $span;
		$sm_cols = $span > 2 ? 2 : $span;
		$masonry = true === get_theme_mod( 'lsvr_gallery_archive_masonry_enable', false ) ? ' lsvr-grid--masonry' : '';

		echo 'lsvr-grid lsvr-grid--' . esc_attr( $number_of_columns ) . '-cols lsvr-grid--md-' . esc_attr( $md_cols ) . '-cols lsvr-grid--sm-' . esc_attr( $sm_cols ) . '-cols' . esc_attr( $masonry );

	}
}

// Gallery archive grid column class
if ( ! function_exists( 'lsvr_townpress_the_gallery_post_archive_grid_column_class' ) ) {
	function lsvr_townpress_the_gallery_post_archive_grid_column_class() {

		$number_of_columns = ! empty( get_theme_mod( 'lsvr_gallery_archive_grid_columns', 2 ) ) ? (int) get_theme_mod( 'lsvr_gallery_archive_grid_columns', 2 ) : 2;
		$span = 12 / $number_of_columns;

		// Get medium span class
		$span_md_class = 3 === $span || 4 === $span || 6 === $span ? ' lsvr-grid__col--md-span-6' : '';

		// Get small span class
		$span_sm_class = 3 === $span || 4 === $span || 6 === $span ? ' lsvr-grid__col--sm-span-6' : '';

		echo 'lsvr-grid__col lsvr-grid__col--span-' . esc_attr( $span . $span_md_class . $span_sm_class );

	}
}

// Gallery post background thumbnail
if ( ! function_exists( 'lsvr_townpress_the_gallery_post_background_thumbnail' ) ) {
	function lsvr_townpress_the_gallery_post_background_thumbnail( $post_id ) {
		if ( function_exists( 'lsvr_galleries_get_single_thumb' ) ) {

			$thumbnail = lsvr_galleries_get_single_thumb( $post_id );
			if ( ! empty( $thumbnail ) ) {

				if ( get_theme_mod( 'lsvr_gallery_archive_grid_columns', 4 ) > 2 && ! empty( $thumbnail['medium_url'] ) ) {
					$image_url = $thumbnail['medium_url'];
				} else {
					$image_url = $thumbnail['full_url'];
				}

				if ( ! empty( $image_url ) ) {
					echo ' style="background-image: url( \'' . esc_url( $image_url ) . '\' );"';
				}

			}

		}
	}
}

// Gallery single images
if ( ! function_exists( 'lsvr_townpress_the_gallery_images' ) ) {
	function lsvr_townpress_the_gallery_images( $post_id ) {

		$gallery_images = lsvr_townpress_get_gallery_images( $post_id );
		if ( ! empty( $gallery_images ) ) { ?>

			<!-- IMAGE LIST : begin -->
			<ul class="post__image-list lsvr-grid">

				<?php foreach ( $gallery_images as $image ) : ?>
					<li class="<?php echo esc_attr( lsvr_townpress_the_gallery_post_single_column_class( 'post__image-item' ) ); ?>">
						<a href="<?php echo esc_url( $image[ 'full_url' ] ); ?>"
							class="post__image-link lsvr-open-in-lightbox"
							title="<?php echo esc_attr( $image[ 'title' ] ); ?>">
							<img class="post__image"
								<?php if ( get_theme_mod( 'lsvr_gallery_single_grid_columns', 3 ) > 2 &&
								! empty( $image[ 'medium_url' ] ) ) : ?>
									src="<?php echo esc_url( $image[ 'medium_url' ] ); ?>"
								<?php else : ?>
									src="<?php echo esc_url( $image[ 'full_url' ] ); ?>"
								<?php endif; ?>
								alt="<?php echo esc_attr( $image[ 'alt' ] ); ?>">
						</a>
					</li>
				<?php endforeach; ?>

			</ul>
			<!-- IMAGE LIST : end -->

		<?php }

	}
}

// Gallery single images column class
if ( ! function_exists( 'lsvr_townpress_the_gallery_post_single_column_class' ) ) {
	function lsvr_townpress_the_gallery_post_single_column_class( $class = '' ) {

		$number_of_columns = ! empty( get_theme_mod( 'lsvr_gallery_single_grid_columns', 3 ) ) ? (int) get_theme_mod( 'lsvr_gallery_single_grid_columns', 3 ) : 3;
		$span = 12 / $number_of_columns;

		// Get medium span class
		$span_md_class = 3 === $span || 4 === $span || 6 === $span ? ' lsvr-grid__col--md lsvr-grid__col--md-span-6' : '';

		// Get small span class
		$span_sm_class = 3 === $span || 4 === $span || 6 === $span ? ' lsvr-grid__col--sm lsvr-grid__col--sm-span-6' : '';

		echo trim( esc_attr( $class ) . ' lsvr-grid__col lsvr-grid__col--span-' . esc_attr( $span . $span_md_class . $span_sm_class ) );

	}
}

?>