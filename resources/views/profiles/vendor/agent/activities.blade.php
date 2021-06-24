@extends('layouts.main')

@section('content')



<style>
    /* .list-group-item {
        cursor: pointer;
    } */
    .sub_activity {
        font-size: 11px;
        padding:3px 10px;
    }
    .sub_activity:hover {
        cursor: pointer;
        font-weight: bold;
    }

    .sub_activity::before {
        font-family: "Linearicons-Free";
        content: ">";
        margin-right: 3px;
    }

    .show_subs_btn {
        cursor: pointer;
        font-size: 20px;
    }

    .site_progress:hover {
        cursor: pointer;
        color: blue;
    }

    .show_subs_btn:hover {
        cursor: pointer;
        font-weight: bold;
        color: blue;
    }

    .dropzone {
        min-height: 20px !important;
        border: 1px dashed #3f6ad8 !important;
        padding: unset !important;
    }

</style>


{{-- <ul class="tabs-animated body-tabs-animated nav">
    <li class="nav-item">
        <a role="tab" class="nav-link active" id="tab-today" data-toggle="tab" href="#tab-content-today">
            <span>Today</span>
        </a>
    </li>
    <li class="nav-item">
        <a role="tab" class="nav-link" id="tab-week" data-toggle="tab" href="#tab-content-week">
            <span>This Week</span>
        </a>
    </li>
    <li class="nav-item">
        <a role="tab" class="nav-link" id="tab-this-month" data-toggle="tab" href="#tab-content-month">
            <span>This Month</span>
        </a>
    </li>
</ul> --}}
<div class="tab-content">
    {{-- @php
        $activities = \DB::connection('mysql2')->select('call `agent_activities`('.\Auth::id().')');

        function date_sort($a, $b) {
            return strtotime($a->start_date) - strtotime($b->start_date);
        }
        usort($activities, "date_sort");

        
        function group_by($key, $data) {
            $result = array();

            for ($i=0; $i < count($data); $i++) { 
                if(isset($key) == $data[$i]) {
                    $result[$data[$i]->$key][] = $data[$i];
                } else {
                    $result[""][] = $data[$i];
                }
            }
            return $result;
        }
    @endphp --}}

    @php
        $sites = \DB::connection('mysql2')
            ->table('site_milestone')
            ->select('sam_id', 'site_name', 'site_category', 'program_id')
            ->distinct()
            ->where('site_agent_id', "=", \Auth::id())
            ->orderBy('sam_id') 
            ->get();
        
        $site_status = \DB::connection('mysql2')
            ->table('site_milestone_status')
            ->where('site_agent_id', "=", \Auth::id())
            ->orderBy('sam_id') 
            ->get();

        $activities = \DB::connection('mysql2')
            ->table('site_milestone')
            ->select('sam_id', 'site_name', 'site_category', 'stage_id', 'stage_name', 'activity_id', 'activity_name', 'activity_type', 'activity_duration_days', 'activity_complete', 'profile_id', 'start_date', 'end_date')
            ->distinct()
            ->where('site_agent_id', "=", \Auth::id())
            ->get();

        // dd($sites);
    @endphp

        <div class="tab-pane tabs-animation fade" id="tab-content-today" role="tabpanel">
            <div class="row">
                <div class="col-md-6">
                    <div class="main-card mb-3 card">
                        <div class="card-header">
                            <i class="header-icon lnr-calendar-full icon-gradient bg-mixed-hopes"></i>
                            My Activities
                        </div>
                        <div id="accordion" class="accordion-wrapper mb-3">
                            @foreach ($sites as $site)

                            <div class="card">
                                {{-- <div id="headingOne" class="card-header">
                                    <button type="button" data-toggle="collapse" data-target="#collapse-{{ $site->sam_id }}" aria-expanded="true" aria-controls="collapseOne" class="text-left m-0 p-0 btn btn-link text-dark btn-block">
                                        <div class="row">
                                            <i class="ml-3 mt-1 header-icon lnr-location icon-gradient bg-mixed-hopes"></i>
                                            <div class="">
                                                <h6 class="m-0 p-0">{{ $site->site_name }}</h6>
                                                <small>{{ $site->sam_id }} {{ $site->site_category }}</small>
                                            </div>   
                                        </div>
                                    </button>
                                </div> --}}
                                <ul class="todo-list-wrapper list-group list-group-flush">

                                    @foreach($activities as $activity)

                                        @if($site->sam_id == $activity->sam_id  )

                                        @php
                                            if($activity->activity_complete == 'true'){
                                                $activity_color = 'success';
                                                $activity_badge = "done";
                                            } 
                                            else {

                                                if($activity->end_date <=  Carbon::today()){
                                                    $activity_color = 'danger';
                                                    $activity_badge = "delayed";
                                                } 
                                                else {

                                                    if($activity->start_date >  Carbon::today()){

                                                        $activity_color = 'secondary';
                                                        $activity_badge = "Upcoming";

                                                    } 
                                                    else {

                                                        $activity_color = 'warning';
                                                        $activity_badge = "On Schedule";

                                                    }
                                                }
                                            }

                                        @endphp

                                        <li class="list-group-item activity_list_item" data-sam_id="{{ $site->sam_id }}" data-activity_id="{{ $activity->activity_id }}" data-activity_complete="{{ $activity->activity_complete }}" data-start_date="{{ $activity->start_date }}" data-end_date="{{ $activity->end_date }}" data-profile_id="{{ $activity->profile_id }}">
                                            <div class="todo-indicator bg-{{ $activity_color }}"></div>
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3 ml-2">
                                                        <i class="pe-7s-note2 pe-2x"></i>
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">
                                                            {{ $activity->activity_name }}
                                                            <div class="badge badge-{{ $activity_color }} ml-2">{{ $activity_badge }}</div>
                                                            {{-- @if ($activity->activity_complete == 'false')
                                                            <div class="badge badge-primary ml-0">Active</div>                                                                
                                                            @endif --}}
                                                        </div>
                                                        <div class="widget-subheading">
                                                            <h6 class="m-0 p-0">{{ $site->site_name }}</h6>
                                                        </div>
                                                        <div class="widget-subheading">
                                                            <i>{{ $activity->start_date }} to {{ $activity->end_date }}</i>

                                                        </div>
                                                    </div>
                                                    @if(in_array($activity->profile_id, array("2", "3")))
                                                    <div class="widget-content-right">
                                                        <button class="border-0 btn btn-outline-light show_activity_modal" data-sam_id='{{ $site->sam_id }}' data-site='{{ $site->site_name}}' data-activity='{{ $activity->activity_name}}' data-main_activity='{{ $activity->activity_name}}' data-activity_id='{{ $activity->activity_id}}'>
                                                            <i class="fa fa-angle-double-right fa-lg"></i>
                                                        </button>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </li>

                                        @endif

                                    @endforeach
                                    
                                </ul>                            

                                {{-- <div data-parent="#accordion" id="collapse-{{ $site->sam_id }}" aria-labelledby="heading-{{ $site->sam_id }}" class="collapse" style="">
                                </div> --}}
                            </div>
                            @endforeach
                        </div>                    
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="main-card mb-3 card">
                        <div class="card-header">
                            <i class="header-icon lnr-location icon-gradient bg-mixed-hopes"></i>
                            Site Progress
                        </div>
                        <x-site-progress /> 
                    </div>
                </div>
            </div>
        </div>

