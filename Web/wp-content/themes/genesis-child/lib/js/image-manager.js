jQuery(document).ready(function($) {
	
	$('.dynamik-image-info-button').click(function() {
		var active_li = $(this).closest('li');
		
		active_li.find('.dynamik-listed-image-inner').toggleClass('dynamik-faded dynamik-not-faded');
		active_li.find('.dynamik-listed-image-info-inner').toggleClass('dynamik-faded dynamik-not-faded');
		active_li.find('.dynamik-listed-image-inner.dynamik-faded').toggle();
		active_li.find('.dynamik-listed-image-inner.dynamik-not-faded').fadeToggle();
		active_li.find('.dynamik-listed-image-info-inner.dynamik-faded').toggle();
		active_li.find('.dynamik-listed-image-info-inner.dynamik-not-faded').fadeToggle();
	});
	
	$('.dynamik-image-rename-button').click(function() {
		var answer = confirm ('Are you sure you want to rename this image?');
		if(answer) {
			$('#dynamik-image-file-control-form li').removeAttr('id');
			$(this).closest('li').attr('id', 'dynamik-child-theme-images-list-rename');
			$('#dynamik-image-file-control-form').submit();
		}
	});
	
	$('.dynamik-image-delete-button').click(function() {
		var answer = confirm ('Are you sure you want to delete this image?');
		if(answer) {
			$('#dynamik-image-file-control-form li').removeAttr('id');
			$(this).closest('li').attr('id', 'dynamik-child-theme-images-list-delete');
			$('#dynamik-image-file-control-form').submit();
		}
	});
	
	$('.dynamik-image-delete-all-button').click(function() {
		var answer = confirm ('Are you sure you want to delete ALL Child Theme images?');
		if(answer) {
			$('#dynamik-image-file-control-form li').removeAttr('id');
			$('.dynamik-image-delete-all-button-container').attr('id', 'dynamik-child-theme-images-list-delete-all');
			$('#dynamik-image-file-control-form').submit();
		}
	});
	
	function show_message(response, theme_type) {
		$('#dynamik-image-file-control-form #dynamik-child-theme-images-list-rename .dynamik-ajax-save-spinner').hide();
		$('#dynamik-image-file-control-form #dynamik-child-theme-images-list-rename .dynamik-saved').html(response).fadeIn('slow');
		$('#dynamik-image-file-control-form #dynamik-child-theme-images-list-delete .dynamik-ajax-save-spinner').hide();
		$('#dynamik-image-file-control-form #dynamik-child-theme-images-list-delete .dynamik-saved').html(response).fadeIn('slow');
		$('#dynamik-image-file-control-form #dynamik-child-theme-images-list-delete-all .dynamik-ajax-save-spinner').hide();
		$('#dynamik-image-file-control-form #dynamik-child-theme-images-list-delete-all .dynamik-saved').html(response).fadeIn('slow');
		window.setTimeout(function() {
			$('#dynamik-image-file-control-form .dynamik-saved').fadeOut('slow');
			if(response.substring(0, 5) != 'Error') {
				location.reload();
			}
		}, 2222);
	}
	
	$('#dynamik-image-file-control-form').on('submit', function() {
		$('#dynamik-image-file-control-form #dynamik-child-theme-images-list-rename .dynamik-ajax-save-spinner').show();
		$('#dynamik-image-file-control-form #dynamik-child-theme-images-list-delete .dynamik-ajax-save-spinner').show();
		$('#dynamik-image-file-control-form #dynamik-child-theme-images-list-delete-all .dynamik-ajax-save-spinner').show();
		
		if($('#dynamik-child-theme-images-list-rename').length != 0) {
			var action_type = 'rename';
			var name = $('#dynamik-child-theme-images-list-rename .dynamik-listed-image-name').attr('title');
			var new_name = $('#dynamik-child-theme-images-list-rename .dynamik-listed-image-name').val();
		} else if($('#dynamik-child-theme-images-list-delete').length != 0) {
			var action_type = 'delete';
			var name = $('#dynamik-child-theme-images-list-delete .dynamik-listed-image-name').attr('title');
			var new_name = '';
		} else if($('#dynamik-child-theme-images-list-delete-all').length != 0) {
			var action_type = 'delete_all';
			var name = '';
			var new_name = '';
		}
		var data = $(this).serialize()+'&action_type='+action_type+'&name='+name+'&new_name='+new_name;
		jQuery.post(ajaxurl, data, function(response) {
			if(response) {
				show_message(response);
			}
		});
		
		return false;
	});
	
});