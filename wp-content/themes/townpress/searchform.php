<!-- SEARCH FORM : begin -->
<form class="c-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search">
	<div class="c-search-form__inner">
		<div class="c-search-form__input-holder">
			<input class="c-search-form__input" type="text" name="s"
				placeholder="<?php echo esc_attr( get_theme_mod( 'search_input_placeholder', esc_html__( 'Search this site...', 'townpress' ) ) ); ?>"
				value="<?php echo esc_attr( get_search_query() ); ?>">
			<button class="c-search-form__button" type="submit" title="<?php esc_html_e( 'Search', 'townpress' ); ?>">
				<i class="c-search-form__button-ico icon-magnifier"></i></button>
		</div>
	</div>
</form>
<!-- SEARCH FORM : end -->