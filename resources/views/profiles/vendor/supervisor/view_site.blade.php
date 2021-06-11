@extends('layouts.main')

@section('content')

<style>
.tab-content > .tab-pane:not(.active) {
    display: block;
    height: 0;
    overflow-y: hidden;
}
.subactivity_switch:hover {
    cursor: pointer;
    color: royalblue;
}
.subactivity_action_switch:hover {
    cursor: pointer;
    color: royalblue;
}

.dropzone {
    min-height: 20px !important;
    border: 1px dashed #3f6ad8 !important;
    padding: unset !important;
}

</style>

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
                </div>
            </div>
            <div class="card-body">

                <div class="tab-content">

                    <div class="tab-pane tabs-animation fade show active" id="tab-content-4" role="tabpanel">
                        <ul class="todo-list-wrapper list-group list-group-flush">
                            @foreach ($activities as $activity )
                                <li class="list-group-item" data-start_date="{{ $activity["start_date"] }}" data-end_date="{{ $activity["end_date"] }}">
                                    <div class="todo-indicator bg-{{ $activity["color"] }}"></div>
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left mr-2">
                                                <i class="fa-2x pe-7s-note2"></i>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">
                                                        {{ $activity["activity_name"] }}
                                                        <div class="badge badge-{{ $activity["color"] }} ml-2">
                                                            {{ $activity["badge"] }}
                                                        </div>
                                                    </div>
                                                    <div class="widget-subheading">
                                                        {{ $activity["start_date"] }} to {{ $activity["end_date"] }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-right subactivity_switch" id="subactivity_switch_{{ $activity["activity_id"] }}" data-activity_id="{{ $activity["activity_id"] }}">
                                                <i class="lnr-chevron-down-circle" style="font-size: 20px;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item d-none subactivity" id="subactivity_{{ $activity["activity_id"] }}">
                                    <div class="card-shadow-primary border mb-0 card card-body border-{{ $activity["color"] }}" >
                                        <div class="row subactivity_action_list">
                                            @php
                                                $sub_activities = $activity["sub_activities"];
                                            @endphp
                                            @foreach ( $sub_activities as $sub_activity)
                                                <div class="col-md-6 subactivity_action_switch" data-sam_id="{{ $title_subheading }}" data-activity_id="{{ $activity["activity_id"] }}" data-subactivity_id="{{ $sub_activity->sub_activity_id }}" data-sub_activity_id="{{ $sub_activity->sub_activity_id }}" data-action="{{ $sub_activity->action }}">{{ $sub_activity->sub_activity_name }}</div>
                                            @endforeach
                                        </div>
                                        <div class="row subactivity_action d-none">
                                            {{-- xxx --}}
                                            {{-- <x-action-box/> --}}
                                            <form class="w-100" id="form-upload" enctype="multipart/form-data">@csrf
                                                <div class="list-uploaded"></div>
                                                <hr class="hr-border">
                                                <div class="dropzone"></div>
                                                <input type="hidden" name="sam_id" id="sam_id">
                                                <input type="hidden" name="sub_activity_id" id="sub_activity_id">
                                                <input type="hidden" name="file_name" id="file_name">
                                                <div class="position-relative form-group w-100 mb-0 mt-3">
                                                    <button type="button" class="btn btn-sm btn-primary float-right upload_file">Upload</button>
                                                    <button type="button" class="cancel_uploader btn btn-sm btn-outline-danger float-right mr-1" data-dismiss="modal" aria-label="Close">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                                        
                            @endforeach
                        </ul>
                    </div>

                    <div class="tab-pane tabs-animation fade " id="tab-content-0" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="chart_div"></div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane tabs-animation fade" id="tab-content-1" role="tabpanel">
                        <form>
                            @foreach ( $site_fields as $site_field )
                            <div class="form-row mb-1">
                                <div class="col-5">
                                    <label for="exampleEmail22" class="mr-sm-2">{{ $site_field->field_name }}</label>
                                </div>
                                <div class="col-7">
                                    <input name="email" id="exampleEmail22" type="text" value="{{ $site_field->value }}" class="form-control">
                                </div>
                            </div>
                            @endforeach
                        </form>
                    </div>

                    <div class="tab-pane tabs-animation fade" id="tab-content-2" role="tabpanel">
                        <div class="row">
                            <div class="col-12">
                                <button id="btn_add_issue_switch" class="mt-1 btn btn-danger float-right" type="button">Add Issue</button>
                                <form class="add_issue_form mb-2 d-none">
                                    <div class="form-row mb-1">
                                        <div class="col-5">
                                            <label for="exampleEmail22" class="mr-sm-2">Issue Type</label>
                                        </div>
                                        <div class="col-7">
                                            <input name="email" id="exampleEmail22" type="text" value="{{ $site_field->value }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="col-5">
                                            <label for="exampleEmail22" class="mr-sm-2">Issue</label>
                                        </div>
                                        <div class="col-7">
                                            <input name="email" id="exampleEmail22" type="text" value="{{ $site_field->value }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="col-5">
                                            <label for="exampleEmail22" class="mr-sm-2">Issue Details</label>
                                        </div>
                                        <div class="col-7">
                                            <input name="email" id="exampleEmail22" type="text" value="{{ $site_field->value }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="col-12">
                                            <button class="mt-1 btn btn-danger float-right" type="button">Add Issue</button>
                                            <button id="btn_add_issue_cancel" class="mt-1 btn btn-outline-danger mr-1 float-right" type="button">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- <div class="divider"></div> --}}
                        <div class="row">
                            <div class="col-12">
                                <h5 class="card-title">Issue List</h5>
                                <table class="mb-0 table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Start Date</th>
                                            <th>Issue</th>
                                            <th>Details</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="4">No Issue</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane tabs-animation fade" id="tab-content-3" role="tabpanel">
                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <div class="font-icon-wrapper py-4">
                                    <i class="lnr-plus-circle"></i>
                                    <p>TSSR</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="font-icon-wrapper py-4">
                                    <i class="lnr-plus-circle"></i>
                                    <p>Conceptual Plan</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="font-icon-wrapper py-4">
                                    <i class="lnr-plus-circle"></i>
                                    <p>Letter of Intent</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="font-icon-wrapper py-4">
                                    <i class="lnr-plus-circle"></i>
                                    <p>Proposal Letter</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="font-icon-wrapper py-4">
                                    <i class="lnr-plus-circle"></i>
                                    <p>Installation Plan</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="font-icon-wrapper py-4">
                                    <i class="lnr-plus-circle"></i>
                                    <p>Proposal Letter Signed</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="font-icon-wrapper py-4">
                                    <i class="lnr-plus-circle"></i>
                                    <p>Lessor Information Sheet</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="font-icon-wrapper py-4">
                                    <i class="lnr-plus-circle"></i>
                                    <p>Notice to Proceed</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="font-icon-wrapper py-4">
                                    <i class="lnr-plus-circle"></i>
                                    <p>Letter of Intent Signed</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="font-icon-wrapper py-4">
                                    <i class="lnr-plus-circle"></i>
                                    <p>Lease Extention Notice</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="font-icon-wrapper py-4">
                                    <i class="lnr-plus-circle"></i>
                                    <p>Addendum</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="font-icon-wrapper py-4">
                                    <i class="lnr-plus-circle"></i>
                                    <p>Transmittal</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="font-icon-wrapper py-4">
                                    <i class="lnr-plus-circle"></i>
                                    <p>Provisional Authority Certificate</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="font-icon-wrapper py-4">
                                    <i class="lnr-plus-circle"></i>
                                    <p>DOH Application</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="font-icon-wrapper py-4">
                                    <i class="lnr-plus-circle"></i>
                                    <p>Memo of Justification</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="font-icon-wrapper py-4">
                                    <i class="lnr-plus-circle"></i>
                                    <p>Final Authority Certificate</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="font-icon-wrapper py-4">
                                    <i class="lnr-plus-circle"></i>
                                    <p>DOH Certificate</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane tabs-animation fade" id="tab-content-5" role="tabpanel">
                        <div class="scrollbar-container ps ps--active-y">
                            <div class="p-2">
                                <div class="chat-wrapper p-1">
                                    <div class="chat-box-wrapper">
                                        <div>
                                            <div class="avatar-icon-wrapper mr-1">
                                                <div class="badge badge-bottom btn-shine badge-success badge-dot badge-dot-lg"></div>
                                                <div class="avatar-icon avatar-icon-lg rounded">
                                                    <img src="/images/avatars/2.jpg" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="chat-box">
                                                But I must explain to you how all this mistaken
                                                idea of denouncing pleasure and praising pain was born and I will
                                                give you a complete account of the system.
                                            </div>
                                            <small class="opacity-6">
                                                <i class="fa fa-calendar-alt mr-1"></i>
                                                11:01 AM | Yesterday
                                            </small>
                                        </div>
                                    </div>
                                    <div class="float-right">
                                        <div class="chat-box-wrapper chat-box-wrapper-right">
                                            <div>
                                                <div class="chat-box">
                                                    Expound the actual teachings of the great
                                                    explorer of the truth, the master-builder of human happiness.
                                                </div>
                                                <small class="opacity-6">
                                                    <i class="fa fa-calendar-alt mr-1"></i>
                                                    11:01 AM | Yesterday
                                                </small>
                                            </div>
                                            <div>
                                                <div class="avatar-icon-wrapper ml-1">
                                                    <div class="badge badge-bottom btn-shine badge-success badge-dot badge-dot-lg"></div>
                                                    <div class="avatar-icon avatar-icon-lg rounded">
                                                        <img src="/images/avatars/3.jpg" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chat-box-wrapper">
                                        <div>
                                            <div class="avatar-icon-wrapper mr-1">
                                                <div class="badge badge-bottom btn-shine badge-success badge-dot badge-dot-lg"></div>
                                                <div class="avatar-icon avatar-icon-lg rounded">
                                                    <img src="/images/avatars/2.jpg" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="chat-box">
                                                But I must explain to you how all this mistaken
                                                idea of denouncing pleasure and praising pain was born and I will
                                                give you a complete account of the system.
                                            </div>
                                            <small class="opacity-6">
                                                <i class="fa fa-calendar-alt mr-1"></i>
                                                11:01 AM | Yesterday
                                            </small>
                                        </div>
                                    </div>
                                    <div class="float-right">
                                        <div class="chat-box-wrapper chat-box-wrapper-right">
                                            <div>
                                                <div class="chat-box">
                                                    Denouncing pleasure and praising pain was born
                                                    and I will give you a complete account.
                                                </div>
                                                <small class="opacity-6">
                                                    <i class="fa fa-calendar-alt mr-1"></i>
                                                    11:01 AM | Yesterday
                                                </small>
                                            </div>
                                            <div>
                                                <div class="avatar-icon-wrapper ml-1">
                                                    <div class="badge badge-bottom btn-shine badge-success badge-dot badge-dot-lg"></div>
                                                    <div class="avatar-icon avatar-icon-lg rounded">
                                                        <img src="/images/avatars/2.jpg" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="float-right">
                                        <div class="chat-box-wrapper chat-box-wrapper-right">
                                            <div>
                                                <div class="chat-box">The master-builder of human happiness.</div>
                                                <small class="opacity-6">
                                                    <i class="fa fa-calendar-alt mr-1"></i>
                                                    11:01 AM | Yesterday
                                                </small>
                                            </div>
                                            <div>
                                                <div class="avatar-icon-wrapper ml-1">
                                                    <div class="badge badge-bottom btn-shine badge-success badge-dot badge-dot-lg"></div>
                                                    <div class="avatar-icon avatar-icon-lg rounded">
                                                        <img src="/images/avatars/2.jpg" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 400px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 265px;"></div></div></div>
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
                        <div class="avatar-icon-wrapper mr-3 avatar-icon-xl btn-hover-shine">
                            <div class="avatar-icon rounded">
                                <img src="/images/avatars/3.jpg" alt="Avatar 5">
                            </div>
                        </div>
                        <div>
                            <h5 class="menu-header-title">{{ $agent_name }}</h5>
                            <h6 class="menu-header-subtitle">Agent</h6>
                        </div>
                    </div>
                </div>
            </div>                    
            <ul class="list-group list-group-flush">
                @foreach($agent_sites as $what_site)
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
            </ul>
        </div>
    </div>

    <input id="timeline" type="hidden" value="{{ $timeline }}" />

