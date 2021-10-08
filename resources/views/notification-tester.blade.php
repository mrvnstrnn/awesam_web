<!DOCTYPE html>
<head>
  <title>Laravel 8 Pusher Notification Example Tutorial - XpertPhp</title>
  <h1>Laravel 8 Pusher Notification Example Tutorial</h1>
  <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
  <script>

   var pusher = new Pusher('69e6d00a89f4405eece3', {
      cluster: 'ap1',
      encrypted: true
    });

    var channel = pusher.subscribe('site-moved');
    channel.bind('App\\Events\\SiteMovedEvent', function(data) {
      alert(data.message);
    });
  </script>
</head>