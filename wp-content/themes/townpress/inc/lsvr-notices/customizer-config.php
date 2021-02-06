<?php

add_action( 'customize_register', 'lsvr_townpress_notices_customize_register' );
if ( ! function_exists( 'lsvr_townpress_notices_customize_register' ) ) {
    function lsvr_townpress_notices_customize_register( $wp_customize ) {
        if ( class_exists( 'Lsvr_Customizer' ) ) {

            $lsvr_customizer = new Lsvr_Customizer( $wp_customize, 'lsvr_townpress_' );

            $lsvr_customizer->add_section( 'lsvr_notice_settings', array(
                'title' => esc_html__( 'Notices', 'townpress' ),
                'priority' => 125,
            ));

                // Title
                $lsvr_customizer->add_field( 'lsvr_notice_archive_title', array(
                    'section' => 'lsvr_notice_settings',
                    'label' => esc_html__( 'Notice Archive Title', 'townpress' ),
                    'description' => esc_html__( 'This title will be used as the archive page headline and in breadcrumbs.', 'townpress' ),
                    'type' => 'text',
                    'default' => esc_html__( 'Notices', 'townpress' ),
                    'priority' => 1010,
                ));

                // Archive posts per page
                $lsvr_customizer->add_field( 'lsvr_notice_archive_posts_per_page', array(
                    'section' => 'lsvr_notice_settings',
                    'label' => esc_html__( 'Posts Per Page', 'townpress' ),
                    'description' => esc_html__( 'How many notice posts should be displayed per page. Set to 0 to display all.', 'townpress' ),
                    'type' => 'lsvr-slider',
                    'choices' => array(
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ),
                    'default' => 10,
                    'priority' => 1020,
                ));

                // Archive left sidebar ID
                $lsvr_customizer->add_field( 'lsvr_notice_archive_sidebar_left_id', array(
                    'section' => 'lsvr_notice_settings',
                    'label' => esc_html__( 'Archive Left Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose left sidebar to display on notice post archive.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array_merge(
                        array( 'disable' => esc_html__( 'Disable', 'townpress' ) ),
                        lsvr_townpress_get_sidebars()
                    ),
                    'priority' => 1040,
                    'default' => 'lsvr-townpress-default-sidebar-left',
                ));

                // Archive right sidebar ID
                $lsvr_customizer->add_field( 'lsvr_notice_archive_sidebar_right_id', array(
                    'section' => 'lsvr_notice_settings',
                    'label' => esc_html__( 'Archive Right Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose right sidebar to display on notice post archive.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array_merge(
                        array( 'disable' => esc_html__( 'Disable', 'townpress' ) ),
                        lsvr_townpress_get_sidebars()
                    ),
                    'priority' => 1050,
                    'default' => 'lsvr-townpress-default-sidebar-right',
                ));

                // Separator
                $lsvr_customizer->add_separator( 'lsvr_notice_separator_2', array(
                    'section' => 'lsvr_notice_settings',
                    'priority' => 2000,
                ));

                // Single left sidebar ID
                $lsvr_customizer->add_field( 'lsvr_notice_single_sidebar_left_id', array(
                    'section' => 'lsvr_notice_settings',
                    'label' => esc_html__( 'Detail Left Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose left sidebar to display on notice post detail.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array_merge(
                        array( 'disable' => esc_html__( 'Disable', 'townpress' ) ),
                        lsvr_townpress_get_sidebars()
                    ),
                    'priority' => 2010,
                    'default' => 'lsvr-townpress-default-sidebar-left',
                ));

                // Single right sidebar ID
                $lsvr_customizer->add_field( 'lsvr_notice_single_sidebar_right_id', array(
                    'section' => 'lsvr_notice_settings',
                    'label' => esc_html__( 'Detail Right Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose right sidebar to display on notice post detail.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array_merge(
                        array( 'disable' => esc_html__( 'Disable', 'townpress' ) ),
                        lsvr_townpress_get_sidebars()
                    ),
                    'priority' => 2020,
                    'default' => 'lsvr-townpress-default-sidebar-right',
                ));

        }
    }
}

?>