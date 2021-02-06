<?php
/**
 * Main function to retrieve galleries.
 *
 * @param array $args {
 *		Optional. An array of arguments. If not defined, function will return all galleries
 *
 *		@type int|array		$gallery_id		Single ID or array of IDs of lsvr_gallery post(s).
 *											Only these galleries will be returned.
 *											Leave blank to retrieve all lsvr_gallery posts.
 *
 *		@type int			$limit			Max number of galleries to retrieve.
 *
  *		@type int|array		$category		Category or categories from which to retrieve galleries.
 *
 *		@type string		$orderby		Set how to order galleries.
 *											Accepts standard values for orderby argument in WordPress get_posts function.
 *
 *		@type string		$order			Set order of returned galleries as ascending or descending.
 *											Default 'DESC'. Accepts 'ASC', 'DESC'.
 *
 *		@type bool			$return_meta	If enabled, important gallery meta data will be returned as well.
 *											Default 'false'.
 * }
 * @return array 	Array with all gallery posts.
 */
if ( ! function_exists( 'lsvr_galleries_get' ) ) {
	function lsvr_galleries_get( $args = array() ) {

		// Gallery ID
		if ( ! empty( $args['gallery_id'] ) ) {
			if ( is_array( $args['gallery_id'] ) ) {
				$gallery_id = array_map( 'intval', $args['gallery_id'] );
			} else {
				$gallery_id = array( (int) $args['gallery_id'] );
			}
		} else {
			$gallery_id = false;
		}

		// Get number of galleries
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

		// Get orderby of galleries
		if ( ! empty( $args['orderby'] ) ) {
			$orderby = esc_attr( $args['orderby'] );
		} else {
			$orderby = 'date';
		}

		// Get order of galleries
		$order = ! empty( $args['order'] ) && 'ASC' === strtoupper( $args['order'] ) ? 'ASC' : 'DESC';

		// Check if meta data should be returned as well
		$return_meta = ! empty( $args['return_meta'] ) && true === $args['return_meta'] ? true : false;

		// Tax query
		if ( ! empty( $category ) ) {
			$tax_query = array(
				array(
					'taxonomy' => 'lsvr_gallery_cat',
					'field' => 'term_id',
					'terms' => $category,
				),
			);
		} else {
			$tax_query = false;
		}

		// Get all gallery posts
		$gallery_posts = get_posts(array(
			'post_type' => 'lsvr_gallery',
			'post__in' => $gallery_id,
			'posts_per_page' => $limit,
			'orderby' => $orderby,
			'order' => $order,
			'tax_query' => $tax_query,
			'suppress_filters' => false,
		));

		// Add gallery posts to $return
		if ( ! empty( $gallery_posts ) ) {
			$return = array();
			foreach ( $gallery_posts as $gallery_post ) {
				if ( ! empty( $gallery_post->ID ) ) {
					$return[ $gallery_post->ID ]['post'] = $gallery_post;
				}
			}
		}

		// Add meta to $return
		if ( ! empty( $return ) && is_array( $return ) && true === $return_meta ) {
			foreach ( array_keys( $return ) as $post_id ) {

				// Get gallery image IDs from meta
				$image_ids = get_post_meta( $post_id, 'lsvr_gallery_images', true );
				$image_ids_arr = ! empty( $image_ids ) ? explode( ',', $image_ids ) : false;

				// Add gallery image IDs into $return
				if ( ! empty( $image_ids_arr ) ) {
					$return[ $post_id ]['images'] = array_map( 'intval', $image_ids_arr );
				}

			}
		}

		// Return galleries
		return ! empty( $return ) ? $return : false;

	}
}

/**
 * Return images of a single gallery.
 *
 * @param int 	$gallery_id		Post ID of lsv_gallery post.
 *
 * @return array 	Array with single gallery post data.
 */
