<?php
/**
 * Main function to retrieve directory listings.
 *
 * @param array $args {
 *		Optional. An array of arguments. If not defined, function will return all listings.
 *
 *		@type int|array		$listing_id		Single ID or array of IDs of lsvr_listing post(s).
 *											Only these listings will be returned.
 *											Leave blank to retrieve all lsvr_listing posts.
 *
 *		@type int			$limit			Max number of listings to retrieve.
 *
 *		@type int|array		$category		Category or categories from which to retrieve listings.
 *
 *		@type int|array		$tag			Tag taxonomy from which to retrieve listings.
 *
 *		@type string		$orderby		Set how to order listings.
 *											Accepts standard values for orderby argument in WordPress get_posts function.
 *
 *		@type string		$order			Set order of returned listings as ascending or descending.
 *											Default 'DESC'. Accepts 'ASC', 'DESC'.
 *
 *		@type bool			$return_meta	If enabled, important listing meta data will be returned as well.
 *											Default 'false'.
 *
 * }
 * @return array 	Array with all listing posts.
 */
if ( ! function_exists( 'lsvr_directory_get_listings' ) ) {
	function lsvr_directory_get_listings( $args = array() ) {

		$query_args = array(
			'suppress_filters' => false,
		);

		// Switch language
		if ( ! empty( $args['language'] ) ) {
			global $sitepress;
			if ( is_object( $sitepress ) && method_exists( $sitepress, 'switch_lang' ) ) {
				$sitepress->switch_lang( $args['language'] );
			}
		}

		// Listing ID
		if ( ! empty( $args['listing_id'] ) ) {
			if ( is_array( $args['listing_id'] ) ) {
				$listing_id = array_map( 'intval', $args['listing_id'] );
			} else {
				$listing_id = array_map( 'intval', explode( ',', $args['listing_id'] ) );
			}
			$query_args['post__in'] = $listing_id;
		}

		// Get number of listings
		if ( ! empty( $args['limit'] ) && is_numeric( $args['limit'] ) ) {
			$limit = (int) $args['limit'];
		} else {
			$limit = 1000;
		}
		$query_args['posts_per_page'] = $limit;

		// Get category tax query
		if ( ! empty( $args['category'] ) ) {

			if ( is_array( $args['category'] ) ) {
				$category = array_map( 'intval', $args['category'] );
			} else {
				$category = array( (int) $args['category'] );
			}
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'lsvr_listing_cat',
					'field' => 'term_id',
					'terms' => $category,
				),
			);

		}

		// Get tag tax query
		if ( ! empty( $args['tag'] ) ) {

			if ( is_array( $args['tag'] ) ) {
				$tag = array_map( 'intval', $args['tag'] );
			} else {
				$tag = array( (int) $args['tag'] );
			}
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'lsvr_listing_tag',
					'field' => 'term_id',
					'terms' => $tag,
				),
			);

		}

		// Get search query
		if ( ! empty( $args['keyword'] ) ) {
			$query_args['s'] = wp_strip_all_tags( $args['keyword'] );
		}

		// Get orderby of listings
		if ( ! empty( $args['orderby'] ) ) {
			$orderby = esc_attr( $args['orderby'] );
		} else {
			$orderby = 'date';
		}
		$query_args['orderby'] = $orderby;

		// Get order of listings
		$query_args['order'] = ! empty( $args['order'] ) && 'ASC' === strtoupper( $args['order'] ) ? 'ASC' : 'DESC';

		// Get listing posts
		$listing_posts = get_posts(
			array_merge( array( 'post_type' => 'lsvr_listing' ), $query_args )
		);

		// Add listing posts to $return
		if ( ! empty( $listing_posts ) ) {
			$return = array();
			foreach ( $listing_posts as $listing_post ) {
				if ( ! empty( $listing_post->ID ) ) {
					$return[ $listing_post->ID ]['post'] = $listing_post;
				}
			}
		}

		// Add meta to $return
		$return_meta = ! empty( $args['return_meta'] ) && true === $args['return_meta'] ? true : false;
		if ( ! empty( $return ) && is_array( $return ) && true === $return_meta ) {
			foreach ( array_keys( $return ) as $post_id ) {

				// Get listing link
				$return[ $post_id ]['permalink'] = esc_url( get_permalink( $post_id ) );

				// Get listing meta
				$return[ $post_id ]['meta'] = lsvr_directory_get_listing_meta( $post_id );

			}
		}

		// Return listings
		return ! empty( $return ) ? $return : false;

	}
}

