@extends('layouts.main')

@section('content')
@php
    $notif_type = array('All Notifications', 'Unread Notifications');

    if ( $notif_type[1] == 'Unread Notifications') {
        $notifications_badge = \Auth::user()->unreadNotifications;
    } else {
        $notifications_badge = \Auth::user()->notifications;
    }
@endphp
<ul class="tabs-animated body-tabs-animated nav">
    @for ($i = 0; $i < count($notif_type); $i++)
        <li class="nav-item">
            <a role="tab" class="nav-link {{ $i == 0 ? 'active' : '' }}" id="tab-unread" data-toggle="tab" href="#tab-content-{{ strtolower( str_replace(" ", "-", $notif_type[$i]) ) }}">
                <span>{{ $notif_type[$i] }}</span> 
                
                @if ($notif_type[$i] == 'Unread Notifications')
                    @if (count($notifications_badge) > 0)
                        @if (count($notifications_badge) > 99)
                            <div class="parent-badge-{{ strtolower( str_replace(" ", "-", $notif_type[$i]) ) }}">
                                <span class="badge badge-pill badge-danger child-badge-{{ strtolower( str_replace(" ", "-", $notif_type[$i]) ) }}">99+</span>
                            </div>
                        @else
                            <div class="parent-badge-{{ strtolower( str_replace(" ", "-", $notif_type[$i]) ) }}">
                                <span class="badge badge-pill badge-danger child-badge-{{ strtolower( str_replace(" ", "-", $notif_type[$i]) ) }}">{{ count($notifications_badge) }}</span>
                            </div>
                        @endif
                    @endif
                @endif
            </a>
        </li>
    @endfor
</ul>
<div class="tab-content">
    @for ($i = 0; $i < count($notif_type); $i++)
    <div class="tab-pane tabs-animation fade {{ $i == 0 ? 'active show' : '' }}" id="tab-content-{{ strtolower( str_replace(" ", "-", $notif_type[$i]) ) }}" role="tabpanel">
        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                        <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
                        {{ $notif_type[$i] }}
                        </div>      
                    </div>
                    <div class="card-body parent-notif-{{ strtolower( str_replace(" ", "-", $notif_type[$i]) ) }}">
                        <div class="p-3 child-notif-{{ strtolower( str_replace(" ", "-", $notif_type[$i]) ) }}" style="height: 400px; overflow-y: scroll;">
                            <div class="notifications-box">
                                @php
                                    if ( $notif_type[$i] == 'Unread Notifications') {
                                        $notifications = \Auth::user()->unreadNotifications;
                                    } else {
                                        $notifications = \Auth::user()->notifications;
                                    }
                                @endphp
                                @if (count($notifications) > 0)
                                    <div class="vertical-time-simple vertical-without-time vertical-timeline vertical-timeline--one-column">
                                        @foreach ( $notifications as $notification)
                                            @if (is_array($notification->data))
                                                <div class="vertical-timeline-item dot-danger vertical-timeline-element">
                                                    <div><span class="vertical-timeline-element-icon bounce-in"></span>
                                                        <div class="vertical-timeline-element-content bounce-in">
                                                            <h4 class="timeline-title">{{ isset($notification->data['message']['title']) ? $notification->data['message']['title'] : "" }}</h4>
                                                            <p><b>{{ isset($notification->data['message']['body']) ? $notification->data['message']['body'] : "" }}</b></p>
                                                            <p><small>{{ date('M d, Y', strtotime( $notification->created_at )) ." at ". date('H:i:s', strtotime( $notification->created_at )) }}</small></p>
                                                            <span class="vertical-timeline-element-date"></span>
                                                    
                                                            @if ( is_null($notification->read_at) )
                                                                <a href="javascript:void(0)" class="mark_as_read_unread" data-id="{{ $notification->id }}" data-type_notif_1="{{ strtolower( str_replace(" ", "-", $notif_type[0]) ) }}" data-type_notif_2="{{ strtolower( str_replace(" ", "-", $notif_type[1]) ) }}" data-action="read">Mark as read</a>
                                                            @else
                                                                <a href="javascript:void(0)" class="mark_as_read_unread" data-id="{{ $notification->id }}" data-type_notif_1="{{ strtolower( str_replace(" ", "-", $notif_type[0]) ) }}" data-type_notif_2="{{ strtolower( str_replace(" ", "-", $notif_type[1]) ) }}" data-action="unread">Mark as unread</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="vertical-timeline-item dot-danger vertical-timeline-element">
                                                    <div><span class="vertical-timeline-element-icon bounce-in"></span>
                                                        <div class="vertical-timeline-element-content bounce-in">
                                                            <h4 class="timeline-title">{{ $notification->data }}</h4>
                                                            <p><small>{{ date('M d, Y', strtotime( $notification->created_at )) ." at ". date('H:i:s', strtotime( $notification->created_at )) }}</small></p>
                                                            <span class="vertical-timeline-element-date"></span>
                                                    
                                                            @if ( is_null($notification->read_at) )
                                                                <a href="javascript:void(0)" class="mark_as_read_unread" data-id="{{ $notification->id }}" data-type_notif_1="{{ strtolower( str_replace(" ", "-", $notif_type[0]) ) }}" data-type_notif_2="{{ strtolower( str_replace(" ", "-", $notif_type[1]) ) }}" data-action="read">Mark as read</a>
                                                            @else
                                                                <a href="javascript:void(0)" class="mark_as_read_unread" data-id="{{ $notification->id }}" data-type_notif_1="{{ strtolower( str_replace(" ", "-", $notif_type[0]) ) }}" data-type_notif_2="{{ strtolower( str_replace(" ", "-", $notif_type[1]) ) }}" data-action="unread">Mark as unread</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        
                                    </div>
                                @else
                                    <h1 class="text-center">Nothing to see here.</h1>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endfor
    <script>
        $(document).on("click", ".mark_as_read_unread", function (e) {
            e.preventDefault();

            var id = $(this).attr("data-id");
            var type_notif_1 = $(this).attr("data-type_notif_1");
            var type_notif_2 = $(this).attr("data-type_notif_2");
            var action = $(this).attr("data-action");

            console.log("clicked");

            $.ajax({
                url: "/read-notification/"+id+"/"+action,
                method: "GET",
                success: function (resp) {
                    if (!resp.error) {
                        $( ".parent-notif-"+type_notif_1 ).load(window.location.href + " .child-notif-"+type_notif_1 );
                        
                        $( ".parent-notif-"+type_notif_2 ).load(window.location.href + " .child-notif-"+type_notif_2 );
                        
                        $( ".parent-badge-"+type_notif_2 ).load(window.location.href + " .child-badge-"+type_notif_2 );

                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }
                },
                error: function (resp) {
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )
                }
            });
        });
    </script>
</div>
@endsection