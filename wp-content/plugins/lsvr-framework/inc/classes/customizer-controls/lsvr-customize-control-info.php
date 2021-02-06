<?php
/**
 * Info customize control class
 */
if ( ! class_exists( 'Lsvr_Customize_Control_Info' ) && class_exists( 'WP_Customize_Control' ) ) {
    class Lsvr_Customize_Control_Info extends WP_Customize_Control {

		public function render_content() {
			?>

			<div class="lsvr-customizer-control-info">

				<?php // Label
				if ( ! empty( $this->label ) ) : ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif; ?>

				<?php // Description
				if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description">
						<?php echo esc_html( $this->description ); ?>
					</span>
				<?php endif; ?>

			</div>

			<?php

		}

    }
}