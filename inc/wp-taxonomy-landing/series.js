(function($) {
	$('input[name="header_style"]').on('click', function() {
		var $val = $(this).val();
		if ( $val == 'standard' ) {
			$('#header-html:visible').hide('fast');
		} else {
			$('#header-html:hidden').show('fast');
		}
	});

	$('input[name="cftl_layout"]').on('click', function() {
		var $val = $(this).val();
		$('#explainer').removeClass().addClass($val);
	});
})( jQuery );