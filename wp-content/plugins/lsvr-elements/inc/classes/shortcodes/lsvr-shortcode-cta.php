<?php
/**
 * CTA Shortcode
 */
if ( ! class_exists( 'Lsvr_Shortcode_CTA' ) ) {
    class Lsvr_Shortcode_CTA {

        public static function shortcode( $atts = array(), $content = null, $tag = '' ) {

            // Merge default atts and received atts
            $args = shortcode_atts(
                array(
                    'title' => '',
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
            $class = array( 'lsvr-cta' );
            if ( true === $editor_view ) {
                array_push( $class_arr, 'lsvr-cta--editor-view' );
            }
            if ( ! empty( $args['className'] ) ) {
                array_push( $class, $args['className'] );
            }
            if ( ! empty( $args['more_label'] ) && ! empty( $args['more_link'] ) ) {
                array_push( $class, 'lsvr-cta--has-button' );
            }

            ob_start(); ?>

            <div class="<?php echo esc_attr( implode( ' ', $class ) ); ?>"
                <?php echo ! empty( $args['id'] ) ? ' id="' . esc_attr( $args['id'] ) . '"' : ''; ?>>
                <div class="lsvr-cta__inner">

                    <?php if ( ! empty( $args['title'] ) ) : ?>
                        <h3 class="lsvr-cta__title">
                            <?php echo wp_kses( $args['title'], array(
                                'a' => array(
                                    'href' => array(),
                                    'target' => array(),
                                ),
                                'strong' => array(),
                            )); ?>
                        </h3>
                    <?php endif; ?>

                    <?php if ( ! empty( $args['text'] ) ) : ?>
                        <div class="lsvr-cta__text">
                            <?php echo wpautop( wp_kses( $args['text'], array(
                                'a' => array(
                                    'href' => array(),
                                    'target' => array(),
                                ),
                                'br' => array(),
                                'strong' => array(),
                            ))); ?>
                        </div>
                    <?php endif; ?>

                   <?php if ( ! empty( $args['more_label'] ) && ! empty( $args['more_link'] ) ) : ?>
                        <p class="lsvr-cta__button">
                            <a href="<?php echo esc_url( $args['more_link'] ); ?>" class="lsvr-cta__button-link">
                                <?php echo esc_html( $args['more_label'] ); ?>
                            </a>
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
                    'default' => esc_html__( 'CTA', 'lsvr-elements' ),
                    'priority' => 10,
                ),

                // Text
                array(
                    'name' => 'text',
                    'type' => 'textarea',
                    'label' => esc_html__( 'Text', 'lsvr-elements' ),
                    'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 'lsvr-elements' ),
                    'priority' => 20,
                ),

                // More label
                array(
                    'name' => 'more_label',
                    'type' => 'text',
                    'label' => esc_html__( 'More Button Label', 'lsvr-elements' ),
                    'default' => esc_html__( 'Learn more', 'lsvr-elements' ),
                    'priority' => 30,
                ),

                // More link
                array(
                    'name' => 'more_link',
                    'type' => 'text',
                    'label' => esc_html__( 'More Button Link', 'lsvr-elements' ),
                    'default' => esc_html__( 'http://www.example.org', 'lsvr-elements' ),
                    'priority' => 40,
                ),

                // ID
                array(
                    'name' => 'id',
                    'type' => 'text',
                    'label' => esc_html__( 'Unique ID', 'lsvr-elements' ),
                    'priority' => 100,
                ),

            ), apply_filters( 'lsvr_cta_shortcode_atts', array() ) );
        }

    }
}
?>