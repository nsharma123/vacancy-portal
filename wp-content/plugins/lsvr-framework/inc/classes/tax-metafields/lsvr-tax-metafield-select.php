<?php
/**
 * Select metafield class
 */
if ( ! class_exists( 'Lsvr_Tax_Metafield_Select' ) && class_exists( 'Lsvr_Tax_Metafield' ) ) {
    class Lsvr_Tax_Metafield_Select extends Lsvr_Tax_Metafield {

    	public function __construct( $args ) {
    		parent::__construct( $args );
    	}

    	// Display field
    	public function display_metafield() {
    		?>

            <?php if ( ! empty( $this->args['choices'] ) ) : ?>

                <select class="lsvr-tax-metafield__value"
                    id="<?php echo esc_attr( $this->input_id ); ?>"
                    name="<?php echo esc_attr( $this->input_id ); ?>">

                    <?php if ( ! empty( $this->args['default_option'] ) ) : ?>
                        <option value="<?php echo esc_attr( $this->args['default_option']['value'] ); ?>"
                            <?php if ( ! empty( $this->current_value )
                                && (string) $this->args['default_option']['value'] === (string) $this->current_value ) {
                                    echo ' selected="selected"';
                                } ?>>
                            <?php echo esc_html( $this->args['default_option']['label'] ); ?>
                        </option>
                    <?php endif; ?>

                    <?php foreach ( $this->args['choices'] as $value => $label ) : ?>
                        <option value="<?php echo esc_attr( $value ); ?>"
                            <?php if ( ! empty( $this->current_value )
                                && (string) $value === (string) $this->current_value ) {
                                    echo ' selected="selected"';
                                } ?>>
                            <?php echo esc_html( $label ); ?></option>
                    <?php endforeach; ?>

                </select>

            <?php endif; ?>

    		<?php
    	}

    }
}

?>