$(function() {
    'use strict';

    var windowWidth = window.innerWidth,
        windowHeight = window.innerHeight;
    $(window).on('resize', function() {
        windowWidth = window.innerWidth;
        windowHeight = window.innerHeight;
    });


    //////////// Lazyloading ////////////

    function lazyLoad(x) {
        x += $(window).height() + 100;
        $('[data-background],[data-background-mobile],[data-image]').each(function(){
            var self = $(this),
                image;

            if(self.offset().top > x) {
                return;
            }

            var currentImage;
            if(self.data('background')) {
                // Do we want mobile?
                image = self.data('background');
                if (windowWidth < 600 && self.data('background-mobile')) {
                    image = self.data('background-mobile');
                }

                currentImage = $(this).css('background-image');
                currentImage = currentImage.replace('url(','').replace(')','').replace(/\"/gi, "");
            } else {
                image = self.data('image');
                currentImage = self.attr('src');
            }

            // Is the image the same one we already have?
            if (image == currentImage) {
                return;
            }

            $('<img>',{src:image}).on('load', function(){
                if(self.data('background')){
                    self.css('background-image', 'url("'+image+'")');
                } else {
                    self.attr('src', image);
                }

                self.removeAttr('data-background-mobile');
                if (windowWidth >= 600) {
                    self.removeAttr('data-background');
                }
                self.removeAttr('data-image');
            });
        });
    }

    $(window).scroll(function(){
        var x = $(this).scrollTop();
        lazyLoad(x);
    }).on('resize', function() {
        var x = $(this).scrollTop();
        lazyLoad(x);
    });
    lazyLoad(0);

    //////////// Lazyloading ////////////
});