<?php
// Sitemap section walker
if ( ! class_exists( 'Lsvr_Townpress_Sitemap_Walker' ) ) {
    class Lsvr_Townpress_Sitemap_Walker extends Walker_Nav_Menu {

        function start_lvl( &$output, $depth = 0, $args = [] ) {
            ob_start(); ?>

            <ul class="lsvr-townpress-sitemap__submenu lsvr-townpress-sitemap__submenu--level-<?php echo esc_attr( $depth ); ?>">

            <?php $output .= ob_get_clean();

        }

        function end_lvl( &$output, $depth = 0, $args = [] ) {
            ob_start(); ?>

            </ul>

            <?php $output .= ob_get_clean();
        }

        function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {
            ob_start(); ?>


            <li class="lsvr-townpress-sitemap__item lsvr-townpress-sitemap__item--level-<?php echo esc_attr( $depth ); ?> <?php echo ! empty( $item->classes ) ? esc_attr( trim( implode( ' ', $item->classes ) ) ) : ''; ?>">

                <?php if ( 0 === $depth ) : ?>
                    <h3 class="lsvr-townpress-sitemap__item-title">
                <?php endif; ?>

                <a href="<?php echo esc_url( $item->url ); ?>"
                    class="lsvr-townpress-sitemap__item-link lsvr-townpress-sitemap__item-link--level-<?php echo esc_attr( $depth ); ?>"
                    <?php echo ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : ''; ?>><?php echo esc_html( $item->title ); ?></a>

                <?php if ( 0 === $depth ) : ?>
                    </h3>
                <?php endif; ?>

            <?php $output .= ob_get_clean();
        }

        function end_el( &$output, $item, $depth = 0, $args = [] ) {
            ob_start(); ?>

            </li>

            <?php $output .= ob_get_clean();

        }

    }
}