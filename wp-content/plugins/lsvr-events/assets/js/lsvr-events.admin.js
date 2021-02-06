(function($){ "use strict";
	$(document).ready(function() {


	    // Admin view event post date filter
	    if ( $.fn.datepicker ) {
			$( '.lsvr-events-admin-view__date-filter' ).each(function() {

				var $this = $(this),
				$dateInputs = $this.find( 'input[type="date"]' );

				// Show datepicker
				$dateInputs.each(function() {

					// Show datepicker
					$(this).datepicker({
						dateFormat: 'yy-mm-dd',
						beforeShow: function() {
							$( '#ui-datepicker-div' ).addClass( 'lsvr-events-admin-view__datepicker' );
						},
					});

					// Focus onto input after inserting date from datepicker
					$(this).change(function() {
						$(this).focus();
					});

				});

			});
		}

	});
})(jQuery);