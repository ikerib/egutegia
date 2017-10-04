/**
 * Created by iibarguren on 3/13/17.
 */

$(document).ready(function () {

    $(document).on('mouseenter', '.page-header', function () {
        $('.btnPageHeaderEdit').show();
        $('.btnEzabatu').show()
    }).on('mouseleave', '.page-header', function () {
        $('.btnPageHeaderEdit').hide();
        $('.btnEzabatu').hide()
    })

    $('#btnGorde').on('click', function () {
        $('form').submit()
    });

    $('#btnGordeModal').on('click', function () {
        $('form').submit()
    });

    $('.btnPageHeaderEdit').on('click', function () {
        $('#edit-modal').modal()
    });

    $('.dropdown-toggle').dropdown()

    /*****************************************************************************************************************/
    /** ESKAERA NEW  *************************************************************************************************/

    /*****************************************************************************************************************/
    function workday_count(fstart, fend) {
        const start = moment(fstart);
        const end = moment(fend);
        const first = start.clone().endOf('week'); // end of first week
        const last = end.clone().startOf('week'); // start of last week
        const days = Math.floor(last.diff(first, 'days') * 5 / 7); // this will always multiply of 7

        var wfirst = first.day() - start.day(); // check first week
        if (start.day() === 0) --wfirst; // -1 if start with sunday

        var wlast = end.day() - last.day(); // check last week
        if (end.day() === 6) --wlast; // -1 if end with saturday

        return wfirst + days + wlast; // get the total
    }


    $('#appbundle_eskaera_hasi').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        language: 'eu'
    });

    $('#appbundle_eskaera_amaitu').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        language: 'eu'
    });

    $('#appbundle_eskaera_noiz').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        language: 'eu'
    });

    $('.cmbFetxaKalc').change(function () {
        const hasi = $('#appbundle_eskaera_hasi').val()
        const amaitu = $('#appbundle_eskaera_amaitu').val()
        const d = workday_count(hasi, amaitu)

        $('#appbundle_eskaera_orduak').val(d.toFixed(2))
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
        const firmaid = $(this).data('firmaid')
        const jakinarazpenaid = $(this).data('notifyid')
        const url = Routing.generate('put_firma', {'id': firmaid})
        $.ajax({
            url: url,
            method: 'PUT',
            data: {onartua: 1}
        })
            .done(function (data) {
                const url2 = Routing.generate('put_jakinarazpena', {'id': jakinarazpenaid})
                $.ajax({
                    url: url2,
                    method: 'PUT',
                    data: {onartua: 1}
                }).done(function (data) {
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