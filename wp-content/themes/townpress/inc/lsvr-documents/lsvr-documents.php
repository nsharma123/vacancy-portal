<?php

// Include additional files
require_once( get_template_directory() . '/inc/lsvr-documents/classes/lsvr-townpress-document-categorized-attachments.php' );
require_once( get_template_directory() . '/inc/lsvr-documents/actions.php' );
require_once( get_template_directory() . '/inc/lsvr-documents/frontend-functions.php' );
require_once( get_template_directory() . '/inc/lsvr-documents/customizer-config.php' );

// Is document page
if ( ! function_exists( 'lsvr_townpress_is_document' ) ) {
	function lsvr_townpress_is_document() {

		if ( is_post_type_archive( 'lsvr_document' ) || is_tax( 'lsvr_document_cat' ) || is_tax( 'lsvr_document_tag' ) ||
			is_singular( 'lsvr_document' ) ) {
			return true;
		} else {
			return false;
		}

	}
}

// Get document archive layout
if ( ! function_exists( 'lsvr_townpress_get_document_archive_layout' ) ) {
	function lsvr_townpress_get_document_archive_layout() {

		$path_prefix = 'template-parts/lsvr_document/archive-layout-';

		// Get layout from Customizer
		if ( ! empty( locate_template( $path_prefix . get_theme_mod( 'lsvr_document_archive_layout', 'default' ) . '.php' ) ) ) {
			return get_theme_mod( 'lsvr_document_archive_layout', 'default' );
		}

		// Default layout
		else {
			return 'default';
		}

	}
}

// Get document archive title
if ( ! function_exists( 'lsvr_townpress_get_document_archive_title' ) ) {
	function lsvr_townpress_get_document_archive_title() {

		return get_theme_mod( 'lsvr_document_archive_title', esc_html__( 'Documents', 'townpress' ) );

	}
}

// Get document attachments
if ( ! function_exists( 'lsvr_townpress_get_document_attachments' ) ) {
	function lsvr_townpress_get_document_attachments( $post_id ) {
		if ( function_exists( 'lsvr_documents_get_document_attachments' ) ) {

			return lsvr_documents_get_document_attachments( $post_id );

		}
	}
}

// Has document attachments
if ( ! function_exists( 'lsvr_townpress_has_document_attachments' ) ) {
	function lsvr_townpress_has_document_attachments( $post_id ) {

		$attachments = lsvr_townpress_get_document_attachments( $post_id );
		return ! empty( $attachments ) ? true : false;

	}
}

// Get document attachments of current archive page
if ( ! function_exists( 'lsvr_townpress_get_document_archive_attachments' ) ) {
	function lsvr_townpress_get_document_archive_attachments() {

        // Main archive
        if ( is_post_type_archive( 'lsvr_document' ) ) {

	        $document_ids_args = array(
	        	'post_type' => 'lsvr_document',
	            'posts_per_page' => 1000,
	            'fields' => 'ids',
	            'has_password' => false,
	            'suppress_filters' => false,
	            'tax_query' => array(
	                array(
	                    'taxonomy' => 'lsvr_document_cat',
	                    'terms' => get_terms( 'lsvr_document_cat', array( 'fields' => 'ids'  ) ),
	                    'operator' => 'NOT IN',
	                )
	            ),
	        );

        }

        // Category or tag archive
        else if ( is_tax( 'lsvr_document_cat' ) || is_tax( 'lsvr_document_tag' ) ) {

        	$taxonomy = is_tax( 'lsvr_document_cat' ) ? 'lsvr_document_cat' : 'lsvr_document_tag';
	        $document_ids_args = array(
	            'posts_per_page' => 1000,
	            'post_type' => 'lsvr_document',
	            'fields' => 'ids',
	            'tax_query' => array(
	                array(
	                    'taxonomy' => $taxonomy,
	                    'terms' => get_queried_object_id(),
	                    'operator' => 'IN',
	                    'include_children' => false,
	                )
	            ),
	        );

        }

        // Order of posts
        $posts_order = get_theme_mod( 'lsvr_document_archive_attachments_order', 'filename_asc' );
        if ( 'date_asc' === $posts_order ) {
            $document_ids_args['order'] = 'ASC';
            $document_ids_args['orderby'] = 'date';
        }
        else if ( 'date_desc' === $posts_order ) {
            $document_ids_args['order'] = 'DESC';
            $document_ids_args['orderby'] = 'date';
        }

        // Get posts
        $document_ids = get_posts( $document_ids_args );

        // Get all attachments from documents not belonging to any category
        $attachments = array();
        if ( ! empty( $document_ids ) ) {
            foreach ( $document_ids as $document_id ) {
                $document_attachments = lsvr_documents_get_document_attachments( $document_id );
                if ( ! empty( $document_attachments ) ) {
                	foreach( $document_attachments as $attachment ) {
                		array_push( $attachments, $attachment );
                	}
                }
            }
        }

        // If documents order is set to 'title', sort attachments by filename
        $attachments_order = get_theme_mod( 'lsvr_document_archive_attachments_order', 'filename_asc' );
        if ( ! empty( $attachments ) ) {

            if ( 'filename_asc' === $attachments_order ) {
                usort( $attachments, function( $a, $b ) {
                    return strcmp( $a['filename'], $b['filename'] );
                });
            }
            else if ( 'filename_desc' === $attachments_order ) {
                usort( $attachments, function( $a, $b ) {
                    return strcmp( $b['filename'], $a['filename'] );
                });
            }
            else if ( 'title_asc' === $attachments_order ) {
                usort( $attachments, function( $a, $b ) {
                    return strcmp( $a['title'], $b['title'] );
                });
            }
            else if ( 'title_desc' === $attachments_order ) {
                usort( $attachments, function( $a, $b ) {
                    return strcmp( $b['title'], $a['title'] );
                });
            }

        }

        return $attachments;

	}
}

?>