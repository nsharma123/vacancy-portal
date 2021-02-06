<?php
/**
 * Image widget field class
 */
if ( ! class_exists( 'Lsvr_Widget_Field_Image' ) && class_exists( 'Lsvr_Widget_Field' ) ) {
    class Lsvr_Widget_Field_Image extends Lsvr_Widget_Field {

    	public function __construct( $args ) {
    		parent::__construct( $args );
    	}

    	// Display field
    	public function display_field() {
    		?>

            <label class="lsvr-widget-field__label" for="<?php echo esc_attr( $this->input_id ); ?>">
                <?php echo esc_attr( $this->args['label'] ); ?>
            </label>
            <input type="hidden" class="lsvr-widget-field__input"
                value="<?php echo ! empty( $this->saved_value ) ? esc_attr( $this->saved_value ) : ''; ?>"
                id="<?php echo esc_attr( $this->input_id ); ?>"
                name="<?php echo esc_attr( $this->input_name ); ?>">

            <div class="lsvr-widget-field__image<?php if ( ! empty( $this->saved_value ) ) { echo ' lsvr-widget-field__image--has-image'; } ?>">
                <div class="lsvr-widget-field__image-preview">
                    <div class="lsvr-widget-field__image-placeholder">
                        <?php if ( ! empty( $this->saved_value ) ) : ?>
                            <?php echo wp_get_attachment_image( (int) $this->saved_value , 'thumbnail' ); ?>
                        <?php endif; ?>
                    </div>
                    <p class="lsvr-widget-field__image-message"><?php esc_html_e( 'No image selected', 'lsvr-framework' ); ?></p>
                </div>
                <button class="button lsvr-widget-field__image-add" type="button"><?php esc_html_e( 'Choose Image', 'lsvr-framework' ); ?></button>
                <button class="button lsvr-widget-field__image-remove" type="button"><?php esc_html_e( 'Remove Image', 'lsvr-framework' ); ?></button>
            </div>

			<?php
    	}

    }
}