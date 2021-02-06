<?php
/**
 * Textarea widget field class
 */
if ( ! class_exists( 'Lsvr_Widget_Field_Textarea' ) && class_exists( 'Lsvr_Widget_Field' ) ) {
    class Lsvr_Widget_Field_Textarea extends Lsvr_Widget_Field {

    	public function __construct( $args ) {
    		parent::__construct( $args );
    	}

    	// Display field
    	public function display_field() {
    		?>

            <label class="lsvr-widget-field__label" for="<?php echo esc_attr( $this->input_id ); ?>">
                <?php echo esc_attr( $this->args['label'] ); ?>
            </label>
            <textarea class="lsvr-widget-field__input widefat" cols="40" rows="5"
                id="<?php echo esc_attr( $this->input_id ); ?>"
                name="<?php echo esc_attr( $this->input_name ); ?>"><?php echo ! empty( $this->saved_value ) ? esc_textarea( $this->saved_value ) : ''; ?></textarea>

			<?php
    	}

    }
}