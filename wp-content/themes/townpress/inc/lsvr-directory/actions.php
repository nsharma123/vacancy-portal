<?php

// Load directory JS files
add_action( 'lsvr_townpress_load_assets', 'lsvr_townpress_directory_load_js', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_directory_load_js' ) ) {
	function lsvr_townpress_directory_load_js() {

		$version = wp_get_theme( 'townpress' );
		$version = $version->Version;
		$suffix = defined( 'WP_DEBUG' ) && true == WP_DEBUG ? '' : '.min';

		// Google Map
		if ( lsvr_townpress_is_listing() && ! is_singular( 'lsvr_listing' ) &&
			true === get_theme_mod( 'lsvr_listing_archive_map_enable', true ) ) {

			wp_enqueue_script( 'google-markerclusterer', get_template_directory_uri() . '/assets/js/markerclusterer.min.js', false, $version, true );
			wp_enqueue_script( 'google-richmarker', get_template_directory_uri() . '/assets/js/richmarker.min.js', false, $version, true );
			wp_enqueue_script( 'google-infobox', get_template_directory_uri() . '/assets/js/infobox.min.js', false, $version, true );
			wp_enqueue_script( 'lsvr-townpress-directory-map', get_template_directory_uri() . '/assets/js/townpress-ajax-directory-map' . $suffix . '.js', array( 'jquery' ), $version, true );
			wp_localize_script( 'lsvr-townpress-directory-map', 'lsvr_townpress_ajax_directory_map_var', array(
	    		'url' => admin_url( 'admin-ajax.php' ),
	    		'nonce' => wp_create_nonce( 'lsvr-townpress-ajax-directory-map-nonce' ),
			));

		}

	}
}

// Page title
add_filter( 'document_title_parts', 'lsvr_townpress_listing_title', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_listing_title' ) ) {
	function lsvr_townpress_listing_title( $title ) {

		if ( is_post_type_archive( 'lsvr_listing' ) ) {
			$title['title'] = sanitize_text_field( lsvr_townpress_get_listing_archive_title() );
		}
		return $title;

	}
}

// Breadcrumbs
add_filter( 'lsvr_townpress_add_to_breadcrumbs', 'lsvr_townpress_listing_breadcrumbs', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_listing_breadcrumbs' ) ) {
	function lsvr_townpress_listing_breadcrumbs( $breadcrumbs ) {

		if ( lsvr_townpress_is_listing() && ! is_post_type_archive( 'lsvr_listing' ) ) {
			$breadcrumbs = array(
				array(
					'url' => get_post_type_archive_link( 'lsvr_listing' ),
					'label' => lsvr_townpress_get_listing_archive_title(),
				),
			);
		}
		return $breadcrumbs;

	}
}

// Listing archive pre_get_posts actions
add_action( 'pre_get_posts', 'lsvr_townpress_listing_archive_pre_get_posts' );
if ( ! function_exists( 'lsvr_townpress_listing_archive_pre_get_posts' ) ) {
	function lsvr_townpress_listing_archive_pre_get_posts( $query ) {
		if ( ! is_admin() && $query->is_main_query() && ( $query->is_post_type_archive( 'lsvr_listing' ) ||
			$query->is_tax( 'lsvr_listing_cat' ) || $query->is_tax( 'lsvr_listing_tag' ) ) ) {

			// Listing order
			$order = get_theme_mod( 'lsvr_listing_archive_order', 'default' );
			if ( 'date_asc' === $order ) {
				$query->set( 'orderby', 'date' );
				$query->set( 'order', 'ASC' );
			}
			else if ( 'date_desc' === $order ) {
				$query->set( 'orderby', 'date' );
				$query->set( 'order', 'DESC' );
			}
			else if ( 'title_asc' === $order ) {
				$query->set( 'orderby', 'title' );
				$query->set( 'order', 'ASC' );
			}
			else if ( 'title_desc' === $order ) {
				$query->set( 'orderby', 'title' );
				$query->set( 'order', 'DESC' );
			}

			// Posts per page
			if ( 0 === (int) get_theme_mod( 'lsvr_listing_archive_posts_per_page', 12 ) ) {
				$query->set( 'posts_per_page', 1000 );
			} else {
				$query->set( 'posts_per_page', esc_attr( get_theme_mod( 'lsvr_listing_archive_posts_per_page', 12 ) ) );
			}

		}
	}
}


// Left sidebar ID
add_filter( 'lsvr_townpress_sidebar_left_id', 'lsvr_townpress_listing_sidebar_left_id', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_listing_sidebar_left_id' ) ) {
	function lsvr_townpress_listing_sidebar_left_id( $sidebar_id ) {

		// Single
		if ( is_singular( 'lsvr_listing' ) ) {
			$sidebar_id = get_theme_mod( 'lsvr_listing_single_sidebar_left_id', 'lsvr-townpress-default-sidebar-left' );
		}

		// Archive
		else if ( lsvr_townpress_is_listing() ) {
			$sidebar_id = get_theme_mod( 'lsvr_listing_archive_sidebar_left_id', 'lsvr-townpress-default-sidebar-left' );
		}

		return $sidebar_id;

	}
}

