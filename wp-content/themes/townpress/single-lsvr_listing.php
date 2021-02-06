<?php get_header(); ?>

<?php // Main begin
get_template_part( 'template-parts/main-begin' ); ?>

<!-- POST SINGLE : begin -->
<div class="lsvr_listing-post-page post-single lsvr_listing-post-single">

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

						<?php if ( true === lsvr_townpress_has_listing_single_featured_image( get_the_ID() ) ) : ?>

							<!-- POST THUMBNAIL : begin -->
							<p class="post__thumbnail">
								<?php the_post_thumbnail( 'full' ); ?>
							</p>
							<!-- POST THUMBNAIL : end -->

						<?php endif; ?>

						<?php if ( ! empty( get_post()->post_content ) ) : ?>

							<!-- POST CONTENT : begin -->
							<div class="post__content">
								<?php the_content(); ?>
							</div>
							<!-- POST CONTENT : end -->

						<?php endif; ?>

						<?php // Contact
						if ( lsvr_townpress_has_listing_contact_info( get_the_ID() ) ||
							lsvr_townpress_has_listing_social_links( get_the_ID() ) ) : ?>

							<!-- POST CONTACT : begin -->
							<div class="post__contact">

								<h3 class="post__contact-title"><?php esc_html_e( 'Contact', 'townpress' ); ?></h3>

								<?php // Contact info
								lsvr_townpress_the_listing_contact_info( get_the_ID() ); ?>

								<?php // Social links
								lsvr_townpress_the_listing_social_links( get_the_ID() ); ?>

							</div>
							<!-- POST CONTACT : end -->

						<?php endif; ?>

						<?php // Map
						if ( true === get_theme_mod( 'lsvr_listing_single_map_enable', true ) && lsvr_townpress_has_listing_map_location( get_the_ID() ) ) : ?>

							<?php // Location map
							lsvr_townpress_the_listing_map( get_the_ID() ); ?>

						<?php endif; ?>

						<?php // Opening hours
						if ( lsvr_townpress_has_listing_opening_hours( get_the_ID() ) ) :?>

							<!-- OPENING HOURS : begin -->
							<div class="post__hours">

								<h3 class="post__hours-title"><?php esc_html_e( 'Opening hours', 'townpress' ); ?></h3>
								<?php lsvr_townpress_the_listing_opening_hours( get_the_ID() ); ?>

							</div>
							<!-- OPENING HOURS : end -->

						<?php endif; ?>

						<?php // Gallery
						if ( lsvr_townpress_has_listing_gallery( get_the_ID() ) ) : ?>

							<!-- POST GALLERY : begin -->
							<div class="post__gallery">

								<h3 class="post__gallery-title"><?php esc_html_e( 'Gallery', 'townpress' ); ?></h3>
								<?php lsvr_townpress_the_listing_gallery( get_the_ID() ); ?>

							</div>
							<!-- POST GALLERY : end -->

						<?php endif; ?>

						<?php if ( ( lsvr_townpress_has_post_terms( get_the_ID(), 'lsvr_listing_cat' ) ) ||
							lsvr_townpress_has_post_terms( get_the_ID(), 'lsvr_listing_tag' ) ) : ?>

							<!-- POST FOOTER : begin -->
							<footer class="post__footer">

								<!-- POST META : begin -->
								<ul class="post__meta">

									<?php if ( ( lsvr_townpress_has_post_terms( get_the_ID(), 'lsvr_listing_cat' ) ) ) : ?>

										<!-- POST CATEGORIES : begin -->
										<li class="post__meta-item post__meta-item--category">
											<h6 class="screen-reader-text"><?php esc_html_e( 'Categories:', 'townpress' ); ?></h6>
											<?php lsvr_townpress_the_post_terms( get_the_ID(), 'lsvr_listing_cat' ); ?>
										</li>
										<!-- POST CATEGORIES : end -->

									<?php endif; ?>

									<?php if ( lsvr_townpress_has_post_terms( get_the_ID(), 'lsvr_listing_tag' ) ) : ?>

										<!-- POST TAGS : begin -->
										<li class="post__meta-item post__meta-item--tags">
											<h6 class="screen-reader-text"><?php esc_html_e( 'Tags:', 'townpress' ); ?></h6>
											<?php lsvr_townpress_the_post_terms( get_the_ID(), 'lsvr_listing_tag' ); ?>
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

				<?php // Add custom code at post bottom
				do_action( 'lsvr_townpress_listing_single_bottom' ); ?>

			</div>
		</article>
		<!-- POST : end -->

	<?php endwhile; endif; ?>

</div>
<!-- POST SINGLE : end -->

<?php // Main end
get_template_part( 'template-parts/main-end' ); ?>

<?php get_footer(); ?>