if ( ! function_exists( 'lsvr_galleries_get_gallery_images' ) ) {
	function lsvr_galleries_get_gallery_images( $gallery_id ) {

		// Get gallery ID
		$gallery_id = empty( $gallery_id ) ? get_the_ID() : $gallery_id;

		// Get gallery images from meta
		$gallery_image_ids = explode( ',', get_post_meta( $gallery_id, 'lsvr_gallery_images', true ) );

		// Prepare array for gallery images data
		$gallery_images = array();

		// Parse all gallery images
		if ( ! empty( $gallery_image_ids ) ) {
			foreach ( $gallery_image_ids as $image_id ) {

				$fullsize_img = (array) wp_get_attachment_image_src( $image_id, 'full' );
				$fullsize_url = reset( $fullsize_img );
				$fullsize_width = ! empty( $fullsize_img[1] ) ? $fullsize_img[1] : '';
				$fullsize_height = ! empty( $fullsize_img[2] ) ? $fullsize_img[2] : '';
				$thumb_img = (array) wp_get_attachment_image_src( $image_id, 'thumbnail' );
				$thumb_url = reset( $thumb_img );
				$medium_img = (array) wp_get_attachment_image_src( $image_id, 'medium' );
				$medium_url = reset( $medium_img );
				$large_img = (array) wp_get_attachment_image_src( $image_id, 'large' );
				$large_url = reset( $large_img );

				if ( ! empty( $fullsize_url ) ) {
					$gallery_images[ $image_id ] = array(
						'full_url' => $fullsize_url,
						'full_width' => $fullsize_width,
						'full_height' => $fullsize_height,
						'thumb_url' => $thumb_url,
						'medium_url' => $medium_url,
						'large_url' => $large_url,
						'title' => get_post_field( 'post_title', $image_id ),
						'caption' => get_post_field( 'post_excerpt', $image_id ),
						'alt' => get_post_meta( $image_id, '_wp_attachment_image_alt', true ),
					);
				}

			}
		}

		return $gallery_images;

	}
}

/**
 * Return number of images of a single gallery.
 *
 * @param int 	$gallery_id		Post ID of lsv_gallery post.
 *
 * @return int 	Number of images.
 */
if ( ! function_exists( 'lsvr_galleries_get_gallery_images_count' ) ) {
	function lsvr_galleries_get_gallery_images_count( $gallery_id ) {

		// Get gallery images from meta
		$gallery_image_ids = get_post_meta( $gallery_id, 'lsvr_gallery_images', true );
		$gallery_image_ids = ! empty( $gallery_image_ids ) ? explode( ',', $gallery_image_ids ) : array();

		return count( $gallery_image_ids );

	}
}

/**
 * Return array with gallery thumbnail image data.
 *
 * @param int 	$gallery_id		Post ID of lsv_gallery post.
 *
 * @return array 	Image data.
 */
if ( ! function_exists( 'lsvr_galleries_get_single_thumb' ) ) {
	function lsvr_galleries_get_single_thumb( $gallery_id ) {

		$return = array();

		// Get gallery thumb from post rhumbnail
		if ( has_post_thumbnail( $gallery_id ) ) {
			$image_id = get_post_thumbnail_id( $gallery_id );
		}

		// Get gallery thumb from first gallery image
		else {
			$gallery_image_ids = explode( ',', get_post_meta( $gallery_id, 'lsvr_gallery_images', true ) );
			$image_id = reset( $gallery_image_ids );
		}

		// Get image data
		if ( ! empty( $image_id ) ) {

			// Image URLs
			$return[ 'id' ]	 = $image_id;
			$fullsize_img = (array) wp_get_attachment_image_src( $image_id, 'full' );
			$return[ 'full_url' ] = reset( $fullsize_img );
			$thumb_img = (array) wp_get_attachment_image_src( $image_id, 'thumbnail' );
			$return[ 'thumb_url' ] = reset( $thumb_img );
			$medium_img = (array) wp_get_attachment_image_src( $image_id, 'medium' );
			$return[ 'medium_url' ] = reset( $medium_img );
			$large_img = (array) wp_get_attachment_image_src( $image_id, 'large' );
			$return[ 'large_url' ] = reset( $large_img );

			// Title
			$return['title'] = get_post_field( 'post_title', $image_id );

			// Caption
			$return['caption'] = get_post_field( 'post_excerpt', $image_id );

			// Alt
			$return['alt'] = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

		}

		return $return;

	}
}

?>