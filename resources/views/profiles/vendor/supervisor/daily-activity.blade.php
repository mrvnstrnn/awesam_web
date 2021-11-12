@extends('layouts.main')

@section('content')

<style>
    .work_plan_view{
        cursor: pointer;
    }
</style>
@php
    $dates = \DB::table('view_dar_agent')
            ->distinct()
            ->select('date_added')
            // ->where('user_id', \Auth::user()->id)
            ->where('type', '<>',  'work_plan')
            ->where('type', '<>',  'doc_upload')
            ->orderBy('date_added', 'desc')
            ->get();

@endphp

<div id="workplan-list" class='mt-5'>
    <div class="row">
        <div class="col-12">
            <div class="mb-3 card">
                <div class="dropdown-menu-header py-3 bg-warning border-bottom"   style=" background-image: url('/images/modal-background.jpeg'); background-size:cover;">
                    <div class="row px-4">
                        <div class="menu-header-content btn-pane-right">
                            <h5 class="menu-header-title text-dark">
                                <i class="header-icon pe-7s-date pe-lg font-weight-bold mr-1"></i>
                                 My Team's Activities
                            </h5>
                        </div>
                        <div class="btn-actions-pane-right py-0">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3 border-bottom pb-3">
                        <div class="col-12">
                            <form action="{{ route('daily_activity') }}" method="POST">@csrf
                                <div class="form-row">
                                    <div class="col-12 col-md-6">
                                        <label for="region">Region</label>
                                        <select class="mb-2 form-control" class="region">
                                            <option>All</option>
                                        </select>
                                    </div>

                                    
                                    <div class="col-12 col-md-6">
                                        <label for="user_id">Agent</label>
                                        
                                        <select class="mb-2 form-control" name="user_id">
                                            @php
                                                $get_user_under_me = App\Models\UserDetail::select('user_details.user_id', 'users.name')
                                                                                ->join('users', 'users.id', 'user_details.user_id')
                                                                                ->where('IS_id', \Auth::id())
                                                                                ->get();
                                            @endphp

                                            <option value="">Please select user.</option>
                                            @foreach ($get_user_under_me as $user)
                                                @php
                                                    if (isset($user_id)) {
                                                        $selected = $user_id == $user->user_id ? 'selected': '';
                                                    } else {
                                                        $selected = "";
                                                    }
                                                @endphp
                                                <option {{ $selected }} value="{{ $user->user_id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <button class="btn btn-primary btn-shadow" type="submit">Filter</button>
                                
                                </div>
                                
                            </form>
                        </div>
                    </div>
                    @if (isset($user_id))
                    <div class="row mb-3">
                        <div id="work_plan_this_week" class="col-12 table-responsive">
                            <div id="accordion" class="accordion-wrapper mb-3">
                                @php
                                    if (isset($user_id)) {
                                        $users = App\Models\User::find($user_id);
                                    }
                                    $date_ctr = 0;
                                @endphp
                                <h1>{{ isset($users) ? $users->name : "" }}</h1>
                                @foreach ($dates as $date)
                                @php
                                    $date_ctr++;
                                @endphp
                                
                                <div class="card">
                                    <div id="headingOne" class="card-header bg-light">
                                        <button type="button" data-toggle="collapse" data-target="#collapse{{ $date_ctr }}" aria-expanded=" " aria-controls="collapse{{ $date_ctr }}" class="text-left m-0 p-0 btn btn-link btn-block collapsed">
                                            <h5 class="m-0 p-0  text-dark">{{ $date->date_added }}</h5>
                                        </button>
                                    </div>
                                    <div data-parent="#accordion" id="collapse{{ $date_ctr }}" aria-labelledby="heading{{ $date_ctr }}" class="collapse {{ ($date_ctr==1) ? 'show' : ''}}" style="">
                                        <div class="card-body p-0">
                                            @php

                                                if (isset($user_id)) {

                                                    $dars =  \DB::table('view_dar_agent')
                                                            ->where('date_added', $date->date_added)
                                                            ->where('type', '<>',  'work_plan')
                                                            ->where('type', '<>',  'doc_upload')
                                                            ->where('user_id', $user_id)
                                                            ->get();
                                                } else {

                                                    $get_user = App\Models\UserDetail::select('user_id')
                                                                    ->where('IS_id', \Auth::id())
                                                                    ->get()
                                                                    ->pluck('user_id');

                                                                    
                                                    $dars =  \DB::table('view_dar_agent')
                                                            ->where('date_added', $date->date_added)
                                                            ->where('type', '<>',  'work_plan')
                                                            ->where('type', '<>',  'doc_upload')
                                                            ->whereIn('user_id', $get_user)
                                                            ->get();
                                                }

                                            @endphp
                                            <div id="accordion-sites{{ $date_ctr }}" class="p-0 m-0 ">
                                                <table class='table table-bordered table-striped table-sm'>
                                                    <thead>
                                                        <tr>
                                                            <th>Site</th>
                                                            <th>Activity</th>
                                                            <th>Sub Activity</th>
                                                            <th>Method</th>
                                                            <th>SAQ Objective</th>
                                                            {{-- <th>Work Plan</th> --}}
                                                        </tr>
                                                    </thead>
                                                    <tbody>    
                                                        @foreach ($dars as $dar)
                                                        <tr>
                                                            <td>{{ $dar->site_name }}</td>
                                                            <td>{{ $dar->activity_name }}</td>
                                                            <td>
                                                                @if($dar->type == 'lessor_engagement' && $dar->sub_activity_name == "")
                                                                    ENGAGEMENT
                                                                @else
                                                                    {{ $dar->sub_activity_name }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($dar->type == 'doc_upload')
                                                                    Doc Upload
                                                                @elseif($dar->type == 'lessor_engagement')
                                                                    @php
                                                                        $v = json_decode($dar->value);                                                                            
                                                                    @endphp 
                                                                    {{ $v->lessor_method }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @php
                                                                    $v = json_decode($dar->value);    
                                                                    if(isset($v->saq_objective)){
                                                                        $saq = $v->saq_objective;
                                                                    } else {
                                                                        $saq = "";
                                                                    }
                                                                @endphp 
                                                                {{ $saq }}
                                                            </td>
                                                            {{-- <td> -- -- </td> --}}
                                                        </tr>                                            
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>                                                
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>                            

                        </div>
                    </div>
                    @endif
                </div>
            </div>            
        </div>
    </div>

</div>

@endsection

@section('modals')

    <x-milestone-modal />

@endsection

@section('js_script')

<script src="\js\modal-loader.js"> </script>

@endsection

