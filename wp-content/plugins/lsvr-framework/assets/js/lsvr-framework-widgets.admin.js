(function($){ "use strict";

/* -----------------------------------------------------------------------------

	INIT

----------------------------------------------------------------------------- */

	$(document).on( 'ready widget-added', function() {

	    /* ---------------------------------------------------------------------
	    	INIT WIDGET FIELDS
	    --------------------------------------------------------------------- */

	    // Image
		if ( $.fn.lsvrWidgetFieldImage ) {
			$( '.lsvr-widget-field--image' ).not( '.lsvr-widget-field--init' ).each(function() {
				$(this).addClass( '.lsvr-widget-field--init' );
				$(this).lsvrWidgetFieldImage();
			});
		}

	});

})(jQuery);


(function($){ "use strict";

/* -----------------------------------------------------------------------------

	WIDGET FIELDS

----------------------------------------------------------------------------- */

	/* -------------------------------------------------------------------------
		IMAGE
	------------------------------------------------------------------------- */

	if ( ! $.fn.lsvrWidgetFieldImage ) {
		$.fn.lsvrWidgetFieldImage = function() {
			if ( typeof wp.media !== 'undefined' ) {

				var $this = $(this),
					$input = $this.find( '.lsvr-widget-field__input' ),
					$container = $this.find( '.lsvr-widget-field__image' ),
					$imagePreview = $this.find( '.lsvr-widget-field__image-preview' ),
					$imagePlaceholder = $this.find( '.lsvr-widget-field__image-placeholder' ),
					$addButton = $this.find( '.lsvr-widget-field__image-add' ),
					$removeButton = $this.find( '.lsvr-widget-field__image-remove' ),
					mediaFrame;

				// Choose image
				$addButton.on( 'click', function() {

					// Open media modal
					if ( mediaFrame ) {
						mediaFrame.open();
					}

					// Init media modal
					else {

						mediaFrame = wp.media.frames.file_frame = wp.media({
							multiple: false
						});

						// When a file is selected, grab the URL and set it as the text field's value
						mediaFrame.on( 'select', function() {
							var attachment = mediaFrame.state().get( 'selection' ).first().toJSON();
							if ( attachment.sizes.hasOwnProperty( 'thumbnail' ) ) {
								$imagePlaceholder.html( '<img src="' + attachment.sizes.thumbnail.url + '" alt="">' );
							} else {
								$imagePlaceholder.html( '<img src="' + attachment.sizes.full.url + '" alt="">' );
							}
							$container.addClass( 'lsvr-widget-field__image--has-image' );
							$input.val( attachment.id ).trigger( 'change' );
						});

						mediaFrame.open();

					}

				});

				// Remove image
				$removeButton.on( 'click', function() {
					$imagePlaceholder.html( '' );
					$container.removeClass( 'lsvr-widget-field__image--has-image' );
					$input.val( '' );
				});

			}
		};
	}

})(jQuery);