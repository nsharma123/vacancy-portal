<?php if ( is_active_sidebar( 'lsvr-townpress-footer-widgets' ) ) : ?>

	<!-- FOOTER WIDGETS : begin -->
	<div class="footer-widgets">
		<div class="footer-widgets__inner">
			<div class="lsvr-container">
				<div<?php lsvr_townpress_the_footer_widgets_grid_class(); ?>>

					<?php dynamic_sidebar( 'lsvr-townpress-footer-widgets' ); ?>

				</div>
			</div>
		</div>
	</div>
	<!-- FOOTER WIDGETS : end -->

<?php endif; ?>