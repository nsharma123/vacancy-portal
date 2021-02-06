<?php
/**
 * LSVR Featured Event widget
 *
 * Display single lsvr_event posts
 */
if ( ! class_exists( 'Lsvr_Widget_Event_Featured' ) && class_exists( 'Lsvr_Widget' ) ) {
class Lsvr_Widget_Event_Featured extends Lsvr_Widget {

    public function __construct() {

    	// Init widget
		parent::__construct(array(
			'id' => 'lsvr_events_event_featured',
			'classname' => 'lsvr_event-featured-widget',
			'title' => esc_html__( 'LSVR Featured Event', 'lsvr-events' ),
			'description' => esc_html__( 'Single Event post', 'lsvr-events' ),
			'fields' => array(
				'title' => array(
					'label' => esc_html__( 'Title:', 'lsvr-events' ),
					'type' => 'text',
					'default' => esc_html__( 'Featured Event', 'lsvr-events' ),
				),
				'post' => array(
					'label' => esc_html__( 'Event:', 'lsvr-events' ),
					'description' => esc_html__( 'Choose event to display.', 'lsvr-events' ),
					'type' => 'post',
					'post_type' => 'lsvr_event',
                    'default_label' => esc_html__( 'Random', 'lsvr-events' ),
				),
                'show_excerpt' => array(
                    'label' => esc_html__( 'Display Excerpt', 'lsvr-events' ),
                    'type' => 'checkbox',
                    'default' => 'true',
                ),
				'more_label' => array(
					'label' => esc_html__( 'More Button Label:', 'lsvr-events' ),
					'description' => esc_html__( 'Link to event post archive. Leave blank to hide.', 'lsvr-events' ),
					'type' => 'text',
					'default' => esc_html__( 'More Events', 'lsvr-events' ),
				),
			),
		));

    }

    function widget( $args, $instance ) {

        // Show excerpt
        $show_excerpt = ! empty( $instance['show_excerpt'] ) && ( true === $instance['show_excerpt'] || 'true' === $instance['show_excerpt'] || '1' === $instance['show_excerpt'] ) ? true : false;

        // Get random post
        if ( empty( $instance['post'] ) || ( ! empty( $instance['post'] ) && 'none' === $instance['post'] ) ) {
            $event_post = get_posts( array(
                'post_type' => 'lsvr_event',
                'orderby' => 'rand',
                'posts_per_page' => '1'
            ));
            $event_post = ! empty( $event_post[0] ) ? $event_post[0] : '';
        }

        // Get post
        else if ( ! empty( $instance['post'] ) ) {
            $event_post = get_post( $instance['post'] );
        }

        ?>

        <?php // Before widget content
        parent::before_widget_content( $args, $instance ); ?>

        <div class="widget__content lsvr_event-featured-widget__content">

        	<?php if ( ! empty( $event_post ) ) : ?>

                <?php // Thumbnail
                if ( has_post_thumbnail( $event_post->ID ) ) : ?>
                    <p class="lsvr_event-featured-widget__thumb">
                        <a href="<?php echo esc_url( get_permalink( $event_post->ID ) ); ?>" class="lsvr_event-featured-widget__thumb-link">
                            <?php echo get_the_post_thumbnail( $event_post->ID, 'medium' ); ?>
                        </a>
                    </p>
                <?php endif; ?>

        		<div class="lsvr_event-featured-widget__content-inner">

                    <?php $upcoming_occurrence = lsvr_events_get_next_occurrences( $event_post->ID );
                    if ( ! empty( $upcoming_occurrence[0] ) ) {
                        $event_occurrence = $upcoming_occurrence[0];
                    }
                    else if ( empty( $upcoming_occurrence ) ) {
                        $past_occurrence = lsvr_events_get_recent_occurrences( $event_post->ID );
                        if ( ! empty( $past_occurrence[0] ) ) {
                            $event_occurrence = $past_occurrence[0];
                        }
                    } ?>

                    <?php if ( ! empty( $event_occurrence ) ) : ?>

            			<h4 class="lsvr_event-featured-widget__title">
            				<a href="<?php echo esc_url( get_permalink( $event_post->ID ) ); ?>" class="lsvr_event-featured-widget__title-link">
            					<?php echo get_the_title( $event_post->ID ); ?>
            				</a>
            			</h4>

                        <p class="lsvr_event-featured-widget__date">
                            <time datetime="<?php echo esc_attr( date_i18n( get_option( 'date_format' ), strtotime( $event_occurrence['start'] ) ) ); ?>">
                                <?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $event_occurrence['start'] ) ) ); ?>
                            </time>
                        </p>

                        <p class="lsvr_event-featured-widget__info">

                            <span class="lsvr_event-featured-widget__time">
                                <?php // Time
                                if ( ! empty( $event_occurrence['allday'] ) && true === $event_occurrence['allday'] ) {
                                    esc_html_e( 'All-day event', 'lsvr-events' );
                                }
                                else if ( ! empty( $event_occurrence['postid'] ) && 'true' === get_post_meta( $event_occurrence['postid'], 'lsvr_event_end_time_enable', true ) ) {
                                    echo sprintf( esc_html__( '%s - %s', 'lsvr-events' ),
                                        lsvr_events_get_event_local_start_time( $event_occurrence['postid'] ),
                                        lsvr_events_get_event_local_end_time( $event_occurrence['postid'] )
                                    );
                                }
                                else {
                                    echo esc_html( lsvr_events_get_event_local_start_time( $event_occurrence['postid'] ) );
                                } ?>
                            </span>

                            <?php // Location
                            $event_location_term = wp_get_post_terms( $event_occurrence['postid'], 'lsvr_event_location' ); ?>
                            <?php if ( ! empty( $event_location_term[0]->term_id ) ) {
                                $location_term_id = $event_location_term[0]->term_id;
                                $location_data = get_term( $location_term_id, 'lsvr_event_location' );
                                $location_permalink = get_term_link( $location_term_id, 'lsvr_event_location' );
                                if ( ! empty( $location_data->name ) ) : ?>
                                    <span class="lsvr_event-featured-widget__location">
                                        <?php echo sprintf( esc_html__( 'at %s', 'lsvr-events' ), '<a href="' . esc_attr( $location_permalink ) . '" class="lsvr_event-featured-widget__location-link">' . esc_html( $location_data->name ) . '</a>' ); ?>
                                    </span>
                                <?php endif;
                            } ?>

                        </p>

                        <?php // Excerpt
                        if ( true === $show_excerpt && has_excerpt( $event_post->ID ) ) : ?>
                            <div class="lsvr_event-featured-widget__excerpt">
                                <?php echo wpautop( get_the_excerpt( $event_post->ID ) ); ?>
                            </div>
                        <?php endif; ?>

                    <?php endif; ?>

                    <?php if ( ! empty( $instance[ 'more_label' ] ) ) : ?>
                    <p class="widget__more">
                        <a href="<?php echo esc_url( get_post_type_archive_link( 'lsvr_event' ) ); ?>" class="widget__more-link"><?php echo esc_html( $instance[ 'more_label' ] ); ?></a>
                    </p>
                    <?php endif; ?>

    			</div>

        	<?php else : ?>
                <p class="widget__no-results"><?php esc_html_e( 'There are no events', 'lsvr-galleries' ); ?></p>
        	<?php endif; ?>

        </div>

        <?php // After widget content
        parent::after_widget_content( $args, $instance ); ?>

        <?php

    }

}}

?>