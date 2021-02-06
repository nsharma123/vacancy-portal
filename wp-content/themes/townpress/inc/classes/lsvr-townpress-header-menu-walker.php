<?php
// Header menu walker
if ( ! class_exists( 'Lsvr_Townpress_Header_Menu_Walker' ) ) {
    class Lsvr_Townpress_Header_Menu_Walker extends Walker_Nav_Menu {

        function start_lvl( &$output, $depth = 0, $args = [] ) {
            ob_start(); ?>

        	<ul class="header-menu__submenu sub-menu header-menu__submenu--level-<?php echo esc_attr( $depth ); ?>">

            <?php $output .= ob_get_clean();

        }

        function end_lvl( &$output, $depth = 0, $args = [] ) {
            ob_start(); ?>

        	</ul>

            <?php $output .= ob_get_clean();
        }

        function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {
        	ob_start(); ?>

            <?php if ( 0 === $depth && ! empty( $item->classes ) && in_array( 'lsvr-megamenu', $item->classes ) ) {
                $item->classes[] = 'header-menu__item--megamenu';
            } elseif ( 0 === $depth ) {
                $item->classes[] = 'header-menu__item--dropdown';
            } ?>

        	<li class="header-menu__item header-menu__item--level-<?php echo esc_attr( $depth ); ?> <?php echo ! empty( $item->classes ) ? esc_attr( trim( implode( ' ', $item->classes ) ) ) : ''; ?>">

                <a href="<?php echo esc_url( $item->url ); ?>"
                	class="header-menu__item-link header-menu__item-link--level-<?php echo esc_attr( $depth ); ?>"
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