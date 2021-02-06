<?php
/**
 * LSVR TownPress Weather Widget Shortcode
 */
if ( ! class_exists( 'Lsvr_Shortcode_Townpress_Weather_Widget' ) ) {
    class Lsvr_Shortcode_Townpress_Weather_Widget {

        public static function shortcode( $atts = array(), $content = null, $tag = '' ) {

            // Merge default atts and received atts
            $args = shortcode_atts(
                array(
                    'title' => '',
                    'icon' => '',
                    'address' => '',
                    'latitude' => '',
                    'longitude' => '',
                    'forecast_length' => 3,
                    'units_format' => 'metric',
                    'update_interval' => '1hour',
                    'show_time' => 'true',
                    'background_image' => '',
                    'bottom_text' => '',
                    'id' => '',
                    'className' => '',
                    'editor_view' => false,
                ),
                $atts
            );

            // Check if editor view
            $editor_view = true === $args['editor_view'] || '1' === $args['editor_view'] || 'true' === $args['editor_view'] ? true : false;

            // Element class
            $class_arr = array( 'widget shortcode-widget lsvr-townpress-weather-widget lsvr-townpress-weather-widget--shortcode' );
            if ( true === $editor_view ) {
                array_push( $class_arr, 'lsvr-townpress-weather-widget--editor-view' );
            }
            if ( ! empty( $args['className'] ) ) {
                array_push( $class_arr, $args['className'] );
            }

            ob_start(); ?>

            <?php the_widget( 'Lsvr_Widget_Townpress_Weather', array(
                'title' => $args['title'],
                'address' => $args['address'],
                'latitude' => $args['latitude'],
                'longitude' => $args['longitude'],
                'forecast_length' => $args['forecast_length'],
                'units_format' => $args['units_format'],
                'update_interval' => $args['update_interval'],
                'show_time' => $args['show_time'],
                'background_image' => $args['background_image'],
                'bottom_text' => $args['bottom_text'],
                'editor_view' => $args['editor_view'],
            ), array(
                'before_widget' => '<div' . ( ! empty( $args['id'] ) ? ' id="' . esc_attr( $args['id'] ) . '"' : '' ) . ' class="' . esc_attr( implode( ' ', $class_arr ) ) . '"><div class="widget__inner">',
                'after_widget' => '</div></div>',
                'before_title' => ! empty( $args['icon'] ) ? '<h3 class="widget__title widget__title--has-icon"><i class="widget__title-icon ' . esc_attr( $args['icon'] ) . '"></i>' : '<h3 class="widget__title">',
                'after_title' => '</h3>',
            )); ?>

            <?php return ob_get_clean();

        }

        // Shortcode params
        public static function lsvr_shortcode_atts() {
            return array_merge( array(

                // Title
                array(
                    'name' => 'title',
                    'type' => 'text',
                    'label' => esc_html__( 'Title', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'Title of this section.', 'lsvr-townpress-toolkit' ),
                    'default' => esc_html__( 'Weather Forecast', 'lsvr-townpress-toolkit' ),
                    'priority' => 10,
                ),

                // Address
                array(
                    'name' => 'address',
                    'type' => 'text',
                    'label' => esc_html__( 'Address', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'For example: stowe,us. You can search for your location on OpenWeatherMap.org to see if it is in the database. Do not forget to insert your OpenWeatherMap.org API key under Appearance / Customize / Misc.', 'lsvr-townpress-toolkit' ),
                    'priority' => 20,
                ),

                // Latitude
                array(
                    'name' => 'latitude',
                    'type' => 'text',
                    'label' => esc_html__( 'Latitude', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'Use if you are unable to get your local weather using just the address.', 'lsvr-townpress-toolkit' ),
                    'priority' => 30,
                ),

                // Longitude
                array(
                    'name' => 'longitude',
                    'type' => 'text',
                    'label' => esc_html__( 'Longitude', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'Use if you are unable to get your local weather using just the address.', 'lsvr-townpress-toolkit' ),
                    'priority' => 40,
                ),

                // Forecast length
                array(
                    'name' => 'forecast_length',
                    'type' => 'select',
                    'label' => esc_html__( 'Forecast Length', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'How many days of forecast will be displayed.', 'lsvr-townpress-toolkit' ),
                    'choices' => array(
                        '0' => esc_html__( 'No forecast', 'lsvr-townpress-toolkit' ),
                        '1' => esc_html__( '1 day', 'lsvr-townpress-toolkit' ),
                        '2' => esc_html__( '2 days', 'lsvr-townpress-toolkit' ),
                        '3' => esc_html__( '3 days', 'lsvr-townpress-toolkit' ),
                    ),
                    'default' => '3',
                    'priority' => 50,
                ),

                // Units format
                array(
                    'name' => 'units_format',
                    'type' => 'select',
                    'label' => esc_html__( 'Units Format', 'lsvr-townpress-toolkit' ),
                    'choices' => array(
                        'metric' => esc_html__( 'Metric', 'lsvr-townpress-toolkit' ),
                        'imperial' => esc_html__( 'Imperial', 'lsvr-townpress-toolkit' ),
                    ),
                    'default' => 'metric',
                    'priority' => 60,
                ),

                // Update interval
                array(
                    'name' => 'update_interval',
                    'type' => 'select',
                    'label' => esc_html__( 'Update Interval', 'lsvr-townpress-toolkit' ),
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
                    'priority' => 70,
                ),

                // Display local time
                array(
                    'name' => 'show_time',
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Display Local Time', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'You can change your Timezone and Time Format under Settings / General.', 'lsvr-townpress-toolkit' ),
                    'default' => true,
                    'priority' => 80,
                ),

                // Background image
                array(
                    'name' => 'background_image',
                    'type' => 'image',
                    'label' => esc_html__( 'Background Image', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'Optimal resolution is about 600x600px.', 'lsvr-townpress-toolkit' ),
                    'priority' => 90,
                ),

                // Bottom text
                array(
                    'name' => 'bottom_text',
                    'type' => 'text',
                    'label' => esc_html__( 'Bottom Text', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'Custom text which will be displayed at the bottom of the widget content.', 'lsvr-townpress-toolkit' ),
                    'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 'lsvr-townpress-toolkit' ),
                    'priority' => 100,
                ),

                // ID
                 array(
                    'name' => 'id',
                    'type' => 'text',
                    'label' => esc_html__( 'Unique ID', 'lsvr-townpress-toolkit' ),
                    'description' => esc_html__( 'Custom text which will be displayed at the bottom of the widget content.', 'lsvr-townpress-toolkit' ),
                    'priority' => 200,
                ),

            ), apply_filters( 'lsvr_townpress_weather_widget_shortcode_atts', array() ) );
        }

    }
}
?>