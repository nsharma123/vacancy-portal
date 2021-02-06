<?php get_header(); ?>

<?php // Main begin
get_template_part( 'template-parts/main-begin' ); ?>

<!-- POST SINGLE : begin -->
<div class="lsvr_gallery-post-page post-single lsvr_gallery-post-single">

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

				<?php // Gallery images
				lsvr_townpress_the_gallery_images( get_the_ID() ); ?>

				<?php if ( ! empty( get_post()->post_content ) || true === get_theme_mod( 'lsvr_gallery_single_date_enable', true ) || lsvr_townpress_has_post_terms( get_the_ID(), 'lsvr_gallery_cat' ) || lsvr_townpress_has_post_terms( get_the_ID(), 'lsvr_gallery_tag' ) ) : ?>

					<!-- POST WRAPPER : begin -->
					<div class="post__wrapper">
						<div class="c-content-box">

							<?php if ( ! empty( get_post()->post_content ) ) : ?>

								<!-- POST CONTENT : begin -->
								<div class="post__content">
									<?php the_content(); ?>
								</div>
								<!-- POST CONTENT : end -->

							<?php endif; ?>

							<?php if ( true === get_theme_mod( 'lsvr_gallery_single_date_enable', true ) || lsvr_townpress_has_post_terms( get_the_ID(), 'lsvr_gallery_cat' ) || lsvr_townpress_has_post_terms( get_the_ID(), 'lsvr_gallery_tag' ) ) : ?>

								<!-- POST FOOTER : begin -->
								<footer class="post__footer">

									<!-- POST META : begin -->
									<ul class="post__meta">

										<?php if ( true === get_theme_mod( 'lsvr_gallery_single_date_enable', true ) ) : ?>

											<!-- POST DATE : begin -->
											<li class="post__meta-item post__meta-item--date">
												<time class="post__meta-date" datetime="<?php echo esc_attr( get_the_time( 'c' ) ); ?>">
													<?php the_date(); ?>
												</time>
											</li>
											<!-- POST DATE : end -->

										<?php endif; ?>

										<?php if ( lsvr_townpress_has_post_terms( get_the_ID(), 'lsvr_gallery_cat' ) ) : ?>

											<!-- POST CATEGORY : begin -->
											<li class="post__meta-item post__meta-item--category">
												<h6 class="screen-reader-text"><?php esc_html_e( 'Categories:', 'townpress' ); ?></h6>
												<?php lsvr_townpress_the_post_terms( get_the_ID(), 'lsvr_gallery_cat' ); ?>
											</li>
											<!-- POST CATEGORY : end -->

										<?php endif; ?>

										<?php if ( lsvr_townpress_has_post_terms( get_the_ID(), 'lsvr_gallery_tag' ) ) : ?>

											<!-- POST TAGS : begin -->
											<li class="post__meta-item post__meta-item--tags">
												<h6 class="screen-reader-text"><?php esc_html_e( 'Tags:', 'townpress' ); ?></h6>
												<?php lsvr_townpress_the_post_terms( get_the_ID(), 'lsvr_gallery_tag' ); ?>
											</li>
											<!-- POST TAGS : end -->

										<?php endif; ?>

									</ul>
									<!-- POST META : end -->

								</footer>
								<!-- POST FOOTER : end -->

							<?php endif; ?>

						</div>
					</div>
					<!-- POST WRAPPER : end -->

				<?php endif; ?>

				<?php // Add custom code at post bottom
				do_action( 'lsvr_townpress_gallery_single_bottom' ); ?>

			</div>
		</article>
		<!-- POST : end -->

		<?php // Post navigation
		get_template_part( 'template-parts/single-navigation' ); ?>

	    <?php // Post comments
	    comments_template(); ?>

	<?php endwhile; endif; ?>

</div>
<!-- POST SINGLE : end -->

<?php // Main end
get_template_part( 'template-parts/main-end' ); ?>

<?php get_footer(); ?>