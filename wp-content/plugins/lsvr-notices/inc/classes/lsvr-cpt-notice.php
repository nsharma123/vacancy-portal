<?php
/**
 * Notice post type
 */
if ( ! class_exists( 'Lsvr_CPT_Notice' ) && class_exists( 'Lsvr_CPT' ) ) {
    class Lsvr_CPT_Notice extends Lsvr_CPT {

		public function __construct() {

			parent::__construct( array(
				'id' => 'lsvr_notice',
				'wp_args' => array(
					'labels' => array(
						'name' => esc_html__( 'Notices', 'lsvr-notices' ),
						'singular_name' => esc_html__( 'Notice', 'lsvr-notices' ),
						'add_new' => esc_html__( 'Add New Notice', 'lsvr-notices' ),
						'add_new_item' => esc_html__( 'Add New Notice', 'lsvr-notices' ),
						'edit_item' => esc_html__( 'Edit Notice', 'lsvr-notices' ),
						'new_item' => esc_html__( 'Add New Notice', 'lsvr-notices' ),
						'view_item' => esc_html__( 'View Notice', 'lsvr-notices' ),
						'search_items' => esc_html__( 'Search notices', 'lsvr-notices' ),
						'not_found' => esc_html__( 'No notices found', 'lsvr-notices' ),
						'not_found_in_trash' => esc_html__( 'No notices found in trash', 'lsvr-notices' ),
					),
					'exclude_from_search' => false,
					'public' => true,
					'supports' => array( 'title', 'editor', 'custom-fields' ),
					'capability_type' => 'post',
					'rewrite' => array( 'slug' => 'notices' ),
					'menu_position' => 5,
					'has_archive' => true,
					'show_in_nav_menus' => true,
					'show_in_rest' => true,
					'menu_icon' => 'dashicons-megaphone',
				),
			));

			// Add Category taxonomy
			$this->add_taxonomy(array(
				'id' => 'lsvr_notice_cat',
				'wp_args' => array(
					'labels' => array(
						'name' => esc_html__( 'Notice Categories', 'lsvr-notices' ),
						'singular_name' => esc_html__( 'Notice Category', 'lsvr-notices' ),
						'search_items' => esc_html__( 'Search Notice Categories', 'lsvr-notices' ),
						'popular_items' => esc_html__( 'Popular Notice Categories', 'lsvr-notices' ),
						'all_items' => esc_html__( 'All Notice Categories', 'lsvr-notices' ),
						'parent_item' => esc_html__( 'Parent Notice Category', 'lsvr-notices' ),
						'parent_item_colon' => esc_html__( 'Parent Notice Category:', 'lsvr-notices' ),
						'edit_item' => esc_html__( 'Edit Notice Category', 'lsvr-notices' ),
						'update_item' => esc_html__( 'Update Notice Category', 'lsvr-notices' ),
						'add_new_item' => esc_html__( 'Add New Notice Category', 'lsvr-notices' ),
						'new_item_name' => esc_html__( 'New Notice Category Name', 'lsvr-notices' ),
						'separate_items_with_commas' => esc_html__( 'Separate notice categories by comma', 'lsvr-notices' ),
						'add_or_remove_items' => esc_html__( 'Add or remove notice categories', 'lsvr-notices' ),
						'choose_from_most_used' => esc_html__( 'Choose from the most used notice categories', 'lsvr-notices' ),
						'menu_name' => esc_html__( 'Notice Categories', 'lsvr-notices' )
					),
					'public' => true,
					'show_in_nav_menus' => true,
					'show_ui' => true,
					'show_admin_column' => true,
					'show_tagcloud' => true,
					'hierarchical' => true,
					'rewrite' => array( 'slug' => 'notice-category' ),
					'query_var' => true,
					'show_in_rest' => true,
				),
				'args' => array(
					'admin_tax_filter' => true,
				),
			));

			// Add Tag taxonomy
			$this->add_taxonomy(array(
				'id' => 'lsvr_notice_tag',
				'wp_args' => array(
					'labels' => array(
						'name' => esc_html__( 'Notice Tags', 'lsvr-notices' ),
						'singular_name' => esc_html__( 'Notice Tag', 'lsvr-notices' ),
						'search_items' => esc_html__( 'Search Notice Tags', 'lsvr-notices' ),
						'popular_items' => esc_html__( 'Popular Notice Tags', 'lsvr-notices' ),
						'all_items' => esc_html__( 'All Notice Tags', 'lsvr-notices' ),
						'parent_item' => esc_html__( 'Parent Notice Tag', 'lsvr-notices' ),
						'parent_item_colon' => esc_html__( 'Parent Notice Tag:', 'lsvr-notices' ),
						'edit_item' => esc_html__( 'Edit Notice Tag', 'lsvr-notices' ),
						'update_item' => esc_html__( 'Update Notice Tag', 'lsvr-notices' ),
						'add_new_item' => esc_html__( 'Add New Notice Tag', 'lsvr-notices' ),
						'new_item_name' => esc_html__( 'New Notice Tag Name', 'lsvr-notices' ),
						'separate_items_with_commas' => esc_html__( 'Separate notice tags by comma', 'lsvr-notices' ),
						'add_or_remove_items' => esc_html__( 'Add or remove notice tags', 'lsvr-notices' ),
						'choose_from_most_used' => esc_html__( 'Choose from the most used notice tags', 'lsvr-notices' ),
						'menu_name' => esc_html__( 'Notice Tags', 'lsvr-notices' )
					),
					'public' => true,
					'show_in_nav_menus' => true,
					'show_ui' => true,
					'show_admin_column' => true,
					'show_tagcloud' => true,
					'hierarchical' => false,
					'rewrite' => array( 'slug' => 'notice-tag' ),
					'query_var' => true,
					'show_in_rest' => true,
				),
				'args' => array(
					'admin_tax_filter' => true,
				),
			));

		}

	}
}

?>