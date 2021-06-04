@php
    $mode_activities = collect();
@endphp

<div class="tab-pane tabs-animation fade" id="tab-content-{{ $mode }}" role="tabpanel">
    <div class="row">
        <div class="col-md-7">
            <div class="main-card mb-3 card">
                <div class="card-header-tab card-header">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                    <i class="header-icon lnr-calendar-full icon-gradient bg-ripe-malin"></i>
                    Activities
                    </div>
                </div>
                <div class="accordion" id="accordion{{ $mode }}">
                    @if($mode=="today")
                        @for ($m = 0; $m < count($activities); $m++)
                            @if (($activities[$m]->start_date <= Carbon\Carbon::now()->toDateString()) && ($activities[$m]->end_date >= Carbon\Carbon::now()->toDateString()))
                                @php
                                    $mode_activities->push($activities[$m]);
                                @endphp
                            @elseif($activities[$m]->start_date <= Carbon\Carbon::now()->toDateString() && $activities[$m]->activity_complete == false)
                                @php
                                    $mode_activities->push($activities[$m]);
                                @endphp
                            @endif
                        @endfor
                    @elseif($mode=="week")
                        @for ($m = 0; $m < count($activities); $m++)
                            @if ($activities[$m]->start_date <= Carbon\Carbon::now()->endOfWeek() && $activities[$m]->end_date >= Carbon\Carbon::now()->startOfWeek())
                                @php
                                    $mode_activities->push($activities[$m]);
                                @endphp
                            @elseif($activities[$m]->end_date <= Carbon\Carbon::now()->startOfWeek() && $activities[$m]->activity_complete == false)
                                @php
                                    $mode_activities->push($activities[$m]);
                                @endphp
                            @endif
                        @endfor
                    @elseif($mode=="month")
                        @for ($m = 0; $m < count($activities); $m++)
                            @if ($activities[$m]->start_date <= new Carbon\Carbon('last day of this month') && $activities[$m]->end_date >= new Carbon\Carbon('first day of this month'))
                                @php
                                    $mode_activities->push($activities[$m]);
                                @endphp
                            @elseif($activities[$m]->end_date <= new Carbon\Carbon('first day of this month') && $activities[$m]->activity_complete == false)
                                @php
                                    $mode_activities->push($activities[$m]);
                                @endphp
                            @endif
                        @endfor
                    @endif

                    @php
                        $activities_groups = group_by("site_name", $mode_activities);
                    @endphp
                
                    @for ($j = 0; $j < count(array_keys($activities_groups)); $j++)
                        @php
                            $agent_who = $activities_groups[array_keys($activities_groups)[$j]][0];
                        @endphp 
                        <div class="card">
                            <div id="heading_{{ array_keys($activities_groups)[$j] }}_{{ $mode }}" class="card-header">
                                <button type="button" data-toggle="collapse" data-target="#{{ $mode }}collapse{{ $j }}" aria-expanded="false" aria-controls="#{{ $mode }}collapse{{ $j }}" class="text-left m-0 p-0 btn btn-link btn-block">
                                    <div class="row">
                                        @if($profile=="supervisor")
                                        <div class=" my-auto" style="max-width: 70px; padding-left:10px;">
                                            @if($agent_who->agent_id == 82)
                                                <img width="42" class="rounded-circle" src="/images/avatars/3.jpg" alt="">
                                            @elseif($agent_who->agent_id == 96)
                                                <img width="42" class="rounded-circle" src="/images/avatars/4.jpg" alt="">
                                            @elseif($agent_who->agent_id == 91)
                                                <img width="42" class="rounded-circle" src="/images/avatars/5.jpg" alt="">
                                            @endif

                                        </div>
                                        @endif
                                        <div class="col-md-10  my-auto">
                                            <h5 class="m-0 p-0">
                                                {{ array_keys($activities_groups)[$j] }}
                                                <div class="badge badge-success ml-2">
                                                    {{ count($activities_groups[array_keys($activities_groups)[$j]]) }}
                                                </div>
                                            </h5>
                                        </div>
                                    </div>
                                </button>
                            </div>
                            <div data-parent="#accordion{{ $mode }}" id="{{ $mode }}collapse{{ $j }}" class="collapse {{ $j == 0 ? "show" : "" }}">
                                <ul class="todo-list-wrapper list-group list-group-flush">
                                @for ($k = 0; $k < count($activities_groups[array_keys($activities_groups)[$j]]); $k++)

                                    @php
                                        $activity_id = $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_id;
                                        $activity_name = $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_name;
                                        $site_name = $activities_groups[array_keys($activities_groups)[$j]][$k]->site_name;
                                        $sam_id = $activities_groups[array_keys($activities_groups)[$j]][$k]->sam_id;
                                        $start_date = $activities_groups[array_keys($activities_groups)[$j]][$k]->start_date;
                                        $end_date = $activities_groups[array_keys($activities_groups)[$j]][$k]->end_date;
                                        $sub_activities = $activities_groups[array_keys($activities_groups)[$j]][$k]->sub_activity;
                                        $activity_complete = $activities_groups[array_keys($activities_groups)[$j]][$k]->activity_complete;
                                    
                                        if($profile=="supervisor"){
                                            $agent_id = $activities_groups[array_keys($activities_groups)[$j]][$k]->agent_id;
                                            $agent_name = $activities_groups[array_keys($activities_groups)[$j]][$k]->agent_name;
                                        } else {
                                            $agent_id = "";
                                            $agent_name = "";
                                        }
                                    
                                    @endphp

                                    <x-activity-details :activityid="$activity_id" :activityname="$activity_name" :sitename="$site_name" :samid="$sam_id" :startdate="$start_date" :enddate="$end_date" :subactivities="$sub_activities" :activitycomplete="$activity_complete" mode="{{ $mode }}" profile="{{ $profile }}" agentid="{{ $agent_id }}" agentname="{{ $agent_name }}" />
                                    
                                @endfor
                                </ul>
                            </div>
                        </div>
                        
                    @endfor
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

                        @php
                            $site_name = $activities_groups[array_keys($activities_groups)[$j]][0]->site_name;
                            $sam_id = $activities_groups[array_keys($activities_groups)[$j]][0]->sam_id;
                            $activity_name = $activities_groups[array_keys($activities_groups)[$j]][0]->activity_name;
                            $start_date = $activities_groups[array_keys($activities_groups)[$j]][0]->start_date;
                            $end_date = $activities_groups[array_keys($activities_groups)[$j]][0]->end_date;
                            $activity_complete = $activities_groups[array_keys($activities_groups)[$j]][0]->activity_complete;
                        @endphp
                        
                        <x-activity-sites :sitename="$site_name" :samid="$sam_id" :activityname="$activity_name" :startdate="$start_date" :enddate="$end_date" :activitycomplete="$activity_complete" mode="{{ $mode }}" profile={{ $profile }}/>

                    @endfor
                </ul>
            </div>                


        </div>

    </div>
</div>
