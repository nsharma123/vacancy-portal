<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<!-- WRAPPER : begin -->
	<div id="wrapper">

		<?php // Add custom code before Header
		do_action( 'lsvr_townpress_header_before' ); ?>

		<!-- HEADER : begin -->
		<header id="header" <?php lsvr_townpress_the_header_class(); ?>>
			<div class="header__inner">

				<?php // Add custom code at the top of Header
				do_action( 'lsvr_townpress_header_top' ); ?>

				<?php // Header menu
				get_template_part( 'template-parts/header/navbar' ); ?>

				<?php // Header map
				lsvr_townpress_the_header_map(); ?>

				<!-- HEADER CONTENT : begin -->
				<div class="header__content">
					<div class="lsvr-container">
						<div class="header__content-inner">

							<?php // Add custom code at the top of Header content
							do_action( 'lsvr_townpress_header_content_top' ); ?>

							<?php // Header branding
							get_template_part( 'template-parts/header/branding' ); ?>

							<?php // Header toolbar
							get_template_part( 'template-parts/header/toolbar' ); ?>

							<?php // Add custom code at the bottom of Header content
							do_action( 'lsvr_townpress_header_content_bottom' ); ?>

						</div>
					</div>
				</div>
				<!-- HEADER CONTENT : end -->

				<?php // Add custom code at the bottom of Header
				do_action( 'lsvr_townpress_header_bottom' ); ?>

			</div>
		</header>
		<!-- HEADER : end -->

		<?php // Add custom code after Header
		do_action( 'lsvr_townpress_header_after' ); ?>

		<?php // Header background
		lsvr_townpress_the_header_background(); ?>

		<!-- CORE : begin -->
		<div id="core">
			<div class="core__inner">