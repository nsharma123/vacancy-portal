<?php
/**
 * Feature Shortcode
 */
if ( ! class_exists( 'Lsvr_Shortcode_Feature' ) ) {
    class Lsvr_Shortcode_Feature {

        public static function shortcode( $atts = array(), $content = null, $tag = '' ) {

            // Merge default atts and received atts
            $args = shortcode_atts(
                array(
                    'title' => '',
                    'title_link' => '',
                    'icon' => '',
                    'text' => '',
                    'more_label' => '',
                    'more_link' => '',
                    'id' => '',
                    'className' => '',
                    'editor_view' => false,
                ),
                $atts
            );

            // Check if editor view
            $editor_view = true === $args['editor_view'] || '1' === $args['editor_view'] || 'true' === $args['editor_view'] ? true : false;

            // Get class
            $class = array( 'lsvr-feature' );
            if ( true === $editor_view ) {
                array_push( $class_arr, 'lsvr-feature--editor-view' );
            }
            if ( ! empty( $args['icon'] ) ) {
                array_push( $class, 'lsvr-feature--has-icon' );
            }
            if ( ! empty( $args['className'] ) ) {
                array_push( $class, $args['className'] );
            }

            ob_start(); ?>

            <div class="<?php echo esc_attr( implode( ' ', $class ) ); ?>"
                <?php echo ! empty( $args['id'] ) ? ' id="' . esc_attr( $args['id'] ) . '"' : ''; ?>>
                <div class="lsvr-feature__inner">

                    <?php if ( ! empty( $args['icon'] ) ) : ?>
                        <i class="lsvr-feature__icon <?php echo esc_attr( $args['icon'] ); ?>"></i>
                    <?php endif; ?>

                    <?php if ( ! empty( $args['title'] ) && ! empty( $args['title_link'] ) ) : ?>

                        <h3 class="lsvr-feature__title">
                            <a href="<?php echo esc_url( $args['title_link'] ); ?>"
                                class="lsvr-feature__title-link"><?php echo esc_html( $args['title'] ); ?></a>
                        </h3>

                    <?php elseif ( ! empty( $args['title'] ) ) : ?>

                        <h3 class="lsvr-feature__title">
                            <?php echo esc_html( $args['title'] ); ?>
                        </h3>

                    <?php endif; ?>

                    <?php if ( ! empty( $args['text'] ) ) : ?>

                        <div class="lsvr-feature__text">

                            <?php echo wpautop( wp_kses( $args['text'], array(
                                'a' => array(
                                    'href' => array(),
                                ),
                                'strong' => array(),
                            ))); ?>

                        </div>

                    <?php endif; ?>

                    <?php if ( ! empty( $args['more_label'] ) && ! empty( $args['more_link'] ) ) : ?>

                        <p class="lsvr-feature__more">
                            <a href="<?php echo esc_url( $args['more_link'] ); ?>"
                                class="lsvr-feature__more-link"><?php echo esc_html( $args['more_label'] ); ?></a>
                        </p>

                    <?php endif; ?>

                </div>
            </div>

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
                    'default' => esc_html__( 'Feature', 'lsvr-elements' ),
                    'priority' => 10,
                ),

                // Title link
                array(
                    'name' => 'title_link',
                    'type' => 'text',
                    'label' => esc_html__( 'Title Link', 'lsvr-elements' ),
                    'priority' => 20,
                ),

                // Icon
                array(
                    'name' => 'icon',
                    'type' => 'text',
                    'label' => esc_html__( 'Icon', 'lsvr-elements' ),
                    'description' => esc_html__( 'Insert icon class name. Please refer to the documentation to learn more about icons.', 'lsvr-elements' ),
                    'priority' => 30,
                ),

                // Text
                array(
                    'name' => 'text',
                    'type' => 'textarea',
                    'label' => esc_html__( 'Text', 'lsvr-elements' ),
                    'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 'lsvr-elements' ),
                    'priority' => 40,
                ),

                // More label
                array(
                    'name' => 'more_label',
                    'type' => 'text',
                    'label' => esc_html__( 'More Button Label', 'lsvr-elements' ),
                    'default' => esc_html__( 'Learn more', 'lsvr-elements' ),
                    'priority' => 50,
                ),

                // More link
                array(
                    'name' => 'more_link',
                    'type' => 'text',
                    'label' => esc_html__( 'More Button Link', 'lsvr-elements' ),
                    'default' => esc_html__( 'http://www.example.org', 'lsvr-elements' ),
                    'priority' => 60,
                ),

                // ID
                array(
                    'name' => 'id',
                    'type' => 'text',
                    'label' => esc_html__( 'Unique ID', 'lsvr-elements' ),
                    'priority' => 100,
                ),

            ), apply_filters( 'lsvr_feature_shortcode_atts', array() ) );
        }

    }
}
?>