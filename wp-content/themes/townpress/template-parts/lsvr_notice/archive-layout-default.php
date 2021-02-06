<!-- POST ARCHIVE : begin -->
<div class="lsvr_notice-post-page post-archive lsvr_notice-post-archive lsvr_notice-post-archive--default">

	<?php // Main header
	get_template_part( 'template-parts/lsvr_notice/archive-header' ); ?>

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<!-- POST : begin -->
			<article <?php post_class(); ?>>
				<div class="post__inner c-content-box">

					<!-- POST HEADER : begin -->
					<header class="post__header">

						<!-- POST TITLE : begin -->
						<h2 class="post__title">
							<a href="<?php the_permalink(); ?>" class="post__title-link" rel="bookmark"><?php the_title(); ?></a>
						</h2>
						<!-- POST TITLE : end -->

					</header>
					<!-- POST HEADER : end -->

					<!-- POST CONTENT : begin -->
					<div class="post__content">
						<?php the_content(); ?>
					</div>
					<!-- POST CONTENT : end -->

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

								<?php if ( lsvr_townpress_has_post_terms( get_the_ID(), 'lsvr_notice_cat' ) ) : ?>
									<span class="post__meta-categories"><?php lsvr_townpress_the_post_terms( get_the_ID(), 'lsvr_notice_cat', esc_html__( 'in %s', 'townpress' ) ); ?></span>
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

		<?php // Pagination
		the_posts_pagination(); ?>

	<?php else : ?>

		<?php lsvr_townpress_the_alert_message( esc_html__( 'No notices matched your criteria', 'townpress' ) ); ?>

	<?php endif; ?>

</div>
<!-- POST ARCHIVE : end -->