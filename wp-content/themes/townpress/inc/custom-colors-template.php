<?php

// Get custom colors template
if ( ! function_exists( 'lsvr_townpress_get_custom_colors_template' ) ) {
	function lsvr_townpress_get_custom_colors_template() {

			return '
body { color: $body-font; }
a { color: $body-link; }
abbr { border-color: $body-font; }
button { color: $body-font; }
input, select, textarea { color: $body-font; }
.c-button { border-color: $accent1; background-color: $accent1; }
.c-button--outline { color: $accent1; }
.c-search-form__button { background-color: $accent1; }
.header-navbar { background-color: $accent1; }
.header-menu__item--dropdown .header-menu__item .header-menu__item-link { color: $accent1; }
.header-map__close { background-color: $accent1; }
.header-map-toggle__ico { color: $accent1; }
.header-map-toggle--active { background-color: $accent1; }
.header-languages__item-link { $body-font; }
.header-languages__item--active .header-languages__item-link { background-color: $accent1; }
.header-login__link { color: $body-font; }
.header-login__ico { color: $accent1; }
.header-login__link--logout { background-color: $accent1; }
.header-toolbar-toggle__menu-button { color: $body-font; }
.header-toolbar-toggle__menu-button--active { background-color: $accent1; }
.header-mobile-menu { background-color: $accent1; }
.post-password-form input[type="submit"] { background-color: $accent1; }
.post-comments__list a.comment-edit-link { color: $accent1; }
.comment-form .submit { background-color: $accent1; }
.post-pagination__item-link,
.post-pagination__number-link { color: $accent1; }
.post-pagination__number--active .post-pagination__number-link { background-color: $accent1; }
.post-pagination__number-link:hover { color: $accent1; }
.navigation.pagination a { color: $accent1; }
.navigation.pagination .page-numbers.current { background-color: $accent1; }
.navigation.pagination .page-numbers:not( .next ):not( .prev ):not( .dots ):not( .current ):hover { color: $accent1; }
.lsvr_listing-map__marker-inner { background-color: $accent1; border-color: $accent1; }
.lsvr_listing-map__marker-inner:before { border-top-color: $accent1; }
.lsvr_listing-map__infobox-more-link { background-color: $accent1; }
.lsvr_listing-post-single .post__contact-item:before { color: $accent1; }
.lsvr_listing-post-single .post__social-links-link:hover { background-color: $accent1; }
.lsvr_event-post-single .post__info-item:before { color: $accent1; }
.lsvr_document-post-archive--default .post__title-link { color: $accent1; }
.lsvr_document-post-archive--categorized-attachments .post-tree__item-link-holder--folder:before { color: $accent1; }
.lsvr_document-post-archive--categorized-attachments .post-tree__item-toggle { color: $accent1; }
.lsvr_person-post-page .post__contact-item:before { color: $accent1; }
.lsvr_person-post-page .post__social-link:hover { background-color: $accent1; }
.widget__title-icon { color: $accent1; }
.lsvr-townpress-menu-widget__nav { background-color: $accent1; }
.lsvr_event-list-widget__item-date-month { background-color: $accent1; }
.lsvr_event-filter-widget__option--datepicker:after { color: $accent1; }
.lsvr_event-filter-widget__submit-button { background-color: $accent1; }
.lsvr_person-list-widget__item-title-link { color: $accent1; }
.lsvr_person-list-widget__item-social-link:hover { background-color: $accent1; }
.lsvr_person-featured-widget__title-link { color: $accent1; }
.lsvr_person-featured-widget__social-link:hover { background-color: $accent1; }
.widget_display_search .button { background-color: $accent1; }
.footer-widgets .widget__title-icon { color: $accent1; }
.lsvr_person-list-widget__item-social-link { background-color: $accent1; }
.lsvr_person-featured-widget__social-link { background-color: $accent1; }
.footer-social__link { background-color: $accent1; }
.lsvr-townpress-posts__title-icon { color: $accent1; }
.lsvr-townpress-post-slider__indicator-inner { background-color: $accent1; }
.lsvr-townpress-sitemap__title-icon { color: $accent1; }
.lsvr-button { border-color: $accent1; background-color: $accent1; }
.lsvr-counter__number { color: $accent1; }
.lsvr-cta__button-link { border-color: $accent1; background-color: $accent1; }
.lsvr-feature__icon { color: $accent1; }
.lsvr-progress-bar__bar-inner { background-color: $accent1; }
.lsvr-pricing-table__title { background-color: $accent1; }
.lsvr-pricing-table__price-value { color: $accent1; }
.lsvr-pricing-table__button-link { border-color: $accent1; background-color: $accent1; }
.bbp-submit-wrapper button { border-color: $accent1; background-color: $accent1; }
#bbpress-forums .bbp-reply-content #subscription-toggle a { color: $accent1; }
#bbpress-forums .bbp-pagination-links .page-numbers.current { background-color: $accent1; }
#bbpress-forums #bbp-your-profile fieldset input,
#bbpress-forums #bbp-your-profile fieldset textarea { color: $body-font; }
#bbpress-forums #bbp-your-profile #bbp_user_edit_submit { border-color: $accent1; background-color: $accent1; }
.lsvr-datepicker .ui-datepicker-prev,
.lsvr-datepicker .ui-datepicker-next { color: $accent1; }
.lsvr-datepicker th { color: $accent1; }
.lsvr-datepicker td a { color: $body-font; }
.lsvr-datepicker .ui-state-active { color: $accent1; }
.back-to-top__link { background-color: $accent1; }
';

	}
}
?>