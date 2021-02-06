<?php
/**
 * Image metafield class
 */
if ( ! class_exists( 'Lsvr_Tax_Metafield_Image' ) && class_exists( 'Lsvr_Tax_Metafield' ) ) {
    class Lsvr_Tax_Metafield_Image extends Lsvr_Tax_Metafield {

    	public function __construct( $args ) {
    		parent::__construct( $args );
    	}

    	// Display field
    	public function display_metafield() {
    		?>

    		<input type="hidden" value="<?php echo esc_attr( $this->current_value ); ?>"
				class="lsvr-tax-metafield__value"
				id="<?php echo esc_attr( $this->input_id ); ?>"
				name="<?php echo esc_attr( $this->input_id ); ?>">

            <div class="lsvr-tax-metafield__image<?php if ( ! empty( $this->current_value ) ) { echo ' lsvr-tax-metafield__image--has-image'; } ?>">
                <div class="lsvr-tax-metafield__image-preview">
                    <div class="lsvr-tax-metafield__image-placeholder">
                        <?php if ( ! empty( $this->current_value ) ) : ?>
                            <?php echo wp_get_attachment_image( (int) $this->current_value , 'thumbnail' ); ?>
                        <?php endif; ?>
                    </div>
                    <?php if ( empty( $this->current_value ) ) : ?>
                        <p class="lsvr-tax-metafield__image-message"><?php esc_html_e( 'No image selected', 'lsvr-framework' ); ?></p>
                    <?php endif; ?>
                </div>
                <button class="button lsvr-tax-metafield__image-add" type="button"><?php esc_html_e( 'Choose Image', 'lsvr-framework' ); ?></button>
                <button class="button lsvr-tax-metafield__image-remove" type="button"><?php esc_html_e( 'Remove Image', 'lsvr-framework' ); ?></button>
            </div>

    		<?php
    	}

    }
}

?>