</div>

@endsection
@section('modals')

    <x-milestone-modal />

@endsection




@section('js_script')

{{-- <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js" integrity="sha512-VQQXLthlZQO00P+uEu4mJ4G4OAgqTtKG1hri56kQY1DtdLeIqhKUp9W/lllDDu3uN3SnUNawpW7lBda8+dSi7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}


<script src="js/vendor.activities.js"></script>
<script src="js/modal-loader.js"></script>

<script>

    var mode = "today";


    $('.activity_list_item').each(function(index, element){

        start_date = new Date($(element).attr('data-start_date'));
        end_date = new Date($(element).attr('data-end_date'));
        date_today = new Date();

        var firstday_week = new Date(date_today.setDate(date_today.getDate() - date_today.getDay()));
        var lastday_week = new Date(date_today.setDate(date_today.getDate() - date_today.getDay() + 6));

        // console.log(lastday_week);

        if($(element).attr('data-profile_id') != "2"){
                $(element).addClass('d-none');
        }


        if($(element).attr('data-activity_complete') == "true"){
                $(element).addClass('d-none');
        }

        if($(element).attr('data-activity_complete') == ""){
                $(element).addClass('d-none');
        }

    });


    $('.circle-progress').each(function(index, element){
        var progress = $(element).find('.site_progress').text();

        // console.log(progress);

        $(element)
            .circleProgress({
            value: progress,
            size: 50,
            lineCap: "round",
            fill: { gradient: ["#ff1e41"] },
            })
            .on("circle-animation-progress", function (event, progress, stepValue) {
            $(this)
                .find("small")
                .html("<span>" + stepValue.toFixed(2).substr(2) + "%<span>");
            });

    });


    // Dropzone.autoDiscover = false;
    // $(".dropzone").dropzone({
    //     addRemoveLinks: true,
    //     maxFiles: 1,
    //     maxFilesize: 5,
    //     paramName: "file",
    //     url: "/upload-file",
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     },
    //     success: function (file, resp) {
    //         $("#form-upload  #file_name").val(resp.file);
    //         console.log(resp.message);
    //     },
    //     error: function (file, resp) {
    //         toastr.error(resp.message, "Error");
    //     }
    // });
</script>


@endsection