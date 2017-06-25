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
        dayClick:   function(date) {
            $('#start').val(date.format() + 'T12:00');
            $('#end').val(date.format() + 'T12:00');
            $('#add-event-modal').modal({backdrop: 'static', keyboard: false});
        },
        events: '/application/getEvents',
        eventDataTransform: function (rawEventData) {
            return {
                id: rawEventData.id,
                title: rawEventData.title,
                description: rawEventData.description,
                location: rawEventData.location,
                start: rawEventData.start,
                end: rawEventData.end,
                url: rawEventData.url
            };
        },
        eventClick: function(calEvent, jsEvent, view) {
            $('#event-title').val(calEvent.title);
            $('#event-description').val(calEvent.description);
            $('#event-location').val(calEvent.location);
            $('#event-title').val(calEvent.start);
            $('#event-title').val(calEvent.end);
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
 * Edit event
 * @author James Botwright<james.botwright@glazingvision.co.uk>
 * @version v1.0 25 Jun 2017
 */
function editEvent() {
    alert('Sorry not implemented yet!');
}

/**
 * Delete event
 * @author James Botwright<james.botwright@glazingvision.co.uk>
 * @version v1.0 25 Jun 2017
 */
function deleteEvent() {
    alert('Sorry not implemented yet!');
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
		data: $('#eventsForm').serialize(),
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
 * Prevent default form action and submit with JS
 * @author James Botwright<james.botwright@glazingvision.co.uk>
 * @version v1.0 18 Jun 2017
 */
$('#eventsForm').on('submit',function(e) {
	e.preventDefault();
    postAddEventData();
});
