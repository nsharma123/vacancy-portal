/**
 * Table of contents
 *
 * 1. Components
 * 2. Header
 * 3. Core
 * 4. Widgets
 * 5. Elements
 * 6. Other
 * 7. Plugins
 */

(function($){ "use strict";
$(document).on( 'ready', function() {

/* -----------------------------------------------------------------------------

	1. COMPONENTS

----------------------------------------------------------------------------- */

	/* -------------------------------------------------------------------------
		GOOGLE MAP
	-------------------------------------------------------------------------- */

	if ( $.fn.lsvrTownpressGoogleMap ) {
		$( '.c-gmap' ).each(function() {
			$(this).lsvrTownpressGoogleMap();
		});
	}


/* -----------------------------------------------------------------------------

	2. HEADER

----------------------------------------------------------------------------- */

	/* -------------------------------------------------------------------------
		STICKY NAVBAR
	-------------------------------------------------------------------------- */

	$( '.header-navbar--sticky' ).each(function() {

		if ( $.fn.lsvrTownpressGetMediaQueryBreakpoint() > 991 ) {

			var $navbar = $(this),
				$placeholder = $( '.header-navbar__placeholder' ),
				navbarHeight = $navbar.outerHeight();

			$placeholder.css( 'height', navbarHeight );

		}

	});

	/* -------------------------------------------------------------------------
		HEADER MAP
	-------------------------------------------------------------------------- */

	$( '.header-map' ).each(function() {

		var $this = $(this),
			$canvas = $this.find( '.header-map__canvas' ),
			$close = $this.find( '.header-map__close' ),
			$toggle = $( '.header-map-toggle' ),
			$spinner = $this.find( '.c-spinner' ),
			mapType = $canvas.data( 'maptype' ) ? $canvas.data( 'maptype' ) : 'terrain',
			zoom = $canvas.data( 'zoom' ) ? $canvas.data( 'zoom' ) : 17,
			elementId = $canvas.attr( 'id' ),
			address = $canvas.data( 'address' ) ? $canvas.data( 'address' ) : false,
			latLong = $canvas.data( 'latlong' ) ? $canvas.data( 'latlong' ) : false,
			latitude = false, longitude = false, mapOptions, map;

		// Parse latitude and longitude
		if ( false !== latLong ) {
			var latLongArr = latLong.split( ',' );
			if ( latLongArr.length == 2 ) {
				latitude = latLongArr[0].trim();
				longitude = latLongArr[1].trim();
			}
		}

		// Toggle map
		$toggle.on( 'click', function() {

			$this.slideToggle( 200, function() {
				if ( $this.hasClass( 'header-map--loading' ) ) {
					loadMap();
				} else if ( $this.is( ':visible' ) ) {
					google.maps.event.trigger( map, 'resize' );
				}
				$toggle.toggleClass( 'header-map-toggle--active' );
			});

		});

		// Close map
		$close.on( 'click', function() {
			$this.slideUp( 200 );
			$toggle.removeClass( 'header-map-toggle--active' );
		});

		// Load map
		var loadMap = function() {

			// Load Google Maps API
			if ( $.fn.lsvrTownpressLoadGoogleMapsApi ) {
				$.fn.lsvrTownpressLoadGoogleMapsApi();
			}

			// Set basic API settings
			var apiSetup = function() {

				// Get map type
				switch ( mapType ) {
					case 'roadmap':
						mapType = google.maps.MapTypeId.ROADMAP;
						break;
					case 'satellite':
						mapType = google.maps.MapTypeId.SATELLITE;
						break;
					case 'hybrid':
						mapType = google.maps.MapTypeId.HYBRID;
						break;
					default:
						mapType = google.maps.MapTypeId.TERRAIN;
				}

				// Prepare map options
				mapOptions = {
					'zoom' : zoom,
					'mapTypeId' : mapType,
					'scrollwheel' : true,
				};

				// Set custom styles
				if ( 'undefined' !== typeof lsvr_townpress_google_maps_style_json ) {
					mapOptions.styles = JSON.parse( lsvr_townpress_google_maps_style_json );
				}
				else if ( 'undefined' !== typeof lsvr_townpress_google_maps_style ) {
					mapOptions.styles = lsvr_townpress_google_maps_style;
				}

				// Init the map object
				map = new google.maps.Map( document.getElementById( elementId ),
					mapOptions );
				$this.data( 'map', map );

				// If no latitude and longitude were obtained, geocode the address
				if ( ( false === latitude || false === longitude ) && false !== address ) {

					// We will need API key for geocoding
					var apiKey = typeof lsvr_townpress_google_api_key !== 'undefined' ? lsvr_townpress_google_api_key : false;
					if ( false !== apiKey ) {

						var encodedAddress = encodeURI( address );

	        			jQuery.ajax({
	            			type: 'post',
	            			dataType: 'JSON',
	            			url: 'https://maps.googleapis.com/maps/api/geocode/json?address=' + encodedAddress + '&key=' + apiKey,
	            			success: function( response ) {
 								map.setCenter( response.results[0].geometry.location );
			 					var marker = new google.maps.Marker({
			            			position: response.results[0].geometry.location,
			            			map: map
			        			});
 								$this.removeClass( 'header-map--loading' );
 								$spinner.hide();
	            			}
	            		});

					}

				}

				// If latitude and longitude were obtained, center the map
				else if ( false !== latitude && false !== longitude ) {
					var location = new google.maps.LatLng( latitude, longitude );
 					map.setCenter( location );
 					var marker = new google.maps.Marker({
            			position: location,
            			map: map
        			});
 					$this.removeClass( 'header-map--loading' );
 					$spinner.hide();
				}

				// Otherwise hide the map
				else {
					$this.hide();
				}

			};

			// Check if API is already loaded, if not, wait for trigger
			if ( 'object' === typeof google && 'object' === typeof google.maps ) {
				apiSetup();
			}
			else {
				$( document ).on( 'lsvrTownpressGoogleMapsApiLoaded', function() {
					apiSetup();
				});
			}

		}

	});

	/* -------------------------------------------------------------------------
		HEADER MENU
	------------------------------------------------------------------------- */

	$( '.header-menu__item--dropdown .header-menu__submenu--level-0, .header-menu__item--dropdown .header-menu__submenu--level-1, .header-menu__item--megamenu .header-menu__submenu--level-0' ).each(function() {

		var $submenu = $(this),
			$parent = $(this).parent(),
			$link = $parent.find( '> .header-menu__item-link' );

		// Add hover class
		$parent.hover( function() {
			$parent.addClass( 'header-menu__item--hover' );
			$submenu.show();
		}, function() {
			$parent.removeClass( 'header-menu__item--hover' );
			$submenu.hide();
		});

		$link.on( 'click touchstart', function() {
			if ( ! $parent.hasClass( 'header-menu__item--hover' ) ) {

				// Hide opened submenus
				if ( $submenu.parents( '.header-menu__submenu' ).length < 1 ) {
					$( '.header-menu__item--hover' ).each(function() {
						$(this).removeClass( 'header-menu__item--hover' );
						$(this).find( '> .header-menu__submenu' ).hide();
					});
				}

				// Show subemnu
				$parent.addClass( 'header-menu__item--hover' );
				$submenu.show();

				// Hide on click outside
				$( 'html' ).on( 'touchstart', function(e) {
					$parent.removeClass( 'header-menu__item--hover' );
					$submenu.hide();
				});

				// Disable link
				$parent.on( 'click touchstart', function(e) {
					e.stopPropagation();
				});
				return false;

			}
		});

	});

	/* -------------------------------------------------------------------------
		MOBILE TOOLBAR
	-------------------------------------------------------------------------- */

	// Toogle
	$( '.header-toolbar-toggle__menu-button' ).each(function() {
		$(this).on( 'click', function() {

			$( '.header-toolbar-toggle' ).toggleClass( 'header-toolbar-toggle--active' );
			$(this).toggleClass( 'header-toolbar-toggle__menu-button--active' );
			$( '.header-toolbar' ).slideToggle( 200 );

		});
	});

	// Mobile menu
	$( '.header-mobile-menu__toggle' ).each(function() {

		var $toggle = $(this),
			$parent = $toggle.parent(),
			$submenu = $parent.find( '> .header-mobile-menu__submenu' );

		$toggle.on( 'click', function() {
			$submenu.slideToggle( 200 );
			$toggle.toggleClass( 'header-mobile-menu__toggle--active' );
		});

	});

	// Reset all mobile changes on screen transition
	$(document).on( 'lsvrTownpressScreenTransition', function() {

		$( '.header-toolbar-toggle' ).removeClass( 'header-toolbar-toggle--active' );
		$( '.header-toolbar-toggle__menu-button' ).removeClass( 'header-toolbar-toggle__menu-button--active' );
		$( '.header-toolbar, .header-mobile-menu__submenu' ).removeAttr( 'style' );
		$( '.header-mobile-menu__toggle--active' ).removeClass( 'header-mobile-menu__toggle--active' );

	});

	/* -------------------------------------------------------------------------
		BACKGROUND SLIDESHOW
	-------------------------------------------------------------------------- */

	$( '.header-background--slideshow, .header-background--slideshow-home' ).each(function() {

		var $this = $(this),
			$images = $this.find( '.header-background__image' ),
			slideshowSpeed = $this.data( 'slideshow-speed' ) ? parseInt( $this.data( 'slideshow-speed' ) ) * 1000 : 10,
			animationSpeed = 2000;

		// Continue if there are at least two images
		if ( $images.length > 1 ) {

			// Set default active image
			$images.filter( '.header-background__image--default' ).addClass( 'header-background__image--active' );
			var $active = $images.filter( '.header-background__image--active' ),
				$next;

			// Change image to next one
			var changeImage = function() {

				// Determine next image
				if ( $active.next().length > 0 ) {
					$next = $active.next();
				}
				else {
					$next = $images.first();
				}

				// Hide active
				$active.fadeOut( animationSpeed, function() {
					$(this).removeClass( 'header-background__image--active'  );
				});

				// Show next
				$next.fadeIn( animationSpeed, function() {
					$(this).addClass( 'header-background__image--active' );
					$active = $(this);
				});

				// Repeat
				setTimeout( function() {
					changeImage();
				}, slideshowSpeed );

			};

			// Init
			if ( $.fn.lsvrTownpressGetMediaQueryBreakpoint() > 1199 ) {
				setTimeout( function() {
					changeImage();
				}, slideshowSpeed );
			}

		}

	});

/* -----------------------------------------------------------------------------

	3. CORE

----------------------------------------------------------------------------- */

	/* -------------------------------------------------------------------------
		GALLERIES
	------------------------------------------------------------------------- */

	// Gallery masonry
	if ( $.fn.masonry && $.fn.imagesLoaded ) {
		$( '.lsvr_gallery-post-archive .lsvr-grid--masonry, .lsvr_gallery-post-single .post__image-list' ).each(function() {

			var $this = $(this),
				isRTL = $( 'html' ).attr( 'dir' ) && 'rtl' === $( 'html' ).attr( 'dir' ) ? true : false;

			// Wait for images to load
			$this.imagesLoaded(function() {
				$this.masonry({
					isRTL: isRTL
				});
			});

		});
	}

	/* -------------------------------------------------------------------------
		DOCUMENTS
	------------------------------------------------------------------------- */

	// Categorized attachments
	$( '.lsvr_document-post-archive--categorized-attachments .post-tree__item--folder' ).each(function() {

		var $this = $(this),
			$holder = $this.find( '> .post-tree__item-link-holder' ),
			$children = $this.find( '> .post-tree__children' );

		// Add toggle
		if ( $children.length > 0 ) {
			$holder.append( '<button type="button" class="post-tree__item-toggle"></button>' );
		}
		var $toggle = $holder.find( '> .post-tree__item-toggle' );

		// Toggle click
		$toggle.on( 'click', function() {
			$(this).toggleClass( 'post-tree__item-toggle--active' );
			$children.slideToggle( 150 );
		});

	});


/* -----------------------------------------------------------------------------

	4. WIDGETS

----------------------------------------------------------------------------- */

	/* -------------------------------------------------------------------------
		MENU WIDGET
	------------------------------------------------------------------------- */

	// Desktop hover and touch
	if ( $.fn.lsvrTownpressGetMediaQueryBreakpoint() > 991 ) {
		$( '.lsvr-townpress-menu-widget__submenu--level-0, .lsvr-townpress-menu-widget__submenu--level-1' ).not( ':visible' ).each(function() {

			var $submenu = $(this),
				$parent = $(this).parent(),
				$link = $parent.find( '> .lsvr-townpress-menu-widget__item-link' );

			// Add hover class
			$parent.hover( function() {
				$parent.addClass( 'lsvr-townpress-menu-widget__item--hover' );
				$submenu.show();
			}, function() {
				$parent.removeClass( 'lsvr-townpress-menu-widget__item--hover' );
				$submenu.hide();
			});

			// Touch
			$link.on( 'click touchstart', function() {
				if ( ! $parent.hasClass( 'lsvr-townpress-menu-widget__item--hover' ) ) {

					// Hide opened submenus
					if ( $submenu.parents( '.lsvr-townpress-menu-widget__submenu' ).length < 1 ) {
						$( '.lsvr-townpress-menu-widget__item--hover' ).each(function() {
							$(this).removeClass( 'lsvr-townpress-menu-widget__item--hover' );
							$(this).find( '> .lsvr-townpress-menu-widget__submenu' ).hide();
						});
					}

					// Show subemnu
					$parent.addClass( 'lsvr-townpress-menu-widget__item--hover' );
					$submenu.show();

					// Hide on click outside
					$( 'html' ).on( 'touchstart', function(e) {
						$parent.removeClass( 'lsvr-townpress-menu-widget__item--hover' );
						$submenu.hide();
					});

					// Disable link
					$parent.on( 'click touchstart', function(e) {
						e.stopPropagation();
					});
					return false;

				}
			});

		});
	}

	// Mobile toggle
	$( '.lsvr-townpress-menu-widget--show-on-mobile .lsvr-townpress-menu-widget__submenu' ).not( ':visible' ).each(function() {

		var $submenu = $(this),
			$parent = $(this).parent(),
			$link = $parent.find( '> .lsvr-townpress-menu-widget__item-link' ),
			$toggle = $parent.find( '> .lsvr-townpress-menu-widget__toggle' );

		$toggle.on( 'click', function() {
			$toggle.toggleClass( 'lsvr-townpress-menu-widget__toggle--active' );
			$submenu.slideToggle( 200 );
		});

	});


/* -----------------------------------------------------------------------------

	5. ELEMENTS

----------------------------------------------------------------------------- */

	/* -------------------------------------------------------------------------
		POST SLIDER
	-------------------------------------------------------------------------- */

	if ( $.fn.owlCarousel ) {
		$( '.lsvr-townpress-post-slider' ).each( function() {

			var $this = $(this),
				$sliderInner = $this.find( '.lsvr-townpress-post-slider__inner' ),
				$slideList = $this.find( '.lsvr-townpress-post-slider__list' ),
				$slides = $this.find( '.lsvr-townpress-post-slider__post' ),
				$indicator = $this.find( '.lsvr-townpress-post-slider__indicator-inner' ),
				slideCount = $slides.length,
				autoplay = $this.data( 'autoplay' ) && parseInt( $this.data( 'autoplay' ) ) > 0 ? true : false,
				autoplayTimeout = $this.data( 'autoplay' ) && parseInt( $this.data( 'autoplay' ) ) > 0 ? parseInt( $this.data( 'autoplay' ) ) * 1000 : 0,
				rtl = $( 'html' ).attr( 'dir' ) && $( 'html' ).attr( 'dir' ) == 'rtl' ? true : false;

			if ( slideCount > 1 ) {

				// Init carousel
				$slideList.owlCarousel({
					rtl: rtl,
					autoHeight: true,
					loop: true,
					nav: true,
					navText: new Array( '<i class="lsvr-townpress-post-slider__indicator-icon lsvr-townpress-post-slider__indicator-icon--left icon-angle-left"></i>', '<i class="lsvr-townpress-post-slider__indicator-icon lsvr-townpress-post-slider__indicator-icon--right icon-angle-right"></i>' ),
					navRewind: true,
					dots: false,
					autoplay: autoplay,
					autoplayTimeout: autoplayTimeout,
					autoplayHoverPause: true,
					responsive:{
						0: {
							items: 1
						}
					},
					onTranslated: function() {

						// Refresh indicator
						if ( autoplay ) {
							$indicator.stop( 0, 0 );
						}
						if ( autoplay && $.fn.lsvrTownpressGetMediaQueryBreakpoint() > 991 ) {
							$indicator.css( 'width', 0 );
							if ( ! $this.hasClass( 'lsvr-townpress-post-slider--paused' ) ) {
								$indicator.stop( 0, 0 ).animate({ width : "100%" }, autoplayTimeout );
							}
						}

					}
				});

				// Autoplay indicator
				if ( true === autoplay ) {

					$this.addClass( 'lsvr-townpress-post-slider--has-indicator' );

					// Initial animation
					$indicator.animate({
						width : "100%"
					}, autoplayTimeout, 'linear' );

					// Pause
					var sliderPause = function() {
						$this.addClass( 'lsvr-townpress-post-slider--paused' );
						$indicator.stop( 0, 0 );
					};
					var sliderResume = function() {
						$this.removeClass( 'lsvr-townpress-post-slider--paused' );
						$indicator.stop( 0, 0 ).animate({
							width : "100%"
						}, autoplayTimeout, 'linear' );
					};

					$this.hover(function() {
						sliderPause();
					}, function() {
						sliderResume();
					});

					// Stop on smaller resolutions
					$( document ).on( 'lsvrTownpressScreenTransition', function() {
						if ( $.fn.lsvrTownpressGetMediaQueryBreakpoint() <= 991 ) {
							sliderPause();
						}
					});
					if ( $.fn.lsvrTownpressGetMediaQueryBreakpoint() <= 991 ) {
						sliderPause();
					}

				}

			}

		});
	}


/* -----------------------------------------------------------------------------

	6. OTHER

----------------------------------------------------------------------------- */

	/* -------------------------------------------------------------------------
		BACK TO TOP
	------------------------------------------------------------------------- */

	$( '.back-to-top__link' ).each(function() {

		$(this).on( 'click', function() {
			$( 'html, body' ).animate({ scrollTop: 0 }, 100 );
			return false;
		});

	});

	/* -------------------------------------------------------------------------
		MAGNIFIC POPUP
	------------------------------------------------------------------------- */

	if ( $.fn.magnificPopup ) {

		// Lightbox config
		if ( 'undefined' !== typeof lsvr_townpress_magnificpopup_config ) {
			var js_strings = lsvr_townpress_magnificpopup_config;
			$.extend( true, $.magnificPopup.defaults, {
				tClose: js_strings.mp_tClose,
				tLoading: js_strings.mp_tLoading,
				gallery: {
					tPrev: js_strings.mp_tPrev,
					tNext: js_strings.mp_tNext,
					tCounter: '%curr% / %total%'
				},
				image: {
					tError: js_strings.mp_image_tError,
				},
				ajax: {
					tError: js_strings.mp_ajax_tError,
				}
			});
		}

		// Init lightbox
		$( '.lsvr-open-in-lightbox, .gallery .gallery-item a, .wp-block-gallery .blocks-gallery-item a' ).magnificPopup({
			type: 'image',
			removalDelay: 300,
			mainClass: 'mfp-fade',
			gallery: {
				enabled: true
			}
		});

	}

});
})(jQuery);

