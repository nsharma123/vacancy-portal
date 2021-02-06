<?php
/**
 * Attachment metafield class
 */
if ( ! class_exists( 'Lsvr_Post_Metafield_Attachment' ) && class_exists( 'Lsvr_Post_Metafield' ) ) {
    class Lsvr_Post_Metafield_Attachment extends Lsvr_Post_Metafield {

    	public function __construct( $args ) {
    		parent::__construct( $args );
    	}

    	// Display field
    	public function display_metafield() {

            $multiple = isset( $this->args['multiple'] ) && true === $this->args['multiple'] ? true : false;
            $media_type = isset( $this->args['media_type'] ) && is_array( $this->args['media_type'] ) ? (array) $this->args['media_type'] : false;
            $current_attachment_ids = ! empty( $this->current_value ) ? explode( ',', $this->current_value ) : false;
            $remove_btn_label = esc_html__( 'Remove', 'lsvr-framework' );

            ?>

            <div class="lsvr-post-metafield-attachment"
                data-title-label="<?php esc_html_e( 'Select or Upload Files (hold CTRL or CMD key to select multiple files)', 'lsvr-framework' ); ?>"
                data-allow-multiple="<?php echo true === $multiple ? 'true' : 'false'; ?>"
                <?php if ( ! empty( $media_type ) ) : ?>
                    data-media-type="<?php echo esc_attr( implode( ',', $media_type ) ); ?>"
                <?php endif; ?>>

        		<input type="hidden" value="<?php echo esc_attr( $this->current_value ); ?>"
    				class="lsvr-post-metafield__value lsvr-post-metafield-attachment__value"
    				id="<?php echo esc_attr( $this->input_id ); ?>" name="<?php echo esc_attr( $this->input_id ); ?>">

                <div class="lsvr-post-metafield-attachment__item-list-wrapper"
                    <?php if ( empty( $current_attachment_ids ) ) : ?>style="display: none;"<?php endif; ?>>

                    <ul class="lsvr-post-metafield-attachment__item-list">

                        <?php // Display current attachments
                        if ( ! empty( $current_attachment_ids ) ) : ?>

                            <?php foreach( $current_attachment_ids as $attachment_id ) : ?>

                                <li class="lsvr-post-metafield-attachment__item"
                                    data-attachment-id="<?php echo esc_attr( $attachment_id ); ?>">
                                    <div class="lsvr-post-metafield-attachment__item-inner">

                                        <?php echo esc_html( basename( get_attached_file( $attachment_id ) ) ); ?>
                                        <button class="lsvr-post-metafield-attachment__btn-remove" type="button"><i class="dashicons dashicons-no-alt"></i></button>

                                    </div>
                                </li>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </ul>

                    <p class="howto lsvr-post-metafield-attachment__hint">
                        <?php esc_html_e( 'You can rearrange items via drag and drop', 'lsvr-framework' ); ?>
                    </p>

                </div>

                <button type="button" class="button button-primary button-large lsvr-post-metafield-attachment__btn-select">
                    <?php if ( ! empty( $this->args['select_btn_label'] ) ) : ?>
                        <?php echo esc_html( $this->args['select_btn_label'] ); ?>
                    <?php else : ?>
                        <?php esc_html_e( 'Select', 'lsvr-framework' ); ?>
                    <?php endif;  ?>
                </button>

            </div>

    		<?php
    	}

    }
}

?>