<?php get_header(); ?>

<?php // Main begin
get_template_part( 'template-parts/main-begin' ); ?>

<div <?php post_class( 'search-results-page' ); ?>>

	<!-- PAGE HEADER : begin -->
	<header class="main__header">

		<h1 class="main__title">
			<?php esc_html_e( 'Search Results', 'townpress' ); ?>
		</h1>

	</header>
	<!-- PAGE HEADER : end -->

	<!-- PAGE CONTENT : begin -->
	<div class="page__content">

		<?php // Search form
		get_search_form() ?>

		<?php // Results info
		global $wp_query;
		if ( isset( $wp_query->found_posts ) ) : ?>

			<?php lsvr_townpress_the_alert_message( sprintf( esc_html__( 'Showing %d results for "%s":', 'townpress' ), $wp_query->found_posts, get_search_query() ) ); ?>

		<?php endif; ?>

		<div class="c-content-box">

			<?php if ( have_posts() ) : ?>

				<ul class="search-results-page__list">

					<?php while ( have_posts() ) : the_post(); ?>

						<li class="search-results-page__item">

							<h3 class="search-results-page__item-title">
								<a href="<?php the_permalink(); ?>" class="search-results-page__item-title-link"><?php the_title(); ?></a>
							</h3>

							<?php $post_object = get_post_type_object( get_post_type() ); ?>
							<span class="search-results-page__item-type"><?php echo esc_html( $post_object->labels->singular_name ); ?></span>

						</li>

					<?php endwhile; ?>

				</ul>

				<?php // Pagination
				the_posts_pagination(); ?>

			<?php endif; ?>

		</div>

	</div>
	<!-- PAGE CONTENT : end -->

</div>

<?php // Main end
get_template_part( 'template-parts/main-end' ); ?>

<?php get_footer(); ?>