<?php
/**
 * LSVR Featured Document Widget Shortcode
 */
if ( ! class_exists( 'Lsvr_Shortcode_Document_Featured_Widget' ) ) {
    class Lsvr_Shortcode_Document_Featured_Widget {

        public static function shortcode( $atts = array(), $content = null, $tag = '' ) {

            // Merge default atts and received atts
            $args = shortcode_atts(
                array(
                    'title' => '',
                    'icon' => '',
                    'post' => '',
                    'show_date' => 'true',
                    'show_category' => 'true',
                    'show_excerpt' => 'true',
                    'show_attachments' => 'true',
                    'show_attachment_titles' => 'false',
                    'more_label' => '',
                    'id' => '',
                    'className' => '',
                    'editor_view' => false,
                ),
                $atts
            );

            // Check if editor view
            $editor_view = true === $args['editor_view'] || '1' === $args['editor_view'] || 'true' === $args['editor_view'] ? true : false;

            // Element class
            $class_arr = array( 'widget shortcode-widget lsvr_document-featured-widget lsvr_document-featured-widget--shortcode' );
            if ( true === $editor_view ) {
                array_push( $class_arr, 'lsvr_document-featured-widget--editor-view' );
            }
            if ( ! empty( $args['className'] ) ) {
                array_push( $class_arr, $args['className'] );
            }

            ob_start(); ?>

            <?php the_widget( 'Lsvr_Widget_Document_Featured', array(
                'title' => $args['title'],
                'post' => $args['post'],
                'show_date' => $args['show_date'],
                'show_category' => $args['show_category'],
                'show_excerpt' => $args['show_excerpt'],
                'show_attachments' => $args['show_attachments'],
                'show_attachment_titles' => $args['show_attachment_titles'],
                'more_label' => $args['more_label'],
                'editor_view' => $args['editor_view'],
            ), array(
                'before_widget' => '<div' . ( ! empty( $args['id'] ) ? ' id="' . esc_attr( $args['id'] ) . '"' : '' ) . ' class="' . esc_attr( implode( ' ', $class_arr ) ) . '"><div class="widget__inner">',
                'after_widget' => '</div></div>',
                'before_title' => ! empty( $args['icon'] ) ? '<h3 class="widget__title widget__title--has-icon"><i class="widget__title-icon ' . esc_attr( $args['icon'] ) . '"></i>' : '<h3 class="widget__title">',
                'after_title' => '</h3>',
            )); ?>

            <?php return ob_get_clean();

        }

        // Shortcode params
        public static function lsvr_shortcode_atts() {
            return array_merge( array(

                // Title
                array(
                    'name' => 'title',
                    'type' => 'text',
                    'label' => esc_html__( 'Title', 'lsvr-documents' ),
                    'description' => esc_html__( 'Title of this section.', 'lsvr-documents' ),
                    'default' => esc_html__( 'Featured Document', 'lsvr-documents' ),
                    'priority' => 10,
                ),

                // Post
                array(
                    'name' => 'post',
                    'type' => 'post',
                    'post_type' => 'lsvr_document',
                    'label' => esc_html__( 'Category', 'lsvr-documents' ),
                    'description' => esc_html__( 'Choose document to display.', 'lsvr-documents' ),
                    'priority' => 20,
                ),

                // Display date
                array(
                    'name' => 'show_date',
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Display Date', 'lsvr-documents' ),
                    'default' => true,
                    'priority' => 30,
                ),

                // Display category
                array(
                    'name' => 'show_category',
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Display Category', 'lsvr-documents' ),
                    'default' => true,
                    'priority' => 40,
                ),

                // Display excerpt
                array(
                    'name' => 'show_excerpt',
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Display Excerpt', 'lsvr-documents' ),
                    'default' => true,
                    'priority' => 50,
                ),

                // Display attachments
                array(
                    'name' => 'show_attachments',
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Display Attachments', 'lsvr-documents' ),
                    'default' => true,
                    'priority' => 60,
                ),

                // Display attachment titles
                array(
                    'name' => 'show_attachment_titles',
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Display Attachment Titles', 'lsvr-documents' ),
                    'description' => esc_html__( 'Display titles instead of file names. You can edit titles under Media.', 'lsvr-documents' ),
                    'default' => false,
                    'priority' => 70,
                ),

                // More label
                array(
                    'name' => 'more_label',
                    'type' => 'text',
                    'label' => esc_html__( 'More Link Label', 'lsvr-documents' ),
                    'description' => esc_html__( 'Link to documents archive. Leave blank to hide.', 'lsvr-documents' ),
                    'default' => esc_html__( 'More documents', 'lsvr-documents' ),
                    'priority' => 80,
                ),

                // ID
                array(
                    'name' => 'id',
                    'type' => 'text',
                    'label' => esc_html__( 'Unique ID', 'lsvr-documents' ),
                    'description' => esc_html__( 'You can use this ID to style this specific element with custom CSS, for example.', 'lsvr-documents' ),
                    'priority' => 90,
                ),

            ), apply_filters( 'lsvr_document_featured_widget_shortcode_atts', array() ) );
        }

    }
}
?>