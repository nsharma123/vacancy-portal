<?php

add_action( 'customize_register', 'lsvr_townpress_documents_customize_register' );
if ( ! function_exists( 'lsvr_townpress_documents_customize_register' ) ) {
    function lsvr_townpress_documents_customize_register( $wp_customize ) {
        if ( class_exists( 'Lsvr_Customizer' ) ) {

            $lsvr_customizer = new Lsvr_Customizer( $wp_customize, 'lsvr_townpress_' );

            $lsvr_customizer->add_section( 'lsvr_document_settings', array(
                'title' => esc_html__( 'Documents', 'townpress' ),
                'priority' => 160,
            ));

                // Title
                $lsvr_customizer->add_field( 'lsvr_document_archive_title', array(
                    'section' => 'lsvr_document_settings',
                    'label' => esc_html__( 'Document Archive Title', 'townpress' ),
                    'description' => esc_html__( 'This title will be used as the archive page headline and in breadcrumbs.', 'townpress' ),
                    'type' => 'text',
                    'default' => esc_html__( 'Documents', 'townpress' ),
                    'priority' => 1010,
                ));

                // Archive layout
                $lsvr_customizer->add_field( 'lsvr_document_archive_layout', array(
                    'section' => 'lsvr_document_settings',
                    'label' => esc_html__( 'Archive Layout', 'townpress' ),
                    'description' => esc_html__( 'Change layout for document archive page.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array(
                        'default' => esc_html__( 'Post View', 'townpress' ),
                        'categorized-attachments' => esc_html__( 'Attachment View', 'townpress' ),
                    ),
                    'default' => 'default',
                    'priority' => 1020,
                ));

                // Enable categories
                $lsvr_customizer->add_field( 'lsvr_document_archive_categories_enable', array(
                    'section' => 'lsvr_document_settings',
                    'label' => esc_html__( 'Display Archive Categories', 'townpress' ),
                    'description' => esc_html__( 'Display links to document categories.', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => true,
                    'priority' => 1030,
                    'required' => array(
                        'setting' => 'lsvr_document_archive_layout',
                        'operator' => '==',
                        'value' => 'default',
                    ),
                ));

                // Archive posts order
                $lsvr_customizer->add_field( 'lsvr_document_archive_posts_order', array(
                    'section' => 'lsvr_document_settings',
                    'label' => esc_html__( 'Archive Order of Posts', 'townpress' ),
                    'description' => esc_html__( 'How document posts should be ordered.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array(
                        'date_asc' => esc_html__( 'Published date, ascending', 'townpress' ),
                        'date_desc' => esc_html__( 'Published date, descending', 'townpress' ),
                        'title_asc' => esc_html__( 'Post title, ascending', 'townpress' ),
                        'title_desc' => esc_html__( 'Post title, descending', 'townpress' ),
                    ),
                    'default' => 'date_desc',
                    'priority' => 1040,
                    'required' => array(
                        'setting' => 'lsvr_document_archive_layout',
                        'operator' => '==',
                        'value' => 'default',
                    ),
                ));

                // Archive attachments order
                $lsvr_customizer->add_field( 'lsvr_document_archive_attachments_order', array(
                    'section' => 'lsvr_document_settings',
                    'label' => esc_html__( 'Archive Order of Attachments', 'townpress' ),
                    'description' => esc_html__( 'How document attachments should be ordered.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array(
                        'date_asc' => esc_html__( 'Parent post published date, ascending', 'townpress' ),
                        'date_desc' => esc_html__( 'Parent post published date, descending', 'townpress' ),
                        'filename_asc' => esc_html__( 'Attachment filename, ascending', 'townpress' ),
                        'filename_desc' => esc_html__( 'Attachment filename, descending', 'townpress' ),
                        'title_asc' => esc_html__( 'Attachment title, ascending', 'townpress' ),
                        'title_desc' => esc_html__( 'Attachment title, descending', 'townpress' ),
                    ),
                    'default' => 'filename_asc',
                    'priority' => 1045,
                    'required' => array(
                        'setting' => 'lsvr_document_archive_layout',
                        'operator' => '==',
                        'value' => 'categorized-attachments',
                    ),
                ));

                // Archive posts per page
                $lsvr_customizer->add_field( 'lsvr_document_archive_posts_per_page', array(
                    'section' => 'lsvr_document_settings',
                    'label' => esc_html__( 'Posts Per Page', 'townpress' ),
                    'description' => esc_html__( 'How many document posts should be displayed per page. Set to 0 to display all.', 'townpress' ),
                    'type' => 'lsvr-slider',
                    'choices' => array(
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ),
                    'default' => 20,
                    'priority' => 1060,
                    'required' => array(
                        'setting' => 'lsvr_document_archive_layout',
                        'operator' => '==',
                        'value' => 'default',
                    ),
                ));

                // Attachment titles
                $lsvr_customizer->add_field( 'lsvr_document_enable_attachment_titles', array(
                    'section' => 'lsvr_document_settings',
                    'label' => esc_html__( 'Display Attachment Titles', 'townpress' ),
                    'description' => esc_html__( 'Display attachment titles instead of file names. You can change titles by editing your files under Media.', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => false,
                    'priority' => 1085,
                ));

                // Excluded categories
                $lsvr_customizer->add_field( 'lsvr_document_excluded_categories', array(
                    'section' => 'lsvr_document_settings',
                    'label' => esc_html__( 'Excluded Categories', 'townpress' ),
                    'description' => esc_html__( 'List of category IDs or slugs separated by comma. Documents from these categories won\'t be displayed on the default archive page (but they will still be displayed on the category archive page for that particular category).', 'townpress' ),
                    'type' => 'text',
                    'default' => '',
                    'priority' => 1090,
                ));

                // Archive left sidebar ID
                $lsvr_customizer->add_field( 'lsvr_document_archive_sidebar_left_id', array(
                    'section' => 'lsvr_document_settings',
                    'label' => esc_html__( 'Archive Left Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose left sidebar to display on document post archive.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array_merge(
                        array( 'disable' => esc_html__( 'Disable', 'townpress' ) ),
                        lsvr_townpress_get_sidebars()
                    ),
                    'priority' => 1100,
                    'default' => 'lsvr-townpress-default-sidebar-left',
                ));

                // Archive right sidebar ID
                $lsvr_customizer->add_field( 'lsvr_document_archive_sidebar_right_id', array(
                    'section' => 'lsvr_document_settings',
                    'label' => esc_html__( 'Archive Right Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose right sidebar to display on document post archive.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array_merge(
                        array( 'disable' => esc_html__( 'Disable', 'townpress' ) ),
                        lsvr_townpress_get_sidebars()
                    ),
                    'priority' => 1110,
                    'default' => 'lsvr-townpress-default-sidebar-right',
                ));


                // Separator
                $lsvr_customizer->add_separator( 'lsvr_document_separator_2', array(
                    'section' => 'lsvr_document_settings',
                    'priority' => 2000,
                ));

                // Enable date
                $lsvr_customizer->add_field( 'lsvr_document_single_date_enable', array(
                    'section' => 'lsvr_document_settings',
                    'label' => esc_html__( 'Display Date on Detail', 'townpress' ),
                    'description' => esc_html__( 'Display document post date on post detail.', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => true,
                    'priority' => 2010,
                ));

                // Enable author
                $lsvr_customizer->add_field( 'lsvr_document_single_author_enable', array(
                    'section' => 'lsvr_document_settings',
                    'label' => esc_html__( 'Display Author on Detail', 'townpress' ),
                    'description' => esc_html__( 'Display document post author on post detail', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => true,
                    'priority' => 2020,
                ));

                // Single left sidebar ID
                $lsvr_customizer->add_field( 'lsvr_document_single_sidebar_left_id', array(
                    'section' => 'lsvr_document_settings',
                    'label' => esc_html__( 'Detail Left Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose left sidebar to display on document post detail.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array_merge(
                        array( 'disable' => esc_html__( 'Disable', 'townpress' ) ),
                        lsvr_townpress_get_sidebars()
                    ),
                    'priority' => 2100,
                    'default' => 'lsvr-townpress-default-sidebar-left',
                ));

                // Single right sidebar ID
                $lsvr_customizer->add_field( 'lsvr_document_single_sidebar_right_id', array(
                    'section' => 'lsvr_document_settings',
                    'label' => esc_html__( 'Detail Right Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose right sidebar to display on document post detail.', 'townpress' ),
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