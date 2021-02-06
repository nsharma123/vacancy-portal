<?php
/**
 * Checkbox metafield class
 */
if ( ! class_exists( 'Lsvr_Post_Metafield_Checkbox' ) && class_exists( 'Lsvr_Post_Metafield' ) ) {
    class Lsvr_Post_Metafield_Checkbox extends Lsvr_Post_Metafield {

    	public function __construct( $args ) {
    		parent::__construct( $args );
    	}

    	// Display field
    	public function display_metafield() {

    		$choices = is_array( $this->args['choices'] ) ? $this->args['choices'] : [];
    		$this->current_value = '' === $this->current_value ? '' : $this->current_value;
    		$current_value_arr = ! empty( $this->current_value ) ? explode( ',', $this->current_value ) : false;
    		?>

			<div class="lsvr-post-metafield-checkbox<?php if ( ! empty( $this->args['style'] ) ) { echo ' lsvr-post-metafield-checkbox--style-' . esc_attr( $this->args['style'] ); } ?>">
				<input type="hidden" value="<?php echo esc_attr( $this->current_value ); ?>"
					class="lsvr-post-metafield__value lsvr-post-metafield-checkbox__value"
					id="<?php echo esc_attr( $this->input_id ); ?>" name="<?php echo esc_attr( $this->input_id ); ?>">
				<?php foreach ( $choices as $value => $label ) : ?>
					<label for="<?php echo esc_attr( $this->input_id . '_' . $value ); ?>"
						class="lsvr-post-metafield-checkbox__item">
						<input type="checkbox" value="<?php echo esc_attr( $value ); ?>"
							id="<?php echo esc_attr( $this->input_id . '_' . $value ); ?>"
							name="<?php echo esc_attr( $this->input_id . '_' . $value ); ?>"
							<?php if ( ! empty( $current_value_arr ) && in_array( $value, $current_value_arr ) ) {
								echo ' checked="checked"'; } ?>>
						<span><?php echo esc_html( $label ); ?></span>
						<?php if ( empty( $this->args['style'] ) || $this->args['style'] !== 'inline' ) : ?>
							<br>
						<?php endif; ?>
					</label>
				<?php endforeach;?>
			</div>

    		<?php
    	}

    }
}

?>