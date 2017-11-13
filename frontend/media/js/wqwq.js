//Accordian Action
var actionFaq = 'click';
var speedFaq = "500";



$(document).ready(function () {
    $('li.q').on(actionFaq, function () {
        $(this).next().slideToggle(speedFaq)
            .siblings('li.a').slideUp();

        var img = $(this).children('img');
        $('img').not(img).removeClass('rotate');
        img.toggleClass('rotate');
    });
});
