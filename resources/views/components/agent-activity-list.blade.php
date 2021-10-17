@php
// $activities = \DB::connection('mysql2')
//     ->table('milestone_tracking')
//     // ->select(
//     //     'activity_complete',
//     //     'end_date',
//     //     'sam_id',
//     //     'activity_name',
//     //     'site_name',
//     //     )
//     ->where('site_agent_id', "=", \Auth::id())
//     ->where('profile_id', "=", 2)
//     ->get();

// $activities = \DB::connection('mysql2')
//                     ->table('view_sites_activity_2')
//                     ->select(
//                         'sam_id', 
//                         'site_name', 
//                         'site_address', 
//                         'site_category', 
//                         'activity_id', 
//                         'activity_name', 
//                         'start_date', 
//                         'end_date', 
//                         'program_id', 
//                         'profile_id', 
//                         'activity_complete'
//                     )
//                     ->whereJsonContains('site_agent', [
//                         'user_id' => \Auth::id()
//                     ])
//                     ->where('profile_id', 2)
//                     ->distinct()
//                     ->get();

$activities = \DB::connection('mysql2')
                    ->table('view_assigned_sites')
                    ->where('agent_id', \Auth::id())
                    ->where('activity_profile_id', 2)
                    ->get();




@endphp

{{-- @foreach($activities as $activity) --}}

