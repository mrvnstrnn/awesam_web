@extends('layouts.main')

@section('content')

<style>
    .list-group-item {
        cursor: pointer;
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
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <ul>
                                                        @php
                                                            $json = json_decode($activities_groups[array_keys($activities_groups)[$j]][$k]->sub_activity, 1);

                                                            foreach ($json as $sub_activity){
                                                                if ($sub_activity['activity_id'] == $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_id){

                                                                    // $show_sub_activity[] = $sub_activitiy;
                                                                    echo "<li>" . $sub_activity['sub_activity_name'] . "</li>";

                                                                }
                                                            }
                                                        @endphp
                                                        </ul>
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
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <ul>
                                                        @php
                                                            $json = json_decode($activities_groups[array_keys($activities_groups)[$j]][$k]->sub_activity, 1);

                                                            foreach ($json as $sub_activity){
                                                                if ($sub_activity['activity_id'] == $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_id){

                                                                    // $show_sub_activity[] = $sub_activitiy;
                                                                    echo "<li>" . $sub_activity['sub_activity_name'] . "</li>";

                                                                }
                                                            }
                                                        @endphp
                                                        </ul>
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
                                            <div class="widget-subheading">
                                                <div class="badge badge-success">
                                                    {{ $activities_groups[array_keys($activities_groups)[$j]][0]->activity_name }}
                                                </div>
                                            </div>
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
                                            <div class="widget-subheading">
                                                <div class="badge badge-danger">
                                                    {{ $activities_groups[array_keys($activities_groups)[$j]][0]->activity_name }}
                                                </div>
                                            </div>
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
                                            <div class="widget-subheading">
                                                <div class="badge badge-success">
                                                    {{ $activities_groups[array_keys($activities_groups)[$j]][0]->activity_name }}
                                                </div>
                                            </div>
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
                                            <div class="widget-subheading">
                                                <div class="badge badge-danger">
                                                    {{ $activities_groups[array_keys($activities_groups)[$j]][0]->activity_name }}
                                                </div>
                                            </div>
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
                                            <div class="widget-subheading">
                                                <div class="badge badge-success">
                                                    {{ $activities_groups[array_keys($activities_groups)[$j]][0]->activity_name }}
                                                </div>
                                            </div>
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
                                            <div class="widget-subheading">
                                                <div class="badge badge-danger">
                                                    {{ $activities_groups[array_keys($activities_groups)[$j]][0]->activity_name }}
                                                </div>
                                                
                                            </div>
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
<div class="modal fade" id="list-group-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                Body
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js_script')
    <script>
        $(".list-group-item").on('click', function(e){
            e.preventDefault();
            $("#list-group-modal").modal("show");
            $(".modal-title").text(e.target.children[1].children[0].innerHTML);
        });
    </script>
@endsection