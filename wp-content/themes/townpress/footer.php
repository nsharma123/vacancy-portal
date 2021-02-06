		</div>
	</div>
	<!-- CORE : end -->

	<?php // Add custom code before Footer
	do_action( 'lsvr_townpress_footer_before' ); ?>

	<!-- FOOTER : begin -->
	<footer id="footer" <?php lsvr_townpress_the_footer_class(); ?>
		<?php lsvr_townpress_the_footer_background(); ?>>
		<div class="footer__inner">

			<?php // Add custom code before footer widgets
			do_action( 'lsvr_townpress_footer_widgets_before' ); ?>

			<?php // Footer widgets
			get_sidebar( 'footer-widgets' ); ?>

			<?php // Add custom code after footer widgets
			do_action( 'lsvr_townpress_footer_widgets_after' ); ?>

			<?php // Footer bottom
			get_template_part( 'template-parts/footer-bottom' ); ?>

			<?php // Add custom code after footer bottom
			do_action( 'lsvr_townpress_footer_bottom_after' ); ?>

		</div>
	</footer>
	<!-- FOOTER : end -->

</div>
<!-- WRAPPER : end -->

<?php wp_footer(); ?>

</body>
</html>