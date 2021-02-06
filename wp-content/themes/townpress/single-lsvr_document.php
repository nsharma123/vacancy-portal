<?php get_header(); ?>

<?php // Main begin
get_template_part( 'template-parts/main-begin' ); ?>

<!-- DOCUMENT POST SINGLE : begin -->
<div class="lsvr_document-post-page post-single lsvr_document-post-single">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<!-- POST : begin -->
		<article <?php post_class( 'post' ); ?>>
			<div class="post__inner">

				<!-- POST HEADER : begin -->
				<header class="main__header">

					<h1 class="main__title"><?php the_title(); ?></h1>

					<?php // Breadcrumbs
					get_template_part( 'template-parts/breadcrumbs' ); ?>

				</header>
				<!-- POST HEADER : end -->

				<!-- POST WRAPPER : begin -->
				<div class="post__wrapper">
					<div class="c-content-box">

						<?php if ( ! empty( get_post()->post_content ) ) : ?>

							<!-- POST TEXT : begin -->
							<div class="post__content">
								<?php the_content(); ?>
							</div>
							<!-- POST TEXT : end -->

						<?php endif; ?>

						<?php // Get post attachments
						if ( lsvr_townpress_has_document_attachments( get_the_ID() ) && ! post_password_required( get_the_ID() ) ) : ?>

							<!-- POST ATTACHMENTS : begin -->
							<div class="post__attachments">
								<h4 class="post__attachments-title"><?php esc_html_e( 'Attachments', 'townpress' ); ?></h4>
								<?php lsvr_townpress_the_document_attachments( get_the_ID() ); ?>
							</div>
							<!-- POST ATTACHMENTS : end -->

						<?php endif;  ?>

						<!-- POST FOOTER : begin -->
						<footer class="post__footer">

							<!-- POST META : begin -->
							<ul class="post__meta">

								<?php if ( true === get_theme_mod( 'lsvr_document_single_date_enable', true ) || true === get_theme_mod( 'lsvr_document_single_author_enable', true ) ) : ?>

									<!-- POST DATE : begin -->
									<li class="post__meta-item post__meta-item--date">

										<?php if ( true === get_theme_mod( 'lsvr_document_single_date_enable', true ) ) : ?>
											<time class="post__meta-date" datetime="<?php echo esc_attr( get_the_time( 'c' ) ); ?>">
												<?php the_date(); ?>
											</time>
										<?php endif; ?>

										<?php if ( true === get_theme_mod( 'lsvr_document_single_author_enable', true ) ) : ?>
											<span class="post__meta-author"><?php echo sprintf( esc_html__( 'by %s', 'townpress' ), '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" class="post__meta-author-link" rel="author">' . get_the_author() . '</a>' ); ?></span>
										<?php endif; ?>

									</li>
									<!-- POST DATE : end -->

								<?php endif; ?>

								<?php if ( lsvr_townpress_has_post_terms( get_the_ID(), 'lsvr_document_cat' ) ) : ?>

									<!-- POST CATEGORY : begin -->
									<li class="post__meta-item post__meta-item--category">
										<h6 class="screen-reader-text"><?php esc_html_e( 'Categories:', 'townpress' ); ?></h6>
										<?php lsvr_townpress_the_post_terms( get_the_ID(), 'lsvr_document_cat' ); ?>
									</li>
									<!-- POST CATEGORY : end -->

								<?php endif; ?>

								<?php if ( lsvr_townpress_has_post_terms( get_the_ID(), 'lsvr_document_tag' ) ) : ?>

									<!-- POST TAGS : begin -->
									<li class="post__meta-item post__meta-item--tags">
										<h6 class="screen-reader-text"><?php esc_html_e( 'Tags:', 'townpress' ); ?></h6>
										<?php lsvr_townpress_the_post_terms( get_the_ID(), 'lsvr_document_tag' ); ?>
									</li>
									<!-- POST TAGS : end -->

								<?php endif; ?>

							</ul>
							<!-- POST META : end -->

						</footer>
						<!-- POST FOOTER : end -->

					</div>
				</div>
				<!-- POST WRAPPER : end -->

				<?php // Add custom code at post bottom
				do_action( 'lsvr_townpress_document_single_bottom' ); ?>

			</div>
		</article>
		<!-- POST : end -->

	<?php endwhile; endif; ?>

</div>
<!-- DOCUMENT POST SINGLE : end -->

<?php // Main end
get_template_part( 'template-parts/main-end' ); ?>

<?php get_footer(); ?>