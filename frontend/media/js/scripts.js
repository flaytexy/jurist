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

/*dasdasds a*/
    $( "a[data-reveal-id]" ).on('click', function () {

        var curModalSelector = '#' + $(this).attr('data-reveal-id');
        var curModal = $(curModalSelector);

        curModal.dialog({
            title: "",
            modal: true,
            width: "auto",
            maxHeight: "700px",
            closeText: "X",
            // maxWidth: 660, // This won't work
            create: function( event, ui ) {
                // Set maxWidth
                $(this).css("maxWidth", "1000px");

            },
            open: function (event, ui) {
                $('.ui-widget-overlay').addClass('custom-overlay');
                //$(this).parent().children().children('.ui-dialog-titlebar-close').hide();
            },
            close: function() {
                $('.ui-widget-overlay').removeClass('custom-overlay');
            }
        });

        return false;
    });



    console.log('Its_End_Script');
});
