<?php
/**
 * Counter Shortcode
 */
if ( ! class_exists( 'Lsvr_Shortcode_Counter' ) ) {
    class Lsvr_Shortcode_Counter {

        public static function shortcode( $atts = array(), $content = null, $tag = '' ) {

            // Merge default atts and received atts
            $args = shortcode_atts(
                array(
                    'number' => '',
                    'number_unit' => '',
                    'label' => '',
                    'id' => '',
                    'className' => '',
                    'editor_view' => false,
                ),
                $atts
            );

            // Check if editor view
            $editor_view = true === $args['editor_view'] || '1' === $args['editor_view'] || 'true' === $args['editor_view'] ? true : false;

            // Get class
            $class = array( 'lsvr-counter' );
            if ( true === $editor_view ) {
                array_push( $class_arr, 'lsvr-counter--editor-view' );
            }
            if ( ! empty( $args['className'] ) ) {
                array_push( $class, $args['className'] );
            }

            ob_start(); ?>

            <div class="<?php echo esc_attr( implode( ' ', $class ) ); ?>"
                <?php echo ! empty( $args['id'] ) ? ' id="' . esc_attr( $args['id'] ) . '"' : ''; ?>>
                <div class="lsvr-counter__inner">

                    <?php if ( ! empty( $args['number_unit'] ) ) : ?>

                        <h3 class="lsvr-counter__number">
                            <?php echo esc_html( $args['number'] ); ?><span class="lsvr-counter__number-unit"><?php echo esc_html( $args['number_unit'] ); ?></span>
                        </h3>

                    <?php else : ?>

                        <h3 class="lsvr-counter__number">
                            <?php echo esc_html( $args['number'] ); ?>
                        </h3>

                    <?php endif; ?>

                    <?php if ( ! empty( $args['label'] ) ) : ?>

                        <p class="lsvr-counter__label">
                            <?php echo wp_kses( $args['label'], array(
                                'a' => array(
                                    'href' => '',
                                ),
                                'strong' => array(),
                            )); ?>
                        </p>

                    <?php endif; ?>

                </div>
            </div>

            <?php return ob_get_clean();

        }

        // Shortcode params
        public static function lsvr_shortcode_atts() {
            return array_merge( array(

                // Number
                array(
                    'name' => 'number',
                    'type' => 'text',
                    'label' => esc_html__( 'Number', 'lsvr-elements' ),
                    'description' => esc_html__( 'Counter number.', 'lsvr-elements' ),
                    'default' => 50,
                    'priority' => 10,
                ),

                // Number unit
                array(
                    'name' => 'number_unit',
                    'type' => 'text',
                    'label' => esc_html__( 'Unit', 'lsvr-elements' ),
                    'description' => esc_html__( 'Number unit.', 'lsvr-elements' ),
                    'default' => esc_html__( '%', 'lsvr-elements' ),
                    'priority' => 20,
                ),

                // Label
                array(
                    'name' => 'label',
                    'type' => 'text',
                    'label' => esc_html__( 'Label', 'lsvr-elements' ),
                    'description' => esc_html__( 'Short text description.', 'lsvr-elements' ),
                    'default' => esc_html__( 'Counter', 'lsvr-elements' ),
                    'priority' => 30,
                ),

                // ID
                array(
                    'name' => 'id',
                    'type' => 'text',
                    'label' => esc_html__( 'Unique ID', 'lsvr-elements' ),
                    'priority' => 40,
                ),

            ), apply_filters( 'lsvr_counter_shortcode_atts', array() ) );
        }

    }
}
?>