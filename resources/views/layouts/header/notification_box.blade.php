<div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right">
<div class="dropdown-menu-header mb-0">
    <div class="dropdown-menu-header-inner bg-deep-blue">
        <div class="menu-header-image opacity-1" style="background-image: url('images/dropdown-header/city3.jpg');"></div>
        <div class="menu-header-content text-dark">
            <h5 class="menu-header-title">Notifications</h5>
            <h6 class="menu-header-subtitle">You have
                <b>{{ count(\Auth::user()->unreadNotifications) }}</b> unread notifications
            </h6>
        </div>
    </div>
</div>
<div id="notif-box">
    <div class="scroll-area-sm">
        <div class="scrollbar-container ps">
            <div class="p-3">
                <div class="vertical-without-time vertical-timeline vertical-timeline--animate vertical-timeline--one-column notification_area">
                </div>
            </div>
        <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
    </div>
</div>
<ul class="nav flex-column">
    <li class="nav-item-divider nav-item"></li>
    <li class="nav-item-btn text-center nav-item">
        <a href="{{ route('notifications') }}" class="btn-shadow btn-wide btn-pill btn btn-focus btn-sm">View All</a>
    </li>
</ul>
</div>
