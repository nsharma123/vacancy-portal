<?php
/**
 * LSVR Featured Person widget
 *
 * Display single lsvr_person post
 */
if ( ! class_exists( 'Lsvr_Widget_Person_Featured' ) && class_exists( 'Lsvr_Widget' ) ) {
class Lsvr_Widget_Person_Featured extends Lsvr_Widget {

    public function __construct() {

    	// Init widget
		parent::__construct(array(
			'id' => 'lsvr_people_person_featured',
			'classname' => 'lsvr_person-featured-widget',
			'title' => esc_html__( 'LSVR Featured Person', 'lsvr-people' ),
			'description' => esc_html__( 'Single Person post', 'lsvr-people' ),
			'fields' => array(
				'title' => array(
					'label' => esc_html__( 'Title:', 'lsvr-people' ),
					'type' => 'text',
					'default' => esc_html__( 'Featured Person', 'lsvr-people' ),
				),
				'post' => array(
					'label' => esc_html__( 'Person:', 'lsvr-people' ),
					'description' => esc_html__( 'Choose person to display', 'lsvr-people' ),
					'type' => 'post',
					'post_type' => 'lsvr_person',
					'default_label' => esc_html__( 'Random', 'lsvr-people' ),
				),
				'show_excerpt' => array(
					'label' => esc_html__( 'Display Excerpt', 'lsvr-people' ),
					'type' => 'checkbox',
					'default' => 'true',
				),
				'show_social' => array(
					'label' => esc_html__( 'Display Social Links', 'lsvr-people' ),
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

    	// Show excerpt
    	$show_excerpt = ! empty( $instance['show_excerpt'] ) && ( true === $instance['show_excerpt'] || 'true' === $instance['show_excerpt'] || '1' === $instance['show_excerpt'] ) ? true : false;

    	// Show social
    	$show_social = ! empty( $instance['show_social'] ) && ( true === $instance['show_social'] || 'true' === $instance['show_social'] || '1' === $instance['show_social'] ) ? true : false;

    	// Get random post
    	if ( empty( $instance['post'] ) || ( ! empty( $instance['post'] ) && 'none' === $instance['post'] ) ) {
    		$person_post = get_posts( array(
    			'post_type' => 'lsvr_person',
    			'orderby' => 'rand',
    			'posts_per_page' => '1'
			));
			$person_post = ! empty( $person_post[0] ) ? $person_post[0] : '';
    	}

    	// Get post
    	else if ( ! empty( $instance['post'] ) ) {
    		$person_post = get_post( $instance['post'] );
    	}

        ?>

        <?php // Before widget content
        parent::before_widget_content( $args, $instance ); ?>

        <div class="widget__content lsvr_person-featured-widget__content">

        	<?php if ( ! empty( $person_post ) ) : ?>

    			<div class="lsvr_person-featured-widget__wrapper<?php if ( has_post_thumbnail( $person_post->ID ) ) { echo ' lsvr_person-featured-widget__wrapper--has-thumb'; } ?>">

        			<?php // Thumbnail
        			if ( has_post_thumbnail( $person_post->ID ) ) : ?>
        				<p class="lsvr_person-featured-widget__thumb">
        					<a href="<?php echo esc_url( get_permalink( $person_post->ID ) ); ?>" class="lsvr_person-featured-widget__thumb-link">
        						<?php echo get_the_post_thumbnail( $person_post->ID, 'thumbnail' ); ?>
        					</a>
        				</p>
        			<?php endif; ?>

        			<h4 class="lsvr_person-featured-widget__title">
        				<a href="<?php echo esc_url( get_permalink( $person_post->ID ) ); ?>" class="lsvr_person-featured-widget__title-link">
        					<?php echo get_the_title( $person_post->ID ); ?>
        				</a>
        			</h4>

        			<?php if ( ! empty( get_post_meta( $person_post->ID, 'lsvr_person_role', true ) ) ) : ?>
        				<h5 class="lsvr_person-featured-widget__subtitle">
        					<?php echo esc_html( get_post_meta( $person_post->ID, 'lsvr_person_role', true ) ); ?>
        				</h5>
        			<?php endif; ?>

					<?php // Excerpt
					if ( true === $show_excerpt && has_excerpt( $person_post->ID ) ) : ?>
						<div class="lsvr_person-featured-widget__excerpt">
							<?php echo wpautop( get_the_excerpt( $person_post->ID ) ); ?>
						</div>
					<?php endif; ?>

        			<?php // Social links
        			if ( true === $show_social ) : ?>

	        			<?php $social_links = lsvr_people_get_person_social_links( $person_post->ID ); ?>
	        			<?php if ( ! empty( $social_links ) ) : ?>

	        				<ul class="lsvr_person-featured-widget__social">

	        					<?php foreach ( $social_links as $type => $link ) : ?>

	        						<li class="lsvr_person-featured-widget__social-item">
	        							<a href="<?php echo esc_url( $link ); ?>" class="lsvr_person-featured-widget__social-link">
	        								<i class="lsvr_person-featured-widget__social-icon lsvr_person-social-icon lsvr_person-social-icon--<?php echo esc_attr( $type ); ?>"></i>
	        							</a>
	        						</li>

	        					<?php endforeach; ?>

	        				</ul>

	        			<?php endif; ?>

	        		<?php endif; ?>

    			</div>

				<?php if ( ! empty( $instance[ 'more_label' ] ) ) : ?>
				<p class="widget__more">
					<a href="<?php echo esc_url( get_post_type_archive_link( 'lsvr_person' ) ); ?>" class="widget__more-link"><?php echo esc_html( $instance[ 'more_label' ] ); ?></a>
				</p>
				<?php endif; ?>

        	<?php else :?>
        		<p class="widget__no-results"><?php esc_html_e( 'Please choose a person to display', 'lsvr-people' ); ?></p>
        	<?php endif; ?>

        </div>

        <?php // After widget content
        parent::after_widget_content( $args, $instance ); ?>

        <?php

    }

}}

?>