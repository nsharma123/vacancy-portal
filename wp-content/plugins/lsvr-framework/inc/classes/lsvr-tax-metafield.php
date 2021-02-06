<?php
/**
 * General class for handling taxonomy metabox fields.
 *
 * @param array $args {
 *
 *		@type string		$taxonomy_name		Name of the taxonomy this field belongs to.
 *
 *		@type string		$field_id			Unique ID of this metafield.
 *
  *		@type array			$args				Array with all attributes required to display the metafield.
 * }
 */
if ( ! class_exists( 'Lsvr_Tax_Metafield' ) ) {
	class Lsvr_Tax_Metafield {

		public $taxonomy_name;
		public $input_id;
		public $term_id;
		public $args;
		public $current_value;
		public $default_value;

		public function __construct( $args ) {

			$this->taxonomy_name = ! empty( $args['taxonomy_name'] ) ? sanitize_key( $args['taxonomy_name'] ) : false;
			$this->field_id = ! empty( $args['field_id'] ) ? sanitize_key( $args['field_id'] ) : false;
			$this->term_id = ! empty( $args['term_id'] ) ? sanitize_key( $args['term_id'] ) : false;
			$this->args = ! empty( $args['args'] ) ? $args['args'] : false;

			// Geenrate input ID
			if ( ! empty( $this->taxonomy_name ) && ! empty( $this->field_id ) && ! empty( $this->args ) ) {
				$this->input_id = $this->taxonomy_name . '_tax_meta[' . $this->field_id . ']';
			}

			// Get default value
			$this->default_value = ! empty( $this->args['default'] ) ? $this->args['default'] : '';

			// Get current value
			if ( ! empty( $this->term_id ) ) {

				$current_value = get_option( $this->taxonomy_name . '_term_' . (int) $this->term_id . '_meta' );

				if ( empty( $current_value[ $this->field_id ] ) ) {
					$this->current_value = $this->default_value;
				} else {
					$this->current_value = $current_value[ $this->field_id ];
				}

			}

			// Display metafield
			$this->metafield_before();
			$this->display_metafield();
			$this->metafield_after();

		}

		// Metafield before
		public function metafield_before() {
			?>

			<div class="lsvr-tax-metafield lsvr-tax-metafield--<?php echo esc_attr( $this->args['type'] ); ?>">
				<div class="lsvr-tax-metafield__inner">

			<?php
		}

		// Display metafield
		public function display_metafield() {
			// Defined in child class
		}

		// Metafield after
		public function metafield_after() {
			?>

				</div>
			</div>

			<?php
		}

	}
}

?>