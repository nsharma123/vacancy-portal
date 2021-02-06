<?php
/**
 * External attachment metafield class
 */
if ( ! class_exists( 'Lsvr_Post_Metafield_External_Attachment' ) && class_exists( 'Lsvr_Post_Metafield' ) ) {
    class Lsvr_Post_Metafield_External_Attachment extends Lsvr_Post_Metafield {

    	public function __construct( $args ) {
    		parent::__construct( $args );
    	}

    	// Display field
    	public function display_metafield() {

            $remove_btn_label = esc_html__( 'Remove', 'lsvr-framework' );
            $current_attachments = ! empty( $this->current_value ) ? explode( '|', $this->current_value ) : false;
    		?>

            <div class="lsvr-post-metafield-ext-attachment">

        		<input type="hidden" value="<?php echo esc_attr( $this->current_value ); ?>"
    				class="lsvr-post-metafield__value lsvr-post-metafield-ext-attachment__value"
    				id="<?php echo esc_attr( $this->input_id ); ?>"
    				name="<?php echo esc_attr( $this->input_id ); ?>">

                <div class="lsvr-post-metafield-ext-attachment__item-list-wrapper"
                    <?php if ( empty( $current_attachments ) ) : ?>style="display: none;"<?php endif; ?>>

                    <ul class="lsvr-post-metafield-ext-attachment__item-list">

                        <?php // Display current attachments
                        if ( ! empty( $current_attachments ) ) : ?>
                            <?php foreach( $current_attachments as $attachment_url ) : ?>

                                <li class="lsvr-post-metafield-ext-attachment__item"
                                    data-encoded-url="<?php echo esc_attr( $attachment_url ); ?>">
                                    <div class="lsvr-post-metafield-ext-attachment__item-inner">

                                        <?php echo esc_html( urldecode( $attachment_url ) ); ?>
                                        <button class="lsvr-post-metafield-ext-attachment__btn-remove" type="button"><i class="dashicons dashicons-no-alt"></i></button>

                                    </div>
                                </li>

                            <?php endforeach; ?>
                        <?php endif; ?>

                    </ul>

                    <p class="howto lsvr-post-metafield-ext-attachment__hint">
                        <?php esc_html_e( 'You can rearrange items via drag and drop', 'lsvr-framework' ); ?>
                    </p>

                </div>

                <input type="text" class="lsvr-post-metafield-ext-attachment__url-input">
                <button type="button" class="button button-primary button-large lsvr-post-metafield-ext-attachment__btn-add">
                    <?php esc_html_e( 'Add URL', 'lsvr-framework' ); ?>
                </button>

            </div>

    		<?php
    	}

    }
}

?>