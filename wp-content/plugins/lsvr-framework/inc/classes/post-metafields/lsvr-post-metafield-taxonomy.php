<?php
/**
 * Taxonomy metafield class
 */
if ( ! class_exists( 'Lsvr_Post_Metafield_Taxonomy' ) && class_exists( 'Lsvr_Post_Metafield' ) ) {
    class Lsvr_Post_Metafield_Taxonomy extends Lsvr_Post_Metafield {

    	public function __construct( $args ) {
    		parent::__construct( $args );
    	}

    	// Display field
    	public function display_metafield() {

            // Get list of all taxonomy terms
            if ( ! empty( $this->args['taxonomy'] ) && taxonomy_exists( $this->args['taxonomy'] ) ) {
                $tax_terms = get_terms(array(
                    'taxonomy' => $this->args['taxonomy'],
                    'orderby' => 'name',
                    'hide_empty' => false,
                ));
            }

            // Extract current term ID from saved meta value
            if ( ! empty( $this->current_value ) && 'false' !== $this->current_value ) {
                $current_term_id = explode( ',', $this->current_value );
                $current_term_id = ! empty( $current_term_id[1] ) ? $current_term_id[1] : '';
            } else {
                $current_term_id = false;
            }

    		?>

            <?php if ( ! empty( $tax_terms ) ) : ?>

                <div class="lsvr-post-metafield-taxonomy">

                    <input type="hidden" value="<?php echo esc_attr( $this->current_value ); ?>"
                        class="lsvr-post-metafield__value lsvr-post-metafield-taxonomy__value"
                        id="<?php echo esc_attr( $this->input_id ); ?>" name="<?php echo esc_attr( $this->input_id ); ?>">
                    <input type="hidden" value="<?php echo esc_attr( $this->args['taxonomy'] ); ?>"
                        class="lsvr-post-metafield-taxonomy__slug">

                    <select class="lsvr-post-metafield-taxonomy__select">

                        <option value="false"
                            <?php if ( 'false' === $this->current_value ) { echo ' selected="selected"'; } ?>>
                            <?php esc_html_e( 'None', 'lsvr-framework' ); ?>
                        </option>

                        <?php foreach ( $tax_terms as $term ) : ?>
                            <option value="<?php echo esc_attr( $term->term_id ); ?>"
                                <?php if ( (int) $term->term_id === (int) $current_term_id ) { echo ' selected="selected"'; } ?>>
                                <?php echo esc_html( $term->name ); ?>
                            </option>
                        <?php endforeach; ?>

                    </select>

                </div>

            <?php elseif ( ! empty( $this->args['no_terms_msg'] ) ) : ?>

                <p><em><?php echo esc_html( $this->args['no_terms_msg'] ); ?></em></p>

            <?php endif; ?>

    		<?php
    	}

    }
}

?>