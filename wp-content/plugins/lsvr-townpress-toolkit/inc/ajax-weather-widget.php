<?php

/**
 * Function fired during AJAX request to display weather.
 *
 * @return json 	JSON with all listings data required to display the weather.
 */

add_action( 'wp_ajax_nopriv_lsvr-townpress-toolkit-ajax-weather-widget', 'lsvr_townpress_toolkit_ajax_weather_widget' );
add_action( 'wp_ajax_lsvr-townpress-toolkit-ajax-weather-widget', 'lsvr_townpress_toolkit_ajax_weather_widget' );
if ( ! function_exists( 'lsvr_townpress_toolkit_ajax_weather_widget' ) ) {
	function lsvr_townpress_toolkit_ajax_weather_widget() {

		// Test nonce
		$nonce = ! empty( $_POST['nonce'] ) ? $_POST['nonce'] : false;
		if ( ! wp_verify_nonce( $nonce, 'lsvr-townpress-toolkit-ajax-weather-widget-nonce' ) ) {
			die ( esc_html__( 'You do not have permission to access this data', 'lsvr-townpress-toolkit' ) );
		}

		// Parse listings to retrieve required data
		if ( ! empty( $_POST['data'] ) ) {

			$args = (array) $_POST['data'];
			$api_key = get_theme_mod( 'openweathermap_api_key' );
			$address = ! empty( $args['address'] ) ? $args['address'] : '';
			$latitude = ! empty( $args['latitude'] ) ? $args['latitude'] : '';
			$longitude = ! empty( $args['longitude'] ) ? $args['longitude'] : '';
			$forecast_length = ! empty( $args['forecast_length'] ) ? intval( $args['forecast_length'] ) : 3;
			$units_format = ! empty( $args['units_format'] ) ? $args['units_format'] : 'metric';
			$update_interval = ! empty( $args['update_interval'] ) ? $args['update_interval'] : '1hour';
			$weather_response = array();
			$args_hash = 'lsvr_townpress_weather_widget_t_' . md5( serialize( $args ) );
			$transient = 'disable' !== $update_interval ? get_transient( $args_hash ) : false;

			// Prepare URL params
			if ( ! empty( $latitude ) && ! empty( $longitude ) ) {
				$url_params = 'lat=' . urlencode( $latitude ) . '&lon=' . urlencode( $longitude );
			} else if ( ! empty( $address ) ) {
				$url_params = 'q=' . urlencode( $address );
			}
			if ( ! empty( $url_params ) && ! empty( $api_key ) ) {
				$url_params .= '&units=' . urlencode( $units_format ) . '&APPID=' . urlencode( $api_key );
			}

			// Check for cached data
			if ( 'disable' !== $update_interval && ! empty( $transient ) ) {
				$weather_response = $transient;
			}

			// Retrieve fresh data
			else {

				// Get current weather
				if ( ! empty( $url_params ) ) {

					$current_url = 'http://api.openweathermap.org/data/2.5/weather?' . $url_params;
					$current_json = @wp_remote_request( $current_url );

					if ( is_array( $current_json ) && array_key_exists( 'body', $current_json ) ) {
						$weather_response['current'] = json_decode( $current_json['body'] );
					}

				}

				// Get forecast
				if ( ! empty( $url_params ) && $forecast_length > 0 ) {

					$forecast_url = 'http://api.openweathermap.org/data/2.5/forecast?' . $url_params;
					$forecast_json = @wp_remote_request( $forecast_url );

					if ( is_array( $forecast_json ) && array_key_exists( 'body', $forecast_json ) ) {
						$weather_response['forecast'] = json_decode( $forecast_json['body'] );
					}

				}

				// Save cache
				if ( '10min' === $update_interval ) {
					$expiration_time = 60 * 10;
				} else if ( '30min' === $update_interval ) {
					$expiration_time = 60 * 30;
				} else if ( '1hour' === $update_interval ) {
					$expiration_time = 60 * 60;
				} else if ( '3hours' === $update_interval ) {
					$expiration_time = 60 * 60 * 3;
				} else if ( '12hours' === $update_interval ) {
					$expiration_time = 60 * 60 * 12;
				} else if ( '24hours' === $update_interval ) {
					$expiration_time = 60 * 60 * 24;
				} else {
					$expiration_time = 60 * 30;
				}
				set_transient( $args_hash, $weather_response, $expiration_time );

			}

			// Convert listings data to JSON
			if ( ! empty( $weather_response ) ) {
				echo json_encode( $weather_response );
			} else {
				echo json_encode( array( 'error' => esc_html__( 'No response', 'lsvr-townpress-toolkit' ) ) );
			}

		} else {
			echo json_encode( array( 'error' => esc_html__( 'Missing data', 'lsvr-townpress-toolkit' ) ) );
		}

		wp_die();

	}
}

?>