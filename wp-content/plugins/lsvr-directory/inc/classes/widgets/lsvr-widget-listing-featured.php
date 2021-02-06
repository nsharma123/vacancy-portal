<?php
/**
 * LSVR Featured Listing widget
 *
 * Single lsvr_listing post
 */
if ( ! class_exists( 'Lsvr_Widget_Listing_Featured' ) && class_exists( 'Lsvr_Widget' ) ) {
class Lsvr_Widget_Listing_Featured extends Lsvr_Widget {

    public function __construct() {

    	// Init widget
		parent::__construct(array(
			'id' => 'lsvr_directory_listing_featured',
			'classname' => 'lsvr_listing-featured-widget',
			'title' => esc_html__( 'LSVR Featured Directory Listing', 'lsvr-directory' ),
			'description' => esc_html__( 'Single directory Listing post', 'lsvr-directory' ),
			'fields' => array(
				'title' => array(
					'label' => esc_html__( 'Title:', 'lsvr-directory' ),
					'type' => 'text',
					'default' => esc_html__( 'Featured Listing', 'lsvr-directory' ),
				),
				'post' => array(
					'label' => esc_html__( 'Listing:', 'lsvr-directory' ),
					'description' => esc_html__( 'Choose listing to display.', 'lsvr-directory' ),
					'type' => 'post',
					'post_type' => 'lsvr_listing',
                    'default_label' => esc_html__( 'Random', 'lsvr-directory' ),
				),
                'show_address' => array(
                    'label' => esc_html__( 'Display Address', 'lsvr-directory' ),
                    'type' => 'checkbox',
                    'default' => 'true',
                ),
                'show_category' => array(
                    'label' => esc_html__( 'Display Category', 'lsvr-directory' ),
                    'type' => 'checkbox',
                    'default' => 'true',
                ),
                'show_excerpt' => array(
                    'label' => esc_html__( 'Display Excerpt', 'lsvr-directory' ),
                    'type' => 'checkbox',
                    'default' => 'false',
                ),
				'more_label' => array(
					'label' => esc_html__( 'More Button Label:', 'lsvr-directory' ),
                    'description' => esc_html__( 'Link to listing post archive. Leave blank to hide.', 'lsvr-directory' ),
					'type' => 'text',
					'default' => esc_html__( 'More Listings', 'lsvr-directory' ),
				),
			),
		));

    }

    function widget( $args, $instance ) {

        // Show address
        $show_address = ! empty( $instance['show_address'] ) && ( true === $instance['show_address'] || 'true' === $instance['show_address'] || '1' === $instance['show_address'] ) ? true : false;

        // Show category
        $show_category = ! empty( $instance['show_category'] ) && ( true === $instance['show_category'] || 'true' === $instance['show_category'] || '1' === $instance['show_category'] ) ? true : false;

        // Show excerpt
        $show_excerpt = ! empty( $instance['show_excerpt'] ) && ( true === $instance['show_excerpt'] || 'true' === $instance['show_excerpt'] || '1' === $instance['show_excerpt'] ) ? true : false;

        // Get random post
        if ( empty( $instance['post'] ) || ( ! empty( $instance['post'] ) && 'none' === $instance['post'] ) ) {
            $listing_post = get_posts( array(
                'post_type' => 'lsvr_listing',
                'orderby' => 'rand',
                'posts_per_page' => '1'
            ));
            $listing_post = ! empty( $listing_post[0] ) ? $listing_post[0] : '';
        }

        // Get post
        else if ( ! empty( $instance['post'] ) ) {
            $listing_post = get_post( $instance['post'] );
        }

       	?>

        <?php // Before widget content
        parent::before_widget_content( $args, $instance ); ?>

        <div class="widget__content lsvr_listing-featured-widget__content">

        	<?php if ( ! empty( $listing_post ) ) : ?>

    			<?php // Thumbnail
    			if ( has_post_thumbnail( $listing_post->ID ) ) : ?>
    				<p class="lsvr_listing-featured-widget__thumb">
    					<a href="<?php echo esc_url( get_permalink( $listing_post->ID ) ); ?>" class="lsvr_listing-featured-widget__thumb-link">
    						<?php echo get_the_post_thumbnail( $listing_post->ID, 'medium' ); ?>
    					</a>
    				</p>
    			<?php endif; ?>

                <div class="lsvr_listing-featured-widget__content-inner">

        			<h4 class="lsvr_listing-featured-widget__title">
        				<a href="<?php echo esc_url( get_permalink( $listing_post->ID ) ); ?>" class="lsvr_listing-featured-widget__title-link">
        					<?php echo get_the_title( $listing_post->ID ); ?>
        				</a>
        			</h4>

					<?php // Address
					if ( true === $show_address && ! empty( get_post_meta( $listing_post->ID, 'lsvr_listing_address', true ) ) ) : ?>
        				<p class="lsvr_listing-featured-widget__address">
        					<?php echo nl2br( esc_html( get_post_meta( $listing_post->ID, 'lsvr_listing_address', true ) ) ); ?>
        				</p>
        			<?php endif; ?>

                    <?php // Category
                    $terms = wp_get_post_terms( $listing_post->ID, 'lsvr_listing_cat' );
                    $category_html = '';
                    if ( ! empty( $terms ) ) {
                        foreach ( $terms as $term ) {
                            $category_html .= '<a href="' . esc_url( get_term_link( $term->term_id, 'lsvr_listing_cat' ) ) . '" class="lsvr_listing-featured-widget__category-link">' . $term->name . '</a>';
                            $category_html .= $term !== end( $terms ) ? ', ' : '';
                        }
                    }
                    if ( true === $show_category && ! empty( $category_html ) ) : ?>
                        <p class="lsvr_listing-featured-widget__category">
                            <?php echo sprintf( esc_html__( 'in %s', 'lsvr-directory' ), $category_html ); ?>
                        </p>
                    <?php endif; ?>

                    <?php // Excerpt
                    if ( true === $show_excerpt && has_excerpt( $listing_post->ID ) ) : ?>
                        <div class="lsvr_listing-featured-widget__excerpt">
                            <?php echo wpautop( get_the_excerpt( $listing_post->ID ) ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( ! empty( $instance[ 'more_label' ] ) ) : ?>
                    <p class="widget__more">
                        <a href="<?php echo esc_url( get_post_type_archive_link( 'lsvr_listing' ) ); ?>" class="widget__more-link"><?php echo esc_html( $instance[ 'more_label' ] ); ?></a>
                    </p>
                    <?php endif; ?>

        		</div>

        	<?php else : ?>
        		<p class="widget__no-results"><?php esc_html_e( 'There are no listings', 'lsvr-directory' ); ?></p>
        	<?php endif; ?>

        </div>

        <?php // After widget content
        parent::after_widget_content( $args, $instance ); ?>

        <?php

    }

}}

?>