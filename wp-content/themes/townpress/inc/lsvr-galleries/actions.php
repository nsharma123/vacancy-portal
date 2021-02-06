<?php

// Load gallery JS files
add_action( 'lsvr_townpress_load_assets', 'lsvr_townpress_gallery_load_js', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_gallery_load_js' ) ) {
	function lsvr_townpress_gallery_load_js() {

		// Masonry
		if ( is_singular( 'lsvr_gallery' ) ) {
			wp_enqueue_script( 'masonry' );
		}

	}
}

// Page title
add_filter( 'document_title_parts', 'lsvr_townpress_gallery_title', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_gallery_title' ) ) {
	function lsvr_townpress_gallery_title( $title ) {

		if ( is_post_type_archive( 'lsvr_gallery' ) ) {
			$title['title'] = sanitize_text_field( lsvr_townpress_get_gallery_archive_title() );
		}
		return $title;

	}
}

// Breadcrumbs
add_filter( 'lsvr_townpress_add_to_breadcrumbs', 'lsvr_townpress_gallery_breadcrumbs', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_gallery_breadcrumbs' ) ) {
	function lsvr_townpress_gallery_breadcrumbs( $breadcrumbs ) {

		if ( lsvr_townpress_is_gallery() && ! is_post_type_archive( 'lsvr_gallery' ) ) {
			$breadcrumbs = array(
				array(
					'url' => get_post_type_archive_link( 'lsvr_gallery' ),
					'label' => lsvr_townpress_get_gallery_archive_title(),
				),
			);
		}
		return $breadcrumbs;

	}
}

// Archive pre_get_posts actions
add_action( 'pre_get_posts', 'lsvr_townpress_gallery_archive_pre_get_posts' );
if ( ! function_exists( 'lsvr_townpress_gallery_archive_pre_get_posts' ) ) {
	function lsvr_townpress_gallery_archive_pre_get_posts( $query ) {
		if ( ! is_admin() && $query->is_main_query() && ( $query->is_post_type_archive( 'lsvr_gallery' ) ||
			$query->is_tax( 'lsvr_gallery_cat' ) || $query->is_tax( 'lsvr_gallery_tag' ) ) ) {

			// Posts per page
			if ( 0 === get_theme_mod( 'lsvr_gallery_archive_posts_per_page', 12 ) ) {
				$query->set( 'posts_per_page', 1000 );
			} else {
				$query->set( 'posts_per_page', esc_attr( get_theme_mod( 'lsvr_gallery_archive_posts_per_page', 12 ) ) );
			}

		}
	}
}

// Enable single post single navigation
add_filter( 'lsvr_townpress_post_single_navigation_enable', 'lsvr_townpress_gallery_single_post_navigation_enable' );
if ( ! function_exists( 'lsvr_townpress_gallery_single_post_navigation_enable' ) ) {
	function lsvr_townpress_gallery_single_post_navigation_enable( $enabled ) {

		if ( lsvr_townpress_is_gallery() && true === get_theme_mod( 'lsvr_gallery_single_navigation_enable', true ) ) {
			$enabled = true;
		}

		return $enabled;

	}
}

// Left sidebar ID
add_filter( 'lsvr_townpress_sidebar_left_id', 'lsvr_townpress_gallery_sidebar_left_id', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_gallery_sidebar_left_id' ) ) {
	function lsvr_townpress_gallery_sidebar_left_id( $sidebar_id ) {

		// Single
		if ( is_singular( 'lsvr_gallery' ) ) {
			$sidebar_id = get_theme_mod( 'lsvr_gallery_single_sidebar_left_id', 'lsvr-townpress-default-sidebar-left' );
		}

		// Archive
		else if ( lsvr_townpress_is_gallery() ) {
			$sidebar_id = get_theme_mod( 'lsvr_gallery_archive_sidebar_left_id', 'lsvr-townpress-default-sidebar-left' );
		}

		return $sidebar_id;

	}
}

