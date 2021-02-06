<?php
/**
 * LSVR Featured Event Widget Shortcode
 */
if ( ! class_exists( 'Lsvr_Shortcode_Event_Featured_Widget' ) ) {
    class Lsvr_Shortcode_Event_Featured_Widget {

        public static function shortcode( $atts = array(), $content = null, $tag = '' ) {

            // Merge default atts and received atts
            $args = shortcode_atts(
                array(
                    'title' => '',
                    'icon' => '',
                    'post' => '',
                    'show_excerpt' => 'true',
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
            $class_arr = array( 'widget shortcode-widget widget lsvr_event-featured-widget widget lsvr_event-featured-widget--shortcode' );
            if ( true === $editor_view ) {
                array_push( $class_arr, 'lsvr_event-featured-widget--editor-view' );
            }
            if ( ! empty( $args['className'] ) ) {
                array_push( $class_arr, $args['className'] );
            }

            ob_start(); ?>

            <?php the_widget( 'Lsvr_Widget_Event_Featured', array(
                'title' => $args['title'],
                'post' => $args['post'],
                'show_excerpt' => $args['show_excerpt'],
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
                    'label' => esc_html__( 'Title', 'lsvr-events' ),
                    'description' => esc_html__( 'Title of this section.', 'lsvr-events' ),
                    'default' => esc_html__( 'Featured Event', 'lsvr-events' ),
                    'priority' => 10,
                ),

                // Post
                array(
                    'name' => 'post',
                    'type' => 'post',
                    'post_type' => 'lsvr_event',
                    'label' => esc_html__( 'Event', 'lsvr-events' ),
                    'description' => esc_html__( 'Choose event to display.', 'lsvr-events' ),
                    'priority' => 20,
                ),

                // Display excerpt
                array(
                    'name' => 'show_excerpt',
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Display Excerpt', 'lsvr-events' ),
                    'default' => true,
                    'priority' => 30,
                ),

                // More label
                array(
                    'name' => 'more_label',
                    'type' => 'text',
                    'label' => esc_html__( 'More Link Label', 'lsvr-events' ),
                    'description' => esc_html__( 'Link to events archive. Leave blank to hide.', 'lsvr-events' ),
                    'default' => esc_html__( 'More events', 'lsvr-events' ),
                    'priority' => 40,
                ),

                // ID
                array(
                    'name' => 'id',
                    'type' => 'text',
                    'label' => esc_html__( 'Unique ID', 'lsvr-events' ),
                    'description' => esc_html__( 'You can use this ID to style this specific element with custom CSS, for example.', 'lsvr-events' ),
                    'priority' => 50,
                ),

            ), apply_filters( 'lsvr_event_featured_widget_shortcode_atts', array() ) );
        }

    }
}
?>