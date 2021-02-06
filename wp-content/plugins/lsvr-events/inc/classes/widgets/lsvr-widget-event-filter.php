<?php
/**
 * LSVR Event Filter widget
 *
 * Display list form for filtering lsvr_event posts
 */
if ( ! class_exists( 'Lsvr_Widget_Event_Filter' ) && class_exists( 'Lsvr_Widget' ) ) {
class Lsvr_Widget_Event_Filter extends Lsvr_Widget {

    public function __construct() {

    	// Init widget
		parent::__construct(array(
			'id' => 'lsvr_events_event_filter',
			'classname' => 'lsvr_event-filter-widget',
			'title' => esc_html__( 'LSVR Event Filter', 'lsvr-events' ),
			'description' => esc_html__( 'Filter event posts', 'lsvr-events' ),
			'fields' => array(
				'title' => array(
					'label' => esc_html__( 'Title:', 'lsvr-events' ),
					'type' => 'text',
					'default' => esc_html__( 'Filter Events', 'lsvr-events' ),
				),
				'submit_label' => array(
					'label' => esc_html__( 'Submit Button Label:', 'lsvr-events' ),
					'type' => 'text',
					'default' => esc_html__( 'Filter', 'lsvr-events' ),
				),
				'more_label' => array(
					'label' => esc_html__( 'More Button Label:', 'lsvr-events' ),
					'description' => esc_html__( 'Link to event post archive. Leave blank to hide.', 'lsvr-events' ),
					'type' => 'text',
					'default' => esc_html__( 'All Events', 'lsvr-events' ),
				),
			),
		));

    }

    function widget( $args, $instance ) {

		// Get filter form action
		if ( is_tax( 'lsvr_event_cat' ) || is_tax( 'lsvr_event_tag' ) || is_tax( 'lsvr_event_location' ) ) {
			$taxonomy = get_query_var( 'taxonomy' );
			$form_action = get_term_link( get_queried_object_id(), $taxonomy );
		} else {
			$form_action = get_post_type_archive_link( 'lsvr_event' );
		}

        ?>

        <?php // Before widget content
        parent::before_widget_content( $args, $instance ); ?>

        <div class="widget__content">

			<?php // Hook before form fields
			do_action( 'lsvr_events_filter_widget_form_before' ); ?>

			<!-- FILTER FORM : begin -->
			<form class="lsvr_event-filter-widget__form" method="get"
				action="<?php echo esc_url( $form_action ); ?>">
				<div class="lsvr_event-filter-widget__form-inner">

					<?php // Hook before form fields
					do_action( 'lsvr_events_filter_widget_form_fields_before' ); ?>

					<!-- DATE FROM : begin -->
					<p class="lsvr_event-filter-widget__option lsvr_event-filter-widget__option--datepicker lsvr_event-filter-widget__option--date-from">
						<label for="lsvr_event-filter-widget__date-from" class="lsvr_event-filter-widget__label"><?php esc_html_e( 'Date from:', 'lsvr-events' ); ?></label>
						<input type="text" class="lsvr_event-filter-widget__input lsvr_event-filter-widget__input--datepicker"
							name="date_from" id="lsvr_event-filter-widget__date-from"
							placeholder="<?php esc_html_e( 'Choose Date', 'lsvr-events' ); ?>"
							<?php if ( isset( $_GET['date_from'] ) ) : ?>
								value="<?php echo preg_replace( '/[^0-9-]/', '', $_GET['date_from'] ); ?>"
							<?php endif; ?>>
					</p>
					<!-- DATE FROM : end -->

					<!-- DATE TO : begin -->
					<p class="lsvr_event-filter-widget__option lsvr_event-filter-widget__option--datepicker lsvr_event-filter-widget__option--date-to">
						<label for="lsvr_event-filter-widget__date-to" class="lsvr_event-filter-widget__label"><?php esc_html_e( 'Date to:', 'lsvr-events' ); ?></label>
						<input type="text" class="lsvr_event-filter-widget__input lsvr_event-filter-widget__input--datepicker"
							name="date_to" id="lsvr_event-filter-widget__date-to"
							placeholder="<?php esc_html_e( 'Choose Date', 'lsvr-events' ); ?>"
							<?php if ( isset( $_GET['date_to'] ) ) : ?>
								value="<?php echo preg_replace( '/[^0-9-]/', '', $_GET['date_to'] ); ?>"
							<?php endif; ?>>
					</p>
					<!-- DATE to : end -->

					<?php // Hook before form submit
					do_action( 'lsvr_events_filter_widget_form_submit_before' ); ?>

					<!-- SUBMIT : begin -->
					<p class="lsvr_event-filter-widget__submit">
						<button type="submit" class="lsvr_event-filter-widget__submit-button">
							<?php esc_html_e( 'Filter', 'lsvr-events' ); ?>
						</button>
					</p>
					<!-- SUBMIT : end -->

					<?php // Hook after form submit
					do_action( 'lsvr_events_filter_widget_form_submit_after' ); ?>

				</div>
			</form>
			<!-- FILTER FORM : end -->

			<?php // Hook after form
			do_action( 'lsvr_events_filter_widget_form_after' ); ?>

            <?php if ( ! empty( $instance[ 'more_label' ] ) ) : ?>
            <p class="widget__more">
                <a href="<?php echo esc_url( get_post_type_archive_link( 'lsvr_event' ) ); ?>" class="widget__more-link"><?php echo esc_html( $instance[ 'more_label' ] ); ?></a>
            </p>
            <?php endif; ?>

        </div>

        <?php // After widget content
        parent::after_widget_content( $args, $instance ); ?>

        <?php

    }

}}

?>