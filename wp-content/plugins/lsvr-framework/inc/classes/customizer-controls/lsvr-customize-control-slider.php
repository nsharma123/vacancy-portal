<?php
/**
 * Slider customize control class
 */
if ( ! class_exists( 'Lsvr_Customize_Control_Slider' ) && class_exists( 'WP_Customize_Control' ) ) {
    class Lsvr_Customize_Control_Slider extends WP_Customize_Control {

		public function render_content() {

			// Prepare params
			$min = ! empty( $this->choices['min'] ) ? $this->choices['min'] : 0;
			$max = ! empty( $this->choices['max'] ) ? $this->choices['max'] : 100;
			$step = ! empty( $this->choices['step'] ) ? $this->choices['step'] : 1;

			?>

			<div class="lsvr-customizer-control-slider">

				<input type="hidden" class="lsvr-customizer-control-value lsvr-customizer-control-slider__value"
					value="<?php echo esc_attr( $this->value() ); ?>"
					<?php $this->link(); ?>>

				<?php // Display label and description
				if ( ! empty( $this->label ) || ! empty( $this->description ) ) : ?>
					<label>
						<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
						<span class="description customize-control-description">
							<?php echo esc_html( $this->description ); ?>
						</span>
					</label>
				<?php endif; ?>

				<div class="lsvr-customizer-control-slider__slider-wrapper">
					<div class="lsvr-customizer-control-slider__slider-value">
						<?php echo esc_html( $this->value() ); ?>
					</div>
					<div class="lsvr-customizer-control-slider__slider"
						data-min="<?php echo esc_attr( $min ); ?>"
						data-max="<?php echo esc_attr( $max ); ?>"
						data-step="<?php echo esc_attr( $step ); ?>"
						data-value="<?php echo esc_attr( $this->value() ); ?>"></div>
				</div>

			</div>

			<?php
		}

    }
}