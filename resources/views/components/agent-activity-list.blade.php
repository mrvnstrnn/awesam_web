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

$activities = \DB::connection('mysql2')
    ->table('view_sites_activity')
    // ->whereJsonContains('site_agent', [
    //     'user_id' => \Auth::id()
    // ])
    ->where('profile_id', 2)
    ->get();
@endphp

{{-- @foreach($activities as $activity) --}}

@for ($i = 0; $i < count($activities); $i++)

@php
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

@endphp

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
                {{-- @if ($activities[$i]->activity_complete == 'false')
                <div class="badge badge-primary ml-0">Active</div>                                                                
                @endif --}}
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
        {{-- <div class="widget-content-right">
            <button class="border-0 btn btn-outline-light show_activity_modal" data-sam_id='{{ $activities[$i]->sam_id }}' data-site='{{ $activities[$i]->site_name}}' data-activity='{{ $activities[$i]->activity_name}}' data-main_activity='{{ $activities[$i]->activity_name}}' data-activity_id='{{ $activities[$i]->activity_id}}'>
                <i class="fa fa-angle-double-right fa-lg"></i>
            </button>
        </div> --}}
        @endif
    </div>
</div>
</li>

@endfor

<script src="js/modal-loader.js"></script>

<script>
    $('.activity_list_item').each(function(index, element){

start_date = new Date($(element).attr('data-start_date'));
end_date = new Date($(element).attr('data-end_date'));
date_today = new Date();

var firstday_week = new Date(date_today.setDate(date_today.getDate() - date_today.getDay()));
var lastday_week = new Date(date_today.setDate(date_today.getDate() - date_today.getDay() + 6));

// console.log(lastday_week);

if($(element).attr('data-profile_id') != "2"){
        // $(element).addClass('d-none');
}


if($(element).attr('data-activity_complete') == "true"){
        // $(element).addClass('d-none');
}

if($(element).attr('data-activity_complete') == ""){
        // $(element).addClass('d-none');
}

});
</script>