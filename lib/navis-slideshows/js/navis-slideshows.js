(function() {
    var $ = jQuery;

    $(document).ready(function() {
        $('.navis-slideshow').slick({
            adaptiveHeight: true,
            lazyLoad: 'progressive',
            dots: true,
            prevArrow: '<a class="slick-previous slick-navigation" href="#" title="Previous">Previous</a>',
            nextArrow: '<a class="slick-next slick-navigation" href="#" title="Next">Next</a>'
        });
    });
})();
