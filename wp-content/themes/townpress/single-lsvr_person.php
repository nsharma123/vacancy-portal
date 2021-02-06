<?php get_header(); ?>

<?php // Main begin
get_template_part( 'template-parts/main-begin' ); ?>

<!-- POST SINGLE : begin -->
<div class="lsvr_person-post-page post-single lsvr_person-post-single">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<!-- POST : begin -->
		<article <?php post_class( 'post' ); ?>>
			<div class="post__inner">

				<!-- POST HEADER : begin -->
				<header class="main__header<?php if ( has_post_thumbnail() ) { echo ' post__header--has-thumb'; } ?>">

					<h1 class="main__title"><?php the_title(); ?></h1>

					<?php if ( lsvr_townpress_has_person_role( get_the_ID() ) ) : ?>
						<h4 class="main__subtitle"><?php lsvr_townpress_the_person_role( get_the_ID() ); ?></h4>
					<?php endif; ?>

					<?php // Breadcrumbs
					get_template_part( 'template-parts/breadcrumbs' ); ?>

				</header>
				<!-- POST HEADER : end -->

				<?php if ( has_post_thumbnail() || lsvr_townpress_has_person_contact_info( get_the_ID() ) || lsvr_townpress_has_person_social_links( get_the_ID() ) ) : ?>

					<!-- POST CARD : begin -->
					<div class="post__card">
						<div class="post__card-inner c-content-box">

							<?php if ( has_post_thumbnail() ) : ?>

								<!-- POST THUMBNAIL : begin -->
								<p class="post__thumbnail">
									<?php the_post_thumbnail( 'thumbnail' ); ?>
								</p>
								<!-- POST THUMBNAIL : end -->

							<?php endif; ?>

							<?php if ( lsvr_townpress_has_person_contact_info( get_the_ID() ) || lsvr_townpress_has_person_social_links( get_the_ID() ) ) : ?>

								<div class="post__card-info">

									<?php // Contact info
									lsvr_townpress_the_person_contact_info( get_the_ID() ); ?>

									<?php // Social links
									lsvr_townpress_the_person_social_links( get_the_ID() ); ?>

								</div>

							<?php endif; ?>

						</div>
					</div>
					<!-- POST CARD : begin -->

				<?php endif; ?>

				<?php if ( ! empty( get_post()->post_content ) ) : ?>

					<div class="c-content-box">

						<!-- POST CONTENT : begin -->
						<div class="post__content">

							<div class="post__text">
								<?php the_content(); ?>
							</div>

						</div>
						<!-- POST CONTENT : begin -->

					</div>

				<?php endif; ?>

				<?php // Add custom code at post bottom
				do_action( 'lsvr_townpress_person_single_bottom' ); ?>

			</div>
		</article>
		<!-- POST : end -->

	<?php endwhile; endif; ?>

</div>
<!-- POST SINGLE : end -->

<?php // Main end
get_template_part( 'template-parts/main-end' ); ?>

<?php get_footer(); ?>