</div>

@endsection

@section('modals')
<div class="modal fade" id="modal-sub_activity" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Site Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/download-pdf" method="POST" target="_blank">@csrf
                <div class="modal-body" style="overflow-y: auto !important; max-height: calc(100vh - 210px);">
                </div>
                <input type="hidden" name="sam_id" id="sam_id">
                <input type="hidden" name="sub_activity_id" id="sub_activity_id">
                <textarea name="template" id="template" class="d-none" cols="30" rows="10"></textarea>
                <div class="modal-footer">
                    <button type="button" class="btn btn btn-secondary" data-dismiss="modal" aria-label="Close">
                        Close
                    </button>
                    <button type="submit" class="btn btn btn-success print_to_pdf">Print to PDF</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js_script')

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js" integrity="sha512-VQQXLthlZQO00P+uEu4mJ4G4OAgqTtKG1hri56kQY1DtdLeIqhKUp9W/lllDDu3uN3SnUNawpW7lBda8+dSi7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="{{ asset('js/supervisor-view-sites.js') }}"></script>
<script type="text/javascript">

    Dropzone.autoDiscover = false;
    $(".dropzone").dropzone({
        addRemoveLinks: true,
        maxFiles: 1,
        maxFilesize: 5,
        paramName: "file",
        url: "/upload-file",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (file, resp) {
            $("#form-upload  #file_name").val(resp.file);
            console.log(resp.message);
        },
        error: function (file, response) {
            toastr.error(resp.message, "Error");
        }
    });


    $(document).ready(() => {
    
        // subactivity_switch
    
        $('.subactivity_switch').on( 'click', function (e) {
    
            var show_what = "#subactivity_" + $(this).attr("data-activity_id");
            $(".subactivity").addClass("d-none");
            $('.subactivity_action_list').removeClass('d-none');
            $('.subactivity_action').addClass('d-none');


            $(show_what).removeClass("d-none");

    
        });
    
    
        // $('.subactivity_action_switch').on( 'click', function (e) {
        //     $('.subactivity_action_list').addClass('d-none');
        //     $('.subactivity_action').removeClass('d-none');
    
        // });
    
        $('#btn_add_issue_cancel').on( 'click', function (e) {
            $('.add_issue_form').addClass('d-none');
            $('#btn_add_issue_switch').removeClass('d-none');
        });

        $('#btn_add_issue_switch').on( 'click', function (e) {
            $('.add_issue_form').removeClass('d-none');
            $(this).addClass('d-none');
        });
        
        

    });
    
    </script>
    

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    google.charts.load('current', {'packages':['gantt']});
    google.charts.setOnLoadCallback(drawChart);

    function daysToMilliseconds(days) {
        return days * 24 * 60 * 60 * 1000;
    }

    function drawChart() {

        var data = new google.visualization.DataTable();
        
        data.addColumn('string', 'Task ID');
        data.addColumn('string', 'Task Name');
        data.addColumn('string', 'Resource');
        data.addColumn('date', 'Start Date');
        data.addColumn('date', 'End Date');
        data.addColumn('number', 'Duration');
        data.addColumn('number', 'Percent Complete');
        data.addColumn('string', 'Dependencies');

        var timeline = $('#timeline').val();
        var obj = jQuery.parseJSON(timeline);

        var times =[];
        var chain = null;

        $.each(obj, function(key,value) {
            whattopush = [
                value.stage_name, 
                value.stage_name, 
                value.stage_name,
                new Date(value.start_date), 
                new Date(value.end_date), 
                null,
                100,  
                chain
            ];

            chain = value.stage_name    
            times.push(whattopush);
        });    

        data.addRows(times);
        var options = {
            height: 415,
            gantt: {
            }
        };

        var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

        chart.draw(data, options);
    }

</script>

<script type="text/javascript">
    google.charts.load("current", {packages:["timeline"]});
    google.charts.setOnLoadCallback(drawChart2);

    function drawChart2() {

        var container = document.getElementById('example4.2');
        var chart = new google.visualization.Timeline(container);
        var dataTable = new google.visualization.DataTable();
    
        dataTable.addColumn({ type: 'string', id: 'Role' });
        dataTable.addColumn({ type: 'string', id: 'Name' });
        dataTable.addColumn({ type: 'date', id: 'Start' });
        dataTable.addColumn({ type: 'date', id: 'End' });

        var timeline = $('#timeline').val();
        var obj = jQuery.parseJSON(timeline);

        var times =[];

        $.each(obj, function(key,value) {
            whattopush = [
                'Timeline',
                value.stage_name, 
                new Date(value.start_date), 
                new Date(value.end_date)
            ];
            times.push(whattopush);
        });    

        dataTable.addRows(times);
    
        var options = {
            timeline: { groupByRowLabel: true, showRowLabels: true }
        };
    
        chart.draw(dataTable, options);

    }

</script>


@endsection