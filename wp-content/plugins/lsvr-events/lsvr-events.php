<?php
/**
 * Plugin Name: LSVR Events
 * Description: Adds Event custom post type
 * Version: 1.5.2
 * Author: LSVRthemes
 * Author URI: http://themeforest.net/user/LSVRthemes/portfolio
 * Text Domain: lsvr-events
 * Domain Path: /languages
 * License: http://themeforest.net/licenses
 * License URI: http://themeforest.net/licenses
*/

// Include additional functions and classes
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
require_once( 'inc/classes/lsvr-cpt.php' );
require_once( 'inc/classes/lsvr-cpt-event.php' );
require_once( 'inc/classes/lsvr-permalink-settings.php' );
require_once( 'inc/classes/lsvr-permalink-settings-events.php' );
require_once( 'inc/core-functions.php' );
require_once( 'inc/wpml-config.php' );
require_once( 'inc/blocks-config.php' );
require_once( 'inc/vc-config.php' );

// Include additional functions and classes for admin only
if ( is_admin() ) {
	require_once( 'inc/geocode-event-location.php' );
	require_once( 'inc/event-occurrences.php' );
}

// Load textdomain
load_plugin_textdomain( 'lsvr-events', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );

// Load CSS & JS
add_action( 'wp_enqueue_scripts', 'lsvr_events_load_assets' );
if ( ! function_exists( 'lsvr_events_load_assets' ) ) {
	function lsvr_events_load_assets() {

		// Get plugin version
		$plugin_data = get_plugin_data( __FILE__ );
		$plugin_version = ! empty( $plugin_data['Version'] ) ? $plugin_data['Version'] : false;
		$suffix = defined( 'WP_DEBUG' ) && true == WP_DEBUG ? '' : '.min';

		// Datepicker
		if ( true === apply_filters( 'lsvr_events_load_datepicker_js', true ) ) {
			wp_enqueue_script( 'jquery-ui-datepicker' );
		}

		// Plugin scripts
		wp_enqueue_script(
			'lsvr-events-scripts',
			plugin_dir_url( __FILE__ ) . 'assets/js/lsvr-events' . $suffix . '.js',
			array( 'jquery' ),
			$plugin_version
		);

	}
}

// Load admin CSS & JS
add_action( 'admin_enqueue_scripts', 'lsvr_events_load_admin_assets' );
if ( ! function_exists( 'lsvr_events_load_admin_assets' ) ) {
	function lsvr_events_load_admin_assets() {

		global $pagenow, $typenow;

		// Get plugin version
		$plugin_data = get_plugin_data( __FILE__ );
		$plugin_version = ! empty( $plugin_data['Version'] ) ? $plugin_data['Version'] : false;
		$suffix = defined( 'WP_DEBUG' ) && true == WP_DEBUG ? '' : '.min';

		// Load assets only on events admin view
		if ( $typenow === 'lsvr_event' && 'edit.php' === $pagenow ) {

			wp_enqueue_script( 'jquery-ui-datepicker' );

			// Admin styles
			wp_enqueue_style(
				'lsvr-events-admin-styles',
				plugin_dir_url( __FILE__ ) . 'assets/css/lsvr-events.admin.css',
				false,
				$plugin_version
			);

			// Admin scripts
			wp_enqueue_script(
				'lsvr-events-admin-scripts',
				plugin_dir_url( __FILE__ ) . 'assets/js/lsvr-events.admin.js',
				array( 'jquery' ),
				$plugin_version
			);

			// RTL version
			if ( is_rtl() ) {
				wp_enqueue_style(
					'lsvr-events-admin-rtl-styles',
					plugin_dir_url( __FILE__ ) . 'assets/css/lsvr-events.admin.rtl.css',
					false,
					$plugin_version
				);
			}

		}

	}
}

// Register Event CPT
if ( class_exists( 'Lsvr_CPT_Event' ) ) {

	// Register CPT on plugin activation
	if ( ! function_exists( 'lsvr_events_activate_register_event_cpt' ) ) {
		function lsvr_events_activate_register_event_cpt() {
			$lsvr_event_cpt = new Lsvr_CPT_Event();
			$lsvr_event_cpt->activate_cpt();
		}
	}
	register_activation_hook( __FILE__, 'lsvr_events_activate_register_event_cpt' );

	// Register CPT
	$lsvr_event_cpt = new Lsvr_CPT_Event();

}

// Add permalink settings
if ( class_exists( 'Lsvr_Permalink_Settings_Events' ) ) {
	$permalink_settings = new Lsvr_Permalink_Settings_Events();
}

