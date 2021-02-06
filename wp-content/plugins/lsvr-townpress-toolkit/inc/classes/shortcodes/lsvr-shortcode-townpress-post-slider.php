<?php
/**
 * LSVR TownPress Post Slider Shortcode
 */
if ( ! class_exists( 'Lsvr_Shortcode_Townpress_Post_Slider' ) ) {
    class Lsvr_Shortcode_Townpress_Post_Slider {

        public static function shortcode( $atts = array(), $content = null, $tag = '' ) {

            // Merge default atts and received atts
            $args = shortcode_atts(
                array(
                    'category' => 0,
                    'limit' => 5,
                    'height' => 0,
                    'align' => 'right',
                    'show_excerpt' => 'true',
                    'autoplay' => 0,
                    'overlay_opacity' => 0.5,
                    'id' => '',
                    'className' => '',
                    'editor_view' => false,
                ),
                $atts
            );

            // Check if editor view
            $editor_view = true === $args['editor_view'] || '1' === $args['editor_view'] || 'true' === $args['editor_view'] ? true : false;

            // Check if show excerpt
            $show_excerpt = true === $args['show_excerpt'] || '1' === $args['show_excerpt'] || 'true' === $args['show_excerpt'] ? true : false;

            // Element class
            $class_arr = array( 'lsvr-townpress-post-slider' );
            if ( true === $editor_view ) {
                array_push( $class_arr, 'lsvr-townpress-post-slider--editor-view' );
            }
            if ( ! empty( $args['className'] ) ) {
                array_push( $class_arr, $args['className'] );
            }
            if ( ! empty( $args['align'] ) ) {
                array_push( $class_arr, 'lsvr-townpress-post-slider--align-' . $args['align'] );
            } else {
                array_push( $class_arr, 'lsvr-townpress-post-slider--align-right' );
            }

            // Prepare query
            $limit = 0 === (int) $args['limit'] ? 1000 : (int) $args['limit'];
            $query_args = array(
                'posts_per_page' => $limit,
                'post_type' => 'post',
            );

            // Get category
            if ( ! empty( $args['category'] ) && is_numeric( $args['category'] ) && (int) $args['category'] > 0 ) {
                $category_id = (int) $args['category'];
            } else if ( ! empty( $args['category'] ) ) {
                $category_id = get_term_by( 'slug', $args['category'], 'category', ARRAY_A );
                $category_id = ! empty( $category_id['term_taxonomy_id'] ) ? $category_id['term_taxonomy_id'] : false;
            } else {
                $category_id = false;
            }

            // Set category
            if ( ! empty( $category_id ) ) {
                $query_args['category'] = $category_id;
            }

            // Get posts
            $posts = get_posts( $query_args );

            ob_start(); ?>

            <div class="<?php echo esc_attr( implode( ' ', $class_arr ) ); ?>"
                data-autoplay="<?php echo ! empty( $args['autoplay'] ) ? esc_attr( (int) $args['autoplay'] ) : 0; ?>"
                <?php echo ! empty( $args['id'] ) ? ' id="' . esc_attr( $args['id'] ) . '"' : ''; ?>>
                <div class="lsvr-townpress-post-slider__inner"<?php if ( ! empty( $args['height'] ) && (int) $args['height'] > 0 ) { echo ' style=" height: ' . esc_attr( (int) $args['height'] ) . 'px;"'; } ?>>

                    <?php if ( ! empty( $posts ) ) : ?>

                        <div class="lsvr-townpress-post-slider__list">

                            <?php foreach ( $posts as $post ) : ?>

                                <article <?php post_class( 'lsvr-townpress-post-slider__post', $post->ID ); ?>>
                                    <div class="lsvr-townpress-post-slider__post-bg"
                                        <?php if ( has_post_thumbnail( $post->ID ) ) { echo ' style="background-image: url( ' . esc_url( get_the_post_thumbnail_url( $post->ID, 'full' ) ) . ' );"'; } ?>>
                                        <div class="lsvr-townpress-post-slider__post-inner"<?php if ( ! empty( $args['height'] ) && (int) $args['height'] > 0 ) { echo ' style=" height: ' . esc_attr( (int) $args['height'] ) . 'px;"'; } ?>>

                                            <header class="lsvr-townpress-post-slider__post-header">

                                                <h2 class="lsvr-townpress-post-slider__post-title">
                                                    <a href="<?php echo esc_url( get_the_permalink( $post->ID ) ); ?>"
                                                        class="lsvr-townpress-post-slider__post-title-link" rel="bookmark">
                                                        <?php echo esc_html( $post->post_title ); ?>
                                                    </a>
                                                </h2>

                                                <p class="lsvr-townpress-post-slider__post-meta">
                                                    <time class="lsvr-townpress-post-slider__post-meta-date"
                                                        datetime="<?php echo esc_attr( get_the_time( 'c', $post->ID  ) ); ?>">
                                                        <?php echo esc_html( get_the_date( get_option( 'post_format' ), $post->ID ) ); ?>
                                                    </time>
                                                    <span class="lsvr-townpress-post-slider__post-meta-categories">
                                                        <?php lsvr_townpress_toolkit_the_post_terms( $post->ID, 'category', esc_html__( 'in %s', 'lsvr-townpress-toolkit' ), '',  1 ); ?>
                                                    </span>
                                                </p>

                                            </header>

                                            <?php if ( true === $show_excerpt && ! empty( $post->post_excerpt ) ) : ?>

                                                <div class="lsvr-townpress-post-slider__post-content">
                                                    <?php echo wpautop( wp_kses( $post->post_excerpt, array(
                                                        'a' => array(
                                                            'href' => array()
                                                        ),
                                                        'strong' => array(),
                                                        'em' => array(),
                                                        'br' => array(),
                                                    ) ) ); ?>
                                                </div>

                                            <?php endif; ?>

                                            <a href="<?php echo esc_url( get_the_permalink( $post->ID ) ); ?>"
                                                style="opacity: <?php echo ! empty( $args['overlay_opacity'] ) ? esc_attr( (int) $args['overlay_opacity'] / 100 ) : 0.5; ?>"
                                                class="lsvr-townpress-post-slider__post-overlay-link"></a>

                                        </div>
                                    </div>
                                </article>

                            <?php endforeach; wp_reset_postdata(); ?>

                        </div>

                        <?php if ( ! empty( $args['autoplay'] ) && (int) $args['autoplay'] > 0 ) : ?>
                            <div class="lsvr-townpress-post-slider__indicator"><span class="lsvr-townpress-post-slider__indicator-inner"></span></div>
                        <?php endif; ?>

                    <?php else : ?>

                        <p class="c-alert-message"><?php esc_html_e( 'There are no posts', 'lsvr-townpress-toolkit' ); ?></p>

                    <?php endif; ?>

                </div>
            </div>

            <?php return ob_get_clean();

        }

        // Shortcode params
        public static function lsvr_shortcode_atts() {
            return array_merge( array(

                // Category
                array(
                    'name' => 'category',
                    'type' => 'taxonomy',
                    'tax' => 'category',
                    'label' => esc_html__( 'Category', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'Display posts from a specific category.', 'lsvr-townpress-toolkit' ),
                    'priority' => 10,
                ),

                // Limit
                array(
                    'name' => 'limit',
                    'type' => 'select',
                    'label' => esc_html__( 'Limit', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'How many posts to display.', 'lsvr-townpress-toolkit' ),
                    'choices' => array( 0 => esc_html__( 'All', 'lsvr-townpress-toolkit' ) ) + range( 0, 20, 1 ),
                    'default' => 4,
                    'priority' => 20,
                ),

                // Height
                array(
                    'name' => 'height',
                    'type' => 'select',
                    'label' => esc_html__( 'Height', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'Slider height in pixels.', 'lsvr-townpress-toolkit' ),
                    'choices' => array( 0 => esc_html__( 'Default', 'lsvr-townpress-toolkit' ) ) + array_combine( range( 400, 600, 10 ), range( 400, 600, 10 ) ),
                    'default' => 0,
                    'priority' => 30,
                ),

                // Align
                array(
                    'name' => 'align',
                    'type' => 'select',
                    'label' => esc_html__( 'Align', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'Alignment of slide content.', 'lsvr-townpress-toolkit' ),
                    'choices' => array(
                        'left' => esc_html__( 'Left', 'lsvr-townpress-toolkit' ),
                        'right' => esc_html__( 'Right', 'lsvr-townpress-toolkit' ),
                    ),
                    'default' => 'right',
                    'priority' => 40,
                ),

                // Display excerpt
                array(
                    'name' => 'show_excerpt',
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Display Excerpt', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'Display post excerpt.', 'lsvr-townpress-toolkit' ),
                    'default' => true,
                    'priority' => 50,
                ),

                // Autoplay
                array(
                    'name' => 'autoplay',
                    'type' => 'select',
                    'label' => esc_html__( 'Autoplay', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'Time between slide change in seconds. Set to 0 to disable autoplay.', 'lsvr-townpress-toolkit' ),
                    'choices' => range( 0, 30, 1 ),
                    'default' => 0,
                    'priority' => 60,
                ),

                // Overlay opacity
                array(
                    'name' => 'overlay_opacity',
                    'type' => 'select',
                    'label' => esc_html__( 'Overlay opacity', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'Opacity of overlay element. Set to 0 to make it completely transparent.', 'lsvr-townpress-toolkit' ),
                    'choices' => range( 0, 100, 1 ),
                    'default' => 50,
                    'priority' => 70,
                ),

                // ID
                array(
                    'name' => 'id',
                    'type' => 'text',
                    'label' => esc_html__( 'Unique ID', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'You can use this ID to style this specific element with custom CSS, for example.', 'lsvr-townpress-toolkit' ),
                    'priority' => 80,
                ),

            ), apply_filters( 'lsvr_townpress_post_slider_shortcode_atts', array() ) );
        }

    }
}
?>