<?php
/*
 * Events functionality supports recurring events created via custom DB table,
 * that's why we can't use standard WP loop, but will have to do it via custom function instead
 */
?>

<!-- POST ARCHIVE : begin -->
<div class="lsvr_event-post-page post-archive lsvr_event-post-archive lsvr_event-post-archive--default">

	<?php // Archive header
	get_template_part( 'template-parts/lsvr_event/archive-header' ); ?>

	<?php // Events categories
	if ( true === get_theme_mod( 'lsvr_event_archive_categories_enable', true ) ) {
		lsvr_townpress_the_event_archive_categories();
	} ?>

	<?php if ( lsvr_townpress_has_events() ) : ?>

		<!-- POST ARCHIVE GRID : begin -->
		<div class="post-archive__grid">

			<?php $i = 1; $event_occurrences = lsvr_townpress_get_event_archive(); foreach ( lsvr_townpress_get_event_archive() as $event_occurrence ) : ?>

				<?php lsvr_townpress_the_event_post_archive_grid_begin( $event_occurrence, $i ); ?>

				<div class="<?php lsvr_townpress_the_event_post_archive_grid_column_class(); ?>">

					<!-- POST : begin -->
					<article <?php lsvr_townpress_the_event_post_class( $event_occurrence['postid'] ); ?>>
						<div class="c-content-box post__inner">

							<?php // Post thumbnail
							lsvr_townpress_the_event_post_archive_thumbnail( $event_occurrence['postid'] ); ?>

							<!-- POST HEADER : begin -->
							<header class="post__header">

								<!-- POST TITLE : begin -->
								<h3 class="post__title">
									<a href="<?php echo get_permalink( $event_occurrence['postid'] ); ?>" class="post__title-link" rel="bookmark"><?php echo esc_html( get_the_title( $event_occurrence['postid'] ) ); ?></a>
								</h3>
								<!-- POST TITLE : end -->

							</header>
							<!-- POST HEADER : end -->

							<!-- POST INFO : begin -->
							<ul class="post__info">

								<!-- POST DATE : begin -->
								<li class="post__info-item post__info-item--date">
									<time datetime="<?php echo esc_attr( date_i18n( 'c', strtotime( $event_occurrence['start'] ) ) ); ?>">
										<?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $event_occurrence['start'] ) ) ); ?>
									</time>
								</li>
								<!-- POST DATE : end -->

								<!-- POST TIME : begin -->
								<li class="post__info-item post__info-item--time">
									<?php lsvr_townpress_the_event_archive_time( $event_occurrence, esc_html__( '%s - %s', 'townpress' ) ); ?>
								</li>
								<!-- POST TIME : end -->

								<?php if ( lsvr_townpress_has_event_location( $event_occurrence['postid'] ) ) : ?>

									<!-- POST LOCATION : begin -->
									<li class="post__info-item post__info-item--location">
										<?php lsvr_townpress_the_event_location_linked( $event_occurrence['postid'], esc_html__( '%s', 'townpress' ) ); ?>
									</li>
									<!-- POST LOCATION : end -->

								<?php endif; ?>

							</ul>
							<!-- POST INFO : end -->

						</div>
					</article>
					<!-- POST : end -->

				</div>

				<?php lsvr_townpress_the_event_post_archive_grid_end( $i, count( $event_occurrences ) ); ?>

			<?php $i++; endforeach; ?>

		</div>
		<!-- POST ARCHIVE GRID : end -->

		<?php // Pagination
		lsvr_townpress_the_event_archive_pagination(); ?>

	<?php else : ?>

		<?php lsvr_townpress_the_alert_message( esc_html__( 'No events matched your criteria', 'townpress' ) ); ?>

	<?php endif; ?>

</div>
<!-- POST ARCHIVE : end -->