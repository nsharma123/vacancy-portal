<?php

add_action( 'customize_register', 'lsvr_townpress_galleries_customize_register' );
if ( ! function_exists( 'lsvr_townpress_galleries_customize_register' ) ) {
    function lsvr_townpress_galleries_customize_register( $wp_customize ) {
        if ( class_exists( 'Lsvr_Customizer' ) ) {

            $lsvr_customizer = new Lsvr_Customizer( $wp_customize, 'lsvr_townpress_' );

            $lsvr_customizer->add_section( 'lsvr_gallery_settings', array(
                'title' => esc_html__( 'Galleries', 'townpress' ),
                'priority' => 150,
            ));

                // Title
                $lsvr_customizer->add_field( 'lsvr_gallery_archive_title', array(
                    'section' => 'lsvr_gallery_settings',
                    'label' => esc_html__( 'Gallery Archive Title', 'townpress' ),
                    'description' => esc_html__( 'This title will be used as the archive page headline and in breadcrumbs.', 'townpress' ),
                    'type' => 'text',
                    'default' => esc_html__( 'Galleries', 'townpress' ),
                    'priority' => 1010,
                ));

                // Enable categories
                $lsvr_customizer->add_field( 'lsvr_gallery_archive_categories_enable', array(
                    'section' => 'lsvr_gallery_settings',
                    'label' => esc_html__( 'Display Archive Categories', 'townpress' ),
                    'description' => esc_html__( 'Display links to gallery categories.', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => true,
                    'priority' => 1030,
                ));

                // Archive grid columns
                $lsvr_customizer->add_field( 'lsvr_gallery_archive_grid_columns', array(
                    'section' => 'lsvr_gallery_settings',
                    'label' => esc_html__( 'Number of Columns', 'townpress' ),
                    'description' => esc_html__( 'Divide layout into several columns. It is not recommended to set this to more than two columns if you are using both sidebars on your archive page.', 'townpress' ),
                    'type' => 'lsvr-slider',
                    'choices' => array(
                        'min' => 1,
                        'max' => 4,
                        'step' => 1,
                    ),
                    'default' => 2,
                    'priority' => 1060,
                ));

                // Archive posts per page
                $lsvr_customizer->add_field( 'lsvr_gallery_archive_posts_per_page', array(
                    'section' => 'lsvr_gallery_settings',
                    'label' => esc_html__( 'Posts Per Page', 'townpress' ),
                    'description' => esc_html__( 'How many gallery posts should be displayed per page. Set to 0 to display all.', 'townpress' ),
                    'type' => 'lsvr-slider',
                    'choices' => array(
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ),
                    'default' => 12,
                    'priority' => 1070,
                ));

                // Enable archive date
                $lsvr_customizer->add_field( 'lsvr_gallery_archive_date_enable', array(
                    'section' => 'lsvr_gallery_settings',
                    'label' => esc_html__( 'Display Date on Archive', 'townpress' ),
                    'description' => esc_html__( 'Display the gallery post date on post archive.', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => true,
                    'priority' => 1080,
                ));

                // Enable archive images count
                $lsvr_customizer->add_field( 'lsvr_gallery_archive_image_count_enable', array(
                    'section' => 'lsvr_gallery_settings',
                    'label' => esc_html__( 'Display Image Count on Archive', 'townpress' ),
                    'description' => esc_html__( 'Display the number of gallery images on post archive.', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => true,
                    'priority' => 1090,
                ));

                // Archive left sidebar ID
                $lsvr_customizer->add_field( 'lsvr_gallery_archive_sidebar_left_id', array(
                    'section' => 'lsvr_gallery_settings',
                    'label' => esc_html__( 'Archive Left Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose left sidebar to display on gallery post archive.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array_merge(
                        array( 'disable' => esc_html__( 'Disable', 'townpress' ) ),
                        lsvr_townpress_get_sidebars()
                    ),
                    'priority' => 1100,
                    'default' => 'lsvr-townpress-default-sidebar-left',
                ));

                // Archive right sidebar ID
                $lsvr_customizer->add_field( 'lsvr_gallery_archive_sidebar_right_id', array(
                    'section' => 'lsvr_gallery_settings',
                    'label' => esc_html__( 'Archive Right Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose right sidebar to display on gallery post archive.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array_merge(
                        array( 'disable' => esc_html__( 'Disable', 'townpress' ) ),
                        lsvr_townpress_get_sidebars()
                    ),
                    'priority' => 1110,
                    'default' => 'lsvr-townpress-default-sidebar-right',
                ));

                // Separator
                $lsvr_customizer->add_separator( 'lsvr_gallery_separator_2', array(
                    'section' => 'lsvr_gallery_settings',
                    'priority' => 2000,
                ));

                // Single grid columns
                $lsvr_customizer->add_field( 'lsvr_gallery_single_grid_columns', array(
                    'section' => 'lsvr_gallery_settings',
                    'label' => esc_html__( 'Number of Columns', 'townpress' ),
                    'description' => esc_html__( 'Divide layout into several columns.', 'townpress' ),
                    'type' => 'lsvr-slider',
                    'choices' => array(
                        'min' => 1,
                        'max' => 4,
                        'step' => 1,
                    ),
                    'default' => 3,
                    'priority' => 2010,
                ));

                // Enable detail date
                $lsvr_customizer->add_field( 'lsvr_gallery_single_date_enable', array(
                    'section' => 'lsvr_gallery_settings',
                    'label' => esc_html__( 'Display Date on Detail', 'townpress' ),
                    'description' => esc_html__( 'Display the gallery post date on post detail.', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => true,
                    'priority' => 2020,
                ));

                // Enable post detail navigation
                $lsvr_customizer->add_field( 'lsvr_gallery_single_navigation_enable', array(
                    'section' => 'lsvr_gallery_settings',
                    'label' => esc_html__( 'Enable Gallery Detail Navigation', 'townpress' ),
                    'description' => esc_html__( 'Display links to previous and next posts at the bottom of the current gallery.', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => true,
                    'priority' => 2030,
                ));

                // Single left sidebar ID
                $lsvr_customizer->add_field( 'lsvr_gallery_single_sidebar_left_id', array(
                    'section' => 'lsvr_gallery_settings',
                    'label' => esc_html__( 'Detail Left Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose left sidebar to display on gallery post detail.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array_merge(
                        array( 'disable' => esc_html__( 'Disable', 'townpress' ) ),
                        lsvr_townpress_get_sidebars()
                    ),
                    'priority' => 2100,
                    'default' => 'lsvr-townpress-default-sidebar-left',
                ));

                // Single right sidebar ID
                $lsvr_customizer->add_field( 'lsvr_gallery_single_sidebar_right_id', array(
                    'section' => 'lsvr_gallery_settings',
                    'label' => esc_html__( 'Detail Right Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose right sidebar to display on gallery post detail.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array_merge(
                        array( 'disable' => esc_html__( 'Disable', 'townpress' ) ),
                        lsvr_townpress_get_sidebars()
                    ),
                    'priority' => 2110,
                    'default' => 'lsvr-townpress-default-sidebar-right',
                ));

        }
    }
}

?>