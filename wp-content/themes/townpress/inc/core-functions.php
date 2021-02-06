<?php

/**
 * GENERAL
 */

	// Get pages
	if ( ! function_exists( 'lsvr_townpress_get_pages' ) ) {
		function lsvr_townpress_get_pages() {

			$pages = get_pages();
			$return = array();

			if ( ! empty( $pages ) ) {

				foreach ( $pages as $page ) {
					if ( ! empty( $page->ID ) && ! empty( $page->post_title ) ) {
						$return[ $page->ID ] = $page->post_title;
					}
				}

			}

			return $return;

		}
	}

	// Get languages
	if ( ! function_exists( 'lsvr_townpress_get_languages' ) ) {
		function lsvr_townpress_get_languages() {

			$languages = array();

			// WPML Generated
			if ( 'wpml' == get_theme_mod( 'language_switcher', 'disable' ) ) {

				$wpml_languages = apply_filters( 'wpml_active_languages', false, 'skip_missing=0&orderby=id&order=desc' );

				if ( is_array( $wpml_languages ) && count( $wpml_languages ) > 1 ) {
					foreach ( $wpml_languages as $lang ) {

						$language = array();
						$language['label'] = ! empty( $lang['language_code'] ) ? $lang['language_code'] : '';
						$language['url'] = ! empty( $lang['url'] ) ? $lang['url'] : '';
						$language['active'] = isset( $lang['active'] ) && true === (bool) $lang['active'] ? true : false;
						array_push( $languages, $language );

					}
				}

			}

			// Custom links
			elseif ( 'custom' == get_theme_mod( 'language_switcher', 'disable' ) ) {

				for ( $i = 1; $i <=4; $i++) {
					if ( ! empty( get_theme_mod( 'language_custom' . $i . '_label', '' ) ) &&
						! empty( get_theme_mod( 'language_custom' . $i . '_url', '' ) ) ) {

						$language = array();
						$language['label'] = get_theme_mod( 'language_custom' . $i . '_label', '' );
						$language['url'] = get_theme_mod( 'language_custom' . $i . '_url', '' );
						if ( ! empty( get_theme_mod( 'language_custom' . $i . '_code', '' ) ) &&
							get_locale() === get_theme_mod( 'language_custom' . $i . '_code', '' ) ) {

							$language['active'] = true;

						} else {
							$language['active'] = false;
						}

						array_push( $languages, $language );

					}
				}

			}

			return ! empty( $languages ) ? $languages : false;

		}
	}

	// Has languages
	if ( ! function_exists( 'lsvr_townpress_has_languages' ) ) {
		function lsvr_townpress_has_languages() {

			$languages = lsvr_townpress_get_languages();
			return ! empty( $languages ) ? true : false;

		}
	}

	// Get parents of taxonomy term
	if ( ! function_exists( 'lsvr_townpress_get_term_parents' ) ) {
		function lsvr_townpress_get_term_parents( $term_id, $taxonomy, $max_limit = 5 ) {

			$term = get_term( $term_id, $taxonomy );
			if ( 0 !== $term->parent ) {

				$parents_arr = [];
				$counter = 0;
				$parent_id = $term->parent;

				while ( 0 !== $parent_id && $counter < $max_limit ) {
					array_unshift( $parents_arr, $parent_id );
					$parent = get_term( $parent_id, $taxonomy );
					$parent_id = $parent->parent;
					$counter++;
				}
				return $parents_arr;

			}
			else {
				return false;
			}

		}
	}

	// Get breadcrumbs
	if ( ! function_exists( 'lsvr_townpress_get_breadcrumbs' ) ) {
		function lsvr_townpress_get_breadcrumbs() {

			global $wp_query, $post;
			$breadcrumbs = [];

			// Home link
			$breadcrumbs[] = array(
				'url' => esc_url( home_url( '/' ) ),
				'label' => esc_html__( 'Home', 'townpress' ),
			);

			// Blog root for blog pages
			if ( get_option( 'page_for_posts' ) ) {
				$blog_root = array(
					'url' => get_permalink( get_option( 'page_for_posts' ) ),
					'label' => get_the_title( get_option( 'page_for_posts' ) ),
				);
			}
			else {
				$blog_root = array(
					'url' => esc_url( home_url( '/' ) ),
					'label' => esc_html__( 'News', 'townpress' ),
				);
			}

			// Blog
			if ( is_tag() || is_day() || is_month() || is_year() || is_author() || is_singular( 'post' ) ) {
				array_push( $breadcrumbs, $blog_root );
			}

			// Blog category
			else if ( is_category() ) {
				$breadcrumbs[] = $blog_root;
				$current_term = $wp_query->queried_object;
				$current_term_id = $current_term->term_id;
				$parent_ids = lsvr_townpress_get_term_parents( $current_term_id, 'category' );
				if ( ! empty( $parent_ids ) ) {
					foreach( $parent_ids as $parent_id ){
						$parent = get_term( $parent_id, 'category' );
						$breadcrumbs[] = array(
							'url' => get_term_link( $parent, 'category' ),
							'label' => $parent->name,
						);
					}
				}
			}

			// Regular page
			else if ( is_page() ) {
				$parent_id = $post->post_parent;
				$parents_arr = [];
				while ( $parent_id ) {
					$page = get_page( $parent_id );
					$parents_arr[] = array(
						'url' => get_permalink( $page->ID ),
						'label' => get_the_title( $page->ID ),
					);
					$parent_id = $page->post_parent;
				}
				$parents_arr = array_reverse( $parents_arr );
				foreach ( $parents_arr as $parent ) {
					$breadcrumbs[] = $parent;
				}
			}

			// Apply filters
			if ( ! empty( apply_filters( 'lsvr_townpress_add_to_breadcrumbs', array() ) ) ) {
				$breadcrumbs = array_merge( $breadcrumbs, apply_filters( 'lsvr_townpress_add_to_breadcrumbs', array() ) );
			}

			// Taxonomy
			if ( is_tax() ) {

				$taxonomy = get_query_var( 'taxonomy' );
				$term_parents = lsvr_townpress_get_term_parents( get_queried_object_id(), $taxonomy );
				if ( ! empty( $term_parents ) ) {
					foreach( $term_parents as $term_id ) {

						$term = get_term_by( 'id', $term_id, $taxonomy );
						$breadcrumbs[] = array(
							'url' => get_term_link( $term_id, $taxonomy ),
							'label' => $term->name,
						);

					}
				}
			}

			// Return breadcrumbs
			return $breadcrumbs;

		}
	}

	// Has breadcrumbs
	if ( ! function_exists( 'lsvr_townpress_has_breadcrumbs' ) ) {
		function lsvr_townpress_has_breadcrumbs( $page_id = false ) {

			return apply_filters( 'lsvr_townpress_enable_breadcrumbs', true );

		}
	}

	// Get sidebars
	if ( ! function_exists( 'lsvr_townpress_get_sidebars' ) ) {
		function lsvr_townpress_get_sidebars() {

			$sidebar_list = array(
				'lsvr-townpress-default-sidebar-left' => esc_html__( 'Default Left Sidebar', 'townpress'  ),
				'lsvr-townpress-default-sidebar-right' => esc_html__( 'Default Right Sidebar', 'townpress'  )
			);
			$custom_sidebars = lsvr_townpress_get_custom_sidebars();
			if ( ! empty( $custom_sidebars ) ) {
				$sidebar_list = array_merge( $sidebar_list, $custom_sidebars );
			}

            return $sidebar_list;

		}
	}

	// Get custom sidebars
	if ( ! function_exists( 'lsvr_townpress_get_custom_sidebars' ) ) {
		function lsvr_townpress_get_custom_sidebars() {

			$return = array();

			$custom_sidebars = get_theme_mod( 'custom_sidebars' );
			if ( ! empty( $custom_sidebars ) && '{' === substr( $custom_sidebars, 0, 1 ) ) {

				$custom_sidebars = (array) json_decode( $custom_sidebars );
				if ( ! empty( $custom_sidebars['sidebars'] ) ) {
					$custom_sidebars = $custom_sidebars['sidebars'];
					foreach ( $custom_sidebars as $sidebar ) {
						$sidebar = (array) $sidebar;
						if ( ! empty( $sidebar['id'] ) ) {

							$sidebar_label = ! empty( $sidebar['label'] ) ? $sidebar['label'] : sprintf( esc_html__( 'Custom Sidebar %d', 'townpress' ), (int) $sidebar['id'] );
							$return[ 'lsvr-townpress-custom-sidebar-' . $sidebar['id'] ] = $sidebar_label;

						}
					}
				}

			}

			return $return;

		}
	}

	// Get page left sidebar ID
	if ( ! function_exists( 'lsvr_townpress_get_page_sidebar_left_id' ) ) {
		function lsvr_townpress_get_page_sidebar_left_id( $page_id = false ) {

			// Page
			if ( is_page() ) {

				$page_id = ! empty( $page_id ) ? $page_id : get_the_ID();
				$sidebar_id = ! empty( $page_id ) ? get_post_meta( $page_id, 'lsvr_townpress_page_sidebar_left', true ) : false;

				if ( ! empty( $sidebar_id ) ) {
					$sidebar_id = $sidebar_id;
				} else {
					$sidebar_id = 'lsvr-townpress-default-sidebar-left';
				}

			}

			// Is blog single
			else if ( is_singular( 'post' ) ) {
				$sidebar_id = get_theme_mod( 'blog_single_sidebar_left_id', 'lsvr-townpress-default-sidebar-left' );
			}

			// Is blog archive
			else if ( lsvr_townpress_is_blog() ) {
				$sidebar_id = get_theme_mod( 'blog_archive_sidebar_left_id', 'lsvr-townpress-default-sidebar-left' );
			}

			// Filter
			else if ( ! empty( apply_filters( 'lsvr_townpress_sidebar_left_id', 'lsvr-townpress-default-sidebar-left' ) ) ) {
				$sidebar_id = apply_filters( 'lsvr_townpress_sidebar_left_id', 'lsvr-townpress-default-sidebar-left' );
			}

			// Default
			else {
				$sidebar_id = 'lsvr-townpress-default-sidebar-left';
			}

			$sidebar_id = ! empty( $sidebar_id ) ? $sidebar_id : 'lsvr-townpress-default-sidebar-left';

			return $sidebar_id;

		}
	}

	// Has page left sidebar
	if ( ! function_exists( 'lsvr_townpress_has_page_sidebar_left' ) ) {
		function lsvr_townpress_has_page_sidebar_left( $page_id = false ) {

			$sidebar_id = lsvr_townpress_get_page_sidebar_left_id( $page_id );
			return $sidebar_id !== 'disable' ? true : false;

		}
	}

	// Get page right sidebar ID
	if ( ! function_exists( 'lsvr_townpress_get_page_sidebar_right_id' ) ) {
		function lsvr_townpress_get_page_sidebar_right_id( $page_id = false ) {

			// Page
			if ( is_page() ) {

				$page_id = ! empty( $page_id ) ? $page_id : get_the_ID();
				$sidebar_id = ! empty( $page_id ) ? get_post_meta( $page_id, 'lsvr_townpress_page_sidebar_right', true ) : false;

				if ( ! empty( $sidebar_id ) ) {
					$sidebar_id = $sidebar_id;
				} else {
					$sidebar_id = 'disable';
				}

			}

			// Is blog single
			else if ( is_singular( 'post' ) ) {
				$sidebar_id = get_theme_mod( 'blog_single_sidebar_right_id' );
			}

			// Is blog archive
			else if ( lsvr_townpress_is_blog() ) {
				$sidebar_id = get_theme_mod( 'blog_archive_sidebar_right_id', 'lsvr-townpress-default-sidebar-right' );
			}

			// Filter
			else if ( ! empty( apply_filters( 'lsvr_townpress_sidebar_right_id', 'lsvr-townpress-default-sidebar-right' ) ) ) {
				$sidebar_id = apply_filters( 'lsvr_townpress_sidebar_right_id', 'lsvr-townpress-default-sidebar-right' );
			}

			// Default
			else {
				$sidebar_id = 'lsvr-townpress-default-sidebar-right';
			}

			$sidebar_id = ! empty( $sidebar_id ) ? $sidebar_id : 'lsvr-townpress-default-sidebar-right';

			return $sidebar_id;

		}
	}

	// Has page right sidebar
	if ( ! function_exists( 'lsvr_townpress_has_page_sidebar_right' ) ) {
		function lsvr_townpress_has_page_sidebar_right( $page_id = false ) {

			$sidebar_id = lsvr_townpress_get_page_sidebar_right_id( $page_id );
			return $sidebar_id !== 'disable' ? true : false;

		}
	}

	// Get image URL
	if ( ! function_exists( 'lsvr_townpress_get_image_url' ) ) {
		function lsvr_townpress_get_image_url( $image_id, $size = 'full' ) {

			$image_src = wp_get_attachment_image_src( $image_id, $size );
			return ! empty( $image_src[0] ) ? $image_src[0] : '';

		}
	}

	// Get image width
	if ( ! function_exists( 'lsvr_townpress_get_image_width' ) ) {
		function lsvr_townpress_get_image_width( $image_id, $size = 'full' ) {

			$image_src = wp_get_attachment_image_src( $image_id, $size );
			return ! empty( $image_src[1] ) ? $image_src[1] : '';

		}
	}

	// Get image height
	if ( ! function_exists( 'lsvr_townpress_get_image_height' ) ) {
		function lsvr_townpress_get_image_height( $image_id, $size = 'full' ) {

			$image_src = wp_get_attachment_image_src( $image_id, $size );
			return ! empty( $image_src[2] ) ? $image_src[2] : '';

		}
	}

	// Get image title
	if ( ! function_exists( 'lsvr_townpress_get_image_title' ) ) {
		function lsvr_townpress_get_image_title( $image_id ) {

			$image_title = get_the_title( $image_id );
			return ! empty( $image_title ) ? $image_title : '';

		}
	}

	// Get image alt
	if ( ! function_exists( 'lsvr_townpress_get_image_alt' ) ) {
		function lsvr_townpress_get_image_alt( $image_id ) {

			$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
			return ! empty( $image_alt ) ? $image_alt : '';

		}
	}

	// Get social links
	if ( ! function_exists( 'lsvr_townpress_get_social_links' ) ) {
		function lsvr_townpress_get_social_links() {

			$social_links = array();

			$saved_social_links = ! empty( get_theme_mod( 'social_links', '' ) ) ? (array) @json_decode( get_theme_mod( 'social_links', '' ) ) : '';
			if ( ! empty( $saved_social_links ) ) {
				foreach ( $saved_social_links as $saved_link_id => $saved_link_info ) {
					$social_links[ $saved_link_id ] = (array) $saved_link_info;
				}
			}

			// Get custom links
			$custom_social_links = apply_filters( 'lsvr_townpress_add_custom_social_links', '' );
			if ( ! empty( $custom_social_links ) ) {
				$social_links = array_merge( $social_links, $custom_social_links );
			}

			return $social_links;

		}
	}

	// Get post terms names
	if ( ! function_exists( 'lsvr_townpress_get_post_term_names' ) ) {
		function lsvr_townpress_get_post_term_names( $post_id, $taxonomy ) {

			$terms = wp_get_post_terms( $post_id, $taxonomy );
			$term_names = array();

			if ( ! empty( $terms ) && is_array( $terms ) ) {
				foreach ( $terms as $tag ) {
					array_push( $term_names, $tag->name );
				}
			}
			return ! empty( $term_names ) ? $term_names : false;

		}
	}

	// Has post terms
	if ( ! function_exists( 'lsvr_townpress_has_post_terms' ) ) {
		function lsvr_townpress_has_post_terms( $post_id, $taxonomy ) {

			$terms = wp_get_post_terms( $post_id, $taxonomy );
			return ! empty( $terms ) ? true : false;

		}
	}

	// Has previous post
	if ( ! function_exists( 'lsvr_townpress_has_previous_post' ) ) {
		function lsvr_townpress_has_previous_post() {

			$previous_post = get_adjacent_post( false, '', false );
			return ! empty( $previous_post ) ? true : false;

		}
	}

	// Get previous post ID
	if ( ! function_exists( 'lsvr_townpress_get_previous_post_url' ) ) {
		function lsvr_townpress_get_previous_post_url() {

			$previous_post = get_adjacent_post( false, '', false );
			return ! empty( $previous_post->ID ) ? get_permalink( $previous_post->ID ) : false;

		}
	}

	// Get previous post title
	if ( ! function_exists( 'lsvr_townpress_get_previous_post_title' ) ) {
		function lsvr_townpress_get_previous_post_title() {

			$previous_post = get_adjacent_post( false, '', false );
			return ! empty( $previous_post->post_title ) ? $previous_post->post_title : false;

		}
	}

	// Has next post
	if ( ! function_exists( 'lsvr_townpress_has_next_post' ) ) {
		function lsvr_townpress_has_next_post() {

			$next_post = get_adjacent_post( false, '', true );
			return ! empty( $next_post ) ? true : false;

		}
	}

	// Get next post ID
	if ( ! function_exists( 'lsvr_townpress_get_next_post_url' ) ) {
		function lsvr_townpress_get_next_post_url() {

			$next_post = get_adjacent_post( false, '', true );
			return ! empty( $next_post->ID ) ? get_permalink( $next_post->ID ) : false;

		}
	}

	// Get next post title
	if ( ! function_exists( 'lsvr_townpress_get_next_post_title' ) ) {
		function lsvr_townpress_get_next_post_title() {

			$next_post = get_adjacent_post( false, '', true );
			return ! empty( $next_post->post_title ) ? $next_post->post_title : false;

		}
	}

	// Get post comments count
	if ( ! function_exists( 'lsvr_townpress_get_post_comments_count' ) ) {
		function lsvr_townpress_get_post_comments_count( $post_id = false ) {

			$post_id = ! empty( $post_id ) ? $post_id : get_the_ID();

            $comments_count = get_comment_count( $post_id );
            $approved_count = ! empty( $comments_count['approved'] ) ? (int) $comments_count['approved'] : false;

			return ! empty( $approved_count ) ? $approved_count : 0;

		}
	}

	// Has post comments
	if ( ! function_exists( 'lsvr_townpress_has_post_comments' ) ) {
		function lsvr_townpress_has_post_comments( $post_id = false ) {

			$post_id = ! empty( $post_id ) ? $post_id : get_the_ID();

            $comments_count = get_comment_count( $post_id );
            $approved_count = ! empty( $comments_count['approved'] ) ? (int) $comments_count['approved'] : false;

			return ! empty( $approved_count ) ? true : false;

		}
	}

	// Day name
	if ( ! function_exists( 'lsvr_townpress_get_day_name' ) ) {
		function lsvr_townpress_get_day_name( $day, $format = 'l' ) {

			return date_i18n( $format, strtotime( $day ) );

		}
	}

	// Convert hex color to RGB
	if ( ! function_exists( 'lsvr_townpress_hex2rgb' ) ) {
		function lsvr_townpress_hex2rgb( $hex ) {

			$hex = ltrim( $hex, '#' );
			$rgb = array();
			if ( 6 === strlen( $hex ) ) {
				array_push( $rgb, substr( $hex, 0, 2 ) );
				array_push( $rgb, substr( $hex, 2, 2 ) );
				array_push( $rgb, substr( $hex, 4, 2 ) );
				return array_map( 'hexdec', $rgb );
			}

		}
	}


	// Custom colors CSS
	if ( ! function_exists( 'lsvr_townpress_get_custom_colors_css' ) ) {
		function lsvr_townpress_get_custom_colors_css( $is_editor = false ) {

			$custom_colors = array(
				'accent1' => get_theme_mod( 'colors_custom_accent1', '#ec5237' ),
				'body-link' => get_theme_mod( 'colors_custom_link', '#ec5237' ),
				'body-font' => get_theme_mod( 'colors_custom_text', '#565656' ),
			);

			$theme_version = wp_get_theme( 'townpress' );
			$theme_version = $theme_version->Version;

			// Check if CSS with same colors doesn't exists in DB
			$saved_colors = get_option( 'lsvr_townpress_custom_colors' );
			$saved_css = get_option( 'lsvr_townpress_custom_colors_css' );
			$saved_editor_css = get_option( 'lsvr_townpress_custom_editor_colors_css' );
			$saved_version = get_option( 'lsvr_townpress_custom_colors_version' );

			if ( ! empty( $saved_colors ) && ! empty( $saved_css ) && ! empty( $saved_editor_css ) && $saved_colors === $custom_colors && $theme_version === $saved_version ) {
				if ( true === $is_editor ) {
					return $saved_editor_css;
				} else {
					return $saved_css;
				}
			}

			// If there is no CSS for selected colors, generate it
			else {

				$css_template = lsvr_townpress_get_custom_colors_template();
				$css_editor_template = lsvr_townpress_get_editor_custom_colors_template();

				if ( ! empty( $css_template ) && ! empty( $css_editor_template ) ) {

					// Get RGB accents
					$accent1_rgb = implode( ', ', lsvr_townpress_hex2rgb( $custom_colors[ 'accent1' ] ) );

					// Replace RGBA first
					$custom_css = str_replace(
						array( 'rgba( $accent1' ),
						array( 'rgba( ' . $accent1_rgb ),
						$css_template
					);
					$custom_editor_css = str_replace(
						array( 'rgba( $accent1' ),
						array( 'rgba( ' . $accent1_rgb ),
						$css_editor_template
					);

					// Replace the rest
					$custom_css = str_replace(
						array( '$accent1', '$body-link', '$body-font', "\r", "\n", "\t" ),
						array( $custom_colors[ 'accent1' ], $custom_colors[ 'body-link' ], $custom_colors[ 'body-font' ], '', '', '' ),
						$custom_css
					);
					$custom_editor_css = str_replace(
						array( '$accent1', '$body-link', '$body-font', "\r", "\n", "\t" ),
						array( $custom_colors[ 'accent1' ], $custom_colors[ 'body-link' ], $custom_colors[ 'body-font' ], '', '', '' ),
						$custom_editor_css
					);

					// Save colors and CSS to DB
					update_option( 'lsvr_townpress_custom_colors', $custom_colors );
					update_option( 'lsvr_townpress_custom_colors_css', $custom_css );
					update_option( 'lsvr_townpress_custom_editor_colors_css', $custom_editor_css );
					update_option( 'lsvr_townpress_custom_colors_version', $theme_version );

					if ( true === $is_editor ) {
						return $custom_editor_css;
					} else {
						return $custom_css;
					}

				} else {
					return '';
				}

			}

		}
	}


