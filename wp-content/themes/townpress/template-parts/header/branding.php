<?php // Header logo
if ( has_custom_logo() ) : ?>

	<!-- HEADER BRANDING : begin -->
	<div <?php lsvr_townpress_the_header_logo_class(); ?>>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header-logo__link">
			<img src="<?php echo esc_url( wp_get_attachment_url( get_theme_mod( 'custom_logo' ) ) ); ?>"
				class="header-logo__image"
				alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
		</a>
	</div>
	<!-- HEADER BRANDING : end -->

<?php endif; ?>