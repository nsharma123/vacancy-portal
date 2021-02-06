<?php

add_action( 'customize_register', 'lsvr_townpress_people_customize_register' );
if ( ! function_exists( 'lsvr_townpress_people_customize_register' ) ) {
    function lsvr_townpress_people_customize_register( $wp_customize ) {
        if ( class_exists( 'Lsvr_Customizer' ) ) {

            $lsvr_customizer = new Lsvr_Customizer( $wp_customize, 'lsvr_townpress_' );

            $lsvr_customizer->add_section( 'lsvr_person_settings', array(
                'title' => esc_html__( 'People', 'townpress' ),
                'priority' => 170,
            ));

                // Title
                $lsvr_customizer->add_field( 'lsvr_person_archive_title', array(
                    'section' => 'lsvr_person_settings',
                    'label' => esc_html__( 'Person Archive Title', 'townpress' ),
                    'description' => esc_html__( 'This title will be used as the archive page headline and in breadcrumbs.', 'townpress' ),
                    'type' => 'text',
                    'default' => esc_html__( 'People', 'townpress' ),
                    'priority' => 1010,
                ));

                // Enable categories
                $lsvr_customizer->add_field( 'lsvr_person_archive_categories_enable', array(
                    'section' => 'lsvr_person_settings',
                    'label' => esc_html__( 'Display Archive Categories', 'townpress' ),
                    'description' => esc_html__( 'Display links to person categories.', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => true,
                    'priority' => 1020,
                ));

                // Archive grid columns
                $lsvr_customizer->add_field( 'lsvr_person_archive_grid_columns', array(
                    'section' => 'lsvr_person_settings',
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

                // Archive left sidebar ID
                $lsvr_customizer->add_field( 'lsvr_person_archive_sidebar_left_id', array(
                    'section' => 'lsvr_person_settings',
                    'label' => esc_html__( 'Archive Left Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose left sidebar to display on person post archive.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array_merge(
                        array( 'disable' => esc_html__( 'Disable', 'townpress' ) ),
                        lsvr_townpress_get_sidebars()
                    ),
                    'priority' => 1040,
                    'default' => 'lsvr-townpress-default-sidebar-left',
                ));

                // Archive right sidebar ID
                $lsvr_customizer->add_field( 'lsvr_person_archive_sidebar_right_id', array(
                    'section' => 'lsvr_person_settings',
                    'label' => esc_html__( 'Archive Right Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose right sidebar to display on person post archive.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array_merge(
                        array( 'disable' => esc_html__( 'Disable', 'townpress' ) ),
                        lsvr_townpress_get_sidebars()
                    ),
                    'priority' => 1050,
                    'default' => 'lsvr-townpress-default-sidebar-right',
                ));

                // Separator
                $lsvr_customizer->add_separator( 'lsvr_person_separator_2', array(
                    'section' => 'lsvr_person_settings',
                    'priority' => 2000,
                ));

                // Single left sidebar ID
                $lsvr_customizer->add_field( 'lsvr_person_single_sidebar_left_id', array(
                    'section' => 'lsvr_person_settings',
                    'label' => esc_html__( 'Detail Left Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose left sidebar to display on person post detail.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array_merge(
                        array( 'disable' => esc_html__( 'Disable', 'townpress' ) ),
                        lsvr_townpress_get_sidebars()
                    ),
                    'priority' => 2010,
                    'default' => 'lsvr-townpress-default-sidebar-left',
                ));

                // Single right sidebar ID
                $lsvr_customizer->add_field( 'lsvr_person_single_sidebar_right_id', array(
                    'section' => 'lsvr_person_settings',
                    'label' => esc_html__( 'Detail Right Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose right sidebar to display on person post detail.', 'townpress' ),
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