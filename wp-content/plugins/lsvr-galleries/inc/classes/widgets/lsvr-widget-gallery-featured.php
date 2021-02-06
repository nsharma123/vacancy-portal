<?php
/**
 * LSVR Featured Gallery widget
 *
 * Single lsvr_gallery post
 */
if ( ! class_exists( 'Lsvr_Widget_Gallery_Featured' ) && class_exists( 'Lsvr_Widget' ) ) {
class Lsvr_Widget_Gallery_Featured extends Lsvr_Widget {

    public function __construct() {

    	// Init widget
		parent::__construct(array(
			'id' => 'lsvr_galleries_gallery_featured',
			'classname' => 'lsvr_gallery-featured-widget',
			'title' => esc_html__( 'LSVR Featured Gallery', 'lsvr-galleries' ),
			'description' => esc_html__( 'Single Gallery post', 'lsvr-galleries' ),
			'fields' => array(
				'title' => array(
					'label' => esc_html__( 'Title:', 'lsvr-galleries' ),
					'type' => 'text',
					'default' => esc_html__( 'Featured Gallery', 'lsvr-galleries' ),
				),
				'post' => array(
					'label' => esc_html__( 'Gallery:', 'lsvr-galleries' ),
					'description' => esc_html__( 'Choose gallery to display.', 'lsvr-galleries' ),
					'type' => 'post',
					'post_type' => 'lsvr_gallery',
					'default_label' => esc_html__( 'Random', 'lsvr-galleries' ),
				),
				'show_date' => array(
					'label' => esc_html__( 'Display Date', 'lsvr-galleries' ),
					'type' => 'checkbox',
					'default' => 'true',
				),
				'show_image_count' => array(
					'label' => esc_html__( 'Display Image Count', 'lsvr-galleries' ),
					'type' => 'checkbox',
					'default' => 'true',
				),
				'show_excerpt' => array(
					'label' => esc_html__( 'Display Excerpt', 'lsvr-galleries' ),
					'type' => 'checkbox',
					'default' => 'true',
				),
				'more_label' => array(
					'label' => esc_html__( 'More Button Label:', 'lsvr-galleries' ),
					'description' => esc_html__( 'Link to gallery post archive. Leave blank to hide.', 'lsvr-galleries' ),
					'type' => 'text',
					'default' => esc_html__( 'More Galleries', 'lsvr-galleries' ),
				),
			),
		));

    }

    function widget( $args, $instance ) {

    	// Show date
    	$show_date = ! empty( $instance['show_date'] ) && ( true === $instance['show_date'] || 'true' === $instance['show_date'] || '1' === $instance['show_date'] ) ? true : false;

    	// Show image count
    	$show_image_count = ! empty( $instance['show_image_count'] ) && ( true === $instance['show_image_count'] || 'true' === $instance['show_image_count'] || '1' === $instance['show_image_count'] ) ? true : false;

    	// Show excerpt
    	$show_excerpt = ! empty( $instance['show_excerpt'] ) && ( true === $instance['show_excerpt'] || 'true' === $instance['show_excerpt'] || '1' === $instance['show_excerpt'] ) ? true : false;

    	// Get random post
    	if ( empty( $instance['post'] ) || ( ! empty( $instance['post'] ) && 'none' === $instance['post'] ) ) {
    		$gallery_post = get_posts( array(
    			'post_type' => 'lsvr_gallery',
    			'orderby' => 'rand',
    			'posts_per_page' => '1'
			));
			$gallery_post = ! empty( $gallery_post[0] ) ? $gallery_post[0] : '';
    	}

    	// Get post
    	else if ( ! empty( $instance['post'] ) ) {
    		$gallery_post = get_post( $instance['post'] );
    	}

        ?>

        <?php // Before widget content
        parent::before_widget_content( $args, $instance ); ?>

        <div class="widget__content lsvr_gallery-featured-widget__content">

        	<?php if ( ! empty( $gallery_post ) ) : ?>

    			<?php // Thumbnail
    			$gallery_thumb = lsvr_galleries_get_single_thumb( $gallery_post->ID );
    			if ( ! empty( $gallery_thumb ) ) : ?>
    				<p class="lsvr_gallery-featured-widget__thumb">
    					<a href="<?php echo esc_url( get_permalink( $gallery_post->ID ) ); ?>" class="lsvr_gallery-featured-widget__thumb-link">
    						<img src="<?php echo esc_url( $gallery_thumb['medium_url'] ); ?>" title="<?php echo esc_attr( $gallery_thumb['title'] ); ?>" alt="<?php echo esc_attr( $gallery_thumb['alt'] ); ?>">
    					</a>
    				</p>
    			<?php endif; ?>

    			<div class="lsvr_gallery-featured-widget__content-inner">

	    			<h4 class="lsvr_gallery-featured-widget__title">
	    				<a href="<?php echo esc_url( get_permalink( $gallery_post->ID ) ); ?>" class="lsvr_gallery-featured-widget__title-link">
	    					<?php echo get_the_title( $gallery_post->ID ); ?>
	    				</a>
	    			</h4>

					<?php // Date
					if ( true === $show_date ) : ?>
						<p class="lsvr_gallery-featured-widget__date">
							<time datetime="<?php echo esc_attr( get_the_time( 'c', $gallery_post->ID ) ); ?>">
								<?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $gallery_post->post_date ) ) ); ?>
							</time>
						</p>
					<?php endif; ?>

					<?php // Images count
					if ( true === $show_image_count && ! empty( lsvr_galleries_get_gallery_images_count( $gallery_post->ID ) ) ) : ?>
						<p class="lsvr_gallery-featured-widget__count">
							<?php echo esc_html( sprintf( _n( '%d image', '%d images', lsvr_galleries_get_gallery_images_count( $gallery_post->ID ), 'lsvr-galleries' ), lsvr_galleries_get_gallery_images_count( $gallery_post->ID ) ) ); ?>
						</p>
					<?php endif; ?>

					<?php // Excerpt
					if ( true === $show_excerpt && has_excerpt( $gallery_post->ID ) ) : ?>
						<div class="lsvr_gallery-featured-widget__excerpt">
							<?php echo wpautop( get_the_excerpt( $gallery_post->ID ) ); ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $instance[ 'more_label' ] ) ) : ?>
					<p class="widget__more">
						<a href="<?php echo esc_url( get_post_type_archive_link( 'lsvr_gallery' ) ); ?>" class="widget__more-link"><?php echo esc_html( $instance[ 'more_label' ] ); ?></a>
					</p>
					<?php endif; ?>

				</div>

        	<?php else : ?>
        		<p class="widget__no-results"><?php esc_html_e( 'There are no galleries', 'lsvr-galleries' ); ?></p>
        	<?php endif; ?>

        </div>

        <?php // After widget content
        parent::after_widget_content( $args, $instance ); ?>

        <?php

    }

}}

?>