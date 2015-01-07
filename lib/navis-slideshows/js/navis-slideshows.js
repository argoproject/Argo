function navisloadSlideshow( postID, permalink, totalSlides ) {
    var startSlide = 1;
    var startHash = "#1";
    var slideContainerDiv = '#slides-' + postID;
    var slidePermalinkElement = slideContainerDiv + ' a.slide-permalink';
    var currentSlide;

    jQuery( slidePermalinkElement ).attr( "href", permalink + startHash );

    // Get slide number if it exists
    if ( window.location.hash ) {
        fragment = window.location.hash.replace( "#","" );
        slideNum = parseInt( fragment );

        if ( ! isNaN( slideNum ) ) {
            startSlide = slideNum;
            ensureImageIsLoaded( postID, slideNum );

            ensureImageIsLoaded( postID,
                getNextSlideNum( slideNum, totalSlides )
            );
            ensureImageIsLoaded( postID,
                getPrevSlideNum( slideNum, totalSlides )
            );

            jQuery( slidePermalinkElement ).attr( "href", permalink + "#" + startSlide );
        }
    }


    jQuery( slideContainerDiv ).slidesjs({
        pagination: {
            active: true,
            effect: "fade"
        },
        effect: {
            fade: {
                speed: 300,
                crossfade: true
            }
          },
        navigation: {
            effect: "fade"
        },
        start: startSlide,
        callback: {

            loaded: function( current ) {

                var el = jQuery( 'div[slidesjs-index='+current+']');
                var height = el.height();
                el.parent().css('height',height);
                el.parent().parent().css('height', height);

            },

            start: function( current ) {

                var el = jQuery( 'div[slidesjs-index='+current+']');
                var height = el.height();
                el.parent().css('height',height);
                el.parent().parent().css('height', height);

            },

            complete: function( current ) {

                // Set the slide number as a hash
                currentSlide = current;
                var curSlide = "#" + current;

                ensureImageIsLoaded( postID, current );
                ensureImageIsLoaded(
                    postID, getNextSlideNum( current, totalSlides )
                );
                jQuery( slidePermalinkElement ).attr(
                    "href", permalink + curSlide
                );
            }
        }
    });

    // Pre-load the next and previous images when the user jumps to a
    // specific slide
    jQuery( ".pagination a" ).on( 'click', '.navis-slideshow', function( evt ) {
        var slideNum = parseInt( jQuery(this).text() );
        ensureImageIsLoaded( postID, slideNum );
        ensureImageIsLoaded( postID, getNextSlideNum( slideNum, totalSlides ) );
        ensureImageIsLoaded( postID, getPrevSlideNum( slideNum, totalSlides ) );
    });

    // Ensure the previous image is loaded when the user goes back
    jQuery( ".slide-nav .prev" ).on( 'click', '.navis-slideshow', function( evt ) {
        ensureImageIsLoaded(
            postID, getPrevSlideNum( currentSlide, totalSlides )
        );
    });

    // Ensure the previous image is loaded when the user goes back
    jQuery( ".slide-nav .next" ).on( 'click', '.navis-slideshow', function( evt ) {
        ensureImageIsLoaded(
            postID, getNextSlideNum( currentSlide, totalSlides )
        );
    });
}


function getSlideElement( postID, slideNum ) {
    return postID + '-slide' + slideNum;
}


function getNextSlideNum( current, count ) {
    return ( current + 1 > count ) ? 1 : current + 1;
}


function getPrevSlideNum( current, count ) {
    return ( current == 1 ) ? count : current - 1;
}


function ensureImageIsLoaded( postID, slideNum ) {

    var slideDiv = jQuery( "#" + getSlideElement( postID, slideNum ) );

    // Do nothing if the slide image already exists
    if ( slideDiv.has( "img" ).length ) return;

    var imgData = slideDiv.attr( "data-src" ),
    	urlData = slideDiv.attr( "data-href" );
    if ( imgData ) {
        var parts = imgData.split( "*" );
        var img = jQuery( "<img/>" )
            .attr( "src", parts[0] );
        if ( urlData ) img = img.wrap("<a href='" + urlData + "' target='_blank' />").parent();
        slideDiv.prepend( img );
    }
}


function ensureAllImagesAreLoaded( postID, count ) {
    for ( i = 1; i <= count; i++ ) {
        ensureImageIsLoaded( getSlideElement( postID, i ) );
    }
}