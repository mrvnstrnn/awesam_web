@extends('layouts.main')

@section('content')

@php
$i = 0;

$user_program = \Auth::user()->getUserProgram()[0]->program_id;

if ( $user_program == 3 ) {
    $categories_array = ["none"];
    $activity_id_range = ['11', '17'];
} else if ( $user_program == 4 ) {
    $activity_id_range = ['12', '18'];
    $categories_array = ["BAU", "RETROFIT", "REFARM"];
} else {
    $activity_id_range = ['1', '10'];
    $categories_array = [""];
}

$stage_activities = \DB::table('stage_activities')
                        ->where('program_id', $user_program)
                        ->whereBetween('activity_id', $activity_id_range)
                        ->orderBy('activity_id')
                        ->get();

@endphp
{{-- <div class="row">
    <div class="col-12">
        <h3></h3>
    </div>
</div> --}}
<div class="row">
    <div class="col-lg-12">
        <div class="main-card mb-3 card">            
            <div class="no-gutters row border">
                @foreach ($stage_activities as $stage_activity)
                @php
                    $i ++;
                @endphp                    
                <div class="col-sm-3 col-12 border">
                    <div class="milestone-bg bg_img_{{ $i }}"></div>

                    <div class="widget-chart widget-chart-hover milestone_sites">
                        {{-- <div class="widget-numbers" id="stage_counter_{{ $milestone->stage_id }}">- -</div> --}}
                        <div class="widget-numbers" id="stage_counter_{{ $stage_activity->id }}">
                            {{ \Auth::user()->activities_count($stage_activity->program_id, $stage_activity->activity_id, $stage_activity->category); }}
                        </div>
                        <div class="widget-subheading" id="stage_counter_label_{{ $stage_activity->id }}">{{ $stage_activity->activity_name }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

@endsection