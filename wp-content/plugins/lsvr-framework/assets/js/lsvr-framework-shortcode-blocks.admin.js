( function( wp ) {

	var	el = wp.element.createElement,
		registerBlockType = wp.blocks.registerBlockType,
		InspectorControls = wp.editor.InspectorControls,
		MediaUpload = wp.editor.MediaUpload;

    // Change event
    function onChangeEvent( props, name ) {
    	this.name = name;
    	var parent = this;
    	this.onChange = function( newVal ) {
    		props.setAttributes( { [parent.name] : newVal } );
    	};
    }

    // MediaUpload  event
    function mediaUploadEvent( props, name, label, description ) {

    	this.name = name;
    	var parent = this,
    		label = label,
    		description = description;

		// Render
    	this.render = function( open ) {

    		var imageEl, removeButtonEl;

			var openModal = function() {
				open.open();
			};

			var removeImage = function() {
				props.setAttributes( { [parent.name] : '' } );
			}

			// Description element
			var descriptionEl = description !== '' ? el( 'p', { className: 'components-base-control__help' }, description ) : '';

			// Image element
			if ( typeof props.attributes[ parent.name ] !== 'undefined' && props.attributes[ parent.name ] !== '' ) {
				imageEl = el( 'p', { className: 'lsvr-control-mediaupload__image' },
					el( 'img', { src: props.attributes[ parent.name ] } )
				);
				removeButtonEl = el( 'button', { className: 'lsvr-control-mediaupload__button-remove components-button is-button is-default is-large', onClick: removeImage },
					el( 'i', { className: 'dashicons dashicons-trash' }, '' )
				);
			} else {
				imageEl = '';
				removeButtonEl = '';
			}

			// HTML
			return el( 'div', { className: 'components-base-control' },
				el( 'div', { className: 'components-base-control__field' },
					el( 'label', { className: 'components-base-control__label' }, label )
				),
				imageEl,
				el( 'button', { className: 'lsvr-control-mediaupload__button-add components-button is-button is-default is-large', onClick: openModal },
					el( 'i', { className: 'dashicons dashicons-upload' }, '' )
				),
				removeButtonEl,
				descriptionEl
			);

    	}

		// On select
    	this.onSelect = function( args ) {
    		props.setAttributes( { [parent.name] : args.url } );
    	}

    }

    // Create controls
    function createControls( props, atts ) {

    	var controls = [],
    		component,
    		controlArgs,
    		onChangeEvents = [],
    		mediaUploadEvents = [];

		// Loop all attributes
    	for ( var i = 0; i < atts.length; i++ ) {

    		// Basic control args
    		controlArgs = {};
    		controlArgs.label = atts[ i ].label;
    		controlArgs.help = typeof atts[ i ].description !== 'undefined' ? atts[ i ].description : '';
    		onChangeEvents[ i ] = new onChangeEvent( props, atts[ i ].name );
    		controlArgs.onChange = onChangeEvents[ i ].onChange;

    		// Select control args
    		if ( 'select' === atts[ i ].type ) {
    			component = wp.components.SelectControl;
    			controlArgs.value = props.attributes[ atts[ i ].name ];
    			controlArgs.options = atts[ i ].choices;
    		}

    		// Radio control args
    		else if ( 'radio' === atts[ i ].type ) {
    			component = wp.components.RadioControl;
    			controlArgs.selected = props.attributes[ atts[ i ].name ];
    			controlArgs.options = atts[ i ].choices;
    		}

    		// Checkbox control args
    		else if ( 'checkbox' === atts[ i ].type ) {
    			component = wp.components.CheckboxControl;
    			controlArgs.checked = props.attributes[ atts[ i ].name ];
    		}

    		// Textarea control args
    		else if ( 'textarea' === atts[ i ].type ) {
    			component = wp.components.TextareaControl;
    			controlArgs.value = props.attributes[ atts[ i ].name ];
    		}

    		// Image
    		else if ( 'image' === atts[ i ].type ) {
    			component = MediaUpload;
    			controlArgs.allowedTypes = [ 'image' ];
    			controlArgs.multiple = false;
    			mediaUploadEvents[ i ] = new mediaUploadEvent( props, atts[ i ].name, atts[ i ].label, atts[ i ].description );
    			controlArgs.render = mediaUploadEvents[ i ].render;
    			controlArgs.onSelect = mediaUploadEvents[ i ].onSelect;
    		}

    		// Text control args
    		else {
    			component = wp.components.TextControl;
    			controlArgs.value = props.attributes[ atts[ i ].name ];
    		}

    		// Add control
        	controls.push( el(
				component,
				controlArgs
			));

    	}

    	return controls;

    }

    // Hash attributes
	function hashAttributes( attributes ) {

		var attributesString = JSON.stringify( attributes ),
			hash = 0, i, chr;

		if ( attributesString.length === 0 ) return hash;
	  	for ( i = 0; i < attributesString.length; i++ ) {
	    	chr = attributesString.charCodeAt( i );
	    	hash = ( ( hash << 5 ) - hash ) + chr;
	    	hash |= 0; // Convert to 32bit integer
	  	}
	  	return hash;

	}

	// Retrieve HTML via ajax
	var shortcodeAjaxRequest = null;
	function makeAjaxRequest( props, tag, newAttsHash ) {

		var blockId = props.name.replace( '/', '-' ) + '-' + props.clientId,

		// Make call
        shortcodeAjaxRequest = jQuery.ajax({
            type: 'post',
            url: lsvr_framework_shortcode_blocks_ajax_var.url,
            data: 'action=lsvr-framework-shortcode-blocks-ajax&nonce=' + lsvr_framework_shortcode_blocks_ajax_var.nonce + '&tag=' + tag + '&' + jQuery.param( props.attributes ),
            success: function( response ) {

            	// Display new HTML
            	$( '#' + blockId ).find( '.lsvr-shortcode-block-view__html' ).html( response );

            	// Disable loading animation
            	$( '#' + blockId ).removeClass( 'lsvr-shortcode-block-view--loading' );

            	// Save new attributes
            	$( '#' + blockId ).attr( 'data-lsvr-shortcode-block-attributes-hash', newAttsHash );

            	// Trigger an event
				$.event.trigger({
					type: 'lsvrShortcodeBlockLoaded',
					message: 'Block was loaded.',
					time: new Date()
				});

            },
            error: function() {
				window.console.log( 'Ajax Response: ERROR' );
            }
        });

	}

	// Generate dynamic editor view
    function generateDynamicEditorView( props, tag, refresh ) {

    	var blockId = props.name.replace( '/', '-' ) + '-' + props.clientId,
    		currentHtml = $( '#' + blockId ).find( '.lsvr-shortcode-block-view__html' ).html(),
    		currentAttsHash = $( '#' + blockId ).attr( 'data-lsvr-shortcode-block-attributes-hash' ),
    		wrapperClassPostfix = '';

		// Check if there is an existing HTML
		currentHtml = typeof currentHtml !== 'undefined' ? currentHtml : '';

		// Check the current attributes
		currentAttsHash = typeof currentAttsHash !== 'undefined' ? currentAttsHash : 0;

		// Check if ajax call can be made
		if ( '' === currentHtml || true === refresh ) {

			// Hash new attributes
			newAttsHash = hashAttributes( props.attributes );

			// Proceed only if the new attribtues are different compared to existing ones
    		if ( Math.floor( currentAttsHash ) !== Math.floor( newAttsHash ) ) {

    			// Enable loading animation
    			wrapperClassPostfix = 'lsvr-shortcode-block-view--loading';

    			// Make an initial ajax request without timeout
    			if ( '' === currentHtml && false === refresh ) {
    				makeAjaxRequest( props, tag, newAttsHash );
    			}

    			// Make an ajax request with timeout
    			else {

					// Do ajax request after a delay
	    			clearTimeout( $( 'body' ).data( 'lsvr-shortcode-blocks-ajax-timer' ) );
	    			$( 'body' ).data( 'lsvr-shortcode-blocks-ajax-timer', setTimeout( function() {

	    				// Enable loading animation
		            	$( '#' + blockId ).addClass( 'lsvr-shortcode-block-view--loading' );

		            	// Make ajax request
		            	makeAjaxRequest( props, tag, newAttsHash );

	    			}, 500 ));

    			}

			}

    	}

    	// Display block
    	return el( 'div', { className: 'lsvr-shortcode-block-view ' + wrapperClassPostfix, id: blockId,
    		'data-lsvr-shortcode-block-attributes-hash': currentAttsHash },
			el( 'i', { className: 'lsvr-shortcode-block-view__spinner' }, '' ),
			el( 'div', { className: 'lsvr-shortcode-block-view__html' },
				el( wp.element.RawHTML, null, currentHtml )
			)
		);

    }

	// Generate static editor view
    function generateStaticEditorView( props, atts, title, icon ) {

    	return el( 'div', { className: 'lsvr-shortcode-block-view lsvr-shortcode-block-view--static', },
			el( 'h4', { className: 'lsvr-shortcode-block-view__title' },
				el ( 'i', { className: 'lsvr-shortcode-block-view__title-icon dashicons dashicons-' + icon }, '' ),
				title
			),
		);

    }

    // Generate shortcode tag
    function generateShortcodeTag( props, atts, tag ) {

    	var shortcodeAtts = '';

    	// Custom attributes
    	for ( var i = 0; i < atts.length; i++ ) {
    		if ( typeof props.attributes[ atts[ i ].name ] !== 'undefined' ) {
				shortcodeAtts += ' ' + atts[ i ].name + '="' + props.attributes[ atts[ i ].name ] + '"';
			}
    	}

    	return '[' + tag + shortcodeAtts + ']';

    }

    // Register dynamic block
	function registerDynamicShortcodeBlock( args ) {

		// Prepare attributes
		this.attributes = {};
		for ( var i = 0; i < args.attributes.length; i++ ) {

			// Type
			this.attributes[ args.attributes[ i ].name ] = {
				type: 'checkbox' === args.attributes[ i ].type ? 'bool' : 'string',
			};

			// Default value
			if ( typeof args.attributes[ i ].default !== 'undefined' ) {
				this.attributes[ args.attributes[ i ].name ].default = args.attributes[ i ].default;
			}

		}

		// Register block
		registerBlockType( args.name, {

			title: args.title,
			description: typeof args.description !== 'undefined' ? args.description : '',
			category: typeof args.category !== 'undefined' ? args.category : 'common',
			icon: typeof args.icon !== 'undefined' ? args.icon : '',
			attributes: this.attributes,

			edit: function( props ) {

				var isSelected = props.isSelected;

	            if ( isSelected ) {

	            	return [
	            		el(
		        			InspectorControls,
		        			{ key: 'inspector' },
							el(
								wp.components.PanelBody,
								{
									title: args.panel_title,
								},
								createControls( props, args.attributes ),
							),
		    			),
						generateDynamicEditorView( props, args.tag, true ),
	    			];

	            } else {
	            	return generateDynamicEditorView( props, args.tag, false );
	            }

			},

			save: function( props ) {
	        	return null;
			},

		});

	}

    // Register static block
	function registerStaticShortcodeBlock( args ) {

		// Prepare attributes
		this.attributes = {};
		for ( var i = 0; i < args.attributes.length; i++ ) {

			// Type
			this.attributes[ args.attributes[ i ].name ] = {
				type: 'checkbox' === args.attributes[ i ].type ? 'bool' : 'string',
			};

			// Default value
			if ( typeof args.attributes[ i ].default !== 'undefined' ) {
				this.attributes[ args.attributes[ i ].name ].default = args.attributes[ i ].default;
			}

		}

		// Register block
		registerBlockType( args.name, {

			title: args.title,
			description: typeof args.description !== 'undefined' ? args.description : '',
			category: typeof args.category !== 'undefined' ? args.category : 'common',
			icon: typeof args.icon !== 'undefined' ? args.icon : '',
			attributes: this.attributes,

			edit: function( props ) {

				var isSelected = props.isSelected;

	            if ( isSelected ) {

	            	return [
	            		el(
		        			InspectorControls,
		        			{ key: 'inspector' },
							el(
								wp.components.PanelBody,
								{
									title: args.panel_title,
								},
								createControls( props, args.attributes ),
							),
		    			),
						generateStaticEditorView( props, args.attributes, args.title, args.icon ),
	    			];

	            } else {
	            	return generateStaticEditorView( props, args.attributes, args.title, args.icon );
	            }

			},

			save: function( props ) {
				return null;
			},

		});

	}

	// Register dynamic blocks from JSON
	if ( typeof lsvrDynamicShortcodeBlocks !== 'undefined' ) {

		// Register dynamic shortcode blocks
		for ( var i = 0; i < lsvrDynamicShortcodeBlocks.length; i++ ) {
			new registerDynamicShortcodeBlock( lsvrDynamicShortcodeBlocks[ i ] );
		}
	}

	// Register static blocks from JSON
	if ( typeof lsvrStaticShortcodeBlocks !== 'undefined' ) {

		// Register dynamic shortcode blocks
		for ( var i = 0; i < lsvrStaticShortcodeBlocks.length; i++ ) {
			new registerStaticShortcodeBlock( lsvrStaticShortcodeBlocks[ i ] );
		}
	}

} )(
	window.wp
);