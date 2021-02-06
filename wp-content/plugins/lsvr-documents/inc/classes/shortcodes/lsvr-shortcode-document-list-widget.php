<?php
/**
 * LSVR Document List Widget Shortcode
 */
if ( ! class_exists( 'Lsvr_Shortcode_Document_List_Widget' ) ) {
    class Lsvr_Shortcode_Document_List_Widget {

        public static function shortcode( $atts = array(), $content = null, $tag = '' ) {

            // Merge default atts and received atts
            $args = shortcode_atts(
                array(
                    'title' => '',
                    'icon' => '',
                    'category' => 0,
                    'tags' => '',
                    'limit' => 4,
                    'show_date' => 'true',
                    'show_attachment_count' => 'true',
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
            $class_arr = array( 'widget shortcode-widget lsvr_document-list-widget lsvr_document-list-widget--shortcode' );
            if ( true === $editor_view ) {
                array_push( $class_arr, 'lsvr_document-list-widget--editor-view' );
            }
            if ( ! empty( $args['className'] ) ) {
                array_push( $class_arr, $args['className'] );
            }

            ob_start(); ?>

            <?php the_widget( 'Lsvr_Widget_Document_List', array(
                'title' => $args['title'],
                'category' => $args['category'],
                'tags' => $args['tags'],
                'limit' => $args['limit'],
                'show_date' => $args['show_date'],
                'show_attachment_count' => $args['show_attachment_count'],
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
                    'default' => esc_html__( 'Latest Documents', 'lsvr-documents' ),
                    'priority' => 10,
                ),

                // Category
                array(
                    'name' => 'category',
                    'type' => 'taxonomy',
                    'tax' => 'lsvr_document_cat',
                    'label' => esc_html__( 'Category', 'lsvr-documents' ),
                    'description' => esc_html__( 'Display documents from a specific category.', 'lsvr-documents' ),
                    'priority' => 20,
                ),

                // Tags
                array(
                    'name' => 'tags',
                    'type' => 'text',
                    'label' => esc_html__( 'Tags', 'lsvr-documents' ),
                    'description' => esc_html__( 'Display only documents which contain certain tags. Separate tag slugs by comma.', 'lsvr-documents' ),
                    'priority' => 30,
                ),

                // Limit
                array(
                    'name' => 'limit',
                    'type' => 'select',
                    'label' => esc_html__( 'Limit', 'lsvr-documents' ),
                    'description' => esc_html__( 'How many documents to display.', 'lsvr-documents' ),
                    'choices' => array( 0 => esc_html__( 'All', 'lsvr-documents' ) ) + range( 0, 20, 1 ),
                    'default' => 4,
                    'priority' => 40,
                ),

                // Display date
                array(
                    'name' => 'show_date',
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Display Date', 'lsvr-documents' ),
                    'default' => true,
                    'priority' => 50,
                ),

                // Display attachment count
                array(
                    'name' => 'show_attachment_count',
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Display Attachment Count', 'lsvr-documents' ),
                    'default' => true,
                    'priority' => 60,
                ),

                // More label
                array(
                    'name' => 'more_label',
                    'type' => 'text',
                    'label' => esc_html__( 'More Link Label', 'lsvr-documents' ),
                    'description' => esc_html__( 'Link to documents archive. Leave blank to hide.', 'lsvr-documents' ),
                    'default' => esc_html__( 'More documents', 'lsvr-documents' ),
                    'priority' => 70,
                ),

                // ID
                array(
                    'name' => 'id',
                    'type' => 'text',
                    'label' => esc_html__( 'Unique ID', 'lsvr-documents' ),
                    'description' => esc_html__( 'You can use this ID to style this specific element with custom CSS, for example.', 'lsvr-documents' ),
                    'priority' => 80,
                ),


            ), apply_filters( 'lsvr_document_list_widget_shortcode_atts', array() ) );
        }

    }
}
?>