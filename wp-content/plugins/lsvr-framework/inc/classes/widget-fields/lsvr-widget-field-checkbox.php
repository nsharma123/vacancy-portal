<?php
/**
 * Checkbox widget field class
 */
if ( ! class_exists( 'Lsvr_Widget_Field_Checkbox' ) && class_exists( 'Lsvr_Widget_Field' ) ) {
    class Lsvr_Widget_Field_Checkbox extends Lsvr_Widget_Field {

    	public function __construct( $args ) {
    		parent::__construct( $args );
    	}

    	// Display field
    	public function display_field() {
    		?>

			<label class="lsvr-widget-field__label" for="<?php echo esc_attr( $this->input_id ); ?>">
                <input type="checkbox" class="lsvr-widget-field__input" value="true"
                    id="<?php echo esc_attr( $this->input_id ); ?>"
                    name="<?php echo esc_attr( $this->input_name ); ?>"
                    <?php if ( ! empty( $this->saved_value ) && 'true' === $this->saved_value ) { echo ' checked="checked"'; } ?>>
				<?php echo esc_attr( $this->args['label'] ); ?>
			</label>

			<?php
    	}

    }
}