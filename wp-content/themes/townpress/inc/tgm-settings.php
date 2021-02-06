<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme TownPress for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/inc/classes/class-tgm-plugin-activation.php';

/**
 * Register the required plugins for this theme.
 */
add_action( 'tgmpa_register', 'lsvr_townpress_register_required_plugins' );
if ( ! function_exists( 'lsvr_townpress_register_required_plugins' ) ) {
	function lsvr_townpress_register_required_plugins() {
		/*
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(

			// LSVR TownPress Toolkit
			array(
				'name' => 'LSVR TownPress Toolkit',
				'slug' => 'lsvr-townpress-toolkit',
				'source' => get_template_directory() . '/inc/plugins/lsvr-townpress-toolkit.zip',
				'required' => false,
				'version' => '1.3.0',
			),

			// LSVR Framework
			array(
				'name' => 'LSVR Framework',
				'slug' => 'lsvr-framework',
				'source' => get_template_directory() . '/inc/plugins/lsvr-framework.zip',
				'required' => false,
				'version' => '1.4.0',
			),

			// LSVR Elements
			array(
				'name' => 'LSVR Elements',
				'slug' => 'lsvr-elements',
				'source' => get_template_directory() . '/inc/plugins/lsvr-elements.zip',
				'required' => false,
				'version' => '1.2.2',
			),

			// LSVR Notices
			array(
				'name' => 'LSVR Notices',
				'slug' => 'lsvr-notices',
				'source' => get_template_directory() . '/inc/plugins/lsvr-notices.zip',
				'required' => false,
				'version' => '1.3.1',
			),

			// LSVR Directory
			array(
				'name' => 'LSVR Directory',
				'slug' => 'lsvr-directory',
				'source' => get_template_directory() . '/inc/plugins/lsvr-directory.zip',
				'required' => false,
				'version' => '1.4.2',
			),

			// LSVR Events
			array(
				'name' => 'LSVR Events',
				'slug' => 'lsvr-events',
				'source' => get_template_directory() . '/inc/plugins/lsvr-events.zip',
				'required' => false,
				'version' => '1.5.2',
			),

			// LSVR Galleries
			array(
				'name' => 'LSVR Galleries',
				'slug' => 'lsvr-galleries',
				'source' => get_template_directory() . '/inc/plugins/lsvr-galleries.zip',
				'required' => false,
				'version' => '1.4.1',
			),

			// LSVR Documents
			array(
				'name' => 'LSVR Documents',
				'slug' => 'lsvr-documents',
				'source' => get_template_directory() . '/inc/plugins/lsvr-documents.zip',
				'required' => false,
				'version' => '1.4.1',
			),

			// LSVR People
			array(
				'name' => 'LSVR People',
				'slug' => 'lsvr-people',
				'source' => get_template_directory() . '/inc/plugins/lsvr-people.zip',
				'required' => false,
				'version' => '1.4.1',
			),

			// Envato Market
			array(
				'name' => 'Envato Market',
				'slug' => 'envato-market',
				'source' => get_template_directory() . '/inc/plugins/envato-market.zip',
				'required' => false,
				'version' => '2.0.0',
			),

		);

		/*
		 * Array of configuration settings. Amend each line as needed.
		 *
		 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
		 * strings available, please help us make TGMPA even better by giving us access to these translations or by
		 * sending in a pull-request with .po file(s) with the translations.
		 *
		 * Only uncomment the strings in the config array if you want to customize the strings.
		 */
		$config = array(
			'id'           => 'townpress',                 // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.

			'strings'      => array(
				'page_title'                      => esc_html__( 'Install Required Plugins', 'townpress' ),
				'menu_title'                      => esc_html__( 'Install Plugins', 'townpress' ),
				'installing'                      => esc_html__( 'Installing Plugin: %s', 'townpress' ),
				'updating'                        => esc_html__( 'Updating Plugin: %s', 'townpress' ),
				'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'townpress' ),
				'notice_can_install_required'     => _n_noop(
					'This theme requires the following plugin: %1$s.',
					'This theme requires the following plugins: %1$s.',
					'townpress'
				),
				'notice_can_install_recommended'  => _n_noop(
					'This theme recommends the following plugin: %1$s.',
					'This theme recommends the following plugins: %1$s.',
					'townpress'
				),
				'notice_ask_to_update'            => _n_noop(
					'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
					'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
					'townpress'
				),
				'notice_ask_to_update_maybe'      => _n_noop(
					'There is an update available for: %1$s.',
					'There are updates available for the following plugins: %1$s.',
					'townpress'
				),
				'notice_can_activate_required'    => _n_noop(
					'The following required plugin is currently inactive: %1$s.',
					'The following required plugins are currently inactive: %1$s.',
					'townpress'
				),
				'notice_can_activate_recommended' => _n_noop(
					'The following recommended plugin is currently inactive: %1$s.',
					'The following recommended plugins are currently inactive: %1$s.',
					'townpress'
				),
				'install_link'                    => _n_noop(
					'Begin installing plugin',
					'Begin installing plugins',
					'townpress'
				),
				'update_link' 					  => _n_noop(
					'Begin updating plugin',
					'Begin updating plugins',
					'townpress'
				),
				'activate_link'                   => _n_noop(
					'Begin activating plugin',
					'Begin activating plugins',
					'townpress'
				),
				'return'                          => esc_html__( 'Return to Required Plugins Installer', 'townpress' ),
				'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'townpress' ),
				'activated_successfully'          => esc_html__( 'The following plugin was activated successfully:', 'townpress' ),
				'plugin_already_active'           => esc_html__( 'No action taken. Plugin %1$s was already active.', 'townpress' ),
				'plugin_needs_higher_version'     => esc_html__( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'townpress' ),
				'complete'                        => esc_html__( 'All plugins installed and activated successfully. %1$s', 'townpress' ),
				'dismiss'                         => esc_html__( 'Dismiss this notice', 'townpress' ),
				'notice_cannot_install_activate'  => esc_html__( 'There are one or more required or recommended plugins to install, update or activate.', 'townpress' ),
				'contact_admin'                   => esc_html__( 'Please contact the administrator of this site for help.', 'townpress' ),
				'nag_type'                        => '',
			),
		);

		tgmpa( $plugins, $config );
	}
}