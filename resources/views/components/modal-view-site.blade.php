<style>
.modal-dialog{
    -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
    -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
    -o-box-shadow: 0 5px 15px rgba(0,0,0,0);
    box-shadow: 0 5px 15px rgba(0,0,0,0);
}   

.dropzone {
    min-height: 20px !important;
    border: 1px dashed #3f6ad8 !important;
    padding: unset !important;
}
</style>


<div class="modal fade" id="viewInfoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true"  data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" style="background-color: transparent; border: 0">
            
                <div class="row">
                    <div class="col-lg-8 col-md-12 col-sm-12">
                        <div class="main-card mb-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                    <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>                                    {{ $site[0]->site_name }}
                                    @if($site[0]->site_category != null)
                                        <div class="badge badge-secondary ml-2">
                                            {{ $site[0]->site_category }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <ul class="tabs-animated body-tabs-animated nav">
                                            <li class="nav-item">
                                                <a role="tab" class="nav-link active" id="tab-site_activities" data-toggle="tab" href="#tab-content-site_activities">
                                                    <span>Activities</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a role="tab" class="nav-link" id="tab-forecast" data-toggle="tab" href="#tab-content-forecast">
                                                    <span>Forecast</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a role="tab" class="nav-link" id="tab-site_fields" data-toggle="tab" href="#tab-content-site_fields">
                                                    <span>Details</span>
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
                                <div class="divider"></div>
                                <div class="tab-content">
                                    <div class="tab-pane tabs-animation fade show active" id="tab-content-site_activities" role="tabpanel">
                                        <x-view-site-activities :activities="$activities" :samid="$sam_id"/>
                                    </div>
                                    <div class="tab-pane tabs-animation fade " id="tab-content-forecast" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="chart_div"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane tabs-animation fade" id="tab-content-site_fields" role="tabpanel">
                                        <x-site-fields :sitefields="$site_fields" />
                                    </div>
                                    <div class="tab-pane tabs-animation fade" id="tab-content-issues" role="tabpanel">
                                        <x-site-issues :site="$site" />
                                    </div>
                                    <div class="tab-pane tabs-animation fade" id="tab-content-files" role="tabpanel">
                                        <x-site-files :site="$site" />
                                    </div>
                                    <div class="tab-pane tabs-animation fade" id="tab-content-site_chat" role="tabpanel">
                                        <x-site-chat  :site="$site" />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                
                    <div class="col-lg-4 col-md-12 col-sm-12">

                        <div class="mb-3 profile-responsive card">
                            <div class="dropdown-menu-header">
                                <div class="dropdown-menu-header-inner bg-dark">
                                    <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                                    <div class="menu-header-content btn-pane-right">
                                        <div>
                                            <h5 class="menu-header-title">{{ $site[0]->site_name }}</h5>
                                            @if($site[0]->site_category != null)
                                                <h6 class="menu-header-subtitle">{{ $site[0]->site_category }}</h6>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>                    
                            <div class="text-center">
                                <div id="chart"></div>
                                <div class="mb-4">Completed Activities</div>
                            </div>
                        </div>
                        
                        
                        <x-agent-sites :agentsites="$agent_sites" :agentname="$agent_name" :completedactivities="$completed_activities" />   
                    </div>
                
                    <input id="timeline" type="hidden" value="{{ $timeline }}" />
                    <input id="completed" type="hidden" value="{{ $completed_activities }}" />
                
                </div>
                

            {{-- <div class="modal-footer"> --}}
                {{-- @if($activity !='RTB Declaration')
                    <button type="button" class="btn btn-success btn_reject_approve" data-action="approved">Approve RTB Declaration</button>
                @else
                    <button type="button" class="btn btn-success btn_reject_approve" data-action="approved">Declare RTB Date</button>
                @endif --}}
            {{-- </div> --}}
        </div>
    </div>
</div>


<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
{{-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> --}}

<script>  

    var complete = $('#completed').val();

    // alert(complete);
    var options = {
          series: [complete * 100],
          chart: {
          height: 350,
          type: 'radialBar',
          toolbar: {
            show: true
          }
        },
        plotOptions: {
          radialBar: {
            startAngle: -135,
            endAngle: 225,
             hollow: {
              margin: 0,
              size: '70%',
              background: '#fff',
              image: undefined,
              imageOffsetX: 0,
              imageOffsetY: 0,
              position: 'front',
              dropShadow: {
                enabled: true,
                top: 3,
                left: 0,
                blur: 4,
                opacity: 0.24
              }
            },
            track: {
              background: '#fff',
              strokeWidth: '67%',
              margin: 0, // margin is in pixels
              dropShadow: {
                enabled: true,
                top: -3,
                left: 0,
                blur: 4,
                opacity: 0.35
              }
            },
        
            dataLabels: {
              show: true,
              name: {
                offsetY: -10,
                show: true,
                color: '#888',
                fontSize: '17px'
              },
              value: {
                formatter: function(val) {
                  return parseInt(val);
                },
                color: '#111',
                fontSize: '36px',
                show: true,
              }
            }
          }
        },
        fill: {
          type: 'gradient',
          gradient: {
            shade: 'dark',
            type: 'horizontal',
            shadeIntensity: 0.5,
            gradientToColors: ['#ABE5A1'],
            inverseColors: true,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100]
          }
        },
        stroke: {
          lineCap: 'round'
        },
        labels: ['Percent'],
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();  

</script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.0/viewer.min.js" integrity="sha512-11Ip09cPitpyapqTnApnxupcQdX1fzWkRZZoEU+I0+IxrVxORGThseKL6O2s+qbBN7aTw7SDbk+rWFZ/LVmB7g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

{{-- <script src="{{ asset('js/supervisor-view-sites.js') }}"></script> --}}
{{-- <script src="{{ asset('js/view_site.js') }}"></script> --}}
