<?php
/**
 * LSVR Featured post widget
 *
 * Single post
 */
if ( ! class_exists( 'Lsvr_Widget_Post_Featured' ) && class_exists( 'Lsvr_Widget' ) ) {
class Lsvr_Widget_Post_Featured extends Lsvr_Widget {

    public function __construct() {

    	// Init widget
		parent::__construct(array(
			'id' => 'lsvr_post_featured',
			'classname' => 'lsvr-post-featured-widget',
			'title' => esc_html__( 'LSVR Featured Post', 'lsvr-elements' ),
			'description' => esc_html__( 'Single post', 'lsvr-elements' ),
			'fields' => array(
				'title' => array(
					'label' => esc_html__( 'Title:', 'lsvr-elements' ),
					'type' => 'text',
					'default' => esc_html__( 'Featured Post', 'lsvr-elements' ),
				),
				'post' => array(
					'label' => esc_html__( 'Post:', 'lsvr-elements' ),
					'description' => esc_html__( 'Choose post to display.', 'lsvr-elements' ),
					'type' => 'post',
					'post_type' => 'post',
                    'default_label' => esc_html__( 'Random', 'lsvr-elements' ),
				),
                'show_date' => array(
                    'label' => esc_html__( 'Display Date', 'lsvr-elements' ),
                    'type' => 'checkbox',
                    'default' => 'true',
                ),
                'show_category' => array(
                    'label' => esc_html__( 'Display Category', 'lsvr-elements' ),
                    'type' => 'checkbox',
                    'default' => 'true',
                ),
                'show_excerpt' => array(
                    'label' => esc_html__( 'Display Excerpt', 'lsvr-elements' ),
                    'type' => 'checkbox',
                    'default' => 'true',
                ),
				'more_label' => array(
					'label' => esc_html__( 'More Button Label:', 'lsvr-elements' ),
                    'description' => esc_html__( 'Link to post archive. Leave blank to hide.', 'lsvr-elements' ),
					'type' => 'text',
					'default' => esc_html__( 'More Posts', 'lsvr-elements' ),
				),
			),
		));

    }

    function widget( $args, $instance ) {

        // Show date
        $show_date = ! empty( $instance['show_date'] ) && ( true === $instance['show_date'] || 'true' === $instance['show_date'] || '1' === $instance['show_date'] ) ? true : false;

        // Show category
        $show_category = ! empty( $instance['show_category'] ) && ( true === $instance['show_category'] || 'true' === $instance['show_category'] || '1' === $instance['show_category'] ) ? true : false;

        // Show excerpt
        $show_excerpt = ! empty( $instance['show_excerpt'] ) && ( true === $instance['show_excerpt'] || 'true' === $instance['show_excerpt'] || '1' === $instance['show_excerpt'] ) ? true : false;

        // Get random post
        if ( empty( $instance['post'] ) || ( ! empty( $instance['post'] ) && 'none' === $instance['post'] ) ) {
            $post = get_posts( array(
                'post_type' => 'post',
                'orderby' => 'rand',
                'posts_per_page' => '1'
            ));
            $post = ! empty( $post[0] ) ? $post[0] : '';
        }

        // Get post
        else if ( ! empty( $instance['post'] ) ) {
            $post = get_post( $instance['post'] );
        }

       	?>

        <?php // Before widget content
        parent::before_widget_content( $args, $instance ); ?>

        <div class="widget__content lsvr-post-featured-widget__content">

        	<?php if ( ! empty( $post ) ) : ?>

    			<?php // Thumbnail
    			if ( has_post_thumbnail( $post->ID ) ) : ?>
    				<p class="lsvr-post-featured-widget__thumb">
    					<a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" class="lsvr-post-featured-widget__thumb-link">
    						<?php echo get_the_post_thumbnail( $post->ID, 'medium' ); ?>
    					</a>
    				</p>
    			<?php endif; ?>

                <div class="lsvr-post-featured-widget__content-inner">

        			<h4 class="lsvr-post-featured-widget__title">
        				<a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" class="lsvr-post-featured-widget__title-link">
        					<?php echo get_the_title( $post->ID ); ?>
        				</a>
        			</h4>

                    <?php // Date
                    if ( true === $show_date ) : ?>
                        <p class="lsvr-post-featured-widget__date">
                            <time datetime="<?php echo esc_attr( get_the_time( 'c', $post->ID ) ); ?>"><?php echo esc_html( get_the_date( get_option( 'date_format' ), $post->ID ) ); ?></time>
                        </p>
                    <?php endif; ?>

                    <?php // Category
                    $terms = wp_get_post_terms( $post->ID, 'category' );
                    $category_html = '';
                    if ( ! empty( $terms ) ) {
                        foreach ( $terms as $term ) {
                            $category_html .= '<a href="' . esc_url( get_term_link( $term->term_id, 'category' ) ) . '" class="lsvr-post-featured-widget__category-link">' . $term->name . '</a>';
                            $category_html .= $term !== end( $terms ) ? ', ' : '';
                        }
                    }
                    if ( true === $show_category && ! empty( $category_html ) ) : ?>
                        <p class="lsvr-post-featured-widget__category">
                            <?php echo sprintf( esc_html__( 'in %s', 'lsvr-elements' ), $category_html ); ?>
                        </p>
                    <?php endif; ?>

                    <?php // Excerpt
                    if ( true === $show_excerpt && has_excerpt( $post->ID ) ) : ?>
                        <div class="lsvr-post-featured-widget__excerpt">
                            <?php echo wpautop( get_the_excerpt( $post->ID ) ); ?>
                            <p class="lsvr-post-featured-widget__excerpt-more">
                                <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" class="lsvr-post-featured-widget__excerpt-more-link"><?php esc_html_e( 'Read More', 'lsvr-elements' ); ?></a>
                            </p>
                        </div>
                    <?php endif; ?>

                    <?php if ( ! empty( $instance[ 'more_label' ] ) ) : ?>
                    <p class="widget__more">
                        <a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>" class="widget__more-link"><?php echo esc_html( $instance[ 'more_label' ] ); ?></a>
                    </p>
                    <?php endif; ?>

        		</div>

        	<?php else : ?>
        		<p class="widget__no-results"><?php esc_html_e( 'There are no posts', 'lsvr-elements' ); ?></p>
        	<?php endif; ?>

        </div>

        <?php // After widget content
        parent::after_widget_content( $args, $instance ); ?>

        <?php

    }

}}

?>