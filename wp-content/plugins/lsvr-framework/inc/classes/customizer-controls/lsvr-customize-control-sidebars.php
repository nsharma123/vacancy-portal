<?php
/**
 * Custom Sidebars customize control class
 */
if ( ! class_exists( 'Lsvr_Customize_Control_Sidebars' ) && class_exists( 'WP_Customize_Control' ) ) {
    class Lsvr_Customize_Control_Sidebars extends WP_Customize_Control {

		public function render_content() {

			// Saved value
			if ( ! empty( $this->value() ) && '{' === substr( $this->value(), 0, 1 ) ) {
				$savedData = (array) json_decode( $this->value() );
				$last_id = ! empty( $savedData[ 'last_id' ] ) ? (int) $savedData[ 'last_id' ] : false;
				$sidebars = ! empty( $savedData[ 'sidebars' ] ) ? (array) $savedData[ 'sidebars' ] : false;
				if ( empty( $last_id ) || empty( $sidebars ) ) {
					$last_id = 0;
					$sidebars = array();
				}
			}
			else {
				$last_id = 0;
				$sidebars = array();
			}

			?>

			<div class="lsvr-customizer-control-sidebars"
				data-input-placeholder="<?php echo esc_attr( esc_html__( 'Custom Sidebar %d', 'lsvr-framework' ) ); ?>">

				<input type="hidden" class="lsvr-customizer-control-value lsvr-customizer-control-sidebars__value"
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

				<div class="lsvr-customizer-control-sidebars__wrapper">

					<ul class="lsvr-customizer-control-sidebars__list" data-last-id="<?php echo esc_attr( $last_id ); ?>"<?php if ( empty( $sidebars ) ) { echo ' style="display: none;"'; } ?>>
						<?php if ( ! empty( $sidebars ) ) : ?>
							<?php foreach ( $sidebars as $sidebar ) : $sidebar = (array) $sidebar; ?>
								<li class="lsvr-customizer-control-sidebars__item" data-sidebar-id="<?php echo esc_attr( $sidebar['id'] ); ?>">
									<input type="text" class="lsvr-customizer-control-sidebars__item-input"
										placeholder="<?php echo esc_attr( sprintf( esc_html__( 'Custom Sidebar %d', 'lsvr-framework' ), $sidebar['id'] ) ); ?>"
										value="<?php echo esc_attr( $sidebar['label'] ); ?>">
									<button type="button" class="lsvr-customizer-control-sidebars__remove-button" title="#<?php echo esc_attr( $sidebar['id'] ); ?>"><i class="dashicons dashicons-no-alt"></i></button>
								</li>
							<?php endforeach; ?>
						<?php endif; ?>
					</ul>

					<p class="lsvr-customizer-control-sidebars__no-sidebars"<?php if ( ! empty( $sidebars ) ) { echo ' style="display: none;"'; } ?>>
						<strong><?php esc_html_e( 'No sidebars yet. Want to add one?', 'lsvr-framework' ); ?></strong>
					</p>

					<button type="button" class="button button-primary lsvr-customizer-control-sidebars__add-button"><?php esc_html_e( 'Add Sidebar', 'lsvr-framework' ); ?></button>

				</div>

			</div>

			<?php

		}

    }
}