<?php add_action( 'after_setup_theme', 'lsvr_townpress_child_theme_setup' );
if ( ! function_exists( 'lsvr_townpress_child_theme_setup' ) ) {
	function lsvr_townpress_child_theme_setup() {

		/**
		 * Load parent and child style.css
		 *
		 * @link https://codex.wordpress.org/Child_Themes#How_to_Create_a_Child_Theme
		 */
		add_action( 'wp_enqueue_scripts', 'lsvr_townpress_child_enqueue_parent_styles' );
		if ( ! function_exists( 'lsvr_townpress_child_enqueue_parent_styles' ) ) {
			function lsvr_townpress_child_enqueue_parent_styles() {

				// Load parent theme's style.css
				$parent_version = wp_get_theme( 'townpress' );
				$parent_version = $parent_version->Version;
				wp_enqueue_style( 'lsvr-townpress-main-style', get_template_directory_uri() . '/style.css', array(), $parent_version );

				// Load child theme's style.css
				$child_version = wp_get_theme();
				$child_version = $child_version->Version;
				wp_enqueue_style( 'lsvr-townpress-child-style', get_stylesheet_directory_uri() . '/style.css', array(), $child_version );

			}
		}

		/* Load editor style */
		add_action( 'enqueue_block_editor_assets', 'lsvr_townpress_child_load_editor_assets' );
		if ( ! function_exists( 'lsvr_townpress_child_load_editor_assets' ) ) {
			function lsvr_townpress_child_load_editor_assets() {

				$child_version = wp_get_theme();
				$child_version = $child_version->Version;
				wp_enqueue_style( 'lsvr-townpress-child-editor-style', get_stylesheet_directory_uri() . '/editor-style.css', array(), $child_version );

			}
		}

		/* Add your code after this comment */

	}
} ?>