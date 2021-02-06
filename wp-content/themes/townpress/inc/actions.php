<?php

// Load Google Fonts
add_action( 'lsvr_townpress_load_assets', 'lsvr_townpress_load_google_fonts_css', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_load_google_fonts_css' ) ) {
	function lsvr_townpress_load_google_fonts_css() {

		if ( true === get_theme_mod( 'typography_google_fonts_enable', true ) ) {

			// Prepare query params
			$primary_font = get_theme_mod( 'typography_primary_font', 'Source+Sans+Pro' );
			$primary_font_variants = '400,400italic,600,600italic,700,700italic';
			$family_param = $primary_font . ':' . $primary_font_variants;
			$subset = get_theme_mod( 'typography_font_subsets' );
			$subset_param = ! empty( $subset ) && is_string( $subset ) ? $subset : '';

			// Create query
			$query_args = array(
				'family' => $family_param,
				'subset' => $subset_param,
			);
			$query_args = array_filter( $query_args );

			// Enqueue fonts
			if ( ! empty( $query_args ) ) {
				wp_enqueue_style( 'lsvr-townpress-google-fonts', add_query_arg( $query_args, '//fonts.googleapis.com/css' ) );
			}

			// Primary font style
			$primary_font_elements = array( 'body', 'input', 'textarea', 'select', 'button', '#cancel-comment-reply-link', '.lsvr_listing-map__infobox' );
			$primary_font_family = str_replace( '+', ' ', $primary_font );
			$primary_font_css = implode( ', ', $primary_font_elements ) . ' { font-family: \'' . esc_attr( $primary_font_family ) . '\', Arial, sans-serif; }';
			wp_add_inline_style( 'lsvr-townpress-main-style', $primary_font_css );
			wp_add_inline_style( 'lsvr-townpress-main-style', 'html, body { font-size: ' . esc_attr( get_theme_mod( 'typography_base_font_size', '16' ) ) . 'px; }' );

		}

	}
}

// Load editor Google Fonts
add_action( 'lsvr_townpress_load_editor_assets', 'lsvr_townpress_load_editor_google_fonts_css', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_load_editor_google_fonts_css' ) ) {
	function lsvr_townpress_load_editor_google_fonts_css() {

		if ( true === get_theme_mod( 'typography_google_fonts_enable', true ) ) {

			// Prepare query params
			$primary_font = get_theme_mod( 'typography_primary_font', 'Source+Sans+Pro' );
			$primary_font_variants = '400,400italic,600,600italic,700,700italic';
			$family_param = $primary_font . ':' . $primary_font_variants;
			$subset = get_theme_mod( 'typography_font_subsets' );
			$subset_param = ! empty( $subset ) && is_string( $subset ) ? $subset : '';

			// Create query
			$query_args = array(
				'family' => $family_param,
				'subset' => $subset_param,
			);
			$query_args = array_filter( $query_args );

			// Enqueue fonts
			if ( ! empty( $query_args ) ) {
				wp_enqueue_style( 'lsvr-townpress-editor-google-fonts', add_query_arg( $query_args, '//fonts.googleapis.com/css' ) );
			}

			// Primary font style
			$primary_font_elements = array( '.lsvr-shortcode-block-view__html' );
			$primary_font_family = str_replace( '+', ' ', $primary_font );
			$primary_font_css = implode( ', ', $primary_font_elements ) . ' { font-family: \'' . esc_attr( $primary_font_family ) . '\', Arial, sans-serif; }';
			wp_add_inline_style( 'lsvr-townpress-editor-style', $primary_font_css );
			wp_add_inline_style( 'lsvr-townpress-editor-style', '.lsvr-shortcode-block-view__html { font-size: ' . esc_attr( get_theme_mod( 'typography_base_font_size', '16' ) ) . 'px; }' );

		}

	}
}

// Set logo dimensions
add_action( 'lsvr_townpress_load_assets', 'lsvr_townpress_set_logo_dimensions', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_set_logo_dimensions' ) ) {
	function lsvr_townpress_set_logo_dimensions() {

		$max_width = get_theme_mod( 'header_logo_max_width', 140 );
		$max_width_home = get_theme_mod( 'header_logo_max_width_home', 200 );
		$max_width_mobile = get_theme_mod( 'header_logo_max_width_mobile', 140 );
		if ( ! empty( $max_width ) && ! empty( $max_width_home ) ) {
			wp_add_inline_style( 'lsvr-townpress-main-style', '.header-logo { max-width: ' . esc_attr( $max_width ) . 'px; } .header-logo--front { max-width: ' . esc_attr( $max_width_home ) . 'px; } @media ( max-width: 991px ) { .header-logo { max-width: ' . esc_attr( $max_width_mobile ) . 'px; } }' );
		}

	}
}

