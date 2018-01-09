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


function reCheckJsFilter(whoChange) {

    var switchJsPattern = ('#sw-list input.switch');

    jQuery('#switchAllBanks > table').removeClass('js-filter-marker');
    jQuery('#switchAllBanks > table').addClass('js-filter-marker');

    $('#switchAllBanks  > table.js-filter-marker').hide();

    if (whoChange !== undefined) {
        if (whoChange.attr('js-filter-run-first') == '0') {
            whoChange.attr('js-filter-run-first', '1');
        }
    }

    jQuery('#sw-list input.switch').each(function () {
        checked = jQuery(this).is(':checked');
        curFilter = jQuery(this).attr('js-filter');
        runFirstMark = jQuery(this).attr('js-filter-run-first');
        switchOnlyValue = jQuery(this).attr('js-filter-switch-only');


        if (runFirstMark === 'undefined') {
            runFilter = 1;
        } else if (runFirstMark === '0') {
            runFilter = 0;
        } else {
            runFilter = 1;
        }

        checkedIndex = 0;
        if (checked === true) {
            checkedIndex = 1;
        }

        if (runFilter) {
            if (switchOnlyValue !== undefined) {
                if (parseInt(switchOnlyValue) === parseInt(checkedIndex)) {
                    $('#switchAllBanks > table.js-filter-marker[' + curFilter + '=' + checkedIndex + ']').show();
                    $('#switchAllBanks > table.js-filter-marker[' + curFilter + '!=' + checkedIndex + ']').hide();
                    $('#switchAllBanks > table.js-filter-marker[' + curFilter + '!=' + checkedIndex + ']').removeClass('js-filter-marker');
                } else {
                    $('#switchAllBanks > table.js-filter-marker[' + curFilter + '=' + checkedIndex + ']').show();
                    $('#switchAllBanks > table.js-filter-marker[' + curFilter + '!=' + checkedIndex + ']').show();
                }
            }
            else {
                if (checked === true) {
                    $('#switchAllBanks > table.js-filter-marker[' + curFilter + '=' + checkedIndex + ']').show();
                    $('#switchAllBanks > table.js-filter-marker[' + curFilter + '!=' + checkedIndex + ']').hide();
                    $('#switchAllBanks > table.js-filter-marker[' + curFilter + '!=' + checkedIndex + ']').removeClass('js-filter-marker');
                } else {
                    $('#switchAllBanks > table.js-filter-marker[' + curFilter + '=' + checkedIndex + ']').show();
                    $('#switchAllBanks > table.js-filter-marker[' + curFilter + '!=' + checkedIndex + ']').hide();
                    $('#switchAllBanks > table.js-filter-marker[' + curFilter + '!=' + checkedIndex + ']').removeClass('js-filter-marker');
                }
            }
        }
    });

    jQuery('#switchAllBanks div.region-id-mark').show();
    jQuery('#switchAllBanks div.region-id-mark').each(function () {
        var howCountryFinalByRegion = jQuery('#switchAllBanks > table.js-filter-marker.' + $(this).attr('id'));
        if(howCountryFinalByRegion.length == 0) {
            $(this).hide();
        }
    });
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
    }, 40000, "linear", function () {
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

var $ticker = $('[data-ticker="list"]'),
    tickerItem = '[data-ticker="item"]'
itemCount = $(tickerItem).length,
    viewportWidth = 0;


$(function () {

    $(".Modern-Slider").slick({
        autoplay: true,
        autoplaySpeed: 10000,
        speed: 600,
        slidesToShow: 1,
        slidesToScroll: 1,
        pauseOnHover: false,
        dots: true,
        pauseOnDotsHover: true,
        cssEase: 'linear',
        // fade:true,
        draggable: false,
        prevArrow: '<button class="PrevArrow"></button>',
        nextArrow: '<button class="NextArrow"></button>'
    });

    $("#clicky").click(function () {
        if ($("#sticky-social").is(':visible')) {
            $("#sticky-social").animate({width: 'hide'});
        }
        else {
            $("#sticky-social").animate({width: 'show'});

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
        //alert($(this).attr('data-show-block'));
        //$('#show-one-el').hide();
        //$('#show-one-el #' + $(this).attr('data-show-block')).show();
        $('#menu-show-block-zone').show();
        $('#menu-show-block-zone .block-zone').hide();
        $('#' + $(this).attr('data-show-block')).show();
        $.scrollTo('#' + $(this).attr('data-show-block'), -250);

        //$('body').scrollTo('#' + $(this).attr('data-show-block'));
    });

    /*dasdasds a*/
    $("a[data-reveal-id]").on('click', function () {

        var curModalSelector = '#' + $(this).attr('data-reveal-id');
        var curModal = $(curModalSelector);

        curModal.dialog({
            title: "",
            modal: true,
            width: "auto",
            maxHeight: "700px",
            closeText: "X",
            // maxWidth: 660, // This won't work
            create: function (event, ui) {
                // Set maxWidth
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




    initializeTicker();


    (function () {
        var cx = '014824414261944164439:sfk3fpa6eoq';
        var gcse = document.createElement('script');
        gcse.type = 'text/javascript';
        gcse.async = true;
        gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(gcse, s);
    })();

    console.log('Its_End_Script');
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