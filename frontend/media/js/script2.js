var actionFaq = 'click';
var speedFaq = "500";


jQuery(document).ready(function ($) {
    'use strict';

	$('li.q').on(actionFaq, function () {
		$(this).next().slideToggle(speedFaq)
			.siblings('li.a').slideUp();

		var img = $(this).children('img');
		$('img').not(img).removeClass('rotate');
		img.toggleClass('rotate');
	});

    //===== Menu Active =====//
    var pgurl = window.location.href.substr(window.location.href.lastIndexOf("/") + 1);
    $("nav ul li a").each(function () {
	if ($(this).attr("href") == pgurl || $(this).attr("href") == '')
	    $(this).parent('li').addClass("active");
    });

    //===== Top Bar contact Toggle =====//
    $('.topbar-contact > li:first-child').addClass('active');
    $('.topbar-contact > li').on('click', function () {
	$(this).parent().find('li').removeClass('active');
	$(this).addClass('active');
	return false;
    });

    //===== Responsive Header =====//
    $('.menu-btn').on('click', function () {
	$('.responsive-menu').addClass('slidein');
	return false;
    });
    $('.close-btn').on('click', function () {
	$('.responsive-menu').removeClass('slidein');
	return false;
    });
    $('.responsive-menu li.menu-item-has-children > i').on('click', function () {
	$(this).parent().siblings().children('ul').slideUp();
	$(this).parent().siblings().removeClass('active');
	$(this).parent().children('ul').slideToggle();
	$(this).parent().toggleClass('active');
	return false;
    });

    //===== Paackages Script =====//
    $('.location-book > li:first-child').addClass('active');
    $('div.packages  ul.location-book li').each(function () {
	var $this = $(this);
	$(this).on('mouseenter', function () {
	    var parent = $($this).parent('ul');
	    $(parent).find('li').each(function () {
		$(this).removeClass('active');
	    });
	    $(this).addClass('active');
	});
    });

    //===== Sticky Header =====// 
    var menu_height = $('header').height();
    $(window).scroll(function () {
	var scroll = $(window).scrollTop();
	if (scroll >= 60) {
	    $('.stick').addClass('sticky');
	} else {
	    $('.stick').removeClass('sticky');
	}
    });
    if ($('header').hasClass('stick')) {
	$('.theme-layout').css({'padding-top': menu_height});
    }

    //===== Select2 =====//
    if ($.isFunction($.fn.select2)) {
	$('select').select2();
    }

    //===== Scroll Bar =====//
    if ($.isFunction($.fn.perfectScrollbar)) {
	$('.responsive-menu').perfectScrollbar();
    }

    //===== Parallax =====//
    if ($.isFunction($.fn.scrolly)) {
	$('.parallax').scrolly({bgParallax: true});
    }

    //===== Ajax Contact Form =====//
    $('#contactform').submit(function () {
	var action = $(this).attr('action');
	var msg = $('#message');
	$(msg).hide();
	var data = 'name=' + $('#name').val() + '&email=' + $('#email').val() + '&phone=' + $('#phone').val() + '&comments=' + $('#comments').val() + 'verify=' + $('#verify').val() + 'captcha=' + $(".g-recaptcha-response").val();
	$.ajax({
	    type: 'POST',
	    url: action,
	    data: data,
	    beforeSend: function () {
		$('#submit').attr('disabled', true);
		$('img.loader').fadeIn('slow');
	    },
	    success: function (data) {
		$('#submit').attr('disabled', false);
		$('img.loader').fadeOut('slow');
		$(msg).empty();
		$(msg).html(data);
		$('#message').slideDown('slow');
		if (data.indexOf('success') > 0) {
		    $('#contactform').slideUp('slow');
		}
	    }
	});
	return false;
    });

    //===== Sponsor Carousel =====//
    if ($.isFunction($.fn.owlCarousel)) {
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
});/*========== Document Ready Function Ends Here ==========*/