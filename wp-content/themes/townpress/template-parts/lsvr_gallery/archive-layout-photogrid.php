<!-- POST ARCHIVE : begin -->
<div class="lsvr_gallery-post-page post-archive lsvr_gallery-post-archive lsvr_gallery-post-archive--photogrid">

	<?php // Archive header
	get_template_part( 'template-parts/lsvr_gallery/archive-header' ); ?>

	<?php // Gallery categories
	if ( true === get_theme_mod( 'lsvr_gallery_archive_categories_enable', true ) ) {
		lsvr_townpress_the_post_archive_categories( 'lsvr_gallery', 'lsvr_gallery_cat' );
	} ?>

	<?php if ( have_posts() ) : ?>

		<!-- POST ARCHIVE GRID : begin -->
		<div class="post-archive__grid">
			<div class="<?php lsvr_townpress_the_gallery_post_archive_grid_class(); ?>">

				<?php while ( have_posts() ) : the_post(); ?>

					<div class="<?php lsvr_townpress_the_gallery_post_archive_grid_column_class(); ?>">

						<!-- POST : begin -->
						<article <?php post_class( 'post' ); ?>
							<?php lsvr_townpress_the_gallery_post_background_thumbnail( get_the_ID() ); ?>>
							<div class="post__inner">
								<div class="post__bg">

									<!-- POST HEADER : begin -->
									<header class="post__header">

										<!-- POST TITLE : begin -->
										<h2 class="post__title">
											<a href="<?php the_permalink(); ?>" class="post__title-link" rel="bookmark"><?php the_title(); ?></a>
										</h2>
										<!-- POST TITLE : end -->

									</header>
									<!-- POST HEADER : end -->

									<?php if ( true === get_theme_mod( 'lsvr_gallery_archive_date_enable', true ) ||
										lsvr_townpress_has_post_terms( get_the_ID(), 'lsvr_gallery_cat' ) ||
										true === get_theme_mod( 'lsvr_gallery_archive_image_count_enable', true ) ) : ?>

										<!-- POST INFO : begin -->
										<ul class="post__info">

											<?php if ( true === get_theme_mod( 'lsvr_gallery_archive_date_enable', true ) ) : ?>

												<!-- POST DATE : begin -->
												<li class="post__info-item post__info-item--date">
													<time class="post__meta-date" datetime="<?php echo esc_attr( get_the_time( 'c' ) ); ?>">
														<?php echo esc_html( get_the_date() ); ?>
													</time>
												</li>
												<!-- POST DATE : end -->

											<?php endif; ?>

											<?php if ( lsvr_townpress_has_post_terms( get_the_ID(), 'lsvr_gallery_cat' ) ) : ?>

												<!-- POST CATEGORY : begin -->
												<li class="post__info-item post__info-item--category">
													<?php lsvr_townpress_the_post_terms( get_the_ID(), 'lsvr_gallery_cat' ); ?>
												</li>
												<!-- POST CATEGORY : end -->

											<?php endif; ?>

											<?php if ( true === get_theme_mod( 'lsvr_gallery_archive_image_count_enable', true ) ) : ?>

												<!-- POST IMAGES COUNT : begin -->
												<li class="post__info-item post__info-item--images">
													<?php echo esc_html( sprintf( _n( '%d image', '%d images', lsvr_townpress_get_gallery_images_count( get_the_ID() ), 'townpress' ), lsvr_townpress_get_gallery_images_count( get_the_ID() ) ) ); ?>
												</li>
												<!-- POST IMAGES COUNT : end -->

											<?php endif; ?>

										</ul>
										<!-- POST INFO : end -->

									<?php endif; ?>

									<!-- OVERLAY LINK : begin -->
									<a href="<?php the_permalink(); ?>"
										class="post__overlay-link">
										<span class="screen-reader-text"><?php esc_html_e( 'Open Gallery', 'townpress' ); ?></span>
									</a>
									<!-- OVERLAY LINK : end -->

								</div>
							</div>
						</article>
						<!-- POST : end -->

					</div>

				<?php endwhile; ?>

			</div>
		</div>
		<!-- POST ARCHIVE GRID : end -->

		<?php // PAGINATION
		the_posts_pagination(); ?>

	<?php else : ?>

		<?php lsvr_townpress_the_alert_message( esc_html__( 'No galleries matched your criteria', 'townpress' ) ); ?>

	<?php endif; ?>

</div>
<!-- POST ARCHIVE : end -->