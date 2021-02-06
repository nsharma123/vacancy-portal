<?php
/**
 * Textarea metafield class
 */
if ( ! class_exists( 'Lsvr_Post_Metafield_Textarea' ) && class_exists( 'Lsvr_Post_Metafield' ) ) {
    class Lsvr_Post_Metafield_Textarea extends Lsvr_Post_Metafield {

    	public function __construct( $args ) {
    		parent::__construct( $args );
    	}

    	// Display field
    	public function display_metafield() {
    		?>

    		<textarea class="lsvr-post-metafield__value lsvr-post-metafield-textarea"
				id="<?php echo esc_attr( $this->input_id ); ?>"
				name="<?php echo esc_attr( $this->input_id ); ?>"
                rows="1" cols="40"><?php echo esc_textarea( $this->current_value ); ?></textarea>

    		<?php
    	}

        // Sanitize metafield value before saving
        public static function sanitize_before_save( $value ) {

            // Allow only some HTML tags
            return wp_kses( $value, array(
                'a' => array(
                    'href' => array(),
                    'title' => array(),
                    'class' => array(),
                ),
                'strong' => array(),
                'p' => array(),
            ));

        }

    }
}

?>