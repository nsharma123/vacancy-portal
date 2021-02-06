<?php

add_action( 'customize_register', 'lsvr_townpress_bbpress_customize_register' );
if ( ! function_exists( 'lsvr_townpress_bbpress_customize_register' ) ) {
    function lsvr_townpress_bbpress_customize_register( $wp_customize ) {
        if ( class_exists( 'Lsvr_Customizer' ) ) {

            $lsvr_customizer = new Lsvr_Customizer( $wp_customize, 'lsvr_townpress_' );

            $lsvr_customizer->add_section( 'lsvr_bbpress_settings', array(
                'title' => esc_html__( 'bbPress', 'townpress' ),
                'priority' => 180,
            ));

                // Title
                $lsvr_customizer->add_field( 'lsvr_bbpress_archive_title', array(
                    'section' => 'lsvr_bbpress_settings',
                    'label' => esc_html__( 'Archive Title', 'townpress' ),
                    'description' => esc_html__( 'This title will be used as the archive page headline and in breadcrumbs.', 'townpress' ),
                    'type' => 'text',
                    'default' => esc_html__( 'Forums', 'townpress' ),
                    'priority' => 1010,
                ));

                // Archive left sidebar ID
                $lsvr_customizer->add_field( 'lsvr_bbpress_sidebar_left_id', array(
                    'section' => 'lsvr_bbpress_settings',
                    'label' => esc_html__( 'Left Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose left sidebar to display on bbPress pages.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array_merge(
                        array( 'disable' => esc_html__( 'Disable', 'townpress' ) ),
                        lsvr_townpress_get_sidebars()
                    ),
                    'priority' => 1040,
                    'default' => 'lsvr-townpress-default-sidebar-left',
                ));

                // Archive right sidebar ID
                $lsvr_customizer->add_field( 'lsvr_bbpress_sidebar_right_id', array(
                    'section' => 'lsvr_bbpress_settings',
                    'label' => esc_html__( 'Right Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose right sidebar to display on bbPress pages.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array_merge(
                        array( 'disable' => esc_html__( 'Disable', 'townpress' ) ),
                        lsvr_townpress_get_sidebars()
                    ),
                    'priority' => 1050,
                    'default' => 'lsvr-townpress-default-sidebar-right',
                ));

        }
    }
}

?>