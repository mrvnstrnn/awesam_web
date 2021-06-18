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
                                    <i class="header-icon lnr-question-circle icon-gradient bg-ripe-malin"></i>
                                        {{ $site[0]->site_name }}
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
                    $(".child_div_"+sub_activity_id).load(document.location.href + " .child_div_"+sub_activity_id );
                    console.log(resp.message);
                    toastr.success(resp.message, "Success");
                } else {
                    toastr.error(resp.message, "Error");
                }
            },
            error: function (file, response) {
                toastr.error(resp.message, "Error");
            }
            });
            
        },
        error: function (file, resp) {
            toastr.error(resp.message, "Error");
        }
    });
    
    // issues

    $('.my_table_issue').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: $('.my_table_issue').attr('data-href'),
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        },
        dataSrc: function(json){
            return json.data;
        },
        'createdRow': function( row, data, dataIndex ) {
            $(row).attr('data-id', data.issue_id);
        },
        columns: [
            { data: "start_date" },
            { data: "issue" },
            { data: "issue_details" },
            { data: "issue_status" },
        ],
    });

    $('#btn_add_issue_cancel').on( 'click', function (e) {
        $('.add_issue_form').addClass('d-none');
        $('#btn_add_issue_switch').removeClass('d-none');
    });

    $('#btn_add_issue_switch').on( 'click', function (e) {
        $('.add_issue_form').removeClass('d-none');
        $(this).addClass('d-none');
    });

    $("#issue_type").on("change", function (){
        if($(this).val() != ""){
            $("select[name=issue] option").remove();
            $.ajax({
                url: "/get-issue/"+$(this).val(),
                method: "GET",
                success: function (resp){
                    if(!resp.error){
                        resp.message.forEach(element => {
                            $("select[name=issue]").append(
                                '<option value="'+element.issue_type_id+'">'+element.issue+'</option>'
                            );
                        });
                    } else {
                        toastr.error(resp.message, "Error");
                    }
                },
                error: function (resp){
                    toastr.error(resp.message, "Error");
                }
            });
        }
    });

    $(".add_issue").on("click", function (){
        $("small").text("");
        $.ajax({
            url: "/add-issue",
            method: "POST",
            data: $(".add_issue_form").serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp){
                if(!resp.error){
                    $('.my_table_issue').DataTable().ajax.reload(function(){
                        $(".add_issue_form")[0].reset();
                        $('#btn_add_issue_cancel').trigger("click");
                        toastr.success(resp.message, "Success");
                    });
                } else {
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $("." + index + "-error").text(data);
                        });
                    } else {
                        toastr.error(resp.message, 'Error');
                    }
                }
            },
            error: function (resp){
                toastr.error(resp.message, "Error");
            }
        });
    });

    $('.my_table_issue').on("click", "tr td", function(){
        if($(this).attr("colspan") != 4){
            $("#modal_issue").modal("show");

            $.ajax({
                url: "/get-issue/details/"+$(this).parent().attr('data-id'),
                method: "GET",
                success: function (resp){
                    if(!resp.error){
                        if(resp.message.issue_status == "cancelled"){
                            $(".cancel_issue").addClass("d-none");
                        } else {
                            $(".cancel_issue").removeClass("d-none");
                        }
                        $(".cancel_issue").attr("data-id", resp.message.issue_id);

                        $(".view_issue_form input[name=issue]").val(resp.message.issue);
                        $(".view_issue_form input[name=start_date]").val(resp.message.start_date);
                        $(".view_issue_form input[name=issue_type]").val(resp.message.issue_type);
                        $(".view_issue_form textarea[name=issue_details]").text(resp.message.issue_details);
                    } else {
                        toastr.error(resp.message, "Error");
                    }
                },
                error: function (resp){
                    toastr.error(resp.message, "Error");
                }
            });
            
            $("#view_issue_form issue input[name=issue_id]").val();
        }
    });


    $(".cancel_issue").on("click", function(){
        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");
        $.ajax({
            url: "/cancel-my-issue/"+$(this).attr('data-id'),
            method: "GET",
            success: function (resp){
                if(!resp.error){
                    $('.my_table_issue').DataTable().ajax.reload(function(){
                        toastr.success(resp.message, "Succes");
                        $("#modal_issue").modal("hide");
                        $(".cancel_issue").removeAttr("disabled");
                        $(".cancel_issue").text("Cancel Issue");
                    });
                } else {
                    toastr.error(resp.message, "Error");
                    $(".cancel_issue").removeAttr("disabled");
                    $(".cancel_issue").text("Cancel Issue");
                }
            },
            error: function (resp){
                toastr.error(resp.message, "Error");
                $(".cancel_issue").removeAttr("disabled");
                $(".cancel_issue").text("Cancel Issue");
            }
        });
    });
    //end issues

    //chat
    $(".send_message").on("click", function (e){
        e.preventDefault();

        var sam_id = $("input[name=hidden_sam_id]").val();

        var message = $('.message_enter').val();

        if (message != ""){

            $.ajax({
                url: "/chat-send",
                method: "POST",
                data: {
                    comment : message,
                    sam_id : sam_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp){
                    if (!resp.error){
                        $(".message_enter").val("");
                        $(".chat-content").load(window.location.href + " .chat-content" );
                    } else {
                        toastr.error(resp.message, "Error");
                    }
                },
                error: function (resp) {
                    toastr.error(resp.message, "Error");
                }
            });
        }

    });

    $('.message_enter').keypress(function (e) {

        var key = e.which;
        if(key == 13) {
            var message = $('.message_enter').val();

            if (message != ""){
                $(".send_message").trigger("click");
            }
        }
    });  


    // end chat

    $(".view_file").on("click", function (){
        $("#view_file_modal").modal("show");

        var extensions = ["pdf", "jpg", "png"];
        // console.log(extensions.includes($(this).attr('data-value').split('.').pop()) == true);
        if( extensions.includes($(this).attr('data-value').split('.').pop()) == true) {     
          htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 380px; height: 100%" src="/ViewerJS/#../files/' + $(this).attr('data-value') + '" allowfullscreen></iframe>';

        } else {
          htmltoload = '<div class="text-center my-5"><a href="/files/' + $(this).attr('data-value') + '"><i class="fa fa-fw display-1" aria-hidden="true" title="Copy to use file-excel-o"></i><H5>Download Document</H5></a><small>No viewer available; download the file to check.</small></div>';
        }

        // htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 380px; height: 100%" src="/ViewerJS/#../files/' + $(this).attr('data-value') + '" allowfullscreen></iframe>';
                
        $('.modal-body .container-fluid').html(htmltoload); 
    });

</script>
