<?php
/**
 * LSVR TownPress Posts Shortcode
 */
if ( ! class_exists( 'Lsvr_Shortcode_Townpress_Posts' ) ) {
    class Lsvr_Shortcode_Townpress_Posts {

        public static function shortcode( $atts = array(), $content = null, $tag = '' ) {

            // Merge default atts and received atts
            $args = shortcode_atts(
                array(
                    'title' => '',
                    'icon' => '',
                    'category' => 0,
                    'limit' => 8,
                    'featured_limit' => 1,
                    'more_label' => '',
                    'id' => '',
                    'className' => '',
                    'editor_view' => false,
                ),
                $atts
            );

            // Check if editor view
            $editor_view = true === $args['editor_view'] || '1' === $args['editor_view'] || 'true' === $args['editor_view'] ? true : false;

            // Element class
            $class_arr = array( 'lsvr-townpress-posts' );
            if ( true === $editor_view ) {
                array_push( $class_arr, 'lsvr-townpress-posts--editor-view' );
            }
            if ( ! empty( $args['className'] ) ) {
                array_push( $class_arr, $args['className'] );
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

            <section class="<?php echo esc_attr( implode( ' ', $class_arr ) ); ?>"
                <?php echo ! empty( $args['id'] ) ? ' id="' . esc_attr( $args['id'] ) . '"' : ''; ?>>
                <div class="c-content-box lsvr-townpress-posts__inner">

                    <?php if ( ! empty( $args['icon'] ) ) : ?>
                        <i class="lsvr-townpress-posts__icon <?php echo esc_html( $args['icon'] ); ?>"></i>
                    <?php endif; ?>

                    <?php if ( ! empty( $args['title'] ) ) : ?>

                        <header class="lsvr-townpress-posts__header">
                            <h2 class="lsvr-townpress-posts__title<?php if ( ! empty( $args['icon'] ) ) { echo ' lsvr-townpress-posts__title--has-icon'; } ?>">

                                <?php if ( ! empty( $args['icon'] ) ) : ?>
                                    <i class="lsvr-townpress-posts__title-icon <?php echo esc_html( $args['icon'] ); ?>"></i>
                                <?php endif; ?>

                                <?php if ( ! empty( $category_id ) && ! empty( term_exists( $category_id, 'category' ) ) ) : ?>
                                    <a href="<?php echo esc_url( get_term_link( (int) $category_id, 'category' ) ); ?>"
                                        class="lsvr-townpress-posts__title-link">
                                <?php else : ?>
                                    <a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>"
                                        class="lsvr-townpress-posts__title-link">
                                <?php endif; ?>

                                    <?php echo wp_kses( $args['title'], array(
                                        'strong' => array(),
                                    )); ?>

                                </a>

                            </h2>
                        </header>

                    <?php endif; ?>

                    <div class="lsvr-townpress-posts__content">

                        <?php if ( ! empty( $posts ) ) : ?>

                            <ul class="lsvr-townpress-posts__list">

                                <?php $i = 0; foreach ( $posts as $post ) : ?>

                                    <?php // Featured post
                                    if ( ! empty( $args['featured_limit'] ) && $i < (int) $args['featured_limit'] ) : ?>

                                        <li class="lsvr-townpress-posts__item lsvr-townpress-posts__item--featured<?php if ( has_post_thumbnail( $post->ID ) ) { echo ' lsvr-townpress-posts__item--has-thumbnail'; } ?>">

                                            <article <?php post_class( 'lsvr-townpress-posts__post', $post->ID ); ?>>
                                                <div class="lsvr-townpress-posts__post-inner">

                                                    <header class="lsvr-townpress-posts__post-header">

                                                        <?php if ( has_post_thumbnail( $post->ID ) ) : ?>
                                                            <p class="lsvr-townpress-posts__post-thumbnail">
                                                                <a href="<?php echo esc_url( get_the_permalink( $post->ID ) ); ?>"
                                                                    class="lsvr-townpress-posts__post-thumbnail-link"
                                                                    style="background-image: url( '<?php echo esc_url( get_the_post_thumbnail_url( $post->ID, 'full' ) ); ?>' );"></a>
                                                            </p>
                                                        <?php endif; ?>

                                                        <h3 class="lsvr-townpress-posts__post-title">
                                                            <a href="<?php echo esc_url( get_the_permalink( $post->ID ) ); ?>" class="lsvr-townpress-posts__post-title-link" rel="bookmark">
                                                                <?php echo esc_html( $post->post_title ); ?>
                                                            </a>
                                                        </h3>

                                                        <p class="lsvr-townpress-posts__post-meta">
                                                            <time class="lsvr-townpress-posts__post-meta-date"
                                                                datetime="<?php echo esc_attr( get_the_time( 'c', $post->ID  ) ); ?>">
                                                                <?php echo esc_html( get_the_date( get_option( 'post_format' ), $post->ID ) ); ?>
                                                            </time>
                                                            <span class="lsvr-townpress-posts__post-meta-categories">
                                                                <?php lsvr_townpress_toolkit_the_post_terms( $post->ID, 'category', esc_html__( 'in %s', 'lsvr-townpress-toolkit' ), '',  1 ); ?>
                                                            </span>
                                                        </p>

                                                    </header>

                                                    <div class="lsvr-townpress-posts__post-content">

                                                        <?php if ( ! empty( $post->post_excerpt ) ) : ?>

                                                            <?php echo wpautop( wp_kses( $post->post_excerpt, array(
                                                                'a' => array(
                                                                    'href' => array()
                                                                ),
                                                                'strong' => array(),
                                                                'em' => array(),
                                                                'br' => array(),
                                                            ) ) ); ?>

                                                            <p class="lsvr-townpress-posts__post-permalink">
                                                                <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" class="lsvr-townpress-posts__post-permalink-link" rel="bookmark">
                                                                    <?php esc_html_e( 'Read More', 'lsvr-townpress-toolkit' ); ?>
                                                                </a>
                                                            </p>

                                                        <?php elseif ( $post->post_content ) : ?>

                                                            <?php echo wpautop( $post->post_content ); ?>

                                                        <?php endif; ?>

                                                    </div>

                                                </div>
                                            </article>

                                        </li>

                                    <?php // Shortformat post
                                    else : ?>

                                        <li class="lsvr-townpress-posts__item lsvr-townpress-posts__item--short">

                                            <article <?php post_class( 'lsvr-townpress-posts__post', $post->ID ); ?>>

                                                <h3 class="lsvr-townpress-posts__post-title">
                                                    <a href="<?php echo esc_url( get_the_permalink( $post->ID ) ); ?>" class="lsvr-townpress-posts__post-title-link" rel="bookmark">
                                                        <?php echo esc_html( $post->post_title ); ?>
                                                    </a>
                                                </h3>

                                                <p class="lsvr-townpress-posts__post-meta">
                                                    <time class="lsvr-townpress-posts__post-meta-date"
                                                        datetime="<?php echo esc_attr( get_the_time( 'c', $post->ID  ) ); ?>">
                                                        <?php echo esc_html( get_the_date( get_option( 'post_format' ), $post->ID ) ); ?>
                                                    </time>
                                                </p>

                                            </article>

                                        </li>

                                    <?php endif; ?>

                                <?php $i++; endforeach; wp_reset_postdata(); ?>

                            </ul>

                        <?php else : ?>

                            <p class="c-alert-message"><?php esc_html_e( 'There are no posts', 'lsvr-townpress-toolkit' ); ?></p>

                        <?php endif; ?>

                    </div>

                    <?php if ( ! empty( $args[ 'more_label' ] ) ) : ?>
                        <footer class="lsvr-townpress-posts__footer">
                            <p class="lsvr-townpress-posts__more">
                                <?php if ( ! empty( $category_id ) && ! empty( term_exists( $category_id, 'category' ) ) ) : ?>
                                    <a href="<?php echo esc_url( get_term_link( (int) $category_id, 'category' ) ); ?>"
                                        class="lsvr-townpress-posts__more-link"><?php echo esc_html( $args[ 'more_label' ] ); ?></a>
                                <?php else : ?>
                                    <a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>"
                                        class="lsvr-townpress-posts__more-link"><?php echo esc_html( $args[ 'more_label' ] ); ?></a>
                                <?php endif; ?>
                            </p>
                        </footer>
                    <?php endif; ?>

                </div>
            </section>

            <?php return ob_get_clean();

        }

        // Shortcode params
        public static function lsvr_shortcode_atts() {
            return array_merge( array(

                // Title
                array(
                    'name' => 'title',
                    'type' => 'text',
                    'label' => esc_html__( 'Title', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'Title of this section.', 'lsvr-townpress-toolkit' ),
                    'default' => esc_html__( 'Latest News', 'lsvr-townpress-toolkit' ),
                    'priority' => 10,
                ),

                // Icon
                array(
                    'name' => 'icon',
                    'type' => 'text',
                    'label' => esc_html__( 'Icon', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'Icon name. Please refer to the documentation to learn more about icons.', 'lsvr-townpress-toolkit' ),
                    'default' => 'icon-reading',
                    'priority' => 20,
                ),

                // Category
                array(
                    'name' => 'category',
                    'type' => 'taxonomy',
                    'tax' => 'category',
                    'label' => esc_html__( 'Category', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'Display posts from a specific category.', 'lsvr-townpress-toolkit' ),
                    'priority' => 30,
                ),

                // Limit
                array(
                    'name' => 'limit',
                    'type' => 'select',
                    'label' => esc_html__( 'Limit', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'How many posts to display.', 'lsvr-townpress-toolkit' ),
                    'choices' => array( 0 => esc_html__( 'All', 'lsvr-townpress-toolkit' ) ) + range( 0, 20, 1 ),
                    'default' => 4,
                    'priority' => 40,
                ),

                // Featured limit
                array(
                    'name' => 'featured_limit',
                    'type' => 'select',
                    'label' => esc_html__( 'Featured Limit', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'How many posts will be displayed as featured - with excerpt and featured image.', 'lsvr-townpress-toolkit' ),
                    'choices' => range( 0, 15, 1 ),
                    'default' => 1,
                    'priority' => 50,
                ),

                // More Label
                array(
                    'name' => 'more_label',
                    'type' => 'text',
                    'label' => esc_html__( 'More Link Label', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'Link to post archive. Leave blank to hide.', 'lsvr-townpress-toolkit' ),
                    'default' => esc_html__( 'More News', 'lsvr-townpress-toolkit' ),
                    'priority' => 60,
                ),

                // ID
                array(
                    'name' => 'id',
                    'type' => 'text',
                    'label' => esc_html__( 'Unique ID', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'You can use this ID to style this specific element with custom CSS, for example.', 'lsvr-townpress-toolkit' ),
                    'priority' => 70,
                ),

            ), apply_filters( 'lsvr_townpress_posts_shortcode_atts', array() ) );
        }

    }
}
?>