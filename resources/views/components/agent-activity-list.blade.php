@php
$activities = \DB::connection('mysql2')
    ->table('milestone_tracking')
    ->where('site_agent_id', "=", \Auth::id())
    ->get();
@endphp

@foreach($activities as $activity)

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

<li class="list-group-item border-top activity_list_item show_activity_modal" data-sam_id="{{ $activity->sam_id }}" data-activity_id="{{ $activity->activity_id }}" data-activity_complete="{{ $activity->activity_complete }}" data-start_date="{{ $activity->start_date }}" data-end_date="{{ $activity->end_date }}" data-profile_id="{{ $activity->profile_id }}">
<div class="todo-indicator bg-{{ $activity_color }}"></div>
<div class="widget-content p-0">
    <div class="widget-content-wrapper">
        <div class="widget-content-left mr-3 ml-2">
            @php
                if($activity->activity_name == "Advanced Site Hunting"){
                    $activity_schedule = \DB::table('sub_activity_value')
                                        ->where('sam_id', $activity->sam_id)
                                        ->where('type', 'site_schedule')
                                        ->get();

                    $sched = json_decode($activity_schedule[0]->value);
                    $sched = getdate(strtotime($sched->site_schedule));

                }    
            @endphp
            @if($activity->activity_name == "Advanced Site Hunting")
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
                {{ $activity->activity_name }}
                {{-- @if ($activity->activity_complete == 'false')
                <div class="badge badge-primary ml-0">Active</div>                                                                
                @endif --}}
            </div>
            <div class="" style="  width: 400px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 14px;
            font-weight: bold; 
            cursor: pointer;
          ">
                {{ $activity->site_name }}
            </div>
            <div class="" style="font-size: 12px;">
                <i class="m-0 p-0">{{ $activity->sam_id }}</i>
            </div>
            <div class="mt-1">
                <i class="lnr-calendar-full"></i>
                <i>{{ $activity->start_date }} to {{ $activity->end_date }}</i>                
                <div class="badge badge-{{ $activity_color }} ml-2" style="font-size: 9px !important;">{{ $activity_badge }}</div>
            </div>
        </div>
        @if(in_array($activity->profile_id, array("2", "3")))
        {{-- <div class="widget-content-right">
            <button class="border-0 btn btn-outline-light show_activity_modal" data-sam_id='{{ $activity->sam_id }}' data-site='{{ $activity->site_name}}' data-activity='{{ $activity->activity_name}}' data-main_activity='{{ $activity->activity_name}}' data-activity_id='{{ $activity->activity_id}}'>
                <i class="fa fa-angle-double-right fa-lg"></i>
            </button>
        </div> --}}
        @endif
    </div>
</div>
</li>

@endforeach

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