/**
 * HEADER
 */

	// Has navbar
	if ( ! function_exists( 'lsvr_townpress_has_navbar' ) ) {
		function lsvr_townpress_has_navbar() {

			if ( has_nav_menu( 'lsvr-townpress-header-menu' ) ) {
				return true;
			} else {
				return false;
			}

		}
	}

	// Has sticky navbar
	if ( ! function_exists( 'lsvr_townpress_has_sticky_navbar' ) ) {
		function lsvr_townpress_has_sticky_navbar() {

			if ( true === get_theme_mod( 'sticky_navbar_enable', true ) ) {
				return true;
			} else {
				return false;
			}

		}
	}

	// Has header map
	if ( ! function_exists( 'lsvr_townpress_has_header_map' ) ) {
		function lsvr_townpress_has_header_map() {

			$latlong = lsvr_townpress_get_header_map_latlong();
			$address = get_theme_mod( 'header_map_address' );

			if ( ( 'enable' === get_theme_mod( 'header_map_enable', 'disable' )
				|| ( 'enable-front' === get_theme_mod( 'header_map_enable', 'disable' ) && is_front_page() ) )
				&& ( ! empty( $latlong ) || ! empty( $address ) ) ) {

				return true;

			}

			else {
				return false;
			}

		}
	}

	// Header map latlong
	if ( ! function_exists( 'lsvr_townpress_get_header_map_latlong' ) ) {
		function lsvr_townpress_get_header_map_latlong() {

			$latitude = get_theme_mod( 'header_map_latitude' );
			$longitude = get_theme_mod( 'header_map_longitude' );
			$map_meta = get_option( 'lsvr_townpress_header_map_meta' );
			$latlong_geocoded = ! empty( $map_meta['latlong_geocoded'] ) ? $map_meta['latlong_geocoded'] : false;

			// Return user submitted latlong
			if ( ! empty( $latitude ) && ! empty( $longitude ) ) {
				return array_map( 'trim', array( $latitude, $longitude ) );
			}

			// Return geocoded altlong from address
			else if ( ! empty( $latlong_geocoded ) ) {
				return array_map( 'trim', explode( ',', $latlong_geocoded ) );
			}

			else {
				return false;
			}

		}
	}

	// Has header login
	if ( ! function_exists( 'lsvr_townpress_has_header_login' ) ) {
		function lsvr_townpress_has_header_login() {

			if ( true === (bool) get_theme_mod( 'header_login_enable', true ) && ! empty( get_theme_mod( 'header_login_page' ) ) ) {
				return true;
			} else {
				return false;
			}

		}
	}

	// Has header search
	if ( ! function_exists( 'lsvr_townpress_has_header_search' ) ) {
		function lsvr_townpress_has_header_search() {

			if ( true === (bool) get_theme_mod( 'header_search_enable', true ) ) {
				return true;
			} else {
				return false;
			}

		}
	}


