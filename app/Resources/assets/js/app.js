/**
 * Created by iibarguren on 3/13/17.
 */

$( document ).ready(function() {

    $(document).on('mouseenter', '.page-header', function () {
        $('.btnPageHeaderEdit').show();
    }).on('mouseleave', '.page-header', function () {
        $('.btnPageHeaderEdit').hide();
    });

    $('#btnGorde').on('click', function() {
        $('form').submit();
    });
    $('#btnGordeModal').on('click', function() {
        $('form').submit();
    });

    $('.btnPageHeaderEdit').on('click', function () {
        $('#edit-modal').modal();
    });

    $('.dropdown-toggle').dropdown()

});