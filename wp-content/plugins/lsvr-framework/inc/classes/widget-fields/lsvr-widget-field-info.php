<?php
/**
 * Info widget field class
 */
if ( ! class_exists( 'Lsvr_Widget_Field_Info' ) && class_exists( 'Lsvr_Widget_Field' ) ) {
    class Lsvr_Widget_Field_Info extends Lsvr_Widget_Field {

    	public function __construct( $args ) {
    		parent::__construct( $args );
    	}

    	// Display field
    	public function display_field() {
    		?>

            <?php if ( ! empty( $this->args['content'] ) ) : ?>
                <p><?php echo esc_html( $this->args['content'] ); ?></p>
            <?php endif; ?>


			<?php
    	}

    }
}