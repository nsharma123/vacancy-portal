<?php
/**
 * Gallery post type
 */
if ( ! class_exists( 'Lsvr_CPT_Gallery' ) && class_exists( 'Lsvr_CPT' ) ) {
    class Lsvr_CPT_Gallery extends Lsvr_CPT {

		public function __construct() {

			parent::__construct( array(
				'id' => 'lsvr_gallery',
				'wp_args' => array(
					'labels' => array(
						'name' => esc_html__( 'Galleries', 'lsvr-galleries' ),
						'singular_name' => esc_html__( 'Gallery', 'lsvr-galleries' ),
						'add_new' => esc_html__( 'Add New Gallery', 'lsvr-galleries' ),
						'add_new_item' => esc_html__( 'Add New Gallery', 'lsvr-galleries' ),
						'edit_item' => esc_html__( 'Edit Gallery', 'lsvr-galleries' ),
						'new_item' => esc_html__( 'Add New Gallery', 'lsvr-galleries' ),
						'view_item' => esc_html__( 'View Gallery', 'lsvr-galleries' ),
						'search_items' => esc_html__( 'Search galleries', 'lsvr-galleries' ),
						'not_found' => esc_html__( 'No galleries found', 'lsvr-galleries' ),
						'not_found_in_trash' => esc_html__( 'No galleries found in trash', 'lsvr-galleries' ),
					),
					'exclude_from_search' => false,
					'public' => true,
					'supports' => array( 'title', 'editor', 'custom-fields', 'revisions', 'excerpt', 'thumbnail' ),
					'capability_type' => 'post',
					'rewrite' => array( 'slug' => 'galleries' ),
					'menu_position' => 5,
					'has_archive' => true,
					'show_in_nav_menus' => true,
					'show_in_rest' => true,
					'menu_icon' => 'dashicons-format-gallery',
				),
			));

			// Add Category taxonomy
			$this->add_taxonomy(array(
				'id' => 'lsvr_gallery_cat',
				'wp_args' => array(
					'labels' => array(
						'name' => esc_html__( 'Gallery Categories', 'lsvr-galleries' ),
						'singular_name' => esc_html__( 'Gallery Category', 'lsvr-galleries' ),
						'search_items' => esc_html__( 'Search Gallery Categories', 'lsvr-galleries' ),
						'popular_items' => esc_html__( 'Popular Gallery Categories', 'lsvr-galleries' ),
						'all_items' => esc_html__( 'All Gallery Categories', 'lsvr-galleries' ),
						'parent_item' => esc_html__( 'Parent Gallery Category', 'lsvr-galleries' ),
						'parent_item_colon' => esc_html__( 'Parent Gallery Category:', 'lsvr-galleries' ),
						'edit_item' => esc_html__( 'Edit Gallery Category', 'lsvr-galleries' ),
						'update_item' => esc_html__( 'Update Gallery Category', 'lsvr-galleries' ),
						'add_new_item' => esc_html__( 'Add New Gallery Category', 'lsvr-galleries' ),
						'new_item_name' => esc_html__( 'New Gallery Category Name', 'lsvr-galleries' ),
						'separate_items_with_commas' => esc_html__( 'Separate gallery categories by comma', 'lsvr-galleries' ),
						'add_or_remove_items' => esc_html__( 'Add or remove gallery categories', 'lsvr-galleries' ),
						'choose_from_most_used' => esc_html__( 'Choose from the most used gallery categories', 'lsvr-galleries' ),
						'menu_name' => esc_html__( 'Gallery Categories', 'lsvr-galleries' )
					),
					'public' => true,
					'show_in_nav_menus' => true,
					'show_ui' => true,
					'show_admin_column' => true,
					'show_tagcloud' => true,
					'hierarchical' => true,
					'rewrite' => array( 'slug' => 'gallery-category' ),
					'query_var' => true,
					'show_in_rest' => true,
					'show_in_admin' => true,
				),
				'args' => array(
					'admin_tax_filter' => true,
				),
			));

			// Add Tag taxonomy
			$this->add_taxonomy(array(
				'id' => 'lsvr_gallery_tag',
				'wp_args' => array(
					'labels' => array(
						'name' => esc_html__( 'Gallery Tags', 'lsvr-galleries' ),
						'singular_name' => esc_html__( 'Gallery Tag', 'lsvr-galleries' ),
						'search_items' => esc_html__( 'Search Gallery Tags', 'lsvr-galleries' ),
						'popular_items' => esc_html__( 'Popular Gallery Tags', 'lsvr-galleries' ),
						'all_items' => esc_html__( 'All Gallery Tags', 'lsvr-galleries' ),
						'parent_item' => esc_html__( 'Parent Gallery Tag', 'lsvr-galleries' ),
						'parent_item_colon' => esc_html__( 'Parent Gallery Tag:', 'lsvr-galleries' ),
						'edit_item' => esc_html__( 'Edit Gallery Tag', 'lsvr-galleries' ),
						'update_item' => esc_html__( 'Update Gallery Tag', 'lsvr-galleries' ),
						'add_new_item' => esc_html__( 'Add New Gallery Tag', 'lsvr-galleries' ),
						'new_item_name' => esc_html__( 'New Gallery Tag Name', 'lsvr-galleries' ),
						'separate_items_with_commas' => esc_html__( 'Separate gallery tags by comma', 'lsvr-galleries' ),
						'add_or_remove_items' => esc_html__( 'Add or remove gallery tags', 'lsvr-galleries' ),
						'choose_from_most_used' => esc_html__( 'Choose from the most used gallery tags', 'lsvr-galleries' ),
						'menu_name' => esc_html__( 'Gallery Tags', 'lsvr-galleries' )
					),
					'public' => true,
					'show_in_nav_menus' => true,
					'show_ui' => true,
					'show_admin_column' => true,
					'show_tagcloud' => true,
					'hierarchical' => false,
					'rewrite' => array( 'slug' => 'gallery-tag' ),
					'query_var' => true,
					'show_in_rest' => true,
				),
				'args' => array(
					'admin_tax_filter' => true,
				),
			));

			// Additional custom admin functionality
			if ( is_admin() ) {

				// Add Gallery Settings metabox
				add_action( 'init', array( $this, 'add_gallery_post_metabox' ) );

				// Display custom columns in admin archive view
				add_filter( 'manage_edit-lsvr_gallery_columns', array( $this, 'add_columns' ), 10, 1 );
				add_action( 'manage_posts_custom_column', array( $this, 'display_columns' ), 10, 1 );

			}

		}

		// Add Gallery Settings metabox
		public function add_gallery_post_metabox() {
			if ( class_exists( 'Lsvr_Post_Metabox' ) ) {
				$lsvr_gallery_settings_metabox = new Lsvr_Post_Metabox(array(
					'id' => 'lsvr_gallery_images',
					'wp_args' => array(
						'title' => __( 'Gallery Images', 'lsvr-galleries' ),
						'screen' => 'lsvr_gallery',
					),
					'fields' => array(

						// Gallery
						'lsvr_gallery_images' => array(
							'type' => 'gallery',
							'description' => esc_html__( 'Upload new or select existing images. Don\'t forget to set the gallery thumbnail (via Featured Image) as well.', 'lsvr-galleries' ),
							'multiple' => true,
							'select_btn_label' => esc_html__( 'Manage Gallery Images', 'lsvr-galleries' ),
							'media_type' => array( 'image' ),
							'priority' => 10,
						),

					),
				));
			}
		}

		// Add custom columns to admin view
		public function add_columns( $columns ) {
			$image_count = array( 'lsvr_gallery_image_count' => esc_html__( 'Number of Images', 'lsvr-galleries' ) );
			$columns = array_slice( $columns, 0, 2, true ) + $image_count + array_slice( $columns, 1, NULL, true );
			return $columns;
		}

		// Display custom columns in admin view
		public function display_columns( $column ) {
			global $post;
			global $typenow;
			if ( 'lsvr_gallery' == $typenow && 'lsvr_gallery_image_count' === $column ) {

				// Get number of images
				$lsvr_gallery_images = get_post_meta( $post->ID, 'lsvr_gallery_images', true );
				if ( ! empty( $lsvr_gallery_images ) ) {
					$images_count = count( explode( ',', $lsvr_gallery_images ) );
				} else {
					$images_count = 0;
				}

				// Display number of images
				echo esc_html( sprintf( _n( '%d image', '%d images', $images_count, 'lsvr-galleries' ), $images_count ) );

			}
		}

	}
}

?>