// Load skin CSS
add_action( 'lsvr_townpress_load_assets', 'lsvr_townpress_load_skin_css' );
if ( ! function_exists( 'lsvr_townpress_load_skin_css' ) ) {
	function lsvr_townpress_load_skin_css() {

		$version = wp_get_theme( 'townpress' );
		$version = $version->Version;

		// Load predefined color skin
		if ( 'predefined' === get_theme_mod( 'colors_method', 'predefined' ) || 'custom-colors' === get_theme_mod( 'colors_method', 'predefined' ) ) {
			$skin_file = get_theme_mod( 'colors_predefined_skin', 'default' );
			wp_enqueue_style( 'lsvr-townpress-color-scheme', get_template_directory_uri() . '/assets/css/skins/' . esc_attr( $skin_file ) . '.css', array( 'lsvr-townpress-main-style' ), $version );
		}

		// Generate CSS from custom colors
		if ( 'custom-colors' === get_theme_mod( 'colors_method', 'predefined' ) ) {
			wp_add_inline_style( 'lsvr-townpress-color-scheme', lsvr_townpress_get_custom_colors_css() );
		}

	}
}

// Load editor skin CSS
add_action( 'lsvr_townpress_load_editor_assets', 'lsvr_townpress_load_editor_skin_css' );
if ( ! function_exists( 'lsvr_townpress_load_editor_skin_css' ) ) {
	function lsvr_townpress_load_editor_skin_css() {

		$version = wp_get_theme( 'townpress' );
		$version = $version->Version;

		// Load predefined editor color skin
		if ( 'predefined' === get_theme_mod( 'colors_method', 'predefined' ) || 'custom-colors' === get_theme_mod( 'colors_method', 'predefined' ) ) {
			$skin_file = get_theme_mod( 'colors_predefined_skin', 'default' );
			wp_enqueue_style( 'lsvr-townpress-editor-color-scheme', get_template_directory_uri() . '/assets/css/skins/' . esc_attr( $skin_file ) . '.editor.css', array( 'lsvr-townpress-editor-style' ), $version );
		}

		// Generate CSS from custom colors
		if ( 'custom-colors' === get_theme_mod( 'colors_method', 'predefined' ) ) {
			wp_add_inline_style( 'lsvr-townpress-editor-color-scheme', lsvr_townpress_get_custom_colors_css( true ) );
		}


	}
}

// Load Google API key
add_action( 'lsvr_townpress_load_assets', 'lsvr_townpress_load_google_api_key', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_load_google_api_key' ) ) {
	function lsvr_townpress_load_google_api_key() {

		$api_key = get_theme_mod( 'google_api_key' );
		if ( ! empty( $api_key ) ) {
			wp_add_inline_script( 'lsvr-townpress-main-scripts', 'var lsvr_townpress_google_api_key = "' . esc_js( trim( $api_key ) ) . '";' );
		}

	}
}

// Load Google Maps style
add_action( 'lsvr_townpress_load_assets', 'lsvr_townpress_load_google_maps_style', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_load_google_maps_style' ) ) {
	function lsvr_townpress_load_google_maps_style() {

		if ( is_singular( 'lsvr_listing' ) || is_post_type_archive( 'lsvr_listing' ) || is_tax( 'lsvr_listing_cat' ) || is_tax( 'lsvr_listing_tag' ) || is_singular( 'lsvr_event' ) || is_page() ) {

			$custom_map_style = get_theme_mod( 'google_maps_style_custom', '' );

			if ( 'custom' === get_theme_mod( 'google_maps_style', 'default' ) && ! empty( $custom_map_style ) ) {
				wp_add_inline_script( 'lsvr-townpress-main-scripts', 'var lsvr_townpress_google_maps_style_json = ' . json_encode( $custom_map_style ) . ';' );
			}

		}

	}
}

