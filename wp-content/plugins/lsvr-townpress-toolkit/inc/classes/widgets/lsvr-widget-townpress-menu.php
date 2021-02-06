<?php
/**
 * LSVR Menu widget
 *
 * Display a custom menu
 */
if ( ! class_exists( 'Lsvr_Widget_Townpress_Menu' ) && class_exists( 'Lsvr_Widget' ) ) {
class Lsvr_Widget_Townpress_Menu extends Lsvr_Widget {

    public function __construct() {

    	// Init widget
		parent::__construct(array(
			'id' => 'lsvr_townpress_menu',
			'classname' => 'lsvr-townpress-menu-widget',
			'title' => esc_html__( 'TownPress Menu', 'lsvr-townpress-toolkit' ),
			'description' => esc_html__( 'Custom menu', 'lsvr-townpress-toolkit' ),
			'fields' => array(
				'title' => array(
					'label' => esc_html__( 'Title:', 'lsvr-townpress-toolkit' ),
					'type' => 'text',
				),
				'menu_id' => array(
					'label' => esc_html__( 'Menu:', 'lsvr-townpress-toolkit' ),
					'description' => esc_html__( 'Choose menu to display. You can manage your menus under Appearance / Menus.', 'lsvr-townpress-toolkit' ),
					'type' => 'select',
					'choices' => lsvr_townpress_toolkit_get_menus(),
				),
				'show_active' => array(
					'label' => esc_html__( 'Expand Active Submenu', 'lsvr-townpress-toolkit' ),
					'description' => esc_html__( 'Active item\'s submenu will be displayed without hovering on desktop devices.', 'lsvr-townpress-toolkit' ),
					'type' => 'checkbox',
					'default' => 'true',
				),
				'show_on_mobile' => array(
					'label' => esc_html__( 'Display On Mobile', 'lsvr-townpress-toolkit' ),
					'description' => esc_html__( 'Display this menu on mobile devices.', 'lsvr-townpress-toolkit' ),
					'type' => 'checkbox',
					'default' => 'true',
				),
			),
		));

    }

    function widget( $args, $instance ) {

    	// Show active
    	$show_active = ! empty( $instance['show_active'] ) && ( true === $instance['show_active'] || 'true' === $instance['show_active'] || '1' === $instance['show_active'] ) ? true : false;

    	// Show on mobile
		if ( ! empty( $instance['show_on_mobile'] ) && 'true' === $instance['show_on_mobile'] ) {
			$args[ 'before_widget' ] = str_replace( 'lsvr-townpress-menu-widget', 'lsvr-townpress-menu-widget lsvr-townpress-menu-widget--show-on-mobile', $args[ 'before_widget' ] );
		}

        ?>

        <?php // Before widget content
        parent::before_widget_content( $args, $instance ); ?>

        <div class="widget__content">

			<?php if ( ! empty( $instance['menu_id'] ) && is_nav_menu( $instance['menu_id'] ) ) : ?>

				<nav class="lsvr-townpress-menu-widget__nav<?php if ( true === $show_active ) { echo esc_attr( ' lsvr-townpress-menu-widget__nav--expanded-active' ); } ?>">

				    <?php wp_nav_menu(
				        array(
				            'menu' => $instance['menu_id'],
							'container' => '',
							'menu_class' => 'lsvr-townpress-menu-widget__list',
							'fallback_cb' => '',
							'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'walker' => new Lsvr_Townpress_Menu_Widget_Walker(),
						)
					); ?>

				</nav>

			<?php endif; ?>

        </div>

        <?php // After widget content
        parent::after_widget_content( $args, $instance ); ?>

        <?php

    }

}}

?>