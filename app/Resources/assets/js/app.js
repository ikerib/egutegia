/**
 * Created by iibarguren on 3/13/17.
 */

$(document).ready(function () {

    $(document).on("mouseenter", ".page-header", function () {
        $(".btnPageHeaderEdit").show();
        $(".btnEzabatu").show();
    }).on("mouseleave", ".page-header", function () {
        $(".btnPageHeaderEdit").hide();
        $(".btnEzabatu").hide();
    });

    $('#btnGorde').on('click', function () {
        $('form').submit()
    });

    $('#btnGordeModal').on('click', function () {
        $('form').submit()
    });

    $('.btnPageHeaderEdit').on('click', function () {
        $('#edit-modal').modal()
    });

    $(".dropdown-toggle").dropdown();

    /*****************************************************************************************************************/
    /** ESKAERA NEW  *************************************************************************************************/
    /*****************************************************************************************************************/


    $('#fetxa-inline').datepicker({
        format: "yyyy-mm-dd",
        language: "eu"
    }).on('changeDate', function(event) {
        $('#appbundle_konpentsatuak_fetxa').val(event.format('yyyy-mm-dd'));
    });

    $('#appbundle_konpentsatuak_fetxa').datepicker({
        format: "yyyy-mm-dd",
        language: "eu",
        orientation: "bottom left",
        todayHighlight: true,
        autoclose: true
    });






    /*****************************************************************************************************************/
    /** FIN ESKAERA NEW  *********************************************************************************************/
    /*****************************************************************************************************************/

    /*****************************************************************************************************************/
    /** NOTIFICATION INDEX  ******************************************************************************************/
    /*****************************************************************************************************************/
    $('.btnReaded').on('click', function () {
        const that = this;
        const miid = $(this).data('id')
        const url = Routing.generate('put_jakinarazpena_readed', {'id': miid})
        $.ajax({
            url: url,
            method: 'PUT'
        })
            .done(function (data) {
                if ($(that).children().hasClass('label-danger')) {
                    $(that).html(' <span class="label label-success"> Bai</span>')
                } else {
                    $(that).html(' <span class="label label-danger"> Ez</span>')
                }
            })
            .fail(function (xhr) {
                bootbox.alert('Akats bat gertatu da.')
            })
    })

    $('.btnEskaeraOnartu').on('click', function () {
        const firmaid = $(this).data("firmaid");
        const jakinarazpenaid = $(this).data("notifyid");
        const userid = null;
        const url = Routing.generate("put_firma", { "id": firmaid, "userid": null });
        $.ajax({
            url: url,
            method: 'PUT',
            data: {onartua: 1}
        })
            .done(function (data) {
                const url2 = Routing.generate("put_jakinarazpena", { "id": jakinarazpenaid });
                $.ajax({
                    url: url2,
                    method: 'PUT',
                    data: {onartua: 1}
                }).done(function (data) {
                    console.log(data);
                    location.reload()
                }).fail(function (xhr) {
                    bootbox.alert('Firma egin da baina jakinarazpena irakurria markatzerakoan akatsa bat gertatu da.')
                })
            })
            .fail(function (xhr) {
                bootbox.alert('Akats bat gertatu da firmatzerakoan.')
            });
    });

    $('.btnEskaeraEzOnartu').on('click', function () {
        const firmaid = $(this).data('firmaid');
        const jakinarazpenaid = $(this).data('notifyid');
        const url = Routing.generate('put_firma', {'id': firmaid});
        $.ajax({
            url: url,
            method: 'PUT',
            data: {onartua: 0}
        })
            .done(function (data) {
                const url2 = Routing.generate('put_jakinarazpena', {'id': jakinarazpenaid});
                $.ajax({
                    url: url2,
                    method: 'PUT',
                    data: {onartua: 0}
                }).done(function (data) {
                    location.reload()
                }).fail(function (xhr) {
                    bootbox.alert('Firma egin da baina jakinarazpena irakurria markatzerakoan akatsa bat gertatu da.')
                })
            })
            .fail(function (xhr) {
                bootbox.alert('Akats bat gertatu da firmatzerakoan.')
            })
    });
    /*****************************************************************************************************************/
    /** FIN NOTIFICATION INDEX  **************************************************************************************/
    /*****************************************************************************************************************/


});
