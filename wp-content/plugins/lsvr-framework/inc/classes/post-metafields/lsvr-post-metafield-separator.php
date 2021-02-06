<?php
/**
 * Separator metafield class
 */
if ( ! class_exists( 'Lsvr_Post_Metafield_Separator' ) && class_exists( 'Lsvr_Post_Metafield' ) ) {
    class Lsvr_Post_Metafield_Separator extends Lsvr_Post_Metafield {

    	public function __construct( $args ) {
    		parent::__construct( $args );
    	}

    	// Display field
    	public function display_metafield() {
    		?>

    		<hr class="lsvr-post-metafield-separator">

    		<?php
    	}

    }
}

?>