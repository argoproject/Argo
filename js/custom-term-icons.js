jQuery( document ).ready( function( $ ) {
	var format = function( option ) {
		var el = $( option.element );
		return '<i class="' + el.data('css') + '"></i> ' + option.text;
	};

	$('#associated_icon').select2({
		formatResult: format,
    formatSelection: format,
    escapeMarkup: function(m) { return m; }
	});
});