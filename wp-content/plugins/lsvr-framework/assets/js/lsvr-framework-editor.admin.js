(function($){ "use strict";

/* -----------------------------------------------------------------------------

	INIT

----------------------------------------------------------------------------- */

	$(document).ready(function() {

	    /* ---------------------------------------------------------------------
	    	METABOX DEPENDENCY
	    --------------------------------------------------------------------- */

	    $( '.lsvr-post-metabox[data-page-template]' ).each(function() {

	    	var $this = $(this),
	    		metaboxId = $this.data( 'metabox-id' ),
	    		templates = $this.data( 'page-template' ),
	    		$holder = $this.parents( '#' + metaboxId ),
	    		$templateSelectbox = $( '#page_template' );

    		if ( $templateSelectbox.length > 0 && templates !== '' ) {

    		// Parse templates
    		templates = templates.split( ',' );

    			var templateChange = function() {
		    		if ( templates.indexOf( $templateSelectbox.val() ) > -1 ) {
		    			$holder.show();
		    			$holder.find( '.lsvr-post-metafield__value' ).each(function(){
		    				$(this).prop( 'disabled', false );
		    			});
		    		} else {

		    			$holder.hide();

		    			// Disable all hidden value inputs so they won't be saved
		    			$holder.find( '.lsvr-post-metafield__value' ).each(function(){
		    				$(this).prop( 'disabled', true );
		    			});

		    		}
    			};
    			templateChange();

	    		// Refresh on template change
	    		$templateSelectbox.on( 'change', function() {
	    			templateChange();
	    		});

	    	}

	    });

	    /* ---------------------------------------------------------------------
	    	METAFIELDS DEPENDENCY
	    --------------------------------------------------------------------- */

		$( '.lsvr-post-metafield[data-required]' ).each(function() {

			var $this = $(this),
				requiredData = $this.data( 'required' ),
				json,
				metaboxId = $this.parents( '.lsvr-post-metabox' ).data( 'metabox-id' );

			// Parse json
			try {
				json = JSON.parse( requiredData );
			} catch (e) {
				json = requiredData;
			}

			// Get required input ID
			var requiredInputId = json.id + '_input',
				$requiredInput = $( 'input[name="' + requiredInputId + '"]' ),
				requiredInputVal,
				requiredValue = 'boolean' === typeof( json.value ) ? json.value.toString() : json.value,
				operator = json.hasOwnProperty( 'operator' ) ? json.operator : '==';

			// Compare by operator
			var compareValues = {
				'==' : function( inputVal, requiredVal ) {

					// If array
					if ( 'object' == typeof( requiredVal ) ) {

						for ( var k in requiredVal ) {
    						if ( inputVal === requiredVal[ k ] ) {
        						return true;
    						}
						}
						return false;

					}

					// Else
					else {
						return inputVal == requiredVal;
					}

				},
				'!==' : function( inputVal, requiredVal ) { return inputVal !== requiredVal },
			};

			// Check if required condition is met and then show/hide this field
			var checkRequiredField = function() {

				// Get input value
				if ( 'radio' === $requiredInput.attr( 'type' ) ) {
					requiredInputVal = $requiredInput.filter( ':checked' ).val();
				} else {
					requiredInputVal = $requiredInput.val();
				}

				// Compare input value and required value
				if ( compareValues[ operator ]( requiredInputVal, requiredValue ) ) {
					$this.slideDown( 150 );
				} else {
					$this.slideUp( 150 );
				}

			};

			// Listen for input change event
			$requiredInput.each(function() {

				// Check after page load
				checkRequiredField();

				// Check after value change
				$(this).on( 'change', function() {
					checkRequiredField();
				});

			});

		});

	    /* ---------------------------------------------------------------------
	    	INIT METAFIELDS
	    --------------------------------------------------------------------- */

	    // Attachment
		if (  $.fn.lsvrPostMetafieldAttachment ) {
			$( '.lsvr-post-metafield-attachment' ).each(function() {
				$(this).lsvrPostMetafieldAttachment();
			});
		}

    	// Date
    	if (  $.fn.lsvrPostMetafieldDate ) {
    		$( '.lsvr-post-metafield-date' ).each(function() {
    			$(this).lsvrPostMetafieldDate();
    		});
		}

    	// Datetime
    	if (  $.fn.lsvrPostMetafieldDatetime ) {
    		$( '.lsvr-post-metafield-datetime' ).each(function() {
    			$(this).lsvrPostMetafieldDatetime();
    		});
		}

    	// External Attachment
    	if (  $.fn.lsvrPostMetafieldExternalAttachment ) {
    		$( '.lsvr-post-metafield-ext-attachment' ).each(function() {
    			$(this).lsvrPostMetafieldExternalAttachment();
    		});
		}

	    // Gallery
		if (  $.fn.lsvrPostMetafieldGallery ) {
			$( '.lsvr-post-metafield-gallery' ).each(function() {
				$(this).lsvrPostMetafieldGallery();
			});
		}

		// Checkbox
		if ( $.fn.lsvrPostMetafieldCheckbox ) {
			$( '.lsvr-post-metafield-checkbox' ).each(function() {
				$(this).lsvrPostMetafieldCheckbox();
		    });
		}

		// Opening Hours
		if ( $.fn.lsvrPostMetafieldOpeningHours ) {
			$( '.lsvr-post-metafield-opening-hours' ).each(function() {
				$(this).lsvrPostMetafieldOpeningHours();
		    });
		}

		// Slider
		if ( $.fn.lsvrPostMetafieldSlider ) {
			$( '.lsvr-post-metafield-slider' ).each(function() {
				$(this).lsvrPostMetafieldSlider();
		    });
		}

		// Switch
		if ( $.fn.lsvrPostMetafieldSwitch ) {
			$( '.lsvr-post-metafield-switch' ).each(function() {
				$(this).lsvrPostMetafieldSwitch();
		    });
		}

		// Taxonomy
		if ( $.fn.lsvrPostMetafieldTaxonomy ) {
			$( '.lsvr-post-metafield-taxonomy' ).each(function() {
				$(this).lsvrPostMetafieldTaxonomy();
		    });
		}

	});

})(jQuery);

