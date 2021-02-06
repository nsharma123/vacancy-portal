<?php
/**
 * Select widget field class
 */
if ( ! class_exists( 'Lsvr_Widget_Field_Select' ) && class_exists( 'Lsvr_Widget_Field' ) ) {
    class Lsvr_Widget_Field_Select extends Lsvr_Widget_Field {

    	public function __construct( $args ) {
    		parent::__construct( $args );
    	}

    	// Display field
    	public function display_field() {
    		?>

            <label class="lsvr-widget-field__label" for="<?php echo esc_attr( $this->input_id ); ?>">
                <?php echo esc_attr( $this->args['label'] ); ?>
            </label>
            <select class="lsvr-widget-field__input widefat"
                id="<?php echo esc_attr( $this->input_id ); ?>"
                name="<?php echo esc_attr( $this->input_name ); ?>">

                <?php foreach ( $this->args['choices'] as $option_value => $option_label ) : ?>
                    <option value="<?php echo esc_attr( $option_value ); ?>"
                        <?php if ( ! empty( $this->saved_value ) && $this->saved_value == $option_value ) { echo ' selected="selected"'; } ?>>
                            <?php echo esc_html( $option_label ); ?>
                    </option>
                <?php endforeach; ?>

            </select>

			<?php
    	}

    }
}