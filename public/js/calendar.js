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
    $(".se-pre-con").fadeOut("slow");
    $('#calendar').fullCalendar({
       editable:   true,
       selectable: true,
       height:     450,
       dayClick:   function() {
           $('#addEventModal').modal({backdrop: 'static', keyboard: false});
       },
//            select:     function() {
//                alert('selected!');
//            },
//       events: '/api',
//       eventDataTransform: function (rawEventData) {
//           return {
//               id: rawEventData.id,
//               title: rawEventData.title,
//               start: rawEventData.start,
//               end: rawEventData.end,
//               url: rawEventData.url
//           };
//       }
   });
}

/**
 * Add event to dB 
 * @author James Botwright<james.botwright@glazingvision.co.uk>
 * @version v1.0 18 Jun 2017
 */
function addEvent() {
    postAddEventData();
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
			
		},
		error: function(jXHR, textStatus, errorThrown) {
			if (jXHR.status == 401) {
				$("#addEventModal").html(jXHR.responseText);
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
