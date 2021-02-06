<?php
/**
 * Post widget field class
 */
if ( ! class_exists( 'Lsvr_Widget_Field_Post' ) && class_exists( 'Lsvr_Widget_Field' ) ) {
    class Lsvr_Widget_Field_Post extends Lsvr_Widget_Field {

    	public function __construct( $args ) {
    		parent::__construct( $args );
    	}

    	// Display field
    	public function display_field() {
    		?>

            <?php $posts = get_posts(array(
                'post_type' => ! empty( $this->args['post_type'] ) ? $this->args['post_type'] : 'post',
                'posts_per_page' => 1000,
                'orderby' => 'title',
                'order' => 'ASC',
            )); ?>

			<label class="lsvr-widget-field__label" for="<?php echo esc_attr( $this->input_id ); ?>">
				<?php echo esc_attr( $this->args['label'] ); ?>
			</label>

            <?php if ( ! empty( $posts ) ) : ?>

                <select class="lsvr-widget-field__input widefat"
                    id="<?php echo esc_attr( $this->input_id ); ?>"
                    name="<?php echo esc_attr( $this->input_name ); ?>">

                    <?php if ( ! empty( $this->args['default_label'] ) ) : ?>
                        <option value="none"><?php echo esc_html( $this->args['default_label'] ); ?></option>
                    <?php endif; ?>

                    <?php foreach ( $posts as $post ) : ?>
                        <option value="<?php echo esc_attr( $post->ID ); ?>"
                            <?php if ( ! empty( $this->saved_value ) && (int) $this->saved_value === $post->ID ) { echo ' selected="selected"'; } ?>>
                            <?php echo esc_html( $post->post_title ); ?>
                        </option>
                    <?php endforeach; ?>

                </select>

            <?php else : ?>

                <?php esc_html_e( 'There are no posts', 'lsvr-framework' ); ?>

            <?php endif; ?>

			<?php
    	}

    }
}