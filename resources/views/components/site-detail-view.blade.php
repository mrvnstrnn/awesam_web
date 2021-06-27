<div id="site_details_view"  class="{{ $site_details_view }}">                                    
    <div class="row">      
        <div class="col-12 text-center">
            <button class="btn-icon btn-pill btn btn-focus d-none" id="site_details_view_switch">
                <i class="pe-7s-angle-up-circle pe-2x btn-icon-wrapper"></i>
                @if($main_activity == "")
                    {{ $site[0]->activity_name }}
                @else
                    {{ $main_activity }}
                @endif
            </button>
        </div>
    </div>
    <div class="row  border-bottom mb-3">
        <div class="col-12">
            <ul class="tabs-animated body-tabs-animated nav">
                <li class="nav-item">
                    <a role="tab" class="nav-link active" id="tab-details" data-toggle="tab" href="#tab-content-details">
                        <span>Details</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a role="tab" class="nav-link" id="tab-files" data-toggle="tab" href="#tab-content-activities">
                        <span>Forecast</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a role="tab" class="nav-link" id="tab-files" data-toggle="tab" href="#tab-content-files">
                        <span>Files</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a role="tab" class="nav-link" id="tab-issues" data-toggle="tab" href="#tab-content-issues">
                        <span>Issues</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a role="tab" class="nav-link" id="tab-site_chat" data-toggle="tab" href="#tab-content-site_chat">
                        <span>Site Chat</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class='mb-3'>
        @php
        if($site[0]->end_date > now()){
            $badge_color = "success";
        } else {
            $badge_color = "danger";
        }

        @endphp

        @if($main_activity == "")
            <span class="badge badge-dark text-sm mb-0 p-2">{{ $site[0]->stage_name }}</span>
            <span class="badge badge-{{ $badge_color }} text-sm mb-0 p-2">{{ $site[0]->activity_name }}</span>
        @else
            <span class="badge badge-{{ $badge_color }} text-sm mb-0 p-2">{{ $main_activity }}</span>
        @endif

    </div>  
    <div class="tab-content">

        <div class="tab-pane tabs-animation fade show active" id="tab-content-details" role="tabpanel">
            <div id="">

            </div>
            <div id="">

            </div>
            <x-site-details :site="$site" :sitefields="$site_fields" />
        </div>
        <div class="tab-pane tabs-animation fade" id="tab-content-activities" role="tabpanel">
            {{-- <x-site-activities :site="$site" /> --}}
            <div class="loader-wrapper w-100 d-flex justify-content-center align-items-center">
                <div class="loader">
                    <div class="ball-scale-multiple">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>        
        </div>
        <div class="tab-pane tabs-animation fade" id="tab-content-issues" role="tabpanel">
            <x-site-issues :site="$site" />
        </div>
        <div class="tab-pane tabs-animation fade" id="tab-content-files" role="tabpanel">
            {{-- <x-site-files :site="$site" /> --}}
            <div class="loader-wrapper w-100 d-flex justify-content-center align-items-center">
                <div class="loader">
                    <div class="ball-scale-multiple">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>        
        </div>
        <div class="tab-pane tabs-animation fade" id="tab-content-site_chat" role="tabpanel">
            <x-site-chat  :site="$site" />
        </div>
    </div>
</div>