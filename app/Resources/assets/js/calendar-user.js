/**
 * Created by iibarguren on 3/13/17.
 */

$(function() {
    var currentYear = new Date().getFullYear();

    $('#usercalendar').calendar({
        style:'background',
        language: 'eu',
        minDate: new Date('2017-01-01'),
        // disabledWeekDays: [0,7],
        allowOverlap: true,
        // displayWeekNumber: true,
        enableContextMenu: true,
        enableRangeSelection: true,
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
            $('#usercalendar').data('calendar').setDataSource(data);
        },
        error: function() {
            console.log("HORROR!!");
        }

    });


});
