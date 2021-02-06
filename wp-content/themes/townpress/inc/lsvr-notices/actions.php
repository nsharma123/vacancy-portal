<?php

// Page title
add_filter( 'document_title_parts', 'lsvr_townpress_notice_title', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_notice_title' ) ) {
	function lsvr_townpress_notice_title( $title ) {

		if ( is_post_type_archive( 'lsvr_notice' ) ) {
			$title['title'] = sanitize_text_field( lsvr_townpress_get_notice_archive_title() );
		}
		return $title;

	}
}

// Breadcrumbs
add_filter( 'lsvr_townpress_add_to_breadcrumbs', 'lsvr_townpress_notice_breadcrumbs', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_notice_breadcrumbs' ) ) {
	function lsvr_townpress_notice_breadcrumbs( $breadcrumbs ) {

		if ( lsvr_townpress_is_notice() && ! is_post_type_archive( 'lsvr_notice' ) ) {
			$breadcrumbs = array(
				array(
					'url' => get_post_type_archive_link( 'lsvr_notice' ),
					'label' => lsvr_townpress_get_notice_archive_title(),
				),
			);
		}
		return $breadcrumbs;

	}
}

// Archive pre_get_posts actions
add_action( 'pre_get_posts', 'lsvr_townpress_notice_archive_pre_get_posts' );
if ( ! function_exists( 'lsvr_townpress_notice_archive_pre_get_posts' ) ) {
	function lsvr_townpress_notice_archive_pre_get_posts( $query ) {
		if ( ! is_admin() && $query->is_main_query() && ( $query->is_post_type_archive( 'lsvr_notice' ) ||
			$query->is_tax( 'lsvr_notice_cat' ) || $query->is_tax( 'lsvr_notice_tag' ) ) ) {

			// Posts per page
			if ( 0 === get_theme_mod( 'lsvr_notice_archive_posts_per_page', 10 ) ) {
				$query->set( 'posts_per_page', 1000 );
			} else {
				$query->set( 'posts_per_page', esc_attr( get_theme_mod( 'lsvr_notice_archive_posts_per_page', 10 ) ) );
			}

		}
	}
}

// Left sidebar ID
add_filter( 'lsvr_townpress_sidebar_left_id', 'lsvr_townpress_notice_sidebar_left_id', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_notice_sidebar_left_id' ) ) {
	function lsvr_townpress_notice_sidebar_left_id( $sidebar_id ) {

		// Single
		if ( is_singular( 'lsvr_notice' ) ) {
			$sidebar_id = get_theme_mod( 'lsvr_notice_single_sidebar_left_id', 'lsvr-townpress-default-sidebar-left' );
		}

		// Archive
		else if ( lsvr_townpress_is_notice() ) {
			$sidebar_id = get_theme_mod( 'lsvr_notice_archive_sidebar_left_id', 'lsvr-townpress-default-sidebar-left' );
		}

		return $sidebar_id;

	}
}

// Right sidebar ID
add_filter( 'lsvr_townpress_sidebar_right_id', 'lsvr_townpress_notice_sidebar_right_id', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_notice_sidebar_right_id' ) ) {
	function lsvr_townpress_notice_sidebar_right_id( $sidebar_id ) {

		// Single
		if ( is_singular( 'lsvr_notice' ) ) {
			$sidebar_id = get_theme_mod( 'lsvr_notice_single_sidebar_right_id', 'lsvr-townpress-default-sidebar-right' );
		}

		// Archive
		else if ( lsvr_townpress_is_notice() ) {
			$sidebar_id = get_theme_mod( 'lsvr_notice_archive_sidebar_right_id', 'lsvr-townpress-default-sidebar-right' );
		}

		return $sidebar_id;

	}
}

// Add post meta data
add_action( 'lsvr_townpress_notice_single_bottom', 'lsvr_townpress_add_notice_single_meta', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_add_notice_single_meta' ) ) {
	function lsvr_townpress_add_notice_single_meta() { ?>

		<script type="application/ld+json">
		{
			"@context" : "http://schema.org",
			"@type" : "NewsArticle",
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

		 	<?php if ( lsvr_townpress_has_post_terms( get_the_ID(), 'lsvr_notice_tag' ) ) : ?>
			,"keywords": "<?php echo esc_js( implode( ',', lsvr_townpress_get_post_term_names( get_the_ID(), 'lsvr_notice_tag' ) ) ); ?>"
		 	<?php endif; ?>

		}
		</script>

	<?php }
}

?>