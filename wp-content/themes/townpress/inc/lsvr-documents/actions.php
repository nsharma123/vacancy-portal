<?php

// Page title
add_filter( 'document_title_parts', 'lsvr_townpress_document_title', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_document_title' ) ) {
	function lsvr_townpress_document_title( $title ) {

		if ( is_post_type_archive( 'lsvr_document' ) ) {
			$title['title'] = sanitize_text_field( lsvr_townpress_get_document_archive_title() );
		}
		return $title;

	}
}

// Breadcrumbs
add_filter( 'lsvr_townpress_add_to_breadcrumbs', 'lsvr_townpress_document_breadcrumbs', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_document_breadcrumbs' ) ) {
	function lsvr_townpress_document_breadcrumbs( $breadcrumbs ) {

		if ( lsvr_townpress_is_document() && ! is_post_type_archive( 'lsvr_document' ) ) {
			$breadcrumbs = array(
				array(
					'url' => get_post_type_archive_link( 'lsvr_document' ),
					'label' => lsvr_townpress_get_document_archive_title(),
				),
			);
		}
		return $breadcrumbs;

	}
}

// Archive pre_get_posts actions
add_action( 'pre_get_posts', 'lsvr_townpress_document_archive_pre_get_posts' );
if ( ! function_exists( 'lsvr_townpress_document_archive_pre_get_posts' ) ) {
	function lsvr_townpress_document_archive_pre_get_posts( $query ) {
		if ( ! is_admin() && $query->is_main_query() && ( $query->is_post_type_archive( 'lsvr_document' ) ||
			$query->is_tax( 'lsvr_document_cat' ) || $query->is_tax( 'lsvr_document_tag' ) ) ) {

			// Posts per page
			if ( 0 === get_theme_mod( 'lsvr_document_archive_posts_per_page', 20 ) ) {
				$query->set( 'posts_per_page', 1000 );
			} else {
				$query->set( 'posts_per_page', esc_attr( get_theme_mod( 'lsvr_document_archive_posts_per_page', 20 ) ) );
			}

			// Order
			$order = get_theme_mod( 'lsvr_document_archive_posts_order', 'date_desc' );
			if ( 'title_asc' === $order ) {
				$query->set( 'orderby', 'title' );
				$query->set( 'order', 'ASC' );
			}
			else if ( 'title_desc' === $order ) {
				$query->set( 'orderby', 'title' );
				$query->set( 'order', 'DESC' );
			}
			else if ( 'date_asc' === $order ) {
				$query->set( 'orderby', 'date' );
				$query->set( 'order', 'ASC' );
			}
			else {
				$query->set( 'orderby', 'date' );
				$query->set( 'order', 'DESC' );
			}

			// Exclude posts from certain categories
    		$excluded_categories = array();
    		$excluded_categories_data = get_theme_mod( 'lsvr_document_excluded_categories', '' );
    		if ( ! empty( $excluded_categories_data ) ) {
    			$excluded_categories_arr = array_map( 'trim', explode( ',', $excluded_categories_data ) );
    			foreach ( $excluded_categories_arr as $excluded ) {
    				if ( is_numeric( $excluded ) ) {
    					array_push( $excluded_categories, (int) $excluded );
    				} else {
    					 $term = get_term_by( 'slug', $excluded, 'lsvr_document_cat' );
    					 if ( ! empty( $term->term_id ) ) {
    					 	array_push( $excluded_categories, $term->term_id );
    					 }
    				}
    			}
    		}
    		if ( ! empty( $excluded_categories ) ) {
				$query->set( 'tax_query', array(
					array(
						'taxonomy' => 'lsvr_document_cat',
						'field' => 'term_id',
						'terms' => $excluded_categories,
						'operator' => 'NOT IN',
					)
				));
    		}

		}
	}
}

// Left sidebar ID
add_filter( 'lsvr_townpress_sidebar_left_id', 'lsvr_townpress_document_sidebar_left_id', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_document_sidebar_left_id' ) ) {
	function lsvr_townpress_document_sidebar_left_id( $sidebar_id ) {

		// Single
		if ( is_singular( 'lsvr_document' ) ) {
			$sidebar_id = get_theme_mod( 'lsvr_document_single_sidebar_left_id', 'lsvr-townpress-default-sidebar-left' );
		}

		// Archive
		else if ( lsvr_townpress_is_document() ) {
			$sidebar_id = get_theme_mod( 'lsvr_document_archive_sidebar_left_id', 'lsvr-townpress-default-sidebar-left' );
		}

		return $sidebar_id;

	}
}

// Right sidebar ID
add_filter( 'lsvr_townpress_sidebar_right_id', 'lsvr_townpress_document_sidebar_right_id', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_document_sidebar_right_id' ) ) {
	function lsvr_townpress_document_sidebar_right_id( $sidebar_id ) {

		// Single
		if ( is_singular( 'lsvr_document' ) ) {
			$sidebar_id = get_theme_mod( 'lsvr_document_single_sidebar_right_id', 'lsvr-townpress-default-sidebar-right' );
		}

		// Archive
		else if ( lsvr_townpress_is_document() ) {
			$sidebar_id = get_theme_mod( 'lsvr_document_archive_sidebar_right_id', 'lsvr-townpress-default-sidebar-right' );
		}

		return $sidebar_id;

	}
}

// Add post meta data
add_action( 'lsvr_townpress_document_single_bottom', 'lsvr_townpress_add_document_single_meta', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_add_document_single_meta' ) ) {
	function lsvr_townpress_add_document_single_meta() { ?>

		<script type="application/ld+json">
		{
			"@context" : "http://schema.org",
			"@type" : "DataCatalog",
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

		 	<?php if ( lsvr_townpress_has_post_terms( get_the_ID(), 'lsvr_document_tag' ) ) : ?>
			,"keywords": "<?php echo esc_js( implode( ',', lsvr_townpress_get_post_term_names( get_the_ID(), 'lsvr_document_tag' ) ) ); ?>"
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

		 	<?php if ( lsvr_townpress_has_document_attachments( get_the_ID() ) ) : ?>
		 		,"associatedMedia" : [
		 		<?php $i = 1; foreach ( lsvr_townpress_get_document_attachments( get_the_ID() ) as $attachment ) : ?>
					{
			 			"@type" : "DataDownload",
			 			"url" : "<?php echo esc_url( $attachment['url'] ); ?>"
			 		}<?php if ( $i < count( lsvr_townpress_get_document_attachments( get_the_ID() ) ) ) { echo ','; } ?>
		 		<?php $i++; endforeach; ?>
		 		]
		 	<?php endif; ?>

		}
		</script>

	<?php }
}

?>