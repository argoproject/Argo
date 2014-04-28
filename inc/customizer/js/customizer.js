/**
 * Called from inside the iframe
 */
function largoCustomizerPreviewSettings( settings ) {

	var sections = [ 'largo_homepage', 'largo_footer_layout', 'largo_colors', 'largo_single_post' ];

	// Show the sections that should appear on this view
	jQuery.each( sections, function( index, value ){

		if ( -1 == settings.hidden_sections.indexOf( value ) ) {
			jQuery('#accordion-section-'+value).slideDown('fast');
		} else {
			jQuery('#accordion-section-'+value).slideUp('fast');
		}

	});

}

jQuery(document).ready( function( $ ){

	$( 'ul.customize-control-rich-radio input:checked' ).closest('li').show();

	$( '.customize-control-rich-radio-previous' ).on( 'click', function() {

		var li = $(this).closest( 'li' );
		li.hide();
		if ( li.prev().length ) {
			previous = li.prev();
		} else {
			previous = li.closest( 'ul' ).children().last();
		}
		previous.show();

	});

	$( '.customize-control-rich-radio-next' ).on( 'click', function() {

		var li = $(this).closest( 'li' );
		li.hide();
		if ( li.next().length ) {
			next = li.next();
		} else {
			next = li.closest( 'ul' ).children().first();
		}
		next.show();

	});

});
