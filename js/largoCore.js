jQuery(document).ready(function($) {

	//html5 placeholders
	$('input[placeholder], textarea[placeholder]').placeholder();

	// dim sidebar
	$(window).scroll(function(){
		if (($(this).scrollTop() > 300) && (document.documentElement.clientWidth >= 767)) {
			$('.showey-hidey').animate({opacity: '0.5'}, 100);
		} else if (($(this).scrollTop() < 300)) {
			$('.showey-hidey').animate({opacity: '1'}, 100);
		}
	});

	// make the sidebar visible if you hover over it
	if (document.documentElement.clientWidth >= 767) {
		$('.showey-hidey').hover(function() {
			$(this).animate({opacity: '1'}, 100);
			}, function() {
				if ($(window).scrollTop() < 300) {
					$(this).animate({opacity: '1'}, 100);
				} else {
				    $(this).animate({opacity: '0.5'}, 100);
				}
		});
	}

	//get the correct sized image for the header, replace it with a new one if the window is resized
	$('.header_img').attr('src', banner_img_src);
	$(window).resize(function() {
		$('.header_img').attr('src', whichHeader());
	});

	//the homepage carousel, make sure we don't load this unless .carousel is defined
	if($().carousel) {
		$('.carousel').carousel({
			interval: 6000
		});
	}

	//homepage alert CSS hacks
	if ( $('.alert-wrapper').length ) {
		var $wrapper = $('.alert-wrapper'), $container = $('#alert-container');
		$(window).on('resize', function() {
			var $marginWidth = ( $(window).width() - $container.width() ) / -2;
			$marginWidth = ( $marginWidth > 0 ) ? 0 : parseInt( $marginWidth ) ;
			$wrapper.css( {marginLeft: $marginWidth, marginRight: $marginWidth} );
		});
		$(window).trigger('resize');
	}

	//enable "clean read" functionality
	$('a.clean-read').on('click', function() {
		$('body').addClass('clean-read').append('<a class="clean-read-close" href="#">Exit "Clean Read" mode</a>');
		$('.clean-read-container').append('<a class="clean-read-close" href="#">Exit "Clean Read" mode</a>');
		$('a.clean-read').hide();
		return false;
	});

	//close "clean read"
	$(document).on('click', '.clean-read-close', function() {
		$('body').removeClass('clean-read');
		$('a.clean-read').show();
		$('.clean-read-close').remove();
		return false;
	});

	//ESC triggers "clean read" close
	$(document).keyup(function(e) {
    if (e.keyCode == 27 && $('body').hasClass('clean-read')) $('.clean-read-close').trigger('click');
  });

  //GA event tracking for image-widget items
  $('a.image-click-track').on('click', function() {
	  if (typeof _gaq == 'object') _gaq.push(['_trackEvent', 'Click', 'Image Widget', this.getAttribute('title')]);
  });

  // Touch enable the drop-down menus
  (function() {
	  if ( Modernizr.touch ) {

	  	// iOS Safari works with touchstart, the rest work with click
			mobileEvent = /Mobile\/.+Safari/.test(navigator.userAgent) ? 'touchstart' : 'click';

			// Open the drop down
			var openMenu = false;

			// Handle the tap for the drop down
		  $('ul.nav').on( mobileEvent+'.largo', 'li.dropdown', function( event ) {
		  	var li = $(event.currentTarget);
		  	console.log(event.target, event.currentTarget);

		  	if ( !li.is('.open') ) {
		  		// The link when the menu is closed
		  		closeOpenMenu();
		  		li.addClass('open');
		  		openMenu = li;

		  		event.preventDefault();
		  		event.stopPropagation();

		  	} else if ( $(event.target).is('b.caret') ) {
		  		// The caret when the menu is open
		  		li.removeClass('open');
		  		openMenu = false;

		  		event.preventDefault();
		  		event.stopPropagation();
		  	}
		  });

		  // Call this to call the open menu
		  var closeOpenMenu = function() {
		  	if ( openMenu ) {
		  		openMenu.removeClass('open');
		  		openMenu = false;
		  	}
		  }

		  // Close the open menu when the user taps elsewhere
		  $('body').on( mobileEvent, closeOpenMenu);
		}
	})();

	// Sticky header and footer
	(function(){
		var stickyNavEl = $( '.sticky-nav-holder' );
		var mainEl = $('#main');

		mainEl.waypoint( function( direction ) {
			stickyNavEl.toggleClass( 'show', direction == 'down' );
		}, { offset: $('#wpadminbar').height() + parseInt( mainEl.css('marginTop') ) 	});

		// Check if their is a sticky footer
		var stickyFooterEl = $( '.sticky-footer-holder' );
		if ( stickyFooterEl.length ) {
			// Show the sticky footer by default
			stickyFooterEl.addClass( 'show' );

			$('#site-footer').waypoint( function( direction ) {
				stickyFooterEl.toggleClass( 'show', direction == 'up' );
			}, { offset: '100%' } );
		}
	})();

});