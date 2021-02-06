<?php
/**
 * Taxonomy metafield class
 */
if ( ! class_exists( 'Lsvr_Post_Metafield_Taxonomy_Assign' ) && class_exists( 'Lsvr_Post_Metafield' ) ) {
    class Lsvr_Post_Metafield_Taxonomy_Assign extends Lsvr_Post_Metafield {

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

        // Action fired after saving
        public static function after_save( $post_id, $value ) {

            // Assign the chosen taxonomy term to this post via WP function
            if ( ! empty( $post_id ) && ! empty( $value ) ) {

                // Parse current value to get taxonomy slug and term id
                $value_arr = explode( ',', $value );
                $taxonomy = ! empty( $value_arr[0] ) ? $value_arr[0] : false;
                $term_id = ! empty( $value_arr[1] ) ? $value_arr[1] : false;

                if ( ! empty( $taxonomy ) && ! empty( $term_id ) ) {
                    wp_set_object_terms( $post_id, (int) $term_id, sanitize_key( $taxonomy ), false );
                } elseif ( ! empty( $taxonomy ) ) {
                    wp_delete_object_term_relationships( $post_id, sanitize_key( $taxonomy ) );
                }

            }

        }

    }
}

?>