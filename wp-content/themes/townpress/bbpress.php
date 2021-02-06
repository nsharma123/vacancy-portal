<?php get_header(); ?>

<?php // Main begin
get_template_part( 'template-parts/main-begin' ); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<div <?php post_class(); ?>>

		<!-- PAGE HEADER : begin -->
		<header class="main__header">

			<h1 class="main__title">
				<?php if ( is_post_type_archive( 'forum' ) ) : ?>
					<?php echo esc_html( lsvr_townpress_get_bbpress_archive_title() ); ?>
				<?php else : ?>
					<?php the_title(); ?>
				<?php endif; ?>
			</h1>

			<?php // Breadcrumbs
			get_template_part( 'template-parts/breadcrumbs' ); ?>

		</header>
		<!-- PAGE HEADER : end -->

		<!-- PAGE CONTENT : begin -->
		<div class="page__content bbpress-page">

			<?php the_content(); ?>

		</div>
		<!-- PAGE CONTENT : end -->

	</div>

<?php endwhile; endif; ?>

<?php // Main end
get_template_part( 'template-parts/main-end' ); ?>

<?php get_footer(); ?>