// Load Magnific Popup lightbox
add_action( 'lsvr_townpress_load_assets', 'lsvr_townpress_load_lightbox', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_load_lightbox' ) ) {
	function lsvr_townpress_load_lightbox() {

		if ( true === apply_filters( 'lsvr_townpress_default_lightbox_enable', true ) && ( is_page() || is_singular( 'lsvr_listing' ) || is_singular( 'lsvr_gallery' ) ) ) {

			// Generate config JS for Magnific Popup
			$magnific_popup_config = 'var lsvr_townpress_magnificpopup_config = {
				mp_tClose : \'' . esc_html__( 'Close (Esc)', 'townpress' ) . '\',
				mp_tLoading : \'' . esc_html__( 'Loading...', 'townpress' ) . '\',
				mp_tPrev : \'' . esc_html__( 'Previous (Left arrow key)', 'townpress' ) . '\',
				mp_tNext : \'' . esc_html__( 'Next (Right arrow key)', 'townpress' ) . '\',
				mp_image_tError : \'' . esc_html__( 'The image could not be loaded.', 'townpress' ) . '\',
				mp_ajax_tError : \'' . esc_html__( 'The content could not be loaded.', 'townpress' ) . '\',
			};';
			wp_add_inline_script( 'magnific-popup', $magnific_popup_config );

		}

	}
}

// Add icon field to widgets
add_action( 'in_widget_form', 'lsvr_townpress_widget_custom_options', 5, 3 );
if ( ! function_exists( 'lsvr_townpress_widget_custom_options' ) ) {
	function lsvr_townpress_widget_custom_options( $t, $return, $instance ) {

		$default_icons = array(
			'archives' => 'icon-archive',
			'calendar' => 'icon-calendar-full',
			'categories' => 'icon-list4',
			'nav_menu' => 'icon-menu',
			'recent-comments' => 'icon-bubble',
			'recent-posts' => 'icon-reading',
			'search' => 'icon-magnifier',
			'lsvr_post_list' => 'icon-reading',
			'lsvr_post_featured' => 'icon-reading',
			'lsvr_townpress_weather' => 'icon-cloud-sun',
			'lsvr_notices_notice_list' => 'icon-bullhorn',
			'lsvr_notices_notice_categories' => 'icon-list4',
			'lsvr_directory_listing_list' => 'icon-map-marker',
			'lsvr_directory_listing_featured' => 'icon-map-marker',
			'lsvr_directory_listing_categories' => 'icon-list4',
			'lsvr_events_event_list' => 'icon-calendar-full',
			'lsvr_events_event_featured' => 'icon-calendar-full',
			'lsvr_events_event_locations' => 'icon-map-marker',
			'lsvr_events_event_categories' => 'icon-list4',
			'lsvr_events_event_filter' => 'icon-calendar-full',
			'lsvr_galleries_gallery_featured' => 'icon-image',
			'lsvr_galleries_gallery_list' => 'icon-pictures',
			'lsvr_galleries_gallery_categories' => 'icon-list4',
			'lsvr_documents_document_list' => 'icon-file-text-o',
			'lsvr_documents_document_featured' => 'icon-file-text-o',
			'lsvr_documents_document_attachments' => 'icon-file-text-o',
			'lsvr_documents_document_categories' => 'icon-list4',
			'lsvr_people_person_featured' => 'icon-user',
			'lsvr_people_person_list' => 'icon-users',
			'lsvr_people_person_categories' => 'icon-list4',
		);
		$icon_class = ! empty( $default_icons[ $t->id_base ] ) ? $default_icons[ $t->id_base ] : '';

		$instance = wp_parse_args( (array) $instance, array(
			'lsvr_iconclass' => $icon_class,
			'lsvr_boxed' => 'true'
		));

		if ( ! isset( $instance['lsvr_iconclass'] ) ) {
			$instance['lsvr_iconclass'] = null;
		}
		if ( ! isset( $instance['lsvr_boxed'] ) ) {
			$instance['lsvr_boxed'] = null;
		} ?>

		<p>
			<label for="<?php echo esc_attr( $t->get_field_id( 'lsvr_iconclass' ) ); ?>"><?php esc_html_e( 'Icon:', 'townpress' ); ?></label>
			<input type="text" class="widefat" name="<?php echo esc_attr( $t->get_field_name( 'lsvr_iconclass' ) ); ?>"
				id="<?php echo esc_attr( $t->get_field_id( 'lsvr_iconclass' ) ); ?>"
				value="<?php echo esc_attr( $instance[ 'lsvr_iconclass' ] ); ?>">
			<br><small><?php esc_html_e( 'Insert icon class name. For example "icon-magnifier". Please refer to the documentation to learn more about icons.', 'townpress' ); ?></small>
		</p>

		<?php $return = null;
		return array( $t, $return, $instance );

	}
}

