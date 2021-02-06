<?php /* Template Name: Not Boxed */
esc_html__( 'Not Boxed', 'townpress' ); ?>

<?php get_header(); ?>

<?php // Main begin
get_template_part( 'template-parts/main-begin' ); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<div <?php post_class(); ?>>

		<!-- PAGE HEADER : begin -->
		<header class="main__header">

			<h1 class="main__title"><?php the_title(); ?></h1>

			<?php // Breadcrumbs
			get_template_part( 'template-parts/breadcrumbs' ); ?>

		</header>
		<!-- PAGE HEADER : end -->

		<!-- PAGE CONTENT : begin -->
		<div class="page__content">

			<?php the_content(); ?>
			<?php wp_link_pages(); ?>

		    <?php // Post comments
		    if ( comments_open() ) : ?>
		    	<div class="c-content-box">
		    		<?php comments_template(); ?>
		    	</div>
		    <?php endif; ?>

		</div>
		<!-- PAGE CONTENT : end -->

	</div>

<?php endwhile; endif; ?>

<?php // Main end
get_template_part( 'template-parts/main-end' ); ?>

<?php get_footer(); ?>