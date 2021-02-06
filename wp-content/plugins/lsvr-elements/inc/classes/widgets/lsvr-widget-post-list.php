<?php
/**
 * LSVR Posts widget
 *
 * Display list of posts
 */
if ( ! class_exists( 'Lsvr_Widget_Post_List' ) && class_exists( 'Lsvr_Widget' ) ) {
class Lsvr_Widget_Post_List extends Lsvr_Widget {

    public function __construct() {

    	// Init widget
		parent::__construct(array(
			'id' => 'lsvr_post_list',
			'classname' => 'lsvr-post-list-widget',
			'title' => esc_html__( 'LSVR Posts', 'lsvr-elements' ),
			'description' => esc_html__( 'List of posts', 'lsvr-elements' ),
			'fields' => array(
				'title' => array(
					'label' => esc_html__( 'Title:', 'lsvr-elements' ),
					'type' => 'text',
					'default' => esc_html__( 'News', 'lsvr-elements' ),
				),
				'category' => array(
					'label' => esc_html__( 'Category:', 'lsvr-elements' ),
					'description' => esc_html__( 'Display posts only from certain category.', 'lsvr-elements' ),
					'type' => 'taxonomy',
					'taxonomy' => 'category',
					'default_label' => esc_html__( 'None', 'lsvr-elements' ),
				),
				'limit' => array(
					'label' => esc_html__( 'Limit:', 'lsvr-elements' ),
					'description' => esc_html__( 'Number of posts to display.', 'lsvr-elements' ),
					'type' => 'select',
					'choices' => array( 0 => esc_html__( 'All', 'lsvr-elements' ) ) + range( 0, 10, 1 ),
					'default' => 4,
				),
				'show_thumb' => array(
					'label' => esc_html__( 'Display Thumbnail', 'lsvr-elements' ),
					'type' => 'checkbox',
					'default' => 'true',
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

    	// Show thumb
    	$show_thumb = ! empty( $instance['show_thumb'] ) && ( true === $instance['show_thumb'] || 'true' === $instance['show_thumb'] || '1' === $instance['show_thumb'] ) ? true : false;

    	// Show date
    	$show_date = ! empty( $instance['show_date'] ) && ( true === $instance['show_date'] || 'true' === $instance['show_date'] || '1' === $instance['show_date'] ) ? true : false;

    	// Show category
    	$show_category = ! empty( $instance['show_category'] ) && ( true === $instance['show_category'] || 'true' === $instance['show_category'] || '1' === $instance['show_category'] ) ? true : false;

    	// Get posts
    	$query_args = array(
    		'post_type' => 'post',
    		'posts_per_page' => ! empty( $instance['limit'] ) && (int) $instance[ 'limit' ] > 0 ? (int) $instance[ 'limit' ] : 1000,
    		'suppress_filters' => false,
		);
		if ( ! empty( $instance['category'] ) && 'none' !== $instance['category'] ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'field' => 'term_id',
					'terms' => $instance['category'],
				),
			);
		}
    	$posts = get_posts( $query_args );
        ?>

        <?php // Before widget content
        parent::before_widget_content( $args, $instance ); ?>

        <div class="widget__content">

        	<?php if ( ! empty( $posts ) ) : ?>

        		<ul class="lsvr-post-list-widget__list">
	        		<?php foreach ( $posts as $post ) : ?>

	        			<li class="lsvr-post-list-widget__item<?php if ( true === $show_thumb && has_post_thumbnail( $post->ID ) ) { echo ' lsvr-post-list-widget__item--has-thumb'; } ?>">
	        				<div class="lsvr-post-list-widget__item-inner">

								<?php // Thumbnail
	    						if ( true === $show_thumb && has_post_thumbnail( $post->ID ) ) : ?>

									<p class="lsvr-post-list-widget__item-thumb">
										<a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" class="lsvr-post-list-widget__item-thumb-link">
											<?php echo get_the_post_thumbnail( $post->ID, 'thumbnail' ); ?>
										</a>
									</p>

								<?php endif; ?>

								<div class="lsvr-post-list-widget__item-content">

				        			<h4 class="lsvr-post-list-widget__item-title">
				        				<a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" class="lsvr-post-list-widget__item-title-link">
				        					<?php echo get_the_title( $post->ID ); ?>
				        				</a>
				        			</h4>

									<?php // Date
									if ( true === $show_date ) : ?>
										<p class="lsvr-post-list-widget__item-date">
											<time datetime="<?php echo esc_attr( date( 'c', strtotime( $post->post_date ) ) ); ?>">
												<?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $post->post_date ) ) ); ?>
											</time>
										</p>
									<?php endif; ?>

									<?php // Category
									$terms = wp_get_post_terms( $post->ID, 'category' );
									$category_html = '';
									if ( ! empty( $terms ) ) {
										foreach ( $terms as $term ) {
											$category_html .= '<a href="' . esc_url( get_term_link( $term->term_id, 'category' ) ) . '" class="lsvr-post-list-widget__item-category-link">' . $term->name . '</a>';
											$category_html .= $term !== end( $terms ) ? ', ' : '';
										}
									}
									if ( true === $show_category && ! empty( $category_html ) ) : ?>
										<p class="lsvr-post-list-widget__item-category">
											<?php echo sprintf( esc_html__( 'in %s', 'lsvr-elements' ), $category_html ); ?>
										</p>
									<?php endif; ?>

								</div>

							</div>
        				</li>

	        		<?php endforeach; ?>
        		</ul>

				<?php if ( ! empty( $instance[ 'more_label' ] ) ) : ?>
				<p class="widget__more">
					<?php if ( ! empty( $instance['category'] ) && ! empty( term_exists( (int) $instance['category'], 'category' ) ) ) : ?>
						<a href="<?php echo esc_url( get_term_link( (int) $instance['category'], 'category' ) ); ?>" class="widget__more-link"><?php echo esc_html( $instance[ 'more_label' ] ); ?></a>
					<?php else : ?>
						<a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>" class="widget__more-link"><?php echo esc_html( $instance[ 'more_label' ] ); ?></a>
					<?php endif; ?>
				</p>
				<?php endif; ?>

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