(function() {
    var $ = jQuery;

    $(document).ready(function() {
        $('.navis-slideshow').each(function() {
            var post_id = $(this).attr('id'),
                post_id_clean = post_id.replace('slides-', ''),
                slick_opts = {
                    adaptiveHeight: true,
                    lazyLoad: 'progressive',
                    dots: true,
                    prevArrow: '<a class="slick-previous slick-navigation" href="#" title="Previous">Previous</a>',
                    nextArrow: '<a class="slick-next slick-navigation" href="#" title="Next">Next</a>'
                };

            if (window.location.hash) {
                var search = new RegExp(post_id_clean, 'g');

                if (search.test(window.location.hash.replace('#', ''))) {
                    var fragment = window.location.hash.replace(/^\#.*\//, '', 'gmi'),
                        slideNum = parseInt(fragment);

                    if (!isNaN(slideNum))
                        slick_opts.initialSlide = slideNum - 1;
                }
            }

            $(this).slick(slick_opts);
        });
    });
})();
