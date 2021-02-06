<!-- POST ARCHIVE : begin -->
<div class="lsvr_person-post-page post-archive lsvr_person-post-archive lsvr_person-post-archive--default">

	<?php // Archive header
	get_template_part( 'template-parts/lsvr_person/archive-header' ); ?>

	<?php // Person categories
	if ( true === get_theme_mod( 'lsvr_person_archive_categories_enable', true ) ) {
		lsvr_townpress_the_post_archive_categories( 'lsvr_person', 'lsvr_person_cat' );
	} ?>

	<?php if ( have_posts() ) : ?>

		<!-- POST ARCHIVE GRID : begin -->
		<div class="post-archive__grid">
			<div class="<?php lsvr_townpress_the_person_post_archive_grid_class(); ?>">

				<?php while ( have_posts() ) : the_post(); ?>

					<div class="<?php lsvr_townpress_the_person_post_archive_grid_column_class(); ?>">

						<!-- POST : begin -->
						<article <?php post_class( 'post' ); ?>>
							<div class="c-content-box">
								<div class="post__inner">

									<?php if ( has_post_thumbnail() ) : ?>

										<!-- POST THUMBNAIL : begin -->
										<p class="post__thumbnail">
											<a href="<?php the_permalink(); ?>" class="post__thumbnail-link"><?php the_post_thumbnail( 'thumbnail' ); ?></a>
										</p>
										<!-- POST THUMBNAIL : end -->

									<?php endif; ?>

									<!-- POST TITLE : begin -->
									<h2 class="post__title">
										<a href="<?php the_permalink(); ?>" class="post__title-link" rel="bookmark"><?php the_title(); ?></a>
									</h2>
									<!-- POST TITLE : end -->

									<?php if ( lsvr_townpress_has_person_role( get_the_ID() ) ) : ?>
										<h6 class="post__subtitle"><?php lsvr_townpress_the_person_role( get_the_ID() ); ?></h6>
									<?php endif; ?>

									<?php // Contact info
									lsvr_townpress_the_person_contact_info( get_the_ID() ); ?>

									<?php // Social links
									lsvr_townpress_the_person_social_links( get_the_ID() ); ?>

								</div>
							</div>
						</article>
						<!-- POST : end -->

					</div>

				<?php endwhile; ?>

			</div>
		</div>
		<!-- POST ARCHIVE GRID : end -->

	<?php else : ?>

		<?php lsvr_townpress_the_alert_message( esc_html__( 'There are no person posts', 'townpress' ) ); ?>

	<?php endif; ?>

</div>
<!-- POST ARCHIVE : end -->