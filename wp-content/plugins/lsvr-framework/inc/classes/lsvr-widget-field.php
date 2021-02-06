<?php
/**
 * General class for handling widget fields.
 */
if ( ! class_exists( 'Lsvr_Widget_Field' ) ) {
	class Lsvr_Widget_Field {

		public $field_id;
		public $args;
		public $type;
		public $input_id;
		public $input_name;
		public $saved_value;

		public function __construct( $args ) {

			$this->field_id = ! empty( $args['field_id'] ) ? sanitize_key( $args['field_id'] ) : false;
			$this->args = ! empty( $args['args'] ) ? $args['args'] : false;
			$this->type = ! empty( $this->args['type'] ) ? $this->args['type'] : 'text';
			$this->input_id = ! empty( $args['input_id'] ) ? $args['input_id'] : false;
			$this->input_name = ! empty( $args['input_name'] ) ? $args['input_name'] : false;
			$this->saved_value = ! empty( $args['saved_value'] ) ? $args['saved_value'] : '';

			// Display field
			$this->field_before();
			$this->display_field();
			$this->field_after();

		}

		// Field before
		public function field_before() {
			?>

			<div class="lsvr-widget-field lsvr-widget-field--<?php echo esc_attr( $this->type ); ?>">
				<div class="lsvr-widget-field__inner">
					<div class="lsvr-widget-field__content">

			<?php
		}

		// Display field
		public function display_field() {
			// Defined in child class
		}

		// Field after
		public function field_after() {
			?>
					</div>

	        		<?php // Description
	        		if ( ! empty( $this->args['description'] ) ) : ?>
	        			<p class="lsvr-widget-field__description"><small><?php echo esc_html( $this->args['description'] ); ?></small></p>
	    			<?php endif; ?>

				</div>
			</div>

			<?php
		}

	}
}