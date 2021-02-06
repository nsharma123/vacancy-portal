<?php /* Template Name: Boxed w/o Title */
esc_html__( 'Boxed w/o Title', 'townpress' ); ?>

<?php get_header(); ?>

<?php // Main begin
get_template_part( 'template-parts/main-begin' ); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<div <?php post_class(); ?>>

		<!-- PAGE CONTENT : begin -->
		<div class="page__content">

			<div class="c-content-box">

				<?php the_content(); ?>
				<?php wp_link_pages(); ?>

			</div>

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