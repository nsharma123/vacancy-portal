<!-- POST ARCHIVE : begin -->
<div class="lsvr_listing-post-page post-archive lsvr_listing-post-archive lsvr_listing-post-archive--default">

	<?php // Archive header
	get_template_part( 'template-parts/lsvr_listing/archive-header' ); ?>

	<?php // Directory categories
	if ( true === get_theme_mod( 'lsvr_listing_archive_categories_enable', true ) ) {
		lsvr_townpress_the_post_archive_categories( 'lsvr_listing', 'lsvr_listing_cat' );
	} ?>

	<?php // Directory map
	if ( have_posts() ) {
		lsvr_townpress_the_listing_archive_map();
	} ?>

	<?php if ( have_posts() ) : ?>

		<!-- POST ARCHIVE GRID : begin -->
		<div class="post-archive__grid">
			<div class="<?php lsvr_townpress_the_listing_archive_grid_class(); ?>">

				<?php while ( have_posts() ) : the_post(); ?>

					<div class="<?php lsvr_townpress_the_listing_archive_grid_column_class(); ?>">

						<!-- POST : begin -->
						<article <?php post_class( 'post' ); ?>>
							<div class="c-content-box post__inner">

								<?php if ( has_post_thumbnail( get_the_ID() ) ) : ?>

									<?php // Post thumbnail
									lsvr_townpress_the_listing_archive_thumbnail( get_the_ID() ); ?>

								<?php endif; ?>

								<!-- POST HEADER : begin -->
								<header class="post__header">

									<!-- POST TITLE : begin -->
									<h2 class="post__title">
										<a href="<?php the_permalink(); ?>" class="post__title-link" rel="bookmark"><?php the_title(); ?></a>
									</h2>
									<!-- POST TITLE : end -->

								</header>
								<!-- POST HEADER : end -->

								<?php if ( lsvr_townpress_has_post_terms( get_the_ID(), 'lsvr_listing_cat' ) ||
									lsvr_townpress_has_listing_address( get_the_ID() ) ) : ?>

									<!-- POST INFO : begin -->
									<ul class="post__info">

										<?php if ( lsvr_townpress_has_listing_address( get_the_ID() ) ) : ?>

											<!-- POST ADDRESS : begin -->
											<li class="post__info-item post__info-item--location">
												<?php lsvr_townpress_the_listing_address( get_the_ID() ); ?>
											</li>
											<!-- POST ADDRESS : end -->

										<?php endif; ?>

										<?php if ( lsvr_townpress_has_post_terms( get_the_ID(), 'lsvr_listing_cat' ) ) : ?>

											<!-- POST META : begin -->
											<li class="post__info-item post__info-item--category">
												<?php lsvr_townpress_the_post_terms( get_the_ID(), 'lsvr_listing_cat', esc_html__( '%s', 'townpress' ) ); ?>
											</li>
											<!-- POST META : end -->

										<?php endif; ?>

									</ul>
									<!-- POST INFO : end -->

								<?php endif; ?>

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

		<?php lsvr_townpress_the_alert_message( esc_html__( 'No listings matched your criteria', 'townpress' ) ); ?>

	<?php endif; ?>

</div>
<!-- POST ARCHIVE : end -->