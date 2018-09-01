(function ($) {
    $.fn.onEnter = function (func) {
        this.bind('keypress', function (e) {
            if (e.keyCode == 13) func.apply(this, [e]);
        });
        return this;
    };
})(jQuery);

function initMap() {

    if (initializeScroll) {

        $.getScript("https://maps.googleapis.com/maps/api/js?key=AIzaSyCWVV9qdg3P78sJnnzvx1o9CJ6nqSKagG0", function () {
            var mapElement = document.getElementById('map');
            if (mapElement) {
                var mapOptions = {
                    zoom: 15,
                    center: new google.maps.LatLng(55.758784, 37.608181) // New York
                    //styles: [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#4f595d"},{"visibility":"on"}]}]
                };
                var map = new google.maps.Map(mapElement, mapOptions);

                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(55.758784, 37.608181),
                    map: map,
                    title: 'Snazzy!'
                });
            }

            //console.log("GoogleMaps loaded. (maps.googleapis.com bottom-right)");
        });

        initializeScroll = false;
    }
}


function setupViewport() {
    $ticker.find(tickerItem).clone().prependTo('[data-ticker="list"]');

    for (i = 0; i < itemCount; i++) {
        var itemWidth = $(tickerItem).eq(i).outerWidth();
        viewportWidth = viewportWidth + itemWidth;
    }

    $ticker.css('width', viewportWidth);
}

function animateTicker() {
    $ticker.animate({
        marginLeft: -viewportWidth
    }, 50000, "linear", function () {
        $ticker.css('margin-left', '0');
        animateTicker();
    });
}

function initializeTicker() {
    setupViewport();
    animateTicker();

    $ticker.on('mouseenter', function () {
        $(this).stop(true);
    }).on('mouseout', function () {
        animateTicker();
    });
}


jQuery.scrollTo = function (target, offset, speed, container) {

    if (isNaN(target)) {

        if (!(target instanceof jQuery))
            target = $(target);

        target = parseInt(target.offset().top);
    }

    container = container || "html, body";
    if (!(container instanceof jQuery))
        container = $(container);

    speed = speed || 500;
    offset = offset || 0;

    container.animate({
        scrollTop: target + offset
    }, speed);
};


var $ticker = $('[data-ticker="list"]'),
    tickerItem = '[data-ticker="item"]',
    itemCount = $(tickerItem).length,
    viewportWidth = 0;


function sHide() {
    $('#adBlock').hide();
    $('.gsc-adBlock').hide();

    return true;
}

// возвращает cookie с именем name, если есть, если нет, то undefined
function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

function setCookie(name, value, options) {
    options = options || {};

    var expires = options.expires;

    if (typeof expires == "number" && expires) {
        var d = new Date();
        d.setTime(d.getTime() + expires * 1000);
        expires = options.expires = d;
    }
    if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
    }

    value = encodeURIComponent(value);

    var updatedCookie = name + "=" + value;

    for (var propName in options) {
        updatedCookie += "; " + propName;
        var propValue = options[propName];
        if (propValue !== true) {
            updatedCookie += "=" + propValue;
        }
    }

    document.cookie = updatedCookie;
}

function deleteCookie(name) {
    setCookie(name, "", {
        expires: -1
    })
}

$('#searchBlock')
    .on('keypress', '.gsib_a', function (e) {
        console.log('sea keypress');
        setTimeout(function () {
            sHide();
        }, 10);
        setTimeout(function () {
            sHide();
        }, 100);
        setTimeout(function () {
            sHide();
        }, 300);
        setTimeout(function () {
            sHide();
        }, 600);
        setTimeout(function () {
            sHide();
        }, 1000);
        setTimeout(function () {
            sHide();
        }, 3000);
    })
    .on('click', '.gsc-search-button', function (e) {
        console.log('sea click');
        setTimeout(function () {
            sHide();
        }, 10);
        setTimeout(function () {
            sHide();
        }, 100);
        setTimeout(function () {
            sHide();
        }, 300);
        setTimeout(function () {
            sHide();
        }, 600);
        setTimeout(function () {
            sHide();
        }, 1000);
    });


$(function (e) {

    // if (getCookie('shownDialogVyhodnoy34e') != 'true') { // Cookie not set?
    //     $('#dialog-vyhodnoy').dialog({
    //         modal: true,
    //         buttons: { //Show dialog
    //             'Закрыть': function() {
    //                 $(this).dialog('close');
    //         }},
    //         open: function() {
    //             $(this).closest(".ui-dialog")
    //                 .find(".ui-dialog-titlebar-close")
    //                 //.removeClass("ui-dialog-titlebar-close")
    //                 .html("<span class='ui-button-icon-primary ui-icon ui-icon-closethick'></span>");
    //         }
    //     });
    // }
    // setCookie('shownDialogVyhodnoy34e', 'true', 1); // Set cookie

    $("#clicky").click(function () {
        var ssocial = $("#sticky-zone");
        if (ssocial.is(':visible')) {
            ssocial.animate({width: 'hide'});
        }
        else {
            ssocial.animate({width: 'show'});
        }
    });

    $("b:contains('Русский')").addClass('Rus');
    $("b:contains('English')").addClass('Eng');
    $("li:contains('English')").addClass('Eng');
    $("li:contains('Русский')").addClass('Rus');


    //Check to see if the window is top if not then display button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 500) {
            $('.scrollToTop').fadeIn();
        } else {
            $('.scrollToTop').fadeOut();
        }
    });

    //Click event to scroll to top
    $('.scrollToTop').click(function () {
        $('html, body').animate({scrollTop: 0}, 800);
        return false;
    });
    //Scroll header mobile version


