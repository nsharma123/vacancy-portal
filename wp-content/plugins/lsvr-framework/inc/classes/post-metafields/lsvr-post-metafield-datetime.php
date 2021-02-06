<?php
/**
 * Datetime metafield class
 */
if ( ! class_exists( 'Lsvr_Post_Metafield_Datetime' ) && class_exists( 'Lsvr_Post_Metafield' ) ) {
    class Lsvr_Post_Metafield_Datetime extends Lsvr_Post_Metafield {

    	public function __construct( $args ) {
    		parent::__construct( $args );
    	}

    	// Display field
    	public function display_metafield() {

			// Set default value
			if ( empty( $this->current_value ) ) {
				$this->current_value = get_gmt_from_date( current_time( 'mysql' ), 'Y-m-d 08:00:00' );
			}

    		// Convert saved UTC date to local date
			$current_value_local = get_date_from_gmt( date( 'Y-m-d H:i:s', strtotime( $this->current_value ) ), 'Y-m-d H:i:s' );

    		// Parse saved datetime value
    		$current_value_timestamp = strtotime( $current_value_local );
			$fulldate_input_value = '';
			$date_input_value = '';
			$hour_input_value = '';
			$minute_input_value = '';
			if ( $current_value_timestamp ) {
				$date_input_value = date( 'Y-m-d', $current_value_timestamp );
				$hour_input_value = date( 'H', $current_value_timestamp );
				$minute_input_value = date( 'i', $current_value_timestamp );
				$fulldate_input_value = date( 'Y-m-d H:i', $current_value_timestamp );
			}
    		?>

			<div class="lsvr-post-metafield-datetime">
				<input type="hidden" value="<?php echo esc_attr( $fulldate_input_value ); ?>"
					class="lsvr-post-metafield__value lsvr-post-metafield-datetime__value"
					id="<?php echo esc_attr( $this->input_id ); ?>"
					name="<?php echo esc_attr( $this->input_id ); ?>">
				<span class="lsvr-post-metafield-datetime__input-wrapper">
					<input type="date" value="<?php echo esc_attr( $date_input_value ); ?>"
						class="lsvr-post-metafield-datetime__input-date">
				</span>@

				<div class="lsvr-post-metafield-datetime__time-wrapper">

					<span class="lsvr-post-metafield-datetime__select-wrapper">
						<span class="screen-reader-text"><?php esc_html_e( 'Hour', 'lsvr-framework' ); ?></span>
						<select class="lsvr-post-metafield-datetime__input-hour">
							<?php for ( $i = 0; $i < 24; $i++ ) : ?>
								<?php $value = str_pad( $i, 2, 0, STR_PAD_LEFT ); ?>
								<option value="<?php echo esc_attr( $value ); ?>"<?php if ( $value === $hour_input_value) { echo ' selected="selected"'; } ?>>
									<?php echo esc_html( $value ); ?>
								</option>
							<?php endfor; ?>
						</select>
					</span>:
					<span class="lsvr-post-metafield-datetime__select-wrapper">
						<span class="screen-reader-text"><?php esc_html_e( 'Minute', 'lsvr-framework' ); ?></span>
						<select class="lsvr-post-metafield-datetime__input-minute">
							<?php for ( $i = 0; $i < 60; $i++ ) : ?>
								<?php $value = str_pad( $i, 2, 0, STR_PAD_LEFT ); ?>
								<option value="<?php echo esc_attr( $value ); ?>"<?php if ( $value === $minute_input_value) { echo ' selected="selected"'; } ?>><?php echo esc_html( $value ); ?></option>
							<?php endfor; ?>
						</select>
					</span>

				</div>

			</div>

    		<?php
    	}

    	// Sanitize metafield value before saving
    	public static function sanitize_before_save( $value ) {

    		// Convert local date to UTC
    		if ( strtotime( $value ) ) {
    			return esc_attr( get_gmt_from_date( date( 'Y-m-d H:i:s', strtotime( $value ) ), 'Y-m-d H:i:s' ) );
    		} else {
    			return '';
    		}

    	}

    }
}

?>