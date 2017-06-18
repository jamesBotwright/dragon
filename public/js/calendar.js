/**
 * Fade loading GIF when page loaded
 * @author James Botwright<james.botwright@glazingvision.co.uk>
 * @version v1.0 26 May 2017
 */
$(window).load(function() {
	$(".se-pre-con").fadeOut("slow");
});

/**
* 
* @param {type} param
*/
$(document).ready(onLoadFunction);

/**
* 
* @returns {undefined}
*/
function onLoadFunction() {        
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
       events: '/api',
       eventDataTransform: function (rawEventData) {
           return {
               id: rawEventData.id,
               title: rawEventData.title,
               start: rawEventData.start,
               end: rawEventData.end,
               url: rawEventData.url
           };
       }
   });
}

/**
 * 
 * @returns {undefined}
 */
function addEvent() {
    
}