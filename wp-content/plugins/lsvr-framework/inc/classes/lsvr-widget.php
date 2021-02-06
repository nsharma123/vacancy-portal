<?php
// General class for handling widgets
if ( ! class_exists( 'Lsvr_Widget' ) ) {
class Lsvr_Widget extends WP_Widget {

	protected $defaults;
	public $fields;

    public function __construct( $args ) {
    	if ( ! empty( $args ) ) {

			// Init widget
    		parent::__construct(
    			$args['id'],
    			$args['title'],
    			array(
    				'classname' => $args['classname'],
    				'description' => $args['description'],
				)
			);

			// Save fields
			if ( ! empty( $args['fields'] ) ) {

				$this->fields = $args['fields'];

	    		// Set default values
	    		$this->defaults = array();
	    		foreach ( $this->fields as $field_id => $field_args ) {
	    			if ( array_key_exists( 'default', $field_args ) ) {
	    				$this->defaults[ $field_id ] = $field_args['default'];
	    			}
	    		}

			}

    	}
    }

    function form( $instance ) {
    	if ( ! empty( $this->fields ) ) {

    		// Merge saved values with default values
	    	if ( ! empty( $instance ) && is_array( $instance ) ) {
	    		$instance = wp_parse_args( $instance, $this->defaults );
	    	} else {
	    		$instance = $this->defaults;
	    	}

			 // Display form fields
        	foreach ( $this->fields as $field_id => $field_args ) {

				$field_class = ! empty( $field_args['type'] ) ? 'Lsvr_Widget_Field_' . str_replace( '-', '_', ucwords( $field_args['type'], '-' ) ) : '';
				if ( class_exists( $field_class ) ) {
					$field = new $field_class(array(
						'field_id' => $field_id,
						'args' => $field_args,
						'input_id' => $this->get_field_id( $field_id ),
						'input_name' => $this->get_field_name( $field_id ),
						'saved_value' => ! empty( $instance[ $field_id ] ) ? $instance[ $field_id ] : '',
					));
				}

			}

    	}
	}

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;
        foreach ( $this->fields as $field_id => $field_args ) {
        	$instance[ $field_id ] = $new_instance[ $field_id ];
        }
        return $instance;

    }

    function before_widget_content( $args, $instance ) {

		echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
        	echo $args['before_title'] . apply_filters( 'widget_title', $instance[ 'title' ] ) . $args['after_title'];
        }

    }

    function after_widget_content( $args, $instance ) {

    	echo $args['after_widget'];

    }

}}

?>