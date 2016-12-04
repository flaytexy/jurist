$(function(){
    $("#menu-show-block").on('click', 'a', function(){
        //alert($(this).attr('data-show-block'));
        //$('#show-one-el').hide();
        //$('#show-one-el #' + $(this).attr('data-show-block')).show();
        $('#menu-show-block-zone').show();
        $('#menu-show-block-zone .block-zone').hide();
        $('#' + $(this).attr('data-show-block')).show();
    });

    console.log('Its_End_Script');
});
