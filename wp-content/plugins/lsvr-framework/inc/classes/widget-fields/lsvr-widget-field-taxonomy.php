<?php
/**
 * Taxonomy widget field class
 */
if ( ! class_exists( 'Lsvr_Widget_Field_Taxonomy' ) && class_exists( 'Lsvr_Widget_Field' ) ) {
    class Lsvr_Widget_Field_Taxonomy extends Lsvr_Widget_Field {

    	public function __construct( $args ) {
    		parent::__construct( $args );
    	}

    	// Display field
    	public function display_field() {
    		?>

            <?php $taxonomy_terms = get_terms(array(
                'taxonomy' => ! empty( $this->args['taxonomy'] ) ? $this->args['taxonomy'] : 'category',
                'hide_empty' => false,
            )); ?>

            <label class="lsvr-widget-field__label" for="<?php echo esc_attr( $this->input_id ); ?>">
                <?php echo esc_attr( $this->args['label'] ); ?>
            </label>

            <?php if ( ! empty( $taxonomy_terms ) ) : ?>

                <select class="lsvr-widget-field__input widefat"
                    id="<?php echo esc_attr( $this->input_id ); ?>"
                    name="<?php echo esc_attr( $this->input_name ); ?>">

                    <?php if ( ! empty( $this->args['default_label'] ) ) : ?>
                        <option value="none"><?php echo esc_html( $this->args['default_label'] ); ?></option>
                    <?php endif; ?>

                    <?php foreach ( $taxonomy_terms as $term ) : if ( is_object( $term ) ) : ?>
                        <option value="<?php echo esc_attr( $term->term_id ); ?>"
                            <?php if ( ! empty( $this->saved_value ) && (int) $this->saved_value === $term->term_id ) { echo ' selected="selected"'; } ?>>
                            <?php echo esc_html( $term->name ); ?>
                        </option>
                    <?php endif; endforeach; ?>

                </select>

            <?php else : ?>

                <?php esc_html_e( 'There are no items', 'lsvr-framework' ); ?>

            <?php endif; ?>

			<?php
    	}

    }
}