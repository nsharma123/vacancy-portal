<?php

// Include additional files
require_once( get_template_directory() . '/inc/lsvr-galleries/actions.php' );
require_once( get_template_directory() . '/inc/lsvr-galleries/frontend-functions.php' );
require_once( get_template_directory() . '/inc/lsvr-galleries/customizer-config.php' );

// Is gallery page
if ( ! function_exists( 'lsvr_townpress_is_gallery' ) ) {
	function lsvr_townpress_is_gallery() {

		if ( is_post_type_archive( 'lsvr_gallery' ) || is_tax( 'lsvr_gallery_cat' ) || is_tax( 'lsvr_gallery_tag' ) ||
			is_singular( 'lsvr_gallery' ) ) {
			return true;
		} else {
			return false;
		}

	}
}

// Get gallery archive layout
if ( ! function_exists( 'lsvr_townpress_get_gallery_archive_layout' ) ) {
	function lsvr_townpress_get_gallery_archive_layout() {

		return 'photogrid';

	}
}

// Get gallery archive title
if ( ! function_exists( 'lsvr_townpress_get_gallery_archive_title' ) ) {
	function lsvr_townpress_get_gallery_archive_title() {

		return get_theme_mod( 'lsvr_gallery_archive_title', esc_html__( 'Galleries', 'townpress' ) );

	}
}

// Has thumbnail
if ( ! function_exists( 'lsvr_townpress_has_gallery_post_archive_thumbnail' ) ) {
	function lsvr_townpress_has_gallery_post_archive_thumbnail( $post_id ) {
		if ( function_exists( 'lsvr_galleries_get_single_thumb' ) ) {

			$thumbnail = lsvr_galleries_get_single_thumb( $post_id );
			return ! empty( $thumbnail ) ? true : false;

		}
	}
}


// Get gallery images
if ( ! function_exists( 'lsvr_townpress_get_gallery_images' ) ) {
	function lsvr_townpress_get_gallery_images( $post_id ) {
		if ( function_exists( 'lsvr_galleries_get_gallery_images' ) ) {

			$gallery_images = lsvr_galleries_get_gallery_images( $post_id );
			return ! empty( $gallery_images ) ? $gallery_images : false;

		}
	}
}

// Gallery images count
if ( ! function_exists( 'lsvr_townpress_get_gallery_images_count' ) ) {
	function lsvr_townpress_get_gallery_images_count( $post_id ) {
		if ( function_exists( 'lsvr_galleries_get_gallery_images_count' ) ) {

			return (int) lsvr_galleries_get_gallery_images_count( $post_id );

		}
	}
}

// Has gallery images
if ( ! function_exists( 'lsvr_townpress_has_gallery_images' ) ) {
	function lsvr_townpress_has_gallery_images( $post_id ) {
		if ( function_exists( 'lsvr_galleries_get_gallery_images_count' ) ) {

			$images_count = lsvr_galleries_get_gallery_images_count( $post_id );
			return $images_count > 0 ? true : false;

		}
	}
}

?>