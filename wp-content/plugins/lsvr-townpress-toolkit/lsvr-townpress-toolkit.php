<?php
/**
 * Plugin Name: LSVR TownPress Theme Toolkit
 * Description: Adds theme-specific functionality
 * Version: 1.3.0
 * Author: LSVRthemes
 * Author URI: http://themeforest.net/user/LSVRthemes/portfolio
 * Text Domain: lsvr-townpress-toolkit
 * Domain Path: /languages
 * License: http://themeforest.net/licenses
 * License URI: http://themeforest.net/licenses
*/

// Include additional functions and classes
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
require_once( 'inc/classes/lsvr-townpress-menu-widget-walker.php' );
require_once( 'inc/classes/lsvr-townpress-sitemap-walker.php' );
require_once( 'inc/ajax-weather-widget.php' );
require_once( 'inc/core-functions.php' );
require_once( 'inc/frontend-functions.php' );
require_once( 'inc/blocks-config.php' );
require_once( 'inc/vc-config.php' );

// Load textdomain
load_plugin_textdomain( 'lsvr-townpress-toolkit', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );

// Load CSS & JS
add_action( 'wp_enqueue_scripts', 'lsvr_townpress_toolkit_load_assets' );
if ( ! function_exists( 'lsvr_townpress_toolkit_load_assets' ) ) {
	function lsvr_townpress_toolkit_load_assets() {

		$plugin_data = get_plugin_data( __FILE__ );
		$plugin_version = ! empty( $plugin_data['Version'] ) ? $plugin_data['Version'] : false;
		$suffix = defined( 'WP_DEBUG' ) && true == WP_DEBUG ? '' : '.min';

		if ( apply_filters( 'lsvr_townpress_toolkit_weather_widget_enable', true ) ) {
			wp_enqueue_script( 'lsvr-townpress-toolkit-weather-widget', plugin_dir_url( __FILE__ ) . 'assets/js/lsvr-townpress-toolkit-weather-widget' . $suffix . '.js', array( 'jquery' ), $plugin_version );
			wp_localize_script( 'lsvr-townpress-toolkit-weather-widget', 'lsvr_townpress_toolkit_ajax_weather_widget_var', array(
	    		'url' => admin_url( 'admin-ajax.php' ),
	    		'nonce' => wp_create_nonce( 'lsvr-townpress-toolkit-ajax-weather-widget-nonce' ),
			));
		}

	}
}

// Register widgets
add_action( 'widgets_init', 'lsvr_townpress_toolkit_register_widgets' );
if ( ! function_exists( 'lsvr_townpress_toolkit_register_widgets' ) ) {
	function lsvr_townpress_toolkit_register_widgets() {

		// Menu
		require_once( 'inc/classes/widgets/lsvr-widget-townpress-menu.php' );
		if ( class_exists( 'Lsvr_Widget_Townpress_Menu' ) ) {
			register_widget( 'Lsvr_Widget_Townpress_Menu' );
		}

		// Weather
		require_once( 'inc/classes/widgets/lsvr-widget-townpress-weather.php' );
		if ( class_exists( 'Lsvr_Widget_Townpress_Weather' ) ) {
			register_widget( 'Lsvr_Widget_Townpress_Weather' );
		}

	}
}

// Register shortcodes
add_action( 'init', 'lsvr_townpress_toolkit_register_shortcodes' );
if ( ! function_exists( 'lsvr_townpress_toolkit_register_shortcodes' ) ) {
	function lsvr_townpress_toolkit_register_shortcodes() {

    	// Posts
		require_once( 'inc/classes/shortcodes/lsvr-shortcode-townpress-posts.php' );
		if ( class_exists( 'Lsvr_Shortcode_Townpress_Posts' ) ) {
			add_shortcode( 'lsvr_townpress_posts', array( 'Lsvr_Shortcode_Townpress_Posts', 'shortcode' ) );
		}

    	// Post slider
		require_once( 'inc/classes/shortcodes/lsvr-shortcode-townpress-post-slider.php' );
		if ( class_exists( 'Lsvr_Shortcode_Townpress_Post_Slider' ) ) {
			add_shortcode( 'lsvr_townpress_post_slider', array( 'Lsvr_Shortcode_Townpress_Post_Slider', 'shortcode' ) );
		}

    	// Sitemap
		require_once( 'inc/classes/shortcodes/lsvr-shortcode-townpress-sitemap.php' );
		if ( class_exists( 'Lsvr_Shortcode_Townpress_Sitemap' ) ) {
			add_shortcode( 'lsvr_townpress_sitemap', array( 'Lsvr_Shortcode_Townpress_Sitemap', 'shortcode' ) );
		}

    	// Sidebar
		require_once( 'inc/classes/shortcodes/lsvr-shortcode-townpress-sidebar.php' );
		if ( class_exists( 'Lsvr_Shortcode_Townpress_Sidebar' ) ) {
			add_shortcode( 'lsvr_townpress_sidebar', array( 'Lsvr_Shortcode_Townpress_Sidebar', 'shortcode' ) );
		}

    	// Weather Widget
		require_once( 'inc/classes/shortcodes/lsvr-shortcode-townpress-weather-widget.php' );
		if ( class_exists( 'Lsvr_Shortcode_Townpress_Weather_Widget' ) ) {
			add_shortcode( 'lsvr_townpress_weather_widget', array( 'Lsvr_Shortcode_Townpress_Weather_Widget', 'shortcode' ) );
		}

	}
}

?>