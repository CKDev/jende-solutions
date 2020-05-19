jQuery(document).ready(function($) {

	var site_header = $('.site-header');
	/* Set a site_header var and then test to make sure the .site-header element actually exists on the page.
	* If it does then go ahead and execute the rest of the script. This prevents JS errors on pages where
	* the default header element is not present, such as when a page builder takes over the header HTML.
	*/
	if (site_header.length) {

		/* Function that adds a 'dynamik-fixed-header' body class when the browser/device width is greater than a specified width
		* and removes the 'dynamik-fixed-header' body class when it's that width or less. This "disables" the fixed design
		* for smaller browser/devices sizes to allow for greater vertical space in such viewing situations.
		* This is basically the JS version of CSS's @media query, for responsive design scenarios.
		*/
		$(window).resize(function() {
			if (window.outerWidth > dynamik_fixed_header_min_width) {
				$('body').addClass('dynamik-fixed-header');
			} else {
				$('body').removeClass('dynamik-fixed-header');
			}
		});
		
		/* Trigger the above .resize function to ensure the proper body class
		* is in place based on the browser/device width.
		*/
		$(window).resize();
		
		var adminbar_height = $('#wpadminbar').outerHeight();
		var header_top_pos = $('.site-header').offset().top;
		var header_height = $('.site-header').outerHeight();

		/* Add/remove a 'dynamik-scrolled' body class based on the scroll position of the web page
		* to properly enable/disable the fixed elements at the appropriate time.
		*/
		$(function() {
			var scrolled = false;
			$(window).scroll(function() {
				// Add or remove the 'dynamik-scrolled' body class based on scroll position, among other tweaks.
				if ($(this).scrollTop() > (header_top_pos + header_height - adminbar_height) && $('body').hasClass('dynamik-fixed-header')) {
					$('body').addClass('dynamik-scrolled').css('padding-top', header_height);
					$('.site-header').addClass('dynamik-fixed-site-header');
					if (scrolled == false && dynamik_fixed_header_fade) {
						$('.site-header').hide().fadeIn(200);
					}
					scrolled = true;
				} else {
					$('body').removeClass('dynamik-scrolled').css('padding-top', '');
					$('.site-header').removeClass('dynamik-fixed-site-header');
					scrolled = false;
				}
			});
		});

	}

});