(function($){ "use strict";

/* -----------------------------------------------------------------------------

	7. PLUGINS

----------------------------------------------------------------------------- */

	/* -------------------------------------------------------------------------
		MEDIA QUERY BREAKPOINT
	------------------------------------------------------------------------- */

	if ( ! $.fn.lsvrTownpressGetMediaQueryBreakpoint ) {
		$.fn.lsvrTownpressGetMediaQueryBreakpoint = function() {

			if ( $( '#lsvr-media-query-breakpoint' ).length < 1 ) {
				$( 'body' ).append( '<span id="lsvr-media-query-breakpoint" style="display: none;"></span>' );
			}
			var value = $( '#lsvr-media-query-breakpoint' ).css( 'font-family' );
			if ( typeof value !== 'undefined' ) {
				value = value.replace( "\"", "" ).replace( "\"", "" ).replace( "\'", "" ).replace( "\'", "" );
			}
			if ( isNaN( value ) ) {
				return $( window ).width();
			}
			else {
				return parseInt( value );
			}

		};
	}

	var lsvrTownpressMediaQueryBreakpoint;
	if ( $.fn.lsvrTownpressGetMediaQueryBreakpoint ) {
		lsvrTownpressMediaQueryBreakpoint = $.fn.lsvrTownpressGetMediaQueryBreakpoint();
		$(window).resize(function(){
			if ( $.fn.lsvrTownpressGetMediaQueryBreakpoint() !== lsvrTownpressMediaQueryBreakpoint ) {
				lsvrTownpressMediaQueryBreakpoint = $.fn.lsvrTownpressGetMediaQueryBreakpoint();
				$.event.trigger({
					type: 'lsvrTownpressScreenTransition',
					message: 'Screen transition completed.',
					time: new Date()
				});
			}
		});
	}
	else {
		lsvrTownpressMediaQueryBreakpoint = $(document).width();
	}

	/* -------------------------------------------------------------------------
		GOOGLE MAP
	-------------------------------------------------------------------------- */

	if ( ! $.fn.lsvrTownpressGoogleMap ) {
		$.fn.lsvrTownpressGoogleMap = function() {

			// Prepare params
			var $this = $(this).find( '.c-gmap__canvas' ),
				mapType = $this.data( 'maptype' ) ? $this.data( 'maptype' ) : 'terrain',
				zoom = $this.data( 'zoom' ) ? $this.data( 'zoom' ) : 17,
				enableMouseWheel = $this.data( 'mousewheel' ) && true === String( $this.data( 'mousewheel' ) ) ? true : false,
				elementId = $this.attr( 'id' ),
				address = $this.data( 'address' ) ? $this.data( 'address' ) : false,
				latLong = $this.data( 'latlong' ) ? $this.data( 'latlong' ) : false,
				latitude = false, longitude = false;

			// Parse latitude and longitude
			if ( false !== latLong ) {
				var latLongArr = latLong.split( ',' );
				if ( latLongArr.length == 2 ) {
					latitude = latLongArr[0].trim();
					longitude = latLongArr[1].trim();
				}
			}

			// Load Google Maps API
			if ( $.fn.lsvrTownpressLoadGoogleMapsApi ) {
				$.fn.lsvrTownpressLoadGoogleMapsApi();
			}

			// Set basic API settings
			var apiSetup = function() {

				// Get map type
				switch ( mapType ) {
					case 'roadmap':
						mapType = google.maps.MapTypeId.ROADMAP;
						break;
					case 'satellite':
						mapType = google.maps.MapTypeId.SATELLITE;
						break;
					case 'hybrid':
						mapType = google.maps.MapTypeId.HYBRID;
						break;
					default:
						mapType = google.maps.MapTypeId.TERRAIN;
				}

				// Prepare map options
				var mapOptions = {
					'zoom' : zoom,
					'mapTypeId' : mapType,
					'scrollwheel' : enableMouseWheel,
				};

				// Set custom styles
				if ( 'undefined' !== typeof lsvr_townpress_google_maps_style_json ) {
					mapOptions.styles = JSON.parse( lsvr_townpress_google_maps_style_json );
				}
				else if ( 'undefined' !== typeof lsvr_townpress_google_maps_style ) {
					mapOptions.styles = lsvr_townpress_google_maps_style;
				}

				// Init the map object
				var map = new google.maps.Map( document.getElementById( elementId ),
					mapOptions );
				$this.data( 'map', map );

				// If no latitude and longitude were obtained, geocode the address
				if ( ( false === latitude || false === longitude ) && false !== address ) {

					// We will need API key for geocoding
					var apiKey = typeof lsvr_townpress_google_api_key !== 'undefined' ? lsvr_townpress_google_api_key : false;
					if ( false !== apiKey ) {

						var encodedAddress = encodeURI( address );

	        			jQuery.ajax({
	            			type: 'post',
	            			dataType: 'JSON',
	            			url: 'https://maps.googleapis.com/maps/api/geocode/json?address=' + encodedAddress + '&key=' + apiKey,
	            			success: function( response ) {
 								map.setCenter( response.results[0].geometry.location );
			 					var marker = new google.maps.Marker({
			            			position: response.results[0].geometry.location,
			            			map: map
			        			});
 								$this.removeClass( 'c-gmap__canvas--loading' );
	            			}
	            		});

					}

				}

				// If latitude and longitude were obtained, center the map
				else if ( false !== latitude && false !== longitude ) {
					var location = new google.maps.LatLng( latitude, longitude );
 					map.setCenter( location );
 					var marker = new google.maps.Marker({
            			position: location,
            			map: map
        			});
 					$this.removeClass( 'c-gmap__canvas--loading' );
				}

				// Otherwise hide the map
				else {
					$this.hide();
				}

			};

			// Check if API is already loaded, if not, wait for trigger
			if ( 'object' === typeof google && 'object' === typeof google.maps ) {
				apiSetup();
			}
			else {
				$( document ).on( 'lsvrTownpressGoogleMapsApiLoaded', function() {
					apiSetup();
				});
			}

		};
	}

	/* -------------------------------------------------------------------------
		LOAD GOOGLE MAPS API
	-------------------------------------------------------------------------- */

	if ( ! $.fn.lsvrTownpressLoadGoogleMapsApi ) {
		$.fn.lsvrTownpressLoadGoogleMapsApi = function() {

			// Check if Google Maps API isn't already loaded
			if ( ! $( 'body' ).hasClass( 'lsvr-google-maps-api-loaded' ) ) {

				// Check if Google Maps API object doesn't already exists
				if ( 'object' === typeof google && 'object' === typeof google.maps ) {
					$.fn.lsvrTownpressGoogleMapsApiLoaded();
				}

				// If there is not existing instance of Google Maps API, let's create it
				else if ( ! $( 'body' ).hasClass( 'lsvr-google-maps-api-being-loaded' ) ) {

					$( 'body' ).addClass( 'lsvr-google-maps-api-being-loaded' );

					var script = document.createElement( 'script' ),
						apiKey = typeof lsvr_townpress_google_api_key !== 'undefined' ? lsvr_townpress_google_api_key : false,
						language = $( 'html' ).attr( 'lang' ) ? $( 'html' ).attr( 'lang' ) : 'en';

					// Parse language
					language = language.indexOf( '-' ) > 0 ? language.substring( 0, language.indexOf( '-' ) ) : language;

					// Append the script
					if ( apiKey !== false ) {
						script.type = 'text/javascript';
						script.src = 'https://maps.googleapis.com/maps/api/js?language=' + encodeURIComponent( language ) + '&key=' + encodeURIComponent( apiKey ) + '&callback=jQuery.fn.lsvrTownpressGoogleMapsApiLoaded';
						document.body.appendChild( script );
					}

				}

			}

		};
	}

	// Trigger event
	if ( ! $.fn.lsvrTownpressGoogleMapsApiLoaded ) {
		$.fn.lsvrTownpressGoogleMapsApiLoaded = function() {

			// Make sure that Google Maps API object does exist
			if ( 'object' === typeof google && 'object' === typeof google.maps ) {

				// Trigger the event
				$.event.trigger({
					type: 'lsvrTownpressGoogleMapsApiLoaded',
					message: 'Google Maps API is ready.',
					time: new Date()
				});

				// Add class to BODY element
				$( 'body' ).removeClass( 'lsvr-google-maps-api-being-loaded' );
				$( 'body' ).addClass( 'lsvr-google-maps-api-loaded' );

			}

		};
	}

})(jQuery);