@for ($i = 0; $i < count($activities); $i++)

    @php
    $activity_color = 'dark';
    @endphp

    {{-- @php
        if (isset($activities[$i]->activity_complete)) {

            if($activities[$i]->activity_complete == 'true'){
                $activity_color = 'success';
                $activity_badge = "done";
            }
            else {

                if($activities[$i]->end_date <=  Carbon::today()){
                    $activity_color = 'danger';
                    $activity_badge = "delayed";
                }
                else {

                    if($activities[$i]->start_date >  Carbon::today()){

                        $activity_color = 'secondary';
                        $activity_badge = "Upcoming";

                    }
                    else {

                        $activity_color = 'warning';
                        $activity_badge = "On Schedule";

                    }
                }
            }
        } else {
            $activity_color = 'secondary';
            $activity_badge = "Upcoming";
        }

        $datas = \DB::connection('mysql2')
                        ->table('sub_activity')
                        ->select('sub_activity_id')
                        // ->join('sub_activity_value', 'sub_activity_value.sub_activity_id', 'sub_activity_id')
                        ->where('activity_id', $activities[$i]->activity_id)
                        ->where('program_id', $activities[$i]->program_id)
                        ->where('category', $activities[$i]->site_category)
                        ->where('requirements', 'required')
                        ->whereIn('action', ['doc upload', 'lessor negotiation'])   
                        ->groupBy('sub_activity_id')
                        ->get();

        $sub_activity_id_collect = collect();
        $sub_activity_values_collect = collect();

        foreach ($datas as $data) {
            $sub_activity_id_collect->push($data->sub_activity_id);
        }

        $sub_activity_values = \DB::connection('mysql2')
                                    ->table('sub_activity_value')
                                    ->where('sam_id', $activities[$i]->sam_id)
                                    ->whereIn('sub_activity_id', $sub_activity_id_collect->all())
                                    ->where('status', '!=', 'denied')
                                    ->get();

        foreach ($sub_activity_values as $sub_activity_value) {
            $sub_activity_values_collect->push($sub_activity_value->status);
        }

    @endphp --}}

    {{-- @if ( count($datas) > 0 && count($datas) <= count($sub_activity_values) )
        @if ( in_array( 'denied', $sub_activity_values_collect->all()) )
            @if ( !in_array( 'pending', $sub_activity_values_collect->all()) )
                <li class="list-group-item border-top activity_list_item show_activity_modal" data-sam_id="{{ $activities[$i]->sam_id }}" data-activity_id="{{ $activities[$i]->activity_id }}" data-activity_complete="{{ isset($activities[$i]->activity_complete) ? $activities[$i]->activity_complete : "false" }}" data-start_date="{{ isset($activities[$i]->start_date) ? $activities[$i]->start_date : "" }}" data-end_date="{{ isset($activities[$i]->end_date) ? $activities[$i]->end_date : "" }}" data-profile_id="{{ $activities[$i]->profile_id }}" style="cursor: pointer;">
                    <div class="todo-indicator bg-{{ $activity_color }}"></div>
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3 ml-2">
                                @php
                                    if($activities[$i]->activity_name == "Advanced Site Hunting"){
                                        $activity_schedule = \DB::table('sub_activity_value')
                                                            ->where('sam_id', $activities[$i]->sam_id)
                                                            ->where('type', 'site_schedule')
                                                            ->get();

                                        $sched = json_decode($activity_schedule[0]->value);
                                        $sched = getdate(strtotime($sched->site_schedule));

                                    }
                                @endphp
                                @if($activities[$i]->activity_name == "Advanced Site Hunting")
                                    <div class="text-center">
                                        <div class="m-0 p-0" style="font-size: 12px;">{{ strtoupper(substr($sched["month"], 0, 3)) }}</div>
                                        <div class="m-0 p-0" style="font-size: 24px;">{{ strtoupper(substr($sched["mday"], 0, 3)) }}</div>
                                    </div>
                                @else
                                    <i class="pe-7s-note2 pe-2x"></i>
                                @endif
                            </div>
                            <div class="widget-content-left ml-2">
                                <div class="">
                                    {{ $activities[$i]->activity_name }}
                                </div>
                                <div class="" style="  width: 400px;
                                white-space: nowrap;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                font-size: 14px;
                                font-weight: bold;
                            ">
                                    {{ $activities[$i]->site_name }}
                                </div>
                                <div class="" style="font-size: 12px;">
                                    <i class="m-0 p-0">{{ $activities[$i]->sam_id }}</i>
                                </div>
                                <div class="mt-1">
                                    <i class="lnr-calendar-full"></i>
                                    <i>{{ isset($activities[$i]->start_date) ? $activities[$i]->start_date : "" }} to {{ isset($activities[$i]->end_date) ? $activities[$i]->end_date : "" }}</i>
                                    <div class="badge badge-{{ $activity_color }} ml-2" style="font-size: 9px !important;">{{ $activity_badge }}</div>
                                </div>
                            </div>
                            @if(in_array($activities[$i]->profile_id, array("2", "3")))
                            @endif
                        </div>
                    </div>
                </li>
            @endif
        @elseif ( in_array( 'active', $sub_activity_values_collect->all()) )
            <li class="list-group-item border-top activity_list_item show_activity_modal" data-sam_id="{{ $activities[$i]->sam_id }}" data-activity_id="{{ $activities[$i]->activity_id }}" data-activity_complete="{{ isset($activities[$i]->activity_complete) ? $activities[$i]->activity_complete : "false" }}" data-start_date="{{ isset($activities[$i]->start_date) ? $activities[$i]->start_date : "" }}" data-end_date="{{ isset($activities[$i]->end_date) ? $activities[$i]->end_date : "" }}" data-profile_id="{{ $activities[$i]->profile_id }}" style="cursor: pointer;">
                <div class="todo-indicator bg-{{ $activity_color }}"></div>
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left mr-3 ml-2">
                            @php
                                if($activities[$i]->activity_name == "Advanced Site Hunting"){
                                    $activity_schedule = \DB::table('sub_activity_value')
                                                        ->where('sam_id', $activities[$i]->sam_id)
                                                        ->where('type', 'site_schedule')
                                                        ->get();

                                    $sched = json_decode($activity_schedule[0]->value);
                                    $sched = getdate(strtotime($sched->site_schedule));

                                }
                            @endphp
                            @if($activities[$i]->activity_name == "Advanced Site Hunting")
                                <div class="text-center">
                                    <div class="m-0 p-0" style="font-size: 12px;">{{ strtoupper(substr($sched["month"], 0, 3)) }}</div>
                                    <div class="m-0 p-0" style="font-size: 24px;">{{ strtoupper(substr($sched["mday"], 0, 3)) }}</div>
                                </div>
                            @else
                                <i class="pe-7s-note2 pe-2x"></i>
                            @endif
                        </div>
                        <div class="widget-content-left ml-2">
                            <div class="">
                                {{ $activities[$i]->activity_name }}
                            </div>
                            <div class="" style="  width: 400px;
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            font-size: 14px;
                            font-weight: bold;
                        ">
                                {{ $activities[$i]->site_name }}
                            </div>
                            <div class="" style="font-size: 12px;">
                                <i class="m-0 p-0">{{ $activities[$i]->sam_id }}</i>
                            </div>
                            <div class="mt-1">
                                <i class="lnr-calendar-full"></i>
                                <i>{{ isset($activities[$i]->start_date) ? $activities[$i]->start_date : "" }} to {{ isset($activities[$i]->end_date) ? $activities[$i]->end_date : "" }}</i>
                                <div class="badge badge-{{ $activity_color }} ml-2" style="font-size: 9px !important;">{{ $activity_badge }}</div>
                            </div>
                        </div>
                        @if(in_array($activities[$i]->profile_id, array("2", "3")))
                        @endif
                    </div>
                </div>
            </li>
        @endif
    @else --}}
        <li class="list-group-item border-top activity_list_item show_activity_modal" data-sam_id="{{ $activities[$i]->sam_id }}" data-activity_id="{{ $activities[$i]->activity_id }}" data-activity_complete="{{ isset($activities[$i]->activity_complete) ? $activities[$i]->activity_complete : "false" }}" data-start_date="{{ isset($activities[$i]->start_date) ? $activities[$i]->start_date : "" }}" data-end_date="{{ isset($activities[$i]->end_date) ? $activities[$i]->end_date : "" }}" data-profile_id="{{ $activities[$i]->activity_profile_id }}" style="cursor: pointer;">
            <div id="to-do-indicator-{{ $activities[$i]->sam_id }}" class="todo-indicator bg-{{ $activity_color }}"></div>
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
                        <div class="" style="  width: 400px;
                        white-space: nowrap;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        font-size: 16px;
                        font-weight: bold;
                    ">
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
                        <div class="mt-2 row pl-3">

                            <div class="" style="font-size: 12px;" id="from-to-{{ $activities[$i]->sam_id }}">
                                Loading...
                            </div>
                            <div id="from-to-badge-{{ $activities[$i]->sam_id }}" class=" badge badge-{{ $activity_color }} ml-2" style="font-size: 9px !important; max-height:20px;" ></div>

                        </div>

                    </div>
            </div>
        </li>
    {{-- @endif --}}

