<?php
/**
 * Alert message Shortcode
 */
if ( ! class_exists( 'Lsvr_Shortcode_Alert_Message' ) ) {
    class Lsvr_Shortcode_Alert_Message {

        public static function shortcode( $atts = array(), $content = null, $tag = '' ) {

            // Merge default atts and received atts
            $args = shortcode_atts(
                array(
                    'title' => '',
                    'text' => '',
                    'type' => 'info',
                    'id' => '',
                    'className' => '',
                    'editor_view' => false,
                ),
                $atts
            );

            // Check if editor view
            $editor_view = true === $args['editor_view'] || '1' === $args['editor_view'] || 'true' === $args['editor_view'] ? true : false;

            // Get class
            $class = array( 'lsvr-alert-message' );
            if ( true === $editor_view ) {
                array_push( $class_arr, 'lsvr-alert-message--editor-view' );
            }
            if ( ! empty( $args['className'] ) ) {
                array_push( $class, $args['className'] );
            }
            if ( ! empty( $args['type'] ) ) {
                array_push( $class, 'lsvr-alert-message--' . $args['type'] );
            }

            ob_start(); ?>

            <div class="<?php echo esc_attr( implode( ' ', $class ) ); ?>"
                <?php echo ! empty( $args['id'] ) ? ' id="' . esc_attr( $args['id'] ) . '"' : ''; ?>>
                <div class="lsvr-alert-message__inner">

                    <?php if ( ! empty( $args['title'] ) ) : ?>
                        <h3 class="lsvr-alert-message__title">
                            <?php echo wp_kses( $args['title'], array(
                                'a' => array(
                                    'href' => array(),
                                ),
                            )); ?>
                        </h3>
                    <?php endif; ?>

                    <?php if ( ! empty( $args['text'] ) ) : ?>
                        <div class="lsvr-alert-message__text">
                            <?php echo wpautop( wp_kses( $args['text'], array(
                                'a' => array(
                                    'href' => array(),
                                ),
                                'strong' => '',
                            ))); ?>
                        </div>
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
                    'description' => esc_html__( 'Message title.', 'lsvr-elements' ),
                    'default' => esc_html__( 'Alert Message', 'lsvr-elements' ),
                    'priority' => 10,
                ),

                // Text
                array(
                    'name' => 'text',
                    'type' => 'textarea',
                    'label' => esc_html__( 'Message', 'lsvr-elements' ),
                    'description' => esc_html__( 'Message content.', 'lsvr-elements' ),
                    'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 'lsvr-elements' ),
                    'priority' => 20,
                ),

                // Type
                array(
                    'name' => 'type',
                    'type' => 'select',
                    'label' => esc_html__( 'Type', 'lsvr-elements' ),
                    'description' => esc_html__( 'Message type.', 'lsvr-elements' ),
                    'choices' => array(
                        'info' => esc_html__( 'Info', 'lsvr-elements' ),
                        'warning' => esc_html__( 'Warning', 'lsvr-elements' ),
                        'success' => esc_html__( 'Success', 'lsvr-elements' ),
                    ),
                    'default' => 'info',
                    'priority' => 30,
                ),

                // ID
                array(
                    'name' => 'id',
                    'type' => 'text',
                    'label' => esc_html__( 'Unique ID', 'lsvr-elements' ),
                    'priority' => 40,
                ),

            ), apply_filters( 'lsvr_alert_message_shortcode_atts', array() ) );
        }

    }
}
?>