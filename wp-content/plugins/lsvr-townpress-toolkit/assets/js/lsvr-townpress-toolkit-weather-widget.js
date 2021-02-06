(function($){ "use strict";

	// Actions to fire after all resources are loaded
	$(document).ready(function() {

		if ( $.fn.lsvrTownpressToolkitWeatherWidget ) {
			$( '.lsvr-townpress-weather-widget__weather' ).each(function() {
				$(this).lsvrTownpressToolkitWeatherWidget();
			});
		}

	});

	// Plugin
	if ( ! $.fn.lsvrTownpressToolkitWeatherWidget ) {
		$.fn.lsvrTownpressToolkitWeatherWidget = function() {

			var $this = $(this),
				$spinner = $this.find( '.lsvr-townpress-weather-widget__weather-spinner' ),
				ajaxParams = $this.data( 'ajax-params' ) ? $this.data( 'ajax-params' ) : false,
				forecastLength = $this.data( 'forecast-length' ) && ! isNaN( $this.data( 'forecast-length' ) ) ? parseInt( $this.data( 'forecast-length' ) ) : 0;

			// Ajax request
	        if ( false !== ajaxParams && 'undefined' !== typeof lsvr_townpress_toolkit_ajax_weather_widget_var ) {

	        	jQuery.ajax({
	            	type: 'post',
	            	dataType: 'JSON',
	            	url: lsvr_townpress_toolkit_ajax_weather_widget_var.url,
	            	data: {
	            		action: 'lsvr-townpress-toolkit-ajax-weather-widget',
	            		nonce: encodeURIComponent( lsvr_townpress_toolkit_ajax_weather_widget_var.nonce ),
	            		data: ajaxParams,
	            	},
	            	success: function( response ) {

						if ( typeof response === 'object' ) {

		            		if ( ! ( 'error' in response ) ) {

		            			var currentData = {},
		            				forecastData = [];

		            			// Parse current weather data
		            			if ( 'current' in response ) {

									// Save response location name
									if ( 'name' in response.current ) {
										$this.attr( 'data-response-current-location', response.current.name );
									}

									// Temperature
									if ( 'main' in response.current && 'temp' in response.current.main ) {
										currentData.temperature = String( Math.round( response.current.main.temp ) );
									}

									// Wind
									if ( 'wind' in response.current && 'speed' in response.current.wind ) {
										currentData.wind = Math.floor( response.current.wind.speed );
									}

									// Icon
									if ( 'weather' in response.current && $.isArray( response.current.weather ) &&
										'icon' in response.current.weather[0] ) {
										currentData.icon = response.current.weather[0].icon;
									}

		            			}

		            			// Parse forecast data
		            			if ( 'forecast' in response && 'list' in response.forecast ) {

									// Save response location name
									if ( 'city' in response.forecast && 'name' in response.forecast.city ) {
										$this.attr( 'data-response-forecast-location', response.forecast.city.name );
									}

									for ( var i = 0; i < forecastLength; i++ ) {

										var timestamp = $this.find( '.lsvr-townpress-weather-widget__weather-item--forecast-' + parseInt( i + 1 ) ).data( 'timestamp' ),
											forecastIndex = 0;

										// Find the correct index in JSON
										jQuery.each( response.forecast.list, function() {
											if ( 'dt' in this && parseInt( this.dt ) === timestamp ) {
												forecastIndex = response.forecast.list.indexOf( this );
												return false;
											}
										});

										forecastData[ i ] = {};
										var temp12 = -1000,
											temp15 = -1000,
											temp18 = -1000;

										// Temperature at 12:00
										if ( 'main' in response.forecast.list[ forecastIndex ] && 'temp' in response.forecast.list[ forecastIndex ].main ) {
											temp12 = parseInt( String( Math.round( response.forecast.list[ forecastIndex ].main.temp ) ) );
										}

										// Temperature at 15:00
										if ( 'main' in response.forecast.list[ forecastIndex + 1 ] && 'temp' in response.forecast.list[ forecastIndex + 1 ].main ) {
											temp15 = parseInt( String( Math.round( response.forecast.list[ forecastIndex + 1 ].main.temp ) ) );
										}

										// Temperature at 18:00
										if ( 'main' in response.forecast.list[ forecastIndex + 2 ] && 'temp' in response.forecast.list[ forecastIndex + 2 ].main ) {
											temp18 = parseInt( String( Math.round( response.forecast.list[ forecastIndex + 2 ].main.temp ) ) );
										}

										// Determine max temp
										var tempMax = Math.max( temp12, temp15, temp18 );
										if ( tempMax > -1000 ) {
											forecastData[ i ].temperature = tempMax;
										}

										// Wind
										if ( 'wind' in response.forecast.list[ forecastIndex ] && 'speed' in response.forecast.list[ forecastIndex ].wind ) {
											forecastData[ i ].wind = Math.floor( response.forecast.list[ forecastIndex ].wind.speed );
										}

										// Icon
										if ( 'weather' in response.forecast.list[ forecastIndex ] && $.isArray( response.forecast.list[ forecastIndex ].weather ) &&
											'icon' in response.forecast.list[ forecastIndex ].weather[0] ) {
											forecastData[ i ].icon = response.forecast.list[ forecastIndex ].weather[0].icon;
										}

									}

		            			}

		            			// Generate HTML
		            			generateHtml( currentData, forecastData );

		            		} else {
		            			$this.attr( 'data-response-error', response.error );
		            			$this.slideUp( 200 );
		            		}

	            		} else {
	            			$this.slideUp( 200 );
	            		}

	            	},
	            	error: function() {
	            		$this.slideUp( 200 );
	            	}
	            });

    		}

    		// Generate HTML
			var generateHtml = function( currentData, forecastData ) {

				var $list = $this.find( '.lsvr-townpress-weather-widget__weather-list' ),
					$current = $list.find( '.lsvr-townpress-weather-widget__weather-item--current' ),
					$forecastList = $list.find( '.lsvr-townpress-weather-widget__weather-item--forecast' ),
					iconClasses = { i01d: 'icon-sun', i01n: 'icon-sun', i02d: 'icon-cloud-sun', i02n: 'icon-cloud', i03d: 'icon-cloud', i03n: 'icon-cloud',
						i04d: 'icon-cloud', i04n: 'icon-cloud', i09d: 'icon-cloud-rain', i09n: 'icon-cloud-rain', i10d: 'icon-cloud-rain', i10n: 'icon-cloud-rain',
						i11d: 'icon-cloud-lightning', i11n: 'icon-cloud-lightning', i13d: 'icon-cloud-snow', i13n: 'icon-cloud-snow', i50d: 'icon-cloud-fog',
						i50n: 'icon-cloud-fog' };

				// Current weather
				if ( 'temperature' in currentData && 'wind' in currentData && 'icon' in currentData ) {

					// Set icon
					if ( 'i' + currentData.icon in iconClasses ) {
						$current.find( '.lsvr-townpress-weather-widget__weather-item-icon' ).addClass( iconClasses[ 'i' + currentData.icon ] );
					} else {
						$current.find( '.lsvr-townpress-weather-widget__weather-item-icon' ).hide();
					}

					// Set temperature
					var temperatureUnit = $current.find( '.lsvr-townpress-weather-widget__weather-item-temperature' ).text().trim();
					$current.find( '.lsvr-townpress-weather-widget__weather-item-temperature' ).html( currentData.temperature + temperatureUnit );

					// Set wind
					var windUnit = $current.find( '.lsvr-townpress-weather-widget__weather-item-wind' ).text().trim();
					$current.find( '.lsvr-townpress-weather-widget__weather-item-wind' ).html( currentData.wind + windUnit );

				}

				// Forecast
				if ( forecastData.length > 0 ) {
					for ( var i = 0; i < forecastData.length; i++ ) {
						if ( 'temperature' in forecastData[ i ] && 'wind' in forecastData[ i ] && 'icon' in forecastData[ i ] ) {

							var $forecast = $forecastList.filter( '.lsvr-townpress-weather-widget__weather-item--forecast-' + parseInt( i + 1 ) );

							// Set icon
							if ( 'i' + forecastData[ i ].icon in iconClasses ) {
								$forecast.find( '.lsvr-townpress-weather-widget__weather-item-icon' ).addClass( iconClasses[ 'i' + forecastData[ i ].icon ] );
							} else {
								$forecast.find( '.lsvr-townpress-weather-widget__weather-item-icon' ).hide();
							}

							// Set temperature
							var temperatureUnit = $forecast.find( '.lsvr-townpress-weather-widget__weather-item-temperature' ).text().trim();
							$forecast.find( '.lsvr-townpress-weather-widget__weather-item-temperature' ).html( forecastData[ i ].temperature + temperatureUnit );

							// Set wind
							var windUnit = $forecast.find( '.lsvr-townpress-weather-widget__weather-item-wind' ).text().trim();
							$forecast.find( '.lsvr-townpress-weather-widget__weather-item-wind' ).html( forecastData[ i ].wind + windUnit );

						} else {
							$forecastList.filter( '.lsvr-townpress-weather-widget__weather-item--forecast-' + parseInt( i + 1 ) ).hide();
						}
					}
				}

				$spinner.slideUp( 200 );
				$list.slideDown( 200 );
				$this.removeClass( 'lsvr-townpress-weather-widget__weather--loading' );

			};

		};
	}

})(jQuery);