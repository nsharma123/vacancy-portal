<?php
/**
 * Plugin Name: LSVR Documents
 * Description: Adds Document custom post type
 * Version: 1.4.1
 * Author: LSVRthemes
 * Author URI: http://themeforest.net/user/LSVRthemes/portfolio
 * Text Domain: lsvr-documents
 * Domain Path: /languages
 * License: http://themeforest.net/licenses
 * License URI: http://themeforest.net/licenses
*/

// Include additional functions and classes
require_once( 'inc/classes/lsvr-cpt.php' );
require_once( 'inc/classes/lsvr-cpt-document.php' );
require_once( 'inc/classes/lsvr-permalink-settings.php' );
require_once( 'inc/classes/lsvr-permalink-settings-documents.php' );
require_once( 'inc/core-functions.php' );
require_once( 'inc/blocks-config.php' );
require_once( 'inc/vc-config.php' );

// Load textdomain
load_plugin_textdomain( 'lsvr-documents', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );

// Register Document CPT
if ( class_exists( 'Lsvr_CPT_Document' ) ) {

	// Register CPT on plugin activation
	if ( ! function_exists( 'lsvr_documents_activate_register_document_cpt' ) ) {
		function lsvr_documents_activate_register_document_cpt() {
			$lsvr_document_cpt = new Lsvr_CPT_Document();
			$lsvr_document_cpt->activate_cpt();
		}
	}
	register_activation_hook( __FILE__, 'lsvr_documents_activate_register_document_cpt' );

	// Register CPT
	$lsvr_document_cpt = new Lsvr_CPT_Document();

}

// Add permalink settings
if ( class_exists( 'Lsvr_Permalink_Settings_Documents' ) ) {
	$permalink_settings = new Lsvr_Permalink_Settings_Documents();
}

// Register widgets
add_action( 'widgets_init', 'lsvr_documents_register_widgets' );
if ( ! function_exists( 'lsvr_documents_register_widgets' ) ) {
	function lsvr_documents_register_widgets() {

		// Document attachments
		require_once( 'inc/classes/widgets/lsvr-widget-document-attachments.php' );
		if ( class_exists( 'Lsvr_Widget_Document_Attachments' ) ) {
			register_widget( 'Lsvr_Widget_Document_Attachments' );
		}

		// Document categories
		require_once( 'inc/classes/widgets/lsvr-widget-document-categories.php' );
		if ( class_exists( 'Lsvr_Widget_Document_Categories' ) ) {
			register_widget( 'Lsvr_Widget_Document_Categories' );
		}

		// Featured document
		require_once( 'inc/classes/widgets/lsvr-widget-document-featured.php' );
		if ( class_exists( 'Lsvr_Widget_Document_Featured' ) ) {
			register_widget( 'Lsvr_Widget_Document_Featured' );
		}

		// Document list
		require_once( 'inc/classes/widgets/lsvr-widget-document-list.php' );
		if ( class_exists( 'Lsvr_Widget_Document_List' ) ) {
			register_widget( 'Lsvr_Widget_Document_List' );
		}

	}
}

// Register shortcodes
add_action( 'init', 'lsvr_documents_register_shortcodes' );
if ( ! function_exists( 'lsvr_documents_register_shortcodes' ) ) {
	function lsvr_documents_register_shortcodes() {

    	// Document List Widget
		require_once( 'inc/classes/shortcodes/lsvr-shortcode-document-list-widget.php' );
		if ( class_exists( 'Lsvr_Shortcode_Document_List_Widget' ) ) {
			add_shortcode( 'lsvr_document_list_widget', array( 'Lsvr_Shortcode_Document_List_Widget', 'shortcode' ) );
		}

    	// Featured Document Widget
		require_once( 'inc/classes/shortcodes/lsvr-shortcode-document-featured-widget.php' );
		if ( class_exists( 'Lsvr_Shortcode_Document_Featured_Widget' ) ) {
			add_shortcode( 'lsvr_document_featured_widget', array( 'Lsvr_Shortcode_Document_Featured_Widget', 'shortcode' ) );
		}

    	// Document Attachments Widget
		require_once( 'inc/classes/shortcodes/lsvr-shortcode-document-attachments-widget.php' );
		if ( class_exists( 'Lsvr_Shortcode_Document_Attachments_Widget' ) ) {
			add_shortcode( 'lsvr_document_attachments_widget', array( 'Lsvr_Shortcode_Document_Attachments_Widget', 'shortcode' ) );
		}

	}
}

?>