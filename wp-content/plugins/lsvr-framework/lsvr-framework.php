<?php
/**
 * Plugin Name: LSVR Framework
 * Description: Framework for LSVR themes and plugins
 * Version: 1.4.0
 * Author: LSVRthemes
 * Author URI: http://themeforest.net/user/LSVRthemes/portfolio
 * Text Domain: lsvr-framework
 * Domain Path: /languages
 * License: http://themeforest.net/licenses
 * License URI: http://themeforest.net/licenses
*/

// Include additional functions and classes
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
require_once( 'inc/core-functions.php' );
require_once( 'inc/blocks-config.php' );
require_once( 'inc/classes/lsvr-widget.php' );
if ( is_admin() ) {

	// Post Metaboxes
	require_once( 'inc/classes/lsvr-post-metabox.php' );
	require_once( 'inc/classes/lsvr-post-metafield.php' );
	require_once( 'inc/classes/post-metafields/lsvr-post-metafield-attachment.php' );
	require_once( 'inc/classes/post-metafields/lsvr-post-metafield-checkbox.php' );
	require_once( 'inc/classes/post-metafields/lsvr-post-metafield-date.php' );
	require_once( 'inc/classes/post-metafields/lsvr-post-metafield-datetime.php' );
	require_once( 'inc/classes/post-metafields/lsvr-post-metafield-external-attachment.php' );
	require_once( 'inc/classes/post-metafields/lsvr-post-metafield-gallery.php' );
	require_once( 'inc/classes/post-metafields/lsvr-post-metafield-opening-hours.php' );
	require_once( 'inc/classes/post-metafields/lsvr-post-metafield-radio.php' );
	require_once( 'inc/classes/post-metafields/lsvr-post-metafield-select.php' );
	require_once( 'inc/classes/post-metafields/lsvr-post-metafield-slider.php' );
	require_once( 'inc/classes/post-metafields/lsvr-post-metafield-separator.php' );
	require_once( 'inc/classes/post-metafields/lsvr-post-metafield-switch.php' );
	require_once( 'inc/classes/post-metafields/lsvr-post-metafield-taxonomy.php' );
	require_once( 'inc/classes/post-metafields/lsvr-post-metafield-taxonomy-assign.php' );
	require_once( 'inc/classes/post-metafields/lsvr-post-metafield-text.php' );
	require_once( 'inc/classes/post-metafields/lsvr-post-metafield-textarea.php' );

	// Taxonomy Metaboxes
	require_once( 'inc/classes/lsvr-tax-metabox.php' );
	require_once( 'inc/classes/lsvr-tax-metafield.php' );
	require_once( 'inc/classes/tax-metafields/lsvr-tax-metafield-image.php' );
	require_once( 'inc/classes/tax-metafields/lsvr-tax-metafield-select.php' );
	require_once( 'inc/classes/tax-metafields/lsvr-tax-metafield-text.php' );
	require_once( 'inc/classes/tax-metafields/lsvr-tax-metafield-textarea.php' );

	// Widget Fields
	require_once( 'inc/classes/lsvr-widget-field.php' );
	require_once( 'inc/classes/widget-fields/lsvr-widget-field-checkbox.php' );
	require_once( 'inc/classes/widget-fields/lsvr-widget-field-image.php' );
	require_once( 'inc/classes/widget-fields/lsvr-widget-field-info.php' );
	require_once( 'inc/classes/widget-fields/lsvr-widget-field-post.php' );
	require_once( 'inc/classes/widget-fields/lsvr-widget-field-select.php' );
	require_once( 'inc/classes/widget-fields/lsvr-widget-field-taxonomy.php' );
	require_once( 'inc/classes/widget-fields/lsvr-widget-field-text.php' );
	require_once( 'inc/classes/widget-fields/lsvr-widget-field-textarea.php' );

}

// Include Customizer controls
add_action( 'customize_register', 'lsvr_framework_customize_register' );
if ( ! function_exists( 'lsvr_framework_customize_register' ) ) {
  function lsvr_framework_customize_register( $wp_customize ) {
		require_once( 'inc/classes/lsvr-customizer.php' );
		require_once( 'inc/classes/customizer-controls/lsvr-customize-control-sidebars.php' );
		require_once( 'inc/classes/customizer-controls/lsvr-customize-control-info.php' );
		require_once( 'inc/classes/customizer-controls/lsvr-customize-control-multicheck.php' );
		require_once( 'inc/classes/customizer-controls/lsvr-customize-control-separator.php' );
		require_once( 'inc/classes/customizer-controls/lsvr-customize-control-slider.php' );
		require_once( 'inc/classes/customizer-controls/lsvr-customize-control-social-links.php' );
	}
}

// Load textdomain
load_plugin_textdomain( 'lsvr-framework', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );

