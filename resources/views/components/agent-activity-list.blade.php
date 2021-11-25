<style>
    .siteName {
        width: 100%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 16px;
        font-weight: bold;        
    }
</style>
@php

$activities = \DB::connection('mysql2')
                    ->table('view_assigned_sites')
                    ->where('agent_id', \Auth::id())
                    ->where('activity_profile_id', \Auth::user()->profile_id == 2 ? 2 : 38)
                    ->orderBy('stage_id', 'ASC')
                    ->orderBy('activity_id', 'ASC')
                    ->get();

$uniques_stage = \DB::connection('mysql2')
                    ->table('view_assigned_sites')
                    ->select(
                        'stage_id', 
                        'stage_name'
                        )
                    ->where('agent_id', \Auth::id())
                    ->where('activity_profile_id', \Auth::user()->profile_id == 2 ? 2 : 38)
                    ->distinct('stage_id')
                    ->get();
@endphp

@foreach ($uniques_stage as $unique_stage)
    <div id="accordion" class="accordion-wrapper mb-3">
        <div class="card">
            <div id="heading{{ $unique_stage->stage_id }}" class="card-header">
                <button type="button" data-toggle="collapse" data-target="#collapse{{ $unique_stage->stage_id }}" aria-expanded="false" aria-controls="collapse{{ $unique_stage->stage_id }}" class="text-left m-0 p-0 btn btn-link btn-block collapsed">
                    <h5 class="m-0 p-0">{{ $unique_stage->stage_name }}</h5>
                </button>
            </div>
            <div data-parent="#accordion" id="collapse{{ $unique_stage->stage_id }}" aria-labelledby="heading{{ $unique_stage->stage_id }}" class="collapse" style="">
                <div class="card-body">
                    <div class="form-group">
                        <input type="text" name="search" class="form-control" placeholder="Search {{ $unique_stage->stage_name }} sites...">
                    </div>
                    @for ($i = 0; $i < count($activities); $i++)

                        @if ( $unique_stage->stage_id == $activities[$i]->stage_id )
                        @php
                        $activity_color = 'dark';
                        @endphp

                        <li class="list-group-item border-top activity_list_item">

                            <div class="todo-indicator bg-success"></div>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left pl-2 pr-2">
                                            @if($activities[$i]->activity_name == "Advanced Site Hunting")

                                                @php

                                                    $activity_schedule = \DB::table('sub_activity_value')
                                                                        ->where('sam_id', $activities[$i]->sam_id)
                                                                        ->where('type', 'site_schedule')
                                                                        ->get();

                                                    $sched = json_decode($activity_schedule[0]->value);
                                                    $sched = getdate(strtotime($sched->site_schedule));

                                                @endphp

                                                <div class="text-center">
                                                    <div class="m-0 p-0" style="font-size: 12px;">{{ strtoupper(substr($sched["month"], 0, 3)) }}</div>
                                                    <div class="m-0 p-0" style="font-size: 24px;">{{ strtoupper(substr($sched["mday"], 0, 3)) }}</div>
                                                    <div class="m-0 p-0" style="font-size: 12px;">{{ strtoupper(substr($sched["year"], 0, 4)) }}</div>
                                                </div>

                                            @elseif($activities[$i]->activity_name == "Joint Technical Site Survey")

                                                @php

                                                    $activity_schedule = \DB::table('view_jtss_start_end_dates')
                                                                        ->where('sam_id', $activities[$i]->sam_id)
                                                                        ->first();

                                                    $sched = getdate(strtotime($activity_schedule->jtss_schedule_start));

                                                @endphp

                                                <div class="text-center">
                                                    <div class="m-0 p-0" style="font-size: 12px;">{{ strtoupper(substr($sched["month"], 0, 3)) }}</div>
                                                    <div class="m-0 p-0" style="font-size: 24px;">{{ strtoupper(substr($sched["mday"], 0, 3)) }}</div>
                                                    <div class="m-0 p-0" style="font-size: 12px;">{{ strtoupper(substr($sched["year"], 0, 4)) }}</div>
                                                </div>
                                            @else
                                                <i class="pe-7s-note2 pe-2x"></i>
                                            @endif
                                        </div>
                                        <div class="widget-content-left  pl-2 show_activity_modal"  data-sam_id="{{ $activities[$i]->sam_id }}" data-activity_source="my-activities" data-activity_id="{{ $activities[$i]->activity_id }}" data-activity_complete="{{ isset($activities[$i]->activity_complete) ? $activities[$i]->activity_complete : "false" }}" data-start_date="{{ isset($activities[$i]->start_date) ? $activities[$i]->start_date : "" }}" data-end_date="{{ isset($activities[$i]->end_date) ? $activities[$i]->end_date : "" }}" data-profile_id="{{ $activities[$i]->activity_profile_id }}" style="cursor: pointer;">
                                            <div class="name_to_search">
                                                @if($activities[$i]->site_category != null && $activities[$i]->site_category != 'none')
                                                    {{ $activities[$i]->activity_name }} <span class="ml-1 px-2 py-1 badge badge-secondary"><small>{{ $activities[$i]->site_category }}</small></span>
                                                @else
                                                    {{ $activities[$i]->activity_name }}
                                                @endif
                                                <span class="ml-1 px-2 py-1 badge badge-secondary">{{ $activities[$i]->stage_name }}</span>
                                            </div>
                                            <div class="siteName">
                                                {{ $activities[$i]->site_name }}
                                            </div>
                                            <div class="mt-1" style="font-size: 12px;">
                                                SAM ID: {{ $activities[$i]->sam_id }}
                                            </div>
                                            <div class="mt-1" style="font-size: 12px;">
                                                Start Date: {{ $activities[$i]->activity_created }}
                                            </div>
                                            <div class="mt-1" style="font-size: 12px;">
                                                Aging: {{ $activities[$i]->aging }}
                                            </div>
                                            <div class="mt-2 row pl-3">
                                                <div class="" style="font-size: 12px;" id="from-to-{{ $activities[$i]->sam_id }}">
                                                    Loading...
                                                </div>
                                                <div id="from-to-badge-{{ $activities[$i]->sam_id }}" class=" badge badge-{{ $activity_color }} ml-2" style="font-size: 9px !important; max-height:20px;" ></div>
                                            </div>
                        
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="d-inline-block dropdown">
                                                <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="border-0 btn-transition btn btn-link">
                                                    <i class="fa fa-ellipsis-v fa-lg"></i>
                                                </button>
                                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right" style="position: absolute; transform: translate3d(-668px, 31px, 0px); top: 0px; left: 0px; will-change: transform;" x-placement="bottom-end">
                                                    <h6 tabindex="-1" class="dropdown-header">Activity Actions</h6>
                                                    <div tabindex="-1" class="dropdown-divider"></div>
                                                    <a tabindex="0" class="dropdown-item show_action_modal"  data-activity_source = "work_plan_activity_add" data-json='{"sam_id" : "{{ $activities[$i]->sam_id }}", "activity_id" : "{{$activities[$i]->activity_id}}", "activity_name" : "{{ $activities[$i]->activity_name }}","site_name" : "{{ $activities[$i]->site_name }}", "program_id" : "{{ $activities[$i]->program_id }}", "category" : "{{ $activities[$i]->site_category }}" }'>Add Work Plan</a>

                                                    <a tabindex="0" class="dropdown-item show_action_modal"  data-activity_source = "my-activities-engagement" data-json='{"sam_id" : "{{ $activities[$i]->sam_id }}", "activity_id" : "{{$activities[$i]->activity_id}}", "activity_name" : "{{ $activities[$i]->activity_name }}","site_name" : "{{ $activities[$i]->site_name }}", "program_id" : "{{ $activities[$i]->program_id }}", "category" : "{{ $activities[$i]->site_category }}" }'>Add Engagement</a>
                                                </div>
                                            </div>                        
                                        </div>
                                    </div>
                                </div>
                        </li>
                        @endif

                    @endfor
                </div>
            </div>
        </div>
    </div>
@endforeach

{{-- <script>
    $(document).ready(function(){
        $("input[name=search]").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".name_to_search").filter(function() {
                $("li").toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script> --}}
<script src="js/modal-loader.js"></script>