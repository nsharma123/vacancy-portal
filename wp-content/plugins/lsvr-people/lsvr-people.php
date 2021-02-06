<?php
/**
 * Plugin Name: LSVR People
 * Description: Adds Person custom post type
 * Version: 1.4.1
 * Author: LSVRthemes
 * Author URI: http://themeforest.net/user/LSVRthemes/portfolio
 * Text Domain: lsvr-people
 * Domain Path: /languages
 * License: http://themeforest.net/licenses
 * License URI: http://themeforest.net/licenses
*/

// Include additional functions and classes
require_once( 'inc/classes/lsvr-cpt.php' );
require_once( 'inc/classes/lsvr-cpt-person.php' );
require_once( 'inc/classes/lsvr-permalink-settings.php' );
require_once( 'inc/classes/lsvr-permalink-settings-people.php' );
require_once( 'inc/core-functions.php' );
require_once( 'inc/blocks-config.php' );
require_once( 'inc/vc-config.php' );

// Load textdomain
load_plugin_textdomain( 'lsvr-people', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );

// Register Person CPT
if ( class_exists( 'Lsvr_CPT_Person' ) ) {

	// Register CPT on plugin activation
	if ( ! function_exists( 'lsvr_people_activate_register_person_cpt' ) ) {
		function lsvr_people_activate_register_person_cpt() {
			$lsvr_person_cpt = new Lsvr_CPT_Person();
			$lsvr_person_cpt->activate_cpt();
		}
	}
	register_activation_hook( __FILE__, 'lsvr_people_activate_register_person_cpt' );

	// Register CPT
	$lsvr_person_cpt = new Lsvr_CPT_Person();

}

// Add permalink settings
if ( class_exists( 'Lsvr_Permalink_Settings_People' ) ) {
	$permalink_settings = new Lsvr_Permalink_Settings_People();
}

// Register widgets
add_action( 'widgets_init', 'lsvr_people_register_widgets' );
if ( ! function_exists( 'lsvr_people_register_widgets' ) ) {
	function lsvr_people_register_widgets() {

		// Person categories
		require_once( 'inc/classes/widgets/lsvr-widget-person-categories.php' );
		if ( class_exists( 'Lsvr_Widget_Person_Categories' ) ) {
			register_widget( 'Lsvr_Widget_Person_Categories' );
		}

		// Featured person
		require_once( 'inc/classes/widgets/lsvr-widget-person-featured.php' );
		if ( class_exists( 'Lsvr_Widget_Person_Featured' ) ) {
			register_widget( 'Lsvr_Widget_Person_Featured' );
		}

		// Person list
		require_once( 'inc/classes/widgets/lsvr-widget-person-list.php' );
		if ( class_exists( 'Lsvr_Widget_Person_List' ) ) {
			register_widget( 'Lsvr_Widget_Person_List' );
		}

	}
}

// Register shortcodes
add_action( 'init', 'lsvr_people_register_shortcodes' );
if ( ! function_exists( 'lsvr_people_register_shortcodes' ) ) {
	function lsvr_people_register_shortcodes() {

    	// Person List Widget
		require_once( 'inc/classes/shortcodes/lsvr-shortcode-person-list-widget.php' );
		if ( class_exists( 'Lsvr_Shortcode_Person_List_Widget' ) ) {
			add_shortcode( 'lsvr_person_list_widget', array( 'Lsvr_Shortcode_Person_List_Widget', 'shortcode' ) );
		}

    	// Featured Person Widget
		require_once( 'inc/classes/shortcodes/lsvr-shortcode-person-featured-widget.php' );
		if ( class_exists( 'Lsvr_Shortcode_Person_Featured_Widget' ) ) {
			add_shortcode( 'lsvr_person_featured_widget', array( 'Lsvr_Shortcode_Person_Featured_Widget', 'shortcode' ) );
		}

	}
}

?>