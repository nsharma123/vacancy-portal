<?php

/**
 * GENERAL
 */

	// Alert message
	if ( ! function_exists( 'lsvr_townpress_the_alert_message' ) ) {
		function lsvr_townpress_the_alert_message( $message ) {

			echo '<p class="c-alert-message">' . esc_html( $message ) . '</p>';

		}
	}

	// Post archive categories
	if ( ! function_exists( 'lsvr_townpress_the_post_archive_categories' ) ) {
		function lsvr_townpress_the_post_archive_categories( $post_type, $taxonomy ) {

			$terms = get_terms( $taxonomy );
			if ( ! empty( $terms ) ) { ?>

				<!-- POST ARCHIVE CATEGORIES : begin -->
				<div class="post-archive-categories">
					<div class="c-content-box">
						<h6 class="screen-reader-text"><?php esc_html_e( 'Categories:', 'townpress' ); ?></h6>
						<ul class="post-archive-categories__list">

							<li class="post-archive-categories__item">
								<?php if ( is_tax( $taxonomy ) ) : ?>
									<a href="<?php echo esc_url( get_post_type_archive_link( $post_type ) ); ?>" class="post-archive-categories__item-link"><?php esc_html_e( 'All', 'townpress' ); ?></a>
								<?php else : ?>
									<strong><?php esc_html_e( 'All', 'townpress' ); ?></strong>
								<?php endif; ?>
							</li>

							<?php foreach ( $terms as $term ) : ?>
								<li class="post-archive-categories__item">
									<?php if ( get_queried_object_id() === $term->term_id ) : ?>
										<?php echo esc_html( $term->name ); ?>
									<?php else : ?>
										<a href="<?php echo esc_url( get_term_link( $term->term_id, $taxonomy ) ); ?>" class="post-archive-categories__item-link"><?php echo esc_html( $term->name ); ?></a>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>

						</ul>
					</div>
				</div>
				<!-- POST ARCHIVE CATEGORIES : end -->

			<?php }

		}
	}

	// Post terms
	if ( ! function_exists( 'lsvr_townpress_the_post_terms' ) ) {
		function lsvr_townpress_the_post_terms( $post_id, $taxonomy, $template = '%s', $separator = ', ', $limit = 0 ) {

			$terms = wp_get_post_terms( $post_id, $taxonomy );
			$terms_parsed = array();
			if ( ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					array_push( $terms_parsed, '<a href="' . esc_url( get_term_link( $term->term_id, $taxonomy ) ) . '" class="post__term-link">' . esc_html( $term->name ) . '</a>' );
				}
				if ( $limit > 0 && count( $terms_parsed ) > $limit ) {
					$terms_parsed = array_slice( $terms_parsed, 0, $limit );
				}
			}

			if ( ! empty( $terms_parsed ) ) { ?>

				<span class="post__terms post__terms--<?php echo esc_attr( $taxonomy ); ?>">
					<?php echo sprintf( $template, implode( ', ', $terms_parsed ) ); ?>
				</span>

			<?php }

		}
	}


