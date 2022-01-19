@extends('layouts.home')

@section('style')
    <style>
        .offline {
            -webkit-filter: grayscale(100%);
            filter: grayscale(100%);        
        }
    </style>
@endsection

@section('content')
<h3>Sites</h3>
<div class="row" style="margin-top: 20px;">
    <div class="col-md-6 col-lg-3">
        <div class="mb-3 card">
            <div class="widget-chart widget-chart2 text-left p-0">
                <div class="widget-chat-wrapper-outer">
                    <div class="widget-chart-content widget-chart-content-lg milestone-submilestones">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-gray.jpeg');   background-repeat: no-repeat; background-size: 100%;"></div>

                        <div class="widget-chart-flex">
                            <div class="widget-title  text-muted text-uppercase">
                                Assigned Sites
                            </div>
                        </div>
                        <div class="widget-numbers">
                            <span class="opacity-10 text-secondary pr-2">
                                <i class="fa fa-upload"></i>
                            </span>
                            <span>{{ \DB::select('call `proc_agent_supervisor_site`('. \Auth::id() .')')[0]->COUNT }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="mb-3 card">
            <div class="widget-chart widget-chart2 text-left p-0">
                <div class="widget-chat-wrapper-outer">
                    <div class="widget-chart-content widget-chart-content-lg milestone-submilestones" data-modal_title="Pre-BRGY Distribution" data-modal_ul="Pre_BRGY_Distribution">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-primary.jpeg');   background-repeat: no-repeat; background-size: 100%;"></div>

                        <div class="widget-chart-flex">
                            <div class="widget-title opacity-5 text-muted text-uppercase">
                                New Endorsements
                            </div>
                        </div>
                        <div class="widget-numbers">
                            <span class="opacity-10 text-info">
                                <i class="fa fa-list-ol"></i>
                            </span>
                            <span>{{ \DB::select('call `proc_agent_supervisor_site`('. \Auth::id() .')')[1]->COUNT }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="mb-3 card">
            <div class="widget-chart widget-chart2 text-left p-0">
                <div class="widget-chat-wrapper-outer">
                    <div class="widget-chart-content widget-chart-content-lg milestone-submilestones"data-modal_title="Pre-ARTB Distribution"  data-modal_ul="Pre_ARTB_Distribution">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.10; height: 100%; width:100%; background-image: url('/images/milestone-orange-2.jpeg');   background-repeat: no-repeat; background-size: 100%;"></div>

                        <div class="widget-chart-flex">
                            <div class="widget-title opacity-5 text-muted text-uppercase">
                                Unassigned Sites
                            </div>
                        </div>
                        <div class="widget-numbers">
                            <div class="widget-chart-flex">
                                <div>
                                    <span class="opacity-10 text-warning pr-2">
                                        <i class="fa fa-file-contract"></i>
                                    </span>
                                    <span>{{ \DB::select('call `proc_agent_supervisor_site`('. \Auth::id() .')')[2]->COUNT }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="mb-3 card">
            <div class="widget-chart widget-chart2 text-left p-0">
                <div class="widget-chat-wrapper-outer">
                    <div class="widget-chart-content widget-chart-content-lg milestone-submilestones"data-modal_title="Pre-RTB Distribution" data-modal_ul="Pre_RTB_Distribution">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.15; height: 100%; width:100%; background-image: url('/images/milestone-green-2.jpeg');   background-repeat: no-repeat; background-size: 100%;"></div>

                        <div class="widget-chart-flex">
                            <div class="widget-title opacity-5 text-muted text-uppercase">
                                Site Issues
                            </div>
                        </div>
                        <div class="widget-numbers">
                            <div class="widget-chart-flex">
                                <div>
                                    <span class="opacity-10 text-success pr-2">
                                        <i class="fa fa-angle-double-right"></i>
                                    </span>
                                    <span>{{ \DB::select('call `proc_agent_supervisor_site`('. \Auth::id() .')')[3]->COUNT }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="row">
    <div class="col-12">
        <h3>Team Dashboard</h3>
    </div>
</div>
<div class="mb-3 card">
    <div class="tabs-lg-alternate card-header">
        <ul class="nav nav-justified">
            <li class="nav-item">
                <a data-toggle="tab" href="#tab-eg9-0" class="nav-link active">
                    <div class="widget-number">Milestones</div>
                </a>
            </li>
            <li class="nav-item">
                <a data-toggle="tab" href="#tab-eg9-1" class="nav-link">
                    <div class="widget-number">Productivity</div>
                </a>
            </li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane active" id="tab-eg9-0" role="tabpanel">
            <div class="card-body">
                <div class="row">
                    
                    @php

                            $activities = \DB::table('view_COLOC_dashboard_supervisor')
                                            ->get();
                    @endphp           

                    @foreach ($activities as $activity)                        
                        <div class="col-md-6 col-lg-3">
                            <div class="mb-3 card milestone_sites" data-activity_name="{{ $activity->activity_name}}" data-total="{{ $activity->counter}}" data-activity_id="{{ $activity->activity_id}}">
                                <div class="p-3">
                                    <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.15; height: 100%; width:100%; background-image: url('/images/milestone-blue-2.jpeg');   background-repeat: no-repeat; background-size: 100%;"></div>
                                    <div class="text-center" style="min-height: 40px;">
                                        <div class="text-muted text-uppercase" style="font-size:12px; overflow: hidden;">
                                            {{ $activity->activity_name}}
                                        </div>
                                    </div>
                                    <div class="text-center" style="font-weight: bolder; font-size: 40px;">
                                        {{ $activity->counter}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="tab-pane" id="tab-eg9-1" role="tabpanel">
            <div class="card-body">
                <style>
                    .assigned-sites-table {
                        cursor: pointer;
                    }
                
                    table {
                        width: 100% !important;
                    }
                </style> 
                <table id="dar-table" class="align-middle mb-0 table table-borderless table-striped table-hover assigned-sites-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Vendor</th>
                            <th>Supervisor</th>
                            <th>Agent</th>
                            <th>Site</th>
                            <th>Activity</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table> 
            </div>
        </div>
    </div>
</div> --}}

<div class="divider"></div>

@php
    $user_program = \Auth::user()->getUserProgram()[0]->program_id;
@endphp

<x-home-dashboard-productivity />

<div class="row" style="">
    <div class="col-12">
        <h3>My Team</h3>
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    @php
                        $agents = \App\Models\UserDetail::select('profiles.profile', 'users.name', 'user_details.image')
                                                        ->join('users', 'users.id', 'user_details.user_id')
                                                        ->join('profiles', 'profiles.id', 'users.profile_id')
                                                        ->join('user_programs', 'user_programs.user_id', 'users.id')
                                                        ->where('user_details.IS_id', \Auth::id())
                                                        ->where('user_programs.program_id', $user_program)
                                                        ->get();
                    @endphp
                    
                    @if (count($agents) > 0)
                        @foreach ($agents as $agent)
                            <div class="col mb-2 mt-1" style="text-align: center;">
                                @if (!is_null($agent->image))
                                    <img width="70" height="70" class="rounded-circle border border-dark" src="{{ asset('files/'.$agent->image) }}" alt="">
                                @else
                                    <img width="70" height="70" class="rounded-circle border border-dark" src="images/no-image.jpg" alt="">
                                @endif
                                <div style="text-align: center;">
                                    <div><small>{{ $agent->name }}</small></div>
                                    <div><small>{{ $agent->profile }}</small></div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12 mb-2 mt-1" style="text-align: center;">
                            <h6>No available agent/s.</h6>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

<div class="divider"></div>

<x-home-dashboard-milestone :programid="$user_program" />

<div class="divider"></div>

@endsection

@section("js_script")


@endsection