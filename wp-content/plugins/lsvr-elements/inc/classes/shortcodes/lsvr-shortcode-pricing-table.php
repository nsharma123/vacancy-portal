<?php
/**
 * Pricing Table Shortcode
 */
if ( ! class_exists( 'Lsvr_Shortcode_Pricing_Table' ) ) {
    class Lsvr_Shortcode_Pricing_Table {

        public static function shortcode( $atts = array(), $content = null, $tag = '' ) {

            // Merge default atts and received atts
            $args = shortcode_atts(
                array(
                    'title' => '',
                    'price' => '',
                    'price_description' => '',
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
            $class = array( 'lsvr-pricing-table' );
            if ( true === $editor_view ) {
                array_push( $class_arr, 'lsvr-pricing-table--editor-view' );
            }
            if ( ! empty( $args['className'] ) ) {
                array_push( $class, $args['className'] );
            }

            ob_start(); ?>

            <div class="<?php echo esc_attr( implode( ' ', $class ) ); ?>"
                <?php echo ! empty( $args['id'] ) ? ' id="' . esc_attr( $args['id'] ) . '"' : ''; ?>>
                <div class="lsvr-pricing-table__inner">

                    <?php if ( ! empty( $args['title'] ) ) : ?>
                        <h3 class="lsvr-pricing-table__title">
                            <?php echo wp_kses( $args['title'], array(
                                'a' => array(
                                    'href' => array(),
                                    'target' => array(),
                                ),
                                'strong' => array(),
                            )); ?>
                        </h3>
                    <?php endif; ?>

                    <?php if ( ! empty( $args['price'] ) ) : ?>
                        <p class="lsvr-pricing-table__price">
                            <span class="lsvr-pricing-table__price-value"><?php echo esc_html( $args['price'] ); ?></span>
                            <?php if ( ! empty( $args['price_description'] ) ) : ?>
                                <em class="lsvr-pricing-table__price-description"><?php echo esc_html( $args['price_description'] ); ?></em>
                            <?php endif;  ?>
                        </p>
                    <?php endif;  ?>

                    <?php if ( ! empty( $args['text'] ) ) : ?>
                        <div class="lsvr-pricing-table__text">
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
                        <p class="lsvr-pricing-table__button">
                            <a href="<?php echo esc_url( $args['more_link'] ); ?>" class="lsvr-pricing-table__button-link">
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
                    'default' => esc_html__( 'Pricing Table', 'lsvr-elements' ),
                    'priority' => 10,
                ),

                // Price
                array(
                    'name' => 'price',
                    'type' => 'text',
                    'label' => esc_html__( 'Price', 'lsvr-elements' ),
                    'default' => esc_html__( '$99', 'lsvr-elements' ),
                    'priority' => 20,
                ),

                // Price description
                array(
                    'name' => 'price_description',
                    'type' => 'text',
                    'label' => esc_html__( 'Price Description', 'lsvr-elements' ),
                    'default' => esc_html__( 'per year', 'lsvr-elements' ),
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

            ), apply_filters( 'lsvr_pricing_table_shortcode_atts', array() ) );
        }

    }
}
?>