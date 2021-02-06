<?php if ( lsvr_townpress_has_footer_social_links() || lsvr_townpress_has_footer_text() ||
	has_nav_menu( 'lsvr-townpress-footer-menu' ) ) : ?>

	<!-- FOOTER BOTTOM : begin -->
	<div class="footer-bottom">
		<div class="lsvr-container">
			<div class="footer-bottom__inner">

				<?php // Social links
				lsvr_townpress_the_footer_social_links(); ?>

				<?php // Add custom code before footer menu
				do_action( 'lsvr_townpress_footer_menu_before' ); ?>

				<?php if ( has_nav_menu( 'lsvr-townpress-footer-menu' ) ) : ?>

					<!-- FOOTER MENU : begin -->
					<nav class="footer-menu">

					    <?php wp_nav_menu(
					        array(
					            'theme_location' => 'lsvr-townpress-footer-menu',
								'container' => '',
								'menu_class' => 'footer-menu__list',
								'fallback_cb' => '',
								'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
								'depth' => 1,
							)
						); ?>

					</nav>
					<!-- FOOTER MENU : end -->

				<?php endif; ?>

				<?php // Add custom code after footer menu
				do_action( 'lsvr_townpress_footer_menu_after' ); ?>

				<?php // Footer text
				lsvr_townpress_the_footer_text(); ?>

				<?php // Add custom code after footer text
				do_action( 'lsvr_townpress_footer_text_after' ); ?>

				<?php // Back to top button
				lsvr_townpress_the_back_to_top_button(); ?>

			</div>
		</div>
	</div>
	<!-- FOOTER BOTTOM : end -->

<?php endif; ?>