(function($){ "use strict";

/* -----------------------------------------------------------------------------

	METAFIELDS

----------------------------------------------------------------------------- */

	/* -------------------------------------------------------------------------
		ATTACHMENT
	------------------------------------------------------------------------- */

	if ( ! $.fn.lsvrPostMetafieldAttachment ) {
		$.fn.lsvrPostMetafieldAttachment = function() {

			var $this = $(this),
				$valueInput = $this.find( '.lsvr-post-metafield-attachment__value' ),
				$selectBtn = $this.find( '.lsvr-post-metafield-attachment__btn-select' ),
				$itemListWrapper = $this.find( '.lsvr-post-metafield-attachment__item-list-wrapper' ),
				$itemList = $this.find( '.lsvr-post-metafield-attachment__item-list' ),
				titleLabel = $this.data( 'title-label' ) ? $this.data( 'title-label' ) : '',
				allowMultiple = true === $this.data( 'allow-multiple' ) ? true : false,
				mediaTypeArr = $this.data( 'media-type' ) ? $this.data( 'media-type' ).split() : false,
				mediaType = {},
				mediaModal;

			// Convert array of allowed media types to object
			if ( false !== mediaTypeArr ) {
				for ( var i = 0; i < mediaTypeArr.length; i++ ) {
					mediaType[ i ] = mediaTypeArr[ i ];
				}
			}

			// Parse all current attachments and update value input with their IDs
			var refreshAttachments = function() {

				// Array with all item IDs
				var attachmentIds = new Array();

				// Parse all items and push IDs to array
				$itemList.find( '.lsvr-post-metafield-attachment__item' ).each(function() {
					if ( $(this).attr( 'data-attachment-id' ) ) {
						attachmentIds.push( $(this).attr( 'data-attachment-id' ) );
					}
				});

				// Save new order to value input
				if ( attachmentIds.length > 0 ) {
					$valueInput.val( attachmentIds.join( ',' ) );
				} else {
					$valueInput.val( '' );
				}

  				// Show list with currently selected media if needed
  				if ( $itemListWrapper.is( ':hidden' ) || $itemList.children().length > 0 ) {
  					$itemListWrapper.slideDown( 150 );
  				} else {
  					$itemListWrapper.slideUp( 150 );
  				}

			};

			// Make attachments sortable
			if ( $.fn.sortable ) {
				$itemList.sortable({
					update: function() {
						refreshAttachments();
					}
				});
			}

			// Init item remove buttons
			var initRemoveButtons = function() {
				$this.find( '.lsvr-post-metafield-attachment__btn-remove' ).each(function() {
					$(this).off( 'click' );
					$(this).on( 'click', function() {

						// Remove element from DOM
						$(this).parents( '.lsvr-post-metafield-attachment__item' ).remove();

						// Refresh attachments
						refreshAttachments();

					});
				});
			}
			initRemoveButtons();

			// Open modal on button click
			$selectBtn.on( 'click', function() {

				// If the media modal already exists, reopen it
				if ( mediaModal ) {
      				mediaModal.open();
      				return;
				}

				// Create a new media modal
				mediaModal = wp.media({
					title: titleLabel,
					multiple: true,
					library: mediaType,
				});

				// Make current;y selected images pre-selected in modal
				mediaModal.on( 'open', function() {

					// Create array with currently selected
					var currentSelectionArr = '' !== $valueInput.val() ? $valueInput.val().split( ',' ) : false;

					// Check if there are any selected images
					if ( false !== currentSelectionArr ) {

						var selection = mediaModal.state().get( 'selection' );
						$.each( currentSelectionArr, function( index, id ) {
							var attachment = wp.media.attachment( id );
							attachment.fetch();
							selection.add( attachment );
						});

					}

				});

				// Select action
				mediaModal.on( 'select', function() {

					// Get media attachment details from the modal state
      				var attachments = mediaModal.state().get( 'selection' ).toJSON();

      				// Array with attachment IDs
      				var attachmentIds = new Array();

      				// Hide all currently selected attachments
      				$itemList.empty();

      				// Parse selected attachments
      				$.each( attachments, function( index, attachment ) {

						// Save media IDs into array
						attachmentIds.push( attachment.id );

						// Display selected attachments
						var html = '<li class="lsvr-post-metafield-attachment__item" data-attachment-id="' + attachment.id + '">';
						html += '<div class="lsvr-post-metafield-attachment__item-inner">';
						html += attachment.filename;

						// Add remove button
						html += '<button class="lsvr-post-metafield-attachment__btn-remove" type="button"><i class="dashicons dashicons-no-alt"></i></button>';
						html += '</div></li>';

						// Append HTML
						$itemList.append( html );

						// Init remove buttons
						initRemoveButtons();

	      				// Refresh attachment list
						refreshAttachments();

      				});

      				// Save list of attachment IDs into value input
					$valueInput.val( attachmentIds.join( ',' ) );

				});

				// Open media modal
				mediaModal.open();

			});

		};
	}

	/* -------------------------------------------------------------------------
		DATE
	------------------------------------------------------------------------- */

	if ( ! $.fn.lsvrPostMetafieldDate ) {
		$.fn.lsvrPostMetafieldDate = function() {
			if ( $.fn.datepicker ) {

				var $this = $(this),
				$valueInput = $this.find( '.lsvr-post-metafield-date__value' );

				// Show datepicker
				 $valueInput.datepicker({
					dateFormat: 'yy-mm-dd',
					minDate: 0,
					beforeShow: function() {
						$( '#ui-datepicker-div' ).addClass( 'lsvr-post-metafield__datepicker' );
					},
				});

				$valueInput.parent().on( 'click', function() {
					$valueInput.datepicker( 'show' );
				});

			}
		}
	}

	/* -------------------------------------------------------------------------
		DATETIME
	------------------------------------------------------------------------- */

	if ( ! $.fn.lsvrPostMetafieldDatetime ) {
		$.fn.lsvrPostMetafieldDatetime = function() {
			if ( $.fn.datepicker ) {

				var $this = $(this),
					$valueInput = $this.find( '.lsvr-post-metafield-datetime__value' ),
					$dateInput = $this.find( '.lsvr-post-metafield-datetime__input-date' ),
					$hourInput = $this.find( '.lsvr-post-metafield-datetime__input-hour' ),
					$minuteInput = $this.find( '.lsvr-post-metafield-datetime__input-minute' );

				// Show datepicker
				 $dateInput.datepicker({
					dateFormat: 'yy-mm-dd',
					minDate: 0,
					beforeShow: function() {
						$( '#ui-datepicker-div' ).addClass( 'lsvr-post-metafield__datepicker' );
					},
				});

				$dateInput.parent().on( 'click', function() {
					$dateInput.datepicker( 'show' );
				});

				// Combine date and time values to single value
				$dateInput.on( 'change', function() {
					$getFuldate();
				});
				$hourInput.on( 'change', function() {
					$getFuldate();
				});
				$minuteInput.on( 'change', function() {
					$getFuldate();
				});
				var $getFuldate = function() {
					if ( $dateInput.val() !== '' ) {

						// Save date and time
						if ( $hourInput.val() !== '' && $minuteInput.val() !== '' ) {
							$valueInput.val( $dateInput.val() + ' ' + $hourInput.val() + ':' + $minuteInput.val() );
						}
						// Save date only
						else {
							$valueInput.val( $dateInput.val() );
						}

					} else {
						$valueInput.val( '' );
					}
				}

			}
		};
	}

	/* -------------------------------------------------------------------------
		EXTERNAL ATTACHMENT
	------------------------------------------------------------------------- */

	if ( ! $.fn.lsvrPostMetafieldExternalAttachment ) {
		$.fn.lsvrPostMetafieldExternalAttachment = function() {

			var $this = $(this),
				$valueInput = $this.find( '.lsvr-post-metafield-ext-attachment__value' ),
				$urlInput = $this.find( '.lsvr-post-metafield-ext-attachment__url-input' ),
				$addBtn = $this.find( '.lsvr-post-metafield-ext-attachment__btn-add' ),
				$itemListWrapper = $this.find( '.lsvr-post-metafield-ext-attachment__item-list-wrapper' ),
				$itemList = $this.find( '.lsvr-post-metafield-ext-attachment__item-list' );

			// Parse all current attachments and update value input
			var refreshAttachments = function() {

				// Array with all item URLs
				var attachmentURLs = new Array();

				// Parse all items and push IDs to array
				$itemList.find( '.lsvr-post-metafield-ext-attachment__item' ).each(function() {
					if ( $(this).attr( 'data-encoded-url' ) ) {
						attachmentURLs.push( $(this).attr( 'data-encoded-url' ) );
					}
				});

				// Save new order to value input
				if ( attachmentURLs.length > 0 ) {
					$valueInput.val( attachmentURLs.join( '|' ) );
				} else {
					$valueInput.val( '' );
				}

  				// Show list with currently selected media if needed
  				if ( $itemListWrapper.is( ':hidden' ) || $itemList.children().length > 0 ) {
  					$itemListWrapper.slideDown( 150 );
  				} else {
  					$itemListWrapper.slideUp( 150 );
  				}

			};

			// Init item remove buttons
			var initRemoveButtons = function() {
				$this.find( '.lsvr-post-metafield-ext-attachment__btn-remove' ).each(function() {
					$(this).off( 'click' );
					$(this).on( 'click', function() {

						// Remove element from DOM
						$(this).parents( '.lsvr-post-metafield-ext-attachment__item' ).remove();

						// Refresh attachments
						refreshAttachments();

					});
				});
			}
			initRemoveButtons();

			// Make attachments sortable
			if ( $.fn.sortable ) {
				$itemList.sortable({
					update: function() {
						refreshAttachments();
					}
				});
			}

			// Add new attachment on click
			$addBtn.on( 'click', function() {

				// Check if the input is not blank
				if ( '' !== $urlInput.val() ) {

					// Sanitize URL
					$this.append( '<span class="lsvr-sanitize-url" style="display: none;">' + $urlInput.val() + '</span>' );
					var escapedURL = $this.find( '.lsvr-sanitize-url' ).text();
					$this.find( '.lsvr-sanitize-url' ).remove();
					if ( '' !== escapedURL ) {

						// Display new attachments
						var html = '<li class="lsvr-post-metafield-ext-attachment__item" data-encoded-url="' + encodeURI( escapedURL ) + '">';
						html += '<div class="lsvr-post-metafield-ext-attachment__item-inner">';
						html += escapedURL;

						// Add remove button
						html += '<button class="lsvr-post-metafield-ext-attachment__btn-remove" type="button"><i class="dashicons dashicons-no-alt"></i></button>';
						html += '</div></li>';

						// Append HTML
						$itemList.append( html );

						// Reset input
						$urlInput.val( '' );

						// Init remove buttons
						initRemoveButtons();

	      				// Refresh attachment list
						refreshAttachments();

					}

				}

			});

		};
	}

	/* -------------------------------------------------------------------------
		GALLERY
	------------------------------------------------------------------------- */

	if ( ! $.fn.lsvrPostMetafieldGallery ) {
		$.fn.lsvrPostMetafieldGallery = function() {

			var $this = $(this),
				$valueInput = $this.find( '.lsvr-post-metafield-gallery__value' ),
				$selectBtn = $this.find( '.lsvr-post-metafield-gallery__btn-select' ),
				$itemListWrapper = $this.find( '.lsvr-post-metafield-gallery__item-list-wrapper' ),
				$itemList = $this.find( '.lsvr-post-metafield-gallery__item-list' ),
				titleLabel = $this.data( 'title-label' ) ? $this.data( 'title-label' ) : '',
				mediaModal;

			// Parse all current attachments and update value input with their IDs
			var refreshAttachments = function() {

				// Array with all item IDs
				var attachmentIds = new Array();

				// Parse all items and push IDs to array
				$itemList.find( '.lsvr-post-metafield-gallery__item' ).each(function() {
					if ( $(this).attr( 'data-attachment-id' ) ) {
						attachmentIds.push( $(this).attr( 'data-attachment-id' ) );
					}
				});

				// Save new order to value input
				if ( attachmentIds.length > 0 ) {
					$valueInput.val( attachmentIds.join( ',' ) );
				} else {
					$valueInput.val( '' );
				}

  				// Show list with currently selected media if needed
  				if ( $itemListWrapper.is( ':hidden' ) || $itemList.children().length > 0 ) {
  					$itemListWrapper.slideDown( 150 );
  				} else {
  					$itemListWrapper.slideUp( 150 );
  				}

			};

			// Make attachments sortable
			if ( $.fn.sortable ) {
				$itemList.sortable({
					update: function() {
						refreshAttachments();
					}
				});
			}

			// Init item remove buttons
			var initRemoveButtons = function() {
				$this.find( '.lsvr-post-metafield-gallery__btn-remove' ).each(function() {
					$(this).off( 'click' );
					$(this).on( 'click', function() {

						// Remove element from DOM
						$(this).parents( '.lsvr-post-metafield-gallery__item' ).remove();

						// Refresh attachments
						refreshAttachments();

					});
				});
			}
			initRemoveButtons();

			// Open modal on button click
			$selectBtn.on( 'click', function() {

				// If the media modal already exists, reopen it
				if ( mediaModal ) {
      				mediaModal.open();
      				return;
				}

				// Create a new media modal
				mediaModal = wp.media({
					title: titleLabel,
					multiple: true,
					library: [ 'image' ],
				});

				// Make current;y selected images pre-selected in modal
				mediaModal.on( 'open', function() {

					// Create array with currently selected
					var currentSelectionArr = '' !== $valueInput.val() ? $valueInput.val().split( ',' ) : false;

					// Check if there are any selected images
					if ( false !== currentSelectionArr ) {

						var selection = mediaModal.state().get( 'selection' );
						$.each( currentSelectionArr, function( index, id ) {
							var attachment = wp.media.attachment( id );
							attachment.fetch();
							selection.add( attachment );
						});

					}

				});

				// Select action
				mediaModal.on( 'select', function() {

					// Get media attachment details from the modal state
      				var attachments = mediaModal.state().get( 'selection' ).toJSON();

      				// Array with attachment IDs
      				var attachmentIds = new Array();

      				// Hide all currently selected attachments
      				$itemList.empty();

      				// Parse selected attachments
      				$.each( attachments, function( index, attachment ) {

						// Save media IDs into array
						attachmentIds.push( attachment.id );

						// Display selected attachments
						var html = '<li class="lsvr-post-metafield-gallery__item" data-attachment-id="' + attachment.id + '">';
						html += '<div class="lsvr-post-metafield-gallery__item-inner">';
						html += '<img class="lsvr-post-metafield-gallery__image lsvr-post-metafield-gallery__image--thumb" src="' + attachment.sizes.thumbnail.url + '" alt="">';

						// Add remove button
						html += '<button class="lsvr-post-metafield-gallery__btn-remove" type="button"><i class="dashicons dashicons-no-alt"></i></button>';
						html += '</div></li>';

						// Append HTML
						$itemList.append( html );

						// Init remove buttons
						initRemoveButtons();

	      				// Refresh attachment list
						refreshAttachments();

      				});

      				// Save list of attachment IDs into value input
					$valueInput.val( attachmentIds.join( ',' ) );

				});

				// Open media modal
				mediaModal.open();

			});

		};
	}

	/* -------------------------------------------------------------------------
		CHECKBOX
	------------------------------------------------------------------------- */

	if ( ! $.fn.lsvrPostMetafieldCheckbox ) {
		$.fn.lsvrPostMetafieldCheckbox = function() {

			var $this = $(this),
				$valueInput = $this.find( '.lsvr-post-metafield-checkbox__value' ),
				$checkboxes = $this.find( 'input[type=checkbox]' );

			$checkboxes.each(function() {
				$(this).on( 'change', function() {
					var value = $checkboxes.filter( ':checked' ).map(function() {
						return this.value;
					}).get();
					$valueInput.val( value.join() );
				});
			});

		};
	}

	/* -------------------------------------------------------------------------
		OPENING HOURS
	------------------------------------------------------------------------- */

	if ( ! $.fn.lsvrPostMetafieldOpeningHours ) {
		$.fn.lsvrPostMetafieldOpeningHours = function() {

			var $this = $(this),
				$valueInput = $this.find( '.lsvr-post-metafield-opening-hours__value' );

			// Parse all fields and save values into value input
			var update = function() {

				var valueArr = {};

				// Loop all rows
				$this.find( '.lsvr-post-metafield-opening-hours__row' ).each(function() {

					var $row = $(this),
						$closed = $row.find( '.lsvr-post-metafield-opening-hours__checkbox-closed' ),
						day = $row.data( 'day' ),
						hourFrom, minuteFrom,
						hourTo, minuteTo;

					// Check if hours are closed
					if ( $closed.length > 0 && $closed.is( ':checked' ) ) {
						valueArr[ day ] = 'closed';
					}

					// If hours are not closed get time from and time to
					else {

						// Get time from
						hourFrom = $row.find( '.lsvr-post-metafield-opening-hours__hour-from' ).val();
						minuteFrom = $row.find( '.lsvr-post-metafield-opening-hours__minute-from' ).val();

						// Get time to
						hourTo = $row.find( '.lsvr-post-metafield-opening-hours__hour-to' ).val();
						minuteTo = $row.find( '.lsvr-post-metafield-opening-hours__minute-to' ).val();

						// Push valeus to array
						valueArr[ day ] = hourFrom + ':' + minuteFrom + '-' + hourTo + ':' + minuteTo;
					}

				});

				// Save array to value
				$valueInput.val( JSON.stringify( valueArr ) );

			};

			// Update the value when on fields change
			$this.find( 'select, input[type="checkbox"]' ).each(function() {
				$(this).on( 'change', function() {
					update();
				});
			});

			// Toggle disabled status for selectboxes on "closed" checkbox change
			$this.find( 'input[type="checkbox"]' ).each(function() {

				var $checkbox = $(this);

				$checkbox.on( 'change', function() {

					// Parse all selectboxes in row and change their status
					$checkbox.parents( '.lsvr-post-metafield-opening-hours__row' ).first().find( 'select' ).each(function() {
						if ( $checkbox.is( ':checked' ) ) {
							$(this).prop( 'disabled', 'disabled' );
						} else {
							$(this).prop( 'disabled', false );
						}
					});

				});

			});

		};
	}

	/* -------------------------------------------------------------------------
		SLIDER
	------------------------------------------------------------------------- */

	if ( ! $.fn.lsvrPostMetafieldSlider ) {
		$.fn.lsvrPostMetafieldSlider = function() {
	    	if ( $.fn.slider ) {

	    		var $this = $(this),
	    			$slider = $this.find( '.lsvr-post-metafield-slider__slider' ),
	    			$valueInput = $this.find( '.lsvr-post-metafield-slider__value' ),
	    			$sliderValue = $this.find( '.lsvr-post-metafield-slider__slider-value' ),
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
	    			slide: function( event, ui ) {
	    				$sliderValue.text( ui.value );
	    			},
	    			change: function( event, ui ) {
	    				$valueInput.val( ui.value );
	    				$valueInput.trigger( 'change' );
	    			}
    			});

			}
		};
	}

	/* -------------------------------------------------------------------------
		SWITCH
	------------------------------------------------------------------------- */

	if ( ! $.fn.lsvrPostMetafieldSwitch ) {
		$.fn.lsvrPostMetafieldSwitch = function() {

			var $this = $(this),
				$valueInput = $this.find( '.lsvr-post-metafield-switch__value' ),
				$checkbox = $this.find( 'input[type=checkbox]' );

			$checkbox.on( 'change', function() {

				if ( $(this).is( ':checked' ) ) {
					$valueInput.val( 'true' );
				} else {
					$valueInput.val( 'false' );
				}
				$valueInput.trigger( 'change' );

			});

		};
	}

	/* -------------------------------------------------------------------------
		TAXONOMY
	------------------------------------------------------------------------- */

	if ( ! $.fn.lsvrPostMetafieldTaxonomy ) {
		$.fn.lsvrPostMetafieldTaxonomy = function() {

			var $this = $(this),
				$valueInput = $this.find( '.lsvr-post-metafield-taxonomy__value' ),
				$termSelect = $this.find( '.lsvr-post-metafield-taxonomy__select' ),
				taxonomySlug = $this.find( '.lsvr-post-metafield-taxonomy__slug' ).val();

			$termSelect.on( 'change', function() {

				if ( $(this).val() !== 'false' ) {
					$valueInput.val( taxonomySlug + ',' + $(this).val() );
				} else {
					$valueInput.val( taxonomySlug + ',false' );
				}

			});

		};
	}

})(jQuery);