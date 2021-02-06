<?php
/**
 * LSVR Post List Widget Shortcode
 */
if ( ! class_exists( 'Lsvr_Shortcode_Post_List_Widget' ) ) {
    class Lsvr_Shortcode_Post_List_Widget {

        public static function shortcode( $atts = array(), $content = null, $tag = '' ) {

            // Merge default atts and received atts
            $args = shortcode_atts(
                array(
                    'title' => '',
                    'category' => 0,
                    'limit' => 4,
                    'show_thumb' => 'true',
                    'show_date' => 'true',
                    'show_category' => 'true',
                    'more_label' => '',
                    'id' => '',
                    'className' => '',
                    'icon' => '',
                    'editor_view' => false,
                ),
                $atts
            );

            // Check if editor view
            $editor_view = true === $args['editor_view'] || '1' === $args['editor_view'] || 'true' === $args['editor_view'] ? true : false;

            // Element class
            $class_arr = array( 'widget shortcode-widget lsvr-post-list-widget lsvr-post-list-widget--shortcode' );
            if ( true === $editor_view ) {
                array_push( $class_arr, 'lsvr-post-list-widget--editor-view' );
            }
            if ( ! empty( $args['className'] ) ) {
                array_push( $class_arr, $args['className'] );
            }

            ob_start(); ?>

            <?php the_widget( 'Lsvr_Widget_Post_List', array(
                'title' => $args['title'],
                'category' => $args['category'],
                'limit' => $args['limit'],
                'show_thumb' => $args['show_thumb'],
                'show_date' => $args['show_date'],
                'show_category' => $args['show_category'],
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
                    'label' => esc_html__( 'Title', 'lsvr-elements' ),
                    'description' => esc_html__( 'Title of this section.', 'lsvr-elements' ),
                    'default' => esc_html__( 'Latest Posts', 'lsvr-elements' ),
                    'priority' => 10,
                ),

                // Category
                array(
                    'name' => 'category',
                    'type' => 'taxonomy',
                    'tax' => 'category',
                    'label' => esc_html__( 'Category', 'lsvr-elements' ),
                    'description' => esc_html__( 'Display posts from a specific category.', 'lsvr-elements' ),
                    'priority' => 20,
                ),

                // Limit
                array(
                    'name' => 'limit',
                    'type' => 'select',
                    'label' => esc_html__( 'Limit', 'lsvr-elements' ),
                    'description' => esc_html__( 'How many posts to display.', 'lsvr-elements' ),
                    'choices' => array( 0 => esc_html__( 'All', 'lsvr-elements' ) ) + range( 0, 20, 1 ),
                    'default' => 4,
                    'priority' => 30,
                ),

                // Display thubmnail
                array(
                    'name' => 'show_thumb',
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Display Thumbnail', 'lsvr-elements' ),
                    'default' => true,
                    'priority' => 40,
                ),

                // Display date
                array(
                    'name' => 'show_date',
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Display Date', 'lsvr-elements' ),
                    'default' => true,
                    'priority' => 50,
                ),

                // Display category
                array(
                    'name' => 'show_category',
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Display Category', 'lsvr-elements' ),
                    'default' => true,
                    'priority' => 60,
                ),

                // More label
                array(
                    'name' => 'more_label',
                    'type' => 'text',
                    'label' => esc_html__( 'More Button Label', 'lsvr-elements' ),
                    'description' => esc_html__( 'Link to post archive. Leave blank to hide.', 'lsvr-elements' ),
                    'default' => esc_html__( 'More posts', 'lsvr-elements' ),
                    'priority' => 200,
                ),

                // ID
                array(
                    'name' => 'id',
                    'type' => 'text',
                    'label' => esc_html__( 'Unique ID', 'lsvr-elements' ),
                    'description' => esc_html__( 'You can use this ID to style this specific element with custom CSS, for example.', 'lsvr-elements' ),
                    'priority' => 210,
                ),

            ), apply_filters( 'lsvr_post_list_widget_shortcode_atts', array() ) );
        }

    }
}
?>