// site preloader -- also uncomment the div in the header and the css style for #preloader
    /*   $(window).load(function(){

           $('#rhlpscrtg').fadeOut('slow',function(){$(this).show();});
           $("#status").fadeOut();
           $('#preloader').delay(1000).fadeOut('slow',function(){$(this).remove();});

       });  */


    $("#menu-show-block, #map-pos").on('click', 'a', function () {
        $('#menu-show-block-zone').show();
        $('#menu-show-block-zone .block-zone').hide();
        $('#' + $(this).attr('data-show-block')).show();
        $.scrollTo('#' + $(this).attr('data-show-block'), -250);
    });

    $("a[data-reveal-id]").on('click', function () {
        var curModalSelector = '#' + $(this).attr('data-reveal-id');
        var curModal = $(curModalSelector);
        curModal.dialog({
            title: "",
            modal: true,
            width: "auto",
            maxHeight: "700px",
            closeText: "X",
            create: function (event, ui) {
                $(this).css("maxWidth", "1000px");
            },
            open: function (event, ui) {
                $('.ui-widget-overlay').addClass('custom-overlay');
                //$(this).parent().children().children('.ui-dialog-titlebar-close').hide();
            },
            close: function () {
                $('.ui-widget-overlay').removeClass('custom-overlay');
            }
        });

        return false;
    });

    console.log('Its_End_Script READY');
});

var _d_site = _d_site || '411086831FF94A27DC0340B2';

var initializeScroll = true;

$(window).load(function () {

    // executes when complete page is fully loaded, including all frames, objects and images
    (function () {
        var cx = '014824414261944164439:sfk3fpa6eoq';
        var gcse = document.createElement('script');
        gcse.type = 'text/javascript';
        gcse.async = true;
        //gcse.class = 'gsc-search-button gsc-search-button-v2 fa fa-search';
        gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
        //gcse.src = '/js/google-async-ads.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(gcse, s);

        //console.log("cse.google.com/cse.js loaded.");
    })();
    setTimeout(function () {
        $('.gsc-search-box td.gsc-search-button').addClass("fa fa-search");
        $('td.gsc-search-button input').attr('type', 'button').attr('src', '');
    }, 1000);

    // if(typeof(_DEBUG_MODE)=='undefined' || _DEBUG_MODE == false){
    //     var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
    //     (function () {
    //         var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
    //         s1.async = true;
    //         s1.src = 'https://embed.tawk.to/5a295e135d3202175d9b6ea0/default';
    //         s1.charset = 'UTF-8';
    //         s1.setAttribute('crossorigin', '*');
    //         s0.parentNode.insertBefore(s1, s0);
    //     })();
    // }

    $(window).scroll(function () {
        var scrollPos = $(document).scrollTop();

        // console.log('window.scrollTop: ' + $(window).scrollTop());
        // console.log('window.height: ' +$(window).height());
        // console.log('document.height: ' +$(document).height());

        if($(window).scrollTop() + $(window).height() + 1100 >= $(document).height()) {
            //alert("Bottom Reached!");
            console.log('Bottom Reached! + 1100');
            initMap();
        }
    });

    // $(window).scroll(function() {
    //     // // Подпишитесь
    //     // $.getScript("//widget.privy.com/assets/widget.js", function () {
    //     //     $('#privy-container').hide();
    //     //     setTimeout(function(){
    //     //         //$('#privy-container').show();
    //     //     }, 1000);
    //     //     console.log("widget.privy.com loaded. (subscribe - top left)");
    //     // });
    // });


    // // 'Позвонить? // не работает главный слайдер )) когда сюда перемещаем
    // $.getScript("https://cdn.jotfor.ms/static/feedback2.js", function () {
    //     document.addEventListener("DOMContentLoaded", function(event) {
    //         new JotformFeedback({
    //             formId: "72341635329355",
    //             buttonText: "Позвонить?",
    //             base: "https://form.jotformeu.com/",
    //             background: "#7dc20f",
    //             fontColor: "#FFFFFF",
    //             buttonSide: "left",
    //             buttonAlign: "center",
    //             type: 1,
    //             width: 550,
    //             height: 450
    //         });
    //     });
    //
    //     console.log("feedback2.js loaded. (callPhone - left)");
    // });

    console.log('Its_End_Script LOAD');
});


// var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
// (function () {
//     var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
//     s1.async = true;
//     s1.src = 'https://embed.tawk.to/588fad1957968e2dc9688b7f/default';
//     s1.charset = 'UTF-8';
//     s1.setAttribute('crossorigin', '*');
//     s0.parentNode.insertBefore(s1, s0);
// })();
// List Ticker by Alex Fish
// www.alexefish.com


console.log('FINISH_ALL_SCRIPTS');