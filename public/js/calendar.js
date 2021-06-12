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

  $.ajax({
    url: "/get-my-calendar",
    method: "GET",
    success: function (resp){
      if(!resp.error){

        var events = [];

        resp.message.forEach(element => {
          events.push({ start: element.timeline })
        });

        console.log(events);
        $("#calendar-bg-events").fullCalendar({
          header: {
            left: "prev,next today",
            center: "title",
            right: "month,agendaWeek,agendaDay,listMonth",
          },
          themeSystem: "bootstrap4",
          bootstrapFontAwesome: true,
          defaultDate: "2021-03-12",
          navLinks: true,
          businessHours: true,
          editable: true,
          events: [
            {
              start: "2021-03-06",
              end: "2021-03-08",
              overlap: false,
              rendering: "background",
              color: "var(--success)",
            },
          ],
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
