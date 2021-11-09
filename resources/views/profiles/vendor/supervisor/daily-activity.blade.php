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
                        <div class="col-2">
                            Region
                        </div>
                        <div class="col-4">
                            <select class="mb-2 form-control">
                                <option>All</option>
                            </select>
                        </div>
                        <div class="col-2">
                            Agent
                        </div>
                        <div class="col-4">
                            <select class="mb-2 form-control">
                                <option>All</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div id="work_plan_this_week" class="col-12 table-responsive">
                            <div id="accordion" class="accordion-wrapper mb-3">
                                @php
                                    $date_ctr = 0;
                                @endphp
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
                                                $dars =  \DB::table('view_dar_agent')
                                                            ->where('date_added', $date->date_added)
                                                            ->where('type', '<>',  'work_plan')
                                                            ->where('type', '<>',  'doc_upload')
                                                            ->get();                                                
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
                                                            <th>Work Plan</th>
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
                                                            <td> -- -- </td>
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

