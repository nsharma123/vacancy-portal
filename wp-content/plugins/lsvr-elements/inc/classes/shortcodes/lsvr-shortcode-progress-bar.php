<?php
/**
 * Progress Bar Shortcode
 */
if ( ! class_exists( 'Lsvr_Shortcode_Progress_Bar' ) ) {
    class Lsvr_Shortcode_Progress_Bar {

        public static function shortcode( $atts = array(), $content = null, $tag = '' ) {

            // Merge default atts and received atts
            $args = shortcode_atts(
                array(
                    'title' => '',
                    'percentage' => '',
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
            $class = array( 'lsvr-progress-bar' );
            if ( true === $editor_view ) {
                array_push( $class_arr, 'lsvr-progress-bar--editor-view' );
            }
            if ( ! empty( $args['className'] ) ) {
                array_push( $class, $args['className'] );
            }

            ob_start(); ?>

            <div class="<?php echo esc_attr( implode( ' ', $class ) ); ?>"
                <?php echo ! empty( $args['id'] ) ? ' id="' . esc_attr( $args['id'] ) . '"' : ''; ?>>
                <div class="lsvr-progress-bar__inner">

                    <?php if ( ! empty( $args['title'] ) ) : ?>

                        <h3 class="lsvr-progress-bar__title">
                            <?php echo esc_html( $args['title'] ); ?>
                        </h3>

                    <?php endif; ?>

                    <?php if ( ! empty( $args['percentage'] ) ) : ?>

                        <div class="lsvr-progress-bar__bar">
                            <div class="lsvr-progress-bar__bar-inner" data-percentage="<?php echo esc_attr( (int) $args['percentage'] ); ?>"
                                style="width: <?php echo esc_attr( (int) $args['percentage'] ); ?>%"></div>

                            <?php if ( ! empty( $args['label'] ) ) : ?>
                                <span class="lsvr-progress-bar__bar-label"><?php echo esc_html( $args['label'] ); ?></span>
                            <?php endif; ?>

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
                    'default' => esc_html__( 'Progress Bar', 'lsvr-elements' ),
                    'priority' => 10,
                ),

                // Percentage
                array(
                    'name' => 'percentage',
                    'type' => 'text',
                    'label' => esc_html__( 'Percentage', 'lsvr-elements' ),
                    'description' => esc_html__( 'Value between 0 and 100.', 'lsvr-elements' ),
                    'default' => 50,
                    'priority' => 20,
                ),

                // Label
                array(
                    'name' => 'label',
                    'type' => 'text',
                    'label' => esc_html__( 'Label', 'lsvr-elements' ),
                    'default' => esc_html__( 'Lorem ipsum', 'lsvr-elements' ),
                    'priority' => 30,
                ),

                // ID
                array(
                    'name' => 'id',
                    'type' => 'text',
                    'label' => esc_html__( 'Unique ID', 'lsvr-elements' ),
                    'priority' => 40,
                ),

            ), apply_filters( 'lsvr_progress_bar_shortcode_atts', array() ) );
        }

    }
}
?>