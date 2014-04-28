/**
 * Called from inside the iframe
 */
function largoCustomizerPreviewSettings( settings ) {

	var sections = new Array();
	sections.push( 'largo_homepage' );

	// Show the sections that should appear on this view
	jQuery.each( sections, function( index, value ){

		if ( -1 == settings.hidden_sections.indexOf( value ) ) {
			jQuery('#accordion-section-'+value).slideDown('fast');
		} else {
			jQuery('#accordion-section-'+value).slideUp('fast');
		}

	});

}
