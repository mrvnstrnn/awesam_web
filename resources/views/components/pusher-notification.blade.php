    {{-- PUSHER NOTIFICATION --}}
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script>
  
     var pusher = new Pusher('69e6d00a89f4405eece3', {
        cluster: 'ap1',
        encrypted: true
      });
  
      var channel = pusher.subscribe('site-moved');
      channel.bind('App\\Notifications\\SiteMoved', function(data) {
        // alert(data.message);
        alert("Notification received.");
      });
    </script>
    {{-- PUSHER NOTIFICATION --}}
