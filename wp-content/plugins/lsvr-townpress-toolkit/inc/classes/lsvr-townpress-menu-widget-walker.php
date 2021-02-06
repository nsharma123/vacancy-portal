<?php
// Sitemap section walker
if ( ! class_exists( 'Lsvr_Townpress_Menu_Widget_Walker' ) ) {
    class Lsvr_Townpress_Menu_Widget_Walker extends Walker_Nav_Menu {

        function start_lvl( &$output, $depth = 0, $args = [] ) {
            ob_start(); ?>

            <button class="lsvr-townpress-menu-widget__toggle lsvr-townpress-menu-widget__toggle--level-<?php echo esc_attr( $depth ); ?>" type="button">
                <i class="lsvr-townpress-menu-widget__toggle-icon"></i>
            </button>

            <ul class="lsvr-townpress-menu-widget__submenu lsvr-townpress-menu-widget__submenu--level-<?php echo esc_attr( $depth ); ?>">

            <?php $output .= ob_get_clean();

        }

        function end_lvl( &$output, $depth = 0, $args = [] ) {
            ob_start(); ?>

            </ul>

            <?php $output .= ob_get_clean();
        }

        function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {
            ob_start(); ?>

            <?php if ( ! empty( $item->description ) ) {
                $item->classes[] = 'lsvr-townpress-menu-widget__item--has-icon';
            } ?>

            <li class="lsvr-townpress-menu-widget__item lsvr-townpress-menu-widget__item--level-<?php echo esc_attr( $depth ); ?> <?php echo ! empty( $item->classes ) ? esc_attr( trim( implode( ' ', $item->classes ) ) ) : ''; ?>">

                <a href="<?php echo esc_url( $item->url ); ?>"
                    class="lsvr-townpress-menu-widget__item-link lsvr-townpress-menu-widget__item-link--level-<?php echo esc_attr( $depth ); ?>"
                    <?php echo ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : ''; ?>>

                    <?php if ( ! empty( $item->description ) ) : ?>
                        <i class="lsvr-townpress-menu-widget__item-link-icon lsvr-townpress-menu-widget__item-link-icon--level-<?php echo esc_attr( $depth ); ?> <?php echo esc_attr( $item->description ); ?>"></i>
                    <?php endif; ?>

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