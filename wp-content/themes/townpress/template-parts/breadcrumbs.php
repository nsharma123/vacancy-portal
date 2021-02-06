<?php if ( lsvr_townpress_has_breadcrumbs() ) : ?>

	<?php if ( ! empty( lsvr_townpress_get_breadcrumbs() ) && count( lsvr_townpress_get_breadcrumbs() ) > 1 ) : ?>

		<?php do_action( 'lsvr_townpress_breadcrumbs_before' ); ?>

		<!-- BREADCRUMBS : begin -->
		<ul class="breadcrumbs">
			<?php foreach ( lsvr_townpress_get_breadcrumbs() as $breadcrumb ) : ?>
				<li class="breadcrumbs-item">
					<a href="<?php echo esc_url( $breadcrumb['url'] ); ?>" class="breadcrumbs-link"><?php echo esc_html( $breadcrumb['label'] ); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
		<!-- BREADCRUMBS : end -->

		<?php do_action( 'lsvr_townpress_breadcrumbs_after' ); ?>

	<?php endif; ?>

<?php endif; ?>