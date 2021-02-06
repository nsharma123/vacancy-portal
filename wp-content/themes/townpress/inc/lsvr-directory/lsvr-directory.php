<?php

// Include additional files
require_once( get_template_directory() . '/inc/lsvr-directory/actions.php' );
require_once( get_template_directory() . '/inc/lsvr-directory/ajax-directory-map.php' );
require_once( get_template_directory() . '/inc/lsvr-directory/frontend-functions.php' );
require_once( get_template_directory() . '/inc/lsvr-directory/customizer-config.php' );

// Is listing page
if ( ! function_exists( 'lsvr_townpress_is_listing' ) ) {
	function lsvr_townpress_is_listing() {

		if ( is_post_type_archive( 'lsvr_listing' ) || is_tax( 'lsvr_listing_cat' ) || is_tax( 'lsvr_listing_tag' ) ||
			is_singular( 'lsvr_listing' ) ) {
			return true;
		} else {
			return false;
		}

	}
}

// Get listing archive layout
if ( ! function_exists( 'lsvr_townpress_get_listing_archive_layout' ) ) {
	function lsvr_townpress_get_listing_archive_layout() {

		return 'default';

	}
}

// Get listing archive title
if ( ! function_exists( 'lsvr_townpress_get_listing_archive_title' ) ) {
	function lsvr_townpress_get_listing_archive_title() {

		return get_theme_mod( 'lsvr_listing_archive_title', esc_html__( 'Directory', 'townpress' ) );

	}
}

// Get listing archive map query
if ( ! function_exists( 'lsvr_townpress_get_listing_archive_map_query_json' ) ) {
	function lsvr_townpress_get_listing_archive_map_query_json() {

		$query = array();

		// Check for language
		if ( defined( 'ICL_LANGUAGE_CODE' ) && ! empty( ICL_LANGUAGE_CODE ) ) {
			$query['language'] = ICL_LANGUAGE_CODE;
		}

		// Taxonomy query
		if ( is_tax( 'lsvr_listing_cat' ) ) {
			$query['category'] = get_queried_object_id();
		}

		// Tag query
		if ( is_tax( 'lsvr_listing_tag' ) ) {
			$query['tag'] = get_queried_object_id();
		}

		return ! empty( $query ) ? json_encode( $query ) : false;

	}
}

// Has single featured header
if ( ! function_exists( 'lsvr_townpress_has_listing_single_featured_image' ) ) {
	function lsvr_townpress_has_listing_single_featured_image( $post_id ) {

		$gallery_images = get_post_meta( $post_id, 'lsvr_listing_gallery', true );
		if ( has_post_thumbnail( $post_id ) && true === get_theme_mod( 'lsvr_listing_single_featured_image_enable', true ) ) {
			return true;
		} else {
			return false;
		}

	}
}

// Get map location
if ( ! function_exists( 'lsvr_townpress_get_listing_map_location' ) ) {
	function lsvr_townpress_get_listing_map_location( $post_id, $type = false ) {

		$latlong_arr = array();
		$locating_method = get_post_meta( $post_id, 'lsvr_listing_map_locating_method', true );
		$latlong = get_post_meta( $post_id, 'lsvr_listing_latlong', true );
		$latlong_geocoded = get_post_meta( $post_id, 'lsvr_listing_latlong_geocoded', true );

		if ( 'address' === $locating_method && ! empty( $latlong_geocoded ) ) {

			$latlong_arr['latitude'] = trim( substr( $latlong_geocoded, 0, strpos( $latlong_geocoded, ',' ) ) );
			$latlong_arr['longitude'] = trim( substr( $latlong_geocoded, strpos( $latlong_geocoded, ',' ) + 1, strlen( $latlong_geocoded ) ) );

		}
		else if ( 'latlong' === $locating_method && ! empty( $latlong ) ) {

			$latlong_arr['latitude'] = trim( substr( $latlong, 0, strpos( $latlong, ',' ) ) );
			$latlong_arr['longitude'] = trim( substr( $latlong, strpos( $latlong, ',' ) + 1, strlen( $latlong ) ) );

		}

		if ( 'latitude' === $type && ! empty( $latlong_arr['latitude'] ) ) {
			return $latlong_arr['latitude'];
		}
		else if ( 'longitude' === $type && ! empty( $latlong_arr['longitude'] ) ) {
			return $latlong_arr['longitude'];
		}
		else {
			return $latlong_arr;
		}

	}
}

// Has map location
if ( ! function_exists( 'lsvr_townpress_has_listing_map_location' ) ) {
	function lsvr_townpress_has_listing_map_location( $post_id ) {

		$latlong = lsvr_townpress_get_listing_map_location( $post_id );
		return ! empty( $latlong ) ? true : false;

	}
}

// Get map link
if ( ! function_exists( 'lsvr_townpress_get_listing_map_link' ) ) {
	function lsvr_townpress_get_listing_map_link( $post_id ) {

		if ( lsvr_townpress_has_listing_map_location( $post_id ) ) {
			$latlong = lsvr_townpress_get_listing_map_location( $post_id );
			if ( ! empty( $latlong['latitude'] && ! empty( $latlong['longitude'] ) ) ) {
				return 'http://maps.google.com/maps?q=loc:' . $latlong['latitude'] . ',' . $latlong['longitude'];
			}
		}

	}
}

// Has map link
if ( ! function_exists( 'lsvr_townpress_has_listing_map_link' ) ) {
	function lsvr_townpress_has_listing_map_link( $post_id ) {

		$map_link = lsvr_townpress_get_listing_map_link( $post_id );
		return ! empty( $map_link ) ? true : false;

	}
}

