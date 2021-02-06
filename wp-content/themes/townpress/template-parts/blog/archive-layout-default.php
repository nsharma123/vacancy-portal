<!-- POST ARCHIVE : begin -->
<div class="post-archive blog-post-archive blog-post-archive--default">

	<?php // Main header
	get_template_part( 'template-parts/blog/archive-header' ); ?>

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<!-- POST : begin -->
			<article <?php post_class(); ?>>
				<div class="post__inner c-content-box">

					<!-- POST HEADER : begin -->
					<header class="post__header">

						<?php // Post thumbnail
						lsvr_townpress_the_blog_post_thumbnail( get_the_ID() ); ?>

						<!-- POST TITLE : begin -->
						<h2 class="post__title">
							<a href="<?php the_permalink(); ?>" class="post__title-link" rel="bookmark"><?php the_title(); ?></a>
						</h2>
						<!-- POST TITLE : end -->

					</header>
					<!-- POST HEADER : end -->

					<!-- POST CONTENT : begin -->
					<div class="post__content">
						<?php if ( ! empty( $post->post_excerpt ) ) : ?>

							<?php the_excerpt(); ?>

							<!-- POST PERMALINK : begin -->
							<p class="post__permalink">
								<a href="<?php the_permalink(); ?>" class="post__permalink-link" rel="bookmark">
									<?php esc_html_e( 'Read More', 'townpress' ); ?>
								</a>
							</p>
							<!-- POST PERMALINK : end -->

						<?php elseif ( $post->post_content ) : ?>

							<?php the_content(); ?>

						<?php endif; ?>
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

								<?php if ( lsvr_townpress_has_post_terms( get_the_ID(), 'category' ) ) : ?>
									<span class="post__meta-categories"><?php lsvr_townpress_the_post_terms( get_the_ID(), 'category', esc_html__( 'in %s', 'townpress' ) ); ?></span>
								<?php endif; ?>

							</li>
							<!-- POST DATE : end -->

							<?php if ( lsvr_townpress_has_post_comments( get_the_ID() ) ) : ?>

								<!-- POST COMMENTS COUNT : begin -->
								<li class="post__meta-item post__meta-item--comments">
									<a href="<?php the_permalink(); ?>#comments"><?php echo sprintf( esc_html( _n( '%s Comment', '%s Comments', lsvr_townpress_get_post_comments_count(), 'townpress' ) ), lsvr_townpress_get_post_comments_count() ); ?></a>
								</li>
								<!-- POST COMMENTS COUNT : end -->

							<?php endif; ?>

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

	<?php endif; ?>

</div>
<!-- POST ARCHIVE : end -->