/**
 * HEADER
 */

	// Header class
	if ( ! function_exists( 'lsvr_townpress_the_header_class' ) ) {
		function lsvr_townpress_the_header_class() {

			$class_arr = array();

			// Check if has navbar
			if ( lsvr_townpress_has_navbar() ) {
				array_push( $class_arr, 'header--has-navbar' );
			}

			// Check if has languages
			if ( lsvr_townpress_has_languages() ) {
				array_push( $class_arr, 'header--has-languages' );
			}

			// Check if has login
			if ( lsvr_townpress_has_header_login() ) {
				array_push( $class_arr, 'header--has-login' );
			}

			// Check if has map
			if ( lsvr_townpress_has_header_map() ) {
				array_push( $class_arr, 'header--has-map' );
			}

			// Echo
			if ( ! empty( $class_arr ) ) {
				echo ' class="' . esc_attr( implode( ' ', $class_arr ) ) . '"';
			}

		}
	}

	// Header navbar class
	if ( ! function_exists( 'lsvr_townpress_the_header_navbar_class' ) ) {
		function lsvr_townpress_the_header_navbar_class() {

			$class_arr = array( 'header-navbar' );

			// Check if sticky
			if ( lsvr_townpress_has_sticky_navbar() ) {
				array_push( $class_arr, 'header-navbar--sticky' );
			}

			// Echo
			if ( ! empty( $class_arr ) ) {
				echo ' class="' . esc_attr( implode( ' ', $class_arr ) ) . '"';
			}

		}
	}

	// Header map
	if ( ! function_exists( 'lsvr_townpress_the_header_map' ) ) {
		function lsvr_townpress_the_header_map() {

			$latlong = lsvr_townpress_get_header_map_latlong();
			$latlong = ! empty( $latlong ) ? implode( ',', $latlong ) : '';

			if ( lsvr_townpress_has_header_map() ) : ?>

				<div class="header-map header-map--loading">
					<div id="header-map-canvas" class="header-map__canvas"
						data-address="<?php echo esc_attr( get_theme_mod( 'header_map_address' ) ); ?>"
						data-latlong="<?php echo esc_attr( $latlong ); ?>"
						data-maptype="<?php echo esc_attr( get_theme_mod( 'header_map_type', 'roadmap' ) ); ?>"
						data-zoom="<?php echo esc_attr( get_theme_mod( 'header_map_zoom', 17 ) ); ?>"
						data-mousewheel="false">
					</div>
					<span class="c-spinner"></span>
					<button class="header-map__close" type="button"><i class="header-map__close-ico icon-cross"></i></button>
				</div>

			<?php endif;

		}
	}

	// Header logo class
	if ( ! function_exists( 'lsvr_townpress_the_header_logo_class' ) ) {
		function lsvr_townpress_the_header_logo_class( $custom_class = false ) {

			$class_arr = array( 'header-logo' );

			// Push custom class
			if ( ! empty( $custom_class ) ) {
				array_push( $class_arr, $custom_class );
			}

			// Check if front page
			if ( is_front_page() ) {
				array_push( $class_arr, 'header-logo--front' );
			}

			// Echo
			if ( ! empty( $class_arr ) ) {
				echo ' class="' . esc_attr( implode( ' ', $class_arr ) ) . '"';
			}

		}
	}

	// Header languages
	if ( ! function_exists( 'lsvr_townpress_the_header_languages' ) ) {
		function lsvr_townpress_the_header_languages() {

			$languages = lsvr_townpress_get_languages();
			$classes = array( 'header-toolbar__item header-languages' );

			if ( ! empty( $languages ) ) { ?>

				<!-- HEADER LANGUAGES : begin -->
				<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
					<span class="screen-reader-text"><?php esc_html_e( 'Choose language:', 'townpress' ); ?></span>
					<ul class="header-languages__list">

						<?php foreach ( $languages as $language ) : ?>
							<?php if ( ! empty( $language['label'] ) && ! empty( $language['url'] ) ) : ?>

								<li class="header-languages__item<?php if ( ! empty( $language['active'] ) ) { echo ' header-languages__item--active'; } ?>">
									<a href="<?php echo esc_url( $language['url'] ); ?>" class="header-languages__item-link"><?php echo esc_html( $language['label'] ); ?></a>
								</li>

							<?php endif; ?>
						<?php endforeach; ?>

					</ul>
				</div>
				<!-- HEADER LANGUAGES : end -->

			<?php }

		}
	}

	// Header map toggle
	if ( ! function_exists( 'lsvr_townpress_the_header_map_toggle' ) ) {
		function lsvr_townpress_the_header_map_toggle( $mobile = false ) {

			$class = array( 'header-map-toggle' );
			if ( true === $mobile ) {
				array_push( $class, 'header-map-toggle--mobile' );
			} else {
				array_push( $class, 'header-map-toggle--desktop header-toolbar__item' );
			}

			if ( lsvr_townpress_has_header_map() ) : ?>

				<!-- HEADER MAP TOGGLE : begin -->
				<button class="<?php echo esc_attr( implode( ' ', $class ) ); ?>" type="button">
					<i class="header-map-toggle__ico header-map-toggle__ico--open icon-map2"></i>
					<i class="header-map-toggle__ico header-map-toggle__ico--close icon-cross"></i>
					<span class="header-map-toggle__label"><?php echo esc_html( get_theme_mod( 'header_map_toggle_label', esc_html__( 'Map', 'townpress' ) ) ); ?></span>
				</button>
				<!-- HEADER MAP TOGGLE : end -->

			<?php endif;

		}
	}

	// Header login
	if ( ! function_exists( 'lsvr_townpress_the_header_login' ) ) {
		function lsvr_townpress_the_header_login() {

			if ( lsvr_townpress_has_header_login() ) : ?>

				<!-- HEADER LOGIN : begin -->
				<div class="header-login header-toolbar__item">

					<?php if ( is_user_logged_in() ) : ?>

						<?php $current_user = wp_get_current_user(); ?>

						<?php if ( function_exists( 'bbp_user_profile_edit_url' ) ) : ?>
							<a href="<?php bbp_user_profile_edit_url( bbp_get_current_user_id() ); ?>"
								class="header-login__profile-link"
								title="<?php echo esc_attr( $current_user->display_name ) . ' ' . esc_html__( '(edit profile)', 'townpress' ); ?>">
							<?php echo get_avatar( $current_user->ID, 40 ); ?></a>
						<?php endif; ?>

						<a href="<?php echo esc_url( wp_logout_url( get_home_url() ) ); ?>"
							class="header-login__link header-login__link--logout"
							title="<?php esc_html_e( 'Logout', 'townpress' ); ?>">
							<i class="header-login__ico icon-power-switch"></i>
						</a>

					<?php else : ?>

						<a href="<?php echo get_page_link( (int) get_theme_mod( 'header_login_page' ) ); ?>"
							class="header-login__link header-login__link--login"
							title="<?php echo get_theme_mod( 'header_login_label', esc_html__( 'Login', 'townpress' ) ); ?>">
							<i class="header-login__ico icon-key"></i>
						</a>

					<?php endif; ?>

				</div>
				<!-- HEADER LOGIN : end -->

			<?php endif;

		}
	}

	// Header search
	if ( ! function_exists( 'lsvr_townpress_the_header_search' ) ) {
		function lsvr_townpress_the_header_search() {

			if ( lsvr_townpress_has_header_search() ) : ?>

				<!-- HEADER SEARCH : begin -->
				<div class="header-search header-toolbar__item">

					<?php get_search_form() ?>

				</div>
				<!-- HEADER SEARCH : end -->

			<?php endif;

		}
	}

	// Mobile toolbar toggle
	if ( ! function_exists( 'lsvr_townpress_the_header_toolbar_toggle' ) ) {
		function lsvr_townpress_the_header_toolbar_toggle() {

			?>

			<!-- HEADER TOOLBAR TOGGLE : begin -->
			<div class="header-toolbar-toggle<?php if ( lsvr_townpress_has_header_map() ) { echo ' header-toolbar-toggle--has-map'; } ?>">

				<button class="header-toolbar-toggle__menu-button" type="button">
					<i class="header-toolbar-toggle__menu-button-ico header-toolbar-toggle__menu-button-ico--open icon-menu"></i>
					<i class="header-toolbar-toggle__menu-button-ico header-toolbar-toggle__menu-button-ico--close icon-cross"></i>
					<span class="header-toolbar-toggle__button-label">Menu</span>
				</button>

				<?php lsvr_townpress_the_header_map_toggle( true ); ?>

			</div>
			<!-- HEADER TOOLBAR TOGGLE : end -->

			<?php

		}
	}

	// Header background
	if ( ! function_exists( 'lsvr_townpress_the_header_background' ) ) {
		function lsvr_townpress_the_header_background() {

			$images = array();

			// Get background type
			$background_type = get_theme_mod( 'header_background_type', 'single' );

			// Set class
			$background_class_arr = array( 'header-background' );
			array_push( $background_class_arr, 'header-background--' . get_theme_mod( 'header_background_type', 'single' ) );

 			// If is page and has featured image, use it instead of image defined via Customizer
 			if ( is_page() && has_post_thumbnail( get_the_ID() ) ) {
				array_push( $images, get_the_post_thumbnail_url( get_the_ID() ) );
 			}

 			// Get image from Customizer
 			else {

				// Get default image
				$default_image_url = get_theme_mod( 'header_background_image', '' );
				if ( ! empty( $default_image_url )  ) {
					array_push( $images, $default_image_url );
				}

				// Get additional images
				if ( 'slideshow' === $background_type || 'random' === $background_type ||
					( 'slideshow-home' === $background_type && is_front_page() ) ) {

					for ( $i = 2; $i <= 5; $i++ ) {

						$image_url = get_theme_mod( 'header_background_image_' . $i, '' );
						if ( ! empty( $image_url )  ) {
							array_push( $images, $image_url );
						}

					}

				}

			}

			// Create background element
			if ( ! empty( $images ) ) { ?>

				<div class="<?php echo implode( ' ', $background_class_arr ); ?>"
					data-slideshow-speed="<?php echo esc_attr( get_theme_mod( 'header_background_slideshow_speed', 10 ) ); ?>">

					<?php // Pick random image
					if ( 'random' === $background_type ) : $random_index = rand( 0, count( $images ) - 1 ); ?>

						<div class="header-background__image header-background__image--default"
							style="background-image: url( '<?php echo ! empty( $images[ $random_index ] ) ? esc_url( $images[ $random_index ] ) : esc_url( reset( $images ) ); ?>' );"></div>

					<?php // List all images
					else : ?>

						<?php foreach ( $images as $image_url ) : ?>

							<div class="header-background__image<?php if ( $image_url === reset( $images ) ) { echo ' header-background__image--default'; } ?>"
								style="background-image: url('<?php echo esc_url( $image_url ); ?>'); "></div>

						<?php endforeach; ?>

					<?php endif; ?>

				</div>

			<?php }

		}
	}