/**
 * FOOTER
 */

	// Has background
	if ( ! function_exists( 'lsvr_townpress_has_footer_background' ) ) {
		function lsvr_townpress_has_footer_background() {

			$image_url = get_theme_mod( 'footer_background_image' );
			if ( ! empty( $image_url ) ) {
				return true;
			} else {
				return false;
			}

		}
	}

	// Footer widgets before widget
	if ( ! function_exists( 'lsvr_townpress_get_footer_widgets_before_widget' ) ) {
		function lsvr_townpress_get_footer_widgets_before_widget() {

			$columns = (int) get_theme_mod( 'footer_widgets_columns', 4 );
			$span = 12 / $columns;
			$span_lg = $columns >= 2 ? 6 : 12;
			$span_md = $columns >= 2 ? 6 : 12;

			$return = '<div class="footer-widgets__column lsvr-grid__col lsvr-grid__col--span-' . esc_attr( $span );
			$return .= ' lsvr-grid__col--md lsvr-grid__col--md-span-' . esc_attr( $span_md );
			$return .= ' lsvr-grid__col--lg lsvr-grid__col--lg-span-' . esc_attr( $span_lg ) . '">';
			$return .= '<div class="footer-widgets__column-inner"><div id="%1$s" class="widget %2$s"><div class="widget__inner">';

			return $return;

		}
	}

	// Footer widgets after widget
	if ( ! function_exists( 'lsvr_townpress_get_footer_widgets_after_widget' ) ) {
		function lsvr_townpress_get_footer_widgets_after_widget() {

			return '</div></div></div></div>';

		}
	}

	// Has footer social links
	if ( ! function_exists( 'lsvr_townpress_has_footer_social_links' ) ) {
		function lsvr_townpress_has_footer_social_links() {

			$social_links = lsvr_townpress_get_social_links();
			if ( true === get_theme_mod( 'footer_social_links_enable', true ) && ! empty( $social_links )) {
				return true;
			} else {
				return false;
			}

		}
	}

	// Has footer text
	if ( ! function_exists( 'lsvr_townpress_has_footer_text' ) ) {
		function lsvr_townpress_has_footer_text() {

			$footer_text = get_theme_mod( 'footer_text' );
			if ( ! empty( $footer_text ) ) {
				return true;
			} else {
				return false;
			}
		}
	}