add_filter( 'widget_update_callback', 'lsvr_townpress_widget_custom_options_update', 5, 3 );
if ( ! function_exists( 'lsvr_townpress_widget_custom_options_update' ) ) {
	function lsvr_townpress_widget_custom_options_update( $instance, $new_instance, $old_instance ) {

		$instance['lsvr_iconclass'] = sanitize_title( $new_instance['lsvr_iconclass'] );
		return $instance;

	}
}

add_filter( 'dynamic_sidebar_params', 'lsvr_townpress_widget_custom_params' );
if ( ! function_exists( 'lsvr_townpress_widget_custom_params' ) ) {
	function lsvr_townpress_widget_custom_params( $params ) {

		global $wp_registered_widgets;
		$widget_id = ! empty( $params[0]['widget_id'] ) ? $params[0]['widget_id'] : false;
		$widget_obj = ! empty( $wp_registered_widgets[ $widget_id ] ) ? $wp_registered_widgets[ $widget_id ] : false;

		if ( ! empty( $widget_obj['_wo_original_callback'][0]->option_name ) ) {
			$widget_opt = get_option( $widget_obj['_wo_original_callback'][0]->option_name );
		} else if ( ! empty( $widget_obj['callback'][0]->option_name ) ) {
			$widget_opt = get_option( $widget_obj['callback'][0]->option_name );
		}

		if ( ! empty( $widget_obj['params'][0]['number'] ) ) {
			$widget_num = $widget_obj['params'][0]['number'];

			// Add icon
			if ( ! empty( $widget_opt[ $widget_num ]['lsvr_iconclass'] ) ) {
				$params[0]['before_title'] = '<h3 class="widget__title widget__title--has-icon"><i class="widget__title-icon ' . esc_attr( $widget_opt[ $widget_num ]['lsvr_iconclass'] ) . '"></i>';
			}

		}

		return $params;

	}
}

// Add icon att to widget shortcodes
add_filter( 'lsvr_townpress_weather_widget_shortcode_atts', 'lsvr_townpress_add_icon_shortcode_att' );
add_filter( 'lsvr_definition_list_widget_shortcode_atts', 'lsvr_townpress_add_icon_shortcode_att' );
add_filter( 'lsvr_post_featured_widget_shortcode_atts', 'lsvr_townpress_add_icon_shortcode_att' );
add_filter( 'lsvr_post_list_widget_shortcode_atts', 'lsvr_townpress_add_icon_shortcode_att' );
add_filter( 'lsvr_listing_list_widget_shortcode_atts', 'lsvr_townpress_add_icon_shortcode_att' );
add_filter( 'lsvr_listing_featured_widget_shortcode_atts', 'lsvr_townpress_add_icon_shortcode_att' );
add_filter( 'lsvr_document_list_widget_shortcode_atts', 'lsvr_townpress_add_icon_shortcode_att' );
add_filter( 'lsvr_document_featured_widget_shortcode_atts', 'lsvr_townpress_add_icon_shortcode_att' );
add_filter( 'lsvr_document_attachments_widget_shortcode_atts', 'lsvr_townpress_add_icon_shortcode_att' );
add_filter( 'lsvr_event_list_widget_shortcode_atts', 'lsvr_townpress_add_icon_shortcode_att' );
add_filter( 'lsvr_event_featured_widget_shortcode_atts', 'lsvr_townpress_add_icon_shortcode_att' );
add_filter( 'lsvr_gallery_list_widget_shortcode_atts', 'lsvr_townpress_add_icon_shortcode_att' );
add_filter( 'lsvr_gallery_featured_widget_shortcode_atts', 'lsvr_townpress_add_icon_shortcode_att' );
add_filter( 'lsvr_notice_list_widget_shortcode_atts', 'lsvr_townpress_add_icon_shortcode_att' );
add_filter( 'lsvr_person_list_widget_shortcode_atts', 'lsvr_townpress_add_icon_shortcode_att' );
add_filter( 'lsvr_person_featured_widget_shortcode_atts', 'lsvr_townpress_add_icon_shortcode_att' );
if ( ! function_exists( 'lsvr_townpress_add_icon_shortcode_att' ) ) {
	function lsvr_townpress_add_icon_shortcode_att() {

		return array(
			array(
	        	'name' => 'icon',
	            'type' => 'text',
	            'label' => esc_html__( 'Icon', 'townpress' ),
	            'description' => esc_html__( 'Insert icon class name. Please refer to the documentation to learn more about icons.', 'townpress' ),
	            'priority' => 15,
            ),
		);

	}
}

