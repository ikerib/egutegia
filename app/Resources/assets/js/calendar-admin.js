/**
 * Created by iibarguren on 3/13/17.
 */

function findValueInObjectArray(obj, find) {
    var result = -1;
    $.each(obj, function (k, v) {
        if (v.id === parseInt(find)) {
            result = k;
            return k;
        }
    });
    return result;
}

function hoursCalc(event, ezabatu) {
    // Types array
    var arrTypes = [];
    jQuery('.typestype').each(function () {
        var currentElement = $(this);
        var t = {};
        t.id = currentElement.data('id');
        t.name = currentElement.data('name');
        t.color = currentElement.data('color');
        arrTypes.push(t)
    });
    // Orduak Birkalkulatzen motaren arabera
    var typeIndex = findValueInObjectArray(arrTypes, event.type);
    if (typeIndex === -1) {
        bootbox.alert({
            message: "Egutegi motak ez daude finkatuak",
            className: 'bb-alternate-modal'
        });
    } else {
        var tipoa = arrTypes[typeIndex];
        var hoursYear = parseFloat($('input#appbundle_calendar_hoursYear').val());
        var hoursFree = parseFloat($('input#appbundle_calendar_hoursFree').val());
        var hoursSelf = parseFloat($('input#appbundle_calendar_hoursSelf').val());
        var hoursCompensed = parseFloat($('input#appbundle_calendar_hoursCompensed').val());
        var oldValue = 0;

        if ($('#oldValue').val() !== "") {
            oldValue = parseFloat($('#oldValue').val());
        }

        if (tipoa.name === "Oporrak") {
            if ((ezabatu === 1) || (ezabatu === true)) {
                hoursFree = hoursFree + oldValue;
            } else {
                hoursFree = hoursFree + oldValue - event.hours;
            }

            $('input#appbundle_calendar_hoursFree').val(hoursFree);
            $('#hoursFree').html(hoursFree);
        }

        if (tipoa.name === "Norberarentzako") {
            if ((ezabatu === 1) || (ezabatu === true)) {
                hoursSelf = hoursSelf + oldValue;
            } else {
                hoursSelf = hoursSelf + oldValue - event.hours;
            }
            $('input#appbundle_calendar_hoursSelf').val(hoursSelf);
            $('#hoursSelf').html(hoursSelf);
        }

        if (tipoa.name === "Konpentsatuak") {
            if ((ezabatu === 1) || (ezabatu === true)) {
                hoursCompensed = hoursCompensed + oldValue;
            } else {
                hoursCompensed = hoursCompensed + oldValue - event.hours;
            }
            $('input#appbundle_calendar_hoursCompensed').val(hoursCompensed);
            $('#hoursCompensed').html(hoursCompensed);
        }

    }
}

function editEvent(event) {
    $('#event-modal input[name="event-index"]').val(event ? event.id : '');
    $('#event-modal input[name="event-name"]').val(event ? event.name : '');
    $('#event-modal input[name="event-type"]').val(event ? event.type : '');
    $('#event-modal input[name="event-hours"]').val(event ? event.hours : '');
    $('#event-modal input[name="event-start-date"]').datepicker('update', event ? event.startDate : '');
    $('#event-modal input[name="event-end-date"]').datepicker('update', event ? event.endDate : '');

    $('#oldValue').val(event ? event.hours : 0);

    $('#cmbTypeSelect').val(event ? event.type : '');

    if ( event ) {
        if ( event.type === undefined ) {
            $('#cmbTypeSelect').val("-1");
        }
    }

    $('#event-modal').modal();
    $('#event-modal').on('shown.bs.modal', function () {
        $('#event-modal input[name="event-name"]').focus()
    })
}

function deleteEvent(event) {
    var dataSource = $('#calendar').data('calendar').getDataSource();

    for (var i in dataSource) {
        if (dataSource[i].id == event.id) {
            dataSource.splice(i, 1);
            $('#oldValue').val(event ? event.hours : 0);
            hoursCalc(event, true);
            break;
        }
    }


    $('#calendar').data('calendar').setDataSource(dataSource);
}

function saveEvent() {
    var event = {
        id: $('#event-modal input[name="event-index"]').val(),
        name: $('#event-modal input[name="event-name"]').val(),
        type: $('#event-modal option:selected').val(),
        hours: $('#event-modal input[name="event-hours"]').val(),
        color: $('#event-modal option:selected').data('color'),
        startDate: $('#event-modal input[name="event-start-date"]').datepicker('getDate'),
        endDate: $('#event-modal input[name="event-end-date"]').datepicker('getDate')
    };

    // Data Validation
    if ( event.name.length === 0 ) {
        bootbox.alert("Izena jartzea beharrezkoa da.");
        return;
    }
    if ( event.type === "-1" ) {
        bootbox.alert("Mota zehaztea beharrezkoa da.");
        return;
    }
    if ( event.hours.length === 0 ) {
        event.hours = 0;
    } else {
        if ($.isNumeric (event.hours) === false) {
            bootbox.alert("Ordu kopuruak zenbakia izan behar du.");
            return;
        }
    }
    if ( (Date.parse(event.startDate)===false) || ( Date.parse(event.endDate)===false ) ) {
        bootbox.alert("Hasiera eta amaiera datak zehaztea beharrezkoa da, edo ez dute formatu egokia.");
        return;
    }

    var dataSource = $('#calendar').data('calendar').getDataSource();

    if (event.id) {
        for (var i in dataSource) {
            if (dataSource[i].id == event.id) {
                dataSource[i].name = event.name;
                dataSource[i].type = event.type;
                dataSource[i].hours = parseFloat(event.hours);
                dataSource[i].color = event.color;
                dataSource[i].startDate = event.startDate;
                dataSource[i].endDate = event.endDate;
                hoursCalc(event);
            }
        }
    }
    else {
        var newId = 0;
        for (var i in dataSource) {
            if (dataSource[i].id > newId) {
                newId = dataSource[i].id;
            }
        }

        newId++;
        event.id = newId;

        hoursCalc(event);

        dataSource.push(event);
    }

    $('#calendar').data('calendar').setDataSource(dataSource);
    $('#event-modal').modal('hide');
}

