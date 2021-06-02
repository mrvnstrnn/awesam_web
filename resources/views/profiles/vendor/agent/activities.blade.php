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
    .show_subs_btn:hover {
        cursor: pointer;
        font-weight: bold;
        color: blue;
    }

</style>


<ul class="tabs-animated body-tabs-animated nav">
    <li class="nav-item">
        <a role="tab" class="nav-link active" id="tab-today" data-toggle="tab" href="#tab-content-today">
            <span>Today</span>
        </a>
    </li>
    <li class="nav-item">
        <a role="tab" class="nav-link" id="tab-this-week" data-toggle="tab" href="#tab-content-this-week">
            <span>This Week</span>
        </a>
    </li>
    <li class="nav-item">
        <a role="tab" class="nav-link" id="tab-this-month" data-toggle="tab" href="#tab-content-this-month">
            <span>This Month</span>
        </a>
    </li>
</ul>
<div class="tab-content">
    @php
        $activities = \DB::connection('mysql2')->select('call `agent_activities`('.\Auth::id().')');
        // dd($activities);

        function date_sort($a, $b) {
            return strtotime($a->start_date) - strtotime($b->start_date);
        }
        usort($activities, "date_sort");
        
        function group_by($key, $data) {
            $result = array();

            for ($i=0; $i < count($data); $i++) { 
                // if(array_key_exists($key, $data[$i])){
                if(isset($key) == $data[$i]) {
                    $result[$data[$i]->$key][] = $data[$i];
                } else {
                    $result[""][] = $data[$i];
                }
            }
            return $result;
        }

        $daily_activities = collect();
        $weekly_activities = collect();
        $monthly_activities = collect();

        // dd($activities);
    @endphp
    <div class="tab-pane tabs-animation fade show active" id="tab-content-today" role="tabpanel">
        <div class="row">
            
            <div class="col-md-7">

                <div class="main-card mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                        <i class="header-icon lnr-calendar-full icon-gradient bg-ripe-malin"></i>
                        Activities
                        </div>
                    </div>
                    <ul class="todo-list-wrapper list-group list-group-flush">
                        <div id="accordion" class="accordion-wrapper">
                            @for ($m = 0; $m < count($activities); $m++)
                                @if (($activities[$m]->start_date <= Carbon\Carbon::now()->toDateString()) && ($activities[$m]->end_date >= Carbon\Carbon::now()->toDateString()))
                                    @php
                                        $daily_activities->push($activities[$m]);
                                    @endphp

                                @elseif($activities[$m]->start_date <= Carbon\Carbon::now()->toDateString() && $activities[$m]->activity_complete == false)
                                    @php
                                        $daily_activities->push($activities[$m]);
                                    @endphp
                                @endif
                            @endfor

                            @php
                                $activities_groups = group_by("site_name", $daily_activities);
                            @endphp
                        
                            @for ($j = 0; $j < count(array_keys($activities_groups)); $j++)
                                
                                <div class="card">
                                    <div id="headingThree" class="card-header">
                                        <button type="button" data-toggle="collapse" data-target="#dailycollapse{{ $j }}" aria-expanded="false" aria-controls="#dailycollapse{{ $j }}" class="text-left m-0 p-0 btn btn-link btn-block">
                                            <h5 class="m-0 p-0">
                                                {{ array_keys($activities_groups)[$j] }}
                                                <div class="badge badge-success ml-2">
                                                    {{ count($activities_groups[array_keys($activities_groups)[$j]]) }}
                                                </div>
                                            </h5>
                                        </button>
                                    </div>
                                    <div data-parent="#accordion" id="dailycollapse{{ $j }}" class="collapse {{ $j == 0 ? "show" : "" }}">
                                        {{-- <div class="card-body"> --}}
                                            @for ($k = 0; $k < count($activities_groups[array_keys($activities_groups)[$j]]); $k++)

                                                @if (($activities_groups[array_keys($activities_groups)[$j]][$k]->start_date <= Carbon\Carbon::now()->toDateString()) && ($activities_groups[array_keys($activities_groups)[$j]][$k]->end_date >= Carbon\Carbon::now()->toDateString()))
                                                    <li class="list-group-item">
                                                        <div class="todo-indicator bg-warning"></div>
                                                        <div class="widget-content p-0">
                                                            <div class="widget-content-wrapper">
                                                                <div class="widget-content-left mr-2">
                                                                    <i class="pe-7s-note2"></i>
                                                                </div>
                                                                <div class="widget-content-left">
                                                                    <div class="widget-heading">
                                                                        {{ $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_name }}
                                                                    </div>
                                                                    <div class="widget-subheading">
                                                                        {{ $activities_groups[array_keys($activities_groups)[$j]][$k]->site_name }} 
                                                                        - 
                                                                        {{ $activities_groups[array_keys($activities_groups)[$j]][$k]->sam_id }}</div>
                                                                    <div class="widget-subheading">
                                                                        {{ date('M d, Y', strtotime($activities_groups[array_keys($activities_groups)[$j]][$k]->start_date)) }} 
                                                                        to 
                                                                        {{ date('M d, Y', strtotime($activities_groups[array_keys($activities_groups)[$j]][$k]->end_date)) }}</div>
                                                                </div>
                                                                <div class="widget-content-right show_subs_btn"  data-show_li="sub_activity_{{ $activities_groups[array_keys($activities_groups)[$j]][$k]->sam_id }}_{{ $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_id }}_li" data-chevron="down">
                                                                    <i class="lnr-chevron-down-circle"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </li>
                                                    <li id="sub_activity_{{ $activities_groups[array_keys($activities_groups)[$j]][$k]->sam_id }}_{{ $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_id }}_li" class="list-group-item sub_activity_li d-none">
                                                        <div id="sub_activity_{{ $activities_groups[array_keys($activities_groups)[$j]][$k]->sam_id }}_{{ $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_id }}" class="card-shadow-primary border mb-0 card card-body border-warning" >
                                                            <div class="row lister">
                                                                @php
                                                                    $json = json_decode($activities_groups[array_keys($activities_groups)[$j]][$k]->sub_activity, 1);
                                                                    if ($json != null) {
                                                                        foreach ($json as $sub_activity){
                                                                            if ($sub_activity['activity_id'] == $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_id){
    
                                                                                // $show_sub_activity[] = $sub_activitiy;
                                                                                echo "<div class='col-md-6 sub_activity' data-sam_id='" . $activities_groups[array_keys($activities_groups)[$j]][$k]->sam_id ."'  data-activity_id='" . $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_id ."' data-sub_activity_name='" . $sub_activity['sub_activity_name'] . "' data-action='" . $sub_activity['action'] . "'>" . $sub_activity['sub_activity_name'] . "</div>";
    
                                                                            }
                                                                        }
                                                                    }   
                                                                @endphp
                                                            </div>
                                                            <div class="row action_box d-none">
                                                                <form class="w-100">                                                          
                                                                <div class="position-relative form-group mb-2 px-2">
                                                                    <label id="" for="doc_upload[]" class="doc_upload_label">Email</label>
                                                                    <div class="input-group">
                                                                        <input type="file" name="doc_upload[]" class="p-1 form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="position-relative form-group w-100 mb-0 px-2">
                                                                    <button type="button" class="btn btn-sm btn-primary float-right" data-complete="false" id="" data-href="">Upload</button>                                                    
                                                                    <button type="button" class="cancel_uploader btn btn-sm btn-outline-danger float-right mr-1" data-dismiss="modal" aria-label="Close">
                                                                        Cancel
                                                                    </button>
                                                                </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @elseif($activities_groups[array_keys($activities_groups)[$j]][$k]->start_date <= Carbon\Carbon::now()->toDateString() && $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_complete == false)
                                                    <li class="list-group-item">
                                                        <div class="todo-indicator bg-danger"></div>
                                                        <div class="widget-content p-0">
                                                            <div class="widget-content-wrapper">
                                                                <div class="widget-content-left mr-2">
                                                                    <i class="fa-2x pe-7s-note2"></i>
                                                                </div>
                                                                <div class="widget-content-left">
                                                                    <div class="widget-content-left">
                                                                        <div class="widget-heading">
                                                                            {{ $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_name }}
                                                                            <div class="badge badge-danger ml-2">
                                                                                {{ _('Delayed') }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="widget-subheading">
                                                                            {{ $activities_groups[array_keys($activities_groups)[$j]][$k]->site_name }} 
                                                                            - 
                                                                            {{ $activities_groups[array_keys($activities_groups)[$j]][$k]->sam_id }}</div>
                                                                        <div class="widget-subheading">
                                                                            {{ date('M d, Y', strtotime($activities_groups[array_keys($activities_groups)[$j]][$k]->start_date)) }} 
                                                                            to 
                                                                            {{ date('M d, Y', strtotime($activities_groups[array_keys($activities_groups)[$j]][$k]->end_date)) }}</div>
                                                                    </div>
                                                                </div>
                                                                <div class="widget-content-right show_subs_btn"  data-show_li="sub_activity_{{ $activities_groups[array_keys($activities_groups)[$j]][$k]->sam_id }}_{{ $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_id }}_li" data-chevron="down">
                                                                    <i class="lnr-chevron-down-circle"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li id="sub_activity_{{ $activities_groups[array_keys($activities_groups)[$j]][$k]->sam_id }}_{{ $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_id }}_li" class="list-group-item d-none sub_activity_li">
                                                        <div id="sub_activity_{{ $activities_groups[array_keys($activities_groups)[$j]][$k]->sam_id }}_{{ $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_id }}" class="card-shadow-primary border mb-0 card card-body border-danger" >
                                                            <div class="row lister">
                                                                @php
                                                                    $json = json_decode($activities_groups[array_keys($activities_groups)[$j]][$k]->sub_activity, 1);
                                                                    if ($json != null) {
                                                                        foreach ($json as $sub_activity){
                                                                            if ($sub_activity['activity_id'] == $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_id){
    
                                                                                // $show_sub_activity[] = $sub_activitiy;
                                                                                echo "<div class='col-md-6 sub_activity' data-sam_id='" . $activities_groups[array_keys($activities_groups)[$j]][$k]->sam_id ."'  data-activity_id='" . $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_id ."' data-sub_activity_name='" . $sub_activity['sub_activity_name'] . "' data-action='" . $sub_activity['action'] . "'>" . $sub_activity['sub_activity_name'] . "</div>";
    
                                                                            }
                                                                        }
                                                                    }   
                                                                @endphp
                                                            </div>
                                                            <div class="row action_box d-none">
                                                                <form class="w-100">                                                          
                                                                <div class="position-relative form-group mb-2 px-2">
                                                                    <label id="" for="doc_upload[]" class="doc_upload_label">Email</label>
                                                                    <div class="input-group">
                                                                        <input type="file" name="doc_upload[]" class="p-1 form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="position-relative form-group w-100 mb-0 px-2">
                                                                    <button type="button" class="btn btn-sm btn-primary float-right" data-complete="false" id="" data-href="">Upload</button>                                                    
                                                                    <button type="button" class="cancel_uploader btn btn-sm btn-outline-danger float-right mr-1" data-dismiss="modal" aria-label="Close">
                                                                        Cancel
                                                                    </button>
                                                                </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endif
                                            @endfor
                                        {{-- </div> --}}
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </ul>
                    <div class="card-footer justify-content-center">
                        <a href="/assigned-sites" class="btn-pill btn-shadow btn-wide fsize-1 btn btn-primary btn-lg ">
                            <span class="mr-2 opacity-7">
                                <i class="icon icon-anim-pulse ion-ios-analytics-outline"></i>
                            </span>
                            <span class="mr-1">View All Sites</span>
                        </a>
                    </div>
                </div>                

            </div>
            
            <div class="col-md-5">

                <div class="main-card mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                        <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
                        Sites
                        </div>
                    </div>
                    <ul class="todo-list-wrapper list-group list-group-flush">
                        @for ($j = 0; $j < count(array_keys($activities_groups)); $j++)
                        {{-- @for ($l = 0; $l < count($activities); $l++) --}}
                            @if (($activities_groups[array_keys($activities_groups)[$j]][0]->start_date <= Carbon\Carbon::now()->toDateString()) && ($activities_groups[array_keys($activities_groups)[$j]][0]->end_date >= Carbon\Carbon::now()->toDateString()))
                            <li class="list-group-item">
                                <div class="todo-indicator bg-warning"></div>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-2">
                                        </div>
                                        <div class="widget-content-left">
                                            <div class="widget-heading">
                                                {{ $activities_groups[array_keys($activities_groups)[$j]][0]->site_name }}
                                            </div>
                                            <div class="widget-subheading">
                                                {{ $activities_groups[array_keys($activities_groups)[$j]][0]->sam_id }}
                                            </div>
                                            {{-- <div class="widget-subheading"> --}}
                                                <div class="badge badge-success">
                                                    {{ $activities_groups[array_keys($activities_groups)[$j]][0]->activity_name }}
                                                </div>
                                            {{-- </div> --}}
                                        </div>
                                        <div class="widget-content-right widget-content-actions">
                                            <button class="border-0 btn-transition btn btn-outline-success">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button class="border-0 btn-transition btn btn-outline-danger">
                                                <i class="fa fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                            </li>
                        @elseif($activities_groups[array_keys($activities_groups)[$j]][0]->start_date <= Carbon\Carbon::now()->toDateString() && $activities_groups[array_keys($activities_groups)[$j]][0]->activity_complete == false)
                            <li class="list-group-item">
                                <div class="todo-indicator bg-danger"></div>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-2">
                                        </div>
                                        <div class="widget-content-left">
                                            <div class="widget-heading">
                                                {{ $activities_groups[array_keys($activities_groups)[$j]][0]->site_name }}
                                            </div>
                                            <div class="widget-subheading">
                                                {{ $activities_groups[array_keys($activities_groups)[$j]][0]->sam_id }}
                                            </div>
                                            {{-- <div class="widget-subheading"> --}}
                                                <div class="badge badge-danger">
                                                    {{ $activities_groups[array_keys($activities_groups)[$j]][0]->activity_name }}
                                                </div>
                                            {{-- </div> --}}
                                        </div>
                                        <div class="widget-content-right widget-content-actions">
                                            <button class="border-0 btn-transition btn btn-outline-success">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button class="border-0 btn-transition btn btn-outline-danger">
                                                <i class="fa fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif
                        @endfor
                    </ul>
                </div>                


            </div>

        </div>
    </div>
    <div class="tab-pane tabs-animation fade" id="tab-content-this-week" role="tabpanel">
        <div class="row">

            <div class="col-md-7">

                <div class="main-card mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                        <i class="header-icon lnr-calendar-full icon-gradient bg-ripe-malin"></i>
                        Activities
                        </div>
                    </div>
                    <ul class="todo-list-wrapper list-group list-group-flush">
                        <div id="accordion" class="accordion-wrapper">
                            @for ($m = 0; $m < count($activities); $m++)
                                @if ($activities[$m]->start_date <= Carbon\Carbon::now()->endOfWeek() && $activities[$m]->end_date >= Carbon\Carbon::now()->startOfWeek())
                                    @php
                                        $weekly_activities->push($activities[$m]);
                                    @endphp
                                @elseif($activities[$m]->end_date <= Carbon\Carbon::now()->startOfWeek() && $activities[$m]->activity_complete == false)
                                    @php
                                        $weekly_activities->push($activities[$m]);
                                    @endphp
                                @endif
                            @endfor
                            
                            @php
                                $activities_groups = group_by("site_name", $weekly_activities);
                            @endphp
                            
                            @for ($j = 0; $j < count(array_keys($activities_groups)); $j++)
                                
                                <div class="card">
                                    <div id="headingThree" class="card-header">
                                        <button type="button" data-toggle="collapse" data-target="#weeklycollapse{{ $j }}" aria-expanded="false" aria-controls="#weeklycollapse{{ $j }}" class="text-left m-0 p-0 btn btn-link btn-block">
                                            <h5 class="m-0 p-0">
                                                {{ array_keys($activities_groups)[$j] }}
                                                <div class="badge badge-success ml-2">
                                                    {{ count($activities_groups[array_keys($activities_groups)[$j]]) }}
                                                </div>
                                            </h5>
                                        </button>
                                    </div>
                                    <div data-parent="#accordion" id="weeklycollapse{{ $j }}" class="collapse {{ $j == 0 ? "show" : "" }}">
                                        {{-- <div class="card-body"> --}}
                                            @for ($k = 0; $k < count($activities_groups[array_keys($activities_groups)[$j]]); $k++)
                            
                                                @if (
                                                ($activities_groups[array_keys($activities_groups)[$j]][$k]->start_date <= Carbon\Carbon::now()->endOfWeek()) 
                                                && 
                                                ($activities_groups[array_keys($activities_groups)[$j]][$k]->end_date >= Carbon\Carbon::now()->startOfWeek())
                                                )
                                                    <li class="list-group-item">
                                                        <div class="todo-indicator bg-warning"></div>
                                                        <div class="widget-content p-0">
                                                            <div class="widget-content-wrapper">
                                                                <div class="widget-content-left mr-2">
                                                                    <i class="pe-7s-note2"></i>
                                                                </div>
                                                                <div class="widget-content-left">
                                                                    <div class="widget-heading">
                                                                        {{ $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_name }}
                                                                    </div>
                                                                    <div class="widget-subheading">
                                                                        {{ $activities_groups[array_keys($activities_groups)[$j]][$k]->site_name }} 
                                                                        - 
                                                                        {{ $activities_groups[array_keys($activities_groups)[$j]][$k]->sam_id }}</div>
                                                                    <div class="widget-subheading">
                                                                        {{ date('M d, Y', strtotime($activities_groups[array_keys($activities_groups)[$j]][$k]->start_date)) }} 
                                                                        to 
                                                                        {{ date('M d, Y', strtotime($activities_groups[array_keys($activities_groups)[$j]][$k]->end_date)) }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                            
                                                @elseif($activities_groups[array_keys($activities_groups)[$j]][$k]->end_date <= Carbon\Carbon::now()->startOfWeek() && $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_complete == false)
                                                    <li class="list-group-item">
                                                        <div class="todo-indicator bg-danger"></div>
                                                        <div class="widget-content p-0">
                                                            <div class="widget-content-wrapper">
                                                                <div class="widget-content-left mr-2">
                                                                    <i class="fa-2x pe-7s-note2"></i>
                                                                </div>
                                                                <div class="widget-content-left">
                                                                    <div class="widget-content-left">
                                                                        <div class="widget-heading">
                                                                            {{ $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_name }}
                                                                            <div class="badge badge-danger ml-2">
                                                                                {{ _('Delayed') }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="widget-subheading">
                                                                            {{ $activities_groups[array_keys($activities_groups)[$j]][$k]->site_name }} 
                                                                            - 
                                                                            {{ $activities_groups[array_keys($activities_groups)[$j]][$k]->sam_id }}</div>
                                                                        <div class="widget-subheading">
                                                                            {{ date('M d, Y', strtotime($activities_groups[array_keys($activities_groups)[$j]][$k]->start_date)) }} 
                                                                            to 
                                                                            {{ date('M d, Y', strtotime($activities_groups[array_keys($activities_groups)[$j]][$k]->end_date)) }}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endif
                                            @endfor
                                        {{-- </div> --}}
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </ul>
                    <div class="card-footer justify-content-center">
                        <a href="/assigned-sites" class="btn-pill btn-shadow btn-wide fsize-1 btn btn-primary btn-lg ">
                            <span class="mr-2 opacity-7">
                                <i class="icon icon-anim-pulse ion-ios-analytics-outline"></i>
                            </span>
                            <span class="mr-1">View Al Sites</span>
                        </a>
                    </div>
                </div>                

            </div>
            
            <div class="col-md-5">

                <div class="main-card mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                        <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
                        Sites
                        </div>
                    </div>
                    <ul class="todo-list-wrapper list-group list-group-flush">
                        @for ($j = 0; $j < count(array_keys($activities_groups)); $j++)
                        {{-- @for ($l = 0; $l < count($activities); $l++) --}}
                            @if (($activities_groups[array_keys($activities_groups)[$j]][0]->start_date <= Carbon\Carbon::now()->endOfWeek()) && ($activities_groups[array_keys($activities_groups)[$j]][0]->end_date >= Carbon\Carbon::now()->startOfWeek()))
                        {{-- @for ($l = 0; $l < count($activities); $l++) --}}
                            {{-- @if (
                            ($activities[$l]->start_date <= Carbon\Carbon::now()->endOfWeek())
                            && 
                            ($activities[$l]->end_date >= Carbon\Carbon::now()->startOfWeek())
                            ) --}}
                            <li class="list-group-item">
                                <div class="todo-indicator bg-warning"></div>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-2">
                                        </div>
                                        <div class="widget-content-left">
                                            <div class="widget-heading">
                                                {{ $activities_groups[array_keys($activities_groups)[$j]][0]->site_name }}
                                            </div>
                                            <div class="widget-subheading">
                                                {{ $activities_groups[array_keys($activities_groups)[$j]][0]->sam_id }}
                                            </div>
                                            {{-- <div class="widget-subheading"> --}}
                                                <div class="badge badge-success">
                                                    {{ $activities_groups[array_keys($activities_groups)[$j]][0]->activity_name }}
                                                </div>
                                            {{-- </div> --}}
                                        </div>
                                        <div class="widget-content-right widget-content-actions">
                                            <button class="border-0 btn-transition btn btn-outline-success">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button class="border-0 btn-transition btn btn-outline-danger">
                                                <i class="fa fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            @elseif($activities_groups[array_keys($activities_groups)[$j]][0]->start_date <= Carbon\Carbon::now()->startOfWeek() && $activities_groups[array_keys($activities_groups)[$j]][0]->activity_complete == false)
                            <li class="list-group-item">
                                <div class="todo-indicator bg-danger"></div>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-2">
                                        </div>
                                        <div class="widget-content-left">
                                            <div class="widget-heading">
                                                {{ $activities_groups[array_keys($activities_groups)[$j]][0]->site_name }}
                                            </div>
                                            <div class="widget-subheading">
                                                {{ $activities_groups[array_keys($activities_groups)[$j]][0]->sam_id }}
                                            </div>
                                            {{-- <div class="widget-subheading"> --}}
                                                <div class="badge badge-danger">
                                                    {{ $activities_groups[array_keys($activities_groups)[$j]][0]->activity_name }}
                                                </div>
                                            {{-- </div> --}}
                                        </div>
                                        <div class="widget-content-right widget-content-actions">
                                            <button class="border-0 btn-transition btn btn-outline-success">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button class="border-0 btn-transition btn btn-outline-danger">
                                                <i class="fa fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif
                        @endfor
                    </ul>
                </div>                


            </div>

        </div>
    </div>
    <div class="tab-pane tabs-animation fade" id="tab-content-this-month" role="tabpanel">
        <div class="row">
            <div class="col-md-7">

                <div class="main-card mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                        <i class="header-icon lnr-calendar-full icon-gradient bg-ripe-malin"></i>
                        Activities
                        </div>
                    </div>
                    <ul class="todo-list-wrapper list-group list-group-flush">        
                        <div id="accordion" class="accordion-wrapper">
                            @for ($m = 0; $m < count($activities); $m++)
                                @if ($activities[$m]->start_date <= new Carbon\Carbon('last day of this month') && $activities[$m]->end_date >= new Carbon\Carbon('first day of this month'))
                                    @php
                                        $monthly_activities->push($activities[$m]);
                                    @endphp
                                @elseif($activities[$m]->end_date <= new Carbon\Carbon('first day of this month') && $activities[$m]->activity_complete == false)
                                    @php
                                        $monthly_activities->push($activities[$m]);
                                    @endphp
                                @endif
                            @endfor
                        
                            @php
                                $activities_groups = group_by("site_name", $monthly_activities);
                            @endphp
                            
                            @for ($j = 0; $j < count(array_keys($activities_groups)); $j++)
                                
                                <div class="card">
                                    <div id="headingThree" class="card-header">
                                        <button type="button" data-toggle="collapse" data-target="#monthlycollapse{{ $j }}" aria-expanded="false" aria-controls="#monthlycollapse{{ $j }}" class="text-left m-0 p-0 btn btn-link btn-block">
                                            <h5 class="m-0 p-0">
                                                {{ array_keys($activities_groups)[$j] }}
                                                <div class="badge badge-success ml-2">
                                                    {{ count($activities_groups[array_keys($activities_groups)[$j]]) }}
                                                </div>
                                            </h5>
                                        </button>
                                    </div>
                                    <div data-parent="#accordion" id="monthlycollapse{{ $j }}" class="collapse {{ $j == 0 ? "show" : "" }}">
                                        {{-- <div class="card-body"> --}}
                                            @for ($k = 0; $k < count($activities_groups[array_keys($activities_groups)[$j]]); $k++)
                            
                                                @if (
                                                ($activities_groups[array_keys($activities_groups)[$j]][$k]->start_date <= Carbon\Carbon::now()->endOfWeek()) 
                                                && 
                                                ($activities_groups[array_keys($activities_groups)[$j]][$k]->end_date >= Carbon\Carbon::now()->startOfWeek())
                                                )
                                                    <li class="list-group-item">
                                                        <div class="todo-indicator bg-warning"></div>
                                                        <div class="widget-content p-0">
                                                            <div class="widget-content-wrapper">
                                                                <div class="widget-content-left mr-2">
                                                                    <i class="pe-7s-note2"></i>
                                                                </div>
                                                                <div class="widget-content-left">
                                                                    <div class="widget-heading">
                                                                        {{ $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_name }}
                                                                    </div>
                                                                    <div class="widget-subheading">
                                                                        {{ $activities_groups[array_keys($activities_groups)[$j]][$k]->site_name }} 
                                                                        - 
                                                                        {{ $activities_groups[array_keys($activities_groups)[$j]][$k]->sam_id }}</div>
                                                                    <div class="widget-subheading">
                                                                        {{ date('M d, Y', strtotime($activities_groups[array_keys($activities_groups)[$j]][$k]->start_date)) }} 
                                                                        to 
                                                                        {{ date('M d, Y', strtotime($activities_groups[array_keys($activities_groups)[$j]][$k]->end_date)) }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                            
                                                @elseif($activities_groups[array_keys($activities_groups)[$j]][$k]->end_date <= new Carbon\Carbon('first day of this month') && $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_complete == false)
                                                    <li class="list-group-item">
                                                        <div class="todo-indicator bg-danger"></div>
                                                        <div class="widget-content p-0">
                                                            <div class="widget-content-wrapper">
                                                                <div class="widget-content-left mr-2">
                                                                    <i class="fa-2x pe-7s-note2"></i>
                                                                </div>
                                                                <div class="widget-content-left">
                                                                    <div class="widget-content-left">
                                                                        <div class="widget-heading">
                                                                            {{ $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_name }}
                                                                            <div class="badge badge-danger ml-2">
                                                                                {{ _('Delayed') }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="widget-subheading">
                                                                            {{ $activities_groups[array_keys($activities_groups)[$j]][$k]->site_name }} 
                                                                            - 
                                                                            {{ $activities_groups[array_keys($activities_groups)[$j]][$k]->sam_id }}</div>
                                                                        <div class="widget-subheading">
                                                                            {{ date('M d, Y', strtotime($activities_groups[array_keys($activities_groups)[$j]][$k]->start_date)) }} 
                                                                            to 
                                                                            {{ date('M d, Y', strtotime($activities_groups[array_keys($activities_groups)[$j]][$k]->end_date)) }}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endif
                                            @endfor
                                        {{-- </div> --}}
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </ul>
                    <div class="card-footer justify-content-center">
                        <a href="/assigned-sites" class="btn-pill btn-shadow btn-wide fsize-1 btn btn-primary btn-lg ">
                            <span class="mr-2 opacity-7">
                                <i class="icon icon-anim-pulse ion-ios-analytics-outline"></i>
                            </span>
                            <span class="mr-1">View Al Sites</span>
                        </a>
                    </div>
                </div>                

            </div>
            
            <div class="col-md-5">

                <div class="main-card mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                        <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
                        Sites
                        </div>
                    </div>
                    <ul class="todo-list-wrapper list-group list-group-flush">
                        @for ($j = 0; $j < count(array_keys($activities_groups)); $j++)
                            @if (
                            ($activities_groups[array_keys($activities_groups)[$j]][0]->start_date <= new Carbon\Carbon('last day of this month'))
                            && 
                            ($activities_groups[array_keys($activities_groups)[$j]][0]->end_date >= new Carbon\Carbon('first day of this month'))
                            )
                            <li class="list-group-item">
                                <div class="todo-indicator bg-warning"></div>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-2">
                                        </div>
                                        <div class="widget-content-left">
                                            <div class="widget-heading">
                                                {{ $activities_groups[array_keys($activities_groups)[$j]][0]->site_name }}
                                            </div>
                                            <div class="widget-subheading">
                                                {{ $activities_groups[array_keys($activities_groups)[$j]][0]->sam_id }}
                                            </div>
                                            {{-- <div class="widget-subheading"> --}}
                                                <div class="badge badge-success">
                                                    {{ $activities_groups[array_keys($activities_groups)[$j]][0]->activity_name }}
                                                </div>
                                            {{-- </div> --}}
                                        </div>
                                        <div class="widget-content-right widget-content-actions">
                                            <button class="border-0 btn-transition btn btn-outline-success">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button class="border-0 btn-transition btn btn-outline-danger">
                                                <i class="fa fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @elseif ($activities_groups[array_keys($activities_groups)[$j]][0]->end_date <= new Carbon\Carbon('first day of this month') && $activities_groups[array_keys($activities_groups)[$j]][0]->activity_complete == false)
                            <li class="list-group-item">
                                <div class="todo-indicator bg-danger"></div>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-2">
                                        </div>
                                        <div class="widget-content-left">
                                            <div class="widget-heading">
                                                {{ $activities_groups[array_keys($activities_groups)[$j]][0]->site_name }}
                                            </div>
                                            <div class="widget-subheading">
                                                {{ $activities_groups[array_keys($activities_groups)[$j]][0]->sam_id }}
                                            </div>
                                            {{-- <div class="widget-subheading"> --}}
                                                <div class="badge badge-danger">
                                                    {{ $activities_groups[array_keys($activities_groups)[$j]][0]->activity_name }}
                                                </div>
                                                
                                            {{-- </div> --}}
                                        </div>
                                        <div class="widget-content-right widget-content-actions">
                                            <button class="border-0 btn-transition btn btn-outline-success">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button class="border-0 btn-transition btn btn-outline-danger">
                                                <i class="fa fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif
                        @endfor
                    </ul>
                </div>                
            </div>
        </div>
    </div>

</div>

@endsection

@section('modals')
<div class="modal fade" id="modal-sub_activity" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Site Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="overflow-y: auto !important; max-height: calc(100vh - 210px);">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn btn-outline-danger" data-dismiss="modal" aria-label="Close">
                    Close
                </button>
                <button type="button" class="btn btn btn-success" data-complete="false" id="" data-href="">Save</button>
            </div>
        </div>
    </div>
</div>


<DIV id="preview-template" style="display: none;">
    <DIV class="dz-preview dz-file-preview">
        <DIV class="dz-image"><IMG data-dz-thumbnail=""></DIV>
        <DIV class="dz-details">
            <DIV class="dz-size"><SPAN data-dz-size=""></SPAN></DIV>
            <DIV class="dz-filename"><SPAN data-dz-name=""></SPAN></DIV>
        </DIV>
        <DIV class="dz-progress"><SPAN class="dz-upload" data-dz-uploadprogress=""></SPAN></DIV>
        <DIV class="dz-error-message"><SPAN data-dz-errormessage=""></SPAN></DIV>
    </DIV>
</DIV>
@endsection

@section('js_script')
<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>


<script>

$(document).ready(function() {


    
    $(".show_subs_btn").on('click', function(e){
        e.preventDefault();
        
        // RESET
        $(".sub_activity_li").addClass('d-none');
        $('.show_subs_btn').html('<i class="lnr-chevron-down-circle"></i>');


        $("#" + $(this).attr("data-show_li")).toggleClass('d-none');

        // alert($(this).attr("data-chevron"));

        if($(this).attr("data-chevron") === "down"){
            var chevronUp = '<i class="lnr-chevron-up-circle" data-toggle="tooltip" data-placement="left" title="" data-original-title="Show Sub Activities"></i>';
            $(this).attr('data-chevron','up');
            console.log('down to up');
        } else {
            var chevronUp = '<i class="lnr-chevron-down-circle" data-toggle="tooltip" data-placement="left" title="" data-original-title="Show Sub Activities"></i>';
            $(this).attr('data-chevron','down');
            console.log('up to down');
            $(".sub_activity_li").addClass('d-none');
            
        }

        $(this).html(chevronUp);
    });

    $(".sub_activity").on('click', function(e){
        e.preventDefault();

        if($(this).attr('data-action')=="doc maker"){

            $(".modal-title").text($(this).attr('data-sub_activity_name'));
            $('.modal-body').html("");

            var content = "";

            $('.modal-body').html('<div id="summernote" name="editordata">' + content + '</div>');
            $('#summernote').summernote({
                height: 300,
                minHeight: null,
                maxHeight: null,
                focus: true, 
            });
            $("#modal-sub_activity").modal("show");
        }

        else if($(this).attr('data-action')=="doc upload"){


            var where = '#sub_activity_' + $(this).attr('data-sam_id') + "_" + $(this).attr('data-activity_id') ;

            $('.lister').removeClass("d-none");
            $('.action_box').addClass("d-none");

            $(where + " .lister").toggleClass("d-none");
            $(where + " .action_box").toggleClass("d-none");

            $(where).find(".doc_upload_label").html($(this).attr('data-sub_activity_name'));
        }
    });

    $(".cancel_uploader").on('click', function(e){
            $('.lister').removeClass("d-none");
            $('.action_box').addClass("d-none");
    });



});        
    </script>
@endsection