// Add CPT support for author archive page
add_action( 'pre_get_posts', 'lsvr_townpress_author_archive_cpt_support' );
if ( ! function_exists( 'lsvr_townpress_author_archive_cpt_support' ) ) {
	function lsvr_townpress_author_archive_cpt_support( $query ) {
	    if ( $query->is_author() && $query->is_main_query() ) {
	        $query->set( 'post_type', array( 'post', 'lsvr_notice', 'lsvr_document', 'lsvr_gallery' ) );
	    }
	}
}

// Enable post single navigation
add_filter( 'lsvr_townpress_post_single_navigation_enable', 'lsvr_townpress_blog_single_post_navigation_enable' );
if ( ! function_exists( 'lsvr_townpress_blog_single_post_navigation_enable' ) ) {
	function lsvr_townpress_blog_single_post_navigation_enable( $enabled ) {

		if ( lsvr_townpress_is_blog() && true === get_theme_mod( 'blog_single_post_navigation_enable', true ) ) {
			$enabled = true;
		}

		return $enabled;

	}
}

// Check if Gutenberg editor is not disabled
add_filter( 'lsvr_framework_gutenberg_is_disabled', 'lsvr_townpress_gutenberg_is_disabled' );
if ( ! function_exists( 'lsvr_townpress_gutenberg_is_disabled' ) ) {
	function lsvr_townpress_gutenberg_is_disabled( $is_disabled ) {

		$is_disabled = get_theme_mod( 'gutenberg_is_disabled', false );

		return $is_disabled;

	}
}

// Add breadcrumbs meta
add_action( 'lsvr_townpress_breadcrumbs_after', 'lsvr_townpress_add_breadcrumbs_meta', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_add_breadcrumbs_meta' ) ) {
	function lsvr_townpress_add_breadcrumbs_meta() { ?>

		<!-- BREADCRUMBS META DATA : begin -->
		<script type="application/ld+json">
		{
			"@context": "http://schema.org",
			"@type": "BreadcrumbList",
			"itemListElement" : [
				<?php $i = 1;
				$breadcrumbs = lsvr_townpress_get_breadcrumbs();
				foreach ( $breadcrumbs as $breadcrumb ) : ?>
				{
					"@type": "ListItem",
					"position": <?php echo esc_js( $i ); ?>,
					"item": {
						"@id": "<?php echo esc_url( $breadcrumb['url'] ); ?>",
						"name": "<?php echo esc_js( $breadcrumb['label'] ); ?>"
					}
				}<?php if ( $breadcrumb !== end( $breadcrumbs ) ) { echo ','; } ?>
				<?php $i++; endforeach; ?>
			]
		}
		</script>
		<!-- BREADCRUMBS META DATA : end -->

	<?php }
}