$(function () {
    var currentYear = new Date().getFullYear();

    $('#calendar').calendar({
        style: 'background',
        language: 'eu',
        minDate: new Date('2017-01-01'),
        // disabledWeekDays: [0,7],
        allowOverlap: true,
        // displayWeekNumber: true,
        enableContextMenu: true,
        enableRangeSelection: true,
        contextMenuItems: [
            {
                text: 'Eguneratu',
                click: editEvent
            },
            {
                text: 'Ezabatu',
                click: deleteEvent
            }
        ],
        selectRange: function (e) {
            editEvent({startDate: e.startDate, endDate: e.endDate});
        },
        mouseOnDay: function (e) {
            if (e.events.length > 0) {
                var content = '';

                for (var i in e.events) {
                    content += '<div class="event-tooltip-content">'
                        + '<div class="event-name" style="color:' + e.events[i].color + '">' + e.events[i].name + '</div>'
                        + '<div class="event-type">' + "Orduak: " + e.events[i].hours + '</div>'
                        + '</div>';
                }

                $(e.element).popover({
                    trigger: 'manual',
                    container: 'body',
                    html: true,
                    content: content
                });

                $(e.element).popover('show');
            }
        },
        mouseOutDay: function (e) {
            if (e.events.length > 0) {
                $(e.element).popover('hide');
            }
        },
        dayContextMenu: function (e) {
            $(e.element).popover('hide');
        }
    });

    var url = Routing.generate('get_events', {'calendarid': $('#calendarid').val()});

    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
        success: function (response) {
            var data = [];
            if (response.length > 0) {
                for (var i = 0; i < response.length; i++) {
                    var d = {};
                    d.id = response[i].id;
                    d.name = response[i].name;
                    if ("type" in response[i]) {
                        if ("color" in response[i].type) {
                            d.color = response[i].type.color;
                            d.type = response[i].type.id;
                        }
                    }
                    d.hours = parseFloat(response[i].hours);
                    d.startDate = new Date(response[i].start_date);
                    d.endDate = new Date(response[i].end_date);
                    data.push(d);
                }
            }
            $('#calendar').data('calendar').setDataSource(data);
        },
        error: function () {
            console.log("HORROR!!");
        }

    });

    $('#save-event').click(function () {
        // TODO: Validation
        saveEvent();
    });

    $('#btnGrabatu').on('click', function () {
        var calendarid = $('#calendarid').val();
        var akatsa = 0;
        // first I backup and remove all calendar events
        var url = Routing.generate('backup_events', {'calendarid': calendarid});

        function waitUntilComplete() {
            return $.ajax({
                url: url,
                type: 'POST',
                success: function () {

                    // Now I save all the events in the given calendar
                    var datuak = $('#calendar').data('calendar').getDataSource();


                    for (var i = 0; i < datuak.length && akatsa === 0; i++) {

                        var url = Routing.generate('post_events');

                        var d = {};
                        d.calendarid = calendarid;
                        d.name = datuak[i].name;
                        d.startDate = moment(datuak[i].startDate).format("YYYY-MM-DD")
                        d.endDate = moment(datuak[i].endDate).format("YYYY-MM-DD")
                        d.color = datuak[i].color;
                        d.type = datuak[i].type;
                        d.hours = parseFloat(datuak[i].hours);

                        return $.ajax({
                            url: url,
                            async:false,
                            type: 'POST',
                            data: JSON.stringify(d),
                            contentType: "application/json",
                            dataType: "json"
                        }).fail(function (xhr, status, error) {
                            // bootbox.alert("Arazo bat egon da 'event' bat grabatzerakoan. Ez dira datu guztiak ongi gorde.");
                            // console.log(xhr);
                            // console.log(status);
                            // console.log(error);
                            akatsa = 1;
                            return;
                        });

                    }
                }
            }).fail(function (xhr, status, error) {
                // bootbox.alert("Arazo bat egon da egutegia historikora pasatzerakoan.");
                // console.log(xhr);
                // console.log(status);
                // console.log(error);
                akatsa = 1;
                return;
            })
        }

        $.when(waitUntilComplete()).done(function (e) {
            // console.log("COMPLETED!!!");
            // console.log(e);
            // console.log("COMPLETED!!!");
            // console.log(akatsa);
            $("#myAlert").hide();
            if (akatsa === 1) {
                $('#alertSpot').append(
                    '<div id="myAlert" class="alert alert-danger alert-dismissible" role="alert">' +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                    '<strong>Arazo</strong> bat egon da eta datuak ezin izan dira grabatu.');
            } else {
                $('#alertSpot').append(
                    '<div id="myAlert" class="alert alert-success alert-dismissible" role="alert">' +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                    'Datuak <strong>ongi</strong> grabatuak izan dira.');
            }

            $("#myAlert").alert();
            $("#myAlert").fadeTo(2000, 500).slideUp(500, function () {
                $("#myAlert").slideUp(500);
            });
        })

    });

});
