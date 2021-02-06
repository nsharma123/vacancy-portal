<?php // Add custom code before Header toolbar
do_action( 'lsvr_townpress_header_toolbar_before' ); ?>

<?php if ( lsvr_townpress_has_languages() || lsvr_townpress_has_header_map() ||
	lsvr_townpress_has_header_login() || lsvr_townpress_has_header_search() || has_nav_menu( 'lsvr-townpress-header-mobile-menu' ) ) : ?>

	<?php // Mobile toolbar toggle
	lsvr_townpress_the_header_toolbar_toggle(); ?>

	<!-- HEADER TOOLBAR : begin -->
	<div class="header-toolbar">

		<?php // Add custom code at the top of Header toolbar
		do_action( 'lsvr_townpress_header_toolbar_top' ); ?>

		<?php // Language switcher
		lsvr_townpress_the_header_languages(); ?>

		<?php // Header map toggle
		lsvr_townpress_the_header_map_toggle(); ?>

		<?php // Header login
		lsvr_townpress_the_header_login(); ?>

		<?php // Mobile menu
		if ( has_nav_menu( 'lsvr-townpress-header-mobile-menu' ) ) : ?>

			<!-- HEADER MOBILE MENU : begin -->
			<nav class="header-mobile-menu">

			    <?php wp_nav_menu(
			        array(
			            'theme_location' => 'lsvr-townpress-header-mobile-menu',
						'container' => '',
						'menu_class' => 'header-mobile-menu__list',
						'fallback_cb' => '',
						'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'walker' => new Lsvr_Townpress_Header_Mobile_Menu_Walker(),
					)
				); ?>

			</nav>
			<!-- HEADER MOBILE MENU : end -->

		<?php endif; ?>

		<?php // Header search
		lsvr_townpress_the_header_search(); ?>

		<?php // Add custom code at the bottom of Header toolbar
		do_action( 'lsvr_townpress_header_toolbar_bottom' ); ?>

	</div>
	<!-- HEADER TOOLBAR : end -->

<?php endif; ?>

<?php // Add custom code after Header toolbar
do_action( 'lsvr_townpress_header_toolbar_after' ); ?>