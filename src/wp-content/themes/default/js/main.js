$(function() {
    'use strict';

    //////////// Lazyloading ////////////

    function lazyLoad(x) {
        x += $(window).height() + 100;
        $('[data-background],[data-image]').each(function(){
            var self = $(this);
            if(self.offset().top > x) {
                return;
            }
            if(self.data('background')){
                var image = self.data('background');
            } else {
                var image = self.data('image');
            }
            $('<img>',{src:image}).on('load', function(){
                if(self.data('background')){
                    self.css('background-image', 'url("'+image+'")');
                } else {
                    self.attr('src', image);
                }
                self.removeAttr('data-background');
                self.removeAttr('data-image');
            })
        });
    }

    $(window).scroll(function(){
        var x = $(this).scrollTop();
        lazyLoad(x);
    });
    lazyLoad(0);

    //////////// Lazyloading ////////////
});