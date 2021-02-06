<?php
/**
 * LSVR Directory widget
 *
 * Display list of lsvr_listing posts
 */
if ( ! class_exists( 'Lsvr_Widget_Listing_List' ) && class_exists( 'Lsvr_Widget' ) ) {
class Lsvr_Widget_Listing_List extends Lsvr_Widget {

    public function __construct() {

    	// Init widget
		parent::__construct(array(
			'id' => 'lsvr_directory_listing_list',
			'classname' => 'lsvr_listing-list-widget',
			'title' => esc_html__( 'LSVR Directory', 'lsvr-directory' ),
			'description' => esc_html__( 'List of Directory listing posts', 'lsvr-directory' ),
			'fields' => array(
				'title' => array(
					'label' => esc_html__( 'Title:', 'lsvr-directory' ),
					'type' => 'text',
					'default' => esc_html__( 'Directory', 'lsvr-directory' ),
				),
				'category' => array(
					'label' => esc_html__( 'Category:', 'lsvr-directory' ),
					'description' => esc_html__( 'Display listings only from a certain category.', 'lsvr-directory' ),
					'type' => 'taxonomy',
					'taxonomy' => 'lsvr_listing_cat',
					'default_label' => esc_html__( 'None', 'lsvr-directory' ),
				),
				'limit' => array(
					'label' => esc_html__( 'Limit:', 'lsvr-directory' ),
					'description' => esc_html__( 'Number of listings to display.', 'lsvr-directory' ),
					'type' => 'select',
					'choices' => array( 0 => esc_html__( 'All', 'lsvr-directory' ), 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ),
					'default' => 4,
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

		// Set posts limit
		$limit = array_key_exists( 'limit', $instance ) && (int) $instance[ 'limit' ] > 0 ? $instance[ 'limit' ] : 1000;

    	// Get person posts
    	$query_args = array(
    		'post_type' => 'lsvr_listing',
    		'posts_per_page' => $limit,
    		'suppress_filters' => false,

		);
		if ( ! empty( $instance['category'] ) && 'none' !== $instance['category'] ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'lsvr_listing_cat',
					'field' => 'term_id',
					'terms' => $instance['category'],
				),
			);
		}
    	$posts = get_posts( $query_args );
        ?>

        <?php // Before widget content
        parent::before_widget_content( $args, $instance ); ?>

        <div class="widget__content lsvr_listing-list-widget__content">

        	<?php if ( ! empty( $posts ) ) : ?>

        		<ul class="lsvr_listing-list-widget__list">
	        		<?php foreach ( $posts as $listing_post ) : ?>

	        			<li class="lsvr_listing-list-widget__item<?php if ( has_post_thumbnail( $listing_post->ID ) ) { echo ' lsvr_listing-list-widget__item--has-thumb'; } ?>">

		        			<?php // Thumbnail
		        			if ( has_post_thumbnail( $listing_post->ID ) ) : ?>
		        				<p class="lsvr_listing-list-widget__item-thumb">
		        					<a href="<?php echo esc_url( get_permalink( $listing_post->ID ) ); ?>" class="lsvr_listing-list-widget__item-thumb-link">
		        						<?php echo get_the_post_thumbnail( $listing_post->ID, 'thumbnail' ); ?>
		        					</a>
		        				</p>
		        			<?php endif; ?>

		        			<div class="lsvr_listing-list-widget__item-content">

			        			<h4 class="lsvr_listing-list-widget__item-title">
			        				<a href="<?php echo esc_url( get_permalink( $listing_post->ID ) ); ?>" class="lsvr_listing-list-widget__item-title-link">
			        					<?php echo get_the_title( $listing_post->ID ); ?>
			        				</a>
			        			</h4>

			        			<?php // Address
			        			if ( true === $show_address && ! empty( get_post_meta( $listing_post->ID, 'lsvr_listing_address', true ) ) ) : ?>
			        				<p class="lsvr_listing-list-widget__item-address">
			        					<?php echo nl2br( esc_html( get_post_meta( $listing_post->ID, 'lsvr_listing_address', true ) ) ); ?>
			        				</p>
			        			<?php endif; ?>

								<?php // Category
								$terms = wp_get_post_terms( $listing_post->ID, 'lsvr_listing_cat' );
								$category_html = '';
								if ( ! empty( $terms ) ) {
									foreach ( $terms as $term ) {
										$category_html .= '<a href="' . esc_url( get_term_link( $term->term_id, 'lsvr_listing_cat' ) ) . '" class="lsvr_listing-list-widget__item-category-link">' . $term->name . '</a>';
										$category_html .= $term !== end( $terms ) ? ', ' : '';
									}
								}
								if ( true === $show_category && ! empty( $category_html ) ) : ?>
									<p class="lsvr_listing-list-widget__item-category">
										<?php echo sprintf( esc_html__( 'in %s', 'lsvr-directory' ), $category_html ); ?>
									</p>
								<?php endif; ?>

							</div>

	        			</li>

	        		<?php endforeach; ?>
        		</ul>

				<?php if ( ! empty( $instance[ 'more_label' ] ) ) : ?>
				<p class="widget__more">
					<?php if ( ! empty( $instance['category'] ) && is_numeric( $instance['category'] ) ) : ?>
						<a href="<?php echo esc_url( get_term_link( (int) $instance['category'], 'lsvr_listing_cat' ) ); ?>" class="widget__more-link"><?php echo esc_html( $instance[ 'more_label' ] ); ?></a>
					<?php else : ?>
						<a href="<?php echo esc_url( get_post_type_archive_link( 'lsvr_listing' ) ); ?>" class="widget__more-link"><?php echo esc_html( $instance[ 'more_label' ] ); ?></a>
					<?php endif; ?>
				</p>
				<?php endif; ?>

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