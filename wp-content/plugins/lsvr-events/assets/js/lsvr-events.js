(function($){ "use strict";
$(document).on( 'ready', function() {

/* -----------------------------------------------------------------------------

	WIDGETS

----------------------------------------------------------------------------- */

	// Events filter
	$( '.lsvr_event-filter-widget' ).each(function() {

		var $this = $(this),
			$form = $this.find( '.lsvr_event-filter-widget__form' );

		// Datepicker
		if ( $.fn.datepicker ) {

			$this.find( '.lsvr_event-filter-widget__input--datepicker' ).each(function() {

				var $datepicker = $(this);

				$datepicker.datepicker({
					dateFormat: 'yy-mm-dd',
					beforeShow: function() {
						$( '#ui-datepicker-div' ).addClass( 'lsvr-datepicker' );
					},
				});

				$datepicker.parent().on( 'click', function() {
					$datepicker.datepicker( 'show' );
				});

			});
		}

	});

});
})(jQuery);