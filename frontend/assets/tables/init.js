/**
 * Created by Vitaliy on 03.01.2017.
 */
jQuery(document).ready(function ($) {
    var table = $('#table-js').DataTable();

    $('#table-js')
        .on( 'mouseenter', 'td', function () {
            var colIdx = table.cell(this).index().column;

            $( table.cells().nodes() ).removeClass( 'highlight' );
            $( table.column( colIdx ).nodes() ).addClass( 'highlight' );
        } );

});