// Get listing address
if ( ! function_exists( 'lsvr_townpress_get_listing_address' ) ) {
	function lsvr_townpress_get_listing_address( $post_id ) {

		$address = get_post_meta( $post_id, 'lsvr_listing_address', true );
		return ! empty( $address ) ? $address : false;

	}
}

// Has listing address
if ( ! function_exists( 'lsvr_townpress_has_listing_address' ) ) {
	function lsvr_townpress_has_listing_address( $post_id ) {

		$address = lsvr_townpress_get_listing_address( $post_id );
		return ! empty( $address ) ? true : false;

	}
}

// Has opening hours
if ( ! function_exists( 'lsvr_townpress_has_listing_opening_hours' ) ) {
	function lsvr_townpress_has_listing_opening_hours( $post_id ) {

		$opening_hours_type = get_post_meta( $post_id, 'lsvr_listing_opening_hours', true );
		$opening_hours_custom = get_post_meta( $post_id, 'lsvr_listing_opening_hours_custom', true );
		$opening_hours_select = get_post_meta( $post_id, 'lsvr_listing_opening_hours_select', true );

		if ( ( 'custom' == $opening_hours_type && ! empty( $opening_hours_custom ) ) ||
			( 'select' == $opening_hours_type && ! empty( $opening_hours_select ) ) ) {
			return true;
		}
		else {
			return false;
		}

	}
}

// Has gallery
if ( ! function_exists( 'lsvr_townpress_has_listing_gallery' ) ) {
	function lsvr_townpress_has_listing_gallery( $post_id ) {

		$gallery_images = get_post_meta( $post_id, 'lsvr_listing_gallery', true );
		return ! empty( $gallery_images ) ? true : false;

	}
}

// Get listing contact info
if ( ! function_exists( 'lsvr_townpress_get_listing_contact_info' ) ) {
	function lsvr_townpress_get_listing_contact_info( $post_id ) {

		$return = array();
		$contact_profiles = array( 'phone', 'fax', 'email', 'website' );

		foreach ( $contact_profiles as $profile ) {
			$contact = get_post_meta( $post_id, 'lsvr_listing_contact_' . $profile, true );
			if ( ! empty( $contact ) ) {
				$return[ $profile ] = $contact;
			}
		}

		// Add address
		if ( lsvr_townpress_has_listing_address( $post_id ) ) {
			$return[ 'address' ] = lsvr_townpress_get_listing_address( $post_id );
		}

		return $return;

	}
}

// Has listing contact info
if ( ! function_exists( 'lsvr_townpress_has_listing_contact_info' ) ) {
	function lsvr_townpress_has_listing_contact_info( $post_id ) {

		$contact_info = lsvr_townpress_get_listing_contact_info( $post_id );
		return ! empty( $contact_info ) ? true : false;

	}
}

// Get listing phone
if ( ! function_exists( 'lsvr_townpress_get_listing_phone' ) ) {
	function lsvr_townpress_get_listing_phone( $post_id ) {

		$phone = get_post_meta( $post_id, 'lsvr_listing_contact_phone', true );
		return ! empty( $phone ) ? $phone : false;
	}
}

// Has listing phone
if ( ! function_exists( 'lsvr_townpress_has_listing_phone' ) ) {
	function lsvr_townpress_has_listing_phone( $post_id ) {

		$phone = lsvr_townpress_get_listing_phone( $post_id );
		return ! empty( $phone ) ? true : false;

	}
}

// Get listing social links
if ( ! function_exists( 'lsvr_townpress_get_listing_social_links' ) ) {
	function lsvr_townpress_get_listing_social_links( $post_id ) {

		$return = array();
		$social_profiles = array( 'twitter', 'facebook', 'instagram', 'yelp' );
		foreach ( $social_profiles as $profile ) {
			$social = get_post_meta( $post_id, 'lsvr_listing_social_' . $profile, true );
			if ( ! empty( $social ) ) {
				$return[ $profile ] = $social;
			}
		}
		return $return;

	}
}

// Has listing social links
if ( ! function_exists( 'lsvr_townpress_has_listing_social_links' ) ) {
	function lsvr_townpress_has_listing_social_links( $post_id ) {

		$social_links = lsvr_townpress_get_listing_social_links( $post_id );
		return ! empty( $social_links ) ? true : false;

	}
}

// Get listing metadata business type
if ( ! function_exists( 'lsvr_townpress_get_listing_meta_business_type' ) ) {
	function lsvr_townpress_get_listing_meta_business_type( $post_id ) {

		return get_post_meta( $post_id, 'lsvr_listing_meta_business_type', true );

	}
}

// Get listing metadata postal address
if ( ! function_exists( 'lsvr_townpress_get_listing_meta_postal_address' ) ) {
	function lsvr_townpress_get_listing_meta_postal_address( $post_id ) {

		$return = array();
		$return['country'] = get_post_meta( $post_id, 'lsvr_listing_meta_country', true );
		$return['locality'] = get_post_meta( $post_id, 'lsvr_listing_meta_locality', true );
		$return['region'] = get_post_meta( $post_id, 'lsvr_listing_meta_region', true );
		$return['postalcode'] = get_post_meta( $post_id, 'lsvr_listing_meta_postalcode', true );
		$return['street'] = get_post_meta( $post_id, 'lsvr_listing_meta_street', true );
		return $return;

	}
}

?>