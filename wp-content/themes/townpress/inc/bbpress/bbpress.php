<?php

// Include additional files
require_once( get_template_directory() . '/inc/bbpress/actions.php' );
require_once( get_template_directory() . '/inc/bbpress/customizer-config.php' );

// Get bbpress archive title
if ( ! function_exists( 'lsvr_townpress_get_bbpress_archive_title' ) ) {
	function lsvr_townpress_get_bbpress_archive_title() {

		return get_theme_mod( 'lsvr_bbpress_archive_title', esc_html__( 'Forums', 'townpress' ) );

	}
}

?>