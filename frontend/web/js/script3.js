/**
 * Created by Vitaliy on 10.12.2016.
 */

$(document).ready(function(){




    'use strict';

    //===== Package Image Gallery Carousel =====//
    if ($.isFunction($.fn.owlCarousel)) {
        $('.packageimg-gallery').owlCarousel({
            autoplay:true,
            autoHeight : true,
            autoplayTimeout:3000,
            smartSpeed:2000,
            loop:true,
            dots:true,
            nav:false,
            margin:0,
            singleItem:true,
            items:1,
            animateIn:"fadeIn",
            animateOut:"fadeOut"
        });
    }

    //===== Video Script =====//
    $('.package-video > i').on('click',function(){
        $(this).parent().toggleClass('active');
    });


    $("a.bb").click(function () {
        var oldHeight =  $("#logomenu-sec").height();
        $("#logomenu-sec").height(0);

        $.fancybox(
            $('#succes_packet').html(),
            {
                maxWidth	: 1000,
                maxHeight	: 500,
                width		: '80%',
                height		: '60%',
                autoSize	: false,
                'onStart': function () {
                    //On Start callback if needed
                },
                'afterClose': function() {
                    $("#logomenu-sec").height(oldHeight);
                }
            }
        );
    });


    $('body').on('click', '.fancybox-wrap #top-save-button', function(){
        alert("dsadas");
    });
    //$("#succes_packet_form").bind("submit", function() {
    //
    //    if ($("#login_name").val().length < 1 || $("#login_pass").val().length < 1) {
    //        $("#login_error").show();
    //        $.fancybox.resize();
    //        return false;
    //    }
    //
    //    $.fancybox.showActivity();
    //
    //    $.ajax({
    //        type		: "POST",
    //        cache	: false,
    //        url		: "/data/login.php",
    //        data		: $(this).serializeArray(),
    //        success: function(data) {
    //            $.fancybox(data);
    //        }
    //    });
    //
    //    return false;
    //});
});