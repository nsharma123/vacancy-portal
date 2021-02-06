<?php
/**
 * General class for handling post metabox fields.
 *
 * @param array $args {
 *
 *		@type string		$id				Unique ID of this metafield. It is used as post's meta key.
 *											It get's echoed into form's HTML as ID attribute
 *											(with '_metafield' postfix).
 *
 *		@type string		$metabox_id		ID of metabox to which this metafield belongs.
 *
 *		@type string		$post_id		ID of currently edited post.
 *											It is required to retrieve the current value of the metafield.
 *
 *		@type array			$args			Array with all attributes required to display the metafield.
 * }
 */
if ( ! class_exists( 'Lsvr_Post_Metafield' ) ) {
	class Lsvr_Post_Metafield {

		public $metafield_id;
		public $metabox_id;
		public $post_id;
		public $args;
		public $input_id;
		public $current_value;
		public $default_value;
		public $is_builder;

		public function __construct( $args ) {

			$this->metafield_id = ! empty( $args['id'] ) ? sanitize_key( $args['id'] ) : '';
			$this->metabox_id = ! empty( $args['metabox_id'] ) ? sanitize_key( $args['metabox_id'] ) : '';
			$this->post_id = ! empty( $args['post_id'] ) ? sanitize_key( $args['post_id'] ) : '';
			$this->args = ! empty( $args['args'] ) ? $args['args'] : '';
			$this->input_id = $this->metafield_id . '_input';
			$this->default_value = ! empty( $this->args['default'] ) ? $this->args['default'] : '';
			$this->current_value = get_post_meta( $this->post_id, $this->metafield_id, true );
			$this->is_builder = ! empty( $args['builder'] ) && true === $args['builder'] ? true : false;

			// Set default value
			if ( '' === $this->current_value ) {
				$this->current_value = $this->default_value;
			}

			// Display metafield
			$this->metafield_before();
			$this->display_metafield();
			$this->metafield_after();

		}

		// Metafield before
		public function metafield_before() {
			?>

			<div class="lsvr-post-metafield"
				data-metafield-id="<?php echo esc_attr( $this->metafield_id ); ?>"
				<?php if ( false === $this->is_builder ) : ?>id="<?php echo esc_attr( $this->metafield_id ) .  '_metafield'; ?>"<?php endif; ?>
				<?php if ( ! empty( $this->args['required'] ) ) {
					echo ' style="display: none;" data-required="' . htmlentities( json_encode( $this->args['required'] ), ENT_QUOTES, 'UTF-8' ) . '"'; }?>>
				<div class="lsvr-post-metafield__inner">

					<?php // Field header
					if ( ! empty( $this->args['title'] ) || ! empty( $this->args['description'] ) ) : ?>

						<div class="lsvr-post-metafield__header">

							<?php // Field title
							if ( ! empty( $this->args['title'] ) ) : ?>

								<h4 class="lsvr-post-metafield__title">
									<?php echo esc_html( $this->args['title'] ); ?>
								</h4>

							<?php endif; ?>

							<?php // Field description
							if ( ! empty( $this->args['description'] ) ) : ?>

								<p class="lsvr-post-metafield__description">
									<?php echo wp_kses( $this->args['description'], array( 'a' => array( 'href' => array() ), 'br' => array(), 'strong' => array() ) ); ?>
								</p>

							<?php endif; ?>

						</div>

					<?php endif; ?>

					<div class="lsvr-post-metafield__content">

			<?php
		}

		// Metafield before
		public function display_metafield() {
			// Defined in child class
		}

		// Metafield after
		public function metafield_after() {
			?>

					</div>
				</div>
			</div>

			<?php
		}

	}
}

?>