(function($){ "use strict";

/* -----------------------------------------------------------------------------

	INIT

----------------------------------------------------------------------------- */

	$(document).on( 'ready', function() {

	    /* ---------------------------------------------------------------------
	    	INIT TAX METAFIELDS
	    --------------------------------------------------------------------- */

	    // Image
		if ( $.fn.lsvrTaxonomyMetafieldImage ) {
			$( '.lsvr-tax-metafield--image' ).each(function() {
				$(this).lsvrTaxonomyMetafieldImage();
			});
		}

	});

})(jQuery);


(function($){ "use strict";

/* -----------------------------------------------------------------------------

	TAX METAFIELDS

----------------------------------------------------------------------------- */

	/* -------------------------------------------------------------------------
		IMAGE
	------------------------------------------------------------------------- */

	if ( ! $.fn.lsvrTaxonomyMetafieldImage ) {
		$.fn.lsvrTaxonomyMetafieldImage = function() {
			if ( typeof wp.media !== 'undefined' ) {

				var $this = $(this),
					$input = $this.find( '.lsvr-tax-metafield__value' ),
					$container = $this.find( '.lsvr-tax-metafield__image' ),
					$imagePreview = $this.find( '.lsvr-tax-metafield__image-preview' ),
					$imagePlaceholder = $this.find( '.lsvr-tax-metafield__image-placeholder' ),
					$addButton = $this.find( '.lsvr-tax-metafield__image-add' ),
					$removeButton = $this.find( '.lsvr-tax-metafield__image-remove' ),
					$message = $this.find( '.lsvr-tax-metafield__image-message' ),
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
							$container.addClass( 'lsvr-tax-metafield__image--has-image' );
							$message.hide();
							$input.val( attachment.id ).trigger( 'change' );
						});

						mediaFrame.open();

					}

				});

				// Remove image
				$removeButton.on( 'click', function() {
					$imagePlaceholder.html( '' );
					$container.removeClass( 'lsvr-tax-metafield__image--has-image' );
					$message.show();
					$input.val( '' );
				});

			}
		};
	}

})(jQuery);