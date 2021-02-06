<?php
/**
 * LSVR Person List Widget Shortcode
 */
if ( ! class_exists( 'Lsvr_Shortcode_Person_List_Widget' ) ) {
    class Lsvr_Shortcode_Person_List_Widget {

        public static function shortcode( $atts = array(), $content = null, $tag = '' ) {

            // Merge default atts and received atts
            $args = shortcode_atts(
                array(
                    'title' => '',
                    'icon' => '',
                    'category' => 0,
                    'limit' => 4,
                    'show_social' => 'true',
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
            $class_arr = array( 'widget shortcode-widget lsvr_person-list-widget lsvr_person-list-widget--shortcode' );
            if ( true === $editor_view ) {
                array_push( $class_arr, 'lsvr_person-list-widget--editor-view' );
            }
            if ( ! empty( $args['className'] ) ) {
                array_push( $class_arr, $args['className'] );
            }

            ob_start(); ?>

            <?php the_widget( 'Lsvr_Widget_Person_List', array(
                'title' => $args['title'],
                'category' => $args['category'],
                'limit' => $args['limit'],
                'show_social' => $args['show_social'],
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
                    'label' => esc_html__( 'Title', 'lsvr-galleries' ),
                    'description' => esc_html__( 'Title of this section.', 'lsvr-people' ),
                    'default' => esc_html__( 'People', 'lsvr-people' ),
                    'priority' => 10,
                ),

                // Category
                array(
                    'name' => 'category',
                    'type' => 'taxonomy',
                    'tax' => 'lsvr_person_cat',
                    'label' => esc_html__( 'Category', 'lsvr-people' ),
                    'description' => esc_html__( 'Display people from a specific category.', 'lsvr-people' ),
                    'priority' => 20,
                ),

                // Limit
                array(
                    'name' => 'limit',
                    'type' => 'select',
                    'label' => esc_html__( 'Limit', 'lsvr-people' ),
                    'description' => esc_html__( 'How many people to display.', 'lsvr-people' ),
                    'choices' => array( 0 => esc_html__( 'All', 'lsvr-people' ) ) + range( 0, 20, 1 ),
                    'default' => 4,
                    'priority' => 30,
                ),

                // Display social
                array(
                    'name' => 'show_social',
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Display Social Links', 'lsvr-people' ),
                    'default' => true,
                    'priority' => 40,
                ),

                // More label
                array(
                    'name' => 'more_label',
                    'type' => 'text',
                    'label' => esc_html__( 'More Link Label', 'lsvr-people' ),
                    'description' => esc_html__( 'Link to people archive. Leave blank to hide.', 'lsvr-people' ),
                    'default' => esc_html__( 'More people', 'lsvr-people' ),
                    'priority' => 50,
                ),

                // ID
                array(
                    'name' => 'id',
                    'type' => 'text',
                    'label' => esc_html__( 'Unique ID', 'lsvr-people' ),
                    'description' => esc_html__( 'You can use this ID to style this specific element with custom CSS, for example.', 'lsvr-people' ),
                    'priority' => 60,
                ),

            ), apply_filters( 'lsvr_person_list_widget_shortcode_atts', array() ) );
        }

    }
}
?>