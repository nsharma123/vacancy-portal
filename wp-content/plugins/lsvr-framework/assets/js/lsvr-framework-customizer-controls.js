(function($){ "use strict";

/* -----------------------------------------------------------------------------

	INIT

----------------------------------------------------------------------------- */

	$(document).ready(function() {

	    /* ---------------------------------------------------------------------
	    	MULTICHECK
	    --------------------------------------------------------------------- */

		$( '.lsvr-customizer-control-multicheck' ).each(function() {

			var $this = $(this),
				$valueInput = $this.find( '.lsvr-customizer-control-multicheck__value' ),
    			$checkboxes = $this.find( '.lsvr-customizer-control-multicheck__checkbox' );

			// Update the value input
			var update = function() {
				var values = [];
				$checkboxes.filter( ':checked' ).each(function() {
					values.push( $(this).val() );
				});
				if ( values.length > 0 ) {
					$valueInput.val( values.join( ',' ) );
				} else {
					$valueInput.val( '' );
				}
				$valueInput.trigger( 'change' );
			}

			// Add change listener for all checkboxes
			$checkboxes.each(function() {
				$(this).on( 'change', function() {
					update();
				});
			});

		});

	    /* ---------------------------------------------------------------------
	    	CUSTOM SIDEBARS
	    --------------------------------------------------------------------- */

	    $( '.lsvr-customizer-control-sidebars' ).each(function() {
	    	if ( $.fn.sortable ) {

				var $this = $(this),
					$valueInput = $this.find( '.lsvr-customizer-control-sidebars__value' ),
					$list = $this.find( '.lsvr-customizer-control-sidebars__list' ),
					$addButton = $this.find( '.lsvr-customizer-control-sidebars__add-button' ),
					$noSidebarsMessage = $this.find( '.lsvr-customizer-control-sidebars__no-sidebars' ),
					inputPlaceholder = $this.data( 'input-placeholder' ),
					lastId = $list.data( 'last-id' );

	    		// Update the value input
	    		var update = function() {

    				var savedData = {},
    					sidebars = [];

	    			// There is at least one sidebar
	    			if ( $list.find( '.lsvr-customizer-control-sidebars__item' ).length > 0 ) {

	    				$list.find( '.lsvr-customizer-control-sidebars__item' ).each(function() {

	    					var sidebar = {};
	    					sidebar.id = $(this).attr( 'data-sidebar-id' );
	    					sidebar.label = $(this).find( 'input' ).val();
	    					sidebars.push( sidebar );

	    				});

	    				savedData.last_id = lastId;
	    				savedData.sidebars = sidebars;

	    			}

	    			// There are no sidebars
	    			else {

	    				savedData.last_id = lastId;
	    				savedData.sidebars = '';

	    			}

	    			// Save data
					$valueInput.val( JSON.stringify( savedData ) );
					$valueInput.trigger( 'change' );

	    		}

	    		// Refresh enviroment after add new items and on init
	    		var refresh = function() {

					// Init remove buttons
					$list.find( '.lsvr-customizer-control-sidebars__remove-button:not( .lsvr-customizer-control-sidebars__remove-button--init )' ).each(function() {
						$(this).on( 'click', function() {

							// Remove item
							$(this).closest( 'li' ).remove();
							update();

							// Hide list if there are no items
							if ( $list.find( '.lsvr-customizer-control-sidebars__item' ).length < 1 ) {
								$list.hide();
								$noSidebarsMessage.show();
							}

						});
						$(this).addClass( 'lsvr-customizer-control-sidebars__remove-button--init' );
					});

					// Add onchange event to new input
					$list.find( '.lsvr-customizer-control-sidebars__item-input:not( .lsvr-customizer-control-sidebars__item-input--init )' ).each(function() {
						$(this).on( 'change', function() {
							update();
						});
						$(this).addClass( 'lsvr-customizer-control-sidebars__item-input--init' );
					});

	    		}
	    		refresh();

				// Add new sidebar
				$addButton.on( 'click', function() {

					var html = '';
					lastId++;

					html += '<li class="lsvr-customizer-control-sidebars__item" data-sidebar-id="' + lastId + '">';
					html += '<input type="text" class="lsvr-customizer-control-sidebars__item-input" placeholder="' + inputPlaceholder.replace( '%d', lastId ) + '">';
					html += '<button type="button" class="lsvr-customizer-control-sidebars__remove-button"><i class="dashicons dashicons-no-alt"></i></button></li>';

					$list.append( html );

					if ( $list.is( ':hidden' ) ) {
						$list.show();
					}
					if ( $noSidebarsMessage.is( ':visible' ) ) {
						$noSidebarsMessage.hide();
					}

					// Refresh sortable list
					$list.sortable( 'refresh' );

					// Refresh enviroment
					refresh();

					// Update value input
					update();

				});

				// Make inputs sortable
				$list.sortable({
					update: function() {
						update();
					}
				});

	    	}
		});

	    /* ---------------------------------------------------------------------
	    	SLIDER
	    --------------------------------------------------------------------- */

	    $( '.lsvr-customizer-control-slider' ).each(function() {
	    	if ( $.fn.slider ) {

	    		var $this = $(this),
	    			$slider = $this.find( '.lsvr-customizer-control-slider__slider' ),
	    			$valueInput = $this.find( '.lsvr-customizer-control-slider__value' ),
	    			$sliderValue = $this.find( '.lsvr-customizer-control-slider__slider-value' ),
	    			min = $slider.data( 'min' ) ? $slider.data( 'min' ) : 0,
	    			max = $slider.data( 'max' ) ? $slider.data( 'max' ) : 100,
	    			step = $slider.data( 'step' ) ? $slider.data( 'step' ) : 1,
	    			value = $slider.data( 'value' ) ? $slider.data( 'value' ) : 1;

	    		// Init slider
	    		$slider.slider({
	    			min: min,
	    			max: max,
	    			step: step,
	    			value: value,
	    			range: 'min',
	    			slide: function( event, ui ) {
	    				$sliderValue.text( ui.value );
	    			},
	    			change: function( event, ui ) {
	    				$valueInput.val( ui.value );
	    				$valueInput.trigger( 'change' );
	    			}
    			});

	    	}
	    });

	    /* ---------------------------------------------------------------------
	    	SOCIAL LINKS
	    --------------------------------------------------------------------- */

	    $( '.lsvr-customizer-control-social-links' ).each(function() {
	    	if ( $.fn.sortable ) {

		    	var $this = $(this),
		    		$valueInput = $this.find( '.lsvr-customizer-control-social-links__value' ),
		    		$list = $this.find( '.lsvr-customizer-control-social-links__list' ),
		    		$listItems = $this.find( '.lsvr-customizer-control-social-links__item' );

	    		// Update the value input
	    		var update = function() {

	    			var linksData = {};

	    			// Loop through all list items and get URLs
					$list.find( '.lsvr-customizer-control-social-links__item' ).each(function() {

	    				var $urlInput = $(this).find( '.lsvr-customizer-control-social-links__item-input-url' ),
	    					$iconInput = $(this).find( '.lsvr-customizer-control-social-links__item-input-icon' ),
	    					$labelInput = $(this).find( '.lsvr-customizer-control-social-links__item-input-label' ),
	    					linkData = {},
	    					linkId;

						// Check required fields
						if ( $urlInput.data( 'id' ) && '' !== $urlInput.val() ) {

							// Get link ID
							linkId = $urlInput.data( 'id' );

							// Get URL
							linkData[ 'url' ] = $urlInput.val();

							// Get icon class
							if ( $iconInput.length > 0 && '' !== $iconInput.val() ) {
								linkData[ 'icon' ] = $iconInput.val();
							}

							// Get label
							if ( $labelInput.length > 0 && '' !== $labelInput.val() ) {
								linkData[ 'label' ] = $labelInput.val();
							}

							// Save link data to array with all links
							linksData[ linkId ] = linkData;

						}

	    			});

	    			// Convert data to JSON and insert them into value input
	    			var valueJSON = JSON.stringify( linksData );
	    			if ( '{}' !== valueJSON ) {
	    				$valueInput.val( valueJSON );
	    				$valueInput.trigger( 'change' );
	    			}

	    		};

	    		// Add change listener for all item inputs
	    		var timeout = false;
	    		$listItems.each(function() {
	    			$(this).find( '.lsvr-customizer-control-social-links__item-input-url, .lsvr-customizer-control-social-links__item-input-icon, .lsvr-customizer-control-social-links__item-input-label' )
						.each(function() {
							$(this).on( 'change paste keydown', function() {
								if ( false !== timeout ) {
									clearTimeout( timeout );
								}
		    					timeout = setTimeout( function() {
		    						update();
		    					}, 500 );
	    					});
						});
	    		});

				// Make inputs sortable
				$list.sortable({
					update: function() {
						update();
					}
				});

			}
    	});

	});
})(jQuery);