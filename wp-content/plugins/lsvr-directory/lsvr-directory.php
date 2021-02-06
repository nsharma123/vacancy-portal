<?php
/**
 * Plugin Name: LSVR Directory
 * Description: Adds Listing custom post type
 * Version: 1.4.2
 * Author: LSVRthemes
 * Author URI: http://themeforest.net/user/LSVRthemes/portfolio
 * Text Domain: lsvr-directory
 * Domain Path: /languages
 * License: http://themeforest.net/licenses
 * License URI: http://themeforest.net/licenses
*/

// Include additional functions and classes
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
require_once( 'inc/classes/lsvr-cpt.php' );
require_once( 'inc/classes/lsvr-cpt-listing.php' );
require_once( 'inc/classes/lsvr-permalink-settings.php' );
require_once( 'inc/classes/lsvr-permalink-settings-directory.php' );
require_once( 'inc/core-functions.php' );
require_once( 'inc/blocks-config.php' );
require_once( 'inc/vc-config.php' );

// Include additional functions and classes for admin only
if ( is_admin() ) {
	require_once( 'inc/geocode-listing.php' );
}

// Load textdomain
load_plugin_textdomain( 'lsvr-directory', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );

// Register Listing CPT
if ( class_exists( 'Lsvr_CPT_Listing' ) ) {

	// Register CPT on plugin activation
	if ( ! function_exists( 'lsvr_directory_activate_register_listing_cpt' ) ) {
		function lsvr_directory_activate_register_listing_cpt() {
			$lsvr_listing_cpt = new Lsvr_CPT_Listing();
			$lsvr_listing_cpt->activate_cpt();
		}
	}
	register_activation_hook( __FILE__, 'lsvr_directory_activate_register_listing_cpt' );

	// Register CPT
	$lsvr_listing_cpt = new Lsvr_CPT_Listing();

}

// Add permalink settings
if ( class_exists( 'Lsvr_Permalink_Settings_Directory' ) ) {
	$permalink_settings = new Lsvr_Permalink_Settings_Directory();
}

// Register widgets
add_action( 'widgets_init', 'lsvr_directory_register_widgets' );
if ( ! function_exists( 'lsvr_directory_register_widgets' ) ) {
	function lsvr_directory_register_widgets() {

		// Listing categories
		require_once( 'inc/classes/widgets/lsvr-widget-listing-categories.php' );
		if ( class_exists( 'Lsvr_Widget_Listing_Categories' ) ) {
			register_widget( 'Lsvr_Widget_Listing_Categories' );
		}

		// Featured listing
		require_once( 'inc/classes/widgets/lsvr-widget-listing-featured.php' );
		if ( class_exists( 'Lsvr_Widget_Listing_Featured' ) ) {
			register_widget( 'Lsvr_Widget_Listing_Featured' );
		}

		// Listing list
		require_once( 'inc/classes/widgets/lsvr-widget-listing-list.php' );
		if ( class_exists( 'Lsvr_Widget_Listing_List' ) ) {
			register_widget( 'Lsvr_Widget_Listing_List' );
		}

	}
}

// Register shortcodes
add_action( 'init', 'lsvr_directory_register_shortcodes' );
if ( ! function_exists( 'lsvr_directory_register_shortcodes' ) ) {
	function lsvr_directory_register_shortcodes() {

    	// Listing List Widget
		require_once( 'inc/classes/shortcodes/lsvr-shortcode-listing-list-widget.php' );
		if ( class_exists( 'Lsvr_Shortcode_Listing_List_Widget' ) ) {
			add_shortcode( 'lsvr_listing_list_widget', array( 'Lsvr_Shortcode_Listing_List_Widget', 'shortcode' ) );
		}

    	// Featured Listing Widget
		require_once( 'inc/classes/shortcodes/lsvr-shortcode-listing-featured-widget.php' );
		if ( class_exists( 'Lsvr_Shortcode_Listing_Featured_Widget' ) ) {
			add_shortcode( 'lsvr_listing_featured_widget', array( 'Lsvr_Shortcode_Listing_Featured_Widget', 'shortcode' ) );
		}

	}
}

?>