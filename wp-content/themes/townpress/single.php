<?php get_header(); ?>

<?php // Main begin
get_template_part( 'template-parts/main-begin' ); ?>

<!-- POST SINGLE : begin -->
<div class="post-single blog-post-single">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<!-- POST : begin -->
		<article <?php post_class(); ?>>
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

						<?php if ( has_post_thumbnail() ) : ?>

							<!-- POST THUMBNAIL : begin -->
							<p class="post__thumbnail">
								<?php the_post_thumbnail( 'full' ); ?>
							</p>
							<!-- POST THUMBNAIL : end -->

						<?php endif; ?>

						<!-- POST CONTENT : begin -->
						<div class="post__content">
							<?php the_content(); ?>
							<?php wp_link_pages(); ?>
						</div>
						<!-- POST CONTENT : end -->

						<!-- POST FOOTER : begin -->
						<footer class="post__footer">

							<!-- POST META : begin -->
							<ul class="post__meta">

								<!-- POST DATE : begin -->
								<li class="post__meta-item post__meta-item--date">

									<time class="post__meta-date" datetime="<?php echo esc_attr( get_the_time( 'c' ) ); ?>">
										<?php the_date(); ?>
									</time>

									<?php if ( true === get_theme_mod( 'blog_single_author_enable', true ) ) : ?>
										<span class="post__meta-author"><?php echo sprintf( esc_html__( 'by %s', 'townpress' ), '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" class="post__meta-author-link" rel="author">' . get_the_author() . '</a>' ); ?></span>
									<?php endif; ?>

									<?php if ( lsvr_townpress_has_post_terms( get_the_ID(), 'category' ) ) : ?>
										<span class="post__meta-categories"><?php lsvr_townpress_the_post_terms( get_the_ID(), 'category', esc_html__( 'in %s', 'townpress' ) ); ?></span>
									<?php endif; ?>

								</li>
								<!-- POST DATE : end -->

								<?php if ( lsvr_townpress_has_post_terms( get_the_ID(), 'post_tag' ) ) : ?>

									<!-- POST TAGS : begin -->
									<?php // We are using wp_get_post_terms() function instead of simple the_tags() for consistency with other post types ?>
									<li class="post__meta-item post__meta-item--tags">
										<h6 class="screen-reader-text"><?php esc_html_e( 'Tags:', 'townpress' ); ?></h6>
										<?php lsvr_townpress_the_post_terms( get_the_ID(), 'post_tag' ); ?>
									</li>
									<!-- POST TAGS : end -->

								<?php endif; ?>

							</ul>
							<!-- POST META : end -->

						</footer>
						<!-- POST FOOTER : end -->

					</div>
				</div>
				<!-- POST WRAPPER : begin -->

				<?php // Add custom code at post bottom
				do_action( 'lsvr_townpress_blog_single_bottom' ); ?>

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