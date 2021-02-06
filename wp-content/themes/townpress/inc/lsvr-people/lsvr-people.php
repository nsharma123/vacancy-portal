<?php

// Include additional files
require_once( get_template_directory() . '/inc/lsvr-people/actions.php' );
require_once( get_template_directory() . '/inc/lsvr-people/frontend-functions.php' );
require_once( get_template_directory() . '/inc/lsvr-people/customizer-config.php' );

// Is person page
if ( ! function_exists( 'lsvr_townpress_is_person' ) ) {
	function lsvr_townpress_is_person() {

		return is_post_type_archive( 'lsvr_person' ) || is_tax( 'lsvr_person_cat' ) || is_singular( 'lsvr_person' ) ? true : false;

	}
}

// Get person archive layout
if ( ! function_exists( 'lsvr_townpress_get_person_archive_layout' ) ) {
	function lsvr_townpress_get_person_archive_layout() {

		return 'default';

	}
}

// Get person archive title
if ( ! function_exists( 'lsvr_townpress_get_person_archive_title' ) ) {
	function lsvr_townpress_get_person_archive_title() {

		return get_theme_mod( 'lsvr_person_archive_title', esc_html__( 'People', 'townpress' ) );

	}
}

// Get person role
if ( ! function_exists( 'lsvr_townpress_get_person_role' ) ) {
	function lsvr_townpress_get_person_role( $post_id ) {

		$person_role = get_post_meta( $post_id, 'lsvr_person_role', true );
		return ! empty( $person_role ) ? $person_role : false;

	}
}

// Has person role
if ( ! function_exists( 'lsvr_townpress_has_person_role' ) ) {
	function lsvr_townpress_has_person_role( $post_id ) {

		$person_role = lsvr_townpress_get_person_role( $post_id );
		return ! empty( $person_role ) ? true : false;

	}
}

// Get person email
if ( ! function_exists( 'lsvr_townpress_get_person_email' ) ) {
	function lsvr_townpress_get_person_email( $post_id ) {

		$email = get_post_meta( $post_id, 'lsvr_person_email', true );
		return ! empty( $email ) ? $email : false;

	}
}

// Has person email
if ( ! function_exists( 'lsvr_townpress_has_person_email' ) ) {
	function lsvr_townpress_has_person_email( $post_id ) {

		$email = lsvr_townpress_get_person_email( $post_id );
		return ! empty( $email ) ? true : false;

	}
}

// Get person phone
if ( ! function_exists( 'lsvr_townpress_get_person_phone' ) ) {
	function lsvr_townpress_get_person_phone( $post_id ) {

		$phone = get_post_meta( $post_id, 'lsvr_person_phone', true );
		return ! empty( $phone ) ? $phone : false;

	}
}

// Has person phone
if ( ! function_exists( 'lsvr_townpress_has_person_phone' ) ) {
	function lsvr_townpress_has_person_phone( $post_id ) {

		$phone = lsvr_townpress_get_person_phone( $post_id );
		return ! empty( $phone ) ? true : false;

	}
}

// Get person website
if ( ! function_exists( 'lsvr_townpress_get_person_website' ) ) {
	function lsvr_townpress_get_person_website( $post_id ) {

		$website = get_post_meta( $post_id, 'lsvr_person_website', true );
		return ! empty( $website ) ? $website : false;

	}
}

// Has person website
if ( ! function_exists( 'lsvr_townpress_has_person_website' ) ) {
	function lsvr_townpress_has_person_website( $post_id ) {

		$website = lsvr_townpress_get_person_website( $post_id );
		return ! empty( $website ) ? true : false;

	}
}

// Has person contact info
if ( ! function_exists( 'lsvr_townpress_has_person_contact_info' ) ) {
	function lsvr_townpress_has_person_contact_info( $post_id ) {

		if ( lsvr_townpress_has_person_email( $post_id ) || lsvr_townpress_has_person_phone( $post_id ) ||
			lsvr_townpress_has_person_website( $post_id ) ) {
			return true;
		} else {
			return false;
		}

	}
}

// Get person social links
if ( ! function_exists( 'lsvr_townpress_get_person_social_links' ) ) {
	function lsvr_townpress_get_person_social_links( $post_id ) {
		if ( function_exists( 'lsvr_people_get_person_social_links' ) ) {

			$social_links = lsvr_people_get_person_social_links( $post_id );
			return ! empty( $social_links ) ? $social_links : false;

		}
	}
}

// Has person social links
if ( ! function_exists( 'lsvr_townpress_has_person_social_links' ) ) {
	function lsvr_townpress_has_person_social_links( $post_id ) {

		$social_links = lsvr_townpress_get_person_social_links( $post_id );
		return ! empty( $social_links ) ? true : false;

	}
}

?>