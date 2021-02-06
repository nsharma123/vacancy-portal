<!-- DOCUMENT POST ARCHIVE : begin -->
<div class="lsvr_document-post-page post-archive lsvr_document-post-archive lsvr_document-post-archive--default">

	<?php // Archive header
	get_template_part( 'template-parts/lsvr_document/archive-header' ); ?>

	<?php // Document categories
	if ( true === get_theme_mod( 'lsvr_document_archive_categories_enable', true ) ) {
		lsvr_townpress_the_post_archive_categories( 'lsvr_document', 'lsvr_document_cat' );
	} ?>

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

		<!-- POST ARCHIVE LIST : begin -->
		<div class="post-archive__list">

			<?php while ( have_posts() ) : the_post(); ?>

				<!-- POST : begin -->
				<article <?php post_class( 'post' ); ?>>
					<div class="c-content-box post__inner">

						<!-- POST HEADER : begin -->
						<header class="post__header">

							<!-- POST TITLE : begin -->
							<h2 class="post__title">
								<a href="<?php the_permalink(); ?>" class="post__title-link" rel="bookmark"><?php the_title(); ?></a>
							</h2>
							<!-- POST TITLE : end -->

						</header>
						<!-- POST HEADER : end -->

						<?php if ( ! empty( $post->post_excerpt ) ) : ?>

							<!-- POST CONTENT : begin -->
							<div class="post__content">
								<?php the_excerpt(); ?>
							</div>
							<!-- POST CONTENT : end -->

						<?php endif; ?>

						<?php // Post attachments
						if ( ! post_password_required( get_the_ID() ) ) {
							lsvr_townpress_the_document_attachments( get_the_ID() );
						} ?>

						<!-- POST FOOTER : begin -->
						<footer class="post__footer">

							<!-- POST META : begin -->
							<ul class="post__meta">

								<!-- POST DATE : begin -->
								<li class="post__meta-item post__meta-item--date">

									<time class="post__meta-date" datetime="<?php echo esc_attr( get_the_time( 'c' ) ); ?>">
										<?php echo esc_html( get_the_date() ); ?>
									</time>

									<?php if ( true === get_theme_mod( 'blog_single_author_enable', true ) ) : ?>
										<span class="post__meta-author"><?php echo sprintf( esc_html__( 'by %s', 'townpress' ), '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" class="post__meta-author-link" rel="author">' . get_the_author() . '</a>' ); ?></span>
									<?php endif; ?>

									<?php if ( lsvr_townpress_has_post_terms( get_the_ID(), 'lsvr_document_cat' ) ) : ?>
										<span class="post__meta-categories"><?php lsvr_townpress_the_post_terms( get_the_ID(), 'lsvr_document_cat', esc_html__( 'in %s', 'townpress' ) ); ?></span>
									<?php endif; ?>

								</li>
								<!-- POST DATE : end -->

							</ul>
							<!-- POST META : end -->

						</footer>
						<!-- POST FOOTER : end -->

					</div>
				</article>
				<!-- POST : end -->

			<?php endwhile; ?>

		</div>
		<!-- POST ARCHIVE LIST : end -->

		<?php // PAGINATION
		the_posts_pagination(); ?>

	<?php else : ?>

		<?php lsvr_townpress_the_alert_message( esc_html__( 'There are no documents', 'townpress' ) ); ?>

	<?php endif; ?>

</div>
<!-- DOCUMENT POST ARCHIVE : end -->