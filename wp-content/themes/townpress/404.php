<?php get_header(); ?>

<?php // Main begin
get_template_part( 'template-parts/main-begin' ); ?>

	<div <?php post_class( 'error-404-page' ); ?>>

		<!-- PAGE CONTENT : begin -->
		<div class="page__content">
			<div class="c-content-box">

				<!-- ERROR 404 PAGE : begin -->
				<div class="error-404-page__inner">
					<h1 class="error-404-page__404"><?php esc_html_e( '404', 'townpress' ); ?></h1>
					<div class="error-404-page__content">
						<h2 class="error-404-page__title"><?php esc_html_e( 'Page Not Found', 'townpress' ); ?></h2>
						<p class="error-404-page__text"><?php esc_html_e( 'The server can\'t find the page you requested. The page has either been moved to a different location or deleted, or you may have mistyped the URL.', 'townpress' ); ?></p>
						<p class="error-404-page__link">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="c-button c-button--large"><?php esc_html_e( 'Back to homepage', 'townpress' ); ?></a>
						</p>
					</div>
				</div>
				<!-- ERROR 404 PAGE : end -->

			</div>
		</div>
		<!-- PAGE CONTENT : end -->

	</div>

<?php // Main end
get_template_part( 'template-parts/main-end' ); ?>

<?php get_footer(); ?>