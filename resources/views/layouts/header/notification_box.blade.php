<div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right">
@php
    $notifications = \Auth::user()->unreadNotifications;
@endphp
<div class="dropdown-menu-header mb-0">
    <div class="dropdown-menu-header-inner bg-deep-blue">
        <div class="menu-header-image opacity-1" style="background-image: url('images/dropdown-header/city3.jpg');"></div>
        <div class="menu-header-content text-dark">
            <h5 class="menu-header-title">Notifications</h5>
            <h6 class="menu-header-subtitle">You have
                <b class="counter_notif"><span>{{ count($notifications) }}</span></b> unread notifications
            </h6>
        </div>
    </div>
</div>
<div id="notif-box">
    <div class="scroll-area-sm">
        <div class="scrollbar-container ps">
            <div class="p-3 scroll-area-sm">
                <div class="vertical-without-time vertical-timeline vertical-timeline--animate vertical-timeline--one-column notification_area">
                    @foreach ( $notifications as $notification)
                        @if (is_array($notification->data))
                            <div class="vertical-timeline-item vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in">
                                        <i class="badge badge-dot badge-dot-xl badge-success"> </i>
                                    </span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <h4 class="timeline-title">{{ isset($notification->data['sam_id']) ? $notification->data['sam_id'] : "" }}</h4>
                                        <p><b>{{ isset($notification->data['message']) ? $notification->data['message'] : "" }}</b></p>
                                        <p><small>{{ date('M d, Y', strtotime( $notification->created_at )) ." at ". date('H:i:s', strtotime( $notification->created_at )) }}</small></p>
                                        <span class="vertical-timeline-element-date"></span>
                                
                                        <a href="javascript:void(0)" class="mark_as_unread" data-id="{{ $notification->id }}" data-action="read">Mark as read</a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="vertical-timeline-item vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in">
                                        <i class="badge badge-dot badge-dot-xl badge-success"> </i>
                                    </span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <h4 class="timeline-title">{{ $notification->data }}</h4>
                                        <p><small>{{ date('M d, Y', strtotime( $notification->created_at )) ." at ". date('H:i:s', strtotime( $notification->created_at )) }}</small></p>
                                        <span class="vertical-timeline-element-date"></span>
                                
                                        <a href="javascript:void(0)" class="mark_as_unread" data-id="{{ $notification->id }}"data-action="read">Mark as read</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        {{-- <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div> --}}
        </div>
    </div>
</div>
<ul class="nav flex-column">
    <li class="nav-item-divider nav-item"></li>
    <li class="nav-item-btn text-center nav-item">
        <a href="{{ route('notifications') }}" class="btn-shadow btn-wide btn-pill btn btn-focus btn-sm">View All</a>
    </li>
</ul>
</div>
