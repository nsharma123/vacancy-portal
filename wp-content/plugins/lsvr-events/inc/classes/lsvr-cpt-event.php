<?php
/**
 * Event post type
 */
if ( ! class_exists( 'Lsvr_CPT_Event' ) && class_exists( 'Lsvr_CPT' ) ) {
    class Lsvr_CPT_Event extends Lsvr_CPT {

		public function __construct() {

			parent::__construct( array(
				'id' => 'lsvr_event',
				'wp_args' => array(
					'labels' => array(
						'name' => esc_html__( 'Events', 'lsvr-events' ),
						'singular_name' => esc_html__( 'Event', 'lsvr-events' ),
						'add_new' => esc_html__( 'Add New Event', 'lsvr-events' ),
						'add_new_item' => esc_html__( 'Add New Event', 'lsvr-events' ),
						'edit_item' => esc_html__( 'Edit Event', 'lsvr-events' ),
						'new_item' => esc_html__( 'Add New Event', 'lsvr-events' ),
						'view_item' => esc_html__( 'View Event', 'lsvr-events' ),
						'search_items' => esc_html__( 'Search events', 'lsvr-events' ),
						'not_found' => esc_html__( 'No events found', 'lsvr-events' ),
						'not_found_in_trash' => esc_html__( 'No events found in trash', 'lsvr-events' ),
					),
					'exclude_from_search' => false,
					'public' => true,
					'supports' => array( 'title', 'editor', 'custom-fields', 'revisions', 'excerpt', 'thumbnail' ),
					'capability_type' => 'post',
					'rewrite' => array( 'slug' => 'events' ),
					'menu_position' => 5,
					'has_archive' => true,
					'show_in_nav_menus' => true,
					'show_in_rest' => true,
					'menu_icon' => 'dashicons-calendar-alt',
				),
			));

			// Add Location taxonomy
			$this->add_taxonomy(array(
				'id' => 'lsvr_event_location',
				'wp_args' => array(
					'labels' => array(
						'name' => esc_html__( 'Event Location', 'lsvr-events' ),
						'singular_name' => esc_html__( 'Event Location', 'lsvr-events' ),
						'search_items' => esc_html__( 'Search Event Locations', 'lsvr-events' ),
						'popular_items' => esc_html__( 'Popular Event Locations', 'lsvr-events' ),
						'all_items' => esc_html__( 'All Event Locations', 'lsvr-events' ),
						'parent_item' => esc_html__( 'Parent Event Location', 'lsvr-events' ),
						'parent_item_colon' => esc_html__( 'Parent Event Location:', 'lsvr-events' ),
						'edit_item' => esc_html__( 'Edit Event Location', 'lsvr-events' ),
						'update_item' => esc_html__( 'Update Event Location', 'lsvr-events' ),
						'add_new_item' => esc_html__( 'Add New Event Location', 'lsvr-events' ),
						'new_item_name' => esc_html__( 'New Event Location Name', 'lsvr-events' ),
						'separate_items_with_commas' => esc_html__( 'Separate event locations by comma', 'lsvr-events' ),
						'add_or_remove_items' => esc_html__( 'Add or remove event locations', 'lsvr-events' ),
						'choose_from_most_used' => esc_html__( 'Choose from the most used event locations', 'lsvr-events' ),
						'menu_name' => esc_html__( 'Event Locations', 'lsvr-events' )
					),
					'public' => true,
					'show_in_nav_menus' => true,
					'show_ui' => true,
					'show_admin_column' => true,
					'show_tagcloud' => false,
					'hierarchical' => false,
					'rewrite' => array( 'slug' => 'event-location' ),
					'query_var' => true,
					'show_in_quick_edit' => false,
					'meta_box_cb' => false,
				),
				'args' => array(
					'admin_tax_filter' => true,
				),
			));

			// Add Category taxonomy
			$this->add_taxonomy(array(
				'id' => 'lsvr_event_cat',
				'wp_args' => array(
					'labels' => array(
						'name' => esc_html__( 'Event Categories', 'lsvr-events' ),
						'singular_name' => esc_html__( 'Event Category', 'lsvr-events' ),
						'search_items' => esc_html__( 'Search Event Categories', 'lsvr-events' ),
						'popular_items' => esc_html__( 'Popular Event Categories', 'lsvr-events' ),
						'all_items' => esc_html__( 'All Event Categories', 'lsvr-events' ),
						'parent_item' => esc_html__( 'Parent Event Category', 'lsvr-events' ),
						'parent_item_colon' => esc_html__( 'Parent Event Category:', 'lsvr-events' ),
						'edit_item' => esc_html__( 'Edit Event Category', 'lsvr-events' ),
						'update_item' => esc_html__( 'Update Event Category', 'lsvr-events' ),
						'add_new_item' => esc_html__( 'Add New Event Category', 'lsvr-events' ),
						'new_item_name' => esc_html__( 'New Event Category Name', 'lsvr-events' ),
						'separate_items_with_commas' => esc_html__( 'Separate event categories by comma', 'lsvr-events' ),
						'add_or_remove_items' => esc_html__( 'Add or remove event categories', 'lsvr-events' ),
						'choose_from_most_used' => esc_html__( 'Choose from the most used event categories', 'lsvr-events' ),
						'menu_name' => esc_html__( 'Event Categories', 'lsvr-events' )
					),
					'public' => true,
					'show_in_nav_menus' => true,
					'show_ui' => true,
					'show_admin_column' => true,
					'show_tagcloud' => true,
					'hierarchical' => true,
					'rewrite' => array( 'slug' => 'event-category' ),
					'query_var' => true,
					'show_in_rest' => true,
				),
				'args' => array(
					'admin_tax_filter' => true,
				),
			));

			// Add Tag taxonomy
			$this->add_taxonomy(array(
				'id' => 'lsvr_event_tag',
				'wp_args' => array(
					'labels' => array(
						'name' => esc_html__( 'Event Tags', 'lsvr-events' ),
						'singular_name' => esc_html__( 'Event Tag', 'lsvr-events' ),
						'search_items' => esc_html__( 'Search Event Tags', 'lsvr-events' ),
						'popular_items' => esc_html__( 'Popular Event Tags', 'lsvr-events' ),
						'all_items' => esc_html__( 'All Event Tags', 'lsvr-events' ),
						'parent_item' => esc_html__( 'Parent Event Tag', 'lsvr-events' ),
						'parent_item_colon' => esc_html__( 'Parent Event Tag:', 'lsvr-events' ),
						'edit_item' => esc_html__( 'Edit Event Tag', 'lsvr-events' ),
						'update_item' => esc_html__( 'Update Event Tag', 'lsvr-events' ),
						'add_new_item' => esc_html__( 'Add New Event Tag', 'lsvr-events' ),
						'new_item_name' => esc_html__( 'New Event Tag Name', 'lsvr-events' ),
						'separate_items_with_commas' => esc_html__( 'Separate event tags by comma', 'lsvr-events' ),
						'add_or_remove_items' => esc_html__( 'Add or remove event tags', 'lsvr-events' ),
						'choose_from_most_used' => esc_html__( 'Choose from the most used event tags', 'lsvr-events' ),
						'menu_name' => esc_html__( 'Event Tags', 'lsvr-events' )
					),
					'public' => true,
					'show_in_nav_menus' => true,
					'show_ui' => true,
					'show_admin_column' => true,
					'show_tagcloud' => true,
					'hierarchical' => false,
					'rewrite' => array( 'slug' => 'event-tag' ),
					'query_var' => true,
					'show_in_rest' => true,
				),
				'args' => array(
					'admin_tax_filter' => true,
				),
			));

			// Additional custom admin functionality
			if ( is_admin() ) {

				// Add Event Settings metabox
				add_action( 'init', array( $this, 'add_event_post_metabox' ) );

				// Add listing category metabox
				add_action( 'init', array( $this, 'add_event_location_tax_metabox' ) );

				// Add custom events filter by start and end date
				add_action( 'restrict_manage_posts', array( $this, 'add_event_date_filter' ) );
				add_action( 'pre_get_posts', array( $this, 'run_event_date_filter' ) );

				// Display custom columns in admin archive view
				add_filter( 'manage_edit-lsvr_event_columns', array( $this, 'add_columns' ), 10, 1 );
				add_action( 'manage_posts_custom_column', array( $this, 'display_columns' ), 10, 1 );

			}

		}

		// Add Event Settings metabox
		public function add_event_post_metabox() {
			if ( class_exists( 'Lsvr_Post_Metabox' ) ) {
				$lsvr_event_post_metabox = new Lsvr_Post_Metabox(array(
					'id' => 'lsvr_event_settings',
					'wp_args' => array(
						'title' => __( 'Event Settings', 'lsvr-events' ),
						'screen' => 'lsvr_event',
					),
					'fields' => array(

						// Event Location
						'lsvr_event_location' => array(
							'type' => 'taxonomy-assign',
							'title' => esc_html__( 'Event Location', 'lsvr-events' ),
							'description' => esc_html__( 'You can manage event locations under Events / Event Locations.', 'lsvr-events' ),
							'taxonomy' => 'lsvr_event_location',
							'no_terms_msg' => esc_html__( 'There are currently no event locations', 'lsvr-events' ),
							'priority' => 10,
						),

						// Start Date
						'lsvr_event_start_date_utc' => array(
							'type' => 'datetime',
							'title' => esc_html__( 'Start Date', 'lsvr-events' ),
							'description' => esc_html__( 'Starting date and time of the event.', 'lsvr-events' ),
							'priority' => 20,
						),

						// End date
						'lsvr_event_end_date_utc' => array(
							'type' => 'datetime',
							'title' => esc_html__( 'End Date', 'lsvr-events' ),
							'description' => esc_html__( 'Ending date and time of the event.', 'lsvr-events' ),
							'priority' => 30,
						),

						// All-day event
						'lsvr_event_allday' => array(
							'type' => 'switch',
							'title' => esc_html__( 'All-day Event', 'lsvr-events' ),
							'description' => esc_html__( 'Enable if this event doesn\'t have specific start and end time.', 'lsvr-events' ),
							'label' => esc_html__( 'This is an all-day event', 'lsvr-events' ),
							'default' => false,
							'priority' => 40,
						),

						// Display end time
						'lsvr_event_end_time_enable' => array(
							'type' => 'switch',
							'title' => esc_html__( 'Show End Time', 'lsvr-events' ),
							'description' => esc_html__( 'Show or hide the end time information on the front-end.', 'lsvr-events' ),
							'label' => esc_html__( 'Display end time', 'lsvr-events' ),
							'default' => true,
							'priority' => 50,
							'required' => array(
								'id' => 'lsvr_event_allday',
								'value' => 'false',
							),
						),

						// Repeat field
						'lsvr_event_repeat' => array(
							'type' => 'radio',
							'title' => esc_html__( 'Repeat', 'lsvr-events' ),
							'description' => esc_html__( 'Create a recurring event.', 'lsvr-events' ),
							'choices' => array(
								'false' => esc_html__( 'Do Not Repeat', 'lsvr-events' ),
								'day' => esc_html__( 'Daily', 'lsvr-events' ),
								'weekday' => esc_html__( 'Every Weekday (Monday to Friday)', 'lsvr-events' ),
								'week' => esc_html__( 'Weekly', 'lsvr-events' ),
								'biweek' => esc_html__( 'Every Two Weeks', 'lsvr-events' ),
								'month' => esc_html__( 'Monthly', 'lsvr-events' ),
								'bimonth' => esc_html__( 'Every Two Months', 'lsvr-events' ),
								'year' => esc_html__( 'Yearly', 'lsvr-events' ),
								'first' => esc_html__( 'Every First:', 'lsvr-events' ),
								'second' => esc_html__( 'Every Second:', 'lsvr-events' ),
								'third' => esc_html__( 'Every Third:', 'lsvr-events' ),
								'fourth' => esc_html__( 'Every Fourth:', 'lsvr-events' ),
								'last' => esc_html__( 'Every Last:', 'lsvr-events' ),
							),
							'default' => 'false',
							'priority' => 60,
						),

						// Repeat day field
						'lsvr_event_repeat_day' => array(
							'type' => 'checkbox',
							'title' => esc_html__( 'Repeat On', 'lsvr-events' ),
							'description' => esc_html__( 'If not specified, event will repeat every day.', 'lsvr-events' ),
							'choices' => array(
								'mon' => esc_html__( 'Mon', 'lsvr-events' ),
								'tue' => esc_html__( 'Tue', 'lsvr-events' ),
								'wed' => esc_html__( 'Wed', 'lsvr-events' ),
								'thu' => esc_html__( 'Thu', 'lsvr-events' ),
								'fri' => esc_html__( 'Fri', 'lsvr-events' ),
								'sat' => esc_html__( 'Sat', 'lsvr-events' ),
								'sun' => esc_html__( 'Sun', 'lsvr-events' ),
							),
							'style' => 'inline',
							'required' => array(
								'id' => 'lsvr_event_repeat',
								'value' => 'day',
							),
							'priority' => 70,
						),

						// Repeat Xth day field
						'lsvr_event_repeat_xth' => array(
							'type' => 'radio',
							'title' => esc_html__( 'Choose Day', 'lsvr-events' ),
							'choices' => array(
								'mon' => esc_html__( 'Mon', 'lsvr-events' ),
								'tue' => esc_html__( 'Tue', 'lsvr-events' ),
								'wed' => esc_html__( 'Wed', 'lsvr-events' ),
								'thu' => esc_html__( 'Thu', 'lsvr-events' ),
								'fri' => esc_html__( 'Fri', 'lsvr-events' ),
								'sat' => esc_html__( 'Sat', 'lsvr-events' ),
								'sun' => esc_html__( 'Sun', 'lsvr-events' ),
							),
							'style' => 'inline',
							'required' => array(
								'id' => 'lsvr_event_repeat',
								'value' => array( 'first', 'second', 'third', 'fourth', 'last' ),
							),
							'default' => 'mon',
							'priority' => 80,
						),

						// End date
						'lsvr_event_repeat_until' => array(
							'type' => 'date',
							'title' => esc_html__( 'Repeat Until', 'lsvr-events' ),
							'default' => date( 'Y-m-d', strtotime( '+1 year 1 day' ) ),
							'priority' => 90,
							'required' => array(
								'id' => 'lsvr_event_repeat',
								'operator' => '!==',
								'value' => 'false',
							),
						),

					),
				));
			}
		}

		// Add event location taxonomy metabox
		public function add_event_location_tax_metabox() {
			if ( class_exists( 'Lsvr_Tax_Metabox' ) ) {

				// Metabox fields
				$lsvr_event_location_metabox_fields = array(

					// Address
					'address' => array(
						'type' => 'textarea',
						'title' => esc_html__( 'Location Address', 'lsvr-events' ),
						'hint' => esc_html__( 'This address will be displayed in event details. Please note that it won\'t be used to display this location on the map, use the Exact Address field below for that.', 'lsvr-events' ),
						'priority' => 20,
					),

					// Accurate address
					'accurate_address' => array(
						'type' => 'text',
						'title' => esc_html__( 'Exact Address', 'lsvr-events' ),
						'hint' => esc_html__( 'This address will be used to display this location on the map, so it should be really accurate. For example: Main St, Stowe, VT 05672, USA.', 'lsvr-events' ),
						'priority' => 30,
					),

					// Latitude and longitude
					'latlong' => array(
						'type' => 'text',
						'title' => esc_html__( 'Latitude and Longitude', 'lsvr-events' ),
						'hint' => esc_html__( 'If you are not able to find the location via its exact address, you can use the latitude and longitude parameters (separated by comma). For example: 40.751597, -73.982243', 'lsvr-events' ),
						'priority' => 40,
					),

				);

				// If LSVR Directory plugin is active, users can link the event locations to directory listings
				if ( function_exists( 'lsvr_directory_get_listings' ) ) {

					// Get all listings
					$listing_posts_arr = array();
					$directory_listings = lsvr_directory_get_listings(array(
						'return_meta' => false
					));

					// Parse all listins and create array with $listing_id => $listing_title
					if ( ! empty( $directory_listings ) ) {
						foreach ( $directory_listings as $listing_id => $listing ) {
							if ( ! empty( $listing['post']->post_title ) ) {
								$listing_posts_arr[ $listing_id ] = $listing['post']->post_title;
							}
						}
					}

					// Add a field with listings into metabox
					if ( ! empty( $listing_posts_arr ) ) {
						$lsvr_event_location_metabox_fields['directory_listing_id'] = array(
							'type' => 'select',
							'title' => esc_html__( 'Link with Directory Listing', 'lsvr-events' ),
							'choices' => $listing_posts_arr,
							'default_option' => array(
								'value' => 'false',
								'label' => esc_html__( 'Do Not Link', 'lsvr-events' ),
							),
							'hint' => esc_html__( 'You can link this event location to an existing directory listing. All location data will be pulled from that listing, which means you don\'t have to fill the rest of the fields below (but you can do it as a backup in case you remove the linked listing in the future).','lsvr-events' ),
							'priority' => 10,
						);
					}

				}

				// Init metabox
				$lsvr_event_location_metabox = new Lsvr_Tax_Metabox(array(
					'taxonomy_name' => 'lsvr_event_location',
					'fields' => $lsvr_event_location_metabox_fields,
				));

			}
		}

		// Add event date filter
		public function add_event_date_filter() {
			global $post_type;
			if ( $post_type === 'lsvr_event' ) {
				?>
				<span class="lsvr-events-admin-view__date-filter">

					<label class="screen-reader-text" for="lsvr_events_admin_filter_date_from">
						<?php esc_html_e( 'Date From', 'lsvr-events' ); ?>
					</label>
					<input type="date" name="lsvr_events_admin_filter_date_from" id="lsvr_events_admin_filter_date_from"
						value="<?php if ( isset( $_GET['lsvr_events_admin_filter_date_from'] ) ) { echo esc_attr( $_GET['lsvr_events_admin_filter_date_from'] ); } ?>"
						placeholder="<?php esc_html_e( 'From Date', 'lsvr-events' ); ?>">

					<label class="screen-reader-text" for="lsvr_events_admin_filter_date_to">
						<?php esc_html_e( 'Date To', 'lsvr-events' ); ?>
					</label>
					<input type="date" name="lsvr_events_admin_filter_date_to" id="lsvr_events_admin_filter_date_to"
						value="<?php if ( isset( $_GET['lsvr_events_admin_filter_date_to'] ) ) { echo esc_attr( $_GET['lsvr_events_admin_filter_date_to'] ); } ?>"
						placeholder="<?php esc_html_e( 'To Date', 'lsvr-events' ); ?>">

				</span>
				<?php
			}
		}

		// Run event date filter
		public function run_event_date_filter( $query ) {

			global $post_type, $pagenow;
			if ( 'edit.php' === $pagenow && 'lsvr_event' === $post_type ) {

				// Get date from
				if ( isset( $_GET['lsvr_events_admin_filter_date_from'] ) && strtotime( $_GET['lsvr_events_admin_filter_date_from'] ) ) {
					$date_from = date( 'Y-m-d 00:00:00', strtotime( $_GET['lsvr_events_admin_filter_date_from'] ) );
				} else {
					$date_from = false;
				}

				// Get date to
				if ( isset( $_GET['lsvr_events_admin_filter_date_to'] ) && strtotime( $_GET['lsvr_events_admin_filter_date_to'] ) ) {
					$date_to = date( 'Y-m-d 23:59:59', strtotime( $_GET['lsvr_events_admin_filter_date_to'] ) );
				} else {
					$date_to = false;
				}

				// If at least one date is defined, alter the query
				if ( ! empty( $date_from ) || ! empty( $date_to ) ) {

					// Retrieve all occurrences which match dates
					// We can pass even FALSE date values, they will be ignored
					$occurrences = lsvr_events_get(array(
						'date_from' => $date_from,
						'date_to' => $date_to,
						'to_return' => array( 'event_ids' )
					));

					// Alter the query to display only filtered event posts
					if ( ! empty( $occurrences['event_ids'] ) && is_array( $occurrences['event_ids'] ) ) {
						$event_ids = array_map( 'intval', $occurrences['event_ids'] );
						$query->query_vars['post__in'] = $event_ids;
					}

				}

			}

		}

		// Add custom columns to admin view
		public function add_columns( $columns ) {
			$start_date = array( 'lsvr_event_start_date' => __( 'Start Date', 'lsvr-events' ) );
			$end_date = array( 'lsvr_event_end_date' => __( 'End Date', 'lsvr-events' ) );
			$columns = array_slice( $columns, 0, 2, true ) + $start_date + $end_date + array_slice( $columns, 1, NULL, true );
			return $columns;
		}

		// Display custom columns in admin view
		public function display_columns( $column ) {
			global $post;
			global $typenow;
			if ( 'lsvr_event' == $typenow  ) {

				// Prepare data
				if ( 'lsvr_event_start_date' === $column || 'lsvr_event_end_date' === $column ) {

					// Convert UTC start date to local date
					$start_date_utc = get_post_meta( $post->ID, 'lsvr_event_start_date_utc', true );
					if ( strtotime( $start_date_utc ) ) {
						$start_date_local = get_date_from_gmt( date( 'Y-m-d H:i:s', strtotime( $start_date_utc ) ), 'Y-m-d H:i:s' );
						$start_time_local = lsvr_events_get_event_local_start_time( $post->ID );
					} else {
						$start_date_local = false;
						$start_time_local = false;
					}

					// Convert UTC end date to local date
					$end_date_utc = get_post_meta( $post->ID, 'lsvr_event_end_date_utc', true );
					if ( strtotime( $end_date_utc ) ) {
						$end_date_local = get_date_from_gmt( date( 'Y-m-d H:i:s', strtotime( $end_date_utc ) ), 'Y-m-d H:i:s' );
						$end_time_local = lsvr_events_get_event_local_end_time( $post->ID );
					} else {
						$end_date_local = false;
						$end_time_local = false;
					}

					// Check if event is all-day event
					$allday = get_post_meta( $post->ID, 'lsvr_event_allday', true );
					$allday = ! empty( $allday ) && 'true' === $allday ? true : false;

					// Check for repeat pattern
					$event_repeat = get_post_meta( $post->ID, 'lsvr_event_repeat', true );
					if ( ! empty( $event_repeat ) && 'false' !== $event_repeat ) {
						$event_repeat_day = get_post_meta( $post->ID, 'lsvr_event_repeat_day', true );
						$event_repeat_xth = get_post_meta( $post->ID, 'lsvr_event_repeat_xth', true );
					} else {
						$event_repeat = false;
						$event_repeat_day = false;
						$event_repeat_xth = false;
					}

					// Translatable labels
					$xth_labels = array(
						'first' => esc_html__( '1st', 'lsvr-events' ),
						'second' => esc_html__( '2nd', 'lsvr-events' ),
						'third' => esc_html__( '3rd', 'lsvr-events' ),
						'fourth' => esc_html__( '4th', 'lsvr-events' ),
						'last' => esc_html__( 'last', 'lsvr-events' ),
					);

				}

				// Start date
				if ( 'lsvr_event_start_date' === $column && ! empty( $start_date_local ) ) {

					// Recurring event
					if ( ! empty( $event_repeat ) ) {
						?>

						<div class="lsvr-events-admin-view__start-date-column">

							<p class="lsvr-events-admin-view__cell-title"><small><strong><?php esc_html_e( 'Recurring Event', 'lsvr-events' ); ?></strong></small></p>

							<?php $next_occurrence_local = lsvr_events_get_next_occurrences( $post->ID, 1, 0 );
							$last_occurrence_local = lsvr_events_get_recent_occurrences( $post->ID, 1, 0 ); ?>

							<?php // Next event occurrence start date
							if ( ! empty( $next_occurrence_local[0]['start'] ) && strtotime( $next_occurrence_local[0]['start'] ) ) : ?>

								<div class="lsvr-events-admin-view__next-occurrence">
									<p>
										<small><?php esc_html_e( 'Next Occurrence Start:', 'lsvr-events' ); ?></small><br>
										<?php
										echo ucfirst( date_i18n( get_option('date_format'), strtotime( $next_occurrence_local[0]['start'] ) ) );
										if ( true === $allday ) {
											echo '<br>@ ' . esc_html__( 'All-day', 'lsvr-events' );
										}
										else {
											echo '<br>@ ' . esc_html( $start_time_local );
										}
										?>
									</p>
								</div>

							<?php // Last event occurrence start date
							elseif ( ! empty( $last_occurrence_local[0]['start'] ) && strtotime( $last_occurrence_local[0]['start'] ) ) : ?>

								<div class="lsvr-events-admin-view__next-occurrence">
									<p>
										<small><?php esc_html_e( 'Last Occurrence Start:', 'lsvr-events' ); ?></small><br>
										<?php
										echo ucfirst( date_i18n( get_option('date_format'), strtotime( $last_occurrence_local[0]['start'] ) ) );
										if ( true === $allday ) {
											echo '<br>@ ' . esc_html__( 'All-day', 'lsvr-events' );
										}
										else {
											echo '<br>@ ' . esc_html( $end_time_local );
										}
										?>
									</p>
								</div>

							<?php endif; ?>

							<div class="lsvr-events-admin-view__recurrence-pattern">
								<hr>
								<p><small><?php esc_html_e( 'Recurrence Pattern:', 'lsvr-events' ); ?></small><br>

									<?php // Repeat daily on specific days
									if ( ! empty( $event_repeat ) && 'day' === $event_repeat && ! empty( $event_repeat_day ) ) {

										$event_repeat_day = explode( ',', $event_repeat_day );
										foreach( $event_repeat_day as $i => $day ) {
											$event_repeat_day[ $i ] = lsvr_events_get_i18n_day_name( $day );
										}
										$event_repeat_day = implode( ', ', $event_repeat_day );
										echo esc_html( sprintf( __( 'Every %s', 'lsvr-events' ), $event_repeat_day ) );

									}

									// Repeat every Xth day
									else if ( ! empty( $event_repeat ) && ! empty( $event_repeat_xth ) &&
										( 'first' === $event_repeat || 'second' === $event_repeat || 'third' === $event_repeat || 'fourth' === $event_repeat || 'last' === $event_repeat ) ) {

										$xth_label = ! empty( $xth_labels[ $event_repeat ] ) ? $xth_labels[ $event_repeat ] : $event_repeat;

										echo esc_html( sprintf( __( 'Every %s %s', 'lsvr-events' ), $xth_label, lsvr_events_get_i18n_day_name( $event_repeat_xth ) ) );

									}

									// Repeat in more standard pattern
									else {

										switch ( $event_repeat ) {
											case 'day':
												esc_html_e( 'Daily', 'lsvr-events' );
												break;
											case 'weekday':
												esc_html_e( 'Every Weekday (Monday to Friday)', 'lsvr-events' );
												break;
											case 'week':
												esc_html_e( 'Weekly', 'lsvr-events' );
												break;
											case 'biweek':
												esc_html_e( 'Every Two Weeks', 'lsvr-events' );
												break;
											case 'month':
												esc_html_e( 'Monthly', 'lsvr-events' );
												break;
											case 'bimonth':
												esc_html_e( 'Every Two Months', 'lsvr-events' );
												break;
											case 'year':
												esc_html_e( 'Yearly', 'lsvr-events' );
												break;
										}

									} ?>

								</p>
							</div>

						</div>

						<?php
					}

					// One-time event
					else {

						?>
						<div class="lsvr-events-admin-view__start-date-column">
							<div class="lsvr-events-admin-view__start-date">

								<?php
								echo ucfirst( date_i18n( get_option('date_format'), strtotime( $start_date_local ) ) );
								if ( true === $allday ) {
									echo '<br>@ ' . esc_html__( 'All-day', 'lsvr-events' );
								}
								else {
									echo '<br>@ ' . esc_html( $start_time_local );
								}
								?>

							</div>
						</div>
						<?php

					}

				}

				// End date
				else if ( 'lsvr_event_end_date' === $column && ! empty( $end_date_local ) ) {

					// Recurring event
					if ( ! empty( $event_repeat ) && empty( $allday ) ) {
						?>
						<div class="lsvr-events-admin-view__end-date-column">

							<p class="lsvr-events-admin-view__cell-title"><small><strong><?php esc_html_e( 'Recurring Event', 'lsvr-events' ); ?></strong></small></p>

							<?php $next_occurrence_local = lsvr_events_get_next_occurrences( $post->ID, 1, 0 ); ?>
							<?php $last_occurrence_local = lsvr_events_get_recent_occurrences( $post->ID, 1, 0 ); ?>

							<?php // Next event occurrence end date
							if ( ! empty( $next_occurrence_local[0]['end'] ) && strtotime( $next_occurrence_local[0]['end'] ) ) : ?>

								<div class="lsvr-events-admin-view__next-occurrence">
									<p>
										<small><?php esc_html_e( 'Next Occurrence End:', 'lsvr-events' ); ?></small><br>
										<?php
										echo ucfirst( date_i18n( get_option('date_format'), strtotime( $next_occurrence_local[0]['end'] ) ) );
										if ( true === $allday ) {
											echo '<br>@ ' . esc_html__( 'All-day', 'lsvr-events' );
										}
										else {
											echo '<br>@ ' . date_i18n( get_option( 'time_format' ), strtotime( $next_occurrence_local[0]['end'] ) );
										}
										?>
									</p>
								</div>

							<?php // Last event occurrence end date
							elseif ( ! empty( $last_occurrence_local[0]['end'] ) && strtotime( $last_occurrence_local[0]['end'] ) ) : ?>

								<div class="lsvr-events-admin-view__next-occurrence">
									<p>
										<small><?php esc_html_e( 'Last Occurrence End:', 'lsvr-events' ); ?></small><br>
										<?php
										echo ucfirst( date_i18n( get_option('date_format'), strtotime( $last_occurrence_local[0]['end'] ) ) );
										if ( true === $allday ) {
											echo '<br>@ ' . esc_html__( 'All-day', 'lsvr-events' );
										}
										else {
											echo '<br>@ ' . date_i18n( get_option( 'time_format' ), strtotime( $last_occurrence_local[0]['end'] ) );
										}
										?>
									</p>
								</div>

							<?php endif; ?>

						</div>
						<?php
					}

					// One-time event
					else {

						?>
						<div class="lsvr-events-admin-view__end-date-column">
							<div class="lsvr-events-admin-view__end-date">

								<?php
								if ( true === $allday ) {
									esc_html_e( 'All-day event', 'lsvr-events' );
								}
								else {
									echo ucfirst( date_i18n( get_option('date_format'), strtotime( $end_date_local ) ) );
									echo '<br>@ ' . esc_html( $end_time_local );
								}
								?>

							</div>
						</div>
						<?php

					}

				}

			}
		}

	}
}

?>