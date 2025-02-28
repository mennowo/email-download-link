(function ($) {
	'use strict';
	
	function prepareFormPostData(form, formData) {
		jQuery.each((form.serializeArray() || {}), function (i, field) {
			formData['ed_' + field.name] = field.value;
		});
		return formData;
	}

	function loadResponse(response, form) {
		var status = response.status;

		var message_class = 'success';
		if(status === 'ERROR') {
			message_class = 'error';
		}
		
		if(status === 'ERRORBOT') {
			message_class = 'boterror';
		}

		var responseText = response['message_text'];
		var messageContainer = $(form).next('.ed_form_message');
		messageContainer.attr('class', 'ed_form_message ' + message_class);
		messageContainer.html(responseText);
		var esSuccessEvent = { 
			detail: { 
						ed_response : message_class, 
						msg: responseText
					}, 
			bubbles: true, 
			cancelable: true 
		};

		jQuery(form).trigger('ed_response', [ esSuccessEvent ]);
	}

	function submitDownlodLinkFun(form){
		var formData = {};
		formData = prepareFormPostData(form, formData);
		formData['ed_submit'] = 'submitted';
		formData['action'] = 'email_download_link';
		//alert(formData.toSource());
		var actionUrl = ed_data.ed_ajax_url;
		jQuery(form).find('#loading-image').show();
		$.ajax({
			type: 'POST',
			url: actionUrl,
			data: formData,
			dataType: 'json',
			success: function (response) {
				if( response && typeof response.status !== 'undefined' && (response.status === "SUCCESS" || response.status === "ERRORBOT") ) {
					jQuery(form).slideUp('slow');
					jQuery(form).hide();
				} else {
					jQuery(form).find('#loading-image').hide();
				}
				jQuery(window).trigger('ed_submit.send_response', [jQuery(form) , response]);
				loadResponse(response, form);
			},
			error: function (err) {
				//alert(err.toSource());
				//alert(JSON.stringify(err, null, 4));
				jQuery(form).find('#loading-image').hide();
				console.log(err, 'error');
			},
		});

		return false;
	}

	$(document).ready(function () {
		$(document).on('submit', '.ed_form', function (e) {
			e.preventDefault();
			var form = $(this);
			submitDownlodLinkFun(form);
		});

	});

})(jQuery);


