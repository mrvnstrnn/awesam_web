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
            <ul class="tabs-animated-shadow nav-justified tabs-animated nav">
                <li class="nav-item">
                    <a role="tab" class="nav-link" id="tab-c1-2" data-toggle="tab" href="#tab-animated1-2" aria-selected="false">
                        <span class="nav-text">Previous</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a role="tab" class="nav-link active" id="tab-c1-0" data-toggle="tab" href="#tab-animated1-0" aria-selected="false">
                        <span class="nav-text">This Week</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a role="tab" class="nav-link" id="tab-c1-1" data-toggle="tab" href="#tab-animated1-1" aria-selected="true">
                        <span class="nav-text">Upcoming</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">

                <div class="tab-pane" id="tab-animated1-2" role="tabpanel">
                    <div class="mb-3 mt-3 card">
                        <div class="card-body p-0">                                        
                            <div class="no-gutters row">
                                <div class="col-sm-4 border">         
                                    <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-orange-2.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>                                                                       
                                    <div class="widget-chart widget-chart-hover milestone_sites"  data-activity_name="" data-total="" data-activity_id="">
                                        <div class="widget-numbers">0%</div>
                                        <div class="widget-subheading">Schedule Adherence</div>
                                    </div>
                                </div>
                                <div class="col-sm-4 border">   
                                    <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-red.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>                                             
                                    <div class="widget-chart widget-chart-hover milestone_sites"  data-activity_name="" data-total="" data-activity_id="">
                                        <div class="widget-numbers">0%</div>
                                        <div class="widget-subheading">Planning Accuracy</div>
                                    </div>
                                </div>
                                <div class="col-sm-4 border"> 
                                    <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-green.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>                                               
                                    <div class="widget-chart widget-chart-hover milestone_sites"  data-activity_name="" data-total="" data-activity_id="">
                                        <div class="widget-numbers">0%</div>
                                        <div class="widget-subheading">Completion Rate</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 card">
                        <div class="dropdown-menu-header py-3 bg-warning border-bottom"   style=" background-image: url('/images/modal-background.jpeg'); background-size:cover;">
                            <div class="row px-4">
                                <div class="menu-header-content btn-pane-right">
                                    <h5 class="menu-header-title text-dark">
                                        <i class="header-icon pe-7s-date pe-lg font-weight-bold mr-1"></i>
                                         Previous Work Plan
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
                                <div id="work_plan_previous" class="col-12 table-responsive">
                                    @php 
                                        
                                        $Date = date('Y-m-d', strtotime('last monday', strtotime('tomorrow')));

                                        date_default_timezone_set('Asia/Manila');
                                        $Date = date('l F d, Y', strtotime($Date. ' - 7 days'));

                                        $work_plans = \DB::table('view_work_plans')
                                                                ->get();


                                    @endphp
                                    <table class="table table-bordered table-hover table-striped">
                                        <tbody>                                            
                                            @for ($i = 0; $i < 7; $i++)
                                            @php
                                                $xdate =  date('l F d, Y', strtotime($Date. ' + ' . $i . ' days'));
                                                $zdate =  date('Y-m-d', strtotime($Date. ' + ' . $i . ' days'));
                                                $wp_ctr = 0;
                                            @endphp
                                            <tr>
            
                                                <td  class="bg-secondary text-white text-bold" colspan="6">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <H5 class="p-0 m-0">{{ $xdate }}<H5>
                                                        </div>
                                                        <div class="col-6 text-right">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr  class="bg-light">
                                                <th>Site</th>
                                                <th>Activity</th>
                                                <th>Subactivity</th>
                                                <th>Method</th>
                                                <th>SAQ Objective</th>
                                                <th>Status</th>
                                            </tr>        
                                            @foreach ($work_plans as $work_plan)
                                                @php
                                                    $wp = json_decode($work_plan->value);
                                                @endphp
                                                @if($wp->planned_date == $zdate)
                                                @php
                                                    $wp_ctr++;
                                                @endphp
                                                <tr class="work_plan_view show_action_modal"  data-activity_source="work_plan_view" data-json='{"work_plan_id" : "{{$work_plan->id}}"}'>
                                                    <td>
                                                        <div class=''><strong>{{ $work_plan->site_name}}</strong></div>
                                                        <div class=""><small>{{ $work_plan->sam_id}}</small></div>
                                                    </td>
                                                    <td>{{ $wp->activity_name}}</td>
                                                    <td>{{ $work_plan->sub_activity_name}}</td>
                                                    <td>{{ $wp->method}}</td>
                                                    <td>{{ $wp->saq_objective}}</td>
                                                    <td>{{ ucfirst($work_plan->status) }}</td>
                                                </tr>
                                                @endif
                                            @endforeach

                                            @if($wp_ctr == 0)
                                            <tr>
                                                <td colspan="6" class="text-center py-3">Nothing Planned</td>
                                            </tr>
                                            @endif
                                        @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane active" id="tab-animated1-0" role="tabpanel">
                    <div class="mb-3 mt-3 card">
                        <div class="card-body p-0">                                        
                            <div class="no-gutters row">
                                <div class="col-3 col-sm-3 border">     
                                    <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-green-2.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>                                           
                                    <div class="widget-chart widget-chart-hover milestone_sites"  data-activity_name="" data-total="" data-activity_id="">
                                        <div class="widget-numbers">0</div>
                                        <div class="widget-subheading">Planned Activities</div>
                                    </div>
                                </div>
                                <div class="col-3 col-sm-3 border">            
                                    <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-orange-2.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>                                    
                                    <div class="widget-chart widget-chart-hover milestone_sites"  data-activity_name="" data-total="" data-activity_id="">
                                        <div class="widget-numbers">0%</div>
                                        <div class="widget-subheading">Schedule Adherence</div>
                                    </div>
                                </div>
                                <div class="col-3 col-sm-3 border">            
                                    <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-red.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>                                    
                                    <div class="widget-chart widget-chart-hover milestone_sites"  data-activity_name="" data-total="" data-activity_id="">
                                        <div class="widget-numbers">0%</div>
                                        <div class="widget-subheading">Planning Accuracy</div>
                                    </div>
                                </div>
                                <div class="col-3 col-sm-3 border">    
                                    <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-green.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>                                            
                                    <div class="widget-chart widget-chart-hover milestone_sites"  data-activity_name="" data-total="" data-activity_id="">
                                        <div class="widget-numbers">0%</div>
                                        <div class="widget-subheading">Completion Rate</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 card">
                        <div class="dropdown-menu-header py-3 bg-warning border-bottom"   style=" background-image: url('/images/modal-background.jpeg'); background-size:cover;">
                            <div class="row px-4">
                                <div class="menu-header-content btn-pane-right">
                                    <h5 class="menu-header-title text-dark">
                                        <i class="header-icon pe-7s-date pe-lg font-weight-bold mr-1"></i>
                                         Work Plan This Week
                                    </h5>
                                </div>
                                <div class="btn-actions-pane-right py-0">
                                </div>
                            </div>
                        </div>
        
                        {{-- <div class="card-header bg-dark text-white">
                            <i class="header-icon lnr-laptop-phone icon-gradient bg-white"></i>
                            Work Plan This Week
                        </div>                         --}}
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-12 text-right">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div id="work_plan_this_week" class="col-12 table-responsive">
                                    @php 
                                        $Date = date('Y-m-d', strtotime('last monday', strtotime('tomorrow')));

                                        $work_plans = \DB::table('view_work_plans')
                                                                ->get();


                                    @endphp
                                    <table class="table table-bordered table-hover table-striped">
                                        <tbody>                                            
                                            @for ($i = 0; $i < 7; $i++)
                                            @php
                                                $xdate =  date('l F d, Y', strtotime($Date. ' + ' . $i . ' days'));
                                                $zdate =  date('Y-m-d', strtotime($Date. ' + ' . $i . ' days'));
                                                $wp_ctr = 0;
                                            @endphp
                                            <tr>
            
                                                <td  class="bg-secondary text-white text-bold" colspan="6">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <H5 class="p-0 m-0">{{ $xdate }}<H5>
                                                        </div>
                                                        <div class="col-6 text-right">
                                                            {{-- @if(date('Y-m-d') <= $zdate)
                                                            <button type="button"  class=" btn-dark border btn-sm text-white btn px-2 mr-2 my-0">
                                                                Add Work Plan
                                                            </button>
                                                            @endif   --}}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr  class="bg-light">
                                                <th>Site</th>
                                                <th>Activity</th>
                                                <th>Subactivity</th>
                                                <th>Method</th>
                                                <th>SAQ Objective</th>
                                                <th>Status</th>
                                            </tr>        
                                            @foreach ($work_plans as $work_plan)
                                                @php
                                                    $wp = json_decode($work_plan->value);
                                                @endphp
                                                @if($wp->planned_date == $zdate)
                                                @php
                                                    $wp_ctr++;
                                                @endphp
                                                <tr class="work_plan_view show_action_modal"  data-activity_source="work_plan_view" data-json='{"work_plan_id" : "{{$work_plan->id}}"}'>
                                                    <td>
                                                        <div class=''><strong>{{ $work_plan->site_name}}</strong></div>
                                                        <div class=""><small>{{ $work_plan->sam_id}}</small></div>
                                                    </td>
                                                    <td>{{ $wp->activity_name}}</td>
                                                    <td>{{ $work_plan->sub_activity_name}}</td>
                                                    <td>{{ $wp->method}}</td>
                                                    <td>{{ $wp->saq_objective}}</td>
                                                    <td>{{ ucfirst($work_plan->status) }}</td>
                                                </tr>
                                                @endif
                                            @endforeach

                                            @if($wp_ctr == 0)
                                            <tr>
                                                <td colspan="6" class="text-center py-3">Nothing Planned</td>
                                            </tr>
                                            @endif
                                        @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab-animated1-1" role="tabpanel">
                    <div class="mb-3 mt-3 card">
                        <div class="card-body p-0">                                        
                            <div class="no-gutters row">
                                <div class="col-sm-4 border">           
                                    <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-gray.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>                                     
                                    <div class="widget-chart widget-chart-hover milestone_sites get_assigned_site"  data-activity_name="" data-total="" data-activity_id="">
                                        <div class="widget-numbers">0</div>
                                        <div class="widget-subheading">Assigned Sites</div>
                                    </div>
                                </div>
                                <div class="col-sm-4 border">      
                                    <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-orange.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>                                          
                                    <div class="widget-chart widget-chart-hover milestone_sites show_action_modal" data-activity_source="work_plan_add" data-activity_name="" data-total="" data-activity_id="">
                                        <div class="widget-numbers">0</div>
                                        {{-- <button type="button" data-activity_source="work_plan_add" data-json='{"planned_date" : "{{ $zdate }}"}' class="show_action_modal btn-dark border btn-sm text-white btn px-2 mr-2 my-0">
                                            Add Work Plan
                                        </button> --}}
                                        <div class="widget-subheading">Activities w/o Work Plan</div>
                                    </div>
                                </div>
                                <div class="col-sm-4 border"> 
                                    <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-green-2.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>                                               
                                    <div class="widget-chart widget-chart-hover milestone_sites"  data-activity_name="" data-total="" data-activity_id="">
                                        <div class="widget-numbers">0</div>
                                        <div class="widget-subheading">Planned Activities</div>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <div class="mb-3 card">
                        <div class="dropdown-menu-header py-3 bg-warning border-bottom"   style=" background-image: url('/images/modal-background.jpeg'); background-size:cover;">
                            <div class="row px-4">
                                <div class="menu-header-content btn-pane-right">
                                    <h5 class="menu-header-title text-dark">
                                        <i class="header-icon pe-7s-date pe-lg font-weight-bold mr-1"></i>
                                         Upcoming Work Plan
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
                                <div id="work_plan_upcoming" class="col-12 table-responsive">
                                    @php 
                                        $Date = date('Y-m-d', strtotime('last monday', strtotime('tomorrow')));

                                        $work_plans = \DB::table('view_work_plans')
                                                                ->get();
                                    @endphp
                                    <table class="table table-bordered table-hover table-striped">
                                        <tbody>                                            
                                            @for ($i = 7; $i < 14; $i++)
                                            @php
                                                $xdate =  date('l F d, Y', strtotime($Date. ' + ' . $i . ' days'));
                                                $zdate =  date('Y-m-d', strtotime($Date. ' + ' . $i . ' days'));
                                                $wp_ctr = 0;
                                            @endphp
                                            <tr>
            
                                                <td  class="bg-secondary text-white text-bold" colspan="6">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <H5 class="p-0 m-0">{{ $xdate }}<H5>
                                                        </div>
                                                        <div class="col-6 text-right">
                                                            <button type="button" data-activity_source="work_plan_add" data-json='{"planned_date" : "{{ $zdate }}"}' class="show_action_modal btn-dark border btn-sm text-white btn px-2 mr-2 my-0">
                                                                Add Work Plan
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr  class="bg-light">
                                                <th>Site</th>
                                                <th>Activity</th>
                                                <th>Subactivity</th>
                                                <th>Method</th>
                                                <th>SAQ Objective</th>
                                                <th>Status</th>
                                            </tr>        
                                            @foreach ($work_plans as $work_plan)
                                                @php
                                                    $wp = json_decode($work_plan->value);
                                                @endphp
                                                @if($wp->planned_date == $zdate)
                                                @php
                                                    $wp_ctr++;
                                                @endphp
                                                <tr class="work_plan_view show_action_modal"  data-activity_source="work_plan_view" data-json='{"work_plan_id" : "{{$work_plan->id}}"}'>
                                                    <td>
                                                        <div class=''><strong>{{ $work_plan->site_name}}</strong></div>
                                                        <div class=""><small>{{ $work_plan->sam_id}}</small></div>
                                                    </td>
                                                    <td>{{ $wp->activity_name}}</td>
                                                    <td>{{ $work_plan->sub_activity_name}}</td>
                                                    <td>{{ $wp->method}}</td>
                                                    <td>{{ $wp->saq_objective}}</td>
                                                    <td>{{ ucfirst($work_plan->status) }}</td>
                                                </tr>
                                                @endif
                                            @endforeach

                                            @if($wp_ctr == 0)
                                            <tr>
                                                <td colspan="6" class="text-center py-3">Nothing Planned</td>
                                            </tr>
                                            @endif
                                        @endfor
                                        </tbody>
                                    </table>
                                </div>
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
    
    <div class="modal fade" id="assigned-sites-modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="dropdown-menu-header">
                    <div class="dropdown-menu-header-inner bg-dark">
                        <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                        <div class="menu-header-content btn-pane-right">
                            <h5 class="menu-header-title">
                                Assigned Sites
                            </h5>
                        </div>
                    </div>
                </div> 
                <div class="modal-body">
                    <div class="container-fluid">
                        <table class="table table-hover assigned_sites_table">
                            <thead>
                                <tr>
                                    <th>SAM ID</th>
                                    <th>Site</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js_script')
<script>
    $(document).ready(function(){
        $(".get_assigned_site").on("click", function(){

            console.log("test");

            $("#assigned-sites-modal").modal("show");

            if ( ! $.fn.DataTable.isDataTable('.assigned_sites_table') ) {

                $('.assigned_sites_table').DataTable({
                    processing: true,
                    serverSide: true,
                    // pageLength: 3,
                    ajax: {
                        url: "/get-assigned-sites",
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    },
                    dataSrc: function(json){
                        return json.data;
                    },
                    columns: [
                        { data: "sam_id" },
                        { data: "site_name" }
                    ],
                });

            } else {
                $('.assigned_sites_table').DataTable().ajax.reload();
            }
        });
    });
</script>
<script src="\js\modal-loader.js"> </script>

@endsection

