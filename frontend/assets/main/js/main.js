$(function () {

    $("#Slider-Main").show().slick({
        autoplay: true,
        autoplaySpeed: 10000,
        speed: 600,
        slidesToShow: 1,
        slidesToScroll: 1,
        pauseOnHover: false,
        dots: false,
        pauseOnDotsHover: true,
        cssEase: 'linear',
        // fade:true,
        draggable: false,
        prevArrow: '<button class="PrevArrow"></button>',
        nextArrow: '<button class="NextArrow"></button>'
    });

    $("#Modern-Slider").show().slick({
        autoplay: true,
        autoplaySpeed: 10000,
        speed: 600,
        slidesToShow: 1,
        slidesToScroll: 1,
        pauseOnHover: false,
        dots: false,
        pauseOnDotsHover: true,
        cssEase: 'linear',
        // fade:true,
        draggable: false,
        prevArrow: '<button class="PrevArrow"></button>',
        nextArrow: '<button class="NextArrow"></button>'
    });

	'use strict';
	//===== Scroll Up Bar =====//
	if ($.isFunction($.fn.scrollupbar)) {
		$('.scrollup').scrollupbar();
	}

	//===== Datepicker =====//
	if ($.isFunction($.fn.datepicker)) {
		$('.datepicker1, .datepicker2').datepicker();
	}

	//===== Search Luxurious Form =====//
	$('.search-luxuriousvilla > span').on('click',function(){
		$('.search-luxuriousform').toggleClass('active');
		$('.search-luxuriousvilla > span').toggleClass('active');
	});

	if ($.isFunction($.fn.owlCarousel)) {
		//===== Customers Reviews Carousel =====//
		$('.customers-reviews').owlCarousel({
			autoplay:true,
			autoplayTimeout:3000,
			smartSpeed:2000,
			loop:true,
			dots:false,
			nav:true,
			margin:10,
			singleItem:true,
			items:1,
			animateIn:"fadeIn",
			animateOut:"fadeOut",
			responsive:{
				0:{nav:false},
				480:{nav:false},
				1200:{nav:true}
			}
		});

		//===== Recent News Carousel =====//
		$("#recentnews-carouselka, #recent-comments").owlCarousel({
			autoplay:true,
			smartSpeed:500,
			loop:true,
			items:2,
			dots:false,
			slideSpeed:4000,
			nav:true,
			margin: 30,
			responsive:{
				0:{items:1,nav:false},
				480:{items:2,nav:false},
				768:{items:2},
				1200:{items:2}
			}
		});


		$('.sponsor-carousel').owlCarousel({
				autoplay: true,
				smartSpeed: 600,
				loop: true,
				items: 5,
				dots: false,
				slideSpeed: 2000,
				nav: true,
				margin: 30,
				responsive: {
					0: {items: 2},
					480: {items: 3},
					768: {items: 4},
					1200: {items: 5}
				}
			});

	}
});
// $(window).scroll(function() {
//
// });
$(window).load(function () {
    setTimeout(function(){
        initializeTicker();
    }, 500);
});
