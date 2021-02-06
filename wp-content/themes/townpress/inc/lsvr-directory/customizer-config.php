<?php

add_action( 'customize_register', 'lsvr_townpress_directory_customize_register' );
if ( ! function_exists( 'lsvr_townpress_directory_customize_register' ) ) {
    function lsvr_townpress_directory_customize_register( $wp_customize ) {
        if ( class_exists( 'Lsvr_Customizer' ) ) {

            $lsvr_customizer = new Lsvr_Customizer( $wp_customize, 'lsvr_townpress_' );

            $lsvr_customizer->add_section( 'lsvr_directory_settings', array(
                'title' => esc_html__( 'Directory', 'townpress' ),
                'priority' => 130,
            ));

                // Title
                $lsvr_customizer->add_field( 'lsvr_listing_archive_title', array(
                    'section' => 'lsvr_directory_settings',
                    'label' => esc_html__( 'Directory Archive Title', 'townpress' ),
                    'description' => esc_html__( 'This title will be used as the archive page headline and in breadcrumbs.', 'townpress' ),
                    'type' => 'text',
                    'default' => esc_html__( 'Directory', 'townpress' ),
                    'priority' => 1010,
                ));

                // Enable map
                $lsvr_customizer->add_field( 'lsvr_listing_archive_map_enable', array(
                    'section' => 'lsvr_directory_settings',
                    'label' => esc_html__( 'Display Map', 'townpress' ),
                    'description' => esc_html__( 'Display the directory map.', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => true,
                    'priority' => 1030,
                ));

                // Archive map type
                $lsvr_customizer->add_field( 'lsvr_listing_archive_map_type', array(
                    'section' => 'lsvr_directory_settings',
                    'label' => esc_html__( 'Archive Map Type', 'townpress' ),
                    'description' => esc_html__( 'Choose the type of directory map.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array(
                        'roadmap' => esc_html__( 'Roadmap', 'townpress' ),
                        'terrain' => esc_html__( 'Terrain', 'townpress' ),
                        'satellite' => esc_html__( 'Satellite', 'townpress' ),
                        'hybrid' => esc_html__( 'Hybrid', 'townpress' ),
                    ),
                    'default' => 'roadmap',
                    'priority' => 1040,
                    'required' => array(
                        'setting' => 'lsvr_listing_archive_map_enable',
                        'operator' => '==',
                        'value' => true,
                    ),
                ));

                // Archive map zoom level
                $lsvr_customizer->add_field( 'lsvr_listing_archive_map_zoom', array(
                    'section' => 'lsvr_directory_settings',
                    'label' => esc_html__( 'Archive Map Zoom', 'townpress' ),
                    'description' => esc_html__( 'Set zoom level for directory map.', 'townpress' ),
                    'type' => 'lsvr-slider',
                    'choices' => array(
                        'min' => 15,
                        'max' => 20,
                        'step' => 1,
                    ),
                    'default' => 16,
                    'priority' => 1050,
                    'required' => array(
                        'setting' => 'lsvr_listing_archive_map_enable',
                        'operator' => '==',
                        'value' => true,
                    ),
                ));

                // Enable categories
                $lsvr_customizer->add_field( 'lsvr_listing_archive_categories_enable', array(
                    'section' => 'lsvr_directory_settings',
                    'label' => esc_html__( 'Display Archive Categories', 'townpress' ),
                    'description' => esc_html__( 'Display links to listing categories.', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => true,
                    'priority' => 1060,
                ));

                // Crop thumbnails
                $lsvr_customizer->add_field( 'lsvr_listing_archive_cropped_thumb_enable', array(
                    'section' => 'lsvr_directory_settings',
                    'label' => esc_html__( 'Crop Thumbnails on Archive', 'townpress' ),
                    'description' => esc_html__( 'Make each listing thumbnail the same size.', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => true,
                    'priority' => 1080,
                ));

                // Archive items order
                $lsvr_customizer->add_field( 'lsvr_listing_archive_order', array(
                    'section' => 'lsvr_directory_settings',
                    'label' => esc_html__( 'Archive Listings Order', 'townpress' ),
                    'description' => esc_html__( 'Choose how directory listings will be ordered on the archive page.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array(
                        'default' => esc_html__( 'Default', 'townpress' ),
                        'date_asc' => esc_html__( 'By Date, Ascending', 'townpress' ),
                        'date_desc' => esc_html__( 'By Date, Descending', 'townpress' ),
                        'title_asc' => esc_html__( 'By Title, Ascending', 'townpress' ),
                        'title_desc' => esc_html__( 'By Title, Descending', 'townpress' ),
                    ),
                    'default' => 'default',
                    'priority' => 1090,
                ));

                // Archive grid columns
                $lsvr_customizer->add_field( 'lsvr_listing_archive_grid_columns', array(
                    'section' => 'lsvr_directory_settings',
                    'label' => esc_html__( 'Archive Number of Columns', 'townpress' ),
                    'description' => esc_html__( 'Divide archive into several columns. It is not recommended to set this to more than two columns if you are using both sidebars on your archive page.', 'townpress' ),
                    'type' => 'lsvr-slider',
                    'choices' => array(
                        'min' => 1,
                        'max' => 4,
                        'step' => 1,
                    ),
                    'default' => 2,
                    'priority' => 1100,
                ));

                // Archive posts per page
                $lsvr_customizer->add_field( 'lsvr_listing_archive_posts_per_page', array(
                    'section' => 'lsvr_directory_settings',
                    'label' => esc_html__( 'Archive Posts Per Page', 'townpress' ),
                    'description' => esc_html__( 'How many listing posts should be displayed per page. Set to 0 to display all.', 'townpress' ),
                    'type' => 'lsvr-slider',
                    'choices' => array(
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ),
                    'default' => 12,
                    'priority' => 1110,
                ));

                // Archive left sidebar ID
                $lsvr_customizer->add_field( 'lsvr_listing_archive_sidebar_left_id', array(
                    'section' => 'lsvr_directory_settings',
                    'label' => esc_html__( 'Archive Left Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose left sidebar to display on listing post archive.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array_merge(
                        array( 'disable' => esc_html__( 'Disable', 'townpress' ) ),
                        lsvr_townpress_get_sidebars()
                    ),
                    'priority' => 1200,
                    'default' => 'lsvr-townpress-default-sidebar-left',
                ));

                // Archive right sidebar ID
                $lsvr_customizer->add_field( 'lsvr_listing_archive_sidebar_right_id', array(
                    'section' => 'lsvr_directory_settings',
                    'label' => esc_html__( 'Archive Right Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose right sidebar to display on listing post archive.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array_merge(
                        array( 'disable' => esc_html__( 'Disable', 'townpress' ) ),
                        lsvr_townpress_get_sidebars()
                    ),
                    'priority' => 1210,
                    'default' => 'lsvr-townpress-default-sidebar-right',
                ));

                // Separator
                $lsvr_customizer->add_separator( 'lsvr_directory_separator_2', array(
                    'section' => 'lsvr_directory_settings',
                    'priority' => 2000,
                ));

                // Enable featured image
                $lsvr_customizer->add_field( 'lsvr_listing_single_featured_image_enable', array(
                    'section' => 'lsvr_directory_settings',
                    'label' => esc_html__( 'Display Featured Image on Detail', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => true,
                    'priority' => 2010,
                ));

                // Enable map
                $lsvr_customizer->add_field( 'lsvr_listing_single_map_enable', array(
                    'section' => 'lsvr_directory_settings',
                    'label' => esc_html__( 'Display Map on Detail', 'townpress' ),
                    'description' => esc_html__( 'Display map on listing detail page.', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => true,
                    'priority' => 2020,

                ));

                // Single map type
                $lsvr_customizer->add_field( 'lsvr_listing_single_map_type', array(
                    'section' => 'lsvr_directory_settings',
                    'label' => esc_html__( 'Detail Map Type', 'townpress' ),
                    'description' => esc_html__( 'Choose the type of the map on listing detail page.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array(
                        'roadmap' => esc_html__( 'Roadmap', 'townpress' ),
                        'terrain' => esc_html__( 'Terrain', 'townpress' ),
                        'satellite' => esc_html__( 'Satellite', 'townpress' ),
                        'hybrid' => esc_html__( 'Hybrid', 'townpress' ),
                    ),
                    'default' => 'roadmap',
                    'priority' => 2030,
                    'required' => array(
                        'setting' => 'lsvr_listing_single_map_enable',
                        'operator' => '==',
                        'value' => true,
                    ),
                ));

                // Single map zoom level
                $lsvr_customizer->add_field( 'lsvr_listing_single_map_zoom', array(
                    'section' => 'lsvr_directory_settings',
                    'label' => esc_html__( 'Detail Map Zoom', 'townpress' ),
                    'description' => esc_html__( 'Set zoom level for the map.', 'townpress' ),
                    'type' => 'lsvr-slider',
                    'choices' => array(
                        'min' => 15,
                        'max' => 20,
                        'step' => 1,
                    ),
                    'default' => 17,
                    'priority' => 2040,
                    'required' => array(
                        'setting' => 'lsvr_listing_single_map_enable',
                        'operator' => '==',
                        'value' => true,
                    ),
                ));

                // Single left sidebar ID
                $lsvr_customizer->add_field( 'lsvr_listing_single_sidebar_left_id', array(
                    'section' => 'lsvr_directory_settings',
                    'label' => esc_html__( 'Detail Left Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose left sidebar to display on listing post detail.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array_merge(
                        array( 'disable' => esc_html__( 'Disable', 'townpress' ) ),
                        lsvr_townpress_get_sidebars()
                    ),
                    'priority' => 2100,
                    'default' => 'lsvr-townpress-default-sidebar-left',
                ));

                // Single right sidebar ID
                $lsvr_customizer->add_field( 'lsvr_listing_single_sidebar_right_id', array(
                    'section' => 'lsvr_directory_settings',
                    'label' => esc_html__( 'Detail Right Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose right sidebar to display on listing post detail.', 'townpress' ),
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