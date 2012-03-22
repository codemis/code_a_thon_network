$(document).ready(function() {
	/**
	 * Setup the sign div options effects 
	 */
	$('a.show_sign_in_option').click(function() {
		var rel = $(this).attr('rel');
		$('div#sign_in_options_wrapper').fadeOut('slow', function() {
			$(this).children('div').hide();
			$('#'+rel).show();
			$(this).fadeIn('slow');
		});
		return false;
	});
});
