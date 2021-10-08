    {{-- PUSHER NOTIFICATION --}}
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script>
  
     var pusher = new Pusher('10d00ec4fed05fe27b51', {
        cluster: 'ap1',
        encrypted: true
      });
  
      var channel = pusher.subscribe('site-moved');
      channel.bind('App\\Notifications\\SiteMoved', function(data) {
        alert(JSON.stringify(data));      
      });
    </script>
    {{-- PUSHER NOTIFICATION --}}