/**
 * BLOG
 */

	// Is blog page
	if ( ! function_exists( 'lsvr_townpress_is_blog' ) ) {
		function lsvr_townpress_is_blog() {

			if ( is_home() || is_post_type_archive( 'post' ) || is_category() || is_singular( 'post' ) ||
				is_tag() || is_day() || is_month() || is_year() || is_author() ) {
				return true;
			} else {
				return false;
			}

		}
	}

	// Get blog archive layout
	if ( ! function_exists( 'lsvr_townpress_get_blog_archive_layout' ) ) {
		function lsvr_townpress_get_blog_archive_layout() {

			$path_prefix = 'template-parts/blog/archive-layout-';

			// Get layout from Customizer
			if ( ! empty( locate_template( $path_prefix . get_theme_mod( 'blog_archive_layout', 'default' ) . '.php' ) ) ) {
				return get_theme_mod( 'blog_archive_layout', 'default' );
			}

			// Default layout
			else {
				return 'default';
			}

		}
	}

	// Get blog archive title
	if ( ! function_exists( 'lsvr_townpress_get_blog_archive_title' ) ) {
		function lsvr_townpress_get_blog_archive_title() {

			if ( is_author() ) {
				return sprintf( esc_html__( 'Author: %s', 'townpress' ), get_the_author_meta( 'display_name' ) );
			} else if ( ! is_home() && ! is_post_type_archive( 'post' ) ) {
				return get_the_archive_title();
			} else if ( get_option( 'page_for_posts' ) ) {
				return esc_html( get_the_title( get_option( 'page_for_posts' ) ) );
			} else {
				return esc_html__( 'News', 'townpress' );
			}

		}
	}

?>