/**
 * Retrieve listing meta data.
 *
 * @param int 		$listing_id		ID of a lsvr_listing post.
 *
 * @return array 					Array with important meta data of a listing posts.
 */
if ( ! function_exists( 'lsvr_directory_get_listing_meta' ) ) {
	function lsvr_directory_get_listing_meta( $listing_id ) {

		$return = array();

		// Get map locating method
		$listing_locating_method = get_post_meta( $listing_id, 'lsvr_listing_map_locating_method', true );
		if ( 'latlong' === $listing_locating_method || 'address' === $listing_locating_method ) {
			$return['locating_method'] = $listing_locating_method;
		} else {
			$return['locating_method'] = false;
		}

		// Get accurrate address from meta
		$listing_accurate_address = get_post_meta( $listing_id, 'lsvr_listing_accurate_address', true );
		if ( ! empty( $listing_accurate_address ) ) {
			$return['accurate_address'] = $listing_accurate_address;
		}

		// Get latitude and longitude from meta
		$listing_latlong = get_post_meta( $listing_id, 'lsvr_listing_latlong', true );
		$listing_latlong = ! empty( $listing_latlong ) ? explode( ',', $listing_latlong ) : false;
		$listing_latitude = ! empty( $listing_latlong[0] ) ? trim( $listing_latlong[0] ) : false;
		$listing_longitude = ! empty( $listing_latlong[1] ) ? trim( $listing_latlong[1] ) : false;
		if ( ! empty( $listing_latitude ) && ! empty( $listing_longitude ) ) {
			$return['latitude'] = $listing_latitude;
			$return['longitude'] = $listing_longitude;
		}

		// Get geocoded latitude and longitude from meta
		$listing_latlong_geocoded = get_post_meta( $listing_id, 'lsvr_listing_latlong_geocoded', true );
		$listing_latlong_geocoded = ! empty( $listing_latlong_geocoded ) ? explode( ',', $listing_latlong_geocoded ) : false;
		$listing_latitude_geocoded = ! empty( $listing_latlong_geocoded[0] ) ? trim( $listing_latlong_geocoded[0] ) : false;
		$listing_longitude_geocoded = ! empty( $listing_latlong_geocoded[1] ) ? trim( $listing_latlong_geocoded[1] ) : false;
		if ( ! empty( $listing_latitude_geocoded ) && ! empty( $listing_longitude_geocoded ) ) {
			$return['latitude_geocoded'] = $listing_latitude_geocoded;
			$return['longitude_geocoded'] = $listing_longitude_geocoded;
		}

		// Get address from meta
		$listing_address = get_post_meta( $listing_id, 'lsvr_listing_address', true );
		if ( ! empty( $listing_address ) ) {
			$return['address'] = $listing_address;
		}

		// Get phone number
		$listing_phone = get_post_meta( $listing_id, 'lsvr_listing_phone_number', true );
		if ( ! empty( $listing_phone ) ) {
			$return['phone'] = $listing_phone;
		}

		// Get email
		$listing_email = get_post_meta( $listing_id, 'lsvr_listing_email', true );
		if ( ! empty( $listing_email ) ) {
			$return['email'] = $listing_email;
		}

		// Get website
		$listing_website = get_post_meta( $listing_id, 'lsvr_listing_website', true );
		if ( ! empty( $listing_website ) ) {
			$return['website'] = $listing_website;
		}

		// Get opening hours
		$listing_opening_hours = get_post_meta( $listing_id, 'lsvr_listing_opening_hours', true );
		if ( ! empty( $listing_opening_hours ) ) {
			$return['opening_hours'] = $listing_opening_hours;
		}

		// Get gallery
		$listing_gallery = get_post_meta( $listing_id, 'lsvr_listing_gallery', true );
		if ( ! empty( $listing_gallery ) ) {
			$return['gallery'] = array_map( 'trim', explode( ',', $listing_gallery ) );
		}

		return $return;

	}
}

?>