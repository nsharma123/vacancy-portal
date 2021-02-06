<?php
/**
 * Text widget field class
 */
if ( ! class_exists( 'Lsvr_Widget_Field_Text' ) && class_exists( 'Lsvr_Widget_Field' ) ) {
    class Lsvr_Widget_Field_Text extends Lsvr_Widget_Field {

    	public function __construct( $args ) {
    		parent::__construct( $args );
    	}

    	// Display field
    	public function display_field() {
    		?>

			<label class="lsvr-widget-field__label" for="<?php echo esc_attr( $this->input_id ); ?>">
				<?php echo esc_attr( $this->args['label'] ); ?>
			</label>
    		<input type="text" class="lsvr-widget-field__input lsvr-widget-field__input--text widefat"
    			value="<?php echo ! empty( $this->saved_value ) ? esc_attr( $this->saved_value ) : ''; ?>"
    			id="<?php echo esc_attr( $this->input_id ); ?>"
    			name="<?php echo esc_attr( $this->input_name ); ?>">

			<?php
    	}

    }
}