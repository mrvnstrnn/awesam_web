<style>
.modal-dialog{
    -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
    -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
    -o-box-shadow: 0 5px 15px rgba(0,0,0,0);
    box-shadow: 0 5px 15px rgba(0,0,0,0);
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js" integrity="sha512-VQQXLthlZQO00P+uEu4mJ4G4OAgqTtKG1hri56kQY1DtdLeIqhKUp9W/lllDDu3uN3SnUNawpW7lBda8+dSi7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
<script>

    var progress = $('#completed_activities').text();
  
    $(".circle-progress-primary")
        .circleProgress({
        value: parseFloat(progress) / 100.0,
        size: 200,
        lineCap: "round",
        fill: { color: "#3f6ad8" },
        })
        .on("circle-animation-progress", function (event, progress, stepValue) {
        $(this)
            .find("small")
            .html("<span>" + stepValue.toFixed(2).substr(2) + "%<span>");
        });

        $("#start_date").flatpickr(
        { 
            maxDate: new Date()
        }
        );

        Dropzone.autoDiscover = false;
        $(".dropzone_files").dropzone({
        addRemoveLinks: true,
        maxFiles: 1,
        maxFilesize: 1,
        paramName: "file",
        url: "/upload-file",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (file, resp) {
            // $("#form-upload  #file_name").val(resp.file);
            var sam_id = this.element.attributes[1].value;
            var sub_activity_id = this.element.attributes[2].value;
            var file_name = resp.file;

            $.ajax({
            url: "/upload-my-file",
            method: "POST",
            data: {
                sam_id : sam_id,
                sub_activity_id : sub_activity_id,
                file_name : file_name,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp) {
                if (!resp.error){
                $(".file_lists").load(window.location.href + " .file_lists" );
                console.log(resp.message);
                } else {
                toastr.error(resp.message, "Error");
                }
            },
            error: function (file, response) {
                toastr.error(resp.message, "Error");
            }
            });
            
        },
        error: function (file, response) {
            toastr.error(resp.message, "Error");
        }
    });

    $(".view_file").on("click", function (){
        $("#view_file_modal").modal("show");

        var extensions = ["pdf", "jpg", "png"];
        console.log(extensions.includes($(this).attr('data-value').split('.').pop()) == true);
        if( extensions.includes($(this).attr('data-value').split('.').pop()) == true) {     
          htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 380px; height: 100%" src="/ViewerJS/#../files/' + $(this).attr('data-value') + '" allowfullscreen></iframe>';

        } else {
          htmltoload = '<div class="text-center my-5"><a href="/files/' + $(this).attr('data-value') + '"><i class="fa fa-fw display-1" aria-hidden="true" title="Copy to use file-excel-o"></i><H5>Download Document</H5></a><small>No viewer available; download the file to check.</small></div>';
        }

        // htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 380px; height: 100%" src="/ViewerJS/#../files/' + $(this).attr('data-value') + '" allowfullscreen></iframe>';
                
        $('.modal-body .container-fluid').html(htmltoload); 
    });

</script>
