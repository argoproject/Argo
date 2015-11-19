(function() {
  var $ = jQuery;

  var bindEvents = function() {
    var debouncedMaybeShowPalette = debounce(maybeShowSocialPalette, 250);
    $(window).on('scroll', debouncedMaybeShowPalette);
    $(window).on('resize', debouncedMaybeShowPalette);
  };

  var maybeShowSocialPalette = function() {
    if ( checkPosition() && checkViewPort() ) {
      if ( ! $('#floating-social-buttons').length ) {
        $('#page').append('<div id="floating-social-buttons" class=""></div>');
        $('#floating-social-buttons')
          .html($("#tmpl-floating-social-buttons").html())
          .fadeIn('100')
          .css('position', 'fixed')
          .css('top', $('.sticky-nav-holder').outerHeight() + (1.5 * 1.22 * 16)) // The line height of a standard p tag in largo is 1.5 * 1.22 * @baseFontSize
          .css('left', offsetLeft());
      } else {
        $('#floating-social-buttons')
          .css('opacity', '1')
          .css('width', '')
          .css('top', $('.sticky-nav-holder').outerHeight() + (1.5 * 1.22 * 16)) // The line height of a standard p tag in largo is 1.5 * 1.22 * @baseFontSize
          .css('left', offsetLeft());
      }

    } else {
      $('#floating-social-buttons')
      .css('width', '0')
      .css('opacity', '0');
    }
  };

  var offsetLeft = function() {
    return $('#content').offset().left;
  }

  var checkPosition = function() {
    var scrollTop = $(window).scrollTop(),
        scrollBottom = scrollTop + $(window).height();

    offsets = getOffsets();

    if (scrollTop > offsets[0] && scrollBottom < offsets[1])
      return true;

    return false;
  };

  var checkViewPort = function() {
    if ( $(window).width() > window.floating_social_buttons_width.min )
      return true;
    return false;
  };

  var debounce = function(func, wait, immediate) {
    var timeout;
    return function() {
      var context = this, args = arguments;
      var later = function() {
        timeout = null;
        if (!immediate) func.apply(context, args);
      };
      var callNow = immediate && !timeout;
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
      if (callNow) func.apply(context, args);
    };
  };

  /**
   * Get the offset of the bottom of the top element bounding the article
   */
  var getOffsetTop = function() {
    // Determine whether or not there is a hero element, and save that element
    if ( typeof window.floating_social_buttons_top_element == 'undefined' ) {
      if ( $('#content .hero').length ) {
        window.floating_social_buttons_top_element = $('#content .hero');
      } else {
        window.floating_social_buttons_top_element = $('#content header');
      }
    }

    return window.floating_social_buttons_top_element.offset().top
      + window.floating_social_buttons_top_element.outerHeight()
      - $('.sticky-nav-holder').outerHeight();
        // We want it to appear when the top area is no longer visible, not when the top area is no longer inside the viewport.
  }

  /**
   * Get the offset of the top of the bottom element bounding the article
   */
  var getOffsetBottom = function() {
    // Article bottom widget area if that exits, else the comments area or the site footer.
    if ( typeof window.floating_social_buttons_bottom_element == 'undefined' ) {
      if ( $('.article-bottom').length ) {
        window.floating_social_buttons_bottom_element = $('.article-bottom .largo-follow');
      } else if ( $('#comments').length ) {
        window.floating_social_buttons_bottom_element = $('#comments');
      } else {
        window.floating_social_buttons_bottom_element = $('#site-footer');
      }
    }

    return window.floating_social_buttons_bottom_element.offset().top;
  }

  /**
   * Gets the offset range where the floating social button is allowed.
   *
   * Returns an array with the 0th index the offset from top and the 1st index the offset from bottom.
   *
   * Things to consider:
   *   if there's a hero unit, we need to use the bottom of that
   *   if there isn't a hero image, then we can use the bottom of `#content > article > header`
   *   afaik, we don't add hero units after the page loads, so this should be good for now
   */
  var getOffsets = function() {

    var offsets = [];

    offsets.push( getOffsetTop() );
    offsets.push( getOffsetBottom() );

    return offsets;
  };

  $(document).ready(bindEvents);
})();
