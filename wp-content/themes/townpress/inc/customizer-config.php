<?php
/**
 * WordPress customizer settings
 */
add_action( 'customize_register', 'lsvr_townpress_customize_register' );
if ( ! function_exists( 'lsvr_townpress_customize_register' ) ) {
    function lsvr_townpress_customize_register( $wp_customize ) {

        // Init the LSVR Customizer object
        if ( class_exists( 'Lsvr_Customizer' ) ) {

            $lsvr_customizer = new Lsvr_Customizer( $wp_customize, 'lsvr_townpress_' );

            // Change order of default sections
            $wp_customize->get_section( 'static_front_page' )->priority = 117;
            $wp_customize->get_section( 'custom_css' )->priority = 300;

            // Header
            $lsvr_customizer->add_section( 'header_settings', array(
                'title' => esc_html__( 'Header', 'townpress' ),
                'priority' => 101,
            ));

                // Default background Image
                $lsvr_customizer->add_field( 'header_background_image', array(
                    'section' => 'header_settings',
                    'label' => esc_html__( 'Default Background Image', 'townpress' ),
                    'description' => esc_html__( 'Optimal resolution is about 2000x1000px.', 'townpress' ),
                    'type' => 'image',
                    'priority' => 1010,
                ));

                // Background type
                $lsvr_customizer->add_field( 'header_background_type', array(
                    'section' => 'header_settings',
                    'label' => esc_html__( 'Background Type', 'townpress' ),
                    'description' => esc_html__( 'Background can be created as a single image (Default Background Image will be used), slide show with multiple images, or a random image (randomized when loading a page).', 'townpress' ),
                    'type' => 'radio',
                    'choices' => array(
                        'single' => esc_html__( 'Single Image', 'townpress' ),
                        'slideshow' => esc_html__( 'Image Slideshow', 'townpress' ),
                        'slideshow-home' => esc_html__( 'Image Slideshow (Homepage Only)', 'townpress' ),
                        'random' => esc_html__( 'Random Image', 'townpress' ),
                    ),
                    'default' => 'single',
                    'priority' => 1020,
                ));

                // Background Image 2
                $lsvr_customizer->add_field( 'header_background_image_2', array(
                    'section' => 'header_settings',
                    'label' => esc_html__( 'Background Image 2', 'townpress' ),
                    'description' => esc_html__( 'Optimal resolution is about 2000x1000px.', 'townpress' ),
                    'type' => 'image',
                    'priority' => 1030,
                    'required' => array(
                        'setting' => 'header_background_type',
                        'operator' => '==',
                        'value' => 'slideshow,slideshow-home,random',
                    ),
                ));

                // Background Image 3
                $lsvr_customizer->add_field( 'header_background_image_3', array(
                    'section' => 'header_settings',
                    'label' => esc_html__( 'Background Image 3', 'townpress' ),
                    'description' => esc_html__( 'Optimal resolution is about 2000x1000px.', 'townpress' ),
                    'type' => 'image',
                    'priority' => 1040,
                    'required' => array(
                        'setting' => 'header_background_type',
                        'operator' => '==',
                        'value' => 'slideshow,slideshow-home,random',
                    ),
                ));

                // Background Image 4
                $lsvr_customizer->add_field( 'header_background_image_4', array(
                    'section' => 'header_settings',
                    'label' => esc_html__( 'Background Image 4', 'townpress' ),
                    'description' => esc_html__( 'Optimal resolution is about 2000x1000px.', 'townpress' ),
                    'type' => 'image',
                    'priority' => 1050,
                    'required' => array(
                        'setting' => 'header_background_type',
                        'operator' => '==',
                        'value' => 'slideshow,slideshow-home,random',
                    ),
                ));

                // Background Image 5
                $lsvr_customizer->add_field( 'header_background_image_5', array(
                    'section' => 'header_settings',
                    'label' => esc_html__( 'Background Image 5', 'townpress' ),
                    'description' => esc_html__( 'Optimal resolution is about 2000x1000px.', 'townpress' ),
                    'type' => 'image',
                    'priority' => 1060,
                    'required' => array(
                        'setting' => 'header_background_type',
                        'operator' => '==',
                        'value' => 'slideshow,slideshow-home,random',
                    ),
                ));

                // Slideshow speed
                $lsvr_customizer->add_field( 'header_background_slideshow_speed', array(
                    'section' => 'header_settings',
                    'label' => esc_html__( 'Slideshow Speed', 'townpress' ),
                    'description' => esc_html__( 'Set how many seconds it takes to change to the next image.', 'townpress' ),
                    'type' => 'lsvr-slider',
                    'choices' => array(
                        'min' => 1,
                        'max' => 60,
                        'step' => 1,
                    ),
                    'default' => 10,
                    'priority' => 1070,
                    'required' => array(
                        'setting' => 'header_background_type',
                        'operator' => '==',
                        'value' => 'slideshow,slideshow-home',
                    ),
                ));

                // Separator
                $lsvr_customizer->add_separator( 'header_separator_2', array(
                    'section' => 'header_settings',
                    'priority' => 2000,
                ));

                // Max logo width
                $lsvr_customizer->add_field( 'header_logo_max_width', array(
                    'section' => 'header_settings',
                    'label' => esc_html__( 'Logo Max Width', 'townpress' ),
                    'description' => esc_html__( 'Set maximum width of your header logo. You can upload your site logo under Customizer / Site Identity.', 'townpress' ),
                    'type' => 'lsvr-slider',
                    'choices' => array(
                        'min' => 50,
                        'max' => 300,
                        'step' => 1,
                    ),
                    'default' => 140,
                    'priority' => 2010,
                ));

                // Max home logo width
                $lsvr_customizer->add_field( 'header_logo_max_width_home', array(
                    'section' => 'header_settings',
                    'label' => esc_html__( 'Logo Max Width on Front Page', 'townpress' ),
                    'description' => esc_html__( 'Set maximum width of your header logo displayed on the front page.', 'townpress' ),
                    'type' => 'lsvr-slider',
                    'choices' => array(
                        'min' => 50,
                        'max' => 300,
                        'step' => 1,
                    ),
                    'default' => 200,
                    'priority' => 2020,
                ));

                // Max mobile logo width
                $lsvr_customizer->add_field( 'header_logo_max_width_mobile', array(
                    'section' => 'header_settings',
                    'label' => esc_html__( 'Logo Max Width on Mobile', 'townpress' ),
                    'description' => esc_html__( 'Set maximum width of your header logo displayed on mobile devices.', 'townpress' ),
                    'type' => 'lsvr-slider',
                    'choices' => array(
                        'min' => 50,
                        'max' => 300,
                        'step' => 1,
                    ),
                    'default' => 140,
                    'priority' => 2030,
                ));

                // Separator
                $lsvr_customizer->add_separator( 'header_separator_3', array(
                    'section' => 'header_settings',
                    'priority' => 3000,
                ));

                // Header map enable
                $lsvr_customizer->add_field( 'header_map_enable', array(
                    'section' => 'header_settings',
                    'label' => esc_html__( 'Header Map', 'townpress' ),
                    'description' => esc_html__( 'Display a toggleable Google map in the header.', 'townpress' ),
                    'type' => 'radio',
                    'choices' => array(
                        'disable' => esc_html__( 'Disable', 'townpress' ),
                        'enable' => esc_html__( 'Enable', 'townpress' ),
                        'enable-front' => esc_html__( 'Enable on front page only', 'townpress' ),
                    ),
                    'default' => 'disable',
                    'priority' => 3010,
                ));

                // Map address
                $lsvr_customizer->add_field( 'header_map_address', array(
                    'section' => 'header_settings',
                    'label' => __( 'Map Address', 'townpress' ),
                    'description' => esc_html__( 'This address will be used for header map.', 'townpress' ),
                    'type' => 'text',
                    'priority' => 3020,
                    'required' => array(
                        'setting' => 'header_map_enable',
                        'operator' => '==',
                        'value' => 'enable,enable-front',
                    ),
                ));

                // Latitude
                $lsvr_customizer->add_field( 'header_map_latitude', array(
                    'section' => 'header_settings',
                    'label' => __( 'Latitude', 'townpress' ),
                    'description' => esc_html__( 'Alternative way to display the header map. It can be more precise than using the address. For example: 44.465446.', 'townpress' ),
                    'type' => 'text',
                    'priority' => 3030,
                    'required' => array(
                        'setting' => 'header_map_enable',
                        'operator' => '==',
                        'value' => 'enable,enable-front',
                    ),
                ));

                // Longitude
                $lsvr_customizer->add_field( 'header_map_longitude', array(
                    'section' => 'header_settings',
                    'label' => __( 'Longitude', 'townpress' ),
                    'description' => esc_html__( 'Alternative way to display the header map. It can be more precise than using the address. For example: -72.687425.', 'townpress' ),
                    'type' => 'text',
                    'priority' => 3040,
                    'required' => array(
                        'setting' => 'header_map_enable',
                        'operator' => '==',
                        'value' => 'enable,enable-front',
                    ),
                ));

                // Map style
                $lsvr_customizer->add_field( 'header_map_type', array(
                    'section' => 'header_settings',
                    'label' => esc_html__( 'Map Type', 'townpress' ),
                    'type' => 'radio',
                    'choices' => array(
                        'roadmap' => esc_html__( 'Roadmap', 'townpress' ),
                        'satellite' => esc_html__( 'Satellite', 'townpress' ),
                        'terrain' => esc_html__( 'Terrain', 'townpress' ),
                        'hybrid' => esc_html__( 'Hybrid', 'townpress' ),
                    ),
                    'default' => 'roadmap',
                    'priority' => 3050,
                    'required' => array(
                        'setting' => 'header_map_enable',
                        'operator' => '==',
                        'value' => 'enable,enable-front',
                    ),
                ));

                // Map zoom level
                $lsvr_customizer->add_field( 'header_map_zoom', array(
                    'section' => 'header_settings',
                    'label' => esc_html__( 'Map Zoom Level', 'townpress' ),
                    'description' => esc_html__( 'Higher number means closer view. Not all map types support all zoom levels.', 'townpress' ),
                    'type' => 'lsvr-slider',
                    'choices' => array(
                        'min' => 1,
                        'max' => 20,
                        'step' => 1,
                    ),
                    'default' => 17,
                    'priority' => 3060,
                    'required' => array(
                        'setting' => 'header_map_enable',
                        'operator' => '==',
                        'value' => 'enable,enable-front',
                    ),
                ));

                // Map toggle label
                $lsvr_customizer->add_field( 'header_map_toggle_label', array(
                    'section' => 'header_settings',
                    'label' => __( 'Map Toggle Label', 'townpress' ),
                    'description' => esc_html__( 'Header map toggle button label.', 'townpress' ),
                    'type' => 'text',
                    'default' => esc_html__( 'Map', 'townpress' ),
                    'priority' => 3070,
                    'required' => array(
                        'setting' => 'header_map_enable',
                        'operator' => '==',
                        'value' => 'enable,enable-front',
                    ),
                ));

                // Separator
                $lsvr_customizer->add_separator( 'header_separator_4', array(
                    'section' => 'header_settings',
                    'priority' => 4000,
                ));

                // Enable Header Login
                $lsvr_customizer->add_field( 'header_login_enable', array(
                    'section' => 'header_settings',
                    'label' => esc_html__( 'Enable Header Login', 'townpress' ),
                    'description' => esc_html__( 'Display login button in header.', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => false,
                    'priority' => 4010,
                ));

                // Header login label
                $lsvr_customizer->add_field( 'header_login_label', array(
                    'section' => 'header_settings',
                    'label' => __( 'Login Label', 'townpress' ),
                    'description' => esc_html__( 'This text will be displayed when you hover over login button in header.', 'townpress' ),
                    'type' => 'text',
                    'default' => esc_html__( 'Login / Register', 'townpress' ),
                    'priority' => 4020,
                    'required' => array(
                        'setting' => 'header_login_enable',
                        'operator' => '==',
                        'value' => true,
                    ),
                ));

                // Header login page
                $lsvr_customizer->add_field( 'header_login_page', array(
                    'section' => 'header_settings',
                    'label' => __( 'Login Page', 'townpress' ),
                    'description' => esc_html__( 'Select a page which contains login form. If you are using bbPress plugin, you can create such page using [bbpress-login] and [bbp-register] shortcodes.', 'townpress' ),
                    'type' => 'select',
                    'choices' => lsvr_townpress_get_pages(),
                    'priority' => 4030,
                    'required' => array(
                        'setting' => 'header_login_enable',
                        'operator' => '==',
                        'value' => true,
                    ),
                ));

                // Separator
                $lsvr_customizer->add_separator( 'header_separator_5', array(
                    'section' => 'header_settings',
                    'priority' => 5000,
                ));

                // Enable Header Search
                $lsvr_customizer->add_field( 'header_search_enable', array(
                    'section' => 'header_settings',
                    'label' => esc_html__( 'Enable Header Search', 'townpress' ),
                    'description' => esc_html__( 'Display search form in header.', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => true,
                    'priority' => 5010,
                ));

                // Enable Sticky Navbar
                $lsvr_customizer->add_field( 'sticky_navbar_enable', array(
                    'section' => 'header_settings',
                    'label' => esc_html__( 'Enable Sticky Navbar', 'townpress' ),
                    'description' => esc_html__( 'Make header menu stick to the top of the page.', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => true,
                    'priority' => 5020,
                ));

            // Footer settings
            $lsvr_customizer->add_section( 'footer_settings', array(
                'title' => esc_html__( 'Footer', 'townpress' ),
                'priority' => 102,
            ));

                // Background Image
                $lsvr_customizer->add_field( 'footer_background_image', array(
                    'section' => 'footer_settings',
                    'label' => esc_html__( 'Background Image', 'townpress' ),
                    'description' => esc_html__( 'Optimal resolution is about 2000x1600px.', 'townpress' ),
                    'type' => 'image',
                    'priority' => 1010,
                ));

                // Separator
                $lsvr_customizer->add_separator( 'footer_separator_2', array(
                    'section' => 'footer_settings',
                    'priority' => 2000,
                ));

                // Footer widgets columns
                $lsvr_customizer->add_field( 'footer_widgets_columns', array(
                    'section' => 'footer_settings',
                    'label' => esc_html__( 'Widget Columns', 'townpress' ),
                    'description' => esc_html__( 'How many columns should be used to display widgets in the footer. You can populate the footer with widgets under Appearance / Widgets.', 'townpress' ),
                    'type' => 'lsvr-slider',
                    'choices' => array(
                        'min' => 1,
                        'max' => 4,
                        'step' => 1,
                    ),
                    'default' => 4,
                    'priority' => 2010,
                ));

                // Separator
                $lsvr_customizer->add_separator( 'footer_separator_3', array(
                    'section' => 'footer_settings',
                    'priority' => 3000,
                ));

                // Show social links
                $lsvr_customizer->add_field( 'footer_social_links_enable', array(
                    'section' => 'footer_settings',
                    'label' => esc_html__( 'Show Social Links in Footer', 'townpress' ),
                    'description' => esc_html__( 'You can manage them under Customizer / Social Links.', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => true,
                    'priority' => 3010,
                ));

                // Separator
                $lsvr_customizer->add_separator( 'footer_separator_4', array(
                    'section' => 'footer_settings',
                    'priority' => 4000,
                ));

                // Footer text
                $lsvr_customizer->add_field( 'footer_text', array(
                    'section' => 'footer_settings',
                    'label' => esc_html__( 'Footer Text', 'townpress' ),
                    'description' => esc_html__( 'Ideal for copyright info. You can use A, EM, BR, P and STRONG tags here. For example: &amp;copy; 2017 &lt;a href="mysite.com"&gt;MySite&lt;/a&gt;', 'townpress' ),
                    'type' => 'textarea',
                    'default'  => '&copy; ' . date( 'Y' ) . ' ' . get_bloginfo( 'name' ),
                    'priority' => 4010,
                ));

                // Separator
                $lsvr_customizer->add_separator( 'footer_separator_5', array(
                    'section' => 'footer_settings',
                    'priority' => 5000,
                ));

                // Enable back to top button
                $lsvr_customizer->add_field( 'back_to_top_button_enable', array(
                    'section' => 'footer_settings',
                    'label' => esc_html__( 'Back to Top Button', 'townpress' ),
                    'description' => esc_html__( 'Display a link to the top of the page.', 'townpress' ),
                    'type' => 'radio',
                    'choices' => array(
                        'disable' => esc_html__( 'Disable back to top button', 'townpress' ),
                        'enable' => esc_html__( 'Enable back to top button', 'townpress' ),
                        'desktop' => esc_html__( 'Enable on dektop only', 'townpress' ),
                        'mobile' => esc_html__( 'Enable on mobile only', 'townpress' ),
                    ),
                    'default' => 'disable',
                    'priority' => 5010,
                ));


            // Sidebar settings
            $lsvr_customizer->add_section( 'sidebar_settings', array(
                'title' => esc_html__( 'Custom Sidebars', 'townpress' ),
                'priority' => 115,
            ));

                // Custom sidebars
                $lsvr_customizer->add_field( 'custom_sidebars', array(
                    'section' => 'sidebar_settings',
                    'label' => esc_html__( 'Manage Custom Sidebars', 'townpress' ),
                    'description' => esc_html__( 'Here you can manage your custom sidebars. You can populate them with widgets under Appearance / Widgets. You can assign a sidebar to a page under Page Settings of that page. You can assign sidebars to post type pages (directory, events, galleries, etc.) in the Customizer.', 'townpress' ),
                    'type' => 'lsvr-sidebars',
                    'priority' => 1010,
                ));


            // Blog settings
            $lsvr_customizer->add_section( 'blog_settings', array(
                'title' => esc_html__( 'Standard Posts', 'townpress' ),
                'priority' => 120,
            ));

                // Enable author
                $lsvr_customizer->add_field( 'blog_archive_thumb_crop_enable', array(
                    'section' => 'blog_settings',
                    'label' => esc_html__( 'Crop Thumbnails', 'townpress' ),
                    'description' => esc_html__( 'Crop post thumbnails on post archive.', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => true,
                    'priority' => 1010,
                ));

                // Archive left sidebar ID
                $lsvr_customizer->add_field( 'blog_archive_sidebar_left_id', array(
                    'section' => 'blog_settings',
                    'label' => esc_html__( 'Archive Left Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose left sidebar to display on post archive.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array_merge(
                        array( 'disable' => esc_html__( 'Disable', 'townpress' ) ),
                        lsvr_townpress_get_sidebars()
                    ),
                    'priority' => 1020,
                    'default' => 'lsvr-townpress-default-sidebar-left',
                ));

                // Archive right sidebar ID
                $lsvr_customizer->add_field( 'blog_archive_sidebar_right_id', array(
                    'section' => 'blog_settings',
                    'label' => esc_html__( 'Archive Right Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose right sidebar to display on post archive.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array_merge(
                        array( 'disable' => esc_html__( 'Disable', 'townpress' ) ),
                        lsvr_townpress_get_sidebars()
                    ),
                    'priority' => 1030,
                    'default' => 'lsvr-townpress-default-sidebar-right',
                ));

                // Separator
                $lsvr_customizer->add_separator( 'blog_separator_1', array(
                    'section' => 'blog_settings',
                    'priority' => 2000,
                ));

                // Enable author
                $lsvr_customizer->add_field( 'blog_single_author_enable', array(
                    'section' => 'blog_settings',
                    'label' => esc_html__( 'Display Author on Detail', 'townpress' ),
                    'description' => esc_html__( 'Display post author on post detail.', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => true,
                    'priority' => 2010,
                ));

                // Enable post detail navigation
                $lsvr_customizer->add_field( 'blog_single_post_navigation_enable', array(
                    'section' => 'blog_settings',
                    'label' => esc_html__( 'Enable Post Detail Navigation', 'townpress' ),
                    'description' => esc_html__( 'Display links to previous and next posts at the bottom of the current post.', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => true,
                    'priority' => 2020,
                ));

                // Single left sidebar ID
                $lsvr_customizer->add_field( 'blog_single_sidebar_left_id', array(
                    'section' => 'blog_settings',
                    'label' => esc_html__( 'Detail Left Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose left sidebar to display on post detail.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array_merge(
                        array( 'disable' => esc_html__( 'Disable', 'townpress' ) ),
                        lsvr_townpress_get_sidebars()
                    ),
                    'priority' => 2030,
                    'default' => 'lsvr-townpress-default-sidebar-left',
                ));

                // Single right sidebar ID
                $lsvr_customizer->add_field( 'blog_single_sidebar_right_id', array(
                    'section' => 'blog_settings',
                    'label' => esc_html__( 'Detail Right Sidebar', 'townpress' ),
                    'description' => esc_html__( 'Choose right sidebar to display on post detail.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array_merge(
                        array( 'disable' => esc_html__( 'Disable', 'townpress' ) ),
                        lsvr_townpress_get_sidebars()
                    ),
                    'priority' => 2040,
                    'default' => 'lsvr-townpress-default-sidebar-right',
                ));


            // Typography
            $lsvr_customizer->add_section( 'typography_settings', array(
                'title' => esc_html__( 'Typography', 'townpress' ),
                'priority' => 210,
            ));

                // Enable Google Fonts
                $lsvr_customizer->add_field( 'typography_google_fonts_enable', array(
                    'section' => 'typography_settings',
                    'label' => esc_html__( 'Enable Google Fonts', 'townpress' ),
                    'description' => esc_html__( 'If you disable Google Fonts, default sans-serif font will be used for all text.', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => true,
                    'priority' => 1010,
                ));

                // Primary font
                $lsvr_customizer->add_field( 'typography_primary_font', array(
                    'section' => 'typography_settings',
                    'label' => esc_html__( 'Font Family', 'townpress' ),
                    'description' => esc_html__( 'Default font family is "Source Sans Pro".', 'townpress' ),
                    'type' => 'select',
                    'choices' => array(
                        'Alegreya' => 'Alegreya',
                        'Alegreya+Sans' => 'Alegreya Sans',
                        'Archivo+Narrow' => 'Archivo Narrow',
                        'Assistant' => 'Assistant',
                        'Fira+Sans' => 'Fira Sans',
                        'Hind' => 'Hind',
                        'Inconsolata' => 'Inconsolata',
                        'Karla' => 'Karla',
                        'Lato' => 'Lato',
                        'Libre+Baskerville' => 'Libre Baskerville',
                        'Lora' => 'Lora',
                        'Merriweather' => 'Merriweather',
                        'Montserrat' => 'Montserrat',
                        'Nunito+Sans' => 'Nunito Sans',
                        'Open+Sans' => 'Open Sans',
                        'PT+Serif' => 'PT Serif',
                        'Playfair+Display' => 'Playfair Display',
                        'Roboto' => 'Roboto',
                        'Roboto+Slab' => 'Roboto Slab',
                        'Source+Sans+Pro' => 'Source Sans Pro',
                        'Source+Serif+Pro' => 'Source Serif Pro',
                        'Work+Sans' => 'Work Sans',
                    ),
                    'default' => 'Source+Sans+Pro',
                    'priority' => 1020,
                    'required' => array(
                        'setting' => 'typography_google_fonts_enable',
                        'operator' => '==',
                        'value' => true,
                    ),
                ));

                // Base font size
                $lsvr_customizer->add_field( 'typography_base_font_size', array(
                    'section' => 'typography_settings',
                    'label' => esc_html__( 'Base Font Size', 'townpress' ),
                    'description' => esc_html__( 'Font size of basic content text. All other font sizes will also be calculated from this value. Default font size is 16px.', 'townpress' ),
                    'type' => 'select',
                    'choices' => array(
                        '12' => esc_html__( '12px', 'townpress' ),
                        '13' => esc_html__( '13px', 'townpress' ),
                        '14' => esc_html__( '14px', 'townpress' ),
                        '15' => esc_html__( '15px', 'townpress' ),
                        '16' => esc_html__( '16px', 'townpress' ),
                        '17' => esc_html__( '17px', 'townpress' ),
                        '18' => esc_html__( '18px', 'townpress' ),
                    ),
                    'default' => '16',
                    'priority' => 1040,
                ));

                // Font subsets
                $lsvr_customizer->add_field( 'typography_font_subsets', array(
                    'section' => 'typography_settings',
                    'label' => esc_html__( 'Font Subsets', 'townpress' ),
                    'description' => esc_html__( 'Only the Latin subset is loaded by default. If your site is in any other language than English, you may need to load an additional font subset. Please note that not all font families support all font subsets.', 'townpress' ),
                    'type' => 'lsvr-multicheck',
                    'choices' => array(
                        'latin-ext' => esc_html__( 'Latin Extended', 'townpress' ),
                        'greek' => esc_html__( 'Greek', 'townpress' ),
                        'greek-ext' => esc_html__( 'Greek Extended', 'townpress' ),
                        'vietnamese' => esc_html__( 'Vietnamese', 'townpress' ),
                        'cyrillic' => esc_html__( 'Cyrillic', 'townpress' ),
                        'cyrillic-ext' => esc_html__( 'Cyrillic Extended', 'townpress' ),
                    ),
                    'priority' => 1050,
                    'required' => array(
                        'setting' => 'typography_google_fonts_enable',
                        'operator' => '==',
                        'value' => true,
                    ),
                ));


            // Colors
            $lsvr_customizer->add_section( 'colors_settings', array(
                'title' => esc_html__( 'Colors', 'townpress' ),
                'priority' => 210,
            ));

                // Colors method
                $lsvr_customizer->add_field( 'colors_method', array(
                    'section' => 'colors_settings',
                    'label' => esc_html__( 'Set Colors By', 'townpress' ),
                    'type' => 'radio',
                    'choices' => array(
                        'predefined' => esc_html__( 'Predefined Scheme', 'townpress' ),
                        'custom-colors' => esc_html__( 'Custom Colors', 'townpress' ),
                        'custom-skin' => esc_html__( 'Custom Scheme', 'townpress' ),
                    ),
                    'default' => 'predefined',
                    'priority' => 1010,
                ));

                // Predefined skin
                $lsvr_customizer->add_field( 'colors_predefined_skin', array(
                    'section' => 'colors_settings',
                    'label' => esc_html__( 'Choose Predefined Skin', 'townpress' ),
                    'type' => 'select',
                    'choices' => array(
                        'default' => esc_html__( 'Default', 'townpress' ),
                        'blue' => esc_html__( 'Blue', 'townpress' ),
                        'green' => esc_html__( 'Green', 'townpress' ),
                        'orange' => esc_html__( 'Orange', 'townpress' ),
                        'bluegrey' => esc_html__( 'Blue-grey', 'townpress' ),
                    ),
                    'default' => 'default',
                    'priority' => 2010,
                    'required' => array(
                        'setting' => 'colors_method',
                        'operator' => '==',
                        'value' => 'predefined',
                    ),
                ));

                // Accent 1
                $lsvr_customizer->add_field( 'colors_custom_accent1', array(
                    'section' => 'colors_settings',
                    'label' => esc_html__( 'Accent', 'townpress' ),
                    'type' => 'color',
                    'default' => '#ec5237',
                    'priority' => 3010,
                    'required' => array(
                        'setting' => 'colors_method',
                        'operator' => '==',
                        'value' => 'custom-colors',
                    ),
                ));

                // Link
                $lsvr_customizer->add_field( 'colors_custom_link', array(
                    'section' => 'colors_settings',
                    'label' => esc_html__( 'Link', 'townpress' ),
                    'type' => 'color',
                    'default' => '#ec5237',
                    'priority' => 3030,
                    'required' => array(
                        'setting' => 'colors_method',
                        'operator' => '==',
                        'value' => 'custom-colors',
                    ),
                ));

                // Text
                $lsvr_customizer->add_field( 'colors_custom_text', array(
                    'section' => 'colors_settings',
                    'label' => esc_html__( 'Text', 'townpress' ),
                    'type' => 'color',
                    'default' => '#565656',
                    'priority' => 3040,
                    'required' => array(
                        'setting' => 'colors_method',
                        'operator' => '==',
                        'value' => 'custom-colors',
                    ),
                ));

                // Child lsvr_customizer's style.csss
                $lsvr_customizer->add_info( 'colors_info_skin', array(
                    'section' => 'colors_settings',
                    'label' => esc_html( 'About Custom Scheme', 'townpress' ),
                    'description' => esc_html__( 'Please refer to the documentation on how to generate your custom color scheme. Put your generated code into child theme\'s style.css file (you can access it via Appearance / Editor).', 'townpress' ),
                    'priority' => 4010,
                    'required' => array(
                        'setting' => 'colors_method',
                        'operator' => '==',
                        'value' => 'custom-skin',
                    ),
                ));


            // Social settings
            $lsvr_customizer->add_section( 'social_settings', array(
                'title' => esc_html__( 'Social Links', 'townpress' ),
                'priority' => 220,
            ));

                // Social Links
                $lsvr_customizer->add_field( 'social_links', array(
                    'section' => 'social_settings',
                    'label' => esc_html__( 'Add Social Links', 'townpress' ),
                    'description' => esc_html__( 'Insert URLs into inputs of social networks which you want to display. You can drag and drop items to change the order.', 'townpress' ),
                    'type' => 'lsvr-social-links',
                    'choices' => array(
                        'email' => array(
                            'label' => esc_html__( 'Email', 'townpress' ),
                            'icon' => 'icon-envelope-o',
                        ),
                        '500px' => array(
                            'label' => esc_html__( '500px', 'townpress' ),
                            'icon' => 'icon-500px',
                        ),
                        'bandcamp' => array(
                            'label' => esc_html__( 'Bandcamp', 'townpress' ),
                            'icon' => 'icon-bandcamp',
                        ),
                        'behance' => array(
                            'label' => esc_html__( 'Behance', 'townpress' ),
                            'icon' => 'icon-behance',
                        ),
                        'codepen' => array(
                            'label' => esc_html__( 'CodePen', 'townpress' ),
                            'icon' => 'icon-codepen',
                        ),
                        'deviantart' => array(
                            'label' => esc_html__( 'DeviantArt', 'townpress' ),
                            'icon' => 'icon-deviantart',
                        ),
                        'dribbble' => array(
                            'label' => esc_html__( 'Dribbble', 'townpress' ),
                            'icon' => 'icon-dribbble',
                        ),
                        'dropbox' => array(
                            'label' => esc_html__( 'Dropbox', 'townpress' ),
                            'icon' => 'icon-dropbox',
                        ),
                        'etsy' => array(
                            'label' => esc_html__( 'Etsy', 'townpress' ),
                            'icon' => 'icon-etsy',
                        ),
                        'facebook' => array(
                            'label' => esc_html__( 'Facebook', 'townpress' ),
                            'icon' => 'icon-facebook',
                        ),
                        'flickr' => array(
                            'label' => esc_html__( 'Flickr', 'townpress' ),
                            'icon' => 'icon-flickr',
                        ),
                        'foursquare' => array(
                            'label' => esc_html__( 'Foursquare', 'townpress' ),
                            'icon' => 'icon-foursquare',
                        ),
                        'github' => array(
                            'label' => esc_html__( 'Github', 'townpress' ),
                            'icon' => 'icon-github',
                        ),
                        'google-plus' => array(
                            'label' => esc_html__( 'Google+', 'townpress' ),
                            'icon' => 'icon-google-plus',
                        ),
                        'instagram' => array(
                            'label' => esc_html__( 'Instagram', 'townpress' ),
                            'icon' => 'icon-instagram',
                        ),
                        'lastfm' => array(
                            'label' => esc_html__( 'last.fm', 'townpress' ),
                            'icon' => 'icon-lastfm',
                        ),
                        'linkedin' => array(
                            'label' => esc_html__( 'LinkedIn', 'townpress' ),
                            'icon' => 'icon-linkedin',
                        ),
                        'odnoklassniki' => array(
                            'label' => esc_html__( 'Odnoklassniki', 'townpress' ),
                            'icon' => 'icon-odnoklassniki',
                        ),
                        'pinterest' => array(
                            'label' => esc_html__( 'Pinterest', 'townpress' ),
                            'icon' => 'icon-pinterest',
                        ),
                        'qq' => array(
                            'label' => esc_html__( 'QQ', 'townpress' ),
                            'icon' => 'icon-qq',
                        ),
                        'reddit' => array(
                            'label' => esc_html__( 'Reddit', 'townpress' ),
                            'icon' => 'icon-reddit',
                        ),
                        'skype' => array(
                            'label' => esc_html__( 'Skype', 'townpress' ),
                            'icon' => 'icon-skype',
                        ),
                        'slack' => array(
                            'label' => esc_html__( 'Slack', 'townpress' ),
                            'icon' => 'icon-slack',
                        ),
                        'snapchat' => array(
                            'label' => esc_html__( 'Snapchat', 'townpress' ),
                            'icon' => 'icon-snapchat',
                        ),
                        'tripadvisor' => array(
                            'label' => esc_html__( 'TripAdvisor', 'townpress' ),
                            'icon' => 'icon-tripadvisor',
                        ),
                        'tumblr' => array(
                            'label' => esc_html__( 'Tumblr', 'townpress' ),
                            'icon' => 'icon-tumblr',
                        ),
                        'twitch' => array(
                            'label' => esc_html__( 'Twitch', 'townpress' ),
                            'icon' => 'icon-twitch',
                        ),
                        'twitter' => array(
                            'label' => esc_html__( 'Twitter', 'townpress' ),
                            'icon' => 'icon-twitter',
                        ),
                        'vimeo' => array(
                            'label' => esc_html__( 'Vimeo', 'townpress' ),
                            'icon' => 'icon-vimeo',
                        ),
                        'vk' => array(
                            'label' => esc_html__( 'VK', 'townpress' ),
                            'icon' => 'icon-vk',
                        ),
                        'yahoo' => array(
                            'label' => esc_html__( 'Yahoo', 'townpress' ),
                            'icon' => 'icon-yahoo',
                        ),
                        'yelp' => array(
                            'label' => esc_html__( 'Yelp', 'townpress' ),
                            'icon' => 'icon-yelp',
                        ),
                        'youtube' => array(
                            'label' => esc_html__( 'YouTube', 'townpress' ),
                            'icon' => 'icon-youtube',
                        ),
                    ),
                    'priority' => 1000,
                ));

                // Separator
                $lsvr_customizer->add_separator( 'social_links_separator_2', array(
                    'section' => 'social_settings',
                    'priority' => 2000,
                ));

                // Enable Header Login
                $lsvr_customizer->add_field( 'social_links_new_window_enable', array(
                    'section' => 'social_settings',
                    'label' => esc_html__( 'Open social links in a new window', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => false,
                    'priority' => 2010,
                ));


            // Language settings
            $lsvr_customizer->add_section( 'language_settings', array(
                'title' => esc_html__( 'Languages', 'townpress' ),
                'priority' => 230,
            ));

                // About
                $lsvr_customizer->add_info( 'language_info', array(
                    'section' => 'language_settings',
                    'label' => esc_html( 'Info', 'townpress' ),
                    'description' => esc_html__( 'The following settings are useful if you want to run your site in more than one language. If you just want to translate the theme to a single language, please check out the documentation on how to do that.', 'townpress' ),
                    'priority' => 1000,
                ));

                // Language switcher
                $lsvr_customizer->add_field( 'language_switcher', array(
                    'section' => 'language_settings',
                    'label' => esc_html__( 'Language Switcher', 'townpress' ),
                    'description' => esc_html__( 'Display links to other language versions. WPML plugin is required for "WPML Generated" option to work.', 'townpress' ),
                    'type' => 'radio',
                    'choices' => array(
                        'disable' => esc_html__( 'Disable', 'townpress' ),
                        'wpml' => esc_html__( 'WPML Generated', 'townpress' ),
                        'custom' => esc_html__( 'Custom Links', 'townpress' ),
                    ),
                    'default' => 'disable',
                    'priority' => 1010,
                ));

                // Separator
                $lsvr_customizer->add_separator( 'language_separator_2', array(
                    'section' => 'language_settings',
                    'priority' => 2000,
                    'required' => array(
                        'setting' => 'language_switcher',
                        'operator' => '==',
                        'value' => 'custom',
                    ),
                ));

                // Custom lang 1 label
                $lsvr_customizer->add_field( 'language_custom1_label', array(
                    'section' => 'language_settings',
                    'label' => esc_html__( 'Language 1 Label', 'townpress' ),
                    'description' => esc_html__( 'For example "EN", "DE" or "ES".', 'townpress' ),
                    'type' => 'text',
                    'priority' => 2010,
                    'required' => array(
                        'setting' => 'language_switcher',
                        'operator' => '==',
                        'value' => 'custom',
                    ),
                ));

                // Custom lang 1 code
                $lsvr_customizer->add_field( 'language_custom1_code', array(
                    'section' => 'language_settings',
                    'label' => esc_html__( 'Language 1 Code', 'townpress' ),
                    'description' => esc_html__( 'It will be used to determine the active language. For example "en_US", "de_DE" or "es_ES".', 'townpress' ),
                    'type' => 'text',
                    'priority' => 2020,
                    'required' => array(
                        'setting' => 'language_switcher',
                        'operator' => '==',
                        'value' => 'custom',
                    ),
                ));

                // Custom lang 1 URL
                $lsvr_customizer->add_field( 'language_custom1_url', array(
                    'section' => 'language_settings',
                    'label' => esc_html__( 'Language 1 URL', 'townpress' ),
                    'description' => esc_html__( 'For example "http://mysite.com/en".', 'townpress' ),
                    'type' => 'text',
                    'priority' => 2030,
                    'required' => array(
                        'setting' => 'language_switcher',
                        'operator' => '==',
                        'value' => 'custom',
                    ),
                ));

                // Separator
                $lsvr_customizer->add_separator( 'language_separator_3', array(
                    'section' => 'language_settings',
                    'priority' => 3000,
                    'required' => array(
                        'setting' => 'language_switcher',
                        'operator' => '==',
                        'value' => 'custom',
                    ),
                ));

                // Custom lang 2 label
                $lsvr_customizer->add_field( 'language_custom2_label', array(
                    'section' => 'language_settings',
                    'label' => esc_html__( 'Language 2 Label', 'townpress' ),
                    'type' => 'text',
                    'priority' => 3010,
                    'required' => array(
                        'setting' => 'language_switcher',
                        'operator' => '==',
                        'value' => 'custom',
                    ),
                ));

                // Custom lang 2 code
                $lsvr_customizer->add_field( 'language_custom2_code', array(
                    'section' => 'language_settings',
                    'label' => esc_html__( 'Language 2 Code', 'townpress' ),
                    'type' => 'text',
                    'priority' => 3020,
                    'required' => array(
                        'setting' => 'language_switcher',
                        'operator' => '==',
                        'value' => 'custom',
                    ),
                ));

                // Custom lang 2 URL
                $lsvr_customizer->add_field( 'language_custom2_url', array(
                    'section' => 'language_settings',
                    'label' => esc_html__( 'Language 2 URL', 'townpress' ),
                    'type' => 'text',
                    'priority' => 3030,
                    'required' => array(
                        'setting' => 'language_switcher',
                        'operator' => '==',
                        'value' => 'custom',
                    ),
                ));

                // Separator
                $lsvr_customizer->add_separator( 'language_separator_4', array(
                    'section' => 'language_settings',
                    'priority' => 4000,
                    'required' => array(
                        'setting' => 'language_switcher',
                        'operator' => '==',
                        'value' => 'custom',
                    ),
                ));

                // Custom lang 3 label
                $lsvr_customizer->add_field( 'language_custom3_label', array(
                    'section' => 'language_settings',
                    'label' => esc_html__( 'Language 3 Label', 'townpress' ),
                    'type' => 'text',
                    'priority' => 4010,
                    'required' => array(
                        'setting' => 'language_switcher',
                        'operator' => '==',
                        'value' => 'custom',
                    ),
                ));

                // Custom lang 3 code
                $lsvr_customizer->add_field( 'language_custom3_code', array(
                    'section' => 'language_settings',
                    'label' => esc_html__( 'Language 3 Code', 'townpress' ),
                    'type' => 'text',
                    'priority' => 4020,
                    'required' => array(
                        'setting' => 'language_switcher',
                        'operator' => '==',
                        'value' => 'custom',
                    ),
                ));

                // Custom lang 3 URL
                $lsvr_customizer->add_field( 'language_custom3_url', array(
                    'section' => 'language_settings',
                    'label' => esc_html__( 'Language 3 URL', 'townpress' ),
                    'type' => 'text',
                    'priority' => 4030,
                    'required' => array(
                        'setting' => 'language_switcher',
                        'operator' => '==',
                        'value' => 'custom',
                    ),
                ));

                // Separator
                $lsvr_customizer->add_separator( 'language_separator_5', array(
                    'section' => 'language_settings',
                    'priority' => 5000,
                    'required' => array(
                        'setting' => 'language_switcher',
                        'operator' => '==',
                        'value' => 'custom',
                    ),
                ));

                // Custom lang 4 label
                $lsvr_customizer->add_field( 'language_custom4_label', array(
                    'section' => 'language_settings',
                    'label' => esc_html__( 'Language 4 Label', 'townpress' ),
                    'type' => 'text',
                    'priority' => 5010,
                    'required' => array(
                        'setting' => 'language_switcher',
                        'operator' => '==',
                        'value' => 'custom',
                    ),
                ));

                // Custom lang 4 code
                $lsvr_customizer->add_field( 'language_custom4_code', array(
                    'section' => 'language_settings',
                    'label' => esc_html__( 'Language 4 Code', 'townpress' ),
                    'type' => 'text',
                    'priority' => 5020,
                    'required' => array(
                        'setting' => 'language_switcher',
                        'operator' => '==',
                        'value' => 'custom',
                    ),
                ));

                // Custom lang 4 URL
                $lsvr_customizer->add_field( 'language_custom4_url', array(
                    'section' => 'language_settings',
                    'label' => esc_html__( 'Language 4 URL', 'townpress' ),
                    'type' => 'text',
                    'priority' => 5030,
                    'required' => array(
                        'setting' => 'language_switcher',
                        'operator' => '==',
                        'value' => 'custom',
                    ),
                ));


            // Misc settings
            $lsvr_customizer->add_section( 'misc_settings', array(
                'title' => esc_html__( 'Misc', 'townpress' ),
                'priority' => 240,
            ));

                 // Openweather.org API key
                $lsvr_customizer->add_field( 'openweathermap_api_key', array(
                    'section' => 'misc_settings',
                    'label' => __( 'OpenWeatherMap.org API Key', 'townpress' ),
                    'description' => esc_html__( 'Please insert your API key if you want to use LSVR TownPress Weather widget.', 'townpress' ),
                    'type' => 'text',
                    'priority' => 1010,
                ));

                 // Search input placeholder
                $lsvr_customizer->add_field( 'search_input_placeholder', array(
                    'section' => 'misc_settings',
                    'label' => __( 'Search Input Placeholder', 'townpress' ),
                    'description' => esc_html__( 'Placeholder text for search input.', 'townpress' ),
                    'type' => 'text',
                    'default' => esc_html__( 'Search this site...', 'townpress' ),
                    'priority' => 1020,
                ));

                // Separator
                $lsvr_customizer->add_separator( 'misc_separator_2', array(
                    'section' => 'misc_settings',
                    'priority' => 2000,
                ));

                // Disable Gutenberg editor
                $lsvr_customizer->add_field( 'gutenberg_is_disabled', array(
                    'section' => 'misc_settings',
                    'label' => esc_html__( 'Gutenberg Is Disabled', 'townpress' ),
                    'description' => esc_html__( 'Enable this if you are NOT using the Gutenberg editor.', 'townpress' ),
                    'type' => 'checkbox',
                    'default' => false,
                    'priority' => 2010,
                ));


            // Google Maps settings
            $lsvr_customizer->add_section( 'google_maps', array(
                'title' => esc_html__( 'Google Maps', 'townpress' ),
                'priority' => 250,
            ));

                // Google API key
                $lsvr_customizer->add_field( 'google_api_key', array(
                    'section' => 'google_maps',
                    'label' => __( 'Google API Key', 'townpress' ),
                    'description' => esc_html__( 'This key is needed to display Google Maps. More info on how to obtain your own API key:', 'townpress' ) . '<br><a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">https://developers.google.com/maps/documentation/javascript/get-api-key</a>',
                    'type' => 'text',
                    'priority' => 1010,
                ));

                // Enable custom maps style
                $lsvr_customizer->add_field( 'google_maps_style', array(
                    'section' => 'google_maps',
                    'label' => esc_html__( 'Google Map Style', 'townpress' ),
                    'description' => esc_html__( 'This will affect only the "terrain" and "roadmap" map styles.', 'townpress' ),
                    'type' => 'radio',
                    'choices' => array(
                        'default' => esc_html__( 'Use default map style', 'townpress' ),
                        'custom' => esc_html__( 'Add custom map style', 'townpress' ),
                    ),
                    'default' => 'default',
                    'priority' => 1020,
                ));

                // Google Maps style
                $lsvr_customizer->add_field( 'google_maps_style_custom', array(
                    'section' => 'google_maps',
                    'label' => __( 'Google Maps Style', 'townpress' ),
                    'description' => esc_html__( 'Override default custom style for Google maps with your own. Data must be provided in JavaScript array format. More info:', 'townpress' ) . '<br><a href="https://developers.google.com/maps/documentation/javascript/styling" target="_blank">https://developers.google.com/maps/documentation/javascript/styling</a>',
                    'type' => 'textarea',
                    'priority' => 1030,
                    'required' => array(
                        'setting' => 'google_maps_style',
                        'operator' => '==',
                        'value' => 'custom',
                    ),
                ));

        }

    }
}

?>