// Load admin CSS & JS
add_action( 'admin_enqueue_scripts', 'lsvr_framework_load_assets' );
if ( ! function_exists( 'lsvr_framework_load_assets' ) ) {
	function lsvr_framework_load_assets() {

		global $pagenow, $typenow;

		// Get plugin version
		$plugin_data = get_plugin_data( __FILE__ );
		$plugin_version = ! empty( $plugin_data['Version'] ) ? $plugin_data['Version'] : false;

		// Load resources for post metaboxes on non-gutenberg pages
		if ( ( 'post.php' === $pagenow || 'post-new.php' === $pagenow ) && true === apply_filters( 'lsvr_framework_gutenberg_is_disabled', false ) ) {

			// Required libraries
			wp_enqueue_media();
			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_script( 'jquery-ui-slider' );
			wp_enqueue_script( 'jquery-ui-sortable' );

			// Metaboxes admin styles
			wp_enqueue_style(
				'lsvr-framework-metaboxes-styles',
				plugin_dir_url( __FILE__ ) . 'assets/css/lsvr-framework-metaboxes.admin.css',
				false,
				$plugin_version
			);

			// Metaboxes admin scripts
			wp_enqueue_script(
				'lsvr-framework-metaboxes-scripts',
				plugin_dir_url( __FILE__ ) . 'assets/js/lsvr-framework-metaboxes.admin.js',
				array( 'jquery' ),
				$plugin_version
			);

			// RTL version
			if ( is_rtl() ) {
				wp_enqueue_style(
					'lsvr-framework-metaboxes-rtl-styles',
					plugin_dir_url( __FILE__ ) . 'assets/css/lsvr-framework-metaboxes.admin.rtl.css',
					false,
					$plugin_version
				);
			}

  		}

  		// Load resources for widgets
  		else if ( 'widgets.php' === $pagenow ) {

  			wp_enqueue_media();
			wp_enqueue_script( 'media-widgets' );

			// Widget admin styles
			wp_enqueue_style(
				'lsvr-framework-widgets-styles',
				plugin_dir_url( __FILE__ ) . 'assets/css/lsvr-framework-widgets.admin.css',
				false,
				$plugin_version
			);

			// Widget admin scripts
			wp_enqueue_script(
				'lsvr-framework-widgets-scripts',
				plugin_dir_url( __FILE__ ) . 'assets/js/lsvr-framework-widgets.admin.js',
				array( 'jquery' ),
				$plugin_version
			);

		}

  		// Load resources for taxonomies
  		else if ( 'edit-tags.php' === $pagenow || 'term.php' === $pagenow ) {

  			wp_enqueue_media();

  			// Taxonomy admin scripts
  			wp_enqueue_script(
  				'lsvr-framework-taxonomy-scripts',
  				plugin_dir_url( __FILE__ ) . 'assets/js/lsvr-framework-taxonomies.admin.js',
  				array( 'jquery' ),
  				$plugin_version
			);

  		}

	}
}

// Load Customizer CSS & JS
add_action( 'customize_controls_enqueue_scripts', 'lsvr_framework_load_customizer_assets' );
if ( ! function_exists( 'lsvr_framework_load_customizer_assets' ) ) {
	function lsvr_framework_load_customizer_assets() {

		// Get plugin version
		$plugin_data = get_plugin_data( __FILE__ );
		$plugin_version = ! empty( $plugin_data['Version'] ) ? $plugin_data['Version'] : false;

		// Required libraries
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'jquery-ui-slider' );
		wp_enqueue_script( 'jquery-ui-sortable' );

		// Customizer admin styles
		wp_enqueue_style(
			'lsvr-framework-customizer-styles',
			plugin_dir_url( __FILE__ ) . 'assets/css/lsvr-framework-customizer-controls.css',
			false,
			$plugin_version
		);

		// Customizer admin scripts
		wp_enqueue_script(
			'lsvr-framework-customizer-scripts',
			plugin_dir_url( __FILE__ ) . 'assets/js/lsvr-framework-customizer-controls.js',
			array( 'jquery', 'customize-controls' ),
			$plugin_version
		);

		// RTL version
		if ( is_rtl() ) {
			wp_enqueue_style(
				'lsvr-framework-customizer-rtl-styles',
				plugin_dir_url( __FILE__ ) . 'assets/css/lsvr-framework-customizer-controls.rtl.css',
				false,
				$plugin_version
			);
		}

	}
}

