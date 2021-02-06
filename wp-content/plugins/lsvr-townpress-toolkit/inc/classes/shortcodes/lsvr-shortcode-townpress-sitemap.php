<?php
/**
 * LSVR TownPress Sitemap Shortcode
 */
if ( ! class_exists( 'Lsvr_Shortcode_Townpress_Sitemap' ) ) {
    class Lsvr_Shortcode_Townpress_Sitemap {

        public static function shortcode( $atts = array(), $content = null, $tag = '' ) {

            // Merge default atts and received atts
            $args = shortcode_atts(
                array(
                    'title' => '',
                    'icon' => '',
                    'menu_id' => '',
                    'columns_count' => 3,
                    'id' => '',
                    'className' => '',
                    'editor_view' => false,
                ),
                $atts
            );

            // Check if editor view
            $editor_view = true === $args['editor_view'] || '1' === $args['editor_view'] || 'true' === $args['editor_view'] ? true : false;

            // Element class
            $class_arr = array( 'lsvr-townpress-sitemap' );
            if ( true === $editor_view ) {
                array_push( $class_arr, 'lsvr-townpress-sitemap--editor-view' );
            }
            if ( ! empty( $args['className'] ) ) {
                array_push( $class_arr, $args['className'] );
            }

            ob_start(); ?>

            <section class="<?php echo esc_attr( implode( ' ', $class_arr ) ); ?>"
                <?php echo ! empty( $args['id'] ) ? ' id="' . esc_attr( $args['id'] ) . '"' : ''; ?>>
                <div class="c-content-box lsvr-townpress-sitemap__inner">

                    <?php if ( ! empty( $args['icon'] ) ) : ?>
                        <i class="lsvr-townpress-sitemap__icon <?php echo esc_html( $args['icon'] ); ?>"></i>
                    <?php endif; ?>

                    <?php if ( ! empty( $args['title'] ) ) : ?>

                        <header class="lsvr-townpress-sitemap__header">
                            <h2 class="lsvr-townpress-sitemap__title<?php if ( ! empty( $args['icon'] ) ) { echo ' lsvr-townpress-sitemap__title--has-icon'; } ?>">
                                <?php if ( ! empty( $args['icon'] ) ) : ?>
                                    <i class="lsvr-townpress-sitemap__title-icon <?php echo esc_html( $args['icon'] ); ?>"></i>
                                <?php endif; ?>
                                <?php echo wp_kses( $args['title'], array(
                                    'strong' => array(),
                                )); ?>
                            </h2>
                        </header>

                    <?php endif; ?>

                    <?php if ( ! empty( $args['menu_id'] ) ) : ?>

                        <div class="lsvr-townpress-sitemap__content">
                            <nav class="lsvr-townpress-sitemap__nav lsvr-townpress-sitemap__nav--<?php echo ! empty( $args['columns_count'] ) ? esc_attr( $args['columns_count'] ) : 3; ?>-cols">
                                <?php wp_nav_menu(array(
                                    'menu' => $args['menu_id'],
                                    'container' => '',
                                    'menu_class' => 'lsvr-townpress-sitemap__list',
                                    'fallback_cb' => '',
                                    'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                                    'walker' => new Lsvr_Townpress_Sitemap_Walker,
                                )); ?>
                            </nav>
                        </div>

                    <?php else : ?>

                        <p class="c-alert-message lsvr-townpress-sitemap__message">
                            <?php esc_html_e( 'Please choose which menu will be used to create this sitemap.', 'lsvr-townpress-toolkit' ); ?>
                        </p>

                    <?php endif; ?>

                </div>
            </section>

            <?php return ob_get_clean();

        }

        // Shortcode params
        public static function lsvr_shortcode_atts() {
            return array_merge( array(

                // Title
                array(
                    'name' => 'title',
                    'type' => 'text',
                    'label' => esc_html__( 'Title', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'Title of this section.', 'lsvr-townpress-toolkit' ),
                    'default' => esc_html__( 'Choose Your Interest', 'lsvr-townpress-toolkit' ),
                    'priority' => 10,
                ),

                // Icon
                array(
                    'name' => 'icon',
                    'type' => 'text',
                    'label' => esc_html__( 'Icon', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'Icon name. Please refer to the documentation to learn more about icons.', 'lsvr-townpress-toolkit' ),
                    'default' => 'icon-road-sign',
                    'priority' => 20,
                ),

                // Menu ID
                array(
                    'name' => 'menu_id',
                    'type' => 'menu',
                    'label' => esc_html__( 'Menu', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'Choose which menu will be used to create the sitemap. You can manage menus under Appearance / Menus.', 'lsvr-townpress-toolkit' ),
                    'priority' => 30,
                ),

                // Columns count
                array(
                    'name' => 'columns_count',
                    'type' => 'select',
                    'label' => esc_html__( 'Number of Columns', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'How many columns should be used to display the sitemap.', 'lsvr-townpress-toolkit' ),
                    'choices' => array( 1 => 1 , 2 => 2, 3 => 3, 4 => 4 ),
                    'default' => 3,
                    'priority' => 40,
                ),

                // ID
                array(
                    'name' => 'id',
                    'type' => 'text',
                    'label' => esc_html__( 'Unique ID', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'You can use this ID to style this specific element with custom CSS, for example.', 'lsvr-townpress-toolkit' ),
                    'priority' => 50,
                ),

            ), apply_filters( 'lsvr_townpress_sitemap_shortcode_atts', array() ) );
        }

    }
}
?>