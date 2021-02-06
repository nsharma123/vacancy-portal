<?php
/**
 * LSVR Featured Document widget
 *
 * Single lsvr_document post
 */
if ( ! class_exists( 'Lsvr_Widget_Document_Featured' ) && class_exists( 'Lsvr_Widget' ) ) {
class Lsvr_Widget_Document_Featured extends Lsvr_Widget {

    public function __construct() {

    	// Init widget
		parent::__construct(array(
			'id' => 'lsvr_documents_document_featured',
			'classname' => 'lsvr_document-featured-widget',
			'title' => esc_html__( 'LSVR Featured Document', 'lsvr-documents' ),
			'description' => esc_html__( 'Single Document post', 'lsvr-documents' ),
			'fields' => array(
				'title' => array(
					'label' => esc_html__( 'Title:', 'lsvr-documents' ),
					'type' => 'text',
					'default' => esc_html__( 'Featured Document', 'lsvr-documents' ),
				),
				'post' => array(
					'label' => esc_html__( 'Document:', 'lsvr-documents' ),
					'description' => esc_html__( 'Choose document to display.', 'lsvr-documents' ),
					'type' => 'post',
					'post_type' => 'lsvr_document',
					'default_label' => esc_html__( 'Random', 'lsvr-documents' ),
				),
				'show_date' => array(
					'label' => esc_html__( 'Display Date', 'lsvr-documents' ),
					'type' => 'checkbox',
					'default' => 'true',
				),
				'show_category' => array(
					'label' => esc_html__( 'Display Category', 'lsvr-documents' ),
					'type' => 'checkbox',
					'default' => 'true',
				),
				'show_excerpt' => array(
					'label' => esc_html__( 'Display Excerpt', 'lsvr-documents' ),
					'type' => 'checkbox',
					'default' => 'true',
				),
				'show_attachments' => array(
					'label' => esc_html__( 'Display Attachments', 'lsvr-documents' ),
					'type' => 'checkbox',
					'default' => 'true',
				),
				'show_attachment_titles' => array(
					'label' => esc_html__( 'Display Attachment Titles', 'lsvr-documents' ),
					'description' => esc_html__( 'Display titles instead of file names. You can edit titles under Media.', 'lsvr-documents' ),
					'type' => 'checkbox',
					'default' => 'false',
				),
				'more_label' => array(
					'label' => esc_html__( 'More Button Label:', 'lsvr-documents' ),
					'description' => esc_html__( 'Link to document post archive. Leave blank to hide.', 'lsvr-documents' ),
					'type' => 'text',
					'default' => esc_html__( 'More Documents', 'lsvr-documents' ),
				),
			),
		));

    }

    function widget( $args, $instance ) {

    	// Show date
    	$show_date = ! empty( $instance['show_date'] ) && ( true === $instance['show_date'] || 'true' === $instance['show_date'] || '1' === $instance['show_date'] ) ? true : false;

    	// Show category
    	$show_category = ! empty( $instance['show_category'] ) && ( true === $instance['show_category'] || 'true' === $instance['show_category'] || '1' === $instance['show_category'] ) ? true : false;

		// Show excerpt
    	$show_excerpt = ! empty( $instance['show_excerpt'] ) && ( true === $instance['show_excerpt'] || 'true' === $instance['show_excerpt'] || '1' === $instance['show_excerpt'] ) ? true : false;

		// Show attachments
    	$show_attachments = ! empty( $instance['show_attachments'] ) && ( true === $instance['show_attachments'] || 'true' === $instance['show_attachments'] || '1' === $instance['show_attachments'] ) ? true : false;

		// Show attachment title
    	$show_attachment_titles = ! empty( $instance['show_attachment_titles'] ) && ( true === $instance['show_attachment_titles'] || 'true' === $instance['show_attachment_titles'] || '1' === $instance['show_attachment_titles'] ) ? true : false;

    	// Get random post
    	if ( empty( $instance['post'] ) || ( ! empty( $instance['post'] ) && 'none' === $instance['post'] ) ) {
    		$document_post = get_posts( array(
    			'post_type' => 'lsvr_document',
    			'orderby' => 'rand',
    			'posts_per_page' => '1'
			));
			$document_post = ! empty( $document_post[0] ) ? $document_post[0] : '';
    	}

    	// Get post
    	else if ( ! empty( $instance['post'] ) ) {
    		$document_post = get_post( $instance['post'] );
    	}

        ?>

        <?php // Before widget content
        parent::before_widget_content( $args, $instance ); ?>

        <div class="widget__content lsvr_document-featured-widget__content">

        	<?php if ( ! empty( $document_post ) ) : ?>

    			<h4 class="lsvr_document-featured-widget__title">
    				<a href="<?php echo esc_url( get_permalink( $document_post->ID ) ); ?>" class="lsvr_document-featured-widget__title-link">
    					<?php echo get_the_title( $document_post->ID ); ?>
    				</a>
    			</h4>

				<?php // Date
				if ( true === $show_date ) : ?>
					<p class="lsvr_document-featured-widget__date">
						<time datetime="<?php echo esc_attr( get_the_time( 'c', $document_post->ID ) ); ?>">
							<?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $document_post->post_date ) ) ); ?>
						</time>
					</p>
				<?php endif; ?>

				<?php // Category
				$terms = wp_get_post_terms( $document_post->ID, 'lsvr_document_cat' );
				$category_html = '';
				if ( ! empty( $terms ) ) {
					foreach ( $terms as $term ) {
						$category_html .= '<a href="' . esc_url( get_term_link( $term->term_id, 'lsvr_document_cat' ) ) . '" class="lsvr_document-featured-widget__category-link">' . $term->name . '</a>';
						$category_html .= $term !== end( $terms ) ? ', ' : '';
					}
				}
				if ( true === $show_category && ! empty( $category_html ) ) : ?>
					<p class="lsvr_document-featured-widget__category">
						<?php echo sprintf( esc_html__( 'in %s', 'lsvr-documents' ), $category_html ); ?>
					</p>
				<?php endif; ?>

				<?php // Excerpt
				if ( true === $show_excerpt && has_excerpt( $document_post->ID ) ) : ?>
					<div class="lsvr_document-featured-widget__excerpt">
						<?php echo wpautop( get_the_excerpt( $document_post->ID ) ); ?>
					</div>
				<?php endif; ?>

				<?php // Attachments
				if ( true === $show_attachments && ! post_password_required( $document_post->ID ) ) : ?>

					<?php $attachments = lsvr_documents_get_document_attachments( $document_post->ID ); ?>
					<?php if ( ! empty( $attachments ) ) : ?>
						<ul class="lsvr_document-featured-widget__attachments">

							<?php foreach ( $attachments as $attachment ) : ?>

								<li class="lsvr_document-featured-widget__attachment">

	        						<i class="lsvr_document-featured-widget__attachment-icon lsvr_document-attachment-icon lsvr_document-attachment-icon--<?php echo esc_attr( $attachment['filetype'] ); ?>"></i>
									<a href="<?php echo esc_url( $attachment['url'] ); ?>"
										target="_blank"
										class="lsvr_document-featured-widget__attachment-link">
										<?php if ( true === $show_attachment_titles && ! empty( $attachment['title'] ) ) {
											echo esc_html( $attachment['title'] );
										} else {
											echo esc_html( $attachment['filename'] );
										} ?>
									</a>
									<?php if ( ! empty( $attachment['filesize'] ) ) : ?>
										<span class="lsvr_document-featured-widget__attachment-filesize"><?php echo esc_html( $attachment['filesize'] ); ?></span>
									<?php endif; ?>
									<?php if ( true === $attachment['external'] ) : ?>
										<span class="lsvr_document-featured-widget__attachment-label"><?php esc_html_e( 'External', 'lsvr-documents' ); ?></span>
									<?php endif; ?>

								</li>

							<?php endforeach; ?>

						</ul>
					<?php endif; ?>

				<?php endif; ?>

				<?php if ( ! empty( $instance[ 'more_label' ] ) ) : ?>
				<p class="widget__more">
					<a href="<?php echo esc_url( get_post_type_archive_link( 'lsvr_document' ) ); ?>" class="widget__more-link"><?php echo esc_html( $instance[ 'more_label' ] ); ?></a>
				</p>
				<?php endif; ?>

        	<?php else : ?>
        		<p class="widget__no-results"><?php esc_html_e( 'There are no documents', 'lsvr-documents' ); ?></p>
        	<?php endif; ?>

        </div>

        <?php // After widget content
        parent::after_widget_content( $args, $instance ); ?>

        <?php

    }

}}

?>