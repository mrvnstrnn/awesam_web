$(document).ready(() => {
  // $("#calendar-list").fullCalendar({
  //   header: {
  //     left: "prev,next today",
  //     center: "title",
  //     right: "listDay,listWeek,month",
  //   },
  //   themeSystem: "bootstrap4",
  //   bootstrapFontAwesome: true,
  //   views: {
  //     listDay: { buttonText: "list day" },
  //     listWeek: { buttonText: "list week" },
  //   },

  //   defaultView: "listWeek",
  //   defaultDate: "2021-03-12",
  //   navLinks: true,
  //   editable: true,
  //   eventLimit: true,
  //   events: [
  //     {
  //       title: "All Day Event",
  //       start: "2021-03-01",
  //     },
  //     {
  //       title: "Long Event",
  //       start: "2021-03-07",
  //       end: "2021-03-10",
  //     },
  //     {
  //       id: 999,
  //       title: "Repeating Event",
  //       start: "2021-03-09T16:00:00",
  //     },
  //     {
  //       id: 999,
  //       title: "Repeating Event",
  //       start: "2021-03-16T16:00:00",
  //     },
  //     {
  //       title: "Conference",
  //       start: "2021-03-11",
  //       end: "2021-03-13",
  //     },
  //     {
  //       title: "Meeting",
  //       start: "2021-03-12T10:30:00",
  //       end: "2021-03-12T12:30:00",
  //     },
  //     {
  //       title: "Lunch",
  //       start: "2021-03-12T12:00:00",
  //     },
  //     {
  //       title: "Meeting",
  //       start: "2021-03-12T14:30:00",
  //     },
  //     {
  //       title: "Happy Hour",
  //       start: "2021-03-12T17:30:00",
  //     },
  //     {
  //       title: "Dinner",
  //       start: "2021-03-12T20:00:00",
  //     },
  //     {
  //       title: "Birthday Party",
  //       start: "2021-03-13T07:00:00",
  //     },
  //     {
  //       title: "Click for Google",
  //       url: "http://google.com/",
  //       start: "2021-03-28",
  //     },
  //   ],
  // });

  // $("#calendar").fullCalendar({
  //   header: {
  //     left: "prev,next today",
  //     center: "title",
  //     right: "month,basicWeek,basicDay",
  //   },
  //   themeSystem: "bootstrap4",
  //   bootstrapFontAwesome: true,
  //   defaultDate: "2021-03-12",
  //   navLinks: true,
  //   editable: true,
  //   eventLimit: true,
  //   events: [
  //     {
  //       title: "All Day Event",
  //       start: "2021-03-01",
  //     },
  //     {
  //       title: "Long Event",
  //       start: "2021-03-07",
  //       end: "2021-03-10",
  //     },
  //     {
  //       id: 999,
  //       title: "Repeating Event",
  //       start: "2021-03-09T16:00:00",
  //     },
  //     {
  //       id: 999,
  //       title: "Repeating Event",
  //       start: "2021-03-16T16:00:00",
  //     },
  //     {
  //       title: "Conference",
  //       start: "2021-03-11",
  //       end: "2021-03-13",
  //     },
  //     {
  //       title: "Meeting",
  //       start: "2021-03-12T10:30:00",
  //       end: "2021-03-12T12:30:00",
  //     },
  //     {
  //       title: "Lunch",
  //       start: "2021-03-12T12:00:00",
  //     },
  //     {
  //       title: "Meeting",
  //       start: "2021-03-12T14:30:00",
  //     },
  //     {
  //       title: "Happy Hour",
  //       start: "2021-03-12T17:30:00",
  //     },
  //     {
  //       title: "Dinner",
  //       start: "2021-03-12T20:00:00",
  //     },
  //     {
  //       title: "Birthday Party",
  //       start: "2021-03-13T07:00:00",
  //     },
  //     {
  //       title: "Click for Google",
  //       url: "http://google.com/",
  //       start: "2021-03-28",
  //     },
  //   ],
  // });

  // $("#calendar-bg-events").fullCalendar({
  //   header: {
  //     left: "prev,next today",
  //     center: "title",
  //     right: "month,agendaWeek,agendaDay,listMonth",
  //   },
  //   themeSystem: "bootstrap4",
  //   bootstrapFontAwesome: true,
  //   defaultDate: "2021-03-12",
  //   navLinks: true,
  //   businessHours: true,
  //   editable: true,
  //   events: [
  //     {
  //       title: "Business Lunch",
  //       start: "2021-03-03T13:00:00",
  //       constraint: "businessHours",
  //     },
  //     {
  //       title: "Meeting",
  //       start: "2021-03-13T11:00:00",
  //       constraint: "availableForMeeting",
  //       color: "#257e4a",
  //     },
  //     {
  //       title: "Conference",
  //       start: "2021-03-18",
  //       end: "2021-03-20",
  //     },
  //     {
  //       title: "Party",
  //       start: "2021-03-29T20:00:00",
  //     },
  //     {
  //       id: "availableForMeeting",
  //       start: "2021-03-11T10:00:00",
  //       end: "2021-03-11T16:00:00",
  //       rendering: "background",
  //     },
  //     {
  //       id: "availableForMeeting",
  //       start: "2021-03-13T10:00:00",
  //       end: "2021-03-13T16:00:00",
  //       rendering: "background",
  //     },
  //     {
  //       start: "2021-03-24",
  //       end: "2021-03-28",
  //       overlap: false,
  //       rendering: "background",
  //       color: "var(--danger)",
  //     },
  //     {
  //       start: "2021-03-06",
  //       end: "2021-03-08",
  //       overlap: false,
  //       rendering: "background",
  //       color: "var(--success)",
  //     },
  //   ],
  // });

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

            start_date = events[j][k].start_date;
            end_date = events[j][k].end_date +"T23:59:00";

            event_to_display.push({
              start: start_date,
              end: end_date,
              // overlap: true,
              color: "var(--"+color+")",
              title: events[j][k].site_name + " : " + events[j][k].activity_name,
            });
          }
        }

        console.log(event_to_display);

        $("#calendar-bg-events").fullCalendar({
          header: {
            left: "prev,next today",
            center: "title",
            right: "month,agendaWeek,agendaDay,listMonth",
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
