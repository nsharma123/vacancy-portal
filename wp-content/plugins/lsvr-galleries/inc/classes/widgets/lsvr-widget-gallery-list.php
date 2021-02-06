<?php
/**
 * LSVR Galleries widget
 *
 * Display list of lsvr_gallery posts
 */
if ( ! class_exists( 'Lsvr_Widget_Gallery_List' ) && class_exists( 'Lsvr_Widget' ) ) {
class Lsvr_Widget_Gallery_List extends Lsvr_Widget {

    public function __construct() {

    	// Init widget
		parent::__construct(array(
			'id' => 'lsvr_galleries_gallery_list',
			'classname' => 'lsvr_gallery-list-widget',
			'title' => esc_html__( 'LSVR Galleries', 'lsvr-galleries' ),
			'description' => esc_html__( 'List of Gallery posts', 'lsvr-galleries' ),
			'fields' => array(
				'title' => array(
					'label' => esc_html__( 'Title:', 'lsvr-galleries' ),
					'type' => 'text',
					'default' => esc_html__( 'Galleries', 'lsvr-galleries' ),
				),
				'category' => array(
					'label' => esc_html__( 'Category:', 'lsvr-galleries' ),
					'description' => esc_html__( 'Display galleries only from a certain category.', 'lsvr-galleries' ),
					'type' => 'taxonomy',
					'taxonomy' => 'lsvr_gallery_cat',
					'default_label' => esc_html__( 'None', 'lsvr-galleries' ),
				),
				'limit' => array(
					'label' => esc_html__( 'Limit:', 'lsvr-galleries' ),
					'description' => esc_html__( 'Number of galleries to display.', 'lsvr-galleries' ),
					'type' => 'select',
					'choices' => array( 0 => esc_html__( 'All', 'lsvr-galleries' ), 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ),
					'default' => 4,
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

    	// Get gallery posts
    	$query_args = array(
    		'limit' => array_key_exists( 'limit', $instance ) ? $instance[ 'limit' ] : 4,
		);
		if ( ! empty( $instance['category'] ) && 'none' !== $instance['category'] ) {
			$query_args['category'] = $instance['category'];
		}
    	$posts = lsvr_galleries_get( $query_args );

        ?>

        <?php // Before widget content
        parent::before_widget_content( $args, $instance ); ?>

        <div class="widget__content">

        	<?php if ( ! empty( $posts ) ) : ?>

        		<ul class="lsvr_gallery-list-widget__list">
	        		<?php foreach ( $posts as $gallery_id => $gallery_post ) : ?>

						<?php $gallery_thumb = lsvr_galleries_get_single_thumb( $gallery_id );
	        			$gallery_post = $gallery_post['post']; ?>

	        			<li class="lsvr_gallery-list-widget__item<?php if ( ! empty( $gallery_thumb ) ) { echo ' lsvr_gallery-list-widget__item--has-thumb'; } ?>">
	        				<div class="lsvr_gallery-list-widget__item-inner">

								<?php if ( ! empty( $gallery_thumb['thumb_url'] ) ) : ?>

									<p class="lsvr_gallery-list-widget__item-thumb">
										<a href="<?php echo esc_url( get_permalink( $gallery_id ) ); ?>" class="lsvr_gallery-list-widget__item-thumb-link">
											<img src="<?php echo esc_url( $gallery_thumb['thumb_url'] ); ?>"
												class="lsvr_gallery-list-widget__item-thumb-img"
												title="<?php echo esc_attr( $gallery_post->post_title ); ?>"
												alt="<?php echo esc_attr( $gallery_thumb['alt'] ); ?>">
										</a>
									</p>

								<?php endif; ?>

								<div class="lsvr_gallery-list-widget__item-content">

									<h4 class="lsvr_gallery-list-widget__item-title">
										<a href="<?php echo esc_url( get_permalink( $gallery_id ) ); ?>" class="lsvr_gallery-list-widget__item-title-link">
											<?php echo esc_html( $gallery_post->post_title ); ?>
										</a>
									</h4>

									<?php // Date
									if ( true === $show_date ) : ?>
										<p class="lsvr_gallery-list-widget__item-date">
											<time datetime="<?php echo esc_attr( get_the_time( 'c', $gallery_post->ID ) ); ?>">
												<?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $gallery_post->post_date ) ) ); ?>
											</time>
										</p>
									<?php endif; ?>

									<?php // Image count
									if ( true === $show_image_count && ! empty( lsvr_galleries_get_gallery_images_count( $gallery_post->ID ) ) ) : ?>
										<p class="lsvr_gallery-list-widget__item-count">
											<?php echo esc_html( sprintf( _n( '%d image', '%d images', lsvr_galleries_get_gallery_images_count( $gallery_post->ID ), 'lsvr-galleries' ), lsvr_galleries_get_gallery_images_count( $gallery_post->ID ) ) ); ?>
										</p>
									<?php endif; ?>

								</div>

							</div>
	        			</li>

	        		<?php endforeach; ?>
        		</ul>

				<?php if ( ! empty( $instance[ 'more_label' ] ) ) : ?>
				<p class="widget__more">
					<?php if ( ! empty( $instance['category'] ) && is_numeric( $instance['category'] ) ) : ?>
						<a href="<?php echo esc_url( get_term_link( (int) $instance['category'], 'lsvr_gallery_cat' ) ); ?>" class="widget__more-link"><?php echo esc_html( $instance[ 'more_label' ] ); ?></a>
					<?php else : ?>
						<a href="<?php echo esc_url( get_post_type_archive_link( 'lsvr_gallery' ) ); ?>" class="widget__more-link"><?php echo esc_html( $instance[ 'more_label' ] ); ?></a>
					<?php endif; ?>
				</p>
				<?php endif; ?>

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