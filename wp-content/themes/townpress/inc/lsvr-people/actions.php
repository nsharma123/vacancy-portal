<?php

// Page title
add_filter( 'document_title_parts', 'lsvr_townpress_person_title', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_person_title' ) ) {
	function lsvr_townpress_person_title( $title ) {

		if ( is_post_type_archive( 'lsvr_person' ) ) {
			$title['title'] = sanitize_text_field( lsvr_townpress_get_person_archive_title() );
		}
		return $title;

	}
}

// Breadcrumbs
add_filter( 'lsvr_townpress_add_to_breadcrumbs', 'lsvr_townpress_person_breadcrumbs', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_person_breadcrumbs' ) ) {
	function lsvr_townpress_person_breadcrumbs( $breadcrumbs ) {

		if ( lsvr_townpress_is_person() && ! is_post_type_archive( 'lsvr_person' ) ) {
			$breadcrumbs = array(
				array(
					'url' => get_post_type_archive_link( 'lsvr_person' ),
					'label' => lsvr_townpress_get_person_archive_title(),
				),
			);
		}
		return $breadcrumbs;

	}
}

// Archive pre_get_posts actions
add_action( 'pre_get_posts', 'lsvr_townpress_person_archive_pre_get_posts' );
if ( ! function_exists( 'lsvr_townpress_person_archive_pre_get_posts' ) ) {
	function lsvr_townpress_person_archive_pre_get_posts( $query ) {
		if ( ! is_admin() && $query->is_main_query() && ( $query->is_post_type_archive( 'lsvr_person' ) || $query->is_tax( 'lsvr_person_cat' ) ) ) {

			// Posts per page
			$query->set( 'posts_per_page', 1000 );

		}
	}
}

// Left sidebar ID
add_filter( 'lsvr_townpress_sidebar_left_id', 'lsvr_townpress_person_sidebar_left_id', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_person_sidebar_left_id' ) ) {
	function lsvr_townpress_person_sidebar_left_id( $sidebar_id ) {

		// Single
		if ( is_singular( 'lsvr_person' ) ) {
			$sidebar_id = get_theme_mod( 'lsvr_person_single_sidebar_left_id', 'lsvr-townpress-default-sidebar-left' );
		}

		// Archive
		else if ( lsvr_townpress_is_person() ) {
			$sidebar_id = get_theme_mod( 'lsvr_person_archive_sidebar_left_id', 'lsvr-townpress-default-sidebar-left' );
		}

		return $sidebar_id;

	}
}

// Right sidebar ID
add_filter( 'lsvr_townpress_sidebar_right_id', 'lsvr_townpress_person_sidebar_right_id', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_person_sidebar_right_id' ) ) {
	function lsvr_townpress_person_sidebar_right_id( $sidebar_id ) {

		// Single
		if ( is_singular( 'lsvr_person' ) ) {
			$sidebar_id = get_theme_mod( 'lsvr_person_single_sidebar_right_id', 'lsvr-townpress-default-sidebar-right' );
		}

		// Archive
		else if ( lsvr_townpress_is_person() ) {
			$sidebar_id = get_theme_mod( 'lsvr_person_archive_sidebar_right_id', 'lsvr-townpress-default-sidebar-right' );
		}

		return $sidebar_id;

	}
}

// Add post meta data
add_action( 'lsvr_townpress_person_single_bottom', 'lsvr_townpress_add_person_single_meta', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_add_person_single_meta' ) ) {
	function lsvr_townpress_add_person_single_meta() { ?>

		<script type="application/ld+json">
		{
			"@context" : "http://schema.org",
			"@type" : "Person",
			"name" : "<?php the_title(); ?>"

			<?php if ( lsvr_townpress_has_person_role( get_the_ID() ) ) : ?>
			,"jobTitle" : "<?php echo esc_js( lsvr_townpress_get_person_role( get_the_ID() ) ); ?>"
			<?php endif; ?>

			<?php if ( lsvr_townpress_has_person_email( get_the_ID() ) ) : ?>
			,"email" : "<?php echo esc_js( lsvr_townpress_get_person_email( get_the_ID() ) ); ?>"
			<?php endif; ?>

			<?php if ( lsvr_townpress_has_person_phone( get_the_ID() ) ) : ?>
			,"telephone" : "<?php echo esc_js( lsvr_townpress_get_person_phone( get_the_ID() ) ); ?>"
			<?php endif; ?>

			<?php if ( lsvr_townpress_has_person_website( get_the_ID() ) ) : ?>
			,"url" : "<?php echo esc_url( lsvr_townpress_get_person_website( get_the_ID() ) ); ?>"
			<?php endif; ?>

			<?php if ( lsvr_townpress_has_person_social_links( get_the_ID() ) ) : ?>
			,"sameAs" : [
				<?php $i = 1; foreach( lsvr_townpress_get_person_social_links( get_the_ID() ) as $profile => $link ) : ?>
		    		"<?php echo esc_url( $link ); ?>"
		    		<?php if ( $i < count( lsvr_townpress_get_person_social_links( get_the_ID() ) ) ) { echo ','; } ?>
				<?php $i++; endforeach; ?>
		  	]
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

		}
		</script>

	<?php }
}

?>