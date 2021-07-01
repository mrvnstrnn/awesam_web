@php
$activities = \DB::connection('mysql2')
    ->table('site_milestone')
    ->join('site', 'site_milestone.sam_id','site.sam_id' )
    ->distinct()
    ->where('site_agent_id', "=", \Auth::id())
    ->where('activity_complete', "=", 'false')
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

<li class="list-group-item activity_list_item" data-sam_id="{{ $activity->sam_id }}" data-activity_id="{{ $activity->activity_id }}" data-activity_complete="{{ $activity->activity_complete }}" data-start_date="{{ $activity->start_date }}" data-end_date="{{ $activity->end_date }}" data-profile_id="{{ $activity->profile_id }}">
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
                <i>{{ $activity->start_date }} to {{ $activity->end_date }}</i>
            </div>
            <div class="widget-subheading">
                <h6 class="m-0 p-0">{{ $activity->site_name }}</h6>
            </div>
            <div class="widget-subheading">
                <i class="m-0 p-0">{{ $activity->sam_id }}</i>
            </div>

        </div>
        @if(in_array($activity->profile_id, array("2", "3")))
        <div class="widget-content-right">
            <button class="border-0 btn btn-outline-light show_activity_modal" data-sam_id='{{ $activity->sam_id }}' data-site='{{ $activity->site_name}}' data-activity='{{ $activity->activity_name}}' data-main_activity='{{ $activity->activity_name}}' data-activity_id='{{ $activity->activity_id}}'>
                <i class="fa fa-angle-double-right fa-lg"></i>
            </button>
        </div>
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
        $(element).addClass('d-none');
}


if($(element).attr('data-activity_complete') == "true"){
        $(element).addClass('d-none');
}

if($(element).attr('data-activity_complete') == ""){
        $(element).addClass('d-none');
}

});
</script>