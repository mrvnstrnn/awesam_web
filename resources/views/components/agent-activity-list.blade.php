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
                    ->where('activity_profile_id', 2)
                    ->orderBy('activity_id', 'ASC')
                    ->get();
@endphp


@for ($i = 0; $i < count($activities); $i++)

    @php
    $activity_color = 'dark';
    @endphp

    <li class="list-group-item border-top activity_list_item">
        {{-- <div id="to-do-indicator-{{ $activities[$i]->sam_id }}" class="todo-indicator bg-{{ $activity_color }}"></div>
        <div class="widget-content p-0">
            <div class="widget-content-wrapper">
                <div class="widget-content-left mr-2 ml-2">
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

                            // $sched = json_decode($activity_schedule[0]);
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
                <div class="widget-content-left ml-2">
                    <div class="">
                        {{ $activities[$i]->activity_name }}
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
            </div>
        </div> --}}

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

                                // $sched = json_decode($activity_schedule[0]);
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
                    <div class="widget-content-left  pl-2 show_activity_modal"  data-sam_id="{{ $activities[$i]->sam_id }}" data-activity_id="{{ $activities[$i]->activity_id }}" data-activity_complete="{{ isset($activities[$i]->activity_complete) ? $activities[$i]->activity_complete : "false" }}" data-start_date="{{ isset($activities[$i]->start_date) ? $activities[$i]->start_date : "" }}" data-end_date="{{ isset($activities[$i]->end_date) ? $activities[$i]->end_date : "" }}" data-profile_id="{{ $activities[$i]->activity_profile_id }}" style="cursor: pointer;">
                        <div class="">
                            {{ $activities[$i]->activity_name }} <span class="ml-1 px-2 py-1 badge badge-secondary"><small>{{ $activities[$i]->site_category }}</small></span>
                        </div>
                        <div class="siteName">
                            {{ $activities[$i]->site_name }}
                        </div>
                        {{-- <div class="mt-1">
                            <i class="lnr-calendar-full"></i>
                            <i>{{ isset($activities[$i]->start_date) ? $activities[$i]->start_date : "" }} to {{ isset($activities[$i]->end_date) ? $activities[$i]->end_date : "" }}</i>
                            <div class="badge badge-{{ $activity_color }} ml-2" style="font-size: 9px !important;">{{ $activity_badge }}</div>
                        </div> --}}
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
                                <button type="button" tabindex="0" class="dropdown-item set_workplan_activity"   data-sam_id="{{ $activities[$i]->sam_id }}" data-activity_id="{{ $activities[$i]->activity_id }}" data-activity_complete="{{ isset($activities[$i]->activity_complete) ? $activities[$i]->activity_complete : "false" }}" data-start_date="{{ isset($activities[$i]->start_date) ? $activities[$i]->start_date : "" }}" data-end_date="{{ isset($activities[$i]->end_date) ? $activities[$i]->end_date : "" }}" data-profile_id="{{ $activities[$i]->activity_profile_id }}">Set Work Plan</button>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
    </li>

@endfor

<script src="js/modal-loader.js"></script>
<script>
    // $.ajax({
    //     url: "/get-agent-activity-timeline",
    //     method: "GET",
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     },
    //     success: function (resp){

    //         console.log(resp.message);
            

    //         $.each(resp.message, function(){

    //             start_date = new Date(this.start_date);
    //             end_date = new Date(this.end_date);
    //             date_today = new Date();

    //             var what_color = "dark";
    //             var what_badge = "Upcoming";

    //             if(start_date < date_today){
    //                 what_color = "danger";
    //                 what_badge = "Delayed";
    //             } 
    //             else if(start_date >= date_today || end_date >= date_today){
    //                 what_color = "success";
    //                 what_badge = "On Schedule";
    //             } 
    //             else {
    //                 what_color = "warning";
    //                 what_badge = "Upcoming";
    //             }


    //             var m = moment(this.activity_created); 
    //             var today = moment().startOf('day');

    //             var days = Math.round(moment.duration(today - m).asDays());

    //             if(days == 0){
    //                 dayTxt = 'Today';
    //             } 
    //             else if(days == 1) {
    //                 dayTxt = days + ' Day';
    //             } else {
    //                 dayTxt = days + ' Days';
    //             }

    //             $('#from-to-' + this.sam_id).html(
    //                 '<div>Forecast: ' + this.start_date + ' to ' + this.end_date + '</div>' +
    //                 '<div>Started: ' + this.activity_created + '</div>' +
    //                 '<div>Aging: ' + dayTxt + '</div>'
    //             );

    //             $('#from-to-badge-' + this.sam_id).text(what_badge);
    //             $('#from-to-badge-' + this.sam_id).text(what_badge).removeClass('badge-dark');
    //             $('#from-to-badge-' + this.sam_id).text(what_badge).addClass('badge-' + what_color);

    //             $('#to-do-indicator-' + this.sam_id).removeClass('bg-dark');
    //             $('#to-do-indicator-' + this.sam_id).addClass('bg-' + what_color);


    //             $('#started-' + this.sam_id).text(this.activity_created + ' | Aging: ');
    //         })
        

    //     },
    //     complete: function(){
    //     },
    //     error: function (resp){
    //         toastr.error(resp.message, "Error");
    //     }
    // });    
</script>
