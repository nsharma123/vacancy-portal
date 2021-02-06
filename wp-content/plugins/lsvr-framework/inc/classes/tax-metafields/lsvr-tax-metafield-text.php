<?php
/**
 * Text metafield class
 */
if ( ! class_exists( 'Lsvr_Tax_Metafield_Text' ) && class_exists( 'Lsvr_Tax_Metafield' ) ) {
    class Lsvr_Tax_Metafield_Text extends Lsvr_Tax_Metafield {

    	public function __construct( $args ) {
    		parent::__construct( $args );
    	}

    	// Display field
    	public function display_metafield() {
    		?>

    		<input type="text" value="<?php echo esc_attr( $this->current_value ); ?>"
				class="regular-text lsvr-tax-metafield__value"
				id="<?php echo esc_attr( $this->input_id ); ?>"
				name="<?php echo esc_attr( $this->input_id ); ?>">

    		<?php
    	}

    }
}

?>