function reCheckJsFilter(whoChange) {
    //alert('dasdsa');
    console.log('reCheckJsFilter');
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

$(function () {
// $('input.switch').switcher({copy: {en: {yes: '', no: ''}}});
// reCheckJsFilter();

    $('.switcher').on('click', function(){
        reCheckJsFilter();
    });

// $('input.switch').on('change', function(){
//     alert('sdadsdsa');
//     reCheckJsFilter();
// });
//
// $('input.switch').switcher({copy: {en: {yes: '', no: ''}}}).on('change', function(){
//     alert('sdadsdsa2');
//     reCheckJsFilter();
// });
});

console.log('FINISH_BANKS_JS');
