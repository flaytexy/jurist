
var slideIndex=0;
var timerId=0;
// Next/previous controls
function plusSlides(n) {
    showSlides(slideIndex += n);
}

function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("banner");
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slides[slideIndex-1].style.display = "flex";
}
function showSlidesAuto () {
	plusSlides(1);
    timerId= setTimeout(showSlidesAuto,6500);
   // Change image every 2 seconds
}
function showSlidesStop(){
	clearTimeout(timerId);
}
function showSlidesRepeat(){
   timerId= setTimeout( showSlidesAuto,3000);
}


$(function () {
  //
    // $("#Slider-Main").show().slick({
    //     autoplay: false,
    //     autoplaySpeed: 10000,
    //     speed: 600,
    //     slidesToShow: 1,
    //     slidesToScroll: 1,
    //     pauseOnHover: false,
    //     dots: false,
    //     pauseOnDotsHover: true,
    //     cssEase: 'linear',
    //     // fade:true,
    //     draggable: false,
    //     prevArrow: '<button class="PrevArrow"></button>',
    //     nextArrow: '<button class="NextArrow"></button>'
    // });


	//===== Search Luxurious Form =====//
	$('.search-luxuriousvilla > span').on('click',function(){
		$('.search-luxuriousform').toggleClass('active');
		$('.search-luxuriousvilla > span').toggleClass('active');
	});

	 if ($.isFunction($.fn.owlCarousel)) {

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
	}
});

$(window).load(function () {

    slideBtn = document.getElementsByClassName('slide-btn');
    slideBtn[0].addEventListener('mouseover', showSlidesStop);
    slideBtn[1].addEventListener('mouseover', showSlidesStop);
    slideBtn[0].addEventListener('mouseout', showSlidesRepeat);
    slideBtn[1].addEventListener('mouseout', showSlidesRepeat);
    showSlidesRepeat();

    setTimeout(function(){
        initializeTicker();
    }, 1000);
});
