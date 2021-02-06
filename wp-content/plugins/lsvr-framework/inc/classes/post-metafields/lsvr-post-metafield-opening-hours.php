<?php
/**
 * Opening hours metafield class
 */
if ( ! class_exists( 'Lsvr_Post_Metafield_Opening_Hours' ) && class_exists( 'Lsvr_Post_Metafield' ) ) {
    class Lsvr_Post_Metafield_Opening_Hours extends Lsvr_Post_Metafield {

    	public function __construct( $args ) {
    		parent::__construct( $args );
    	}

    	// Display field
    	public function display_metafield() {

    		// Create array with all weekdays
			$weekdays = array(
    			array( 'id' => 'sun', 'label' => date_i18n( 'l', strtotime( 'Sunday' ) ) ),
    			array( 'id' => 'mon', 'label' => date_i18n( 'l', strtotime( 'Monday' ) ) ),
    			array( 'id' => 'tue', 'label' => date_i18n( 'l', strtotime( 'Tuesday' ) ) ),
    			array( 'id' => 'wed', 'label' => date_i18n( 'l', strtotime( 'Wednesday' ) ) ),
    			array( 'id' => 'thu', 'label' => date_i18n( 'l', strtotime( 'Thursday' ) ) ),
    			array( 'id' => 'fri', 'label' => date_i18n( 'l', strtotime( 'Friday' ) ) ),
    			array( 'id' => 'sat', 'label' => date_i18n( 'l', strtotime( 'Saturday' ) ) ),
			);

    		// Get start day of week from Settings / Global
			$start_of_week = get_option( 'start_of_week' );
			$start_of_week = ! empty( $weekdays[ $start_of_week ] ) ? $start_of_week : 0;

			// Change order of weekdays based on $start_of_week
			if ( $start_of_week > 0 ) {
				$weekdays_part1 = array_slice( $weekdays, $start_of_week );
				$weekdays_part2 = array_slice( $weekdays, 0, $start_of_week );
				$weekdays_sorted = array_merge( $weekdays_part1, $weekdays_part2 );
			} else {
				$weekdays_sorted = $weekdays;
			}

			// Convert current JSON value to array
			if ( $this->current_value !== '' ) {
				$current_hours = @json_decode( $this->current_value );
			}

    		?>

			<div class="lsvr-post-metafield-opening-hours">

				<input type="hidden" value="<?php echo esc_attr( $this->current_value ); ?>"
					class="lsvr-post-metafield__value lsvr-post-metafield-opening-hours__value"
					id="<?php echo esc_attr( $this->input_id ); ?>"
					name="<?php echo esc_attr( $this->input_id ); ?>">

				<div class="lsvr-post-metafield-opening-hours__rows">

					<?php foreach ( $weekdays_sorted as $day ) : ?>

						<div class="lsvr-post-metafield-opening-hours__row"
							data-day="<?php echo esc_attr( $day['id'] ); ?>">

							<?php // Check if hours aren't closed for this row
							$day_id = $day['id'];
							$is_closed = ! empty( $current_hours->$day_id )
								&& 'closed' === $current_hours->$day_id ? true : false; ?>

							<?php // Parse time
							if ( false === $is_closed && ! empty( $current_hours ) ) {
								$time_from = substr( $current_hours->$day_id, 0, strpos( $current_hours->$day_id, '-' ) );
								$hour_from = substr( $time_from, 0, strpos( $time_from, ':' ) );
								$minute_from = substr( $time_from, strpos( $time_from, ':' ) + 1, strlen( $time_from ) );
								$time_to = substr( $current_hours->$day_id, strpos( $current_hours->$day_id, '-' ) + 1, strlen( $current_hours->$day_id ) );
								$hour_to = substr( $time_to, 0, strpos( $time_to, ':' ) );
								$minute_to = substr( $time_to, strpos( $time_to, ':' ) + 1, strlen( $time_to ) );
							} ?>

							<strong class="lsvr-post-metafield-opening-hours__label">
								<?php echo esc_html( $day['label'] ); ?>
							</strong>

							<div class="lsvr-post-metafield-opening-hours__time-wrapper">

								<select class="lsvr-post-metafield-opening-hours__select lsvr-post-metafield-opening-hours__hour-from"
									<?php if ( true === $is_closed ) { echo ' disabled="disabled"'; } ?>>
									<?php for ( $i = 0; $i < 24; $i++ ) : ?>
										<?php $value = str_pad( $i, 2, 0, STR_PAD_LEFT ); ?>
										<option value="<?php echo esc_attr( $value ); ?>"
											<?php if ( false === $is_closed && ! empty( $hour_from ) &&
												$value === $hour_from ) { echo ' selected="selected"'; } ?>>
											<?php echo esc_html( $value ); ?>
										</option>
									<?php endfor; ?>
								</select>

								<span class="lsvr-post-metafield-opening-hours__colon">:</span>

								<select class="lsvr-post-metafield-opening-hours__select lsvr-post-metafield-opening-hours__minute-from"
									<?php if ( true === $is_closed ) { echo ' disabled="disabled"'; } ?>>
									<?php for ( $i = 0; $i < 60; $i++ ) : ?>
										<?php $value = str_pad( $i, 2, 0, STR_PAD_LEFT ); ?>
										<option value="<?php echo esc_attr( $value ); ?>"
											<?php if ( false === $is_closed && ! empty( $minute_from ) &&
												$value === $minute_from ) { echo ' selected="selected"'; } ?>>
											<?php echo esc_html( $value ); ?>
										</option>
									<?php endfor; ?>
								</select>

								<span class="lsvr-post-metafield-opening-hours__separator">-</span>

								<select class="lsvr-post-metafield-opening-hours__select lsvr-post-metafield-opening-hours__hour-to"
									<?php if ( true === $is_closed ) { echo ' disabled="disabled"'; } ?>>
									<?php for ( $i = 0; $i < 24; $i++ ) : ?>
										<?php $value = str_pad( $i, 2, 0, STR_PAD_LEFT ); ?>
										<option value="<?php echo esc_attr( $value ); ?>"
											<?php if ( false === $is_closed && ! empty( $hour_to ) &&
												$value === $hour_to ) { echo ' selected="selected"'; } ?>>
											<?php echo esc_html( $value ); ?>
										</option>
									<?php endfor; ?>
								</select>

								<span class="lsvr-post-metafield-opening-hours__colon">:</span>

								<select class="lsvr-post-metafield-opening-hours__select lsvr-post-metafield-opening-hours__minute-to"
									<?php if ( true === $is_closed ) { echo ' disabled="disabled"'; } ?>>
									<?php for ( $i = 0; $i < 60; $i++ ) : ?>
										<?php $value = str_pad( $i, 2, 0, STR_PAD_LEFT ); ?>
										<option value="<?php echo esc_attr( $value ); ?>"
											<?php if ( false === $is_closed && ! empty( $minute_to ) &&
												$value === $minute_to ) { echo ' selected="selected"'; } ?>>
											<?php echo esc_html( $value ); ?>
										</option>
									<?php endfor; ?>
								</select>

							</div>

							<label for="lsvr-post-metafield-opening-hours__checkbox-closed--<?php echo esc_attr( $day['id'] ); ?>"
								class="lsvr-post-metafield-opening-hours__label-closed">
								<input type="checkbox" value="closed"
									class="lsvr-post-metafield-opening-hours__checkbox-closed"
									id="lsvr-post-metafield-opening-hours__checkbox-closed--<?php echo esc_attr( $day['id'] ); ?>"
									<?php if ( true === $is_closed ) { echo ' checked="checked"'; } ?>>
								<span><?php esc_html_e( 'Closed', 'lsvr-framework' ); ?></span>
							</label>

						</div>
					<?php endforeach; ?>

				</div>

			</div>

    		<?php
    	}

    }
}

?>