// Add blog post meta data
add_action( 'lsvr_townpress_blog_single_bottom', 'lsvr_townpress_add_blog_single_meta', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_add_blog_single_meta' ) ) {
	function lsvr_townpress_add_blog_single_meta() { ?>

		<script type="application/ld+json">
		{
			"@context" : "http://schema.org",
			"@type" : "NewsArticle",
			"headline": "<?php echo esc_js( get_the_title() ); ?>",
			"url" : "<?php echo esc_url( get_permalink() ); ?>",
			"mainEntityOfPage" : "<?php echo esc_url( get_permalink() ); ?>",
		 	"datePublished": "<?php echo esc_js( get_the_time( 'c' ) ); ?>",
		 	"dateModified": "<?php echo esc_js( get_the_modified_date( 'c' ) ); ?>",
		 	"description": "<?php echo esc_js( get_the_excerpt() ); ?>",
		 	"author": {
		 		"@type" : "person",
		 		"name" : "<?php echo esc_js( get_the_author() ); ?>",
		 		"url" : "<?php esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"
		 	},
		 	"publisher" : {
		 		"@id" : "<?php echo esc_url( home_url() ); ?>#WebSitePublisher"
		 	}

		 	<?php if ( lsvr_townpress_has_post_terms( get_the_ID(), 'post_tag' ) ) : ?>
			,"keywords": "<?php echo esc_js( implode( ',', lsvr_townpress_get_post_term_names( get_the_ID(), 'post_tag' ) ) ); ?>"
		 	<?php endif; ?>

			<?php if ( has_post_thumbnail() ) : ?>
		 	,"image": {
		 		"@type" : "ImageObject",
		 		"url" : "<?php the_post_thumbnail_url( 'full' ); ?>",
		 		"width" : "<?php echo esc_js( lsvr_townpress_get_image_width( get_post_thumbnail_id( get_the_ID() ), 'full' ) ); ?>",
		 		"height" : "<?php echo esc_js( lsvr_townpress_get_image_height( get_post_thumbnail_id( get_the_ID() ), 'full' ) ); ?>",
		 		"thumbnailUrl" : "<?php the_post_thumbnail_url( 'thumbnail' ); ?>"
		 	}
		 	<?php endif; ?>

		}
		</script>

	<?php }
}

// Add site meta data
add_action( 'wp_footer', 'lsvr_townpress_add_site_meta', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_add_site_meta' ) ) {
	function lsvr_townpress_add_site_meta() { ?>

		<?php // Get URLs of social links and email address
		$social_links = lsvr_townpress_get_social_links();
		if ( ! empty( $social_links->email ) ) {
			$email = ! empty( $social_links->email->url ) ? $social_links->email->url : '';
			unset( $social_links->email );
		} ?>

		<script type="application/ld+json">
		{
			"@context" : "http://schema.org",
			"@type" : "WebSite",
			"name" : "<?php bloginfo( 'name' ); ?>",
			"url" : "<?php echo esc_url( home_url() ); ?>",
			"description" : "<?php bloginfo( 'description' ); ?>",
		 	"publisher" : {

		 		"@id" : "<?php echo esc_url( home_url() ); ?>#WebSitePublisher",
		 		"@type" : "Organization",
		 		"name" : "<?php echo esc_js( get_bloginfo('name') ); ?>",
		 		"url" : "<?php echo esc_url( home_url() ); ?>"

				<?php if ( ! empty( $email ) ) : ?>
				,"contactPoint": {
			 		"@type": "ContactPoint",
			 		"contactType": "customer service",
			 		"url": "<?php echo esc_url( home_url() ); ?>",
			 		"email": "<?php echo esc_js( $email ); ?>"
			 	}
				<?php endif; ?>

		 		<?php if ( has_custom_logo() ) : ?>
		 		,"logo" : {
		 			"@type" : "ImageObject",
		 			"url" : "<?php echo esc_url( lsvr_townpress_get_image_url( get_theme_mod( 'custom_logo' ) ) ); ?>",
					"width" : "<?php echo esc_attr( lsvr_townpress_get_image_width( get_theme_mod( 'custom_logo' ) ) ); ?>",
					"height" : "<?php echo esc_attr( lsvr_townpress_get_image_height( get_theme_mod( 'custom_logo' ) ) ); ?>"
		 		}
		 		<?php endif; ?>

				<?php if ( ! empty( $social_links ) ) : ?>
				,"sameAs" : [
					<?php foreach( $social_links as $social ) : if ( ! empty( $social->url ) ) : ?>
			    		"<?php echo esc_url( $social->url ); ?>"<?php if ( $social !== end( $social_links ) ) { echo ','; } ?>
					<?php endif; endforeach; ?>
			  	]
			  	<?php endif; ?>

		 	},
		 	"potentialAction": {
		    	"@type" : "SearchAction",
		    	"target" : "<?php echo esc_url( home_url() ); ?>/?s={search_term}",
		    	"query-input": "required name=search_term"
		    }
		}
		</script>

	<?php }
}

?>