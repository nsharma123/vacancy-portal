<?php
/**
 * LSVR Document Attachments widget
 *
 * Display list of lsvr_document attachments
 */
if ( ! class_exists( 'Lsvr_Widget_Document_Attachments' ) && class_exists( 'Lsvr_Widget' ) ) {
class Lsvr_Widget_Document_Attachments extends Lsvr_Widget {

    public function __construct() {

    	// Init widget
		parent::__construct(array(
			'id' => 'lsvr_documents_document_attachments',
			'classname' => 'lsvr_document-attachments-widget',
			'title' => esc_html__( 'LSVR Document Attachments', 'lsvr-documents' ),
			'description' => esc_html__( 'List of Document Attachments', 'lsvr-documents' ),
			'fields' => array(
				'title' => array(
					'label' => esc_html__( 'Title:', 'lsvr-documents' ),
					'type' => 'text',
					'default' => esc_html__( 'Attachments', 'lsvr-documents' ),
				),
				'category' => array(
					'label' => esc_html__( 'Category:', 'lsvr-documents' ),
					'description' => esc_html__( 'Display only attachments from a certain category.', 'lsvr-documents' ),
					'type' => 'taxonomy',
					'taxonomy' => 'lsvr_document_cat',
					'default_label' => esc_html__( 'None', 'lsvr-documents' ),
				),
				'tags' => array(
					'label' => esc_html__( 'Tags:', 'lsvr-documents' ),
					'description' => esc_html__( 'Display only attachments which contain certain tags. Separate tag slugs by comma.', 'lsvr-documents' ),
					'type' => 'text',
				),
				'limit' => array(
					'label' => esc_html__( 'Limit:', 'lsvr-documents' ),
					'description' => esc_html__( 'Number of attachments to display.', 'lsvr-documents' ),
					'type' => 'select',
					'choices' => array( 0 => esc_html__( 'All', 'lsvr-documents' ), 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ),
					'default' => 4,
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

    	// Show attachment titles
    	$show_attachment_titles = ! empty( $instance['show_attachment_titles'] ) && ( true === $instance['show_attachment_titles'] || 'true' === $instance['show_attachment_titles'] || '1' === $instance['show_attachment_titles'] ) ? true : false;

		// Set posts limit
		$limit = array_key_exists( 'limit', $instance ) && (int) $instance[ 'limit' ] > 0 ? $instance[ 'limit' ] : 1000;

    	// Get document posts
    	$query_args = array(
    		'post_type' => 'lsvr_document',
    		'posts_per_page' => $limit,
    		'has_password' => false,
    		'suppress_filters' => false,
		);

		// Show posts only from a certain category
		if ( ! empty( $instance['category'] ) && 'none' !== $instance['category'] ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'lsvr_document_cat',
					'field' => 'term_id',
					'terms' => $instance['category'],
				),
			);
		}

		// Exclude posts from certain categories
		else {
			$excluded_categories = array();
			$excluded_categories_data = get_theme_mod( 'lsvr_document_excluded_categories', '' );
			if ( ! empty( $excluded_categories_data ) ) {
				$excluded_categories_arr = array_map( 'trim', explode( ',', $excluded_categories_data ) );
				foreach ( $excluded_categories_arr as $excluded ) {
					if ( is_numeric( $excluded ) ) {
						array_push( $excluded_categories, (int) $excluded );
					} else {
						 $term = get_term_by( 'slug', $excluded, 'lsvr_document_cat' );
						 if ( ! empty( $term->term_id ) ) {
						 	array_push( $excluded_categories, $term->term_id );
						 }
					}
				}
			}
			if ( ! empty( $excluded_categories ) ) {
				$query_args[ 'tax_query' ] = array(
					array(
						'taxonomy' => 'lsvr_document_cat',
						'field' => 'term_id',
						'terms' => $excluded_categories,
						'operator' => 'NOT IN',
					),
				);
			}
		}

    	// Show posts only with certain tags
		if ( ! empty( $instance['tags'] ) ) {

			$tags_tax_query = array(
				array(
					'taxonomy' => 'lsvr_document_tag',
					'field' => 'slug',
					'terms' => array_map( 'trim', explode( ',', $instance['tags'] ) ),
				),
			);

			if ( ! empty( $query_args['tax_query'] ) ) {
				$query_args['tax_query'] = array_merge( $query_args['tax_query'], $tags_tax_query );
			} else {
				$query_args['tax_query'] = $tags_tax_query;
			}

		}

    	$posts = get_posts( $query_args );

        ?>

        <?php // Before widget content
        parent::before_widget_content( $args, $instance ); ?>

        <div class="widget__content">

        	<?php if ( ! empty( $posts ) ) : ?>

        		<ul class="lsvr_document-attachments-widget__list">
	        		<?php $i = 0; foreach ( $posts as $document_post ) : ?>

	        			<?php $document_attachments = lsvr_documents_get_document_attachments( $document_post->ID ); ?>
	        			<?php if ( ! empty( $document_attachments ) ) : ?>

	        				<?php foreach ( $document_attachments as $attachment ) : ?>

	        					<li class="lsvr_document-attachments-widget__item">

	        						<i class="lsvr_document-attachments-widget__item-icon lsvr_document-attachment-icon lsvr_document-attachment-icon--<?php echo esc_attr( $attachment['filetype'] ); ?>"></i>
									<a href="<?php echo esc_url( $attachment['url'] ); ?>"
										target="_blank"
										class="lsvr_document-attachments-widget__item-link">
										<?php if ( true === $show_attachment_titles && ! empty( $attachment['title'] ) ) {
											echo esc_html( $attachment['title'] );
										} else {
											echo esc_html( $attachment['filename'] );
										} ?>
									</a>
									<?php if ( ! empty( $attachment['filesize'] ) ) : ?>
										<span class="lsvr_document-attachments-widget__item-filesize"><?php echo esc_html( $attachment['filesize'] ); ?></span>
									<?php endif; ?>
									<?php if ( true === $attachment['external'] ) : ?>
										<span class="lsvr_document-attachments-widget__item-label"><?php esc_html_e( 'External', 'lsvr-documents' ); ?></span>
									<?php endif; ?>

	        					</li>

	        					<?php $i++; if ( (int) $limit > 0 && $i >= $limit ) { break 2; } ?>

	        				<?php endforeach; ?>

	        			<?php endif; ?>

	        		<?php endforeach; ?>
        		</ul>

				<?php if ( ! empty( $instance[ 'more_label' ] ) ) : ?>
				<p class="widget__more">
					<?php if ( ! empty( $instance['category'] ) && is_numeric( $instance['category'] ) ) : ?>
						<a href="<?php echo esc_url( get_term_link( (int) $instance['category'], 'lsvr_document_cat' ) ); ?>" class="widget__more-link"><?php echo esc_html( $instance[ 'more_label' ] ); ?></a>
					<?php else : ?>
						<a href="<?php echo esc_url( get_post_type_archive_link( 'lsvr_document' ) ); ?>" class="widget__more-link"><?php echo esc_html( $instance[ 'more_label' ] ); ?></a>
					<?php endif; ?>
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