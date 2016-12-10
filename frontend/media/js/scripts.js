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


$(function(){
    $("#menu-show-block, #map-pos").on('click', 'a', function(){
        //alert($(this).attr('data-show-block'));
        //$('#show-one-el').hide();
        //$('#show-one-el #' + $(this).attr('data-show-block')).show();
        $('#menu-show-block-zone').show();
        $('#menu-show-block-zone .block-zone').hide();
        $('#' + $(this).attr('data-show-block')).show();
        $.scrollTo('#' + $(this).attr('data-show-block'), -250);

        //$('body').scrollTo('#' + $(this).attr('data-show-block'));
    });

    console.log('Its_End_Script');
});
