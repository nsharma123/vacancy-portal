<?php
/**
 * LSVR Definition List Widget Shortcode
 */
if ( ! class_exists( 'Lsvr_Shortcode_Definition_List_Widget' ) ) {
    class Lsvr_Shortcode_Definition_List_Widget {

        public static function shortcode( $atts = array(), $content = null, $tag = '' ) {

            // Merge default atts and received atts
            $args = shortcode_atts(
                array(
                    'title' => '',
                    'item1_title' => '',
                    'item1_text' => '',
                    'item1_text_link' => '',
                    'item2_title' => '',
                    'item2_text' => '',
                    'item2_text_link' => '',
                    'item3_title' => '',
                    'item3_text' => '',
                    'item3_text_link' => '',
                    'item4_title' => '',
                    'item4_text' => '',
                    'item4_text_link' => '',
                    'item5_title' => '',
                    'item5_text' => '',
                    'item5_text_link' => '',
                    'more_label' => '',
                    'more_link' => '',
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
            $class_arr = array( 'widget shortcode-widget lsvr-definition-list-widget lsvr-definition-list-widget--shortcode' );
            if ( true === $editor_view ) {
                array_push( $class_arr, 'lsvr-definition-list-widget--editor-view' );
            }
            if ( ! empty( $args['className'] ) ) {
                array_push( $class_arr, $args['className'] );
            }

            ob_start(); ?>

            <?php the_widget( 'Lsvr_Widget_Definition_List', array(
                'title' => $args['title'],
                'item1_title' => $args['item1_title'],
                'item1_text' => $args['item1_text'],
                'item1_text_link' => $args['item1_text_link'],
                'item2_title' => $args['item2_title'],
                'item2_text' => $args['item2_text'],
                'item2_text_link' => $args['item2_text_link'],
                'item3_title' => $args['item3_title'],
                'item3_text' => $args['item3_text'],
                'item3_text_link' => $args['item3_text_link'],
                'item4_title' => $args['item4_title'],
                'item4_text' => $args['item4_text'],
                'item4_text_link' => $args['item4_text_link'],
                'item5_title' => $args['item5_title'],
                'item5_text' => $args['item5_text'],
                'item5_text_link' => $args['item5_text_link'],
                'more_label' => $args['more_label'],
                'more_link' => $args['more_link'],
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
                    'default' => esc_html__( 'Definition List', 'lsvr-elements' ),
                    'priority' => 10,
                ),

                // Item 1 title
                array(
                    'name' => 'item1_title',
                    'type' => 'text',
                    'label' => esc_html__( 'Item 1 Title', 'lsvr-elements' ),
                    'default' => esc_html__( 'Lorem ipsum', 'lsvr-elements' ),
                    'priority' => 110,
                ),

                // Item 1 text
                array(
                    'name' => 'item1_text',
                    'type' => 'text',
                    'label' => esc_html__( 'Item 1 Text', 'lsvr-elements' ),
                    'default' => esc_html__( 'Dolor sit amet', 'lsvr-elements' ),
                    'priority' => 120,
                ),

                // Item 1 text link
                array(
                    'name' => 'item1_text_link',
                    'type' => 'text',
                    'label' => esc_html__( 'Item 1 Text Link', 'lsvr-elements' ),
                    'default' => esc_html__( 'http://www.example.org', 'lsvr-elements' ),
                    'priority' => 130,
                ),

                // Item 2 title
                array(
                    'name' => 'item2_title',
                    'type' => 'text',
                    'label' => esc_html__( 'Item 2 Title', 'lsvr-elements' ),
                    'default' => esc_html__( 'Consectetuer adipiscing', 'lsvr-elements' ),
                    'priority' => 210,
                ),

                // Item 2 text
                array(
                    'name' => 'item2_text',
                    'type' => 'text',
                    'label' => esc_html__( 'Item 2 Text', 'lsvr-elements' ),
                    'default' => esc_html__( 'Aenean commodo', 'lsvr-elements' ),
                    'priority' => 220,
                ),

                // Item 2 text link
                array(
                    'name' => 'item2_text_link',
                    'type' => 'text',
                    'label' => esc_html__( 'Item 2 Text Link', 'lsvr-elements' ),
                    'default' => esc_html__( 'http://www.example.org', 'lsvr-elements' ),
                    'priority' => 230,
                ),

                // Item 3 title
                array(
                    'name' => 'item3_title',
                    'type' => 'text',
                    'label' => esc_html__( 'Item 3 Title', 'lsvr-elements' ),
                    'default' => esc_html__( 'Aenean massa', 'lsvr-elements' ),
                    'priority' => 310,
                ),

                // Item 3 text
                array(
                    'name' => 'item3_text',
                    'type' => 'text',
                    'label' => esc_html__( 'Item 3 Text', 'lsvr-elements' ),
                    'default' => esc_html__( 'Parturient montes', 'lsvr-elements' ),
                    'priority' => 320,
                ),

                // Item 3 text link
                array(
                    'name' => 'item3_text_link',
                    'type' => 'text',
                    'label' => esc_html__( 'Item 3 Text Link', 'lsvr-elements' ),
                    'default' => esc_html__( 'http://www.example.org', 'lsvr-elements' ),
                    'priority' => 330,
                ),

                // Item 4 title
                array(
                    'name' => 'item4_title',
                    'type' => 'text',
                    'label' => esc_html__( 'Item 4 Title', 'lsvr-elements' ),
                    'priority' => 410,
                ),

                // Item 4 text
                array(
                    'name' => 'item4_text',
                    'type' => 'text',
                    'label' => esc_html__( 'Item 4 Text', 'lsvr-elements' ),
                    'priority' => 420,
                ),

                // Item 4 text link
                array(
                    'name' => 'item4_text_link',
                    'type' => 'text',
                    'label' => esc_html__( 'Item 4 Text Link', 'lsvr-elements' ),
                    'priority' => 430,
                ),

                // Item 5 title
                array(
                    'name' => 'item5_title',
                    'type' => 'text',
                    'label' => esc_html__( 'Item 5 Title', 'lsvr-elements' ),
                    'priority' => 510,
                ),

                // Item 5 text
                array(
                    'name' => 'item5_text',
                    'type' => 'text',
                    'label' => esc_html__( 'Item 5 Text', 'lsvr-elements' ),
                    'priority' => 520,
                ),

                // Item 5 text link
                array(
                    'name' => 'item5_text_link',
                    'type' => 'text',
                    'label' => esc_html__( 'Item 5 Text Link', 'lsvr-elements' ),
                    'priority' => 530,
                ),

                // More label
                array(
                    'name' => 'more_label',
                    'type' => 'text',
                    'label' => esc_html__( 'More Button Label', 'lsvr-elements' ),
                    'default' => esc_html__( 'Learn more', 'lsvr-elements' ),
                    'priority' => 1000,
                ),

                // More link
                array(
                    'name' => 'more_link',
                    'type' => 'text',
                    'label' => esc_html__( 'More Button Link', 'lsvr-elements' ),
                    'default' => esc_html__( 'http://www.example.org', 'lsvr-elements' ),
                    'priority' => 1010,
                ),

                // ID
                array(
                    'name' => 'id',
                    'type' => 'text',
                    'label' => esc_html__( 'Unique ID', 'lsvr-elements' ),
                    'description' => esc_html__( 'You can use this ID to style this specific element with custom CSS, for example.', 'lsvr-elements' ),
                    'priority' => 1020,
                ),

            ), apply_filters( 'lsvr_definition_list_widget_shortcode_atts', array() ) );
        }

    }
}
?>