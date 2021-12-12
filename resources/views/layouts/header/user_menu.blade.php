<div tabindex="-1" role="menu" aria-hidden="true"
class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
    <div class="dropdown-menu-header">
        <div class="dropdown-menu-header-inner bg-info">
            <div class="menu-header-image opacity-2" style="background-image: url('images/dropdown-header/city3.jpg');"></div>
            <div class="menu-header-content text-left">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left mr-3" id="avatar">
                            @if (!is_null(\Auth::user()->getUserDetail()->first()))
                                @if (!is_null(\Auth::user()->getUserDetail()->first()->image))
                                    <img width="42" height="42" class="rounded-circle border border-dark" src="{{ asset('files/'.\Auth::user()->getUserDetail()->first()->image) }}" alt="">
                                @else
                                <img width="42" height="42" class="rounded-circle border border-dark" src="images/no-image.jpg" alt="">
                                @endif
                            @else
                                <img width="42" height="42" class="rounded-circle border border-dark" src="images/no-image.jpg" alt="">
                            @endif
                        </div>
                        <div class="widget-content-left">
                            <div class="widget-heading">{{ ucwords(Auth::user()->name) }}</div>
                            <div class="widget-subheading">{{ is_null(\Auth::user()->profile_id) ? "" : ucwords(Auth::user()->user_position) }}</div>
                        </div>
                        <div class="widget-content-right mr-2">
                            <button class="btn-pill btn-shadow btn-shine btn btn-focus"
                            href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                Logout
                            </button>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="scroll-area-xs" style="height: 100px;">
        <div class="scrollbar-container ps">
            <ul class="nav flex-column">
                <li class="nav-item-header nav-item">Activity</li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('my_profile') }}">
                        Profile
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link">Recover Password</a>
                </li>
                <li class="nav-item-header nav-item">
                    My Account
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link">
                        Settings
                        <div class="ml-auto badge badge-success">New</div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link">
                        Messages
                        <div class="ml-auto badge badge-warning">512</div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link">Logs</a>
                </li> --}}
            </ul>
        </div>
    </div>
    {{-- <ul class="nav flex-column">
        <li class="nav-item-divider mb-0 nav-item"></li>
    </ul>
    <div class="grid-menu grid-menu-2col">
        <div class="no-gutters row">
            <div class="col-sm-6">
                <button class="btn-icon-vertical btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-warning">
                    <i class="pe-7s-chat icon-gradient bg-amy-crisp btn-icon-wrapper mb-2"></i>
                    Message Inbox
                </button>
            </div>
            <div class="col-sm-6">
                <button class="btn-icon-vertical btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-danger">
                    <i class="pe-7s-ticket icon-gradient bg-love-kiss btn-icon-wrapper mb-2"></i>
                    <b>Support Tickets</b>
                </button>
            </div>
        </div>
    </div> --}}
    {{-- <ul class="nav flex-column">
        <li class="nav-item-divider nav-item"></li>
        <li class="nav-item-btn text-center nav-item">
            <button class="btn-wide btn btn-primary btn-sm"> Open Messages</button>
        </li>
    </ul> --}}
</div>

