<?php
/**
 * Document post type
 */
if ( ! class_exists( 'Lsvr_CPT_Document' ) && class_exists( 'Lsvr_CPT' ) ) {
    class Lsvr_CPT_Document extends Lsvr_CPT {

		public function __construct() {

			parent::__construct( array(
				'id' => 'lsvr_document',
				'wp_args' => array(
					'labels' => array(
						'name' => esc_html__( 'Documents', 'lsvr-documents' ),
						'singular_name' => esc_html__( 'Document', 'lsvr-documents' ),
						'add_new' => esc_html__( 'Add New Document', 'lsvr-documents' ),
						'add_new_item' => esc_html__( 'Add New Document', 'lsvr-documents' ),
						'edit_item' => esc_html__( 'Edit Document', 'lsvr-documents' ),
						'new_item' => esc_html__( 'Add New Document', 'lsvr-documents' ),
						'view_item' => esc_html__( 'View Document', 'lsvr-documents' ),
						'search_items' => esc_html__( 'Search documents', 'lsvr-documents' ),
						'not_found' => esc_html__( 'No documents found', 'lsvr-documents' ),
						'not_found_in_trash' => esc_html__( 'No documents found in trash', 'lsvr-documents' ),
					),
					'exclude_from_search' => false,
					'public' => true,
					'supports' => array( 'title', 'editor', 'custom-fields', 'revisions', 'excerpt' ),
					'capability_type' => 'post',
					'rewrite' => array( 'slug' => 'documents' ),
					'menu_position' => 5,
					'has_archive' => true,
					'show_in_nav_menus' => true,
					'show_in_rest' => true,
					'menu_icon' => 'dashicons-media-text',
				),
			));

			// Add Category taxonomy
			$this->add_taxonomy(array(
				'id' => 'lsvr_document_cat',
				'wp_args' => array(
					'labels' => array(
						'name' => esc_html__( 'Document Categories', 'lsvr-documents' ),
						'singular_name' => esc_html__( 'Document Category', 'lsvr-documents' ),
						'search_items' => esc_html__( 'Search Document Categories', 'lsvr-documents' ),
						'popular_items' => esc_html__( 'Popular Document Categories', 'lsvr-documents' ),
						'all_items' => esc_html__( 'All Document Categories', 'lsvr-documents' ),
						'parent_item' => esc_html__( 'Parent Document Category', 'lsvr-documents' ),
						'parent_item_colon' => esc_html__( 'Parent Document Category:', 'lsvr-documents' ),
						'edit_item' => esc_html__( 'Edit Document Category', 'lsvr-documents' ),
						'update_item' => esc_html__( 'Update Document Category', 'lsvr-documents' ),
						'add_new_item' => esc_html__( 'Add New Document Category', 'lsvr-documents' ),
						'new_item_name' => esc_html__( 'New Document Category Name', 'lsvr-documents' ),
						'separate_items_with_commas' => esc_html__( 'Separate document categories by comma', 'lsvr-documents' ),
						'add_or_remove_items' => esc_html__( 'Add or remove document categories', 'lsvr-documents' ),
						'choose_from_most_used' => esc_html__( 'Choose from the most used document categories', 'lsvr-documents' ),
						'menu_name' => esc_html__( 'Document Categories', 'lsvr-documents' )
					),
					'public' => true,
					'show_in_nav_menus' => true,
					'show_ui' => true,
					'show_admin_column' => true,
					'show_tagcloud' => true,
					'hierarchical' => true,
					'rewrite' => array( 'slug' => 'document-category' ),
					'query_var' => true,
					'show_in_rest' => true,
				),
				'args' => array(
					'admin_tax_filter' => true,
				),
			));

			// Add Tag taxonomy
			$this->add_taxonomy(array(
				'id' => 'lsvr_document_tag',
				'wp_args' => array(
					'labels' => array(
						'name' => esc_html__( 'Document Tags', 'lsvr-documents' ),
						'singular_name' => esc_html__( 'Document Tag', 'lsvr-documents' ),
						'search_items' => esc_html__( 'Search Document Tags', 'lsvr-documents' ),
						'popular_items' => esc_html__( 'Popular Document Tags', 'lsvr-documents' ),
						'all_items' => esc_html__( 'All Document Tags', 'lsvr-documents' ),
						'parent_item' => esc_html__( 'Parent Document Tag', 'lsvr-documents' ),
						'parent_item_colon' => esc_html__( 'Parent Document Tag:', 'lsvr-documents' ),
						'edit_item' => esc_html__( 'Edit Document Tag', 'lsvr-documents' ),
						'update_item' => esc_html__( 'Update Document Tag', 'lsvr-documents' ),
						'add_new_item' => esc_html__( 'Add New Document Tag', 'lsvr-documents' ),
						'new_item_name' => esc_html__( 'New Document Tag Name', 'lsvr-documents' ),
						'separate_items_with_commas' => esc_html__( 'Separate document tags by comma', 'lsvr-documents' ),
						'add_or_remove_items' => esc_html__( 'Add or remove document tags', 'lsvr-documents' ),
						'choose_from_most_used' => esc_html__( 'Choose from the most used document tags', 'lsvr-documents' ),
						'menu_name' => esc_html__( 'Document Tags', 'lsvr-documents' )
					),
					'public' => true,
					'show_in_nav_menus' => true,
					'show_ui' => true,
					'show_admin_column' => true,
					'show_tagcloud' => true,
					'hierarchical' => false,
					'rewrite' => array( 'slug' => 'document-tag' ),
					'query_var' => true,
					'show_in_rest' => true,
				),
				'args' => array(
					'admin_tax_filter' => true,
				),
			));

			// Additional custom admin functionality
			if ( is_admin() ) {

				// Add Document Settings metabox
				add_action( 'init', array( $this, 'add_document_post_metabox' ) );

				// Display custom columns in admin archive view
				add_filter( 'manage_edit-lsvr_document_columns', array( $this, 'add_columns' ), 10, 1 );
				add_action( 'manage_posts_custom_column', array( $this, 'display_columns' ), 10, 1 );

			}

		}

		// Add Document Settings metabox
		public function add_document_post_metabox() {
			if ( class_exists( 'Lsvr_Post_Metabox' ) ) {
				$lsvr_document_settings_metabox = new Lsvr_Post_Metabox(array(
					'id' => 'lsvr_document_settings',
					'wp_args' => array(
						'title' => __( 'Document Settings', 'lsvr-documents' ),
						'screen' => 'lsvr_document',
					),
					'fields' => array(

						// Local Attachments
						'lsvr_document_local_attachments' => array(
							'type' => 'attachment',
							'title' => esc_html__( 'Local Attachments', 'lsvr-documents' ),
							'description' => esc_html__( 'Upload new or select existing files.', 'lsvr-documents' ),
							'select_btn_label' => esc_html__( 'Select Local Attachments', 'lsvr-documents' ),
							'priority' => 10,
						),

						// External Attachments
						'lsvr_document_external_attachments' => array(
							'type' => 'external-attachment',
							'title' => esc_html__( 'External Attachments', 'lsvr-documents' ),
							'description' => esc_html__( 'Insert URL of external attachment.', 'lsvr-documents' ),
							'priority' => 20,
						),

					),
				));
			}
		}

		// Add custom columns to admin view
		public function add_columns( $columns ) {
			$image_count = array( 'lsvr_document_attachments_count' => esc_html__( 'Number of Attachments', 'lsvr-documents' ) );
			$columns = array_slice( $columns, 0, 2, true ) + $image_count + array_slice( $columns, 1, NULL, true );
			return $columns;
		}

		// Display custom columns in admin view
		public function display_columns( $column ) {
			global $post;
			global $typenow;
			if ( 'lsvr_document' == $typenow && 'lsvr_document_attachments_count' === $column ) {

				// Get number of local attachments
				$lsvr_document_local_attachments = get_post_meta( $post->ID, 'lsvr_document_local_attachments', true );
				if ( ! empty( $lsvr_document_local_attachments ) ) {
					$local_attachments_count = count( explode( ',', $lsvr_document_local_attachments ) );
				} else {
					$local_attachments_count = 0;
				}

				// Get number of external attachments
				$lsvr_document_external_attachments = get_post_meta( $post->ID, 'lsvr_document_external_attachments', true );
				if ( ! empty( $lsvr_document_external_attachments ) ) {
					$external_attachments_count = count( explode( '|', $lsvr_document_external_attachments ) );
				} else {
					$external_attachments_count = 0;
				}

				// Display number of attachments
				if ( ! empty( $local_attachments_count ) || ! empty( $external_attachments_count ) ) {
					if ( ! empty( $local_attachments_count ) ) {
						echo esc_html( sprintf( _n( '%d local attachment', '%d local attachments', $local_attachments_count, 'lsvr-documents' ), $local_attachments_count ) );
					}
					if ( ! empty( $external_attachments_count ) ) {
						echo ! empty( $local_attachments_count ) ? '<br>' : '';
						echo esc_html( sprintf( _n( '%d external attachment', '%d external attachments', $external_attachments_count, 'lsvr-documents' ), $external_attachments_count ) );
					}
				} else {
					esc_html_e( 'No attachments', 'lsvr-documents' );
				}

			}
		}

	}
}

?>