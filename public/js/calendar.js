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
           alert('a day has been clicked!');
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

function addEvent() {
    
}