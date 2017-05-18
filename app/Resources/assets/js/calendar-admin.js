/**
 * Created by iibarguren on 3/13/17.
 */

$(function () {

  function workday_count (fstart, fend) {
    var start = moment(fstart)
    var end = moment(fend)
    var first = start.clone().endOf('week'); // end of first week
    var last = end.clone().startOf('week'); // start of last week
    var days = Math.floor(last.diff(first,'days') * 5 / 7); // this will always multiply of 7
    var wfirst = first.day() - start.day(); // check first week
    if(start.day() == 0) --wfirst; // -1 if start with sunday
    var wlast = end.day() - last.day(); // check last week
    if(end.day() == 6) --wlast; // -1 if end with saturday
    return wfirst + days + wlast; // get the total
  }

  function editEvent (event) {
    if ( event.istemplate === 1) {
      bootbox.alert({
        message: "Txantiloiaren parte da, ezin da eguneratu",
        size: 'small'
      });
      return -1
    }

    $('#event-modal input[name="event-index"]').val(event ? event.id : '')
    $('#event-modal input[name="event-name"]').val(event ? event.name : '')
    $('#event-modal input[name="event-type"]').val(event ? event.type : '')
    $('#event-modal input[name="event-hours"]').val(event ? event.hours : '')
    $('#event-modal input[name="event-start-date"]').datepicker('update', event ? event.startDate : '')
    $('#event-modal input[name="event-end-date"]').datepicker('update', event ? event.endDate : '')
    $('#txtOldValue').val(event ? event.hours : '')
    $('#txtOldType').val(event ? event.type : '')

    $('#oldValue').val(event ? event.hours : 0)

    $('#cmbTypeSelect').val(event ? event.type : '')

    if (event) {
      if (event.type === undefined) {
        $('#cmbTypeSelect').val('-1')
      }
    }

    // Number of working days selected
    var d = workday_count(event.startDate, event.endDate)
    $('#txtWorkingDaysSelected').val(d.toFixed(2))
    var j = $('#txtTotalHousSelected').data('jornada')

    var t = d * parseFloat(j)

    $('#txtTotalHousSelected').val(t.toFixed(2))
    $('#event-modal').modal()
    $('#event-modal').on('shown.bs.modal', function () {
      $('#event-modal input[name="event-name"]').focus()
    })
  }

  function deleteEvent (event) {
    var dataSource = $('#calendar').data('calendar').getDataSource()

    for (var i in dataSource) {
      if (dataSource[i].id === event.id) {
        // dataSource.splice(i, 1)
        // $('#oldValue').val(event ? event.hours : 0)
        //
        // break
        var deleteCalendarEvents = function () {
          var url = Routing.generate('delete_events', { 'id': event.id })
          return $.ajax({
            url:url,
            type: 'DELETE',
            data: JSON.stringify(event),
            dataType: 'json',
            success: function(response) {
              return response
            },
            error: function() {
              console.log ("ERROR!")
              return -1
            }
          })
        }

        $.when(deleteCalendarEvents()).done(function(a1){
          location.reload()
        }). fail(function (error){
          $('#myAlert').hide()

          $('#alertSpot').append(
            '<div id="myAlert" class="alert alert-danger alert-dismissible" role="alert">' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
            '<strong>Arazo</strong> bat egon da eta datuak ezin izan dira grabatu.')


          $('#myAlert').alert()
          $('#myAlert').fadeTo(2000, 500).slideUp(500, function () {
            $('#myAlert').slideUp(500)
          })
          $('#divTimelineAlert').show()
        })




      }
    }

    $('#calendar').data('calendar').setDataSource(dataSource)
  }

  function saveEvent () {
    var event = {
      id: $('#event-modal input[name="event-index"]').val(),
      name: $('#event-modal input[name="event-name"]').val(),
      type: $('#event-modal option:selected').val(),
      hours: $('#event-modal input[name="event-hours"]').val(),
      color: $('#event-modal option:selected').data('color'),
      startDate: $('#event-modal input[name="event-start-date"]').datepicker('getDate'),
      endDate: $('#event-modal input[name="event-end-date"]').datepicker('getDate'),
      oldValue: $('#txtOldValue').val(),
      oldType: $('#txtOldType').val()
    }

    // Data Validation
    if (event.name.length === 0) {
      bootbox.alert('Izena jartzea beharrezkoa da.')
      return
    }
    if (event.type === '-1') {
      bootbox.alert('Mota zehaztea beharrezkoa da.')
      return
    }
    if (event.hours.length === 0) {
      event.hours = 0
    } else {
      if ($.isNumeric(event.hours) === false) {
        bootbox.alert('Ordu kopuruak zenbakia izan behar du.')
        return
      }
    }
    if ((Date.parse(event.startDate) === false) || ( Date.parse(event.endDate) === false )) {
      bootbox.alert('Hasiera eta amaiera datak zehaztea beharrezkoa da, edo ez dute formatu egokia.')
      return
    }

    var dataSource = $('#calendar').data('calendar').getDataSource()

    if (event.id) {
      for (var i in dataSource) {
        if (dataSource[i].id == event.id) {
          dataSource[i].name = event.name
          dataSource[i].type = event.type
          dataSource[i].hours = parseFloat(event.hours)
          dataSource[i].color = event.color
          dataSource[i].startDate = event.startDate
          dataSource[i].endDate = event.endDate
          // hoursCalc(event);
        }
      }

      // Aldaketak gorde
      event.calendarid = $('#calendarid').val()

      var putCalendarEvents = function () {
        var url = Routing.generate('put_event', { 'id': event.id })
        return $.ajax({
          url:url,
          type: 'PUT',
          data: JSON.stringify(event),
          dataType: 'json',
          success: function(response) {
            return response
          },
          error: function() {
            console.log ("ERROR!")
            return -1
          }
        })
      }

      $.when(putCalendarEvents()).done(function(a1){
        location.reload()
      }). fail(function (error){
        $('#myAlert').hide()

        $('#alertSpot').append(
          '<div id="myAlert" class="alert alert-danger alert-dismissible" role="alert">' +
          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
          '<strong>Arazo</strong> bat egon da eta datuak ezin izan dira grabatu.')


        $('#myAlert').alert()
        $('#myAlert').fadeTo(2000, 500).slideUp(500, function () {
          $('#myAlert').slideUp(500)
        })
        $('#divTimelineAlert').show()
      })


    }
    else {
      var newId = 0
      for (var i in dataSource) {
        if (dataSource[i].id > newId) {
          newId = dataSource[i].id
        }
      }

      newId++
      event.id = newId

      /**
       * Gore datu basean
       */
      event.calendarid = $('#calendarid').val()

      var saveCalendarEvents = function () {
        var url = Routing.generate('post_events')
        return $.ajax({
          url:url,
          type: 'POST',
          data: JSON.stringify(event),
          dataType: 'json',
          success: function(response) {
            return response
          },
          error: function() {
            console.log ("ERROR!")
            return -1
          }
        })
      }

      $.when(saveCalendarEvents()).done(function(a1){
        location.reload()
      }). fail(function (error){
        $('#myAlert').hide()

        $('#alertSpot').append(
            '<div id="myAlert" class="alert alert-danger alert-dismissible" role="alert">' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
            '<strong>Arazo</strong> bat egon da eta datuak ezin izan dira grabatu.')


        $('#myAlert').alert()
        $('#myAlert').fadeTo(2000, 500).slideUp(500, function () {
          $('#myAlert').slideUp(500)
        })
        $('#divTimelineAlert').show()
      })

    }

    $('#calendar').data('calendar').setDataSource(dataSource)
    $('#event-modal').modal('hide')

    return -1
  }

  var currentYear = new Date().getFullYear()
  var minYear = new Date(currentYear,0,1)
  var maxYear = new Date(currentYear+1,0,7)


  $('#calendar').calendar({
    // style: 'background',
    language: 'eu',
    // minDate: new Date('2017-01-01'),
    minDate: minYear,
    maxDate: maxYear,
    disabledWeekDays: [6, 0],
    allowOverlap: true,
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
      editEvent({startDate: e.startDate, endDate: e.endDate})
    },
    mouseOnDay: function (e) {
      if (e.events.length > 0) {
        var content = ''

        for (var i in e.events) {
          content += '<div class="event-tooltip-content">'
            + '<div class="event-name" style="color:' + e.events[i].color + '">' + e.events[i].name + '</div>'
            + '<div class="event-type">' + 'Orduak: ' + e.events[i].hours + '</div>'
            + '</div>'
        }

        $(e.element).popover({
          trigger: 'manual',
          container: 'body',
          html: true,
          content: content
        })

        $(e.element).popover('show')
      }
    },
    mouseOutDay: function (e) {
      if (e.events.length > 0) {
        $(e.element).popover('hide')
      }
    },
    dayContextMenu: function (e) {
      $(e.element).popover('hide')
    }
  })

  var getAjaxEvents = function () {
    var url = Routing.generate('get_events', {'calendarid': $('#calendarid').val()})
    return $.ajax({
      url: url,
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        var data = []
        if (response.length > 0) {
          for (var i = 0; i < response.length; i++) {
            var d = {}
            d.id = response[i].id
            d.name = response[i].name
            if ('type' in response[i]) {
              if ('color' in response[i].type) {
                d.color = response[i].type.color
                d.type = response[i].type.id
              }
            }
            d.hours = parseFloat(response[i].hours)
            d.startDate = new Date(response[i].start_date)
            d.endDate = new Date(response[i].end_date)
            data.push(d)
          }
        }
        return data
        // $('#calendar').data('calendar').setDataSource(data);
      },
      error: function () {
        return -1
        console.log('HORROR!!')
      }

    })
  }

  var getAjaxTemplateEvents = function () {
    var tmpl = $('#templateid').val()
    if (tmpl === -1) {
      console.log('ez du template-rik')
      return -1
    }
    var url2 = Routing.generate('get_template_events', {'templateid': tmpl})
    return $.ajax({
      url: url2,
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        var data = []
        if (response.length > 0) {
          for (var i = 0; i < response.length; i++) {
            var d = {}
            d.id = response[i].id
            d.name = response[i].name
            if ('type' in response[i]) {
              if ('color' in response[i].type) {
                d.color = response[i].type.color
                d.type = response[i].type.id
              }
            }
            d.hours = parseFloat(response[i].hours)
            d.startDate = new Date(response[i].start_date)
            d.endDate = new Date(response[i].end_date)
            d.templateid = response[i].template.id
            data.push(d)
          }
        }
        // $('#calendar').data('calendar').setDataSource(data);
        return data
      },
      error: function () {
        return -1
      }

    })
  }

  $.when(getAjaxTemplateEvents(), getAjaxEvents()).done(function (a1, a2) {
    var resp = []
    // Check if template is set
    var tmpl = a1[0]

    if (tmpl.length > 0) { // Template is set
      for (var i = 0; i < tmpl.length; i++) {
        var d = {}
        d.id = tmpl[i].id
        d.name = tmpl[i].name
        if ('type' in tmpl[i]) {
          if ('color' in tmpl[i].type) {
            d.color = tmpl[i].type.color;
            // d.color = '#3a4d57'
            d.type = tmpl[i].type.id
          }
        }
        d.hours = parseFloat(tmpl[i].hours)
        d.startDate = new Date(tmpl[i].start_date)
        d.endDate = new Date(tmpl[i].end_date)
        d.istemplate = 1

        resp.push(d)
      }
    }

    var eve = a2[0] // Events
    for (var j = 0; j < eve.length; j++) {
      var d2 = {}
      d2.id = eve[j].id
      d2.name = eve[j].name
      if ('type' in eve[j]) {
        if ('color' in eve[j].type) {
          d2.color = eve[j].type.color
          d2.type = eve[j].type.id
        }
      }
      d2.hours = parseFloat(eve[j].hours)
      d2.startDate = new Date(eve[j].start_date)
      d2.endDate = new Date(eve[j].end_date)
      d2.istemplate = 0

      resp.push(d2)
    }

    $('#calendar').data('calendar').setDataSource(resp)

  })

  $('#save-event').on('click', function () {
    return saveEvent()
  })

  $('#btnGrabatu').on('click', function () {
    var calendarid = $('#calendarid').val()
    var akatsa = 0
    // first I backup and remove all calendar events
    var url = Routing.generate('backup_events', {'calendarid': calendarid})

    function waitUntilComplete () {
      return $.ajax({
        url: url,
        type: 'POST',
        success: function () {

          // Now I save all the events in the given calendar
          var datuak = $('#calendar').data('calendar').getDataSource()

          for (var i = 0; i < datuak.length && akatsa === 0; i++) {

            if (datuak[i].istemplate === undefined) {
              datuak[i].istemplate = 0
            }

            if (datuak[i].istemplate === 0) { // Template Events are not saved
              var url = Routing.generate('post_events')

              var d = {}
              d.calendarid = calendarid
              d.name = datuak[i].name
              d.startDate = moment(datuak[i].startDate).format('YYYY-MM-DD')
              d.endDate = moment(datuak[i].endDate).format('YYYY-MM-DD')
              d.color = datuak[i].color
              d.type = datuak[i].type
              d.hours = parseFloat(datuak[i].hours)

              console.log('POST!')
              console.log(d)

              $.ajax({
                url: url,
                async: false,
                type: 'POST',
                data: JSON.stringify(d),
                contentType: 'application/json',
                dataType: 'json'
              }).fail(function (xhr, status, error) {
                akatsa = 1
                return
              })
            }
          }
        }
      }).fail(function (xhr, status, error) {
        akatsa = 1
        return
      })
    }

    $.when(waitUntilComplete()).done(function (e) {
      $('#myAlert').hide()
      if (akatsa === 1) {
        $('#alertSpot').append(
          '<div id="myAlert" class="alert alert-danger alert-dismissible" role="alert">' +
          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
          '<strong>Arazo</strong> bat egon da eta datuak ezin izan dira grabatu.')
      } else {
        $('#alertSpot').append(
          '<div id="myAlert" class="alert alert-success alert-dismissible" role="alert">' +
          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
          'Datuak <strong>ongi</strong> grabatuak izan dira.')
      }

      $('#myAlert').alert()
      $('#myAlert').fadeTo(2000, 500).slideUp(500, function () {
        $('#myAlert').slideUp(500)
      })
      $('#divTimelineAlert').show()

    })

  })

  $('#btnEzabatu').on('click', function () {
    bootbox.confirm({
      message: 'Ziur zaude Egutegia ezabatu nahi duzula?',
      buttons: {
        confirm: {
          label: 'Bai',
          className: 'btn-success'
        },
        cancel: {
          label: 'Ez',
          className: 'btn-danger'
        }
      },
      callback: function (result) {
        if (result === true) {
          $('#frmDelCalendar').submit()
        }
      }
    })
  })

})
