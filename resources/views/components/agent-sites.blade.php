<div class="mb-3 profile-responsive card">
    <div class="dropdown-menu-header">
        <div class="dropdown-menu-header-inner bg-dark">
            <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
            <div class="menu-header-content btn-pane-right">
                <div class="avatar-icon-wrapper mr-3 avatar-icon-xl btn-hover-shine">
                    <div class="avatar-icon rounded">
                        <img src="/images/avatars/3.jpg" alt="Avatar 5">
                    </div>
                </div>
                <div>
                    <h5 class="menu-header-title">{{ $agentname }}</h5>
                    <h6 class="menu-header-subtitle">Agent</h6>
                </div>
            </div>
        </div>
    </div>                    
    {{-- <ul class="list-group list-group-flush">
        @foreach($agentsites as $what_site)
        <li class="list-group-item">
            <div class="widget-content p-0">
                <div class="widget-content-wrapper">
                    <div class="widget-content-left mr-3">
                        <div class="icon-wrapper m-0">
                            <div class="progress-circle-wrapper">
                                <div class="circle-progress d-inline-block circle-progress-success-sm">
                                    <small><span>81%<span></span></span></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content-left">
                        <div class="widget-heading"><a href="{{ route('view_assigned_site',[$what_site->sam_id]) }}">{{ $what_site->site_name }}</a></div>
                        <div class="widget-subheading">{{ $what_site->sam_id }}</div>
                    </div>
                </div>
            </div>
        </li>                        
        @endforeach
    </ul> --}}    
    {{-- <div class="card-body text-center">
        <div class="progress-circle-wrapper">
            <div class="circle-progress d-inline-block circle-progress-primary">
                <small><span id='completed_activities'>{{ $completedactivities * 100 }}%<span></span></span></small>
            </div>
        </div>
    </div> --}}
    <div class="text-center">
        <div id="chart"></div>
        Completed Activities    
    </div>
    <ul class="list-group list-group-flush">
        @foreach($agentsites as $what_site)
        <li class="list-group-item">
            <div class="widget-content p-0">
                <div class="widget-content-wrapper">
                    {{-- <div class="widget-content-left mr-3">
                        <div class="icon-wrapper m-0">
                            <div class="progress-circle-wrapper">
                                <div class="circle-progress d-inline-block circle-progress-success-sm">
                                    <small><span>81%<span></span></span></small>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="widget-content-left">
                        <div class="widget-heading"><a href="{{ route('view_assigned_site',[$what_site->sam_id]) }}">{{ $what_site->site_name }}</a></div>
                        <div class="widget-subheading">{{ $what_site->sam_id }}</div>
                    </div>
                </div>
            </div>
        </li>                        
        @endforeach
    </ul>
</div>

