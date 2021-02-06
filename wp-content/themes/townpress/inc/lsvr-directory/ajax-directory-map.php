<?php

/**
 * Function fired during AJAX request to display listings on map.
 *
 * @return json 	JSON with all listings data required to display them on map.
 */

add_action( 'wp_ajax_nopriv_lsvr-townpress-ajax-directory-map', 'lsvr_townpress_ajax_directory_map' );
add_action( 'wp_ajax_lsvr-townpress-ajax-directory-map', 'lsvr_townpress_ajax_directory_map' );
if ( ! function_exists( 'lsvr_townpress_ajax_directory_map' ) ) {
	function lsvr_townpress_ajax_directory_map() {

		// Test nonce
		$nonce = ! empty( $_POST['nonce'] ) ? $_POST['nonce'] : false;
		if ( ! wp_verify_nonce( $nonce, 'lsvr-townpress-ajax-directory-map-nonce' ) ) {
			die ( esc_html__( 'You do not have permission to access this data', 'townpress' ) );
		}

		// Use query to retrieve listings
		if ( ! empty( $_POST['query'] ) ) {
			$listings = lsvr_directory_get_listings(
				array_merge(
					(array) $_POST['query'],
					array( 'return_meta' => true )
				)
			);
		}

		// If query is empty, let's get all listings
		else {
			$listings = lsvr_directory_get_listings(array(
				'return_meta' => true
			));
		}

		// Parse listings to retrieve required data
		if ( ! empty( $listings ) ) {

			// Prepare array with all listings data required to display the listings on the map
			$directory_map_data = array(
				'locations' => array(),
				'markerclusterpath' => get_stylesheet_directory_uri() . '/assets/img/',
				'labels' => array_merge(
					array(
						'marker_infowindow_more_link' => esc_html__( 'More Details', 'townpress' ),
						'marker_infowindow_cat_prefix' => esc_html__( '%s', 'townpress' ),
					),
					(array) apply_filters( 'lsvr_directory_map_js_labels', [] )
				),
			);

			// Parse all listings
			foreach ( $listings as $listing_id => $listing ) {

				$listing_arr = array();

				// Get map locating method
				if ( ! empty( $listing['meta']['locating_method'] ) ) {
					$locating_method = esc_html( $listing['meta']['locating_method'] );
				}

				// Get user-defined listing latitude & longitude
				if ( 'latlong' === $locating_method && ( ! empty( $listing['meta']['latitude'] ) && ! empty( $listing['meta']['longitude'] ) ) ) {
					$listing_arr['latitude'] = esc_html( $listing['meta']['latitude'] );
					$listing_arr['longitude'] = esc_html( $listing['meta']['longitude'] );
				}

				// Get geocoded listing latitude & longitude
				else if ( 'address' === $locating_method && ! empty( $listing['meta']['latitude_geocoded'] ) && ! empty( $listing['meta']['longitude_geocoded'] ) ) {
					$listing_arr['latitude'] = esc_html( $listing['meta']['latitude_geocoded'] );
					$listing_arr['longitude'] = esc_html( $listing['meta']['longitude_geocoded'] );
				}

				// Proceed only if latitude and longitude params are set
				// as we can't display listing on the map without those
				if ( ! empty( $listing_arr['latitude'] ) && ! empty( $listing_arr['longitude'] ) ) {

					// Get listing ID
					$listing_arr['id'] = esc_html( $listing['post']->ID );

					// Get listing title
					$listing_arr['title'] = esc_html( $listing['post']->post_title );

					// Get listing permalink
					if ( ! empty( $listing['permalink'] ) ) {
						$listing_arr['permalink'] = esc_url( $listing['permalink'] );
					}

					// Get listing thumbnail URL
					$thumburl = get_the_post_thumbnail_url( $listing_id, 'thumbnail' );
					if ( ! empty( $thumburl ) ) {
						$listing_arr['thumburl'] = esc_url( $thumburl );
					}

					// Get listing category
					$category = array();
					$cat_terms = wp_get_post_terms( $listing_id, 'lsvr_listing_cat' );
					$i = 0;
					foreach ( $cat_terms as $term ) {
						$category[ $i ] = array(
							'id' => $term->term_id,
							'name' => $term->name,
							'url' => esc_url( get_term_link( $term->term_id, 'lsvr_listing_cat' ) ),
						);
						$i++;
					}
					if ( ! empty( $category ) ) {
						$listing_arr['category'] = $category;
					}

					// Get listing address
					if ( ! empty( $listing['meta']['address'] ) ) {
						$listing_arr['address'] = esc_html( $listing['meta']['address'] );
					}

					// Push listing array to array with all listings
					array_push( $directory_map_data['locations'], $listing_arr );

				}

			}

			// Convert listings data to JSON
			if ( ! empty( $directory_map_data ) ) {
				echo json_encode( $directory_map_data );
			} else {
				echo json_encode( array( 'error' => esc_html__( 'No listings', 'townpress' ) ) );
			}

		} else {
			echo json_encode( array( 'error' => esc_html__( 'No listings', 'townpress' ) ) );
		}

		wp_die();

	}
}

?>