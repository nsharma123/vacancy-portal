<?php get_header(); ?>

<?php // Main begin
get_template_part( 'template-parts/main-begin' ); ?>

<!-- POST SINGLE : begin -->
<div class="lsvr_event-post-page post-single lsvr_event-post-single">

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

						<?php if ( has_post_thumbnail() && true === get_theme_mod( 'lsvr_event_single_featured_image_enable', true ) ) : ?>

							<!-- POST THUMBNAIL : begin -->
							<p class="post__thumbnail">
								<?php the_post_thumbnail( 'full' ); ?>
							</p>
							<!-- POST THUMBNAIL : end -->

						<?php endif; ?>

						<?php // Ended event
						if ( ! lsvr_townpress_has_next_event_occurrences( get_the_ID() ) ) : ?>

							<?php lsvr_townpress_the_alert_message( esc_html__( 'This event has ended', 'townpress' ) ); ?>

						<?php elseif ( lsvr_townpress_is_recurring_event( get_the_ID() ) && lsvr_townpress_has_next_event_occurrences( get_the_ID() ) ) : ?>

							<h5 class="post__next-date-title"><?php esc_html_e( 'Next Date', 'townpress' ); ?></h5>

						<?php endif; ?>

						<!-- POST INFO : begin -->
						<ul class="post__info<?php if ( lsvr_townpress_is_multiday_event( get_the_ID() ) ) { echo ' post__info--multiday'; } else { echo ' post__info--singleday'; } ?>">

							<?php // Multi-day event
							if ( lsvr_townpress_is_multiday_event( get_the_ID() ) ) : ?>

								<li class="post__info-item post__info-item--date">

									<h5 class="post__info-item-title"><?php esc_html_e( 'Start', 'townpress' ); ?></h5>
									<p class="post__info-item-text">
										<?php lsvr_townpress_the_event_start_date( get_the_ID() ); ?>
										<?php if ( ! lsvr_townpress_is_allday_event( get_the_ID() ) ) : ?>
											<br><?php lsvr_townpress_the_event_start_time( get_the_ID() ); ?>
										<?php else : ?>
											<br><?php esc_html_e( 'All-day Event', 'townpress' ); ?>
										<?php endif; ?>
									</p>

								</li>

								<li class="post__info-item post__info-item--date">

									<h5 class="post__info-item-title"><?php esc_html_e( 'End', 'townpress' ); ?></h5>
									<p class="post__info-item-text">
										<?php lsvr_townpress_the_event_end_date( get_the_ID() ); ?>
										<?php if ( ! lsvr_townpress_is_allday_event( get_the_ID() ) && lsvr_townpress_has_event_end_time( get_the_ID() ) ) : ?>
											<br><?php lsvr_townpress_the_event_end_time( get_the_ID() ); ?>
										<?php elseif ( lsvr_townpress_is_allday_event( get_the_ID() ) ) : ?>
											<br><?php esc_html_e( 'All-day Event', 'townpress' ); ?>
										<?php endif; ?>
									</p>

								</li>

							<?php // Single-day event
							else : ?>

								<li class="post__info-item post__info-item--date">

									<h5 class="post__info-item-title"><?php esc_html_e( 'Date', 'townpress' ); ?></h5>
									<p class="post__info-item-text">
										<?php lsvr_townpress_the_event_start_date( get_the_ID() ); ?>
									</p>

								</li>

								<li class="post__info-item post__info-item--time">

									<h5 class="post__info-item-title"><?php esc_html_e( 'Time', 'townpress' ); ?></h5>
									<p class="post__info-item-text">
										<?php lsvr_townpress_the_event_time( get_the_ID(), esc_html__( '%s - %s', 'townpress' ) ); ?>
									</p>

								</li>

							<?php endif; ?>

							<?php // Address
							if ( lsvr_townpress_has_event_location_address( get_the_ID() ) ) : ?>

								<!-- POST ADDRESS : begin -->
								<li class="post__info-item post__info-item--location">
									<h5 class="post__info-item-title"><?php lsvr_townpress_the_event_location_linked( get_the_ID(), esc_html__( '%s', 'townpress' ) ); ?></h5>
									<p class="post__info-item-text">
										<?php lsvr_townpress_the_event_location_address( get_the_ID(), false ); ?>
									</p>
								</li>
								<!-- POST ADDRESS : end -->

							<?php endif; ?>

						</ul>
						<!-- POST INFO : end -->

						<?php if ( ! empty( get_post()->post_content ) ) : ?>

							<!-- POST CONTENT : begin -->
							<div class="post__content">
								<?php the_content(); ?>
							</div>
							<!-- POST CONTENT : end -->

						<?php endif; ?>

						<?php // Map
						if ( true === get_theme_mod( 'lsvr_event_single_map_enable', true ) && lsvr_townpress_has_event_location_map( get_the_ID() ) ) : ?>

							<?php // Location map
							lsvr_townpress_the_event_location_map( get_the_ID() ); ?>

						<?php endif; ?>

						<?php if ( lsvr_townpress_is_recurring_event( get_the_ID() ) && lsvr_townpress_has_next_event_occurrences( get_the_ID() ) ) : ?>

							<?php // Recurring info
							if ( lsvr_townpress_is_recurring_event( get_the_ID() ) ) : ?>

								<?php lsvr_townpress_the_alert_message( esc_html__( 'This is a recurring event.', 'townpress' ) . ' ' . lsvr_townpress_get_event_recurrence_pattern_text( get_the_ID(), esc_html__( 'Repeating every %s.', 'townpress' ) ) ); ?>

							<?php endif; ?>

							<!-- UPCOMING DATES : begin -->
							<div class="post__dates">

								<h3 class="post__dates-title"><?php esc_html_e( 'Upcoming Dates', 'townpress' ); ?></h3>
								<?php lsvr_townpress_the_event_upcoming_occurrences( get_the_ID() );  ?>

							</div>
							<!-- UPCOMING DATES : end -->

						<?php endif; ?>

						<?php if ( ( lsvr_townpress_has_post_terms( get_the_ID(), 'lsvr_event_cat' ) ) ||
							lsvr_townpress_has_post_terms( get_the_ID(), 'lsvr_event_tag' ) ) : ?>

							<!-- POST FOOTER : begin -->
							<footer class="post__footer">

								<!-- POST META : begin -->
								<ul class="post__meta">

									<?php if ( ( lsvr_townpress_has_post_terms( get_the_ID(), 'lsvr_event_cat' ) ) ) : ?>

										<!-- POST CATEGORIES : begin -->
										<li class="post__meta-item post__meta-item--category">
											<h6 class="screen-reader-text"><?php esc_html_e( 'Categories:', 'townpress' ); ?></h6>
											<?php lsvr_townpress_the_post_terms( get_the_ID(), 'lsvr_event_cat' ); ?>
										</li>
										<!-- POST CATEGORIES : end -->

									<?php endif; ?>

									<?php if ( lsvr_townpress_has_post_terms( get_the_ID(), 'lsvr_event_tag' ) ) : ?>

										<!-- POST TAGS : begin -->
										<li class="post__meta-item post__meta-item--tags">
											<h6 class="screen-reader-text"><?php esc_html_e( 'Tags:', 'townpress' ); ?></h6>
											<?php lsvr_townpress_the_post_terms( get_the_ID(), 'lsvr_event_tag' ); ?>
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
				do_action( 'lsvr_townpress_event_single_bottom' ); ?>

			</div>
		</article>
		<!-- POST : end -->

	<?php endwhile; endif; ?>

</div>
<!-- POST SINGLE : end -->

<?php // Main end
get_template_part( 'template-parts/main-end' ); ?>

<?php get_footer(); ?>