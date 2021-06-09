@extends('layouts.main')

@section('content')
<style>
.tab-content > .tab-pane:not(.active) {
    display: block;
    height: 0;
    overflow-y: hidden;
}
</style>


@php
    // dd($activities);
                                // dd($site_fields[0]['field_name']);

@endphp
<div class="row">
    <div class="col-12">
        <div id="example4.2" style="height: 100px;"></div>
    </div>
</div>                        

<div class="row" style="margin-top: -30px;">
    <div class="col-md-8">
        <ul class="tabs-animated body-tabs-animated nav">
            <li class="nav-item">
                <a role="tab" class="nav-link active" id="tab-4" data-toggle="tab" href="#tab-content-4">
                    <span>Activities</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link" id="tab-0" data-toggle="tab" href="#tab-content-0">
                    <span>Timeline</span>
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

        <div class="tab-content">
            <div class="tab-pane tabs-animation fade show active" id="tab-content-4" role="tabpanel">
                <div class="main-card mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            <i class="header-icon lnr-question-circle icon-gradient bg-ripe-malin"></i>
                            {{ $title }}
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="todo-list-wrapper list-group list-group-flush">
                            @foreach ($activities as $activity )
                                @php
                                    // dd($activity);
                                @endphp
                                <li class="list-group-item" data-activity_type="{{ $activity->activity_type }}" data-cumulative_days="{{ $activity->cumulative_days }}" data-start_date="{{ $activity->start_date }}" data-end_date="{{ $activity->end_date }}">
                                    <div class="todo-indicator bg-danger"></div>
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left mr-2">
                                                <i class="fa-2x pe-7s-note2"></i>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">
                                                        {{ $activity->activity_name }}
                                                        <div class="badge badge- ml-2">
                                                        </div>
                                                    </div>
                                                    <div class="widget-subheading">
                                                        {{ $activity->site_name }}
                                                    </div>
                                                    <div class="widget-subheading">
                                                        {{ $activity->start_date }} to {{ $activity->end_date }}
                                                    </div>
                                                    <small>{{ $activity->sam_id }}</small>
                                                </div>
                                            </div>
                                            <div class="widget-content-right show_subs_btn"  data-show_li="sub_activity___li_" data-chevron="down">
                                                <i class="lnr-chevron-down-circle"></i>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                
                            @endforeach
                        
                        {{-- <li id="sub_activity___li_" class="list-group-item d-none sub_activity_li">
                            <div id="sub_activity___" class="card-shadow-primary border mb-0 card card-body border-" >
                                <div class="row lister">
                                    @php
                                        // dd($activities);

                                        $json = json_decode($activities->sub_activities, 1);
                                        if ($json != null) {
                                            foreach ($json as $sub_activity){
                                                if ($sub_activity['activity_id'] == $activityid){
                        
                                                    // $show_sub_activity[] = $sub_activitiy;
                                                    echo "<div class='col-md-6 sub_activity' data-sam_id='" . $samid ."'  data-activity_id='" . $activityid ."' data-sub_activity_name='" . $sub_activity['sub_activity_name'] . "' data-action='" . $sub_activity['action'] . "' data-mode='" . $mode ."'>" . $sub_activity['sub_activity_name'] . "</div>";
                                                }
                                            }
                                        }   
                                    @endphp
                                </div>
                                <div class="row action_box d-none">
                                    <x-action-box/>
                                </div>
                            </div>
                        </li> --}}
                        </ul>
                    </div>
                    <div class="d-block text-right card-footer">
                        <button class="mr-2 btn btn-link btn-sm">Cancel</button>
                        <button class="btn btn-success btn-lg">Save</button>
                    </div>
                </div>
            </div>

            <div class="tab-pane tabs-animation fade " id="tab-content-0" role="tabpanel">
                <div class="main-card mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            <i class="header-icon lnr-calendar-full icon-gradient bg-ripe-malin"></i>
                            {{ $title }}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="chart_div"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane tabs-animation fade" id="tab-content-1" role="tabpanel">
                <div class="main-card mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            <i class="header-icon lnr-list icon-gradient bg-ripe-malin"></i>
                            {{ $title }}
                        </div>
                    </div>
                    <div class="card-body">
                        @php
                        @endphp
                        <form>
                            @foreach ( $site_fields as $site_field )
                            <div class="form-row mb-1">
                                <div class="col-5">
                                    <label for="exampleEmail22" class="mr-sm-2">{{ $site_field['field_name'] }}</label>
                                </div>
                                <div class="col-7">
                                    <input name="email" id="exampleEmail22" type="text" value="{{ $site_field['value'] }}" class="form-control">
                                </div>
                            </div>
                            @endforeach
                        </form>
                    </div>
                    <div class="d-block text-right card-footer">
                        <button class="mr-2 btn btn-link btn-sm">Cancel</button>
                        <button class="btn btn-success btn-lg">Save</button>
                    </div>
                </div>
            </div>

            <div class="tab-pane tabs-animation fade" id="tab-content-2" role="tabpanel">
                <div class="main-card mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            <i class="header-icon lnr-question-circle icon-gradient bg-ripe-malin"></i>
                            {{ $title }}
                        </div>
                    </div>
                    <div class="card-body">
                        <p>With supporting text below as a natural lead-in to additional content.</p>
                        <p class="mb-0">
                            Lorem Ipsum has been the industry's standard dummy text ever since the
                            1500s, when an unknown printer took a galley of type and scrambled.
                        </p>
                    </div>
                    <div class="d-block text-right card-footer">
                        <button class="mr-2 btn btn-link btn-sm">Cancel</button>
                        <button class="btn btn-success btn-lg">Save</button>
                    </div>
                </div>
            </div>

            <div class="tab-pane tabs-animation fade" id="tab-content-3" role="tabpanel">
                <div class="main-card mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            <i class="header-icon lnr-cloud-upload icon-gradient bg-ripe-malin"></i>
                            {{ $title }}
                        </div>
                    </div>
                    <div class="card-body">
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
                </div>
            </div>

            <div class="tab-pane tabs-animation fade" id="tab-content-5" role="tabpanel">
                <div class="main-card mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            <i class="header-icon lnr-question-circle icon-gradient bg-ripe-malin"></i>
                            {{ $title }}
                        </div>
                    </div>
                    <div class="card-body">
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
                    <div class="d-block text-right card-footer">
                        <button class="mr-2 btn btn-link btn-sm">Cancel</button>
                        <button class="btn btn-success btn-lg">Save</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3 profile-responsive card" style="margin-top: 80px;">
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

