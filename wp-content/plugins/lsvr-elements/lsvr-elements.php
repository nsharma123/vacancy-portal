<?php
/**
 * Plugin Name: LSVR Elements
 * Description: Set of various LSVR elements
 * Version: 1.2.2
 * Author: LSVRthemes
 * Author URI: http://themeforest.net/user/LSVRthemes/portfolio
 * Text Domain: lsvr-elements
 * Domain Path: /languages
 * License: http://themeforest.net/licenses
 * License URI: http://themeforest.net/licenses
*/

// Include additional functions and classes
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
require_once( 'inc/blocks-config.php' );
require_once( 'inc/vc-config.php' );

// Load textdomain
load_plugin_textdomain( 'lsvr-elements', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );

// Register widgets
add_action( 'widgets_init', 'lsvr_elements_register_widgets' );
if ( ! function_exists( 'lsvr_elements_register_widgets' ) ) {
	function lsvr_elements_register_widgets() {

		// Definition list
		require_once( 'inc/classes/widgets/lsvr-widget-definition-list.php' );
		if ( class_exists( 'Lsvr_Widget_Definition_List' ) ) {
			register_widget( 'Lsvr_Widget_Definition_List' );
		}

		// Post list
		require_once( 'inc/classes/widgets/lsvr-widget-post-list.php' );
		if ( class_exists( 'Lsvr_Widget_Post_List' ) ) {
			register_widget( 'Lsvr_Widget_Post_List' );
		}

		// Featured post
		require_once( 'inc/classes/widgets/lsvr-widget-post-featured.php' );
		if ( class_exists( 'Lsvr_Widget_Post_Featured' ) ) {
			register_widget( 'Lsvr_Widget_Post_Featured' );
		}

	}
}

// Register shortcodes
add_action( 'init', 'lsvr_elements_register_shortcodes' );
if ( ! function_exists( 'lsvr_elements_register_shortcodes' ) ) {
	function lsvr_elements_register_shortcodes() {

    	// Alert message
		require_once( 'inc/classes/shortcodes/lsvr-shortcode-alert-message.php' );
		if ( class_exists( 'Lsvr_Shortcode_Alert_Message' ) ) {
			add_shortcode( 'lsvr_alert_message', array( 'Lsvr_Shortcode_Alert_Message', 'shortcode' ) );
		}

    	// Button
		require_once( 'inc/classes/shortcodes/lsvr-shortcode-button.php' );
		if ( class_exists( 'Lsvr_Shortcode_Button' ) ) {
			add_shortcode( 'lsvr_button', array( 'Lsvr_Shortcode_Button', 'shortcode' ) );
		}

    	// Counter
		require_once( 'inc/classes/shortcodes/lsvr-shortcode-counter.php' );
		if ( class_exists( 'Lsvr_Shortcode_Counter' ) ) {
			add_shortcode( 'lsvr_counter', array( 'Lsvr_Shortcode_Counter', 'shortcode' ) );
		}

    	// CTA
		require_once( 'inc/classes/shortcodes/lsvr-shortcode-cta.php' );
		if ( class_exists( 'Lsvr_Shortcode_CTA' ) ) {
			add_shortcode( 'lsvr_cta', array( 'Lsvr_Shortcode_CTA', 'shortcode' ) );
		}

    	// Definition list
		require_once( 'inc/classes/shortcodes/lsvr-shortcode-definition-list-widget.php' );
		if ( class_exists( 'Lsvr_Shortcode_Definition_list_Widget' ) ) {
			add_shortcode( 'lsvr_definition_list_widget', array( 'Lsvr_Shortcode_Definition_list_Widget', 'shortcode' ) );
		}

    	// Feature
		require_once( 'inc/classes/shortcodes/lsvr-shortcode-feature.php' );
		if ( class_exists( 'Lsvr_Shortcode_Feature' ) ) {
			add_shortcode( 'lsvr_feature', array( 'Lsvr_Shortcode_Feature', 'shortcode' ) );
		}

    	// Featured post
		require_once( 'inc/classes/shortcodes/lsvr-shortcode-post-featured-widget.php' );
		if ( class_exists( 'Lsvr_Shortcode_Post_Featured_Widget' ) ) {
			add_shortcode( 'lsvr_post_featured_widget', array( 'Lsvr_Shortcode_Post_Featured_Widget', 'shortcode' ) );
		}

    	// Icon
		require_once( 'inc/classes/shortcodes/lsvr-shortcode-icon.php' );
		if ( class_exists( 'Lsvr_Shortcode_Icon' ) ) {
			add_shortcode( 'lsvr_icon', array( 'Lsvr_Shortcode_Icon', 'shortcode' ) );
		}

    	// Post list
		require_once( 'inc/classes/shortcodes/lsvr-shortcode-post-list-widget.php' );
		if ( class_exists( 'Lsvr_Shortcode_Post_List_Widget' ) ) {
			add_shortcode( 'lsvr_post_list_widget', array( 'Lsvr_Shortcode_Post_List_Widget', 'shortcode' ) );
		}

    	// Pricing table
		require_once( 'inc/classes/shortcodes/lsvr-shortcode-pricing-table.php' );
		if ( class_exists( 'Lsvr_Shortcode_Pricing_Table' ) ) {
			add_shortcode( 'lsvr_pricing_table', array( 'Lsvr_Shortcode_Pricing_Table', 'shortcode' ) );
		}

    	// Progress bar
		require_once( 'inc/classes/shortcodes/lsvr-shortcode-progress-bar.php' );
		if ( class_exists( 'Lsvr_Shortcode_Progress_Bar' ) ) {
			add_shortcode( 'lsvr_progress_bar', array( 'Lsvr_Shortcode_Progress_Bar', 'shortcode' ) );
		}

	}
}

?>