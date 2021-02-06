<?php
/**
 * LSVR Notice widget
 *
 * Display list of lsvr_notice posts
 */
if ( ! class_exists( 'Lsvr_Widget_Notice_List' ) && class_exists( 'Lsvr_Widget' ) ) {
class Lsvr_Widget_Notice_List extends Lsvr_Widget {

    public function __construct() {

    	// Init widget
		parent::__construct(array(
			'id' => 'lsvr_notices_notice_list',
			'classname' => 'lsvr_notice-list-widget',
			'title' => esc_html__( 'LSVR Notices', 'lsvr-notices' ),
			'description' => esc_html__( 'List of Notice posts', 'lsvr-notices' ),
			'fields' => array(
				'title' => array(
					'label' => esc_html__( 'Title:', 'lsvr-notices' ),
					'type' => 'text',
					'default' => esc_html__( 'Notices', 'lsvr-notices' ),
				),
				'category' => array(
					'label' => esc_html__( 'Category:', 'lsvr-notices' ),
					'description' => esc_html__( 'Display notices only from a certain category.', 'lsvr-notices' ),
					'type' => 'taxonomy',
					'taxonomy' => 'lsvr_notice_cat',
					'default_label' => esc_html__( 'None', 'lsvr-notices' ),
				),
				'limit' => array(
					'label' => esc_html__( 'Limit:', 'lsvr-notices' ),
					'description' => esc_html__( 'Number of notices to display.', 'lsvr-notices' ),
					'type' => 'select',
					'choices' => array( 0 => esc_html__( 'All', 'lsvr-notices' ), 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ),
					'default' => 4,
				),
				'show_date' => array(
					'label' => esc_html__( 'Display Date', 'lsvr-notices' ),
					'type' => 'checkbox',
					'default' => 'true',
				),
				'show_category' => array(
					'label' => esc_html__( 'Display Category', 'lsvr-notices' ),
					'type' => 'checkbox',
					'default' => 'true',
				),
				'more_label' => array(
					'label' => esc_html__( 'More Button Label:', 'lsvr-notices' ),
					'description' => esc_html__( 'Link to notice post archive. Leave blank to hide.', 'lsvr-notices' ),
					'type' => 'text',
					'default' => esc_html__( 'More Notices', 'lsvr-notices' ),
				),
			),
		));

    }

    function widget( $args, $instance ) {

    	// Show date
    	$show_date = ! empty( $instance['show_date'] ) && ( true === $instance['show_date'] || 'true' === $instance['show_date'] || '1' === $instance['show_date'] ) ? true : false;

    	// Show category
    	$show_category = ! empty( $instance['show_category'] ) && ( true === $instance['show_category'] || 'true' === $instance['show_category'] || '1' === $instance['show_category'] ) ? true : false;

		// Set posts limit
		$limit = array_key_exists( 'limit', $instance ) && (int) $instance[ 'limit' ] > 0 ? $instance[ 'limit' ] : 1000;

    	// Get notice posts
    	$query_args = array(
    		'post_type' => 'lsvr_notice',
    		'posts_per_page' => $limit,
    		'suppress_filters' => false,
		);
		if ( ! empty( $instance['category'] ) && 'none' !== $instance['category'] ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'lsvr_notice_cat',
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

        		<ul class="lsvr_notice-list-widget__list">
	        		<?php foreach ( $posts as $post ) : ?>

	        			<li class="lsvr_notice-list-widget__item">

		        			<h4 class="lsvr_notice-list-widget__item-title">
		        				<a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" class="lsvr_notice-list-widget__item-title-link">
		        					<?php echo get_the_title( $post->ID ); ?>
		        				</a>
		        			</h4>

		        			<?php if ( ( true === $show_date ) ||
								( true === $show_category && ! empty( wp_get_post_terms( $post->ID, 'category' ) ) ) ) : ?>

								<ul class="lsvr_notice-list-widget__item-meta">

									<?php // Date
									if ( true === $show_date ) : ?>
										<li class="lsvr_notice-list-widget__item-meta-item lsvr_notice-list-widget__item-meta-item--date">
											<time datetime="<?php echo esc_attr( date( 'c', strtotime( $post->post_date ) ) ); ?>">
												<?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $post->post_date ) ) ); ?>
											</time>
										</li>
									<?php endif; ?>

									<?php // Category
									$terms = wp_get_post_terms( $post->ID, 'lsvr_notice_cat' );
									$category_html = '';
									if ( ! empty( $terms ) ) {
										foreach ( $terms as $term ) {
											$category_html .= '<a href="' . esc_url( get_term_link( $term->term_id, 'lsvr_notice_cat' ) ) . '" class="lsvr_notice-list-widget__item-category-link">' . $term->name . '</a>';
											$category_html .= $term !== end( $terms ) ? ', ' : '';
										}
									}
									if ( true === $show_category && ! empty( $category_html ) ) : ?>
										<li class="lsvr_notice-list-widget__item-meta-item lsvr_notice-list-widget__item-meta-item--category">
											<?php echo sprintf( esc_html__( 'in %s', 'lsvr-notices' ), $category_html ); ?>
										</li>
									<?php endif; ?>

								</ul>

							<?php endif; ?>

	        			</li>

	        		<?php endforeach; ?>
        		</ul>

				<?php if ( ! empty( $instance[ 'more_label' ] ) ) : ?>
				<p class="widget__more">
					<?php if ( ! empty( $instance['category'] ) && is_numeric( $instance['category'] ) ) : ?>
						<a href="<?php echo esc_url( get_term_link( (int) $instance['category'], 'lsvr_notice_cat' ) ); ?>" class="widget__more-link"><?php echo esc_html( $instance[ 'more_label' ] ); ?></a>
					<?php else : ?>
						<a href="<?php echo esc_url( get_post_type_archive_link( 'lsvr_notice' ) ); ?>" class="widget__more-link"><?php echo esc_html( $instance[ 'more_label' ] ); ?></a>
					<?php endif; ?>
				</p>
				<?php endif; ?>

        	<?php else : ?>
        		<p class="widget__no-results"><?php esc_html_e( 'There are no notices', 'lsvr-notices' ); ?></p>
        	<?php endif; ?>

        </div>

        <?php // After widget content
        parent::after_widget_content( $args, $instance ); ?>

        <?php

    }

}}

?>