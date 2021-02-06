<?php

// Get editor custom colors template
if ( ! function_exists( 'lsvr_townpress_get_editor_custom_colors_template' ) ) {
	function lsvr_townpress_get_editor_custom_colors_template() {

			return '
.editor-styles-wrapper body { color: $body-font; }
.editor-styles-wrapper a { color: $body-link; }
.editor-styles-wrapper abbr { border-color: $body-font; }
.editor-styles-wrapper button { color: $body-font; }
.editor-styles-wrapper .c-button { border-color: $accent1; background-color: $accent1; }
.editor-styles-wrapper .c-button--outline { color: $accent1; }
.editor-styles-wrapper .widget__title-icon { color: $accent1; }
.editor-styles-wrapper .lsvr-townpress-menu-widget__nav { background-color: $accent1; }
.editor-styles-wrapper .lsvr_event-list-widget__item-date-month { background-color: $accent1; }
.editor-styles-wrapper .lsvr_event-filter-widget__option--datepicker:after { color: $accent1; }
.editor-styles-wrapper .lsvr_event-filter-widget__submit-button { background-color: $accent1; }
.editor-styles-wrapper .lsvr_person-list-widget__item-title-link { color: $accent1; }
.editor-styles-wrapper .lsvr_person-list-widget__item-social-link:hover { background-color: $accent1; }
.editor-styles-wrapper .lsvr_person-featured-widget__title-link { color: $accent1; }
.editor-styles-wrapper .lsvr_person-featured-widget__social-link:hover { background-color: $accent1; }
.editor-styles-wrapper .widget_display_search .button { background-color: $accent1; }
.editor-styles-wrapper .lsvr-townpress-posts__title-icon { color: $accent1; }
.editor-styles-wrapper .lsvr-townpress-post-slider__indicator-inner { background-color: $accent1; }
.editor-styles-wrapper .lsvr-townpress-sitemap__title-icon { color: $accent1; }
.editor-styles-wrapper .lsvr-button { border-color: $accent1; background-color: $accent1; }
.editor-styles-wrapper .lsvr-counter__number { color: $accent1; }
.editor-styles-wrapper .lsvr-cta__button-link { border-color: $accent1; background-color: $accent1; }
.editor-styles-wrapper .lsvr-feature__icon { color: $accent1; }
.editor-styles-wrapper .lsvr-progress-bar__bar-inner { background-color: $accent1; }
.editor-styles-wrapper .lsvr-pricing-table__title { background-color: $accent1; }
.editor-styles-wrapper .lsvr-pricing-table__price-value { color: $accent1; }
.editor-styles-wrapper .lsvr-pricing-table__button-link { border-color: $accent1; background-color: $accent1; }
';

	}
}
?>