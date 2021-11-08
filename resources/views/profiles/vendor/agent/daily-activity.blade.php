@extends('layouts.main')

@section('content')

<style>
    .work_plan_view{
        cursor: pointer;
    }
</style>


<div id="workplan-list" class='mt-5'>
    <div class="row">
        <div class="col-12">
            <div class="mb-3 card">
                <div class="dropdown-menu-header py-3 bg-warning border-bottom"   style=" background-image: url('/images/modal-background.jpeg'); background-size:cover;">
                    <div class="row px-4">
                        <div class="menu-header-content btn-pane-right">
                            <h5 class="menu-header-title text-dark">
                                <i class="header-icon pe-7s-date pe-lg font-weight-bold mr-1"></i>
                                 My Activities
                            </h5>
                        </div>
                        <div class="btn-actions-pane-right py-0">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-12 text-right">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div id="work_plan_this_week" class="col-12 table-responsive">
                            @php 
                                $Date = date('Y-m-d',strtotime('last monday'));

                                $dates = \DB::table('view_dar_agent')
                                            ->distinct()
                                            ->select('date_added', 'site_name', 'sam_id')
                                            ->where('user_id', \Auth::user()->id)
                                            ->where('type', '<>',  'work_plan')
                                            ->where('type', '<>',  'doc_upload')
                                            ->get();

                                $dars =  \DB::table('view_dar_agent')
                                            ->where('user_id', \Auth::user()->id)
                                            ->where('type', '<>',  'work_plan')
                                            ->where('type', '<>',  'doc_upload')
                                            ->get();
                                           
                                            
                                $current_date = "";
                                $previous_date = "0";
                                $ctr = 0;

                                foreach($dates as $date){
                                    
                                    $current_date = $date->date_added;
                                    $ctr++;

                                    if($current_date <> $previous_date){
                                        if($previous_date != "0"){                                                    
                                            echo "</div>";
                                        }
                                        echo "<div class='border-top pt-2 mb-3'><div class='col-12 p-0'>";
                                        echo "<H3 class='' style='font-weight: bolder;'>" . $date->date_added . "</H3></div>";
                                        echo "<div class='pt-3 border-top'>"; 
                                            echo "<div class='row'>";
                                                echo "<div class='col-md-3'>";
                                                    echo "<H5 class='m-0 p-0'>" . $date->site_name . "</H5>"; 
                                                    echo "<small>" . $date->sam_id . "</small>";
                                                echo "</div>";
                                                echo "<div class='col-md-9'>";
                            @endphp
                                                        <table class='table table-bordered table-striped table-sm'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Sub Activity</th>
                                                                    <th>Method</th>
                                                                    <th>SAQ Objective</th>
                                                                    <th>Work Plan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($dars as $dar )
                                                                    @if($dar->date_added == $date->date_added && $dar->sam_id == $date->sam_id)
                                                                    <tr>
                                                                        <td>{{ $dar->sub_activity_name }}</td>
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
                                                                    @endif
                                                                @endforeach    
                                                            </tbody>
                                                        </table>
                            @php                                                            
                                                echo "</div>";
                                            echo "</div>";
                                        echo "</div>";
                                    } else {
                                        echo "<div class='pt-3 border-top'>"; 
                                            echo "<div class='row'>";
                                                echo "<div class='col-md-3'>";
                                                    echo "<H5 class='m-0 p-0'>" . $date->site_name . "</H5>"; 
                                                    echo "<small>" . $date->sam_id . "</small>";
                                                echo "</div>";
                                                echo "<div class='col-md-9'>";
                            @endphp
                                                        <table class='table table-bordered table-striped table-sm'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Sub Activity</th>
                                                                    <th>Method</th>
                                                                    <th>SAQ Objective</th>
                                                                    <th>Work Plan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($dars as $dar )
                                                                    @if($dar->date_added == $date->date_added && $dar->sam_id == $date->sam_id)
                                                                    <tr>
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
                                                                    @endif
                                                                @endforeach    
                                                            </tbody>
                                                        </table>
                            @php                                                            
                                                echo "</div>";
                                            echo "</div>";
                                        echo "</div>";
                                    }

                                    // if(count($dates) == $ctr){
                                    //     echo "<hr>CLOSE";
                                    // }

                                    $previous_date = $current_date;
                                    

                                    
                                }


                            @endphp
                            {{-- @for ($i = 0; $i < 7; $i++)
                            
                                @php
                                    $xdate =  date('l F d, Y', strtotime($Date. ' + ' . $i . ' days'));
                                    $zdate =  date('Y-m-d', strtotime($Date. ' + ' . $i . ' days'));
                                    $wp_ctr = 0;
                                @endphp

                                {{ $xdate }}



                            @endfor --}}
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

