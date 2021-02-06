<?php

add_action( 'customize_register', 'lsvr_townpress_events_customize_register' );
if ( ! function_exists( 'lsvr_townpress_events_customize_register' ) ) {
    function lsvr_townpress_events_customize_register( $wp_customize ) {
        if ( class_exists( 'Lsvr_Customizer' ) ) {

            $lsvr_customizer = new Lsvr_Customizer( $wp_customize, 'lsvr_townpress_' );

            $lsvr_customizer->add_section( 'lsvr_events_settings', array(
                'title' => esc_html__( 'Events', 'townpress' ),
                'priority' => 140,
            ));

                // Title
                $lsvr_customizer->add_field( 'lsvr_event_archive_title', array(
                    'section' => 'lsvr_events_settings',
                    'label' => esc_html__( 'Event Archive Title', 'townpress' ),
                    'description' => esc_html__( 'This title will be used as the archive page headline and in breadcrumbs.', 'townpress' ),
                    'type' => 'text',
                    'default' => esc_html__( 'Events', 'townpress' ),
                    'priority' => 1010,
                ));

                // Archive grid columns
                $lsvr_customizer->add_field( 'lsvr_event_archive_grid_columns', array(
                    'section' => 'lsvr_events_settings',
                    'label' => esc_html__( 'Number of Columns', 'townpress' ),
                    'description' => esc_html__( 'Divide layout into several columns. It is not recommended to set this to more than two columns if you are using both sidebars on your archive page.', 'townpress' ),
                    'type' => 'lsvr-slider',
                    'choices' => array(
                        'min' => 1,
                        'max' => 4,
                        'step' => 1,
                    ),
                    'default' => 2,
                    'priority' => 1030,
                ));

                // Enable categories
                $lsvr_customizer->add_field( 'lsvr_event_archive_categories_enable', array(
                    'section' => 'lsvr_events_settings',
                    'label' => esc_html__( 'Display Archive Categories', 'townpress' ),
                    'description' => esc_html__( 'Display links to event categories.', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => true,
                    'priority' => 1040,
                ));

                // Group by month
                $lsvr_customizer->add_field( 'lsvr_event_archive_group_enable', array(
                    'section' => 'lsvr_events_settings',
                    'label' => esc_html__( 'Group By Month', 'townpress' ),
                    'description' => esc_html__( 'Divide the archive page into month sections.', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => true,
                    'priority' => 1060,
                ));

                // Crop thumbnail
                $lsvr_customizer->add_field( 'lsvr_event_archive_cropped_thumb_enable', array(
                    'section' => 'lsvr_events_settings',
                    'label' => esc_html__( 'Crop Thumbnails', 'townpress' ),
                    'description' => esc_html__( 'Make each event thumbnail the same size.', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => true,
                    'priority' => 1080,
                ));

                // Archive posts per page
                $lsvr_customizer->add_field( 'lsvr_event_archive_posts_per_page', array(
                    'section' => 'lsvr_events_settings',
                    'label' => esc_html__( 'Posts Per Page', 'townpress' ),
                    'description' => esc_html__( 'How many event posts should be displayed per page. Set to 0 to display all.', 'townpress' ),
                    'type' => 'lsvr-slider',
                    'choices' => array(
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ),
                    'default' => 12,
                    'priority' => 1090,
                ));

                // Archive left sidebar ID
                $lsvr_customizer->add_field( 'lsvr_event_archive_sidebar_left_id', array(
                    'section' => 'lsvr_events_settings',
                    'label' => esc_html__( 'Archive Left Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose left sidebar to display on event post archive.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array_merge(
                        array( 'disable' => esc_html__( 'Disable', 'townpress' ) ),
                        lsvr_townpress_get_sidebars()
                    ),
                    'priority' => 1100,
                    'default' => 'lsvr-townpress-default-sidebar-left',
                ));

                // Archive right sidebar ID
                $lsvr_customizer->add_field( 'lsvr_event_archive_sidebar_right_id', array(
                    'section' => 'lsvr_events_settings',
                    'label' => esc_html__( 'Archive Right Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose right sidebar to display on event post archive.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array_merge(
                        array( 'disable' => esc_html__( 'Disable', 'townpress' ) ),
                        lsvr_townpress_get_sidebars()
                    ),
                    'priority' => 1110,
                    'default' => 'lsvr-townpress-default-sidebar-right',
                ));

                // Separator
                $lsvr_customizer->add_separator( 'lsvr_event_separator_2', array(
                    'section' => 'lsvr_events_settings',
                    'priority' => 2000,
                ));

                // Enable featured image
                $lsvr_customizer->add_field( 'lsvr_event_single_featured_image_enable', array(
                    'section' => 'lsvr_events_settings',
                    'label' => esc_html__( 'Display Featured Image on Detail', 'townpress' ),
                    'description' => esc_html__( 'Display featured image on event detail page.', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => true,
                    'priority' => 2010,
                ));

                // Enable map
                $lsvr_customizer->add_field( 'lsvr_event_single_map_enable', array(
                    'section' => 'lsvr_events_settings',
                    'label' => esc_html__( 'Display Map On Detail', 'townpress' ),
                    'description' => esc_html__( 'Display the event location on event detail page.', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => true,
                    'priority' => 2020,
                ));

                // Single map type
                $lsvr_customizer->add_field( 'lsvr_event_single_map_type', array(
                    'section' => 'lsvr_events_settings',
                    'label' => esc_html__( 'Detail Map Type', 'townpress' ),
                    'description' => esc_html__( 'Choose the type of map on event detail page.', 'townpress' ),
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
                        'setting' => 'lsvr_event_single_map_enable',
                        'operator' => '==',
                        'value' => true,
                    ),
                ));

                // Single map zoom level
                $lsvr_customizer->add_field( 'lsvr_event_single_map_zoom', array(
                    'section' => 'lsvr_events_settings',
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
                        'setting' => 'lsvr_event_single_map_enable',
                        'operator' => '==',
                        'value' => true,
                    ),
                ));

                // Single left sidebar ID
                $lsvr_customizer->add_field( 'lsvr_event_single_sidebar_left_id', array(
                    'section' => 'lsvr_events_settings',
                    'label' => esc_html__( 'Detail Left Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose left sidebar to display on event post detail.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array_merge(
                        array( 'disable' => esc_html__( 'Disable', 'townpress' ) ),
                        lsvr_townpress_get_sidebars()
                    ),
                    'priority' => 2100,
                    'default' => 'lsvr-townpress-default-sidebar-left',
                ));

                // Single right sidebar ID
                $lsvr_customizer->add_field( 'lsvr_event_single_sidebar_right_id', array(
                    'section' => 'lsvr_events_settings',
                    'label' => esc_html__( 'Detail Right Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose right sidebar to display on event post detail.', 'townpress' ),
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