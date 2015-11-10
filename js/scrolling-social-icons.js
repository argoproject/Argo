(function() {
  var $ = jQuery;

  var bindEvents = function() {
    var debouncedMaybeShowPalette = debounce(maybeShowSocialPalette, 250);
    $(window).on('scroll', debouncedMaybeShowPalette);
    $(window).on('resize', debouncedMaybeShowPalette);
  };

  var maybeShowSocialPalette = function() {
    if ( checkPosition() && checkViewPort() ) {
      console.log('TKTK show the social palette');
    }
    console.log('TKTK hide the social palette');
  };

  var checkPosition = function() {
    var scrollTop = $(window).scrollTop();

    if (scrollTop > offsets[0] && scrollTop < offsets[1])
      return true;

    return false;
  };

  var checkViewPort = function() {
    // Replace CONFIGJSON with whatever is providing the appropriate width from the backend
    if ( $(window).width() > CONFIGJSON.width )
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

  var getOffsets = function() {
    var socialLinks = $('.post-social'),
        offsets = [];

    $.each(socialLinks, function(idx, el) {
      if (idx == 0)
        offsets.push($(el).offset().top + $(el).outerHeight());
      else
        offsets.push($(el).offset().top);
    });

    return offsets;
  };

  $(document).ready(bindEvents);
})();
