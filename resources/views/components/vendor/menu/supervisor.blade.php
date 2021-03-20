<ul class="vertical-nav-menu">
    <li class="app-sidebar__heading">Supervisor</li>
    <li>
        <a href="/">
            <i class="metismenu-icon pe-7s-home"></i>
            Home
        </a>
    </li>
    @if($active_slug == '/agents')
    <li>
        <a class="mm-active" href="/agents">
            <i class="metismenu-icon pe-7s-users"></i>
            Agents
        </a>
    </li>
    @else
    <li>
        <a href="/agents">
            <i class="metismenu-icon pe-7s-users"></i>
            Agents
        </a>
    </li>
    @endif
    <li>
        <a href="#">
            <i class="metismenu-icon pe-7s-date"></i>
            Schedule
            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
        </a>
        <ul>
            <li>
                <a href="/calendar">
                    <i class="metismenu-icon"></i>
                    Calendar
                </a>
            </li>
            <li>
                <a href="/tasks">
                    <i class="metismenu-icon"></i>
                    Tasks
                </a>
            </li>
            <li>
                <a href="/requests">
                    <i class="metismenu-icon"></i>
                    Requests
                </a>
            </li>
        </ul>        
    </li>

</ul>
