$(function() {
    'use strict';

    //////////// Lazyloading ////////////

    function lazyLoad(x) {
        x += $(window).height() + 100;
        $('[data-background],[data-image]').each(function(){
            var self = $(this),
                image;

            if(self.offset().top > x) {
                return;
            }
            if(self.data('background')){
                image = self.data('background');
            } else {
                image = self.data('image');
            }
            $('<img>',{src:image}).on('load', function(){
                if(self.data('background')){
                    self.css('background-image', 'url("'+image+'")');
                } else {
                    self.attr('src', image);
                }
                self.removeAttr('data-background');
                self.removeAttr('data-image');
            });
        });
    }

    $(window).scroll(function(){
        var x = $(this).scrollTop();
        lazyLoad(x);
    });
    lazyLoad(0);

    //////////// Lazyloading ////////////
});