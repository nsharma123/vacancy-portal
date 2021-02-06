<?php
/**
 * Switch metafield class
 */
if ( ! class_exists( 'Lsvr_Post_Metafield_Switch' ) && class_exists( 'Lsvr_Post_Metafield' ) ) {
    class Lsvr_Post_Metafield_Switch extends Lsvr_Post_Metafield {

    	public function __construct( $args ) {
    		parent::__construct( $args );
    	}

    	// Display field
    	public function display_metafield() {

    		$checked = true === $this->current_value || 'true' === $this->current_value ? true : false;
    		$default_input_value = true === $checked ? 'true' : 'false'; ?>

			<div class="lsvr-post-metafield-switch">
				<input type="hidden" value="<?php echo esc_attr( $default_input_value ); ?>"
					class="lsvr-post-metafield__value lsvr-post-metafield-switch__value"
					id="<?php echo esc_attr( $this->input_id ); ?>" name="<?php echo esc_attr( $this->input_id ); ?>">

				<label for="<?php echo esc_attr( $this->input_id . '_switch' ); ?>"
					class="lsvr-post-metafield-switch__item">
					<input type="checkbox" value="true"
						id="<?php echo esc_attr( $this->input_id . '_switch' ); ?>"
						name="<?php echo esc_attr( $this->input_id . '_switch' ); ?>"
						<?php if ( true === $checked  ) {
							echo ' checked="checked"'; } ?>>
					<span><?php echo ! empty( $this->args['label'] ) ? esc_html( $this->args['label'] ) : esc_html__( 'Enable', 'lsvr-framework' ); ?></span>
				</label>

			</div>

    		<?php
    	}

    }
}

?>