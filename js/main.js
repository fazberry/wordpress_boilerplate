$(function(){

	var startHeight = $('.section-issue-welcome').height();

	$('.show-hide').on('click', function(e) {
		e.preventDefault();
		if($('.section-issue-welcome').height() == startHeight) {
			var height = $('.section-issue-welcome').css('height', 'auto').height();
			$('.section-issue-welcome').css('height', startHeight);
			$('.section-issue-welcome').animate({height: height}); 
			$('.show-hide').text('MINIMISE');
			$('.show-hide').addClass('show-hide-minimise');
		} else {
			$('.section-issue-welcome').animate({height: startHeight});
			$('.show-hide').text('EXPAND');
			$('.show-hide').removeClass('show-hide-minimise');
		}
	});

	var navDistance = $('.navigation').position().top;

	$(document).scroll(function(e){
		if($(document).scrollTop() >= navDistance) {
			$('.navigation').addClass('sticky');
		} else {
			$('.navigation').removeClass('sticky');
		}
	});

	if($('.social-sticky').length) {

		var socialDistance = $('.social-sticky').position().top - 90;

		$(document).scroll(function(e){
			if($(document).scrollTop() >= socialDistance) {
				$('.social-sticky').addClass('sticky');
				$('.article-container .arrow').addClass('sticky');
			} else {
				$('.social-sticky').removeClass('sticky');
				$('.article-container .arrow').removeClass('sticky');
			}
		});

	}

	// var $carouselItem = $('.section-archive-carousel > div a');
	// var $carouselContainer = $('.section-archive-carousel > div');
	// var carouselWidth = $('.section-archive-carousel').width();

	// var width = $carouselItem.width() * $('.nav-archive .section-archive-carousel > div a').length; 
	// $('.nav-archive .section-archive-carousel > div').width(width);
	// var width = $carouselItem.width() * $('.article-archive .section-archive-carousel > div a').length; 
	// $('.article-archive .section-archive-carousel > div').width(width);

	// $('.section-archive .right-arrow').on('click', function(e){
	// 	e.preventDefault();
	// 	var $target = $(this).siblings('.section-archive-carousel').children();
	// 	var left = parseInt($target.css('left'));
	// 	left = Math.ceil(left / $carouselItem.width()) * $carouselItem.width();
	// 	if(left <= -($target.width() - carouselWidth)) {
	// 		return;
	// 	}
	// 	left = left - $carouselItem.width();
	// 	$target.animate({'left': left});
	// });
	// $('.section-archive .left-arrow').on('click', function(e){
	// 	var $target = $(this).siblings('.section-archive-carousel').children();
	// 	var left = parseInt($target.css('left'));
	// 	e.preventDefault();
	// 	left = Math.ceil(left / $carouselItem.width()) * $carouselItem.width();
	// 	if(left >= 0 ) {
	// 		return;
	// 	}
	// 	left = left + $carouselItem.width();
	// 	$target.animate({'left': left});
	// });


	if(window.innerWidth > 700){
		$('.nav-archive-carousel').slick({
			infinite: false,
			slidesToShow: 4,
			slidesToScroll: 4
		});
	}

	$('.article-archive .section-archive-carousel').slick({
			infinite: false,
			slidesToShow: 4,
			slidesToScroll: 4,
			responsive: [
			    {
			      breakpoint: 700,
			      settings: {
			        slidesToShow: 1,
			        slidesToScroll: 1     
			    }
			}]
		});

	$('.archive-button').on('click', function(e){
		e.preventDefault();
		e.stopPropagation();
		$('.archive-button').toggleClass('archive-open');
		if(!$('.navigation li.archive ul').innerHeight()) {
			$('.navigation li.archive ul').animate({'height': $('.navigation li.archive ul li').innerHeight()});
		} else {
			$('.navigation li.archive ul').animate({'height': 0 });
		}
	});

	$('.burger').on('click', function(e){
		e.preventDefault();
		$('.navigation-inner > ul').fadeToggle();
	});


	$('.nav-dropdown ul a').on('click', function(e){
		e.stopPropagation();
	});	

	if(window.innerWidth > 700){
		$('li.nav-dropdown').hover(function(){
			$(this).children('ul').stop(true).slideDown('fast');
		},function(){
			$(this).children('ul').stop(true).slideUp('fast');
		})
	} else {
		$('.nav-dropdown').on('click', function(e){
			e.preventDefault();
			$('.navigation .nav-dropdown ul').stop(true).slideUp();
			$(this).children('ul').stop(true).slideDown();	
		});	
	}

	$('.article-content .share').on('click', function(e){
		e.preventDefault();
		$('.article-content .share-options').slideToggle('fast');
	})

	// $('.social-sticky .share').hover(function(e){
	// 	e.preventDefault();
	// 	$('.social-sticky .share-options').slideLeft('fast');
	// })

	$('.top').each(function(){
	    $(this).click(function(){ 
	        $('html,body').animate({ scrollTop: 0 }, 'slow');
	        return false; 
	    });
	});


	$('.article-content a > img').each(function(){
		$(this).parent().addClass('lightbox').append($('<span>'));
		if($(this).hasClass('alignright')) {
			$(this).parent().addClass('lightbox-right')

			// Make it the correct width
			// if ($(this).attr('width')) {
			// 	$(this).parent().innerWidth($(this).attr('width') + 'px');
			// }
		}
		if($(this).hasClass('alignleft')) {
			$(this).parent().addClass('lightbox-left')
		}
	})

	

///////////////////////////////////////////////////////// Video ///////////////////////////////////////////////////////////

if($('video').length) {
	// Video
	var video = $("video").get(0);
	video.muted = true;

	// Buttons
	var muteButton = document.getElementById("mute");
	var fullScreenButton = document.getElementById("full-screen");


	// Event listener for the mute button
	if(muteButton) {
		muteButton.addEventListener("click", function(e) {
	  	e.preventDefault();
		  	if (video.muted == false) {
			    // Mute the video
			    video.muted = true;

			    // Update the button text
			    $('#mute').addClass('muted')
		  	} else {
			    // Unmute the video
			    video.muted = false;

			    // Update the button text
			    $('#mute').removeClass('muted')
			}
		});

		// Event listener for the full-screen button
		fullScreenButton.addEventListener("click", function() {
			if (video.requestFullscreen) {
				video.requestFullscreen();
			} else if (video.mozRequestFullScreen) {
				video.mozRequestFullScreen(); // Firefox
			} else if (video.webkitRequestFullscreen) {
				video.webkitRequestFullscreen(); // Chrome and Safari
			}
		});

	}
}


//////////////////////////////////////////////////////// COMMENTS ////////////////////////////////////////////////////////


$('.comment-reply-link').on('click', function(e){
	e.preventDefault();
	e.stopPropagation();
	if($(this).siblings('form').length){
		return;
	}
	var parentId = $(this).closest('li').attr('id').replace( /[^\d]/g, '' );
	console.log(parentId);
	var commentForm = $($('.comment-respond').html());
	commentForm.find('#comment_parent').val(parentId);
	$(this).after(commentForm);
});

//////////////////////////////////////////////////////// SEARCH ////////////////////////////////////////////////////////

	$('.search').on('click', function(e){
		e.preventDefault();
		$('#searchform #s').focus();
		$('.page-overlay').fadeToggle();
		setTimeout(function(){
			$('.search-box').fadeToggle();
		},200)
	})

	$('.page-overlay').on('click', function(){
		$('.search-box').fadeOut();
		$('.page-overlay').fadeOut();
		$('.feedback-form').fadeOut();
	})

	$('.feedback').on('click', function(e){
		e.preventDefault();
		$('.page-overlay').fadeToggle();
		setTimeout(function(){
			$('.feedback-form').fadeToggle();
		},200)
	})


});