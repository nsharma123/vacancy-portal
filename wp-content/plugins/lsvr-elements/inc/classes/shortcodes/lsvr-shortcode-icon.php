<?php
/**
 * LSVR Icon Shortcode
 */
if ( ! class_exists( 'Lsvr_Shortcode_Icon' ) ) {
    class Lsvr_Shortcode_Icon {

        public static function shortcode( $atts = array(), $content = null, $tag ) {

            // Merge default atts and received atts
            $args = shortcode_atts(
                array(
                    'id' => '',
                    'icon' => '',
                ),
                $atts
            );

            $html = '';
            if ( ! empty( $args['icon'] ) ) {

                $html = '<i';
                $html .= ! empty( $args['id'] ) ? ' id="' . esc_attr( $args['id'] ) . '"' : '';
                $html .= ' class="' . esc_attr( $args['icon'] ) . '"></i>';

            }
            return $html;

        }

    }
}
?>