/**
 * FOOTER
 */

	// Footer class
	if ( ! function_exists( 'lsvr_townpress_the_footer_class' ) ) {
		function lsvr_townpress_the_footer_class() {

			$class_arr = array();

			// Check if has background
			if ( lsvr_townpress_has_footer_background() ) {
				array_push( $class_arr, 'footer--has-background' );
			}

			// Echo
			if ( ! empty( $class_arr ) ) {
				echo ' class="' . esc_attr( implode( ' ', $class_arr ) ) . '"';
			}

		}
	}

	// Footer background
	if ( ! function_exists( 'lsvr_townpress_the_footer_background' ) ) {
		function lsvr_townpress_the_footer_background() {

			$image_url = get_theme_mod( 'footer_background_image' );
			if ( ! empty( $image_url ) ) {
				echo ' style="background-image: url( \'' . esc_url( $image_url ) . '\' );"';
			}

		}
	}

	// Footer widgets grid class
	if ( ! function_exists( 'lsvr_townpress_the_footer_widgets_grid_class' ) ) {
		function lsvr_townpress_the_footer_widgets_grid_class() {

			$classes = array( 'lsvr-grid' );
			$columns = get_theme_mod( 'footer_widgets_columns', 4 );

			// Cols
			array_push( $classes, 'lsvr-grid--' . $columns . '-cols' );

			// Cold md
			if ( $columns >= 2 ) {
				array_push( $classes, 'lsvr-grid--md-2-cols' );
			}

			if ( ! empty( $classes ) ) {
				echo ' class="' . esc_attr( implode( ' ', $classes ) ) . '"';
			}

		}
	}

	// Footer social links
	if ( ! function_exists( 'lsvr_townpress_the_footer_social_links' ) ) {
		function lsvr_townpress_the_footer_social_links() {

			$social_links = lsvr_townpress_get_social_links();
			if ( get_theme_mod( 'footer_social_links_enable', true ) &&
				! empty( $social_links ) ) {  ?>

				<!-- FOOTER SOCIAL LINKS : begin -->
				<div class="footer-social">
					<ul class="footer-social__list">
						<?php foreach ( $social_links as $social_link_id => $social_link ) : ?>
							<?php if ( ! empty( $social_link['url'] ) && ! empty( $social_link['icon'] ) ) : ?>
								<li class="footer-social__item footer-social__item--<?php echo esc_attr( $social_link_id ); ?>">
									<a class="footer-social__link footer-social__link--<?php echo esc_attr( $social_link_id ); ?>"
										<?php if ( 'email' === $social_link_id ) : ?>
											href="mailto:<?php echo esc_attr( $social_link['url'] ); ?>"
										<?php else : ?>
											href="<?php echo esc_url( $social_link['url'] ); ?>"
										<?php endif; ?>
										<?php if ( true === get_theme_mod( 'social_links_new_window_enable', false ) ) : ?>
											target="_blank"
										<?php endif; ?>
										<?php if ( ! empty( $social_link['label'] ) ) { echo ' title="' . esc_attr( $social_link['label'] ) . '"'; } ?>>
										<i class="footer-social__icon <?php echo esc_attr( $social_link['icon'] ); ?>"></i>
									</a>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				</div>
				<!-- FOOTER SOCIAL LINKS : end -->

			<?php }

		}
	}

	// Footer text
	if ( ! function_exists( 'lsvr_townpress_the_footer_text' ) ) {
		function lsvr_townpress_the_footer_text() {

			$footer_text = get_theme_mod( 'footer_text', '&copy; ' . date( 'Y' ) . ' ' . get_bloginfo( 'name' ) );

			if ( ! empty( $footer_text ) ) { ?>

				<!-- FOOTER TEXT : begin -->
				<div class="footer-text">
					<?php echo wpautop( wp_kses( $footer_text, array(
						'a' => array(
							'href' => array(),
							'title' => array(),
							'target' => array(),
						),
						'em' => array(),
						'br' => array(),
						'strong' => array(),
						'p' => array(),
					))); ?>
				</div>
				<!-- FOOTER TEXT : end -->

			<?php }

		}
	}

	// Back to top button
	if ( ! function_exists( 'lsvr_townpress_the_back_to_top_button' ) ) {
		function lsvr_townpress_the_back_to_top_button() {

			if ( 'disable' !== get_theme_mod( 'back_to_top_button_enable', 'disable' ) ) {

				$class = array( 'back-to-top' );
				array_push( $class, 'back-to-top--type-' . get_theme_mod( 'back_to_top_button_enable', 'disable' ) );

				?>

				<!-- BACK TO TOP : begin -->
				<div class="<?php echo esc_attr( implode( $class, ' ' ) ); ?>">
					<a class="back-to-top__link" href="#header" title="<?php echo esc_attr( esc_html__( 'Back to top', 'townpress' ) ); ?>"></a>
				</div>
				<!-- BACK TO TOP : end -->

			<?php }

		}
	}


/**
 * BLOG
 */

	// Blog post thumbnail
	if ( ! function_exists( 'lsvr_townpress_the_blog_post_thumbnail' ) ) {
		function lsvr_townpress_the_blog_post_thumbnail( $post_id ) {

			if ( has_post_thumbnail( $post_id ) && true === get_theme_mod( 'blog_archive_thumb_crop_enable', true ) ) : ?>

				<!-- POST THUMBNAIL : begin -->
				<p class="post__thumbnail post__thumbnail--cropped">
					<a href="<?php the_permalink(); ?>" class="post__thumbnail-link post__thumbnail-link--cropped"
						<?php echo ' style="background-image: url( \'' . esc_url( get_the_post_thumbnail_url( $post_id, 'large' ) ) . '\' );"'; ?>></a>
				</p>
				<!-- POST THUMBNAIL : end -->

			<?php elseif ( has_post_thumbnail( $post_id ) ) : ?>

				<!-- POST THUMBNAIL : begin -->
				<p class="post__thumbnail">
					<a href="<?php the_permalink(); ?>" class="post__thumbnail-link"><?php the_post_thumbnail(); ?></a>
				</p>
				<!-- POST THUMBNAIL : end -->

			<?php endif;

		}
	}


?>