// Load Gutenberg CSS & JS
add_action( 'enqueue_block_editor_assets', 'lsvr_framework_load_block_editor_assets' );
if ( ! function_exists( 'lsvr_framework_load_block_editor_assets' ) ) {
	function lsvr_framework_load_block_editor_assets() {

		// Get plugin version
		$plugin_data = get_plugin_data( __FILE__ );
		$plugin_version = ! empty( $plugin_data['Version'] ) ? $plugin_data['Version'] : false;

		// Required libraries
		wp_enqueue_media();
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'jquery-ui-slider' );
		wp_enqueue_script( 'jquery-ui-sortable' );

		// Editor style
		wp_enqueue_style(
			'lsvr-framework-editor-style',
			plugin_dir_url( __FILE__ ) . 'assets/css/lsvr-framework-editor.admin.css',
			false,
			$plugin_version
		);

		// Editor scripts
		wp_enqueue_script(
			'lsvr-framework-editor-scripts',
			plugin_dir_url( __FILE__ ) . 'assets/js/lsvr-framework-editor.admin.js',
			array( 'jquery' ),
			$plugin_version
		);

		// Editor RTL style
		if ( is_rtl() ) {
			wp_enqueue_style(
				'lsvr-framework-editor-rtl-style',
				plugin_dir_url( __FILE__ ) . 'assets/css/lsvr-framework-editor.admin.rtl.css',
				false,
				$plugin_version
			);
		}

		// Shortcode blocks assets
		if ( ! empty( apply_filters( 'lsvr_framework_register_shortcode_blocks_json', '' ) ) ) {

			// Generate dynamic shortcode blocks JSON
			if ( true === apply_filters( 'lsvr_framework_register_dynamic_shortcode_blocks', true ) ) {
				wp_add_inline_script( 'wp-blocks',
					'var lsvrDynamicShortcodeBlocks = ' . json_encode( apply_filters( 'lsvr_framework_register_shortcode_blocks_json', '' ) ) );
			}

			// Generate static shortcode blocks JSON
			else {
				wp_add_inline_script( 'wp-blocks',
					'var lsvrStaticShortcodeBlocks = ' . json_encode( apply_filters( 'lsvr_framework_register_shortcode_blocks_json', '' ) ) );
			}

			// Main shortcode blocks scripts
			wp_enqueue_script(
				'lsvr-framework-shortcode-blocks-scripts',
				plugin_dir_url( __FILE__ ) . 'assets/js/lsvr-framework-shortcode-blocks.admin.js',
				array( 'jquery', 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-editor' ),
				$plugin_version
			);
			wp_localize_script( 'lsvr-framework-shortcode-blocks-scripts', 'lsvr_framework_shortcode_blocks_ajax_var', array(
	    		'url' => admin_url( 'admin-ajax.php' ),
	    		'nonce' => wp_create_nonce( 'lsvr-framework-shortcode-blocks-ajax-nonce' )
			));

		}

	}
}

// Shortcode blocks AJAX
add_action( 'wp_ajax_nopriv_lsvr-framework-shortcode-blocks-ajax', 'lsvr_framework_shortcode_blocks_ajax' );
add_action( 'wp_ajax_lsvr-framework-shortcode-blocks-ajax', 'lsvr_framework_shortcode_blocks_ajax' );
if ( ! function_exists( 'lsvr_framework_shortcode_blocks_ajax' ) ) {
	function lsvr_framework_shortcode_blocks_ajax() {

		$nonce = $_POST['nonce'];
		if ( ! wp_verify_nonce( $nonce, 'lsvr-framework-shortcode-blocks-ajax-nonce' ) ) {
			die ( esc_html__( 'You do not have permission for this action.', 'lsvr-framework' ) );
		}

		if ( isset( $_POST['tag'] ) ) {

			$shortcode_tag = $_POST['tag'];

			// Remove non-shortcode params
			unset( $_POST['nonce'] );
			unset( $_POST['action'] );
			unset( $_POST['tag'] );

			// Generate shortcode
			$attributes = '';
			foreach ( $_POST as $param => $value ) {
				$attributes .= $param . '="' . $value . '" ';
			}

			// Call shortcode
			echo do_shortcode( '[' . $shortcode_tag . ' ' . $attributes . ' editor_view="true"]' );

		}

		wp_die();
	}
}

// Remove wrapping paragraphs
if ( function_exists( 'has_blocks' ) ) {
	remove_filter( 'the_content', 'wpautop' );
}
add_filter( 'the_content', 'lsvr_framework_remove_wpautop' );
if ( ! function_exists( 'lsvr_framework_remove_wpautop' ) ) {
	function lsvr_framework_remove_wpautop( $content ) {

		// Add wpauto to all non Gutenberg pages and posts
		if ( function_exists( 'has_blocks' ) && ! has_blocks( get_the_ID() ) ) {
			$content = wpautop( $content );
		}

		// Remove wrapping paragraphs from shortcode tags
	    $pattern = array(
	        '<p>[lsvr_' => '[lsvr_',
	        ']</p>' => ']',
	        ']<br />' => ']'
	    );

	    return strtr( $content, $pattern );

	}
}

?>