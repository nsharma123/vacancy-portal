<?php
/**
 * LSVR People widget
 *
 * Display list of lsvr_person posts
 */
if ( ! class_exists( 'Lsvr_Widget_Person_List' ) && class_exists( 'Lsvr_Widget' ) ) {
class Lsvr_Widget_Person_List extends Lsvr_Widget {

    public function __construct() {

    	// Init widget
		parent::__construct(array(
			'id' => 'lsvr_people_person_list',
			'classname' => 'lsvr_person-list-widget',
			'title' => esc_html__( 'LSVR People', 'lsvr-people' ),
			'description' => esc_html__( 'List of Person posts', 'lsvr-people' ),
			'fields' => array(
				'title' => array(
					'label' => esc_html__( 'Title:', 'lsvr-people' ),
					'type' => 'text',
					'default' => esc_html__( 'People', 'lsvr-people' ),
				),
				'category' => array(
					'label' => esc_html__( 'Category:', 'lsvr-people' ),
					'description' => esc_html__( 'Display people only from a certain category', 'lsvr-people' ),
					'type' => 'taxonomy',
					'taxonomy' => 'lsvr_person_cat',
					'default_label' => esc_html__( 'None', 'lsvr-people' ),
				),
				'limit' => array(
					'label' => esc_html__( 'Limit:', 'lsvr-people' ),
					'description' => esc_html__( 'Number of people to display', 'lsvr-people' ),
					'type' => 'select',
					'choices' => array( 0 => esc_html__( 'All', 'lsvr-people' ), 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ),
					'default' => 4,
				),
				'show_social' => array(
					'label' => esc_html__( 'Display Social Links', 'lsvr-documents' ),
					'type' => 'checkbox',
					'default' => 'true',
				),
				'more_label' => array(
					'label' => esc_html__( 'More Button Label:', 'lsvr-people' ),
					'description' => esc_html__( 'Link to person post archive. Leave blank to hide', 'lsvr-people' ),
					'type' => 'text',
					'default' => esc_html__( 'More People', 'lsvr-people' ),
				),
			),
		));

    }

    function widget( $args, $instance ) {

    	// Show social
    	$show_social = ! empty( $instance['show_social'] ) && ( true === $instance['show_social'] || 'true' === $instance['show_social'] || '1' === $instance['show_social'] ) ? true : false;

		// Set posts limit
		$limit = array_key_exists( 'limit', $instance ) && (int) $instance[ 'limit' ] > 0 ? $instance[ 'limit' ] : 1000;

    	// Get person posts
    	$query_args = array(
    		'post_type' => 'lsvr_person',
    		'posts_per_page' => $limit,
    		'suppress_filters' => false,
		);
		if ( ! empty( $instance['category'] ) && 'none' !== $instance['category'] ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'lsvr_person_cat',
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

        		<ul class="lsvr_person-list-widget__list">
	        		<?php foreach ( $posts as $person_post ) : ?>

	        			<li class="lsvr_person-list-widget__item<?php if ( has_post_thumbnail( $person_post->ID ) ) { echo ' lsvr_person-list-widget__item--has-thumb'; } ?>">
	        				<div class="lsvr_person-list-widget__item-inner">

			        			<?php // Thumbnail
			        			if ( has_post_thumbnail( $person_post->ID ) ) : ?>
			        				<p class="lsvr_person-list-widget__item-thumb">
			        					<a href="<?php echo esc_url( get_permalink( $person_post->ID ) ); ?>" class="lsvr_person-list-widget__item-thumb-link">
			        						<?php echo get_the_post_thumbnail( $person_post->ID, 'thumbnail' ); ?>
			        					</a>
			        				</p>
			        			<?php endif; ?>

			        			<h4 class="lsvr_person-list-widget__item-title">
			        				<a href="<?php echo esc_url( get_permalink( $person_post->ID ) ); ?>" class="lsvr_person-list-widget__item-title-link">
			        					<?php echo get_the_title( $person_post->ID ); ?>
			        				</a>
			        			</h4>

			        			<?php // Role
			        			if ( ! empty( get_post_meta( $person_post->ID, 'lsvr_person_role', true ) ) ) : ?>
			        				<h5 class="lsvr_person-list-widget__item-subtitle">
			        					<?php echo esc_html( get_post_meta( $person_post->ID, 'lsvr_person_role', true ) ); ?>
			        				</h5>
			        			<?php endif; ?>

								<?php // Social links
								$social_links = lsvr_people_get_person_social_links( $person_post->ID );
								if ( true === $show_social && ! empty( $social_links ) ) : ?>

									<ul class="lsvr_person-list-widget__item-social">

										<?php foreach ( $social_links as $profile => $link ) : ?>

											<li class="lsvr_person-list-widget__item-social-item">
												<a href="<?php echo esc_url( $link ); ?>" class="lsvr_person-list-widget__item-social-link" target="_blank">
													<i class="lsvr_person-list-widget__item-social-icon lsvr_person-social-icon lsvr_person-social-icon--<?php echo esc_attr( $profile ); ?>"></i>
												</a>
											</li>

										<?php endforeach; ?>

									</ul>

								<?php endif; ?>

							</div>
	        			</li>

	        		<?php endforeach; ?>
        		</ul>

				<?php if ( ! empty( $instance[ 'more_label' ] ) ) : ?>
				<p class="widget__more">
					<?php if ( ! empty( $instance['category'] ) && is_numeric( $instance['category'] ) ) : ?>
						<a href="<?php echo esc_url( get_term_link( (int) $instance['category'], 'lsvr_person_cat' ) ); ?>" class="widget__more-link"><?php echo esc_html( $instance[ 'more_label' ] ); ?></a>
					<?php else : ?>
						<a href="<?php echo esc_url( get_post_type_archive_link( 'lsvr_person' ) ); ?>" class="widget__more-link"><?php echo esc_html( $instance[ 'more_label' ] ); ?></a>
					<?php endif; ?>
				</p>
				<?php endif; ?>

        	<?php else : ?>
        		<p class="widget__no-results"><?php esc_html_e( 'There are no people', 'lsvr-people' ); ?></p>
        	<?php endif; ?>

        </div>

        <?php // After widget content
        parent::after_widget_content( $args, $instance ); ?>

        <?php

    }

}}

?>