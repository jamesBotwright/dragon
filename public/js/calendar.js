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
       dayClick:   function() {
           alert('a day has been clicked!');
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
