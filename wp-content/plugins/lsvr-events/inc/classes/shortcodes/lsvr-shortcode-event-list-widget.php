<?php
/**
 * LSVR Event List Widget Shortcode
 */
if ( ! class_exists( 'Lsvr_Shortcode_Event_List_Widget' ) ) {
    class Lsvr_Shortcode_Event_List_Widget {

        public static function shortcode( $atts = array(), $content = null, $tag = '' ) {

            // Merge default atts and received atts
            $args = shortcode_atts(
                array(
                    'title' => '',
                    'icon' => '',
                    'location' => 0,
                    'category' => 0,
                    'limit' => 4,
                    'bold_date' => 'false',
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
            $class_arr = array( 'widget shortcode-widget lsvr_event-list-widget lsvr_event-list-widget--shortcode' );
            if ( true === $editor_view ) {
                array_push( $class_arr, 'lsvr_event-list-widget--editor-view' );
            }
            if ( ! empty( $args['className'] ) ) {
                array_push( $class_arr, $args['className'] );
            }

            ob_start(); ?>

            <?php the_widget( 'Lsvr_Widget_Event_List', array(
                'title' => $args['title'],
                'location' => $args['location'],
                'category' => $args['category'],
                'limit' => $args['limit'],
                'bold_date' => $args['bold_date'],
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
                    'default' => esc_html__( 'Upcoming Events', 'lsvr-events' ),
                    'priority' => 10,
                ),

                // Location
                array(
                    'name' => 'location',
                    'type' => 'taxonomy',
                    'tax' => 'lsvr_event_location',
                    'label' => esc_html__( 'Location', 'lsvr-events' ),
                    'description' => esc_html__( 'Display events only from a certain location.', 'lsvr-events' ),
                    'priority' => 20,
                ),

                // Category
                array(
                    'name' => 'category',
                    'type' => 'taxonomy',
                    'tax' => 'lsvr_event_cat',
                    'label' => esc_html__( 'Category', 'lsvr-events' ),
                    'description' => esc_html__( 'Display events from a specific category.', 'lsvr-events' ),
                    'priority' => 30,
                ),

                // Limit
                array(
                    'name' => 'limit',
                    'type' => 'select',
                    'label' => esc_html__( 'Limit', 'lsvr-events' ),
                    'description' => esc_html__( 'How many events to display.', 'lsvr-events' ),
                    'choices' => array( 0 => esc_html__( 'All', 'lsvr-events' ) ) + range( 0, 20, 1 ),
                    'default' => 4,
                    'priority' => 40,
                ),

                // Bold date
                array(
                    'name' => 'bold_date',
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Bold Date', 'lsvr-events' ),
                    'default' => false,
                    'priority' => 50,
                ),

                // More label
                array(
                    'name' => 'more_label',
                    'type' => 'text',
                    'label' => esc_html__( 'More Link Label', 'lsvr-events' ),
                    'description' => esc_html__( 'Link to events archive. Leave blank to hide.', 'lsvr-events' ),
                    'default' => esc_html__( 'More events', 'lsvr-events' ),
                    'priority' => 60,
                ),

                // ID
                array(
                    'name' => 'id',
                    'type' => 'text',
                    'label' => esc_html__( 'Unique ID', 'lsvr-events' ),
                    'description' => esc_html__( 'You can use this ID to style this specific element with custom CSS, for example.', 'lsvr-events' ),
                    'priority' => 70,
                ),

            ), apply_filters( 'lsvr_event_list_widget_shortcode_atts', array() ) );
        }

    }
}
?>