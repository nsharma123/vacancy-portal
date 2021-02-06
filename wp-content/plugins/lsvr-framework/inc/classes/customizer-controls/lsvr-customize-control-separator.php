<?php
/**
 * Separator customize control class
 */
if ( ! class_exists( 'Lsvr_Customize_Control_Separator' ) && class_exists( 'WP_Customize_Control' ) ) {
    class Lsvr_Customize_Control_Separator extends WP_Customize_Control {

		public function render_content() {
			?>

			<hr class="lsvr-customizer-control-separator">

			<?php

		}

    }
}