<?php if ( lsvr_townpress_has_navbar() ) : ?>

	<!-- HEADER NAVBAR : begin -->
	<div <?php lsvr_townpress_the_header_navbar_class(); ?>>
		<div class="header-navbar__inner">

			<div class="lsvr-container">

				<!-- HEADER MENU : begin -->
				<nav class="header-menu">

				    <?php wp_nav_menu(
				        array(
				            'theme_location' => 'lsvr-townpress-header-menu',
							'container' => '',
							'menu_class' => 'header-menu__list',
							'fallback_cb' => '',
							'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'walker' => new Lsvr_Townpress_Header_Menu_Walker(),
						)
					); ?>

				</nav>
				<!-- HEADER MENU : end -->

			</div>

		</div>
	</div>
	<!-- HEADER NAVBAR : end -->

	<?php // Sticky navbar placeholder
	if ( lsvr_townpress_has_sticky_navbar() ) : ?>
		<div class="header-navbar__placeholder"></div>
	<?php endif; ?>

<?php endif; ?>