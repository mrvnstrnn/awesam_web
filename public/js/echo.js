// window.Echo.channel('site-endorsement').listen('test', (data) => {
//     // console.log(data);
//     alert('sss');
// });

// window.Echo.channel('site-endorsement')
//     .listen('.SiteEndorsement', (e) => {
//         alert('test');
//   });



  Echo.channel('site-endorsement')
  .listen('.SiteEndorsement', (e) => {
      $('#notif-box').append('<div p-2>' + e.endorsement + '<div class="divider"></div></div>');
  });