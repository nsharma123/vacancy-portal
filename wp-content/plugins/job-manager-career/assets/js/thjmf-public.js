var thjmf_public  = (function($, window, document) {
	'use strict';

	$(window).on('resize', function(){
		var popup = $('#thjmf_apply_now_popup');
		var popup_container = popup.find('.thjmf-popup-wrapper');
		var height = popup_container.height();
		var scroll_h = (height - 106 )+'px';
		popup.find('.thjmf-popup-outer-wrapper').css('height',scroll_h);
    });

    $("#thjmf_resume").change(function () {
        var fileExtension = ['pdf', 'doc', 'docx'];
        if( fileupload_change_event( $(this).val() ) ){
        	alert("Only these formats are allowed : "+fileExtension.join(', '));
        	$(this).val('');
        }
    });

    function fileupload_change_event( $ext ){
    	var fileExtension = ['pdf', 'doc', 'docx'];
        if ($.inArray($ext.split('.').pop().toLowerCase(), fileExtension) == -1) {
            return true;
        }
        return false;
    }
	
	function eventSavePopupForm(e, elm){
		var validation_msg = '';
		var form = $(elm).closest('form');
		var valid = validateApplyNowForm(form);
		if($.isArray(valid) && valid.length !== 0 && valid !== '' ){
			e.preventDefault();
			validation_msg = render_validation_msgs( valid );
			var form_notice = form.find('.thjmf-validation-notice');
			form_notice.html(validation_msg).focus();
		}
	}

	function render_validation_msgs( msgs ){
		var errors = '';
		$.each(msgs, function( index, el) {
			errors += '<p>'+el+'</p>';
		});
		return errors;
	}

	function validateApplyNowForm(form){
		var validation_arr = [];
		form.find('.thjmf-validation-error').removeClass('thjmf-validation-error');
		form.find('.thjmf-validation-required').each(function() {
			var field = $(this).find('input');
			var field_type = field.attr('type');
			if(field_type == null){
				field_type = field.is('select') ? 'select' : "";
			}
			var field_name = field.attr('name');
			var label = setValidationProps( field_name, field );

			switch(field_type){
				case 'text':
				default:
					if( field.val() == '' || field.val() == null ){
						validation_arr.push( label+' is a required field' );
					}else if( field_name == 'thjmf_email' && !isEmail( field.val() ) ){
						validation_arr.push( 'Invalid '+label );
					}
					break;
				case 'radio':
					if( form.find('input[name="'+field_name+'"]:checked').val() == null ){
						validation_arr.push( label+' is a required field' );
					}
					break;
				case 'file':
					if( fileupload_change_event( form.find('input[name="'+field_name+'"]').val() ) ){
						validation_arr.push( label+' is a required field' );
					}
					break;
			}
		});
		return validation_arr;
	}

	function setValidationProps( field_name, field ){
		var label = '';
		var label_elm = field.closest('.thjmf-form-field').find(' > label');
		if(label_elm.length){
			label = label_elm[0].childNodes[0].nodeValue;
			label = label !== '' ? label : str_replace('_', ' ', field_name);
			label = '<b>'+label+'</b>';
		}
		return label;
	}

	function eventApplyJob(elm){
		var popup = $('#thjmf_apply_now_popup');
		var popup_content = popup.find('.thjmf-popup-content');
		popup_content.find('.thjmf-validation-notice').html('');
		var popup_container = popup.find('.thjmf-popup-wrapper');
		popup.css({
			visibility: 'hidden',
			display: 'block',
		});
		var width = popup_container.width();		
		popup.css({
			visibility: '',
			display: '',
			left : '',
		});
		var n_h = '42px';
		var n_w = 'calc(50% - '+(width/2)+'px)';
		popup.find('.thjmf-popup-wrapper').css({
			'top'  : n_h, 
			'bottom'  : '12px', 
			'left' : n_w,
		});
		popup.addClass('thjmf-popup-active');
		var height = popup_container.height();
		var scroll_h = (height - 106 )+'px';
		popup.find('.thjmf-popup-outer-wrapper').css('height',scroll_h);
	}

	function eventClosePopup(elm){
		var popup = $('#thjmf_apply_now_popup');
		popup.removeClass('thjmf-popup-active');
		popup.find('.thjmf-validation-notice').html('');
	}

	function filterJobsEvent(elm){
		var form = $('#thjmf_job_filter_form');
		var all_blank = true;
		form.find('select').each(function(index, el) {
			if( $(this).val() != '' ){
				all_blank = false;
			}
		});
		if( all_blank){
			event.preventDefault();
			alert('No filter criteria selected');
		}
	}

	function isEmail(email) {
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		return regex.test(email);
	}
	
	return {
		eventApplyJob  : eventApplyJob,
		eventClosePopup : eventClosePopup,
		eventSavePopupForm : eventSavePopupForm,
		filterJobsEvent : filterJobsEvent,
   	};
}(window.jQuery, window, document));	

function thjmEventApplyJob(elm){
	thjmf_public.eventApplyJob(elm);		
}

function thjmEventClosePopup(elm){
	thjmf_public.eventClosePopup(elm);
}

function thjmEventSavePopupForm(e, elm){
	thjmf_public.eventSavePopupForm(e, elm);
}

function thjmfFilterJobsEvent(e){
	thjmf_public.filterJobsEvent(e);
}