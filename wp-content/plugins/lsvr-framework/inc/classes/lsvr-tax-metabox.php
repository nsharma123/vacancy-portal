<?php
/**
 * General class for handling taxonomy metaboxes.
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
if ( ! class_exists( 'Lsvr_Tax_Metabox' ) ) {
	class Lsvr_Tax_Metabox {

		public $taxonomy_name;
		public $fields;

		public function __construct( $args ) {

			$this->taxonomy_name = ! empty( $args['taxonomy_name'] ) ? sanitize_key( $args['taxonomy_name'] ) : false;
			$this->fields = ! empty( $args['fields'] ) ? $args['fields'] : false;

			if ( ! empty( $this->taxonomy_name ) && ! empty( $this->fields) ) {

				// Sort fields by priority
				if ( ! empty( $this->fields ) ) {
					$fields_priority = array();
					foreach ( $this->fields as $field_id => $field_args ) {
						$fields_priority[ $field_id ] = ! empty( $field_args[ 'priority' ] ) ? intval( $field_args[ 'priority' ] ) : 0;
					}
					array_multisort( $fields_priority, SORT_ASC, $this->fields );
				}

				// Init
				add_action( $this->taxonomy_name . '_add_form_fields', array( $this, 'add_term_metabox' ), 10, 2 );
				add_action( $this->taxonomy_name . '_edit_form_fields', array( $this, 'edit_term_metabox' ), 10, 2 );
				add_action( 'edited_' . $this->taxonomy_name, array( $this, 'save_metabox' ), 10, 2 );
				add_action( 'create_' . $this->taxonomy_name, array( $this, 'save_metabox' ), 10, 2 );

			}
		}

		// Add metabox
		public function add_term_metabox() { ?>

			<?php // Display fields
			foreach ( $this->fields as $field_id => $field_args ) : ?>

				<?php $metafield_class = ! empty( $field_args['type'] ) ? 'Lsvr_Tax_Metafield_' . ucwords( $field_args['type'], '_' ) : ''; ?>

				<?php if ( class_exists( $metafield_class ) ) : ?>

					<div class="form-field">

						<?php if ( ! empty( $field_args['title'] ) ) : ?>
							<label for="<?php echo esc_attr( $this->taxonomy_name . '_tax_meta[' . $field_id . ']' ); ?>">
								<?php echo esc_html( $field_args['title'] ); ?>
							</label>
						<?php endif; ?>

						<?php $metafield = new $metafield_class(array(
							'taxonomy_name' => $this->taxonomy_name,
							'field_id' => $field_id,
							'args' => $field_args,
						)); ?>

						<?php if ( ! empty( $field_args['hint'] ) ) : ?>
							<p class="description"><?php echo esc_html( $field_args['hint'] ); ?></p>
						<?php endif; ?>

					</div>

				<?php endif; ?>

			<?php endforeach; ?>

		<?php }

		// Edit metabox
		public function edit_term_metabox( $term ) { ?>

			<?php // Display fields
			foreach ( $this->fields as $field_id => $field_args ) : ?>

				<?php $metafield_class = ! empty( $field_args['type'] ) ? 'Lsvr_Tax_Metafield_' . ucwords( $field_args['type'], '_' ) : ''; ?>

				<?php if ( class_exists( $metafield_class ) ) : ?>

					<tr class="form-field">
						<th scope="row" valign="top">

							<?php if ( ! empty( $field_args['title'] ) ) : ?>
								<label for="<?php echo esc_attr( $this->taxonomy_name . '_tax_meta[' . $field_id . ']' ); ?>">
									<?php echo esc_html( $field_args['title'] ); ?>
								</label>
							<?php endif; ?>

						</th>
						<td>

							<?php $metafield = new $metafield_class(array(
								'taxonomy_name' => $this->taxonomy_name,
								'field_id' => $field_id,
								'term_id' => $term->term_id,
								'args' => $field_args,
							)); ?>

							<?php if ( ! empty( $field_args['hint'] ) ) : ?>
								<p class="description"><?php echo esc_html( $field_args['hint'] ); ?></p>
							<?php endif; ?>

						</td>
					</tr>

				<?php endif; ?>

			<?php endforeach; ?>

		<?php }

		// Save metabox
		public function save_metabox( $term_id ) {
			if ( isset( $_POST[ $this->taxonomy_name . '_tax_meta' ] ) ) {
				$term_meta = get_option( $this->taxonomy_name . '_term_' . (int) $term_id . '_meta' );
				$cat_keys = array_keys( $_POST[ $this->taxonomy_name . '_tax_meta' ] );
				foreach ( $cat_keys as $key ) {
					if ( isset ( $_POST[ $this->taxonomy_name . '_tax_meta' ][ $key ] ) ) {

						// Get class of current meta field
						if ( ! empty( $this->fields[ $key ][ 'type' ] ) ) {
							$metafield_class = 'Lsvr_Tax_Metafield_' . ucwords( $this->fields[ $key ][ 'type' ], '_' );
						}

						// Field type specific sanitization
						if ( ! empty( $metafield_class ) && class_exists( $metafield_class )
							&& method_exists( $metafield_class, 'sanitize_before_save' ) ) {
							$term_meta[ $key ] = $metafield_class::sanitize_before_save( $_POST[ $this->taxonomy_name . '_tax_meta' ][ $key ] );
						}

						// Default sanitization
						else {
							$term_meta[ $key ] = sanitize_text_field( $_POST[ $this->taxonomy_name . '_tax_meta' ][ $key ] );
						}

					}
				}
				update_option( $this->taxonomy_name . '_term_' . (int) $term_id . '_meta', $term_meta );
			}
		}

	}
}