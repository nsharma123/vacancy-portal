<?php

// Add Sidebar Settings to pages
if ( class_exists( 'Lsvr_Post_Metabox' ) ) {
	$lsvr_townpress_page_sidebar_settings_metabox = new Lsvr_Post_Metabox(array(
		'id' => 'lsvr_townpress_page_sidebar_settings',
		'wp_args' => array(
			'title' => __( 'Sidebar Settings', 'townpress' ),
			'screen' => 'page',
		),
		'fields' => array(

			// Left Sidebar
			'lsvr_townpress_page_sidebar_left' => array(
				'type' => 'select',
				'title' => esc_html__( 'Left Sidebar', 'townpress' ),
				'description' => esc_html__( 'You can manage sidebar widgets under Appearance / Widgets. Custom sidebars can be added under Customizer / Custom Sidebars.', 'townpress' ),
				'choices' => array_merge( array( 'disable' => esc_html__( 'Disable', 'townpress' ) ),
					lsvr_townpress_get_sidebars() ),
				'default' => 'lsvr-townpress-default-sidebar-left',
				'priority' => 310,
			),

			// Right Sidebar
			'lsvr_townpress_page_sidebar_right' => array(
				'type' => 'select',
				'title' => esc_html__( 'Right Sidebar', 'townpress' ),
				'choices' => array_merge( array( 'disable' => esc_html__( 'Disable', 'townpress' ) ),
					lsvr_townpress_get_sidebars() ),
				'default' => 'disable',
				'priority' => 320,
			),

		),
	));
}

?>