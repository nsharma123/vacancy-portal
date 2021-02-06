<?php
/**
 * Slider metafield class
 */
if ( ! class_exists( 'Lsvr_Post_Metafield_Slider' ) && class_exists( 'Lsvr_Post_Metafield' ) ) {
    class Lsvr_Post_Metafield_Slider extends Lsvr_Post_Metafield {

    	public function __construct( $args ) {
    		parent::__construct( $args );
    	}

    	// Display field
    	public function display_metafield() {

            $choices = is_array( $this->args['choices'] ) ? $this->args['choices'] : array();
            if ( ! empty( $choices ) ) {

                // Prepare params
                $min = ! empty( $choices['min'] ) ? $choices['min'] : 0;
                $max = ! empty( $choices['max'] ) ? $choices['max'] : 100;
                $step = ! empty( $choices['step'] ) ? $choices['step'] : 1; ?>

                <div class="lsvr-post-metafield-slider">

            		<input type="hidden" value="<?php echo esc_attr( $this->current_value ); ?>"
                        class="lsvr-post-metafield__value lsvr-post-metafield-slider__value"
        				id="<?php echo esc_attr( $this->input_id ); ?>" name="<?php echo esc_attr( $this->input_id ); ?>">

                    <div class="lsvr-post-metafield-slider__wrapper">
                        <div class="lsvr-post-metafield-slider__slider-value">
                            <?php echo esc_html( $this->current_value ); ?>
                        </div>
                        <div class="lsvr-post-metafield-slider__slider"
                            data-min="<?php echo esc_attr( $min ); ?>"
                            data-max="<?php echo esc_attr( $max ); ?>"
                            data-step="<?php echo esc_attr( $step ); ?>"
                            data-value="<?php echo esc_attr( $this->current_value ); ?>"></div>
                    </div>

                </div>

        		<?php

            }

    	}

    }
}

?>