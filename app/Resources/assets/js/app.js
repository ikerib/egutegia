/**
 * Created by iibarguren on 3/13/17.
 */

$( document ).ready(function() {
    $('#btnGorde').on('click', function() {

        $('form').submit();
    });

    $('.btnPageHeaderEdit').on('click', function () {
        $('#edit-modal').modal();
    });

});