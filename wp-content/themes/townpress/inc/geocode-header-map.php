<?php
/**
 * Get header map latitude and longitude from address and save them into options table.
 * Try to do it asynchronously if Lsvr_Townpress_Async_Task_Geocode_Header_Map_Address class exists, otherwise do it in a standard way.
 */

add_action( 'customize_save_after', 'lsvr_townpress_geocode_header_map', 100 );
if ( ! function_exists( 'lsvr_townpress_geocode_header_map' ) ) {
	function lsvr_townpress_geocode_header_map() {

		if ( ! empty( get_theme_mod( 'google_api_key', '' ) ) ) {

			// Get map meta
			$map_meta = get_option( 'lsvr_townpress_header_map_meta' );

			// Get map address
			$address_saved = get_theme_mod( 'header_map_address', '' );

			// Get latitude and longitude
			$latitude = get_theme_mod( 'header_map_latitude', '' );
			$longitude = get_theme_mod( 'header_map_longitude', '' );

			// Proceed only if accurate address is not blank and latitude or longitude is blank
			if ( ! empty( $address_saved ) && ( empty( $latitude ) || empty( $longitude ) ) ) {

				// Get last geocoded accurate address from meta
				$address_geocoded = ! empty( $map_meta['address_geocoded'] ) ? $map_meta['address_geocoded'] : false;

				// Get geocoded latitude and longitude
				$latlong_geocoded = ! empty( $map_meta['latlong_geocoded'] ) ? $map_meta['latlong_geocoded'] : false;

				// Make sure the address changed from the last geocoding request to avoid unnecessary request
				// or if geocoded latitude and longitude are blank
				if ( ( $address_saved !== $address_geocoded ) || empty( $latlong_geocoded ) ) {

					// Prepare query URL
					$query_url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode( esc_html( $address_saved ) ) . '&key=' . esc_html( get_theme_mod( 'google_api_key', '' ) );

					// Run query
					$response = wp_remote_get( esc_url( $query_url ) );

					// Get location data
					if ( ! empty( $response['body'] ) ) {

						$response = json_decode( $response['body'] );
						if ( is_object( $response ) && property_exists( $response, 'results' ) ) {

							$response = $response->results;

							if ( is_array( $response ) ) {

								$response = reset( $response );
								if ( ! empty( $response->geometry->location->lat ) && ! empty( $response->geometry->location->lng ) ) {
									$latitude_geocoded = $response->geometry->location->lat;
									$longitude_geocoded = $response->geometry->location->lng;
								}

							}
						}

					}

					// If geocoded latitude and longitude are retrieved, save them into meta
					if ( ! empty( $latitude_geocoded ) && ! empty( $longitude_geocoded ) ) {

						// Save geocoded latitude & longitude to term meta var
						$map_meta['latlong_geocoded'] = sanitize_text_field( $latitude_geocoded . ',' . $longitude_geocoded );

						// Copy the accurate_address into address_geocoded meta var to prevent unnecesarry requests
						// if the listing will be saved without address changing in the future
						$map_meta['address_geocoded'] = sanitize_text_field( $address_saved );

					}

				}

			}

			// If locating method is not set to 'address' or accurate address is blank, remove geocoded meta values from meta
			else {

				if ( is_array( $map_meta ) && array_key_exists( 'latlong_geocoded', $map_meta ) ) {
					unset( $map_meta['latlong_geocoded'] );
				}
				if ( is_array( $map_meta ) && array_key_exists( 'address_geocoded', $map_meta ) ) {
					unset( $map_meta['address_geocoded'] );
				}

			}

			// Save meta to options table
			if ( ! empty( $map_meta ) ) {
				update_option( 'lsvr_townpress_header_map_meta', $map_meta );
			}

		}

	}
}

?>