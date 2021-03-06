@extends('layouts.main')

@section('content')

@php

$user_program = \Auth::user()->getUserProgram()[0]->program_id;

if ( $user_program == 3 ) {
    $categories_array = ["none"];
    $activity_id_range = ['11', '17'];
} else if ( $user_program == 4 ) {
    $activity_id_range = ['12', '17'];
    $categories_array = ["BAU", "RETROFIT", "REFARM"];
} else {
    $activity_id_range = ['1', '10'];
    $categories_array = [""];
}
@endphp

    @if ( $user_program == 3 || $user_program == 4)
        
        <div class="row">
            <div class="col-12">
                <h3>RTB Tracker</h3>
            </div>
        </div>

        @for ($j = 0; $j < count($categories_array); $j++)
            @php
            
            $i = 0;
            
            $stage_activities = \DB::table('stage_activities')
                    ->where('program_id', $user_program)
                    ->where('category', $categories_array[$j])
                    ->whereBetween('activity_id', $activity_id_range)
                    ->orderBy('activity_id')
                    ->get();
            @endphp
            @if ( $categories_array[$j] != "none" )
                <h4>{{ $categories_array[$j] }}</h4>
            @endif
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

                                    <div class="widget-chart widget-chart-hover milestone_sites" data-activity_id="{{ $stage_activity->activity_id }}" data-category="{{ $stage_activity->category }}">
                                        {{-- <div class="widget-numbers" id="stage_counter_{{ $milestone->stage_id }}">- -</div> --}}
                                        <div class="widget-numbers" id="stage_counter_{{ $stage_activity->id }}">
                                            {{ \Auth::user()->activities_count($stage_activity->program_id, $stage_activity->activity_id, $categories_array[$j]); }}
                                        </div>
                                        <div class="widget-subheading" id="stage_counter_label_{{ $stage_activity->id }}">{{ $stage_activity->activity_name }}</div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-sm-3 col-12 border">
                                <div class="milestone-bg bg_img_2"></div>

                                <div class="widget-chart widget-chart-hover milestone_sites" data-activity_id="0" data-category="{{ $stage_activity->category }}">
                                    {{-- <div class="widget-numbers" id="stage_counter_{{ $milestone->stage_id }}">- -</div> --}}
                                    <div class="widget-numbers" id="stage_counter_0">
                                        {{ \Auth::user()->activities_count($user_program, 0, $categories_array[$j]); }}
                                    </div>
                                    <div class="widget-subheading" id="stage_counter_label_0">RTBd</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    @else
        <div class="row">
            <div class="col-lg-12">
                <div class="main-card card p-5">            
                    <h3 class="text-center">Nothing to see here.</h3>
                </div>
            </div>
        </div>
    @endif

@endsection

@include('layouts.rtb-tracker')