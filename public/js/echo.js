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
      alert(e);
  });