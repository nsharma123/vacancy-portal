<?php
/**
 * LSVR Definition List widget
 *
 * Display list of definitions
 */
if ( ! class_exists( 'Lsvr_Widget_Definition_List' ) && class_exists( 'Lsvr_Widget' ) ) {
class Lsvr_Widget_Definition_List extends Lsvr_Widget {

    public function __construct() {

    	// Init widget
		parent::__construct(array(
			'id' => 'lsvr_definition_list',
			'classname' => 'lsvr-definition-list-widget',
			'title' => esc_html__( 'LSVR Definition List', 'lsvr-elements' ),
			'description' => esc_html__( 'List of definitions', 'lsvr-elements' ),
			'fields' => array(
				'title' => array(
					'label' => esc_html__( 'Title:', 'lsvr-elements' ),
					'type' => 'text',
				),
				'item1_title' => array(
					'label' => esc_html__( 'Item 1 Title:', 'lsvr-elements' ),
					'type' => 'text',
				),
				'item1_text' => array(
					'label' => esc_html__( 'Item 1 Text:', 'lsvr-elements' ),
					'type' => 'text',
				),
				'item1_text_link' => array(
					'label' => esc_html__( 'Item 1 Text Link:', 'lsvr-elements' ),
					'type' => 'text',
				),
				'item2_title' => array(
					'label' => esc_html__( 'Item 2 Title:', 'lsvr-elements' ),
					'type' => 'text',
				),
				'item2_text' => array(
					'label' => esc_html__( 'Item 2 Text:', 'lsvr-elements' ),
					'type' => 'text',
				),
				'item2_text_link' => array(
					'label' => esc_html__( 'Item 2 Text Link:', 'lsvr-elements' ),
					'type' => 'text',
				),
				'item3_title' => array(
					'label' => esc_html__( 'Item 3 Title:', 'lsvr-elements' ),
					'type' => 'text',
				),
				'item3_text' => array(
					'label' => esc_html__( 'Item 3 Text:', 'lsvr-elements' ),
					'type' => 'text',
				),
				'item3_text_link' => array(
					'label' => esc_html__( 'Item 3 Text Link:', 'lsvr-elements' ),
					'type' => 'text',
				),
				'item4_title' => array(
					'label' => esc_html__( 'Item 4 Title:', 'lsvr-elements' ),
					'type' => 'text',
				),
				'item4_text' => array(
					'label' => esc_html__( 'Item 4 Text:', 'lsvr-elements' ),
					'type' => 'text',
				),
				'item4_text_link' => array(
					'label' => esc_html__( 'Item 4 Text Link:', 'lsvr-elements' ),
					'type' => 'text',
				),
				'item5_title' => array(
					'label' => esc_html__( 'Item 5 Title:', 'lsvr-elements' ),
					'type' => 'text',
				),
				'item5_text' => array(
					'label' => esc_html__( 'Item 5 Text:', 'lsvr-elements' ),
					'type' => 'text',
				),
				'item5_text_link' => array(
					'label' => esc_html__( 'Item 5 Text Link:', 'lsvr-elements' ),
					'type' => 'text',
				),
				'more_label' => array(
					'label' => esc_html__( 'More Button Label:', 'lsvr-elements' ),
					'type' => 'text',
				),
				'more_link' => array(
					'label' => esc_html__( 'More Button Link:', 'lsvr-elements' ),
					'type' => 'text',
				),
			),
		));

    }

    function widget( $args, $instance ) {

        ?>

        <?php // Before widget content
        parent::before_widget_content( $args, $instance ); ?>

        <div class="widget__content">

    		<dl class="lsvr-definition-list-widget__list">

    			<?php for ( $i = 1; $i <= 5; $i++ ) :
    				if ( ! empty( $instance[ 'item' . $i . '_title' ] ) && ! empty( $instance[ 'item' . $i . '_text' ] ) ) : ?>

    					<dt class="lsvr-definition-list-widget__item-title">
    						<?php echo esc_html( $instance[ 'item' . $i . '_title' ] ); ?>
    					</dt>

    					<?php if ( ! empty( $instance[ 'item' . $i . '_text_link' ] ) ) : ?>

	    					<dd class="lsvr-definition-list-widget__item-text">
	    						<a href="<?php echo esc_url( $instance[ 'item' . $i . '_text_link' ] ); ?>"
	    							class="lsvr-definition-list-widget__item-text-link">
	    							<?php echo esc_html( $instance[ 'item' . $i . '_text' ] ); ?>
	    						</a>
	    					</dd>

						<?php else : ?>

							<dd class="lsvr-definition-list-widget__item-text">
	    						<?php echo esc_html( $instance[ 'item' . $i . '_text' ] ); ?>
	    					</dd>

    					<?php endif; ?>

    				<?php endif;
				endfor; ?>

    		</dl>

			<?php if ( ! empty( $instance[ 'more_label' ] ) && ! empty( $instance[ 'more_link' ] ) ) : ?>

				<p class="widget__more">
					<a href="<?php echo esc_url( $instance[ 'more_link' ] ); ?>" class="widget__more-link"><?php echo esc_html( $instance[ 'more_label' ] ); ?></a>
				</p>

			<?php endif; ?>

        </div>

        <?php // After widget content
        parent::after_widget_content( $args, $instance ); ?>

        <?php

    }

}}

?>