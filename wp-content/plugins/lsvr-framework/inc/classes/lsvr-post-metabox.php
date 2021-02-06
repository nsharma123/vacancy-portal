<?php
/**
 * General class for handling post metaboxes.
 *
 * @param array $args {
 *
 *		@type string		$metabox_id		Unique ID of this metabox. It is passed to add_meta_box() function.
 *
 *		@type array			$wp_args		Standard WordPress arguments for creating metaboxes.
 *											It is passed to add_meta_box() function.
 *
 *		@type array			$fields			Array with all metabox fields.
 * }
 */
if ( ! class_exists( 'Lsvr_Post_Metabox' ) ) {
	class Lsvr_Post_Metabox {

		public $metabox_id;
		public $wp_args;
		public $page_template;
		public $fields;

		public function __construct( $args ) {

			$this->metabox_id = ! empty( $args['id'] ) ? sanitize_key( $args['id'] ) : false;
			$this->wp_args = ! empty( $args['wp_args'] ) ? $args['wp_args'] : false;
			$this->page_template = ! empty( $args['page_template'] ) ? (array) $args['page_template'] : false;

			if ( ! empty( $this->metabox_id ) && ! empty( $this->wp_args) ) {

				// Get fields
				$this->fields = ! empty( $args['fields'] ) ? $args['fields'] : array();
				$this->fields = array_merge( $this->fields, apply_filters( $this->metabox_id . '_metabox_fields', array() ) );

				// Get default wp_args
				$default_wp_args = array(
					'title' => __( 'Settings', 'lsvr-framework' ),
					'screen' => 'page',
					'context' => 'normal',
					'priority' => 'high'
				);
				$this->wp_args = is_array( $this->wp_args ) ? array_merge( $default_wp_args, $this->wp_args ) : $default_wp_args;
				$this->wp_args = array_merge( $this->wp_args, apply_filters( $this->metabox_id . '_metabox_wp_args', array() ) );

				// Init
				add_action( 'add_meta_boxes', array( $this, 'add_metabox' ) );
				add_action( 'save_post', array( $this, 'save_metabox' ), 10, 2 );

			}
		}

		// Add metabox
		public function add_metabox() {

			// Sort fields by priority
			if ( ! empty( $this->fields ) ) {
				$fields_priority = array();
				foreach ( $this->fields as $field_id => $field_args ) {
					$fields_priority[ $field_id ] = ! empty( $field_args[ 'priority' ] ) ? intval( $field_args[ 'priority' ] ) : 0;
				}
				array_multisort( $fields_priority, SORT_ASC, $this->fields );
			}

			// Add metabox
			add_meta_box( sanitize_key( $this->metabox_id ),
				$this->wp_args['title'],
				array( $this, 'edit_metabox' ),
				$this->wp_args['screen'],
				$this->wp_args['context'],
				$this->wp_args['priority']
			);

		}

		// Edit metabox
		public function edit_metabox( $post ) {
			?>

			<fieldset class="lsvr-post-metabox" data-metabox-id="<?php echo esc_attr( $this->metabox_id ); ?>"
				<?php if ( ! empty( $this->page_template ) ) :?>data-page-template="<?php echo esc_attr( implode( ',', $this->page_template ) ); ?>"<?php endif; ?>>

				<?php wp_nonce_field( basename( __FILE__ ), $this->metabox_id . '_meta_nonce' );

				// Description
				if ( ! empty( $this->wp_args['description'] ) ) {
					echo '<p class="lsvr-post-metabox__description">' . $this->wp_args['description'] . '</p>';
				} ?>

				<div class="lsvr-post-metabox__metafields">

					<?php // Display fields
					foreach ( $this->fields as $field_id => $field_args ) {
						$metafield_class = ! empty( $field_args['type'] ) ? 'Lsvr_Post_Metafield_' . str_replace( '-', '_', ucwords( $field_args['type'], '-' ) ) : '';
						if ( class_exists( $metafield_class ) ) {
							$metafield = new $metafield_class(array(
								'id' => $field_id,
								'metabox_id' => $this->metabox_id,
								'post_id' => $post->ID,
								'args' => $field_args,
							));
						}
					} ?>

				</div>

			</fieldset>

			<?php
		}

		// Save metabox
		public function save_metabox( $post_id, $post ) {

			// Check nonce
			if ( ! isset( $_POST[ $this->metabox_id . '_meta_nonce' ] ) || ! wp_verify_nonce( $_POST[ $this->metabox_id . '_meta_nonce'], basename( __FILE__ ) ) ) {
    			return $post_id;
			}

			// Save fields
			foreach ( $this->fields as $field_id => $field_args ) {

				$field_input_id = esc_attr( $field_id . '_input' );
				if ( is_array( $_POST ) && array_key_exists( $field_input_id, $_POST ) ) {

					// Get field type class
					$metafield_class = ! empty( $field_args['type'] ) ? 'Lsvr_Post_Metafield_' . str_replace( '-', '_', ucwords( $field_args['type'], '-' ) ) : '';

					// Field type specific sanitization
					if ( class_exists( $metafield_class ) && method_exists( $metafield_class, 'sanitize_before_save' ) ) {
						$field_value = $metafield_class::sanitize_before_save( $_POST[ $field_input_id ] );
					}

					// Default sanitization
					else {
						$field_value = sanitize_text_field( $_POST[ $field_input_id ] );
					}

					// Save value
					update_post_meta( $post->ID, $field_id, $field_value );

					// Field type specific after save action
					if ( class_exists( $metafield_class ) && method_exists( $metafield_class, 'after_save' ) ) {
						$field_value = $metafield_class::after_save( $post_id, $_POST[ $field_input_id ] );
					}

				}

			}

		}

	}
}

?>