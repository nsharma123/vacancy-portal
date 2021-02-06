<?php
/**
 * Multicheck customize control class
 */
if ( ! class_exists( 'Lsvr_Customize_Control_Multicheck' ) && class_exists( 'WP_Customize_Control' ) ) {
    class Lsvr_Customize_Control_Multicheck extends WP_Customize_Control {

		public function render_content() {

			// Concert current value to array
			if ( ! empty( $this->value() ) ) {
				$current_value = explode( ',', $this->value() );
			}

			?>

			<?php if ( ! empty( $this->choices ) ) : ?>
				<div class="lsvr-customizer-control-multicheck">

					<input type="hidden" class="lsvr-customizer-control-value lsvr-customizer-control-multicheck__value"
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

					<ul class="lsvr-customizer-control-multicheck__list">
						<?php foreach ( $this->choices as $value => $label ) : ?>
							<li class="lsvr-customizer-control-multicheck__list-item">
								<label for="lsvr-customizer-control-multicheck__<?php echo esc_attr( $value ); ?>">
									<input type="checkbox" value="<?php echo esc_attr( $value ); ?>"
										class="lsvr-customizer-control-multicheck__checkbox"
										id="lsvr-customizer-control-multicheck__<?php echo esc_attr( $value ); ?>"
										<?php if ( ! empty( $current_value ) && in_array( $value, $current_value ) ) { echo ' checked="checked"'; } ?>>
									<span><?php echo esc_html( $label ); ?></span>
								</label>
							</li>
						<?php endforeach; ?>
					</ul>

				</div>
			<?php endif; ?>

			<?php
		}

    }
}