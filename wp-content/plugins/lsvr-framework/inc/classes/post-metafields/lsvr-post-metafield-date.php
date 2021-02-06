<?php
/**
 * Date metafield class
 */
if ( ! class_exists( 'Lsvr_Post_Metafield_Date' ) && class_exists( 'Lsvr_Post_Metafield' ) ) {
    class Lsvr_Post_Metafield_Date extends Lsvr_Post_Metafield {

    	public function __construct( $args ) {
    		parent::__construct( $args );
    	}

    	// Display field
    	public function display_metafield() {

			// Set default value
			if ( empty( $this->current_value ) && ! empty( $this->default_value ) && strtotime( $this->default_value ) ) {
				$this->current_value = date( 'Y-m-d', strtotime( $this->default_value ) );
			} else if ( empty( $this->current_value ) && empty( $this->default_value ) ) {
                $this->current_value = current_time( 'Y-m-d' );
            }

    		// Get current value
			$current_value_local = date( 'Y-m-d', strtotime( $this->current_value ) );
    		?>

			<div class="lsvr-post-metafield-date">
				<span class="lsvr-post-metafield-date__input-wrapper">
					<input type="date" value="<?php echo esc_attr( $current_value_local ); ?>"
						id="<?php echo esc_attr( $this->input_id ); ?>" name="<?php echo esc_attr( $this->input_id ); ?>"
						class="lsvr-post-metafield-date__value">
				</span>
			</div>

    		<?php
    	}

    	// Sanitize metafield value before saving
    	public static function sanitize_before_save( $value ) {

    		// Make sure to save value as date
    		if ( strtotime( $value ) ) {
    			return esc_attr( date( 'Y-m-d H:i:s', strtotime( $value ) ), 'Y-m-d H:i:s' );
    		} else {
    			return '';
    		}

    	}

    }
}

?>