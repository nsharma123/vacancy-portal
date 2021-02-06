<?php
/**
 * Plugin Name: LSVR Galleries
 * Description: Adds Gallery custom post type
 * Version: 1.4.1
 * Author: LSVRthemes
 * Author URI: http://themeforest.net/user/LSVRthemes/portfolio
 * Text Domain: lsvr-galleries
 * Domain Path: /languages
 * License: http://themeforest.net/licenses
 * License URI: http://themeforest.net/licenses
*/

// Include additional functions and classes
require_once( 'inc/classes/lsvr-cpt.php' );
require_once( 'inc/classes/lsvr-cpt-gallery.php' );
require_once( 'inc/classes/lsvr-permalink-settings.php' );
require_once( 'inc/classes/lsvr-permalink-settings-galleries.php' );
require_once( 'inc/core-functions.php' );
require_once( 'inc/blocks-config.php' );
require_once( 'inc/vc-config.php' );

// Load textdomain
load_plugin_textdomain( 'lsvr-galleries', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );

// Register Gallery CPT
if ( class_exists( 'Lsvr_CPT_Gallery' ) ) {

	// Register CPT on plugin activation
	if ( ! function_exists( 'lsvr_galleries_activate_register_gallery_cpt' ) ) {
		function lsvr_galleries_activate_register_gallery_cpt() {
			$lsvr_gallery_cpt = new Lsvr_CPT_Gallery();
			$lsvr_gallery_cpt->activate_cpt();
		}
	}
	register_activation_hook( __FILE__, 'lsvr_galleries_activate_register_gallery_cpt' );

	// Register CPT
	$lsvr_gallery_cpt = new Lsvr_CPT_Gallery();

}

// Add permalink settings
if ( class_exists( 'Lsvr_Permalink_Settings_Galleries' ) ) {
	$permalink_settings = new Lsvr_Permalink_Settings_Galleries();
}

// Register widgets
add_action( 'widgets_init', 'lsvr_galleries_register_widgets' );
if ( ! function_exists( 'lsvr_galleries_register_widgets' ) ) {
	function lsvr_galleries_register_widgets() {

		// Gallery list
		require_once( 'inc/classes/widgets/lsvr-widget-gallery-list.php' );
		if ( class_exists( 'Lsvr_Widget_Gallery_List' ) ) {
			register_widget( 'Lsvr_Widget_Gallery_List' );
		}

		// Featured gallery
		require_once( 'inc/classes/widgets/lsvr-widget-gallery-featured.php' );
		if ( class_exists( 'Lsvr_Widget_Gallery_Featured' ) ) {
			register_widget( 'Lsvr_Widget_Gallery_Featured' );
		}

		// Gallery categories
		require_once( 'inc/classes/widgets/lsvr-widget-gallery-categories.php' );
		if ( class_exists( 'Lsvr_Widget_Gallery_Categories' ) ) {
			register_widget( 'Lsvr_Widget_Gallery_Categories' );
		}

	}
}

// Register shortcodes
add_action( 'init', 'lsvr_galleries_register_shortcodes' );
if ( ! function_exists( 'lsvr_galleries_register_shortcodes' ) ) {
	function lsvr_galleries_register_shortcodes() {

    	// Gallery List Widget
		require_once( 'inc/classes/shortcodes/lsvr-shortcode-gallery-list-widget.php' );
		if ( class_exists( 'Lsvr_Shortcode_Gallery_List_Widget' ) ) {
			add_shortcode( 'lsvr_gallery_list_widget', array( 'Lsvr_Shortcode_Gallery_List_Widget', 'shortcode' ) );
		}

    	// Featured Gallery Widget
		require_once( 'inc/classes/shortcodes/lsvr-shortcode-gallery-featured-widget.php' );
		if ( class_exists( 'Lsvr_Shortcode_Gallery_Featured_Widget' ) ) {
			add_shortcode( 'lsvr_gallery_featured_widget', array( 'Lsvr_Shortcode_Gallery_Featured_Widget', 'shortcode' ) );
		}

	}
}

?>