// Right sidebar ID
add_filter( 'lsvr_townpress_sidebar_right_id', 'lsvr_townpress_listing_sidebar_right_id', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_listing_sidebar_right_id' ) ) {
	function lsvr_townpress_listing_sidebar_right_id( $sidebar_id ) {

		// Single
		if ( is_singular( 'lsvr_listing' ) ) {
			$sidebar_id = get_theme_mod( 'lsvr_listing_single_sidebar_right_id', 'lsvr-townpress-default-sidebar-right' );
		}

		// Archive
		else if ( lsvr_townpress_is_listing() ) {
			$sidebar_id = get_theme_mod( 'lsvr_listing_archive_sidebar_right_id', 'lsvr-townpress-default-sidebar-right' );
		}

		return $sidebar_id;

	}
}

// Add post meta data
add_action( 'lsvr_townpress_listing_single_bottom', 'lsvr_townpress_add_listing_single_meta', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_add_listing_single_meta' ) ) {
	function lsvr_townpress_add_listing_single_meta() {

		if ( true === get_post_meta( get_the_ID(), 'lsvr_listing_meta_enable', true ) || 'true' === get_post_meta( get_the_ID(), 'lsvr_listing_meta_enable', true ) ) { ?>

			<?php $social_links = lsvr_townpress_get_listing_social_links( get_the_ID() );
			$postal_address = lsvr_townpress_get_listing_meta_postal_address( get_the_ID() ); ?>

			<script type="application/ld+json">
			{
				"@context" : "http://schema.org",
				"@type" : "<?php echo esc_js( lsvr_townpress_get_listing_meta_business_type( get_the_ID() ) ); ?>",
				"name": "<?php echo esc_js( get_the_title() ); ?>",
				"url" : "<?php echo esc_url( get_permalink() ); ?>",
				"mainEntityOfPage" : "<?php echo esc_url( get_permalink() ); ?>",
			 	"description" : "<?php echo esc_js( get_the_excerpt() ); ?>"

			 	<?php if ( lsvr_townpress_has_listing_map_location( get_the_ID() ) ) : ?>
			 	,"hasMap": "<?php echo esc_url( lsvr_townpress_get_listing_map_link( get_the_ID() ) ); ?>"
			 	<?php endif; ?>

				<?php if ( lsvr_townpress_has_listing_phone( get_the_ID() ) ) : ?>
				,"telephone" : "<?php echo esc_js( lsvr_townpress_get_listing_phone( get_the_ID() ) ); ?>"
				<?php endif; ?>

				<?php if ( ! empty( $postal_address ) ) : ?>
				,"address": {
					"@type": "PostalAddress"

					<?php if ( ! empty( $postal_address['country'] ) ) : ?>
					,"addressCountry": "<?php echo esc_js( $postal_address['country'] ); ?>"
					<?php endif; ?>

					<?php if ( ! empty( $postal_address['locality'] ) ) : ?>
					,"addressLocality": "<?php echo esc_js( $postal_address['locality'] ); ?>"
					<?php endif; ?>

					<?php if ( ! empty( $postal_address['region'] ) ) : ?>
					,"addressRegion": "<?php echo esc_js( $postal_address['region'] ); ?>"
					<?php endif; ?>

					<?php if ( ! empty( $postal_address['postalcode'] ) ) : ?>
					,"postalCode": "<?php echo esc_js( $postal_address['postalcode'] ); ?>"
					<?php endif; ?>

					<?php if ( ! empty( $postal_address['street'] ) ) : ?>
					,"streetAddress": "<?php echo esc_js( $postal_address['street'] ); ?>"
					<?php endif; ?>

				}
				<?php endif; ?>

				<?php if ( lsvr_townpress_has_listing_map_location( get_the_ID() ) ) : ?>
				,"geo": {
					"@type": "GeoCoordinates",
					"latitude": "<?php echo esc_js( lsvr_townpress_get_listing_map_location( get_the_ID(), 'latitude' ) ); ?>",
					"longitude": "<?php echo esc_js( lsvr_townpress_get_listing_map_location( get_the_ID(), 'longitude' ) ); ?>"
				}
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

				<?php if ( lsvr_townpress_has_listing_social_links( get_the_ID() ) ) : ?>
				,"sameAs" : [
					<?php foreach ( $social_links as $social_link ) : ?>
			    		"<?php echo esc_url( $social_link ); ?>"<?php if ( $social_link !== end( $social_links ) ) { echo ','; } ?>
					<?php ; endforeach; ?>
			  	]
			  	<?php endif; ?>

			}
			</script>

		<?php }

	}
}

?>