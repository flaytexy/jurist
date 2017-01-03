/**
 * Created by Vitaliy on 03.01.2017.
 */
jQuery(document).ready(function ($) {
    $('#table-js').DataTable( {
        "paging":   false,
        "ordering": true,
        "info":     false,
        "searching": false
    } );

    $('#table-js')
        .on( 'mouseenter', 'td', function () {
            var colIdx = table.cell(this).index().column;

            $( table.cells().nodes() ).removeClass( 'highlight' );
            $( table.column( colIdx ).nodes() ).addClass( 'highlight' );
        } );

});