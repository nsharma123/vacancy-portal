<?php
/**
 * Class for configuring the Customizer fields
 */
if ( ! class_exists( 'Lsvr_Customizer' ) ) {
	class Lsvr_Customizer {

		public $wp_customize;
		public $prefix;
		public $dependencies = [];

		// Constructor
		public function __construct( $wp_customize, $prefix = '' ) {

			$this->wp_customize = $wp_customize;
			$this->prefix = $prefix;

		}

		// Add section
		public function add_section( $id, $args ) {
		    $this->wp_customize->add_section( $this->prefix . $id , array(
		        'title' => ! empty( $args['title'] ) ? $args['title'] : '',
		        'priority' => ! empty( $args['priority'] ) ? $args['priority'] : 0,
		    ));
		}

		// Add info
		public function add_info( $id, $args ) {
			if ( class_exists( 'Lsvr_Customize_Control_Info' ) ) {

	    		// Check field dependencies
	    		if ( ! empty( $args['required'] ) ) {
					$args['active_callback'] = array( $this, 'required' );
					$this->dependencies[ $id ] = $args['required'];
	    			unset( $args['required'] );
	    		}

	    		// Init control
	        	$this->wp_customize->add_setting( $id );
	        	$args['settings'] = $id;
	        	$args['section'] = ! empty( $args['section'] ) ? $this->prefix . $args['section'] : '';
	        	$this->wp_customize->add_control( new Lsvr_Customize_Control_Info(
	                $this->wp_customize,
	                $id,
	                $args
	            ));

        	}
		}

		// Add separator
		public function add_separator( $id, $args ) {
			if ( class_exists( 'Lsvr_Customize_Control_Separator' ) ) {

	    		// Check field dependencies
	    		if ( ! empty( $args['required'] ) ) {
					$args['active_callback'] = array( $this, 'required' );
					$this->dependencies[ $id ] = $args['required'];
	    			unset( $args['required'] );
	    		}

	        	// Init control
	        	$this->wp_customize->add_setting( $id );
	        	$args['settings'] = $id;
	        	$args['section'] = ! empty( $args['section'] ) ? $this->prefix . $args['section'] : '';
	        	$this->wp_customize->add_control( new Lsvr_Customize_Control_Separator(
	                $this->wp_customize,
	                $id,
	                $args
	            ));

        	}
		}

		// Add field
		public function add_field( $id, $args ) {

			// Add setting
        	$this->wp_customize->add_setting( $id, array(
            	'default' => array_key_exists( 'default', $args ) ? $args['default'] : '',
        	));

        	// Prepare control arguments
    		$args['settings'] = $id;
    		$args['section'] = ! empty( $args['section'] ) ? $this->prefix . $args['section'] : '';

    		// Check field dependencies
    		if ( ! empty( $args['required'] ) ) {
				$args['active_callback'] = array( $this, 'required' );
				$this->dependencies[ $id ] = $args['required'];
    			unset( $args['required'] );
    		}

    		// Check the control type
    		$control_type = ! empty( $args['type'] ) ? $args['type'] : false;

    		// Custom Sidebars control
    		if ( 'lsvr-sidebars' === $control_type && class_exists( 'Lsvr_Customize_Control_Sidebars' ) ) {
				$this->wp_customize->add_control( new Lsvr_Customize_Control_Sidebars(
	                $this->wp_customize,
	                $id,
	                $args
	            ));
    		}

    		// Image control
    		else if ( 'image' === $control_type && class_exists( 'WP_Customize_Image_Control' ) ) {
				$this->wp_customize->add_control( new WP_Customize_Image_Control(
	                $this->wp_customize,
	                $id ,
	                $args
	            ));
    		}

    		// Color control
    		else if ( 'color' === $control_type && class_exists( 'WP_Customize_Color_Control' ) ) {
				$this->wp_customize->add_control( new WP_Customize_Color_Control(
	                $this->wp_customize,
	                $id ,
	                $args
	            ));
    		}

    		// Multicheck
    		else if ( 'lsvr-multicheck' === $control_type && class_exists( 'Lsvr_Customize_Control_Multicheck' ) ) {
				$this->wp_customize->add_control( new Lsvr_Customize_Control_Multicheck(
	                $this->wp_customize,
	                $id,
	                $args
	            ));
    		}

    		// Slider control
    		else if ( 'lsvr-slider' === $control_type && class_exists( 'Lsvr_Customize_Control_Slider' ) ) {
				$this->wp_customize->add_control( new Lsvr_Customize_Control_Slider(
	                $this->wp_customize,
	                $id,
	                $args
	            ));
    		}

    		// Social links control
    		else if ( 'lsvr-social-links' === $control_type && class_exists( 'Lsvr_Customize_Control_Social_Links' ) ) {
				$this->wp_customize->add_control( new Lsvr_Customize_Control_Social_Links(
	                $this->wp_customize,
	                $id,
	                $args
	            ));
    		}

    		// Default control
    		else {
				$this->wp_customize->add_control(
					$id,
					$args
				);
    		}

		}

		// Check field dependencies
		public function required( $control ) {

			// Get info about required field
			if ( ! empty( $this->dependencies ) && ! empty( $control->id ) && array_key_exists( $control->id, $this->dependencies ) ) {

				// Check if there are multiple dependencies
				if ( ! empty( $this->dependencies[ $control->id ][0] ) && is_array( $this->dependencies[ $control->id ][0] ) ) {
					$dependencies_arr = $this->dependencies[ $control->id ];
				} else {
					$dependencies_arr = array(
						$this->dependencies[ $control->id ]
					);
				}

				// Loop through dependencies
				foreach ( $dependencies_arr as $dependency ) {

					$setting = ! empty( $dependency['setting'] ) ? $dependency['setting'] : false;
					$operator = ! empty( $dependency['operator'] ) ? $dependency['operator'] : '==';
					$values_arr = ! empty( $dependency['value'] ) ? explode( ',', $dependency['value'] ) : array();

					$current_value = $control->manager->get_setting( $setting )->value();

					// Equals
					if ( $operator === '==' ) {
						if ( ! in_array( $current_value, $values_arr ) ) {
							return false;
						}
					}

				}

			}

			return true;

		}

	}
}