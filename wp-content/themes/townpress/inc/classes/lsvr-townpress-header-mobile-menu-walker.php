<?php
// Header menu walker
if ( ! class_exists( 'Lsvr_Townpress_Header_Mobile_Menu_Walker' ) ) {
    class Lsvr_Townpress_Header_Mobile_Menu_Walker extends Walker_Nav_Menu {

        function start_lvl( &$output, $depth = 0, $args = [] ) {
            ob_start(); ?>

            <button class="header-mobile-menu__toggle header-mobile-menu__toggle--level-<?php echo esc_attr( $depth ); ?>" type="button">
                <i class="header-mobile-menu__toggle-icon"></i>
            </button>
        	<ul class="header-mobile-menu__submenu sub-menu header-mobile-menu__submenu--level-<?php echo esc_attr( $depth ); ?>">

            <?php $output .= ob_get_clean();

        }

        function end_lvl( &$output, $depth = 0, $args = [] ) {
            ob_start(); ?>

        	</ul>

            <?php $output .= ob_get_clean();
        }

        function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {
        	ob_start(); ?>

        	<li class="header-mobile-menu__item header-mobile-menu__item--level-<?php echo esc_attr( $depth ); ?> <?php echo ! empty( $item->classes ) ? esc_attr( trim( implode( ' ', $item->classes ) ) ) : ''; ?>">

                <a href="<?php echo esc_url( $item->url ); ?>"
                	class="header-mobile-menu__item-link header-mobile-menu__item-link--level-<?php echo esc_attr( $depth ); ?>"
                	<?php echo ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : ''; ?>>

                    <?php echo esc_html( $item->title ); ?></a>

            <?php $output .= ob_get_clean();
        }

        function end_el( &$output, $item, $depth = 0, $args = [] ) {
            ob_start(); ?>

            </li>

            <?php $output .= ob_get_clean();

        }

    }
}