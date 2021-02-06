<?php
/**
 * Get latitude and longitude from event location address after term edit.
 *
 * @link https://github.com/techcrunch/wp-async-task
 */
if ( ! class_exists( 'Lsvr_Events_Async_Task_Geocode_Event_Location_Edit' ) && class_exists( 'WP_Async_Task' ) ) {
    class Lsvr_Events_Async_Task_Geocode_Event_Location_Edit extends WP_Async_Task {

		protected $action = 'edited_lsvr_event_location';

		// Prepare data
		protected function prepare_data( $data ) {
			$term_id = $data[0];
    		return array( 'lsvr_event_location_term_id' => $term_id );
		}

		// Run action
		protected function run_action() {
			$term_id = ! empty( $_POST['lsvr_event_location_term_id'] ) ? (int) $_POST['lsvr_event_location_term_id'] : false;
			if ( ! empty( $term_id ) ) {
				do_action( 'wp_async_' . $this->action, $term_id );
    		}
		}

    }
}

?>