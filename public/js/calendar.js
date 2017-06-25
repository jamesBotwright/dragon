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
            $('#start').val(date.format());
            $('#end').val(date.format());
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
            alert("Event: " + calEvent.title + "\n\n"
                + "Description: " + calEvent.description + "\n\n"
                + "Location: " + calEvent.location + "\n\n"
                + "Start: " + new Date(calEvent.start) + "\n\n"
                + "End: " + new Date(calEvent.end) + "\n\n"
            );
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
