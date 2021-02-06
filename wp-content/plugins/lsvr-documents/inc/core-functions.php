<?php
/**
 * Main function to retrieve documents.
 *
 * @param array $args {
 *		Optional. An array of arguments. If not defined, function will return all documents.
 *
 *		@type int|array		$document_id	Single ID or array of IDs of lsvr_document post(s).
 *											Only these documents will be returned.
 *											Leave blank to retrieve all lsvr_document posts.
 *
 *		@type int			$limit			Max number of documents to retrieve.
 *
 *		@type int|array		$category		Category or categories from which to retrieve documents.
 *
 *		@type string		$orderby		Set how to order documents.
 *											Accepts standard values for orderby argument in WordPress get_posts function.
 *
 *		@type string		$order			Set order of returned documents as ascending or descending.
 *											Default 'DESC'. Accepts 'ASC', 'DESC'.
 *
 *		@type bool			$return_meta	If enabled, important document meta data will be returned as well.
 *											Default 'false'.
 * }
 * @return array 	Array with all document posts.
 */
if ( ! function_exists( 'lsvr_documents_get' ) ) {
	function lsvr_documents_get( $args = array() ) {

		// Document ID
		if ( ! empty( $args['document_id'] ) ) {
			if ( is_array( $args['document_id'] ) ) {
				$document_id = array_map( 'intval', $args['document_id'] );
			} else {
				$document_id = array( (int) $args['document_id'] );
			}
		} else {
			$document_id = false;
		}

		// Get number of documents
		if ( ! empty( $args['limit'] ) && is_numeric( $args['limit'] ) ) {
			$limit = (int) $args['limit'];
		} else {
			$limit = 1000;
		}

		// Get category
		if ( ! empty( $args['category'] ) ) {
			if ( is_array( $args['category'] ) ) {
				$category = array_map( 'intval', $args['category'] );
			} else {
				$category = array( (int) $args['category'] );
			}
		} else {
			$category = false;
		}

		// Get orderby of documents
		if ( ! empty( $args['orderby'] ) ) {
			$orderby = esc_attr( $args['orderby'] );
		} else {
			$orderby = 'date';
		}

		// Get order of documents
		$order = ! empty( $args['order'] ) && 'ASC' === strtoupper( $args['order'] ) ? 'ASC' : 'DESC';

		// Check if meta data should be returned as well
		$return_meta = ! empty( $args['return_meta'] ) && true === $args['return_meta'] ? true : false;

		// Tax query
		if ( ! empty( $category ) ) {
			$tax_query = array(
				array(
					'taxonomy' => 'lsvr_document_cat',
					'field' => 'term_id',
					'terms' => $category,
				),
			);
		} else {
			$tax_query = false;
		}

		// Get all document posts
		$document_posts = get_posts(array(
			'post_type' => 'lsvr_document',
			'post__in' => $document_id,
			'posts_per_page' => $limit,
			'orderby' => $orderby,
			'order' => $order,
			'tax_query' => $tax_query,
		));

		// Add document posts to $return
		if ( ! empty( $document_posts ) ) {
			$return = array();
			foreach ( $document_posts as $document_post ) {
				if ( ! empty( $document_post->ID ) ) {
					$return[ $document_post->ID ]['post'] = $document_post;
				}
			}
		}

		// Add meta to $return
		if ( ! empty( $return ) && is_array( $return ) && true === $return_meta ) {
			foreach ( array_keys( $return ) as $post_id ) {

				// Get local attachment IDs from meta
				$local_attachment_ids = get_post_meta( $post_id, 'lsvr_document_local_attachments', true );
				$local_attachment_ids_arr = ! empty( $local_attachment_ids ) ? explode( ',', $local_attachment_ids ) : false;
				if ( ! empty( $local_attachment_ids_arr ) ) {
					$return[ $post_id ]['local_attachments'] = array_map( 'intval', $local_attachment_ids_arr );
				}

				// Get external attachment IDs from meta
				$external_attachments = get_post_meta( $post_id, 'lsvr_document_external_attachments', true );
				$external_attachments_arr = ! empty( $external_attachments ) ? explode( '|', $external_attachments ) : false;
				if ( ! empty( $external_attachments_arr ) ) {
					$return[ $post_id ]['external_attachments'] = array_map( 'urldecode', $external_attachments_arr );
				}

			}
		}

		// Return documents
		return ! empty( $return ) ? $return : false;

	}
}

/**
 * Get document attachments.
 *
 * @param int 		$document_id	lsvr_document post ID.
 *
 * @return array 	Array with document attachments.
 */
