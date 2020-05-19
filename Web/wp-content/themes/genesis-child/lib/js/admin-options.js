jQuery(document).ready(function($) {

	if($.browser.msie) {
		$('select').one('mousedown',function(){
			$(this).data('origWidth', $(this).css('width'));
		}).mousedown(function(){
			$(this).css('width','auto');
		}).change(function(){
			$(this).css('width',$(this).data('origWidth'));
		}).blur(function(){
			$(this).css('width',$(this).data('origWidth'));
		});
	}
	
	$('.dynamik-admin-header-iframe-toggle').click(function() {
		$('body').toggleClass('dynamik-admin-iframe-active');
		$('#dynamik-admin-header-container .dashicons-editor-expand').toggle();
		$('#dynamik-admin-header-container .dashicons-editor-contract').toggle();
		$('#dynamik-admin-header-container .dynamik-admin-header-iframe-device').toggle();
		$('#dynamik-admin-header-container .dashicons-image-rotate').toggle();
		$('#dynamik-admin-header-container .dashicons-admin-home').toggle();
		$('.ace_editor').width($('#dynamik-admin-footer').width());
		$('.ace_content').width($('#dynamik-admin-footer').width());
		setTimeout(function() {
			if($('body').hasClass('dynamik-admin-iframe-active')) {
				$('#dynamik-admin-iframe-container').html(dynamik_iframe).show();
			} else {
				$('#dynamik-admin-iframe-container').html('').hide();
			}
		}, 0);
	});
	
	$('#dynamik-admin-header-container .dashicons-admin-home').click(function() {
		window.location = dynamik_site_url;
	});
	
	$('#dynamik-admin-header-container .dashicons-image-rotate').click(function() {
		document.getElementById('dynamik-admin-iframe').contentWindow.location.reload();
	});
	
	$('.dynamik-admin-header-iframe-device').click(function() {
		var width = $(this).attr('title').split('x')[0];
		var height = $(this).attr('title').split('x')[1];
		if(width == '100') {
			$('#dynamik-admin-iframe').css('width', '100%').css('min-width', '1300px').css('height', '100%');
		} else {
			$('#dynamik-admin-iframe').css('width', width+'px').css('min-width', width+'px').css('height', height+'px');
		}
	});
	
	$(window).keydown(function(e) {
		if((e.ctrlKey || e.metaKey) && e.which == 83) {
			e.preventDefault();
			if($('body').hasClass('dynamik-active-skin-editnig-code')) {
				$('.dynamik-skin-custom-code-button-container input[type="submit"]').click();
			} else {
				$('.dynamik-save-button').click();
			}
			return false;
		}
		if((e.ctrlKey || e.metaKey) && e.which == 69) {
			if($('#dynamik-admin-heading-dashicons-container .dashicons-editor-expand').is(':visible')) {
				$('#dynamik-admin-heading-dashicons-container .dashicons-editor-expand').click();
			} else {
				$('#dynamik-admin-heading-dashicons-container .dashicons-editor-contract').click();
			}
			e.preventDefault();
			return false;
		}
		if(e.which == 27) {
			if($('#dynamik-admin-heading-dashicons-container .dashicons-editor-contract').is(':visible') && !$('body').hasClass('dynamik-active-skin-editnig-code')) {
				$('#dynamik-admin-heading-dashicons-container .dashicons-editor-contract').click();
			} else if($('body').hasClass('dynamik-active-skin-editnig-code')) {
				$('.dynamik-skin-code-editor-close').click();
			}
			e.preventDefault();
			return false;
		}
	});

	function default_text(selector) {
		var element = $(selector);
		var text = element.attr('title');
		if (element.val() == '') {
			element.val(text).addClass('default-text-active');
		}
		element.focus(function() {
			if (element.val() == text) {
				element.val('').removeClass('default-text-active');
			}
		}).blur(function() {
			if (element.val() == '') {
				element.val(text).addClass('default-text-active');
			}
		});/*.parents('form').submit(function() {
			$('.default-text').each(function() {
				if($(this).val() == this.title) {
					$(this).val('').removeClass('default-text-active');
				}
			});
		});*/
	}
	$('.default-text').each(function() {
		default_text('#'+$(this).attr('id'));
	});
	$('.wrap').on('click', '.dynamik-add-button', function () {
		$('.default-text').each(function() {
			default_text('#'+$(this).attr('id'));
		});		
	});
	
});