@section('js_script')
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


    // var rowss = [
    //     ['PMO ENDORSEMENT', 'PMO ENDORSEMENT', 'PMO ENDORSEMENT',
    //      new Date(2021, 2, 22), new Date(2021, 5, 20), null, 100, null],

    //      ['PRE-NEGOTIATION', 'PRE-NEGOTIATION', 'PRE-NEGOTIATION',
    //      new Date(2021, 5, 21), new Date(2021, 8, 20), null, 100, 'PMO ENDORSEMENT'],

    //      ['LESSOR ISSUE', 'LESSOR ISSUE', 'LESSOR ISSUE',
    //      new Date(2021, 8, 30), new Date(2021, 9, 30), null, 25, null],

    //     ['LESSOR NEGOTIATION', 'LESSOR NEGOTIATION', 'LESSOR NEGOTIATION',
    //      new Date(2021, 8, 21), new Date(2021, 11, 20), null, 50, 'PRE-NEGOTIATION'],

    //     ['READY TO BUILD', 'READY TO BUILD', 'READY TO BUILD',
    //      new Date(2021, 11, 21), new Date(2022, 2, 21), null, 0, 'LESSOR NEGOTIATION'],

    //     ['PROVISIONAL ACCEPTANCE', 'PROVISIONAL ACCEPTANCE', 'PROVISIONAL ACCEPTANCE',
    //      new Date(2022, 2, 22), new Date(2022, 5, 20), null, 0, 'READY TO BUILD'],

    //     ['FINAL ACCEPTANCE', 'FINAL ACCEPTANCE', 'FINAL ACCEPTANCE',
    //      new Date(2022, 5, 21), new Date(2022, 8, 20), null, 0, 'PROVISIONAL ACCEPTANCE'],

    //      ['COMPLETED', 'COMPLETED', 'COMPLETED',
    //      new Date(2022, 8, 21), new Date(2022, 9, 21), null, 0, 'FINAL ACCEPTANCE']
    //   ];

    //   console.log(rowss);




    // data.addRows(rowss);

      var options = {
        height: 415,
        gantt: {
        }
      };

    var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

    chart.draw(data, options);
  }

  $(window).resize(function(){
        drawChart();
    });

</script>

<script type="text/javascript">
    google.charts.load("current", {packages:["timeline"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
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
            'COLOC-000001',
            value.stage_name, 
            new Date(value.start_date), 
            new Date(value.end_date)
        ];
        times.push(whattopush);
    });    

    dataTable.addRows(times);

    console.log(times);


    //   dataTable.addRows([
    //     [ 'COLOC-000001', 'PMO Endorsement', new Date(2021, 3, 1), new Date(2021, 3, 4) ],
    //     [ 'COLOC-000001', 'Pre Lessor Negotiation', new Date(2021, 3, 4), new Date(2021, 3, 10) ],
    //     [ 'COLOC-000001', 'Lessor Negotiation', new Date(2021, 3, 10), new Date(2021, 3, 20) ],
    //     [ 'COLOC-000001', 'Ready to Build', new Date(2021, 3, 20), new Date(2021, 3, 30) ],
    //     [ 'COLOC-000001', 'Provisional Authorization', new Date(2021, 3, 30), new Date(2021, 4, 10) ],
    //     [ 'COLOC-000001', 'Final Authorization', new Date(2021, 4, 10), new Date(2021, 4, 15) ],
    //     [ 'COLOC-000001', 'Completed', new Date(2021, 4, 15), new Date(2021, 4, 16) ],
    //   ]);
  
      var options = {
        timeline: { groupByRowLabel: true, showRowLabels: false }
      };
  
      chart.draw(dataTable, options);
    }

    $(window).resize(function(){
        drawChart();
    });

  </script>

@endsection