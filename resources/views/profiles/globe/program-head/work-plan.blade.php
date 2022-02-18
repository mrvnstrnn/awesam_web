@extends('layouts.main')

@section('content')

<style>
    .work_plan_view{
        cursor: pointer;
    }
</style>

@php
    if(isset($user_id)) {
        $users = App\Models\User::find(isset($agent_user_id) ? $agent_user_id : $user_id);

        $get_user_under_sup = App\Models\UserDetail::select('user_details.user_id', 'users.name')
                        ->join('users', 'users.id', 'user_details.user_id')
                        ->where('IS_id', $user_id)
                        ->get();

        if ($users->profile_id == 3) {
            $get_user_under_me = $get_user_under_sup->pluck('user_id');

            $user_to_search = $get_user_under_me;
        } else {
            $user_to_search = [$agent_user_id];
        }

        if ($region_data != 'All') {
            $work_plans = \DB::table('view_work_plans')
                                ->whereIn('user_id',  $user_to_search)
                                ->where('sam_region_name', $region_data)
                                ->get();
        } else {
            $work_plans = \DB::table('view_work_plans')
                                ->whereIn('user_id',  $user_to_search)
                                ->get();

        }
    }
@endphp

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

                            <div class="row mb-3 border-bottom pb-3">
                                <div class="col-12">
                                    <form class="previous_plan_form" action="{{ route('work_plan') }}" method="POST">@csrf
                                        <div class="form-row">
                                            <div class="col-12 col-md-3">
                                                <label for="vendor">Vendor</label>
                                                <select class="mb-2 form-control" class="vendor">
                                                    <option value="All">All</option>
                                                </select>
                                            </div>

                                            <div class="col-12 col-md-3">
                                                <label for="region">Region</label>
                                                <select class="mb-2 form-control" name="region">
                                                    @php
                                                        $regions = \DB::table('location_sam_regions')
                                                                        ->get();  
                                                    @endphp
                                                    <option value="All">All</option>
                                                    @foreach ($regions as $region)
                                                    <option {{ isset($region_data) && $region->sam_region_name == $region_data ? "selected" : "" }} value="{{ $region->sam_region_name }}">{{ $region->sam_region_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="col-12 col-md-3">
                                                <label for="user_id">Supervisor</label>
                                                
                                                <select class="mb-2 form-control" name="user_id" id="user_id">
                                                    @php
                                                        $get_supervisor = App\Models\UserDetail::select('user_details.user_id', 'users.name')
                                                                                        ->join('users', 'users.id', 'user_details.user_id')
                                                                                        // ->where('IS_id', \Auth::id())
                                                                                        ->where('users.profile_id', 3)
                                                                                        ->get();
                                                    @endphp

                                                    <option value="">Please select user.</option>
                                                    @foreach ($get_supervisor as $user)
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

                                            <div class="col-12 col-md-3">
                                                <label for="agent_user_id">Agent</label>
                                                
                                                <select class="mb-2 form-control" name="agent_user_id" id="agent_user_id">
                                                    <option value="">Please select agent.</option>
                                                    @if ( isset($users) )
                                                        {{-- @if ( $users->profile_id == 3 ) --}}
                                                            @foreach ($get_user_under_sup as $item)
                                                                @php
                                                                    $selected = "";    
                                                                    if ( isset($agent_user_id) && $item->user_id == $agent_user_id ) {
                                                                        $selected = "selected";
                                                                    }
                                                                @endphp
                                                                <option {{ $selected }} value="{{ $item->user_id }}">{{ $item->name }}</option>
                                                            @endforeach
                                                        {{-- @endif --}}
                                                    @endif
                                                </select>
                                            </div>

                                            <button class="btn btn-primary btn-shadow" type="submit">Filter</button>
                                        
                                        </div>
                                        
                                    </form>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-12 text-right">
                                </div>
                            </div>

                            @if (isset($user_id))
                                <div class="row mb-3">
                                    <div id="work_plan_previous" class="col-12 table-responsive">
                                        @php 
                                            
                                            $Date = date('Y-m-d', strtotime('last monday', strtotime('tomorrow')));

                                            date_default_timezone_set('Asia/Manila');
                                            $Date = date('l F d, Y', strtotime($Date. ' - 7 days'));

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
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tab-pane active" id="tab-animated1-0" role="tabpanel">
                    <div class="mb-3 mt-3 card">
                        <div class="card-body p-0">                                        
                            <div class="no-gutters row">
                                <div class="col-md-3 col-12 border">     
                                    <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-green-2.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>                                           
                                    <div class="widget-chart widget-chart-hover milestone_sites"  data-activity_name="" data-total="" data-activity_id="">
                                        <div class="widget-numbers">0</div>
                                        <div class="widget-subheading">Planned Activities</div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-12 border">            
                                    <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-orange-2.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>                                    
                                    <div class="widget-chart widget-chart-hover milestone_sites"  data-activity_name="" data-total="" data-activity_id="">
                                        <div class="widget-numbers">0%</div>
                                        <div class="widget-subheading">Schedule Adherence</div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-12 border">            
                                    <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-red.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>                                    
                                    <div class="widget-chart widget-chart-hover milestone_sites"  data-activity_name="" data-total="" data-activity_id="">
                                        <div class="widget-numbers">0%</div>
                                        <div class="widget-subheading">Planning Accuracy</div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-12 border">    
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
                            
                            <div class="row mb-3 border-bottom pb-3">
                                <div class="col-12">
                                    <form class="work_plan_form" action="{{ route('work_plan') }}" method="POST">@csrf
                                        <div class="form-row">
                                            <div class="col-12 col-md-3">
                                                <label for="vendor">Vendor</label>
                                                <select class="mb-2 form-control" class="vendor">
                                                    <option>All</option>
                                                </select>
                                            </div>

                                            <div class="col-12 col-md-3">
                                                <label for="region">Region</label>
                                                <select class="mb-2 form-control" name="region">
                                                    @php
                                                        $regions = \DB::table('location_sam_regions')
                                                                        ->get();  
                                                    @endphp
                                                    <option value="All">All</option>
                                                    @foreach ($regions as $region)
                                                    <option {{ isset($region_data) && $region->sam_region_name == $region_data ? "selected" : "" }} value="{{ $region->sam_region_name }}">{{ $region->sam_region_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="col-12 col-md-3">
                                                <label for="user_id">Supervisor</label>
                                                
                                                <select class="mb-2 form-control" name="user_id" id="user_id">
                                                    @php
                                                        $get_supervisor = App\Models\UserDetail::select('user_details.user_id', 'users.name')
                                                                                        ->join('users', 'users.id', 'user_details.user_id')
                                                                                        // ->where('IS_id', \Auth::id())
                                                                                        ->where('users.profile_id', 3)
                                                                                        ->get();
                                                    @endphp

                                                    <option value="">Please select user.</option>
                                                    @foreach ($get_supervisor as $user)
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

                                            <div class="col-12 col-md-3">
                                                <label for="agent_user_id">Agent</label>
                                                
                                                <select class="mb-2 form-control" name="agent_user_id" id="agent_user_id">
                                                    <option value="">Please select agent.</option>
                                                    @if ( isset($users) )
                                                        {{-- @if ( $users->profile_id == 3 ) --}}
                                                            @foreach ($get_user_under_sup as $item)
                                                                @php
                                                                    $selected = "";    
                                                                    if ( isset($agent_user_id) && $item->user_id == $agent_user_id ) {
                                                                        $selected = "selected";
                                                                    }
                                                                @endphp
                                                                <option {{ $selected }} value="{{ $item->user_id }}">{{ $item->name }}</option>
                                                            @endforeach
                                                        {{-- @endif --}}
                                                    @endif
                                                </select>
                                            </div>

                                            <button class="btn btn-primary btn-shadow" type="submit">Filter</button>
                                        
                                        </div>
                                        
                                    </form>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-12 text-right">
                                </div>
                            </div>
                            
                            @if (isset($user_id))
                                <div class="row mb-3">
                                    <div id="work_plan_this_week" class="col-12 table-responsive">
                                        @php 
                                            $Date = date('Y-m-d', strtotime('last monday', strtotime('tomorrow')));
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
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab-animated1-1" role="tabpanel">
                    <div class="mb-3 mt-3 card">
                        <div class="card-body p-0">                                        
                            <div class="no-gutters row">
                                <div class="col-sm-4 border">           
                                    <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-gray.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>                                     
                                    <div class="widget-chart widget-chart-hover milestone_sites"  data-activity_name="" data-total="" data-activity_id="">
                                        <div class="widget-numbers">0</div>
                                        <div class="widget-subheading">Assigned Sites</div>
                                    </div>
                                </div>
                                <div class="col-sm-4 border">      
                                    <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-orange.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>                                          
                                    <div class="widget-chart widget-chart-hover milestone_sites"  data-activity_name="" data-total="" data-activity_id="">
                                        <div class="widget-numbers">0</div>
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
                            
                            <div class="row mb-3 border-bottom pb-3">
                                <div class="col-12">
                                    <form class="upcoming_plan_form" action="{{ route('work_plan') }}" method="POST">@csrf
                                        <div class="form-row">
                                            <div class="col-12 col-md-3">
                                                <label for="vendor">Vendor</label>
                                                <select class="mb-2 form-control" class="vendor">
                                                    <option>All</option>
                                                </select>
                                            </div>

                                            <div class="col-12 col-md-3">
                                                <label for="region">Region</label>
                                                <select class="mb-2 form-control" name="region">
                                                    @php
                                                        $regions = \DB::table('location_sam_regions')
                                                                        ->get();  
                                                    @endphp
                                                    <option value="All">All</option>
                                                    @foreach ($regions as $region)
                                                    <option {{ isset($region_data) && $region->sam_region_name == $region_data ? "selected" : "" }} value="{{ $region->sam_region_name }}">{{ $region->sam_region_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="col-12 col-md-3">
                                                <label for="user_id">Supervisor</label>
                                                
                                                <select class="mb-2 form-control" name="user_id" id="user_id">
                                                    @php
                                                        $get_supervisor = App\Models\UserDetail::select('user_details.user_id', 'users.name')
                                                                                        ->join('users', 'users.id', 'user_details.user_id')
                                                                                        // ->where('IS_id', \Auth::id())
                                                                                        ->where('users.profile_id', 3)
                                                                                        ->get();
                                                    @endphp

                                                    <option value="">Please select user.</option>
                                                    @foreach ($get_supervisor as $user)
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

                                            <div class="col-12 col-md-3">
                                                <label for="agent_user_id">Agent</label>
                                                
                                                <select class="mb-2 form-control" name="agent_user_id" id="agent_user_id">
                                                    <option value="">Please select agent.</option>
                                                    @if ( isset($users) )
                                                        {{-- @if ( $users->profile_id == 3 ) --}}
                                                            @foreach ($get_user_under_sup as $item)
                                                                @php
                                                                    $selected = "";    
                                                                    if ( isset($agent_user_id) && $item->user_id == $agent_user_id ) {
                                                                        $selected = "selected";
                                                                    }
                                                                @endphp
                                                                <option {{ $selected }} value="{{ $item->user_id }}">{{ $item->name }}</option>
                                                            @endforeach
                                                        {{-- @endif --}}
                                                    @endif
                                                </select>
                                            </div>

                                            <button class="btn btn-primary btn-shadow" type="submit">Filter</button>
                                        
                                        </div>
                                        
                                    </form>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-12 text-right">
                                </div>
                            </div>

                            @if (isset($user_id))
                                <div class="row mb-3">
                                    <div id="work_plan_upcoming" class="col-12 table-responsive">
                                        @php 
                                            $Date = date('Y-m-d', strtotime('last monday', strtotime('tomorrow')));
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
                                                                {{-- <button type="button" data-activity_source="work_plan_add" data-json='{"planned_date" : "{{ $zdate }}"}' class="show_action_modal btn-dark border btn-sm text-white btn px-2 mr-2 my-0">
                                                                    Add Work Plan
                                                                </button> --}}
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
                            @endif
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
<script>

    $("select#user_id").on("change", function() {

        var user_id = $(this).val();
        
        if ( user_id != '') {
            $.ajax({
                url: "/get-agent-of-supervisor/" + user_id,
                method: "GET",
                success: function (resp) {
                    
                    $(".previous_plan_form #agent_user_id option, .work_plan_form #agent_user_id option, .upcoming_plan_form #agent_user_id option").remove();

                    if (resp.message.length < 1) {
                        $(".previous_plan_form #agent_user_id, .work_plan_form #agent_user_id, .upcoming_plan_form #agent_user_id").append(
                            '<option value="">No agent available.</option>'
                        );
                    } else {
                        $(".previous_plan_form #agent_user_id, .work_plan_form #agent_user_id, .upcoming_plan_form #agent_user_id").append(
                            '<option value="">Please select agent.</option>'
                        );

                        resp.message.forEach(element => {
                            $(".previous_plan_form #agent_user_id, .work_plan_form #agent_user_id, .upcoming_plan_form #agent_user_id").append(
                                '<option value="'+ element.id +'">' + element.firstname + ' ' + element.lastname + '</option>'
                            );
                        });
                    }
                },
                error: function (resp) {
                    Swal.fire(
                        'Error',
                        resp.message,
                        'error'
                    )
                }
            });
        }
    });
</script>
<script src="\js\modal-loader.js"> </script>

@endsection

