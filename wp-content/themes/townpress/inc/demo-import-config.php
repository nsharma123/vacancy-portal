<?php

// One Click Demo Import plugin is required for this functionality to work
// https://wordpress.org/plugins/one-click-demo-import/
add_filter( 'pt-ocdi/import_files', 'lsvr_townpress_demo_import' );
if ( ! function_exists( 'lsvr_townpress_demo_import' ) ) {
	function lsvr_townpress_demo_import() {

    	return array(
	        array(
	            'import_file_name' => esc_html__( 'TownPress Content', 'townpress' ),
	            'local_import_file' => trailingslashit( get_template_directory() ) . 'inc/demo-import/content.xml',
	            'import_notice' => esc_html__( 'Please note that demo images are not included. After you import this demo, don\'t forget to regenerate your events under Tools / Regen. Events.', 'townpress' ),
	        ),
	        array(
	            'import_file_name' => esc_html__( 'TownPress Customizer', 'townpress' ),
	            'local_import_file' => trailingslashit( get_template_directory() ) . 'inc/demo-import/content-blank.xml',
				'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'inc/demo-import/customizer.dat',
	            'import_notice' => esc_html__( 'Please note that demo images are not included. After you import this demo, don\'t forget to regenerate your events under Tools / Regen. Events.', 'townpress' ),
	        ),
	        array(
	            'import_file_name' => esc_html__( 'TownPress Widgets', 'townpress' ),
	            'local_import_file' => trailingslashit( get_template_directory() ) . 'inc/demo-import/content-blank.xml',
	            'local_import_widget_file' => trailingslashit( get_template_directory() ) . 'inc/demo-import/widgets.wie',
	            'import_notice' => esc_html__( 'Please note that demo images are not included. After you import this demo, don\'t forget to regenerate your events under Tools / Regen. Events.', 'townpress' ),
	        ),
        );

	}
}

add_action( 'pt-ocdi/after_import', 'lsvr_townpress_after_import_setup' );
if ( ! function_exists( 'lsvr_townpress_after_import_setup' ) ) {
function lsvr_townpress_after_import_setup() {

	    // Set menus
	    $header_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
	    $footer_menu = get_term_by( 'name', 'Footer Menu', 'nav_menu' );
	    if ( ! empty( $header_menu->term_id ) &&
	    	! empty( $footer_menu->term_id ) ) {
		    set_theme_mod( 'nav_menu_locations', array(
		            'lsvr-townpress-header-menu' => $header_menu->term_id,
		            'lsvr-townpress-header-mobile-menu' => $header_menu->term_id,
		            'lsvr-townpress-footer-menu' => $footer_menu->term_id,
		        )
		    );
		}

	    // Assign front page and posts page (blog page).
	    update_option( 'show_on_front', 'page' );
	    $front_page_id = get_page_by_title( 'Welcome to TownPress, the Most Exciting Town of Northeast!' );
	    if ( ! empty( $front_page_id->ID ) ) {
	    	update_option( 'page_on_front', $front_page_id->ID );
		}
	    $blog_page_id  = get_page_by_title( 'News' );
		if ( ! empty( $blog_page_id->ID ) ) {
	    	update_option( 'page_for_posts', $blog_page_id->ID );
		}

	}
}


?>