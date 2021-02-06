<?php
/**
 * LSVR TownPress Widgets Shortcode
 */
if ( ! class_exists( 'Lsvr_Shortcode_Townpress_Sidebar' ) ) {
    class Lsvr_Shortcode_Townpress_Sidebar {

        public static function shortcode( $atts = array(), $content = null, $tag = '' ) {

            // Merge default atts and received atts
            $args = shortcode_atts(
                array(
                    'sidebar_id' => 'lsvr-townpress-default-sidebar-left',
                    'columns_count' => 2,
                    'id' => '',
                    'className' => '',
                    'editor_view' => false,
                ),
                $atts
            );

            // Check if editor view
            $editor_view = true === $args['editor_view'] || '1' === $args['editor_view'] || 'true' === $args['editor_view'] ? true : false;

            // Element class
            $class_arr = array( 'lsvr-townpress-sidebar' );
            if ( true === $editor_view ) {
                array_push( $class_arr, 'lsvr-townpress-sidebar--editor-view' );
            }
            if ( ! empty( $args['className'] ) ) {
                array_push( $class_arr, $args['className'] );
            }

            ob_start(); ?>

            <section class="<?php echo esc_attr( implode( ' ', $class_arr ) ); ?>"
                <?php echo ! empty( $args['id'] ) ? ' id="' . esc_attr( $args['id'] ) . '"' : ''; ?>>
                <div class="lsvr-townpress-sidebar__inner">

                    <?php if ( ! empty( $args['sidebar_id'] ) && is_active_sidebar( $args['sidebar_id'] ) ) : ?>

                        <div class="lsvr-townpress-sidebar__list lsvr-townpress-sidebar__list--<?php echo ! empty( $args['columns_count'] ) ? esc_attr( $args['columns_count'] ) : 2; ?>-cols">
                            <?php dynamic_sidebar( $args['sidebar_id'] ); ?>
                        </div>

                    <?php endif; ?>

                </div>
            </section>

            <?php return ob_get_clean();

        }

        // Shortcode params
        public static function lsvr_shortcode_atts() {
            return array_merge( array(

                // Sidebar ID
                array(
                    'name' => 'sidebar_id',
                    'type' => 'select',
                    'label' => esc_html__( 'Sidebar', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'Choose which sidebar will be used to create this section. You can manage custom sidebars under Customizer / Custom Sidebars and populate them with widgets under Appearance / Widgets.', 'lsvr-townpress-toolkit' ),
                    'choices' => lsvr_townpress_toolkit_get_sidebars(),
                    'priority' => 10,
                ),

                // Columns count
                array(
                    'name' => 'columns_count',
                    'type' => 'select',
                    'label' => esc_html__( 'Number of Columns', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'How many columns should be used to display the widgets.', 'lsvr-townpress-toolkit' ),
                    'choices' => array( 1 => 1, 2 => 2, 3 => 3, 4 => 4 ),
                    'default' => 2,
                    'priority' => 20,
                ),

                // ID
                array(
                    'name' => 'id',
                    'type' => 'text',
                    'label' => esc_html__( 'Unique ID', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'You can use this ID to style this specific element with custom CSS, for example.', 'lsvr-townpress-toolkit' ),
                    'priority' => 30,
                ),

            ), apply_filters( 'lsvr_townpress_sidebar_shortcode_atts', array() ) );
        }

    }
}
?>