<?php
/**
 * Get event location latitude and longitude from address and save them into meta.
 */
add_action( 'create_lsvr_event_location', 'lsvr_events_geocode_event_location', 100 );
add_action( 'edited_lsvr_event_location', 'lsvr_events_geocode_event_location', 100 );
if ( ! function_exists( 'lsvr_events_geocode_event_location' ) ) {
	function lsvr_events_geocode_event_location( $term_id ) {

		if ( ! empty( $term_id  ) && ! empty( get_theme_mod( 'google_api_key', '' ) ) ) {

			// Get term meta
			$term_meta = get_option( 'lsvr_event_location_term_' . (int) $term_id . '_meta' );

			// Get accurate address from meta
			$accurate_address = ! empty( $term_meta['accurate_address'] ) ? $term_meta['accurate_address'] : false;

			// Get latitude and longitude from meta
			$latlong = ! empty( $term_meta['latlong'] ) ? array_map( 'trim', explode( ',', $term_meta['latlong'] ) ) : false;
			$latlong = 2 === count( $latlong ) ? $latlong : false;

			// Proceed only if accurate address is not blank and latitude and longitude field is either blank or in bad format
			if ( ! empty( $accurate_address ) && empty( $latlong ) ) {

				// Get last geocoded accurate address from meta
				$accurate_address_geocoded = ! empty( $term_meta['accurate_address_geocoded'] ) ? $term_meta['accurate_address_geocoded'] : false;

				// Get geocoded latitude and longitude
				$latlong_geocoded = ! empty( $term_meta['latlong_geocoded'] ) ? $term_meta['latlong_geocoded'] : false;

				// Make sure the address changed from the last geocoding request to avoid unnecessary request
				// or if geocoded latitude and longitude are blank
				if ( ( $accurate_address !== $accurate_address_geocoded ) || empty( $latlong_geocoded ) ) {

					// Prepare query URL
					$query_url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode( esc_html( $accurate_address ) ) . '&key=' . esc_html( get_theme_mod( 'google_api_key', '' ) );

					// Run query
					$response = wp_remote_get( esc_url_raw( $query_url ) );

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
						$term_meta['latlong_geocoded'] = sanitize_text_field( $latitude_geocoded . ', ' . $longitude_geocoded );

						// Copy the accurate_address into accurate_address_geocoded meta var to prevent unnecesarry request
						// if the listing will be saved without address changing in the future
						$term_meta['accurate_address_geocoded'] = sanitize_text_field( $accurate_address );

					}

				}

			}

			// If locating method is not set to 'address' or accurate address is blank, remove geocoded meta values from meta
			else {

				if ( is_array( $term_meta ) && array_key_exists( 'latlong_geocoded', $term_meta ) ) {
					unset( $term_meta['latlong_geocoded'] );
				}
				if ( is_array( $term_meta ) && array_key_exists( 'accurate_address_geocoded', $term_meta ) ) {
					unset( $term_meta['accurate_address_geocoded'] );
				}

			}

			// Save meta to options table
			if ( ! empty( $term_meta ) ) {
				update_option( 'lsvr_event_location_term_' . (int) $term_id . '_meta', $term_meta );
			}

		}

	}
}

?>