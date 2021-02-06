<?php
/**
 * Select metafield class
 */
if ( ! class_exists( 'Lsvr_Post_Metafield_Select' ) && class_exists( 'Lsvr_Post_Metafield' ) ) {
    class Lsvr_Post_Metafield_Select extends Lsvr_Post_Metafield {

    	public function __construct( $args ) {
    		parent::__construct( $args );
    	}

    	// Display field
    	public function display_metafield() {

    		$choices = is_array( $this->args['choices'] ) ? $this->args['choices'] : [];
    		$this->current_value = '' === $this->current_value ? 'false' : $this->current_value; ?>

			<div class="lsvr-post-metafield-select">
				<select class="lsvr-post-metafield__value lsvr-post-metafield-select__value"
					id="<?php echo esc_attr( $this->input_id ); ?>" name="<?php echo esc_attr( $this->input_id ); ?>">
					<?php foreach ( $choices as $value => $label ) : ?>
						<option value="<?php echo esc_attr( $value ); ?>"
							<?php if ( ( $value === $this->current_value ) || ( is_numeric( $value ) && is_numeric( $this->current_value ) && (int) $value === (int) $this->current_value ) ) { echo ' selected="selected"'; } ?>>
							<?php echo esc_html( $label ); ?>
						</option>
					<?php endforeach;?>
				</select>
			</div>

    		<?php
    	}

    }
}

?>