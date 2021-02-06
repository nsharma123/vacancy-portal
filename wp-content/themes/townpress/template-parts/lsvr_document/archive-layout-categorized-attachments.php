<!-- POST ARCHIVE : begin -->
<div class="lsvr_document-post-page post-archive lsvr_document-post-archive lsvr_document-post-archive--categorized-attachments">

	<?php // Archive header
	get_template_part( 'template-parts/lsvr_document/archive-header' ); ?>

	<?php if ( have_posts() ) : ?>

		<?php if ( is_tax( 'lsvr_document_cat' ) && ! empty( term_description( get_queried_object_id(), 'lsvr_document_cat' ) ) ) : ?>

			<!-- CATEGORY DESCRIPTION : begin -->
			<div class="post-category-description">
				<div class="c-content-box">
					<?php echo term_description( get_queried_object_id(), 'lsvr_document_cat' ); ?>
				</div>
			</div>
			<!-- CATEGORY DESCRIPTION : end -->

		<?php endif; ?>

		<div class="c-content-box">

    		<?php // Categorized attachments
    		lsvr_townpress_the_document_categorized_attachments(); ?>

		</div>

	<?php else : ?>

		<?php lsvr_townpress_the_alert_message( esc_html__( 'There are no documents', 'townpress' ) ); ?>

	<?php endif; ?>

</div>
<!-- POST ARCHIVE : end -->
