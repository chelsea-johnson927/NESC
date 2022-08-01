document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    if(calendarEl){
  
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth', 
        dayMaxEventRows: true,
  
        views: {
          dayGrid: {
            dayMaxEventRows: 2 
          }
        },
        events: function(info,callback){
  
          jQuery.ajax({
            url:soul.ajaxurl,
            type: 'POST',
            data: {
              "action": "calendar",
              "start": info.start.valueOf()/1000,
              "end": info.end.valueOf()/1000, 
             
            },
            success: function (response){
              var events = JSON.parse(response);
  
              console.log(events);
  
              callback(events);
            }
          });
  
        },
      
      
  
        eventDidMount: function(event){
        
          var fullEvent = event.event.start;   
          var eventTime = fullEvent.toLocaleTimeString( [], { hour: '2-digit', minute: '2-digit' });
  
          //var thumb = event.event.thumbnail;   
          
          console.log(event);  
      
  
          //console.log(thumb);
  
          event.el.innerHTML='<ul id="events-list"><li><a href="'+ event.event.url +'">'+ event.event.title + '</a></li><li>'+ 'Begins:'+ eventTime + '</li></ul>'; 
          
  
          
        }
  
      });
  
      calendar.render();
  
  
    }
  
  
  });
  
  
  
  
  