    {{-- PUSHER NOTIFICATION --}}
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script>
  
     var pusher = new Pusher('10d00ec4fed05fe27b51', {
        cluster: 'ap1',
        encrypted: true
      });
  
      var channel = pusher.subscribe('site-moved');
      channel.bind('App\\Notifications\\SiteMoved', function(data) 
      
      {
        if(data['message']['user_id'] == {{ \Auth::id() }}){
            var notif = '<div class="vertical-timeline-item vertical-timeline-element">' +
                            '<div>' +
                                '<span class="vertical-timeline-element-icon bounce-in">' +
                                    '<i class="badge badge-dot badge-dot-xl badge-success"> </i>' +
                                '</span>' +
                                '<div class="vertical-timeline-element-content bounce-in">' +
                                    '<h4 class="timeline-title">' + data['message']['title'] + '</h4>' +
                                    '<p><b>' + data['message']['body'] + '</b></p>' +
                                    '<p><small></small></p>' +
                                    '<span class="vertical-timeline-element-date"></span>' +
                                '</div>' +
                          '</div>' +
                        '</div>';
            
            $(".notification_area").prepend(notif);

            $('.counter_notif').html('<span>' + $('.vertical-timeline-item').length + '</span>');

        }

      });
    </script>
    {{-- PUSHER NOTIFICATION --}}
