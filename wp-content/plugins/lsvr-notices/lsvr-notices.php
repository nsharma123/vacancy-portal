<?php
/**
 * Plugin Name: LSVR Notices
 * Description: Adds Notice custom post type
 * Version: 1.3.1
 * Author: LSVRthemes
 * Author URI: http://themeforest.net/user/LSVRthemes/portfolio
 * Text Domain: lsvr-notices
 * Domain Path: /languages
 * License: http://themeforest.net/licenses
 * License URI: http://themeforest.net/licenses
*/

// Include additional functions and classes
require_once( 'inc/classes/lsvr-cpt.php' );
require_once( 'inc/classes/lsvr-cpt-notice.php' );
require_once( 'inc/classes/lsvr-permalink-settings.php' );
require_once( 'inc/classes/lsvr-permalink-settings-notices.php' );
require_once( 'inc/blocks-config.php' );
require_once( 'inc/vc-config.php' );

// Load textdomain
load_plugin_textdomain( 'lsvr-notices', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );

// Register Notice CPT
if ( class_exists( 'Lsvr_CPT_Notice' ) ) {

	// Register CPT on plugin activation
	if ( ! function_exists( 'lsvr_notices_activate_register_notice_cpt' ) ) {
		function lsvr_notices_activate_register_notice_cpt() {
			$lsvr_notice_cpt = new Lsvr_CPT_Notice();
			$lsvr_notice_cpt->activate_cpt();
		}
	}
	register_activation_hook( __FILE__, 'lsvr_notices_activate_register_notice_cpt' );

	// Register CPT
	$lsvr_notice_cpt = new Lsvr_CPT_Notice();

}

// Add permalink settings
if ( class_exists( 'Lsvr_Permalink_Settings_Notices' ) ) {
	$permalink_settings = new Lsvr_Permalink_Settings_Notices();
}

// Register widgets
add_action( 'widgets_init', 'lsvr_notices_register_widgets' );
if ( ! function_exists( 'lsvr_notices_register_widgets' ) ) {
	function lsvr_notices_register_widgets() {

		// Notice categories
		require_once( 'inc/classes/widgets/lsvr-widget-notice-categories.php' );
		if ( class_exists( 'Lsvr_Widget_Notice_Categories' ) ) {
			register_widget( 'Lsvr_Widget_Notice_Categories' );
		}

		// Notice list
		require_once( 'inc/classes/widgets/lsvr-widget-notice-list.php' );
		if ( class_exists( 'Lsvr_Widget_Notice_List' ) ) {
			register_widget( 'Lsvr_Widget_Notice_List' );
		}

	}
}

// Register shortcodes
add_action( 'init', 'lsvr_notices_register_shortcodes' );
if ( ! function_exists( 'lsvr_notices_register_shortcodes' ) ) {
	function lsvr_notices_register_shortcodes() {

    	// Notice List Widget
		require_once( 'inc/classes/shortcodes/lsvr-shortcode-notice-list-widget.php' );
		if ( class_exists( 'Lsvr_Shortcode_Notice_List_Widget' ) ) {
			add_shortcode( 'lsvr_notice_list_widget', array( 'Lsvr_Shortcode_Notice_List_Widget', 'shortcode' ) );
		}

	}
}

?>