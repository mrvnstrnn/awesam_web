<div class="row">
    <div class="col-12">
        <div id="example4.2" style="height: 150px;"></div>
    </div>
</div>                        

<div class="row">
    <div class="col-12">
        <ul class="tabs-animated body-tabs-animated nav">
            <li class="nav-item">
                <a role="tab" class="nav-link active" id="tab-4" data-toggle="tab" href="#tab-content-4">
                    <span>Activities</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link" id="tab-0" data-toggle="tab" href="#tab-content-0">
                    <span>Forecast</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link" id="tab-1" data-toggle="tab" href="#tab-content-1">
                    <span>Details</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link" id="tab-3" data-toggle="tab" href="#tab-content-3">
                    <span>Files</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#tab-content-2">
                    <span>Issues</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link" id="tab-5" data-toggle="tab" href="#tab-content-5">
                    <span>Site Chat</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-lg-8 col-md-12 col-sm-12">
        <div class="main-card mb-3 card">
            <div class="card-header-tab card-header">
                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                    <i class="header-icon lnr-question-circle icon-gradient bg-ripe-malin"></i>
                    {{ $title }} 
                    @if($site[0]->site_category != null)
                        <div class="badge badge-secondary ml-2">
                            {{ $site[0]->site_category }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane tabs-animation fade show active" id="tab-content-4" role="tabpanel">
                        <x-view-site-activities :activities="$activities" :samid="$title_subheading"/>
                    </div>
                    <div class="tab-pane tabs-animation fade " id="tab-content-0" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="chart_div"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane tabs-animation fade" id="tab-content-1" role="tabpanel">
                        <x-site-fields :sitefields="$site_fields" />
                    </div>
                    <div class="tab-pane tabs-animation fade" id="tab-content-2" role="tabpanel">
                        <x-site-issues :site="$site" />
                    </div>
                    <div class="tab-pane tabs-animation fade" id="tab-content-3" role="tabpanel">
                        <x-site-files :site="$site" />
                    </div>
                    <div class="tab-pane tabs-animation fade" id="tab-content-5" role="tabpanel">
                        <x-site-chat  :site="$site" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-12 col-sm-12">
        <x-agent-sites :agentsites="$agent_sites" :agentname="$agent_name" :completedactivities="$completed_activities" />   
    </div>

    <input id="timeline" type="hidden" value="{{ $timeline }}" />

</div>
