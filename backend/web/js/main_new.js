$(document).ready(function(){
	if ( $('#grid').length || $('.video__items').length ||  $('.contacts').length ) {
		new WOW().init();
	}

	// header animation elements
	$('.header > ul > li').hover(
		function(){
			$(this).addClass('active_hover');
		}, function(){
			$(this).removeClass('active_hover');
		}
	);
	// END----header animation elements
	if( !$('body').hasClass('main_page') ) {
		if ( $('body').hasClass('news_page') ) {
			$('.header').addClass('header_news');
		}
		$('.header').addClass('header_not-main');
	}
	$('.about_wrapper').css({height: $('.about__left').outerHeight()});
	if ( $(".about__right").length ) {
		if ( $(window).width() > 1250 ) {
			$(".about__right").stick_in_parent();
		}

	}

	var current_pos = 	$('.about__quote').scrollTop();
	$(window).on('scroll', function() {
		if ( $(window).width() > 1200 ) {
			$('.about__quote').stop().animate({top: 500 + $(document).scrollTop() }, 5000);
		}

	})
	if ( $('.overlay').length ) {
		setTimeout(function(){
			$('.overlay').remove()
		}, 1000)

	}
	if ( $('.press__items__item__photo').length > 0 ) {
		$(".press__items__item__photo").owlCarousel({
			nav: true,
			navText: ["<div class='owl_nav_back'></div>","<div class='owl_nav_next'></div>"],
			loop: true,
			// autoplay: true,
			responsive:{
				0:{
					items:1
				}
			}
		});

	}
	var photo_open_next = $('.photo_open__nav .nav_next');
	var photo_open_back = $('.photo_open__nav .nav_back');
	var photos_lg = $('.photo_open__left > img');
	var photos_sm = $('.photo_open__right > img');
	var current_photo = 0;
	function next_photo(){
		for (var i = 0; i < photos_lg.length; i++) {
			$(photos_lg[i]).removeClass('active_photo');
			$(photos_sm[i]).removeClass('active_photo');
		}
		if ( current_photo == photos_lg.length - 1) {
			current_photo = 0;
		} else {
			current_photo++;
		}
		$(photos_lg[current_photo]).addClass('active_photo');
		$(photos_sm[current_photo]).addClass('active_photo');
	}
	function prev_photo(){
		for (var i = 0; i < photos_lg.length; i++) {
			$(photos_lg[i]).removeClass('active_photo');
			$(photos_sm[i]).removeClass('active_photo');
		}
		if ( current_photo == 0) {
			current_photo = photos_lg.length - 1;
		} else {
			current_photo--;
		}
		$(photos_lg[current_photo]).addClass('active_photo');
		$(photos_sm[current_photo]).addClass('active_photo');
	}
	$(photo_open_next).on('click', function(){
		next_photo();
	})
	$(photo_open_back).on('click', function(){
		prev_photo();
	})
	var $hamburger = $(".hamburger");
	 $hamburger.on("click", function(e) {
	   $hamburger.toggleClass("is-active hamb_left");
	   $('.logo_mob').toggleClass('active_mob');
	   $('.header > ul, .header_not-main > ul, .social').toggleClass('active_mob');
	 });
	$(document).on('click', '.theme_btn', function(e){
		$(this).toggleClass('theme_black');
		$('section').toggleClass('theme_black_back');
		$('.texture').toggleClass('texture_black');
		// e.preventDefault();
		$hamburger.toggleClass('black_theme_menu');
	})
})
