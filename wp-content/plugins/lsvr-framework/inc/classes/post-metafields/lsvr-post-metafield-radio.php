<?php
/**
 * Radio metafield class
 */
if ( ! class_exists( 'Lsvr_Post_Metafield_Radio' ) && class_exists( 'Lsvr_Post_Metafield' ) ) {
    class Lsvr_Post_Metafield_Radio extends Lsvr_Post_Metafield {

    	public function __construct( $args ) {
    		parent::__construct( $args );
    	}

    	// Display field
    	public function display_metafield() {

    		$choices = is_array( $this->args['choices'] ) ? $this->args['choices'] : [];
    		$this->current_value = '' === $this->current_value ? 'false' : $this->current_value;
    		?>

			<div class="lsvr-post-metafield-radio<?php if ( ! empty( $this->args['style'] ) ) { echo ' lsvr-post-metafield-radio--style-' . esc_attr( $this->args['style'] ); } ?>">
				<?php $i = 0;
				foreach ( $choices as $value => $label ) : ?>
					<label for="<?php echo esc_attr( $this->input_id . '_' . $i ); ?>"
						class="lsvr-post-metafield-radio__item">
						<input type="radio" value="<?php echo esc_attr( $value ); ?>"
							class="lsvr-post-metafield__value"
							id="<?php echo esc_attr( $this->input_id . '_' . $i ); ?>"
							name="<?php echo esc_attr( $this->input_id ); ?>"
							<?php if ( $value === $this->current_value ) { echo ' checked="checked"'; } ?>>
						<span><?php echo esc_html( $label ); ?></span>
						<?php if ( empty( $this->args['style'] ) || $this->args['style'] !== 'inline' ) : ?>
							<br>
						<?php endif; ?>
					</label>
				<?php $i++; endforeach;?>
			</div>

    		<?php
    	}

    }
}

?>