@endfor

<script src="js/modal-loader.js"></script>

<script>
// $('.activity_list_item').each(function(index, element){



// if($(element).attr('data-profile_id') != "2"){
// }


// if($(element).attr('data-activity_complete') == "true"){
// }

// if($(element).attr('data-activity_complete') == ""){
// }

// });
</script>

<script>
    $.ajax({
        url: "/get-agent-activity-timeline",
        method: "GET",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (resp){

            console.log(resp.message);
            

            $.each(resp.message, function(){

                start_date = new Date(this.start_date);
                end_date = new Date(this.end_date);
                date_today = new Date();

                var what_color = "dark";
                var what_badge = "Upcoming";

                if(start_date < date_today){
                    what_color = "danger";
                    what_badge = "Delayed";
                } 
                else if(start_date >= date_today || end_date >= date_today){
                    what_color = "success";
                    what_badge = "Om Schedule";
                } 
                else {
                    what_color = "warning";
                    what_badge = "Upcoming";
                }


                var m = moment(this.activity_created);  // or whatever start date you have
                var today = moment().startOf('day');

                var days = Math.round(moment.duration(today - m).asDays());

                if(days == 0){
                    dayTxt = 'Today';
                } 
                else if(days == 1) {
                    dayTxt = days + ' Day';
                } else {
                    dayTxt = days + ' Days';
                }

                $('#from-to-' + this.sam_id).html(
                    '<div>Forecast: ' + this.start_date + ' to ' + this.end_date + '</div>' +
                    '<div>Started: ' + this.activity_created + '</div>' +
                    '<div>Aging: ' + dayTxt + '</div>'
                );

                $('#from-to-badge-' + this.sam_id).text(what_badge);
                $('#from-to-badge-' + this.sam_id).text(what_badge).removeClass('badge-dark');
                $('#from-to-badge-' + this.sam_id).text(what_badge).addClass('badge-' + what_color);

                $('#to-do-indicator-' + this.sam_id).removeClass('bg-dark');
                $('#to-do-indicator-' + this.sam_id).addClass('bg-' + what_color);

                // if(this.activity_duration_days > 1) {
                //     dayTxt = ' Days'
                // } else {
                //     dayTxt = ' Day'
                // }

                // $('#duration-' + this.sam_id).text(this.activity_duration_days + dayTxt);

                $('#started-' + this.sam_id).text(this.activity_created + ' | Aging: ');
            })
        

        },
        complete: function(){
        },
        error: function (resp){
            toastr.error(resp.message, "Error");
        }
    });    
</script>
