<?php

// Document attachments
if ( ! function_exists( 'lsvr_townpress_the_document_attachments' ) ) {
	function lsvr_townpress_the_document_attachments( $post_id ) {

		$document_attachments = lsvr_townpress_get_document_attachments( $post_id );
		if ( ! empty( $document_attachments ) ) { ?>

			<ul class="post__attachment-list">

				<?php foreach ( $document_attachments as $attachment ) : ?>
					<li class="post__attachment-item">
						<i class="post__attachment-icon lsvr_document-attachment-icon lsvr_document-attachment-icon--<?php echo esc_attr( $attachment['extension'] ); ?><?php if ( ! empty( $attachment['filetype'] ) ) { echo ' lsvr_document-attachment-icon--' . esc_attr( $attachment['filetype'] ); } ?>"></i>
						<a href="<?php echo esc_url( $attachment['url'] ); ?>"
							target="_blank"
							class="post__attachment-link">
							<?php if ( true === get_theme_mod( 'lsvr_document_enable_attachment_titles', false ) && ! empty( $attachment['title'] ) ) {
								echo esc_html( $attachment['title'] );
							} else {
								echo esc_html( $attachment['filename'] );
							} ?>
						</a>
						<?php if ( ! empty( $attachment['filesize'] ) ) : ?>
							<span class="post__attachment-filesize"><?php echo esc_html( $attachment['filesize'] ); ?></span>
						<?php endif; ?>
						<?php if ( true === $attachment['external'] ) : ?>
							<span class="post__attachment-label"><?php esc_html_e( 'External', 'townpress' ); ?></span>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>

			</ul>

		<?php }

	}
}

// Display document attachments tree
if ( ! function_exists( 'lsvr_townpress_the_document_categorized_attachments' ) ) {
	function lsvr_townpress_the_document_categorized_attachments() {

    	// Query args
    	$query_args = [
        	'taxonomy' => 'lsvr_document_cat',
        	'title_li' => '',
        	'show_option_none' => false,
        	'orderby' => 'name',
        	'order' => 'ASC',
        	'walker' => new Lsvr_Townpress_Document_Categorized_Attachments_Walker,
    	];

        // Main archive
        if ( is_post_type_archive( 'lsvr_document' ) ) {

        	// Get exluded categories
        	$excluded_categories = [];
        	if ( lsvr_townpress_is_document() && ! is_tax( 'lsvr_document_category' ) ) {
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
        	}

        	// Exclude categories
        	if ( ! empty( $excluded_categories ) ) {
        		$query_args['exclude'] = $excluded_categories;
        	}

		}

    	// Category archive
    	else if ( is_tax( 'lsvr_document_cat' ) ) {
			$query_args['child_of'] = get_queried_object_id();
    	}

    	// Get current category attachments
    	$root_attachments = lsvr_townpress_get_document_archive_attachments(); ?>

		<!-- POST ARCHIVE TREE : begin -->
		<div class="post-tree">
			<ul class="post-tree__children post-tree__children--level-1">

		        <?php // Categories
		        wp_list_categories( $query_args ); ?>

	        	<?php // Current category attachments
	        	if ( ! empty( $root_attachments ) ) : ?>
	        		<?php foreach ( $root_attachments as $attachment ) : ?>

						<li class="post-tree__item post-tree__item--file post-tree__item--level-1">

							<div class="post-tree__item-link-holder post-tree__item-link-holder--file">

								<i class="post-tree__item-icon lsvr_document-attachment-icon lsvr_document-attachment-icon--<?php echo esc_attr( $attachment['extension'] ); ?>"></i>
								<a href="<?php echo esc_url( $attachment['url'] ); ?>"
									target="_blank"
									class="post-tree__item-link post-tree__item-link--file">
									<?php if ( true === get_theme_mod( 'lsvr_document_enable_attachment_titles', false ) && ! empty( $attachment['title'] ) ) {
										echo esc_html( $attachment['title'] );
									} else {
										echo esc_html( $attachment['filename'] );
									} ?>
								</a>
								<?php if ( ! empty( $attachment['filesize'] ) ) : ?>
									<span class="post-tree__item-size"><?php echo esc_html( $attachment['filesize'] ); ?></span>
								<?php endif; ?>
								<?php if ( true === $attachment['external'] ) : ?>
									<span class="post-tree__item-label"><?php esc_html_e( 'External', 'townpress' ); ?></span>
								<?php endif; ?>

							</div>

						</li>

	        		<?php endforeach; ?>
	        	<?php endif; ?>

	        </ul>
        </div>
        <!-- POST ARCHIVE TREE : end -->

	<?php }
}

?>