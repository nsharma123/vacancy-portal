<!-- MAIN HEADER : begin -->
<header class="main__header">

	<h1 class="main__title">
		<?php if ( is_tax() ) : ?>
			<?php single_term_title(); ?>
		<?php else : ?>
			<?php echo esc_html( lsvr_townpress_get_event_archive_title() ); ?>
		<?php endif; ?>
	</h1>

	<?php // Breadcrumbs
	get_template_part( 'template-parts/breadcrumbs' ); ?>

</header>
<!-- MAIN HEADER : end -->