// Right sidebar ID
add_filter( 'lsvr_townpress_sidebar_right_id', 'lsvr_townpress_gallery_sidebar_right_id', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_gallery_sidebar_right_id' ) ) {
	function lsvr_townpress_gallery_sidebar_right_id( $sidebar_id ) {

		// Single
		if ( is_singular( 'lsvr_gallery' ) ) {
			$sidebar_id = get_theme_mod( 'lsvr_gallery_single_sidebar_right_id', 'lsvr-townpress-default-sidebar-right' );
		}

		// Archive
		else if ( lsvr_townpress_is_gallery() ) {
			$sidebar_id = get_theme_mod( 'lsvr_gallery_archive_sidebar_right_id', 'lsvr-townpress-default-sidebar-right' );
		}

		return $sidebar_id;

	}
}

// Add post meta data
add_action( 'lsvr_townpress_gallery_single_bottom', 'lsvr_townpress_add_gallery_single_meta', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_add_gallery_single_meta' ) ) {
	function lsvr_townpress_add_gallery_single_meta() { ?>

		<script type="application/ld+json">
		{
			"@context" : "http://schema.org",
			"@type" : "ImageGallery",
			"headline": "<?php echo esc_js( get_the_title() ); ?>",
			"url" : "<?php echo esc_url( get_permalink() ); ?>",
			"mainEntityOfPage" : "<?php echo esc_url( get_permalink() ); ?>",
		 	"datePublished": "<?php echo esc_js( get_the_time( 'c' ) ); ?>",
		 	"dateModified": "<?php echo esc_js( get_the_modified_date( 'c' ) ); ?>",
		 	"description": "<?php echo esc_js( get_the_excerpt() ); ?>",
		 	"author": {
		 		"@type" : "person",
		 		"name" : "<?php echo esc_js( get_the_author() ); ?>",
		 		"url" : "<?php esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"
		 	},
		 	"publisher" : {
		 		"@id" : "<?php echo esc_url( home_url() ); ?>#WebSitePublisher"
		 	}

		 	<?php if ( lsvr_townpress_has_post_terms( get_the_ID(), 'lsvr_gallery_tag' ) ) : ?>
			,"keywords": "<?php echo esc_js( implode( ',', lsvr_townpress_get_post_term_names( get_the_ID(), 'lsvr_gallery_tag' ) ) ); ?>"
		 	<?php endif; ?>

			<?php if ( has_post_thumbnail() ) : ?>
		 	,"image": {
		 		"@type" : "ImageObject",
		 		"url" : "<?php the_post_thumbnail_url( 'full' ); ?>",
		 		"width" : "<?php echo esc_js( lsvr_townpress_get_image_width( get_post_thumbnail_id( get_the_ID() ), 'full' ) ); ?>",
		 		"height" : "<?php echo esc_js( lsvr_townpress_get_image_height( get_post_thumbnail_id( get_the_ID() ), 'full' ) ); ?>",
		 		"thumbnailUrl" : "<?php the_post_thumbnail_url( 'thumbnail' ); ?>"
		 	}
		 	<?php endif; ?>

		 	<?php if ( lsvr_townpress_has_gallery_images( get_the_ID() ) ) : ?>
		 		,"associatedMedia" : [
		 		<?php $i = 1; foreach ( lsvr_townpress_get_gallery_images( get_the_ID() ) as $image ) : ?>
					{
			 			"@type" : "ImageObject",
			 			"url" : "<?php echo esc_url( $image['full_url'] ); ?>",
			 			"width" : "<?php echo esc_js( $image['full_width'] ); ?>",
			 			"height" : "<?php echo esc_js( $image['full_height'] ); ?>",
			 			"thumbnailUrl" : "<?php echo esc_url( $image['thumb_url'] ); ?>"
			 		}<?php if ( $i < count( lsvr_townpress_get_gallery_images( get_the_ID() ) ) ) { echo ','; } ?>
		 		<?php $i++; endforeach; ?>
		 		]
		 	<?php endif; ?>

		}
		</script>

	<?php }
}

?>