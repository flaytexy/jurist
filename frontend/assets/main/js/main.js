$(document).ready(function(){
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
		$(".recentnews-carousel").owlCarousel({
			autoplay:true,
			smartSpeed:500,
			loop:true,
			items:2,
			dots:false,
			slideSpeed:2000,
			nav:true,
			margin: 30,
			responsive:{
				0:{items:1,nav:false},
				480:{items:2,nav:false},
				768:{items:2},
				1200:{items:2}
			}
		});
	}
});