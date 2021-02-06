<?php

// Page title
add_filter( 'document_title_parts', 'lsvr_townpress_bbpress_title', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_bbpress_title' ) ) {
	function lsvr_townpress_bbpress_title( $title ) {

		if ( is_post_type_archive( 'forum' ) ) {
			$title['title'] = sanitize_text_field( lsvr_townpress_get_bbpress_archive_title() );
		}
		return $title;

	}
}

// Breadcrumbs
add_filter( 'lsvr_townpress_add_to_breadcrumbs', 'lsvr_townpress_bbpress_breadcrumbs', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_bbpress_breadcrumbs' ) ) {
	function lsvr_townpress_bbpress_breadcrumbs( $breadcrumbs ) {

		if ( function_exists( 'is_bbpress' ) && is_bbpress() && ! is_post_type_archive( 'forum' ) ) {
			$breadcrumbs = array(
				array(
					'url' => get_post_type_archive_link( 'forum' ),
					'label' => lsvr_townpress_get_bbpress_archive_title(),
				),
			);
		}
		return $breadcrumbs;

	}
}

// Left sidebar ID
add_filter( 'lsvr_townpress_sidebar_left_id', 'lsvr_townpress_bbpress_sidebar_left_id', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_bbpress_sidebar_left_id' ) ) {
	function lsvr_townpress_bbpress_sidebar_left_id( $sidebar_id ) {

		if ( function_exists( 'is_bbpress' ) && is_bbpress() ) {
			$sidebar_id = get_theme_mod( 'lsvr_bbpress_sidebar_left_id', 'lsvr-townpress-default-sidebar-left' );
		}

		return $sidebar_id;

	}
}

// Right sidebar ID
add_filter( 'lsvr_townpress_sidebar_right_id', 'lsvr_townpress_bbpress_sidebar_right_id', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_bbpress_sidebar_right_id' ) ) {
	function lsvr_townpress_bbpress_sidebar_right_id( $sidebar_id ) {

		if ( function_exists( 'is_bbpress' ) && is_bbpress() ) {
			$sidebar_id = get_theme_mod( 'lsvr_bbpress_sidebar_right_id', 'lsvr-townpress-default-sidebar-right' );
		}

		return $sidebar_id;

	}
}

?>