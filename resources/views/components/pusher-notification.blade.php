    {{-- PUSHER NOTIFICATION --}}
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script>
  
     var pusher = new Pusher('10d00ec4fed05fe27b51', {
        cluster: 'ap1',
        encrypted: true
      });
  
      var channel = pusher.subscribe('site-moved');
      channel.bind('App\\Notifications\\SiteMoved', function(data) {
<<<<<<< HEAD
        // alert(data.message);
        alert("Notification received.");
=======
        alert(JSON.stringify(data));      
>>>>>>> 1a61a2e91c0976d17fafe0f7a8e99ab4941da307
      });
    </script>
    {{-- PUSHER NOTIFICATION --}}
