<?php
/**
 * Person post type
 */
if ( ! class_exists( 'Lsvr_CPT_Person' ) && class_exists( 'Lsvr_CPT' ) ) {
    class Lsvr_CPT_Person extends Lsvr_CPT {

		public function __construct() {

			parent::__construct( array(
				'id' => 'lsvr_person',
				'wp_args' => array(
					'labels' => array(
						'name' => esc_html__( 'People', 'lsvr-people' ),
						'singular_name' => esc_html__( 'Person', 'lsvr-people' ),
						'add_new' => esc_html__( 'Add New Person', 'lsvr-people' ),
						'add_new_item' => esc_html__( 'Add New Person', 'lsvr-people' ),
						'edit_item' => esc_html__( 'Edit Person', 'lsvr-people' ),
						'new_item' => esc_html__( 'Add New Person', 'lsvr-people' ),
						'view_item' => esc_html__( 'View Person', 'lsvr-people' ),
						'search_items' => esc_html__( 'Search people', 'lsvr-people' ),
						'not_found' => esc_html__( 'No people found', 'lsvr-people' ),
						'not_found_in_trash' => esc_html__( 'No people found in trash', 'lsvr-people' ),
					),
					'exclude_from_search' => false,
					'public' => true,
					'supports' => array( 'title', 'editor', 'custom-fields', 'excerpt', 'thumbnail' ),
					'capability_type' => 'post',
					'rewrite' => array( 'slug' => 'people' ),
					'menu_position' => 5,
					'has_archive' => true,
					'show_in_nav_menus' => true,
					'show_in_rest' => true,
					'menu_icon' => 'dashicons-groups',
				),
			));

			// Add Category taxonomy
			$this->add_taxonomy(array(
				'id' => 'lsvr_person_cat',
				'wp_args' => array(
					'labels' => array(
						'name' => esc_html__( 'Person Categories', 'lsvr-people' ),
						'singular_name' => esc_html__( 'Person Category', 'lsvr-people' ),
						'search_items' => esc_html__( 'Search Person Categories', 'lsvr-people' ),
						'popular_items' => esc_html__( 'Popular Person Categories', 'lsvr-people' ),
						'all_items' => esc_html__( 'All Person Categories', 'lsvr-people' ),
						'parent_item' => esc_html__( 'Parent Person Categories', 'lsvr-people' ),
						'parent_item_colon' => esc_html__( 'Parent Person Categories:', 'lsvr-people' ),
						'edit_item' => esc_html__( 'Edit Person Category', 'lsvr-people' ),
						'update_item' => esc_html__( 'Update Person Category', 'lsvr-people' ),
						'add_new_item' => esc_html__( 'Add New Person Category', 'lsvr-people' ),
						'new_item_name' => esc_html__( 'New Person Category Name', 'lsvr-people' ),
						'separate_items_with_commas' => esc_html__( 'Separate person categories by comma', 'lsvr-people' ),
						'add_or_remove_items' => esc_html__( 'Add or remove person categories', 'lsvr-people' ),
						'choose_from_most_used' => esc_html__( 'Choose from the most used person categories', 'lsvr-people' ),
						'menu_name' => esc_html__( 'Person Categories', 'lsvr-people' )
					),
					'public' => true,
					'show_in_nav_menus' => true,
					'show_ui' => true,
					'show_admin_column' => true,
					'show_tagcloud' => true,
					'hierarchical' => true,
					'rewrite' => array( 'slug' => 'person-category' ),
					'query_var' => true,
					'show_in_rest' => true,
				),
				'args' => array(
					'admin_tax_filter' => true,
				),
			));

			// Additional custom admin functionality
			if ( is_admin() ) {

				// Add Person Settings metabox
				add_action( 'init', array( $this, 'add_person_post_metabox' ) );

			}

		}

		// Add Person Settings metabox
		public function add_person_post_metabox() {
			if ( class_exists( 'Lsvr_Post_Metabox' ) ) {
				$lsvr_person_settings_metabox = new Lsvr_Post_Metabox(array(
					'id' => 'lsvr_person_settings',
					'wp_args' => array(
						'title' => __( 'Person Settings', 'lsvr-people' ),
						'screen' => 'lsvr_person',
					),
					'fields' => array(

						// Role
						'lsvr_person_role' => array(
							'type' => 'text',
							'title' => esc_html__( 'Role', 'lsvr-people' ),
							'description' => esc_html__( 'Brief description of this person\'s role.', 'lsvr-people' ),
							'priority' => 10,
						),

						// Email
						'lsvr_person_email' => array(
							'type' => 'text',
							'title' => esc_html__( 'Email', 'lsvr-people' ),
							'priority' => 20,
						),

						// Phone
						'lsvr_person_phone' => array(
							'type' => 'text',
							'content_type' => 'number',
							'title' => esc_html__( 'Phone', 'lsvr-people' ),
							'priority' => 30,
						),

						// Website
						'lsvr_person_website' => array(
							'type' => 'text',
							'title' => esc_html__( 'Website', 'lsvr-people' ),
							'priority' => 40,
						),

						// Facebook
						'lsvr_person_facebook' => array(
							'type' => 'text',
							'title' => esc_html__( 'Facebook', 'lsvr-people' ),
							'priority' => 50,
						),

						// Twitter
						'lsvr_person_twitter' => array(
							'type' => 'text',
							'title' => esc_html__( 'Twitter', 'lsvr-people' ),
							'priority' => 60,
						),

						// Skype
						'lsvr_person_skype' => array(
							'type' => 'text',
							'title' => esc_html__( 'Skype', 'lsvr-people' ),
							'priority' => 70,
						),

						// LinkedIn
						'lsvr_person_linkedin' => array(
							'type' => 'text',
							'title' => esc_html__( 'LinkedIn', 'lsvr-people' ),
							'priority' => 80,
						),

					),
				));
			}
		}

	}
}

?>