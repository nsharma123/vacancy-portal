<?php
/**
 * LSVR Weather widget
 *
 * Display a weather forecast from openweather.org
 */
if ( ! class_exists( 'Lsvr_Widget_Townpress_Weather' ) && class_exists( 'Lsvr_Widget' ) ) {
class Lsvr_Widget_Townpress_Weather extends Lsvr_Widget {

    public function __construct() {

    	// Init widget
		parent::__construct(array(
			'id' => 'lsvr_townpress_weather',
			'classname' => 'lsvr-townpress-weather-widget',
			'title' => esc_html__( 'TownPress Weather', 'lsvr-townpress-toolkit' ),
			'description' => esc_html__( 'Weather forecast', 'lsvr-townpress-toolkit' ),
			'fields' => array(
				'info' => array(
					'type' => 'info',
					'content' => esc_html__( 'Please insert your OpenWeatherMap.org API Key under Appearance / Customizer / Misc. Also, don\'t forget to set your basic locale settings under Settings / General (especially Timezone).', 'lsvr-townpress-toolkit' ),
				),
				'title' => array(
					'label' => esc_html__( 'Title:', 'lsvr-townpress-toolkit' ),
					'type' => 'text',
					'default' => esc_html__( 'Weather', 'lsvr-townpress-toolkit' ),
				),
				'address' => array(
					'label' => esc_html__( 'Address:', 'lsvr-townpress-toolkit' ),
					'type' => 'text',
					'description' => esc_html__( 'For example: "stowe,us". You can search for your location on openweathermap.org to see if it\'s in the database.', 'lsvr-townpress-toolkit' ),
				),
				'latitude' => array(
					'label' => esc_html__( 'Latitude:', 'lsvr-townpress-toolkit' ),
					'type' => 'text',
					'description' => esc_html__( 'Use if you are unable to get your local weather using just the address.', 'lsvr-townpress-toolkit' ),
				),
				'longitude' => array(
					'label' => esc_html__( 'Longitude:', 'lsvr-townpress-toolkit' ),
					'type' => 'text',
					'description' => esc_html__( 'Use if you are unable to get your local weather using just the address.', 'lsvr-townpress-toolkit' ),
				),
				'forecast_length' => array(
					'label' => esc_html__( 'Forecast Length:', 'lsvr-townpress-toolkit' ),
					'type' => 'select',
					'description' => esc_html__( 'How many days of forecast will be displayed.', 'lsvr-townpress-toolkit' ),
					'choices' => array(
						'0' => esc_html__( 'No forecast', 'lsvr-townpress-toolkit' ),
						'1' => esc_html__( '1 day', 'lsvr-townpress-toolkit' ),
						'2' => esc_html__( '2 days', 'lsvr-townpress-toolkit' ),
						'3' => esc_html__( '3 days', 'lsvr-townpress-toolkit' ),
					),
					'default' => '3',
				),
				'units_format' => array(
					'label' => esc_html__( 'Units Format:', 'lsvr-townpress-toolkit' ),
					'type' => 'select',
					'choices' => array(
						'metric' => esc_html__( 'Metric', 'lsvr-townpress-toolkit' ),
						'imperial' => esc_html__( 'Imperial', 'lsvr-townpress-toolkit' ),
					),
					'default' => 'metric',
				),
				'update_interval' => array(
					'label' => esc_html__( 'Update Interval:', 'lsvr-townpress-toolkit' ),
					'type' => 'select',
					'description' => esc_html__( 'How often should be weather data pulled from openweathermap.org.', 'lsvr-townpress-toolkit' ),
					'choices' => array(
						'10min' => esc_html__( 'Every 10 minutes', 'lsvr-townpress-toolkit' ),
						'30min' => esc_html__( 'Every 30 minutes', 'lsvr-townpress-toolkit' ),
						'1hour' => esc_html__( 'Every hour', 'lsvr-townpress-toolkit' ),
						'3hours' => esc_html__( 'Every 3 hours', 'lsvr-townpress-toolkit' ),
						'12hours' => esc_html__( 'Every 12 hours', 'lsvr-townpress-toolkit' ),
						'24hours' => esc_html__( 'Every 24 hours', 'lsvr-townpress-toolkit' ),
						'disable' => esc_html__( 'On each page load (not recommended)', 'lsvr-townpress-toolkit' ),
					),
					'default' => '1hour',
				),
				'show_time' => array(
					'label' => esc_html__( 'Show Local Time', 'lsvr-townpress-toolkit' ),
					'description' => esc_html__( 'You can change your Timezone and Time Format under Settings / General.', 'lsvr-townpress-toolkit' ),
					'type' => 'checkbox',
					'default' => 'true',
				),
				'background_image' => array(
					'label' => esc_html__( 'Background Image:', 'lsvr-townpress-toolkit' ),
					'description' => esc_html__( 'Optimal resolution is about 600x600px.', 'lsvr-townpress-toolkit' ),
					'type' => 'image',
				),
				'bottom_text' => array(
					'label' => esc_html__( 'Bottom Text:', 'lsvr-townpress-toolkit' ),
					'description' => esc_html__( 'Custom text which will be displayed at the bottom of the widget content.', 'lsvr-townpress-toolkit' ),
					'type' => 'textarea',
				),
			),
		));

    }

    function widget( $args, $instance ) {

    	// Check if editor view
        $editor_view = ! empty( $instance['editor_view'] ) && ( true === $instance['editor_view'] || '1' === $instance['editor_view'] || 'true' === $instance['editor_view'] ) ? true : false;

    	// Show time
    	$show_time = ! empty( $instance['show_time'] ) && ( true === $instance['show_time'] || 'true' === $instance['show_time'] || '1' === $instance['show_time'] ) ? true : false;

        // Background image
        if ( ! empty( $instance['background_image'] ) && is_numeric( $instance['background_image'] ) && (int) $instance['background_image'] > 0 ) {

            $image_data = wp_get_attachment_image_src( (int) $instance['background_image'], 'full' );
            if ( ! empty( $image_data[0] ) ) {
                $background_url = $image_data[0];
            }

        } else if ( ! empty( $instance['background_image'] ) ) {
            $background_url = $instance['background_image'];
        }

		if ( ! empty( $background_url ) ) {
			$args[ 'before_widget' ] = str_replace( 'lsvr-townpress-weather-widget', 'lsvr-townpress-weather-widget lsvr-townpress-weather-widget--has-background', $args[ 'before_widget' ] );
			$args[ 'before_widget' ] = str_replace( 'widget__inner"', 'widget__inner" style="background-image: url(' . esc_url( $background_url ) . ');"', $args[ 'before_widget' ] );
		}

		// Prepare ajax query
		$ajax_params = array(
			'address' => ! empty( $instance['address'] ) ? $instance['address'] : '',
			'latitude' => ! empty( $instance['latitude'] ) ? $instance['latitude'] : '',
			'longitude' => ! empty( $instance['longitude'] ) ? $instance['longitude'] : '',
			'forecast_length' => ! empty( $instance['forecast_length'] ) ? intval( $instance['forecast_length'] ) : 0,
			'units_format' => ! empty( $instance['units_format'] ) ? $instance['units_format'] : 'metric',
			'update_interval' => ! empty( $instance['update_interval'] ) ? $instance['update_interval'] : '1hour',
		);

		if ( ! empty( $ajax_params['address'] ) || ( ! empty( $ajax_params['latitude'] ) && ! empty( $ajax_params['longitude'] ) ) ) {
			$ajax_params_json = json_encode( $ajax_params );
		} else {
			$ajax_params_json = false;
		}

        ?>

        <?php // Before widget content
        parent::before_widget_content( $args, $instance ); ?>

        <div class="widget__content">

			<?php // Local time
			if ( true === $show_time ) : ?>

				<div class="lsvr-townpress-weather-widget__time">
					<h4 class="lsvr-townpress-weather-widget__time-title"><?php esc_html_e( 'Local Time', 'lsvr-townpress-toolkit' ); ?></h4>
					<p class="lsvr-townpress-weather-widget__time-value"
						data-timezone="<?php echo esc_attr( get_option( 'timezone_string' ) ); ?>">
						<?php echo current_time( get_option( 'time_format' ) ); ?>
					</p>
				</div>

			<?php endif; ?>

			<?php // Weather
			if ( ! empty( $ajax_params_json ) && false === $editor_view ) : ?>

				<div class="lsvr-townpress-weather-widget__weather lsvr-townpress-weather-widget__weather--loading"
					data-ajax-params="<?php echo esc_attr( $ajax_params_json ); ?>"
					data-forecast-length="<?php echo esc_attr( $ajax_params['forecast_length'] ); ?>">

					<span class="lsvr-townpress-weather-widget__weather-spinner c-spinner"></span>

					<ul class="lsvr-townpress-weather-widget__weather-list" style="display: none;">

						<li class="lsvr-townpress-weather-widget__weather-item lsvr-townpress-weather-widget__weather-item--current">
							<div class="lsvr-townpress-weather-widget__weather-item-labels">
								<h4 class="lsvr-townpress-weather-widget__weather-item-title">
									<?php esc_html_e( 'Today', 'lsvr-townpress-toolkit' ); ?>
								</h4>
								<h5 class="lsvr-townpress-weather-widget__weather-item-date">
									<?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( current_time( 'mysql' ) ) ) ); ?>
								</h5>
							</div>
							<div class="lsvr-townpress-weather-widget__weather-item-values">
								<i class="lsvr-townpress-weather-widget__weather-item-icon"></i>
								<div class="lsvr-townpress-weather-widget__weather-item-temperature"
									title="<?php echo esc_attr( esc_html__( 'Temperature', 'lsvr-townpress-toolkit' ) ); ?>">
									<?php echo 'metric' === $ajax_params['units_format'] ? esc_html__( '&deg;C', 'lsvr-townpress-toolkit' ) : esc_html__( '&deg;F', 'lsvr-townpress-toolkit' ); ?>
								</div>
								<div class="lsvr-townpress-weather-widget__weather-item-wind"
									title="<?php echo esc_attr( esc_html__( 'Wind speed', 'lsvr-townpress-toolkit' ) ); ?>">
									<?php echo 'metric' === $ajax_params['units_format'] ? esc_html__( 'm/s', 'lsvr-townpress-toolkit' ) : esc_html__( 'm/h', 'lsvr-townpress-toolkit' ); ?>
								</div>
							</div>
						</li>

						<?php for ( $i = 1; $i <= $ajax_params['forecast_length']; $i++ ) : ?>
							<li class="lsvr-townpress-weather-widget__weather-item lsvr-townpress-weather-widget__weather-item--forecast lsvr-townpress-weather-widget__weather-item--forecast-<?php echo esc_attr( $i ); ?>"
									data-timestamp="<?php echo esc_attr( strtotime( current_time( 'Y-m-d 12:00:00' ) ) + ( 60 * 60 * ( 24 * ( $i ) ) ) ); ?>">
								<div class="lsvr-townpress-weather-widget__weather-item-labels">
									<h4 class="lsvr-townpress-weather-widget__weather-item-title">
										<?php echo date_i18n( 'l', strtotime( current_time( 'mysql' ) ) + ( 60 * 60 * ( 24 * ( $i ) ) ) ); ?>
									</h4>
									<h5 class="lsvr-townpress-weather-widget__weather-item-date">
										<?php echo date_i18n( get_option( 'date_format' ), strtotime( current_time( 'mysql' ) ) + ( 60 * 60 * ( 24 * ( $i ) ) ) ); ?>
									</h5>
								</div>
								<div class="lsvr-townpress-weather-widget__weather-item-values">
									<i class="lsvr-townpress-weather-widget__weather-item-icon"></i>
									<div class="lsvr-townpress-weather-widget__weather-item-temperature"
										title="<?php echo esc_attr( esc_html__( 'Temperature', 'lsvr-townpress-toolkit' ) ); ?>">
										<?php echo 'metric' === $ajax_params['units_format'] ? esc_html__( '&deg;C', 'lsvr-townpress-toolkit' ) : esc_html__( '&deg;F', 'lsvr-townpress-toolkit' ); ?>
									</div>
									<div class="lsvr-townpress-weather-widget__weather-item-wind"
										title="<?php echo esc_attr( esc_html__( 'Wind speed', 'lsvr-townpress-toolkit' ) ); ?>">
										<?php esc_html_e( 'm/s', 'lsvr-townpress-toolkit' ); ?>
									</div>
								</div>
							</li>
						<?php endfor; ?>

					</ul>

				</div>

			<?php elseif ( true === $editor_view ) :  ?>

                <p class="c-alert-message lsvr-townpress-weather-widget__message">
                    <?php esc_html_e( 'Weather forecast can be displayed on front-end only.', 'lsvr-townpress-toolkit' ); ?>
                </p>

			<?php endif; ?>

			<?php // Bottom text
			if ( ! empty( $instance['bottom_text'] ) ) : ?>

				<div class="lsvr-townpress-weather-widget__text">
					<?php echo wpautop( wp_kses( $instance['bottom_text'], array(
						'a' => array(
							'href' => array(),
							'title' => array(),
							'target' => array(),
						),
						'em' => array(),
						'br' => array(),
						'strong' => array(),
						'p' => array(),
					))); ?>
				</div>

			<?php endif; ?>

        </div>

        <?php // After widget content
        parent::after_widget_content( $args, $instance ); ?>

        <?php

    }

}}

?>