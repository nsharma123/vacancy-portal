<?php
/**
 * LSVR Events widget
 *
 * Display list of lsvr_event posts
 */
if ( ! class_exists( 'Lsvr_Widget_Event_List' ) && class_exists( 'Lsvr_Widget' ) ) {
class Lsvr_Widget_Event_List extends Lsvr_Widget {

    public function __construct() {

    	// Init widget
		parent::__construct(array(
			'id' => 'lsvr_events_event_list',
			'classname' => 'lsvr_event-list-widget',
			'title' => esc_html__( 'LSVR Events', 'lsvr-events' ),
			'description' => esc_html__( 'List of Event posts', 'lsvr-events' ),
			'fields' => array(
				'title' => array(
					'label' => esc_html__( 'Title:', 'lsvr-events' ),
					'type' => 'text',
					'default' => esc_html__( 'Upcoming Events', 'lsvr-events' ),
				),
				'location' => array(
					'label' => esc_html__( 'Location:', 'lsvr-events' ),
					'description' => esc_html__( 'Display events only from a certain location.', 'lsvr-events' ),
					'type' => 'taxonomy',
					'taxonomy' => 'lsvr_event_location',
					'default_label' => esc_html__( 'None', 'lsvr-events' ),
				),
				'category' => array(
					'label' => esc_html__( 'Category:', 'lsvr-events' ),
					'description' => esc_html__( 'Display events only from a certain category.', 'lsvr-events' ),
					'type' => 'taxonomy',
					'taxonomy' => 'lsvr_event_cat',
					'default_label' => esc_html__( 'None', 'lsvr-events' ),
				),
				'limit' => array(
					'label' => esc_html__( 'Limit:', 'lsvr-events' ),
					'description' => esc_html__( 'Number of events to display.', 'lsvr-events' ),
					'type' => 'select',
					'choices' => array( 0 => esc_html__( 'All', 'lsvr-events' ), 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ),
					'default' => 4,
				),
                'bold_date' => array(
                    'label' => esc_html__( 'Bold Date', 'lsvr-events' ),
                    'description' => esc_html__( 'Display date in more graphical style. Thumbnail image won\'t be displayed.', 'lsvr-events' ),
                    'type' => 'checkbox',
                    'default' => 'false',
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

    	// Bold date
    	$bold_date = ! empty( $instance['bold_date'] ) && ( true === $instance['bold_date'] || 'true' === $instance['bold_date'] || '1' === $instance['bold_date'] ) ? true : false;

    	// Get posts
    	$query_args = array(
    		'period' => 'future',
			'orderby' => 'start',
			'to_return' => 'occurrences',
    		'limit' => array_key_exists( 'limit', $instance ) ? $instance[ 'limit' ] : 4,
		);
		if ( ! empty( $instance['location'] ) && 'none' !== $instance['location'] ) {
			$query_args['location'] = $instance['location'];
		}
		if ( ! empty( $instance['category'] ) && 'none' !== $instance['category'] ) {
			$query_args['category'] = $instance['category'];
		}
    	$posts = lsvr_events_get( $query_args );

        ?>

        <?php // Before widget content
        parent::before_widget_content( $args, $instance ); ?>

        <div class="widget__content">

        	<?php if ( ! empty( $posts['occurrences'] ) ) : ?>

        		<ul class="lsvr_event-list-widget__list<?php if ( true === $bold_date ) { echo ' lsvr_event-list-widget__list--has-bold-date'; } ?>">
	        		<?php foreach ( $posts['occurrences'] as $event_occurrence ) : ?>

	        			<li class="lsvr_event-list-widget__item<?php if ( has_post_thumbnail( $event_occurrence['postid'] ) ) { echo ' lsvr_event-list-widget__item--has-thumb'; } ?>">

		        			<?php // Thumbnail
		        			if ( has_post_thumbnail( $event_occurrence['postid'] ) && ! $bold_date ) : ?>

		        				<p class="lsvr_event-list-widget__item-thumb">
		        					<a href="<?php echo esc_url( get_permalink( $event_occurrence['postid'] ) ); ?>" class="lsvr_event-list-widget__item-thumb-link">
		        						<?php echo get_the_post_thumbnail( $event_occurrence['postid'], 'thumbnail' ); ?>
		        					</a>
		        				</p>

		        			<?php // Bold date
		        			elseif ( true === $bold_date ) : ?>

								<p class="lsvr_event-list-widget__item-date lsvr_event-list-widget__item-date--bold"
									title="<?php echo esc_attr( date_i18n( get_option( 'date_format' ), strtotime( $event_occurrence['start'] ) ) ); ?>">
									<time datetime="<?php echo esc_attr( date_i18n( get_option( 'date_format' ), strtotime( $event_occurrence['start'] ) ) ); ?>">
										<span class="lsvr_event-list-widget__item-date-month"><?php echo date_i18n( 'M', strtotime( $event_occurrence['start'] ) ); ?></span>
										<span class="lsvr_event-list-widget__item-date-day"><?php echo date_i18n( 'j', strtotime( $event_occurrence['start'] ) ); ?></span>
									</time>
								</p>

		        			<?php endif; ?>

		        			<h4 class="lsvr_event-list-widget__item-title">
		        				<a href="<?php echo esc_url( get_permalink( $event_occurrence['postid'] ) ); ?>" class="lsvr_event-list-widget__item-title-link">
		        					<?php echo get_the_title( $event_occurrence['postid'] ); ?>
		        				</a>
		        			</h4>

	        				<?php if ( ! $bold_date ) : ?>

								<p class="lsvr_event-list-widget__item-date">
									<time datetime="<?php echo esc_attr( date_i18n( get_option( 'date_format' ), strtotime( $event_occurrence['start'] ) ) ); ?>">
										<?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $event_occurrence['start'] ) ) ); ?>
									</time>
								</p>

							<?php endif; ?>

		        			<p class="lsvr_event-list-widget__item-info">

								<span class="lsvr_event-list-widget__item-time">
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
										<span class="lsvr_event-list-widget__item-location">
											<?php echo sprintf( esc_html__( 'at %s', 'lsvr-events' ), '<a href="' . esc_attr( $location_permalink ) . '" class="lsvr_event-list-widget__item-location-link">' . esc_html( $location_data->name ) . '</a>' ); ?>
										</span>
									<?php endif;
								} ?>

							</p>

	        			</li>

	        		<?php endforeach; ?>
        		</ul>

				<?php if ( ! empty( $instance[ 'more_label' ] ) ) : ?>
				<p class="widget__more">
					<?php if ( ! empty( $instance['location'] ) && is_numeric( $instance['location'] ) ) : ?>
						<a href="<?php echo esc_url( get_term_link( (int) $instance['location'], 'lsvr_event_location' ) ); ?>" class="widget__more-link"><?php echo esc_html( $instance[ 'more_label' ] ); ?></a>
					<?php elseif ( ! empty( $instance['category'] ) && is_numeric( $instance['category'] ) ) : ?>
						<a href="<?php echo esc_url( get_term_link( (int) $instance['category'], 'lsvr_event_cat' ) ); ?>" class="widget__more-link"><?php echo esc_html( $instance[ 'more_label' ] ); ?></a>
					<?php else : ?>
						<a href="<?php echo esc_url( get_post_type_archive_link( 'lsvr_event' ) ); ?>" class="widget__more-link"><?php echo esc_html( $instance[ 'more_label' ] ); ?></a>
					<?php endif; ?>
				</p>
				<?php endif; ?>

        	<?php else : ?>
        		<p class="widget__no-results"><?php esc_html_e( 'There are no events', 'lsvr-events' ); ?></p>
        	<?php endif; ?>

        </div>

        <?php // After widget content
        parent::after_widget_content( $args, $instance ); ?>

        <?php

    }

}}

?>