if ( ! function_exists( 'lsvr_documents_get_document_attachments' ) ) {
	function lsvr_documents_get_document_attachments( $post_id ) {

		$return = array();

		// Local attachments
		$local_attachment_meta = get_post_meta( $post_id, 'lsvr_document_local_attachments', true );
		$local_attachment_ids = ! empty( $local_attachment_meta ) ? array_map( 'intval', explode( ',', $local_attachment_meta ) ) : false;
		if ( ! empty( $local_attachment_ids ) ) {

			foreach ( $local_attachment_ids as $attachment_id ) {

				$filename = basename( get_attached_file( $attachment_id ) );
				$filesize = (int) filesize( get_attached_file( $attachment_id ) );
				$filesize = $filesize > 0 ? lsvr_documents_convert_filesize( $filesize ) : false;

				array_push( $return, array(
					'id' => $attachment_id,
					'title' => get_the_title( $attachment_id ),
					'filename' => $filename,
					'url' => wp_get_attachment_url( $attachment_id ),
					'extension' => pathinfo( $filename, PATHINFO_EXTENSION ),
					'filetype' => lsvr_documents_get_attachment_filetype( pathinfo( $filename, PATHINFO_EXTENSION ) ),
					'filesize' => $filesize,
					'external' => false,
				));

			}
		}

		// External attachments
		$external_attachments_meta = get_post_meta( $post_id, 'lsvr_document_external_attachments', true );
		$external_attachment_urls = ! empty( $external_attachments_meta ) ? explode( '|', $external_attachments_meta ) : false;
		if ( ! empty( $external_attachment_urls ) ) {

			foreach ( $external_attachment_urls as $attachment_url ) {

				$filename = basename( $attachment_url );

				array_push( $return, array(
					'title' => $filename,
					'filename' => $filename,
					'url' => $attachment_url,
					'extension' => pathinfo( $filename, PATHINFO_EXTENSION ),
					'filetype' => lsvr_documents_get_attachment_filetype( pathinfo( $filename, PATHINFO_EXTENSION ) ),
					'external' => true,
				));

			}

		}

		return $return;

	}
}

/**
 * Get file type based on extension.
 *
 * @param string 	$extension	File extension.
 *
 * @return string 	File type.
 */
if ( ! function_exists( 'lsvr_documents_get_attachment_filetype' ) ) {
	function lsvr_documents_get_attachment_filetype( $extension ) {

		$image = array( 'gif', 'tiff', 'bmp', 'jpg', 'jpeg', 'png' );
		$audio = array( 'aac', 'ogg', 'm4a', 'flac', 'mp3', 'wav' );
		$video = array( 'mkv', 'webm', 'flv', 'wmv', 'mp4', 'mpg', 'mpeg', 'm4v', '3gp', 'avi', 'mov' );

		if ( in_array( $extension, $image ) ) {
			return 'image';
		}
		elseif ( in_array( $extension, $audio ) ) {
			return 'audio';
		}
		elseif ( in_array( $extension, $video ) ) {
			return 'video';
		}
		else {
			return $extension;
		}

	}
}

/**
 * Convert bytes.
 *
 * @param int 		$bytes	Number of bytes.
 *
 * @return string 	Converted value.
 */
if ( ! function_exists( 'lsvr_documents_convert_filesize' ) ) {
	function lsvr_documents_convert_filesize( $bytes ) {

		$bytes = floatval( $bytes );
		$bytes_arr = array(
			0 => array(
				'unit' => esc_html__( '%s TB', 'lsvr-documents' ),
				'value' => pow( 1024, 4 )
			),
			1 => array(
				'unit' => esc_html__( '%s GB', 'lsvr-documents' ),
				'value' => pow( 1024, 3 )
			),
			2 => array(
				'unit' => esc_html__( '%s MB', 'lsvr-documents' ),
				'value' => pow( 1024, 2 )
			),
			3 => array(
				'unit' => esc_html__( '%s kB', 'lsvr-documents' ),
				'value' => 1024
			),
			4 => array(
				'unit' => esc_html__( '%s B', 'lsvr-documents' ),
				'value' => 1
			),
		);

		foreach( $bytes_arr as $item ) {
			if ( $bytes >= $item['value'] ) {
				$result = $bytes / $item['value'];
				$result = str_replace( '.', ',', strval( round( $result, 0 ) ) );
				$result = sprintf( $item['unit'], $result );
				break;
			}
		}
		return $result;

	}
}

?>