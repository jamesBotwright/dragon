/**
 * Bind loading GIF to AJAX events
 * @author James Botwright<james.botwright@glazingvision.co.uk>
 * @version v1.0 18 Jun 2017
 */
$(document).ready(onLoadFunction)
.on('ajaxStart', function(){
    $('.se-pre-con').fadeIn();
})
.on('ajaxStop', function(){
    $('.se-pre-con').fadeOut('slow');
});

/**
 * Initialisation
 * @author James Botwright<james.botwright@glazingvision.co.uk>
 * @version v1.0 18 Jun 2017
 */
function onLoadFunction() {        
    $('#calendar').fullCalendar({
        editable:   true,
        selectable: true,
        height:     550,
        header: {
            left:   'prev,next today',
            center: 'title',
            right:  'month,agendaWeek,agendaDay'
        },
        dayClick:   function(date) {
            $('#start').val(date.format() + 'T12:00');
            $('#end').val(date.format() + 'T12:00');
            $('#add-event-modal').modal({backdrop: 'static', keyboard: false});
        },
        events: '/application/getEvents',
        eventDataTransform: function (rawEventData) {
            return {
                id:             rawEventData.id,
                title:          rawEventData.title,
                description:    rawEventData.description,
                location:       rawEventData.location,
                start:          rawEventData.start,
                end:            rawEventData.end,
                url:            rawEventData.url
            };
        },
        eventClick: function(calEvent, jsEvent, view) {
            $('#event-id').data('id', calEvent.id);
            $('#event-title').text(calEvent.title);
            $('#event-description').text(calEvent.description);
            $('#event-location').text(calEvent.location);
            $('#event-start').text(calEvent.start);
            $('#event-end').text(calEvent.end);
            $('#event-details-modal').modal({backdrop: 'static', keyboard: false});
            return false;
        }
    });
    $(".se-pre-con").fadeOut("slow");
}

/**
 * Add event to dB 
 * @author James Botwright<james.botwright@glazingvision.co.uk>
 * @version v1.0 18 Jun 2017
 */
function addEvent() {
    postAddEventData()
        .done(function() {
            $('#add-event-modal').modal('hide');
        });
}

/**
 * @author James Botwright<james.botwright@glazingvision.co.uk>
 * @version v1.0 25 Jun 2017
 * @param int $eventId
 */
function editEvent() {
    var eventId = $('#event-id').data('id');
    $('#event-details-modal').modal('hide');
    getEventData(eventId)
        .done(function() {
            $('#edit-event-modal').modal({backdrop: 'static', keyboard: false});
        });
    
}

/**
 * @author James Botwright<james.botwright@glazingvision.co.uk>
 * @version v1.0 25 Jun 2017
 * @param int $eventId
 */
function updateEvent(eventId) {
    postEditEventData(eventId)
        .done(function() {
            $('#edit-event-modal').modal('hide');
        });
}

/**
 * Delete event
 * @author James Botwright<james.botwright@glazingvision.co.uk>
 * @version v1.0 25 Jun 2017
 */
function deleteEvent() {
    var result = confirm("Are you sure you want to delete this event?");
    if (result) {
        var eventId = $('#event-id').data('id');
        removeEventAction(eventId)
            .done(function() {
                $('#event-details-modal').modal('hide');
                $('#calendar').fullCalendar('refetchEvents');
            });
    }
}

/**
 * @author James Botwright <jamesb@glazingvision.co.uk>
 * @version v1.0 26-06-17
 * @param int eventId
 */
function removeEventAction(eventId) {
	return $.ajax({
		url: "/application/removeEvent/" + eventId,
		type: "POST",
		success: function(data, textStatus, jXHR) {
		},
		error: function(jXHR, textStatus, errorThrown) {
		}
	});
}

/**
 * POST form data 
 * @author James Botwright<james.botwright@glazingvision.co.uk>
 * @version v1.0 18 Jun 2017
 */
function postAddEventData() {
    return $.ajax({
		url: '/application/addEvent',
		type: "POST",
		data: $('#addEventsForm').serialize(),
		success: function(data, textStatus, jXHR) {
			$('#calendar').fullCalendar('refetchEvents');
		},
		error: function(jXHR, textStatus, errorThrown) {
			if (jXHR.status == 401) {
				$("#add-event-modal").html(jXHR.responseText);
			}
		}
	});
}

/**
 * POST form data 
 * @author James Botwright<james.botwright@glazingvision.co.uk>
 * @version v1.0 18 Jun 2017
 * @param int eventId
 */
function postEditEventData(eventId) {
    return $.ajax({
		url: '/application/editEvent/' + eventId,
		type: "POST",
		data: $('#editEventsForm').serialize(),
		success: function(data, textStatus, jXHR) {
			$('#calendar').fullCalendar('refetchEvents');
		},
		error: function(jXHR, textStatus, errorThrown) {
			if (jXHR.status == 401) {
				$("#edit-event-modal").html(jXHR.responseText);
			}
		}
	});
}

/**
 * GET event data 
 * @author James Botwright<james.botwright@glazingvision.co.uk>
 * @version v1.0 26 Jun 2017
 * @param int eventId
 */
function getEventData(eventId) {
    return $.ajax({
		url: '/application/editEvent/' + eventId,
		type: "GET",
		success: function(data, textStatus, jXHR) {
			$("#edit-event-modal").html(data);
		},
		error: function(jXHR, textStatus, errorThrown) {
            alert('Uh-oh something appears to have gone wrong...');
		}
	});
}

/**
 * Prevent default form action and submit with JS
 * @author James Botwright<james.botwright@glazingvision.co.uk>
 * @version v1.0 18 Jun 2017
 */
$('#addEventsForm').on('submit',function(e) {
	e.preventDefault();
    postAddEventData();
});

/**
 * Prevent default form action and submit with JS
 * @author James Botwright<james.botwright@glazingvision.co.uk>
 * @version v1.0 18 Jun 2017
 */
$('#editEventsForm').on('submit',function(e) {
	e.preventDefault();
    postEditEventData();
});