// Register widgets
add_action( 'widgets_init', 'lsvr_events_register_widgets' );
if ( ! function_exists( 'lsvr_events_register_widgets' ) ) {
	function lsvr_events_register_widgets() {

		// Event categories
		require_once( 'inc/classes/widgets/lsvr-widget-event-categories.php' );
		if ( class_exists( 'Lsvr_Widget_Event_Categories' ) ) {
			register_widget( 'Lsvr_Widget_Event_Categories' );
		}

		// Featured event
		require_once( 'inc/classes/widgets/lsvr-widget-event-featured.php' );
		if ( class_exists( 'Lsvr_Widget_Event_Featured' ) ) {
			register_widget( 'Lsvr_Widget_Event_Featured' );
		}

		// Event list
		require_once( 'inc/classes/widgets/lsvr-widget-event-list.php' );
		if ( class_exists( 'Lsvr_Widget_Event_List' ) ) {
			register_widget( 'Lsvr_Widget_Event_List' );
		}

		// Event locations
		require_once( 'inc/classes/widgets/lsvr-widget-event-locations.php' );
		if ( class_exists( 'Lsvr_Widget_Event_Locations' ) ) {
			register_widget( 'Lsvr_Widget_Event_Locations' );
		}

		// Event filter
		require_once( 'inc/classes/widgets/lsvr-widget-event-filter.php' );
		if ( class_exists( 'Lsvr_Widget_Event_Filter' ) ) {
			register_widget( 'Lsvr_Widget_Event_Filter' );
		}

	}
}

// Register shortcodes
add_action( 'init', 'lsvr_events_register_shortcodes' );
if ( ! function_exists( 'lsvr_events_register_shortcodes' ) ) {
	function lsvr_events_register_shortcodes() {

    	// Event List Widget
		require_once( 'inc/classes/shortcodes/lsvr-shortcode-event-list-widget.php' );
		if ( class_exists( 'Lsvr_Shortcode_Event_List_Widget' ) ) {
			add_shortcode( 'lsvr_event_list_widget', array( 'Lsvr_Shortcode_Event_List_Widget', 'shortcode' ) );
		}

    	// Featured Event Widget
		require_once( 'inc/classes/shortcodes/lsvr-shortcode-event-featured-widget.php' );
		if ( class_exists( 'Lsvr_Shortcode_Event_Featured_Widget' ) ) {
			add_shortcode( 'lsvr_event_featured_widget', array( 'Lsvr_Shortcode_Event_Featured_Widget', 'shortcode' ) );
		}

	}
}

// Create event occurrences DB table on plugin activation
if ( function_exists( 'lsvr_events_create_event_occurrences_db_table' ) ) {
	register_activation_hook( __FILE__, 'lsvr_events_create_event_occurrences_db_table' );
}

// Regenerate event occurrences screen
add_action( 'admin_menu', 'lsvr_events_regenerate_occurrences_menu' );
if ( ! function_exists( 'lsvr_events_regenerate_occurrences_menu' ) ) {
	function lsvr_events_regenerate_occurrences_menu() {
		add_submenu_page(
			'tools.php',
			esc_html__( 'Regenerate Event Occurrences', 'lsvr-events' ),
			esc_html__( 'Regen. Events', 'lsvr-events' ),
			'manage_options',
			'lsvr-events-regenerate-events',
			'lsvr_events_regenerate_occurrences_screen'
		);
	}
}
if ( ! function_exists( 'lsvr_events_regenerate_occurrences_screen' ) ) {
	function lsvr_events_regenerate_occurrences_screen() {
		if ( function_exists( 'lsvr_events_save_event_occurrences' ) ) {

			if ( ! current_user_can( 'manage_options' ) )  {
				wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'lsvr-events'  ) );
			}

			if ( ! empty( $_POST[ 'lsvr-regenerate-events' ] ) ) {

				$event_posts = get_posts(array(
					'posts_per_page' => 1000,
					'post_type' => array( 'lsvr_event' )
				));

				if ( ! empty( $event_posts ) ) {
					foreach ( $event_posts as $event_post ) {
						 lsvr_events_save_event_occurrences( $event_post->ID, $event_post );
					}
				}

			} ?>

			<div class="wrap">

				<h1><?php esc_html_e( 'Regenerate Event Occurrences', 'lsvr-events' ); ?></h1>

				<?php if ( empty( $_POST[ 'lsvr-regenerate-events' ] ) ) : ?>

					<p><?php esc_html_e( 'Use this tool if you\'ve just imported your Event posts.', 'lsvr-events' ); ?></p>
					<form action="" method="post">
						<input type="submit" class="button" name="lsvr-regenerate-events" value="<?php esc_html_e( 'Regenerate', 'lsvr-events' ); ?>">
					</form>

				<?php elseif ( ! empty( $_POST[ 'lsvr-regenerate-events' ] ) && empty( $event_posts ) ) : ?>
					<?php esc_html_e( 'There are no event posts.', 'lsvr-events'  ); ?>
				<?php elseif ( ! empty( $_POST[ 'lsvr-regenerate-events' ] ) && ! empty( $event_posts ) ) : ?>
					<?php esc_html_e( 'Done!', 'lsvr-events'  ); ?>
				<?php endif; ?>

			</div>

		<?php }
	}
}

?>