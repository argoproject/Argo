(function() {
    var $ = jQuery;

    function createSlider($gallery, slide_num){

        var post_id = $gallery.attr('id'),
            post_id_clean = post_id.replace('slides-', ''),
            slick_opts = {
                adaptiveHeight: true,
                lazyLoad: 'progressive',
                dots: true,
                prevArrow: '<a class="slick-previous slick-navigation" href="#" title="Previous">Previous</a>',
                nextArrow: '<a class="slick-next slick-navigation" href="#" title="Next">Next</a>',
                initialSlide: slide_num
            };

        
        

        $gallery.slick(slick_opts);

        //distinguish between click or drag (drag >100ms)
        var valid_click = true;
        var delay = 100;

        //this function sets the flag to false
        var drag = function(){
            valid_click = false;
        }

        //var $target = $('.navis-slideshow img');
        var $target = $($gallery.find('img'));

        //mousedown, a global variable is set to the timeout function
        $target.mousedown( function(){
            cancel_click = setTimeout( drag, delay );
        })

        //mouseup, the timeout for drag is cancelled
        $target.mouseup( function(e){
            clearTimeout( cancel_click );

            if(valid_click){
                var $slider = $(e.target.closest('.navis-slideshow'));
                expandSlider($slider);
            }

            valid_click = true;
        })
    }

    function createGallery($gallery, slide_num){

        
        $gallery.find('img').each(function(){
            var $this = $(this);
            var src = $this.data('lazy');
            var $parent = $this.parent();
            //$this.attr('src', src);
            $parent.prepend('<div style="background-image:url(' + src + ');"></div>');
            //$parent.css({'width': '33%', 'float': 'left'});
            $parent.click(function(){
                var $this = $(this);
                if ($this.closest('.largo-img-grid').length > 0){
                    $gallery.addClass('navis-slideshow').removeClass('largo-img-grid').addClass('navis-full');
                    createSlider($gallery, $parent.index());
                    addCloseX($gallery);
                }
            });
        });


        //$gallery.slick(slick_opts);
    }

    function addCloseX($slider){
        $slider.prepend('<span class="navis-before">X</span>');
        $('.navis-before').click(function(){
            closeFull($slider);
        });
    }

    function expandSlider($slider){
        var full = 'navis-full';

        if (!$slider.hasClass(full)){
            $slider.addClass(full);
            $slider.slick('setPosition');

            addCloseX($slider);
        }
    };

    function closeFull($slider){
        $('.navis-before').remove();
        $('.navis-full').removeClass('navis-full');
        $slider.slick('setPosition');

        if (!$slider.hasClass('one-up')){
            $slider.slick('unslick');
            $slider.removeClass('navis-slideshow').addClass('largo-img-grid');
            var $parent = $slider.find('>div');
            //$parent.css({'width': '33%', 'float': 'left'});
            $parent.click(function(){
                var $this = $(this);
                if ($this.closest('.largo-img-grid').length > 0){
                    $slider.addClass('navis-slideshow').removeClass('largo-img-grid').addClass('navis-full');
                    createSlider($slider, $this.index());
                    addCloseX($slider);
                }
                
            });
        }
    }

    $(document).ready(function() {
        $('.navis-slideshow').each(function() {
            var $gallery = $(this);
            var slide_num = 0;

            if ($gallery.hasClass('one-up')){
                var post_id = $gallery.attr('id'),
                post_id_clean = post_id.replace('slides-', '');

                if (window.location.hash) {
                    var search = new RegExp(post_id_clean, 'g');

                    if (search.test(window.location.hash.replace('#', ''))) {
                        var fragment = window.location.hash.replace(/^\#.*\//, '', 'gmi'),
                            slideNum = parseInt(fragment);

                        if (!isNaN(slideNum))
                            slide_num = slideNum - 1;
                    }
                }
                createSlider($gallery, slide_num);
            } else {
                $gallery.removeClass('navis-slideshow').addClass('largo-img-grid');
                createGallery($gallery, slide_num);
            }
        });
    });

    $(document).keyup(function(e) {
        var $slider = $('.navis-full');

        if (e.keyCode == 27) { // escape
            if ($slider.length > 0) {
                closeFull($slider);
            }
        }
    });
})();
