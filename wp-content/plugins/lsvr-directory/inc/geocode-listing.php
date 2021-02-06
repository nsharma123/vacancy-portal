<?php
/**
 * Get location latitude and longitude from address and save them into meta.
 */
add_action( 'save_post', 'lsvr_directory_geocode_listing', 100 );
if ( ! function_exists( 'lsvr_directory_geocode_listing' ) ) {
	function lsvr_directory_geocode_listing( $post_id ) {

		$post_type = get_post_type( $post_id );
		if ( 'lsvr_listing' === $post_type && ! empty( get_theme_mod( 'google_api_key', '' ) ) ) {

			// Get locating method
			$locating_method = get_post_meta( $post_id, 'lsvr_listing_map_locating_method', true );

			// Get accurate address from meta
			$accurate_address = get_post_meta( $post_id, 'lsvr_listing_accurate_address', true );

			// Proceed only if locating method is set to 'address' and accurate address is not blank
			if ( 'address' === $locating_method && ! empty( $accurate_address ) ) {

				// Get last geocoded accurate address from meta
				$accurate_address_geocoded = get_post_meta( $post_id, 'lsvr_listing_accurate_address_geocoded', true );

				// Get geocoded latitude and longitude
				$latlong_geocoded = get_post_meta( $post_id, 'lsvr_listing_latlong_geocoded', true );

				// Make sure the address changed from the last geocoding request to avoid unnecessary request
				// or if geocoded latitude and longitude are blank
				if ( ( $accurate_address !== $accurate_address_geocoded ) || empty( $latlong_geocoded ) ) {

					// Prepare query URL
					$query_url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode( esc_attr( $accurate_address ) ) . '&key=' . esc_attr( get_theme_mod( 'google_api_key', '' ) );

					// Run query
					$response = wp_remote_get( esc_url_raw( $query_url ) );

					// Parse response
					if ( ! empty( $response['body'] ) ) {

						$response = json_decode( $response['body'] );

						// Check for data
						if ( is_object( $response ) && property_exists( $response, 'results' ) ) {

							$results = $response->results;

							if ( is_array( $results ) ) {

								$results = reset( $results );
								if ( ! empty( $results->geometry->location->lat ) && ! empty( $results->geometry->location->lng ) ) {
									$latitude_geocoded = $results->geometry->location->lat;
									$longitude_geocoded = $results->geometry->location->lng;
								}

							}
						}

						// Error message
						if ( is_object( $response ) && property_exists( $response, 'error_message' ) ) {
							set_transient( 'lsvr_directory_geocode_error_message', $response->error_message, 45 );
						}

					}

					// If geocoded latitude and longitude are retrieved, save them into meta
					if ( ! empty( $latitude_geocoded ) && ! empty( $longitude_geocoded ) ) {

						// Save geocoded latitude & longitude
						if ( ! empty( get_post_meta( $post_id, 'lsvr_listing_latlong_geocoded' ) ) ) {
							update_post_meta( $post_id, 'lsvr_listing_latlong_geocoded', sanitize_text_field( $latitude_geocoded . ', ' . $longitude_geocoded ) );
						} else {
							add_post_meta( $post_id, 'lsvr_listing_latlong_geocoded', sanitize_text_field( $latitude_geocoded . ', ' . $longitude_geocoded ), true );
						}

						// Copy the accurate_address into accurate_address_geocoded meta to prevent unnecesarry request
						// if the listing will be saved without address changing in the future
						if ( ! empty( get_post_meta( $post_id, 'lsvr_listing_accurate_address_geocoded' ) ) ) {
							update_post_meta( $post_id, 'lsvr_listing_accurate_address_geocoded', sanitize_text_field( $accurate_address ) );
						} else {
							add_post_meta( $post_id, 'lsvr_listing_accurate_address_geocoded', sanitize_text_field( $accurate_address ), true );
						}

					}

				}

			}

			// If locating method is not set to 'address' or accurate address is blank, remove geocoded meta values
			else {
				delete_post_meta( $post_id, 'lsvr_listing_latlong_geocoded' );
				delete_post_meta( $post_id, 'lsvr_listing_accurate_address_geocoded' );
			}

		}

	}
}

// Error message
add_action( 'admin_notices', 'lsvr_directory_geocode_error_message' );
if ( ! function_exists( 'lsvr_directory_geocode_error_message' ) ) {
	function lsvr_directory_geocode_error_message() {

		$error_messsage = get_transient( 'lsvr_directory_geocode_error_message' );

		if ( ! empty( $error_messsage ) ) {

			$class = 'notice notice-error';
			$title = esc_html__( 'The Google API request returned an error:', 'lsvr-directory' );
			$note = esc_html__( 'Please consider using Latitude and Longitude options instead of Exact Address or upgrade your Google API plan.', 'lsvr-directory' );
			$message = $error_messsage;
			printf( '<div class="%1$s"><p><strong>' . $title . '</strong><br>%2$s</p><p>' . $note . '</p></div>', esc_attr( $class ), esc_html( $message ) );
			delete_transient( 'lsvr_directory_geocode_error_message' );

		}

	}
}

?>