/**
 * Created by Vitaliy on 05.02.2017.
 */


function reCheckJsFilter (){
    var switchJsPattern = ('#sw-list input.switch');

    jQuery('#switchAllBanks table').removeClass('js-filter-marker');
    jQuery('#switchAllBanks table').addClass('js-filter-marker');

    $('#switchAllBanks table.js-filter-marker').hide();

    jQuery('#sw-list input.switch').each(function(){
        checked = jQuery(this).is(':checked');
        curFilter = jQuery(this).attr('js-filter');



        if(checked===true){
            alert('#switchAllBanks table.js-filter-marker [' + curFilter + '=1]');
            $('#switchAllBanks table.js-filter-marker [' + curFilter + '=1]').show();
            $('#switchAllBanks table.js-filter-marker [' + curFilter + '=0]').hide();
            //$('#switchAllBanks table.js-filter-marker [' + curFilter + '=1]').
            //alert('#switchAllBanks table [' + curFilter + '=1]');
            //jQuery('#switchAllBanks table' + curFilter + '[]').
        }else{
            alert('#switchAllBanks table.js-filter-marker [' + curFilter + '=0]');
            $('#switchAllBanks table.js-filter-marker [' + curFilter + '=0]').show();
            $('#switchAllBanks table.js-filter-marker [' + curFilter + '=1]').hide();
            //alert('#switchAllBanks table [' + curFilter + '=0]');
            //alert(checked);
        }
    });
}




$('#sw-list input.switch').switcher({copy: {en: {yes: '', no: ''}}});
reCheckJsFilter();
$('#sw-list input.switch').on('change', function(){
    reCheckJsFilter();
});






$('#sw-list input.switch').switcher({copy: {en: {yes: '', no: ''}}}).on('change', function(){
        reCheckJsFilter();
        //var checkbox = $(this);

        /*                if ( checkbox.is(':checked') ){
         checkbox.switcher('setDisabled', false);
         if(checkbox.attr('data-act-class')==='byScore'){
         $('#switchAllBanks .byScore').hide();
         $('#switchAllBanks .byScoreOff').show();
         }
         if(checkbox.attr('data-act-class')==='byPersonal'){
         $('#switchAllBanks .byPersonal').show();
         $('#switchAllBanks .byPersonalOff').hide();
         }
         }else{
         //checkbox.switcher('setDisabled', true);
         if(checkbox.attr('data-act-class')==='byScore'){
         $('#switchAllBanks .byScore').show();
         $('#switchAllBanks .byScoreOff').hide();
         }
         if(checkbox.attr('data-act-class')==='byPersonal'){
         $('#switchAllBanks .byPersonal').hide();
         $('#switchAllBanks .byPersonalOff').show();
         }
         }*/
    });
