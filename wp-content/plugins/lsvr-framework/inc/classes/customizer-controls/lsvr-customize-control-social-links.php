<?php
/**
 * Social links customize control class
 */
if ( ! class_exists( 'Lsvr_Customize_Control_Social_Links' ) && class_exists( 'WP_Customize_Control' ) ) {
    class Lsvr_Customize_Control_Social_Links extends WP_Customize_Control {

		public function render_content() {

			// Default fields
			if ( ! empty( $this->choices ) ) {
				$social_links = $this->choices;
			}

			// Put all saved links at the top of the list of networks
			if ( ! empty( $this->value() && is_string( $this->value() ) ) ) {
				$current_value = json_decode( $this->value() );
				if ( ! empty( $current_value ) ) {
					$current_value_keys = (array) $current_value;
					$current_value_keys = array_keys( array_reverse( $current_value_keys ) );
					foreach ( $current_value_keys as $key ) {
						if ( array_key_exists( $key, $social_links ) ) {
							$social_links = array( $key => $social_links[ $key ] ) + $social_links;
						}
					}
				}
			}

			?>

			<?php if ( ! empty( $social_links ) ) : ?>
				<div class="lsvr-customizer-control-social-links">

					<input type="hidden" class="lsvr-customizer-control-value lsvr-customizer-control-social-links__value"
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

					<ul class="lsvr-customizer-control-social-links__list">

						<?php foreach ( $social_links as $id => $social_link ) : ?>

							<li class="lsvr-customizer-control-social-links__item">

								<label for="lsvr-customizer-control-social-links__<?php echo esc_attr( $id ); ?>"
									class="lsvr-customizer-control-social-links__item-label">
									<?php echo esc_html( $social_link['label'] ); ?>
								</label>
								<input type="text" class="lsvr-customizer-control-social-links__item-input-url"
									<?php if ( ! empty( $current_value->$id->url ) ) { ?>
										value="<?php echo esc_attr( $current_value->$id->url ); ?>"
									<?php } else { ?>
										value=""
									<?php } ?>
									id="lsvr-customizer-control-social-links__<?php echo esc_attr( $id ); ?>"
									data-id="<?php echo esc_attr( $id ); ?>">

								<input type="hidden" class="lsvr-customizer-control-social-links__item-input-icon"
									value="<?php if ( ! empty( $social_link['icon'] ) ) { echo esc_attr( $social_link['icon'] ); } ?>">

								<input type="hidden" class="lsvr-customizer-control-social-links__item-input-label"
									value="<?php if ( ! empty( $social_link['label'] ) ) { echo esc_attr( $social_link['label'] ); } ?>">

							</li>

						<?php endforeach; ?>

					</ul>

				</div>
			<?php endif; ?>

			<?php

		}

    }
}