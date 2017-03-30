/**
 * Created by iibarguren on 3/13/17.
 */
function editEvent(event) {
    $('#event-modal input[name="event-index"]').val(event ? event.id : '');
    $('#event-modal input[name="event-name"]').val(event ? event.name : '');
    $('#event-modal input[name="event-type"]').val(event ? event.type : '');
    $('#event-modal input[name="event-hours"]').val(event ? event.hours : '');
    $('#event-modal input[name="event-start-date"]').datepicker('update', event ? event.startDate : '');
    $('#event-modal input[name="event-end-date"]').datepicker('update', event ? event.endDate : '');
    $('#event-modal').modal();
    $('#event-modal').on('shown.bs.modal', function () {
        $('#event-modal input[name="event-name"]').focus()
    })
}

function deleteEvent(event) {
    var dataSource = $('#calendar').data('calendar').getDataSource();

    for(var i in dataSource) {
        if(dataSource[i].id == event.id) {
            dataSource.splice(i, 1);
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
    var dataSource = $('#calendar').data('calendar').getDataSource();

    if(event.id) {
        for(var i in dataSource) {
            if(dataSource[i].id == event.id) {
                dataSource[i].name = event.name;
                dataSource[i].type = event.type;
                dataSource[i].hours = parseFloat(event.hours);
                dataSource[i].color = event.color;
                dataSource[i].startDate = event.startDate;
                dataSource[i].endDate = event.endDate;
            }
        }
    }
    else
    {
        var newId = 0;
        for(var i in dataSource) {
            if(dataSource[i].id > newId) {
                newId = dataSource[i].id;
            }
        }

        newId++;
        event.id = newId;

        // Types array
        var types = [];
        jQuery('.typestype').each(function() {
            var currentElement = $(this);

            var t = {};
            t.id = currentElement.data('id');
            t.name = currentElement.data('name');
            t.color = currentElement.data('color');
            types.push(t)
        });

        // Orduak Birkalkulatzen motaren arabera
        // if ( event.type)

        dataSource.push(event);
    }

    $('#calendar').data('calendar').setDataSource(dataSource);
    $('#event-modal').modal('hide');
}

$(function() {
    var currentYear = new Date().getFullYear();

    $('#calendar').calendar({
        style:'background',
        language: 'eu',
        minDate: new Date('2017-01-01'),
        // disabledWeekDays: [0,7],
        allowOverlap: true,
        // displayWeekNumber: true,
        enableContextMenu: true,
        enableRangeSelection: true,
        contextMenuItems:[
            {
                text: 'Eguneratu',
                click: editEvent
            },
            {
                text: 'Ezabatu',
                click: deleteEvent
            }
        ],
        selectRange: function(e) {
            editEvent({ startDate: e.startDate, endDate: e.endDate });
        },
        mouseOnDay: function(e) {
            if(e.events.length > 0) {
                var content = '';

                for(var i in e.events) {
                    content += '<div class="event-tooltip-content">'
                        + '<div class="event-name" style="color:' + e.events[i].color + '">' + e.events[i].name + '</div>'
                        + '<div class="event-type">' + e.events[i].hours + '</div>'
                        + '</div>';
                }

                $(e.element).popover({
                    trigger: 'manual',
                    container: 'body',
                    html:true,
                    content: content
                });

                $(e.element).popover('show');
            }
        },
        mouseOutDay: function(e) {
            if(e.events.length > 0) {
                $(e.element).popover('hide');
            }
        },
        dayContextMenu: function(e) {
            $(e.element).popover('hide');
        }
    });

    var url = Routing.generate('get_events', { 'calendarid': $('#calendarid').val()});

    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
        success: function (response) {
            var data = [];
            if ( response.length > 0 ) {
                for (var i = 0; i < response.length; i++) {
                    var d = {};
                    d.id = response[i].id;
                    d.name = response[i].name;
                    if ( "type" in response[i] ) {
                        if ( "color" in response[i].type ) {
                            d.color = response[i].type.color;
                        }
                    }
                    d.hours =  parseFloat(response[i].hours);
                    d.startDate = new Date(response[i].start_date);
                    d.endDate = new Date(response[i].end_date);
                    data.push(d);
                }
            }
            $('#calendar').data('calendar').setDataSource(data);
        },
        error: function() {
            console.log("HORROR!!");
        }

    });

    $('#save-event').click(function() {
        // TODO: Validation
        saveEvent();
    });

    $('#btnGrabatu').on('click', function () {

        var datuak = $('#calendar').data('calendar').getDataSource();

        for (var i = 0; i < datuak.length; i++) {

            var url = Routing.generate('post_events');

            var d = {};
            d.calendarid = $('#calendarid').val();
            d.name = datuak[i].name;
            d.startDate = moment(datuak[i].startDate).format("YYYY-MM-DD")
            d.endDate = moment(datuak[i].endDate).format("YYYY-MM-DD")
            d.color = datuak[i].color;
            d.type = datuak[i].type;
            d.hours = parseFloat(datuak[i].hours);

            // var d = JSON.stringify(datuak);
            console.log("*****************************************");
            console.log("POST datuk:");
            console.log(d);
            console.log("*****************************************");


            $.ajax({
                url: url,
                type: 'POST',
                data: JSON.stringify(d),
                contentType: "application/json",
                dataType: "json",
                success: function (e) {
                    console.log(e);
                }
            }).fail(function (xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
            });

        }

    });

});
