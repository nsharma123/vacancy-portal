<?php
/**
 * LSVR Document categories widget
 *
 * Display list of lsvr_document_cat tax terms
 */
if ( ! class_exists( 'Lsvr_Widget_Document_Categories' ) && class_exists( 'Lsvr_Widget' ) ) {
class Lsvr_Widget_Document_Categories extends Lsvr_Widget {

    public function __construct() {

    	// Init widget
		parent::__construct(array(
			'id' => 'lsvr_documents_document_categories',
			'classname' => 'lsvr_document-categories-widget',
			'title' => esc_html__( 'LSVR Document Categories', 'lsvr-documents' ),
			'description' => esc_html__( 'List of Document categories', 'lsvr-documents' ),
			'fields' => array(
				'title' => array(
					'label' => esc_html__( 'Title:', 'lsvr-documents' ),
					'type' => 'text',
					'default' => esc_html__( 'Document Categories', 'lsvr-documents' ),
				),
			),
		));

    }

    function widget( $args, $instance ) {
        ?>

        <?php // Before widget content
        parent::before_widget_content( $args, $instance ); ?>

        <div class="widget__content">

			<ul class="root">
	        	<?php wp_list_categories(array(
					'title_li' => '',
					'taxonomy' => 'lsvr_document_cat',
					'show_count' => false,
				)); ?>
			</ul>

        </div>

        <?php // After widget content
        parent::after_widget_content( $args, $instance ); ?>

        <?php

    }

}}

?>