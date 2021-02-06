<?php
/**
 * Gallery metafield class
 */
if ( ! class_exists( 'Lsvr_Post_Metafield_Gallery' ) && class_exists( 'Lsvr_Post_Metafield' ) ) {
    class Lsvr_Post_Metafield_Gallery extends Lsvr_Post_Metafield {

    	public function __construct( $args ) {
    		parent::__construct( $args );
    	}

    	// Display field
    	public function display_metafield() {

            $current_attachment_ids = ! empty( $this->current_value ) ? explode( ',', $this->current_value ) : false;
            $remove_btn_label = esc_html__( 'Remove', 'lsvr-framework' );

            ?>

            <div class="lsvr-post-metafield-gallery"
                data-title-label="<?php esc_html_e( 'Select or Upload Files (hold CTRL or CMD key to select multiple files)', 'lsvr-framework' ); ?>">

        		<input type="hidden" value="<?php echo esc_attr( $this->current_value ); ?>"
    				class="lsvr-post-metafield__value lsvr-post-metafield-gallery__value"
    				id="<?php echo esc_attr( $this->input_id ); ?>" name="<?php echo esc_attr( $this->input_id ); ?>">

                <div class="lsvr-post-metafield-gallery__item-list-wrapper"
                    <?php if ( empty( $current_attachment_ids ) ) : ?>style="display: none;"<?php endif; ?>>

                    <ul class="lsvr-post-metafield-gallery__item-list">

                        <?php // Display current attachments
                        if ( ! empty( $current_attachment_ids ) ) : ?>

                            <?php foreach( $current_attachment_ids as $attachment_id ) : ?>

                                <li class="lsvr-post-metafield-gallery__item"
                                    data-attachment-id="<?php echo esc_attr( $attachment_id ); ?>">
                                    <div class="lsvr-post-metafield-gallery__item-inner">

                                        <?php $image_src = wp_get_attachment_image_src( $attachment_id, 'thumbnail' ); ?>
                                        <?php if ( is_array( $image_src ) ) : ?>
                                            <img class="lsvr-post-metafield-gallery__image"
                                                src="<?php echo esc_url( $image_src[0] ) ?>" alt="">
                                        <?php endif; ?>

                                        <button class="lsvr-post-metafield-gallery__btn-remove" type="button"><i class="dashicons dashicons-no-alt"></i></button>

                                    </div>
                                </li>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </ul>

                    <p class="howto lsvr-post-metafield-gallery__hint">
                        <?php esc_html_e( 'You can rearrange items via drag and drop', 'lsvr-framework' ); ?>
                    </p>

                </div>

                <button type="button" class="button button-primary button-large lsvr-post-metafield-gallery__btn-select">
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