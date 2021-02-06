<?php // Config WPML
add_action( 'plugins_loaded', 'lsvr_events_wpml_config' );
if ( ! function_exists( 'lsvr_events_wpml_config' ) ) {
	function lsvr_events_wpml_config() {

		// Override offset for lsvr_events_get function
		add_filter( 'lsvr_events_get_offset', 'lsvr_events_get_offset_wpml' );
		if ( ! function_exists( 'lsvr_events_get_offset_wpml' ) ) {
			function lsvr_events_get_offset_wpml( $return ) {

				return 0;

			}
		}

		// Override limit for lsvr_events_get function
		add_filter( 'lsvr_events_get_limit', 'lsvr_events_get_limit_wpml' );
		if ( ! function_exists( 'lsvr_events_get_limit_wpml' ) ) {
			function lsvr_events_get_limit_wpml( $return ) {

				return 1000;

			}
		}

		// Remove occurrences of non active language
		add_filter( 'lsvr_events_get_return', 'lsvr_events_get_return_wpml' );
		if ( ! function_exists( 'lsvr_events_get_return_wpml' ) ) {
			function lsvr_events_get_return_wpml( $return ) {

				if ( ! empty( $return[ 'occurrences' ] ) ) {
					foreach ( $return[ 'occurrences' ] as $key => $occurrence ) {

						$post_language_details = apply_filters( 'wpml_post_language_details', NULL, $occurrence['postid'] );
						if ( ! empty( $post_language_details['locale'] )
							&& get_locale() !== $post_language_details['locale'] ) {
							unset( $return[ 'occurrences' ][ $key ] );
						}

					}
				}
				$return[ 'occurrences' ] = array_values( $return[ 'occurrences' ] );

				// Set limit to original value
				$offset = ! empty( $return['meta']['args']['offset'] ) ? $return['meta']['args']['offset'] : 0;
				if ( ! empty( $return['meta']['args']['limit'] ) && count( $return[ 'occurrences' ] ) > $return['meta']['args']['limit'] ) {
					$return[ 'occurrences' ] = array_slice( $return[ 'occurrences' ], $offset, $return['meta']['args']['limit'] );
				}

				return $return;

			}
		}

		// Events Filter widget language
		add_action( 'lsvr_events_filter_widget_form_fields_before', 'lsvr_events_filter_widget_wpml_language' );
		if ( ! function_exists( 'lsvr_events_filter_widget_wpml_language' ) ) {
			function lsvr_events_filter_widget_wpml_language() {
				if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
					echo '<input type="hidden" name="lang" value="' . ICL_LANGUAGE_CODE . '">';
				}
			}
		}

	}
} ?>