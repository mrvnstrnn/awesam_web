$(document).ready(() => {

  $.ajax({
    url: "/get-my-calendar",
    method: "GET",
    success: function (resp){
      if(!resp.error){
        var events = [];

        var event_to_display = [];

        // var colors = [
        //     'success', 'primary', 'secondary',
        //     'danger', 'warning'
        // ];

        resp.message.forEach(element => {
          events.push(JSON.parse(element.timeline));
        });
        
        start_date = "";
        end_date = "";

        var color = "";

        for (let j = 0; j < events.length; j++) {
          if (j == 0 || j == 5) {
            color = "success";
          } else if (j == 1 || j == 6) {
            color = "primary";
          } else if (j == 2 || j == 7) {
            color = "secondary";
          } else if (j == 3 || j == 8) {
            color = "danger";
          } else if (j == 4 || j == 9) {
            color = "warning";
          }

          // var random_color = colors[Math.floor(Math.random() * colors.length)];
          for (let k = 0; k < events[j].length; k++) {

            
          console.log(events[j][k]);
          // console.log(events[j][k]);

            // if (events[j][events[j].length - 1].activity_name != "Completed") {

              start_date = events[j][k].start_date +"T00:00:00";
              end_date = events[j][k].end_date +"T23:59:00";

              event_to_display.push({
                start: start_date,
                end: end_date,
                // overlap: true,
                color: "var(--"+color+")",
                title: events[j][k].site_name + " : " + events[j][k].activity_name,
              });
            }
          // }
        }

        $("#calendar-bg-forecast").fullCalendar({
          header: {
            left: "prev,next today",
            center: "title",
            right: "month,agendaWeek,listMonth",
          },
          themeSystem: "bootstrap4",
          bootstrapFontAwesome: true,
          defaultDate: new Date(),
          navLinks: true,
          displayEventTime: false,
          // businessHours: true,
          // editable: true,
          events: 
            event_to_display
          ,
          // eventRender: function(event, element, calEvent) {
          //   console.log(event);
          //   console.log(element);
          //   console.log(calEvent);
          // }
        });
      } else {
        toastr.error(resp.message);
      }
    },
    error: function (resp){
      toastr.error(resp.message);
    }
  });

  $.ajax({
    url: "/get-my-calendar-activities",
    method: "GET",
    success: function (resp){
      if(!resp.error){
        var events = [];

        var event_to_display = [];

        // var colors = [
        //     'success', 'primary', 'secondary',
        //     'danger', 'warning'
        // ];

        resp.message.forEach(element => {
          events.push(JSON.parse(element.timeline));
        });
        
        start_date = "";
        end_date = "";

        var color = "";

        for (let j = 0; j < events.length; j++) {
          if (j == 0 || j == 5) {
            color = "success";
          } else if (j == 1 || j == 6) {
            color = "primary";
          } else if (j == 2 || j == 7) {
            color = "secondary";
          } else if (j == 3 || j == 8) {
            color = "danger";
          } else if (j == 4 || j == 9) {
            color = "warning";
          }

          // var random_color = colors[Math.floor(Math.random() * colors.length)];
          for (let k = 0; k < events[j].length; k++) {

            
          console.log(events[j][k]);
          // console.log(events[j][k]);

            // if (events[j][events[j].length - 1].activity_name != "Completed") {

              start_date = events[j][k].start_date +"T00:00:00";
              end_date = events[j][k].end_date +"T23:59:00";

              event_to_display.push({
                start: start_date,
                end: end_date,
                // overlap: true,
                color: "var(--"+color+")",
                title: events[j][k].site_name + " : " + events[j][k].activity_name,
              });
            }
          // }
        }

        $("#calendar-bg-activities").fullCalendar({
          header: {
            left: "prev,next today",
            center: "title",
            right: "month,agendaWeek,listMonth",
          },
          themeSystem: "bootstrap4",
          bootstrapFontAwesome: true,
          defaultDate: new Date(),
          navLinks: true,
          displayEventTime: false,
          // businessHours: true,
          // editable: true,
          events: 
            event_to_display
          ,
          // eventRender: function(event, element, calEvent) {
          //   console.log(event);
          //   console.log(element);
          //   console.log(calEvent);
          // }
        });
      } else {
        toastr.error(resp.message);
      }
    },
    error: function (resp){
      toastr.error(resp.message);
    }
  });



});
