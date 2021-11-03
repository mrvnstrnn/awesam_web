@extends('layouts.main')

@section('content')

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
                                    <div class="widget-chart widget-chart-hover milestone_sites"  data-activity_name="" data-total="" data-activity_id="">
                                        <div class="widget-numbers">0%</div>
                                        <div class="widget-subheading">Schedule Adherence</div>
                                    </div>
                                </div>
                                <div class="col-sm-4 border">            
                                    <div class="widget-chart widget-chart-hover milestone_sites"  data-activity_name="" data-total="" data-activity_id="">
                                        <div class="widget-numbers">0%</div>
                                        <div class="widget-subheading">Planning Accuracy</div>
                                    </div>
                                </div>
                                <div class="col-sm-4 border">            
                                    <div class="widget-chart widget-chart-hover milestone_sites"  data-activity_name="" data-total="" data-activity_id="">
                                        <div class="widget-numbers">0%</div>
                                        <div class="widget-subheading">Completion Rate</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 card">
                        <div class="card-body">                                        
                            <table class="table table-bordered table-sm">
                                <tbody>
                                    <tr>
                                        <td  class="bg-secondary p-2 text-white" colspan="6">January 1, 2021</td>
                                    </tr>
                                    <tr>
                                        <th>Site</th>
                                        <th>Activity</th>
                                        <th>Subactivity</th>
                                        <th>Mode</th>
                                        <th>SAQ Objective</th>
                                        <th>Status</th>
                                    </tr>
                                    <tr>
                                        <td>Site</td>
                                        <td>Activity</td>
                                        <td>Subactivity</td>
                                        <td>Mode</td>
                                        <td>SAQ Objective</td>
                                        <td>Status</td>
                                    </tr>
                                    <tr>
                                        <td>Site</td>
                                        <td>Activity</td>
                                        <td>Subactivity</td>
                                        <td>Mode</td>
                                        <td>SAQ Objective</td>
                                        <td>Status</td>
                                    </tr>
                                    <tr>
                                        <td  class="bg-secondary p-2 text-white" colspan="6">January 2, 2021</td>
                                    </tr>
                                    <tr>
                                        <th>Site</th>
                                        <th>Activity</th>
                                        <th>Subactivity</th>
                                        <th>Mode</th>
                                        <th>SAQ Objective</th>
                                        <th>Status</th>
                                    </tr>
                                    <tr>
                                        <td>Site</td>
                                        <td>Activity</td>
                                        <td>Subactivity</td>
                                        <td>Mode</td>
                                        <td>SAQ Objective</td>
                                        <td>Status</td>
                                    </tr>
                                    <tr>
                                        <td  class="bg-secondary p-2 text-white" colspan="6">January 3, 2021</td>
                                    </tr>
                                    <tr>
                                        <th>Site</th>
                                        <th>Activity</th>
                                        <th>Subactivity</th>
                                        <th>Mode</th>
                                        <th>SAQ Objective</th>
                                        <th>Status</th>
                                    </tr>
                                    <tr>
                                        <td>Site</td>
                                        <td>Activity</td>
                                        <td>Subactivity</td>
                                        <td>Mode</td>
                                        <td>SAQ Objective</td>
                                        <td>Status</td>
                                    </tr>
                                    <tr>
                                        <td  class="bg-secondary p-2 text-white" colspan="6">January 4, 2021</td>
                                    </tr>
                                    <tr>
                                        <th>Site</th>
                                        <th>Activity</th>
                                        <th>Subactivity</th>
                                        <th>Mode</th>
                                        <th>SAQ Objective</th>
                                        <th>Status</th>
                                    </tr>
                                    <tr>
                                        <td>Site</td>
                                        <td>Activity</td>
                                        <td>Subactivity</td>
                                        <td>Mode</td>
                                        <td>SAQ Objective</td>
                                        <td>Status</td>
                                    </tr>
                                    <tr>
                                        <td  class="bg-secondary p-2 text-white" colspan="6">January 5, 2021</td>
                                    </tr>
                                    <tr>
                                        <th>Site</th>
                                        <th>Activity</th>
                                        <th>Subactivity</th>
                                        <th>Mode</th>
                                        <th>SAQ Objective</th>
                                        <th>Status</th>
                                    </tr>
                                    <tr>
                                        <td>Site</td>
                                        <td>Activity</td>
                                        <td>Subactivity</td>
                                        <td>Mode</td>
                                        <td>SAQ Objective</td>
                                        <td>Status</td>
                                    </tr>
                                    <tr>
                                        <td  class="bg-secondary p-2 text-white" colspan="6">January 6, 2021</td>
                                    </tr>
                                    <tr>
                                        <th>Site</th>
                                        <th>Activity</th>
                                        <th>Subactivity</th>
                                        <th>Mode</th>
                                        <th>SAQ Objective</th>
                                        <th>Status</th>
                                    </tr>
                                    <tr>
                                        <td>Site</td>
                                        <td>Activity</td>
                                        <td>Subactivity</td>
                                        <td>Mode</td>
                                        <td>SAQ Objective</td>
                                        <td>Status</td>
                                    </tr>
                                    <tr>
                                        <td  class="bg-secondary p-2 text-white" colspan="6">January 7, 2021</td>
                                    </tr>
                                    <tr>
                                        <th>Site</th>
                                        <th>Activity</th>
                                        <th>Subactivity</th>
                                        <th>Mode</th>
                                        <th>SAQ Objective</th>
                                        <th>Status</th>
                                    </tr>
                                    <tr>
                                        <td>Site</td>
                                        <td>Activity</td>
                                        <td>Subactivity</td>
                                        <td>Mode</td>
                                        <td>SAQ Objective</td>
                                        <td>Status</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane active" id="tab-animated1-0" role="tabpanel">
                    <div class="mb-3 mt-3 card">
                        <div class="card-body p-0">                                        
                            <div class="no-gutters row">
                                <div class="col-3 col-sm-3 border">            
                                    <div class="widget-chart widget-chart-hover milestone_sites"  data-activity_name="" data-total="" data-activity_id="">
                                        <div class="widget-numbers">0</div>
                                        <div class="widget-subheading">Planned Activities</div>
                                    </div>
                                </div>
                                <div class="col-3 col-sm-3 border">            
                                    <div class="widget-chart widget-chart-hover milestone_sites"  data-activity_name="" data-total="" data-activity_id="">
                                        <div class="widget-numbers">0%</div>
                                        <div class="widget-subheading">Schedule Adherence</div>
                                    </div>
                                </div>
                                <div class="col-3 col-sm-3 border">            
                                    <div class="widget-chart widget-chart-hover milestone_sites"  data-activity_name="" data-total="" data-activity_id="">
                                        <div class="widget-numbers">0%</div>
                                        <div class="widget-subheading">Planning Accuracy</div>
                                    </div>
                                </div>
                                <div class="col-3 col-sm-3 border">            
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
                                    <button type="button" aria-haspopup="true" data-toggle="dropdown" aria-expanded="false" class=" btn-dark px-3 py-2 text-white btn mr-2 my-0">
                                        Add Engagement
                                    </button>        
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
                                <div class="col-12">
                                    @php 
                                        $Date = date('Y-m-d',strtotime('last monday'));
                                    @endphp

                                    <table class="table table-bordered table-sm">
                                        <tbody>
                                                
                                            @for ($i = 0; $i < 7; $i++)
                                            @php
                                                $xdate =  date('l F d, Y', strtotime($Date. ' + ' . $i . ' days'));


                                            @endphp
                                            <tr>
                                                <td  class="bg-secondary p-2 text-white" colspan="6">{{ $xdate }}</td>
                                            </tr>
                                            <tr>
                                                <th>Site</th>
                                                <th>Activity</th>
                                                <th>Subactivity</th>
                                                <th>Mode</th>
                                                <th>SAQ Objective</th>
                                                <th>Status</th>
                                            </tr>
                                            <tr>
                                                <td>Site</td>
                                                <td>Activity</td>
                                                <td>Subactivity</td>
                                                <td>Mode</td>
                                                <td>SAQ Objective</td>
                                                <td>Status</td>
                                            </tr>
                                            <tr>
                                                <td>Site</td>
                                                <td>Activity</td>
                                                <td>Subactivity</td>
                                                <td>Mode</td>
                                                <td>SAQ Objective</td>
                                                <td>Status</td>
                                            </tr>
                                                
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
                                    <div class="widget-chart widget-chart-hover milestone_sites"  data-activity_name="" data-total="" data-activity_id="">
                                        <div class="widget-numbers">0</div>
                                        <div class="widget-subheading">Assigned Sites</div>
                                    </div>
                                </div>
                                <div class="col-sm-4 border">            
                                    <div class="widget-chart widget-chart-hover milestone_sites"  data-activity_name="" data-total="" data-activity_id="">
                                        <div class="widget-numbers">0</div>
                                        <div class="widget-subheading">Activities w/o Work Plan</div>
                                    </div>
                                </div>
                                <div class="col-sm-4 border">            
                                    <div class="widget-chart widget-chart-hover milestone_sites"  data-activity_name="" data-total="" data-activity_id="">
                                        <div class="widget-numbers">0</div>
                                        <div class="widget-subheading">Planned Activities</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 card">
                        <div class="card-body">
                            <table class="table table-bordered table-sm">
                                <tbody>
                                    <tr>
                                        <td  class="bg-secondary p-2 text-white" colspan="6">January 1, 2021</td>
                                    </tr>
                                    <tr>
                                        <th>Site</th>
                                        <th>Activity</th>
                                        <th>Subactivity</th>
                                        <th>Mode</th>
                                        <th>SAQ Objective</th>
                                        <th>Status</th>
                                    </tr>
                                    <tr>
                                        <td>Site</td>
                                        <td>Activity</td>
                                        <td>Subactivity</td>
                                        <td>Mode</td>
                                        <td>SAQ Objective</td>
                                        <td>Status</td>
                                    </tr>
                                    <tr>
                                        <td>Site</td>
                                        <td>Activity</td>
                                        <td>Subactivity</td>
                                        <td>Mode</td>
                                        <td>SAQ Objective</td>
                                        <td>Status</td>
                                    </tr>
                                    <tr>
                                        <td  class="bg-secondary p-2 text-white" colspan="6">January 2, 2021</td>
                                    </tr>
                                    <tr>
                                        <th>Site</th>
                                        <th>Activity</th>
                                        <th>Subactivity</th>
                                        <th>Mode</th>
                                        <th>SAQ Objective</th>
                                        <th>Status</th>
                                    </tr>
                                    <tr>
                                        <td>Site</td>
                                        <td>Activity</td>
                                        <td>Subactivity</td>
                                        <td>Mode</td>
                                        <td>SAQ Objective</td>
                                        <td>Status</td>
                                    </tr>
                                    <tr>
                                        <td  class="bg-secondary p-2 text-white" colspan="6">January 3, 2021</td>
                                    </tr>
                                    <tr>
                                        <th>Site</th>
                                        <th>Activity</th>
                                        <th>Subactivity</th>
                                        <th>Mode</th>
                                        <th>SAQ Objective</th>
                                        <th>Status</th>
                                    </tr>
                                    <tr>
                                        <td>Site</td>
                                        <td>Activity</td>
                                        <td>Subactivity</td>
                                        <td>Mode</td>
                                        <td>SAQ Objective</td>
                                        <td>Status</td>
                                    </tr>
                                    <tr>
                                        <td  class="bg-secondary p-2 text-white" colspan="6">January 4, 2021</td>
                                    </tr>
                                    <tr>
                                        <th>Site</th>
                                        <th>Activity</th>
                                        <th>Subactivity</th>
                                        <th>Mode</th>
                                        <th>SAQ Objective</th>
                                        <th>Status</th>
                                    </tr>
                                    <tr>
                                        <td>Site</td>
                                        <td>Activity</td>
                                        <td>Subactivity</td>
                                        <td>Mode</td>
                                        <td>SAQ Objective</td>
                                        <td>Status</td>
                                    </tr>
                                    <tr>
                                        <td  class="bg-secondary p-2 text-white" colspan="6">January 5, 2021</td>
                                    </tr>
                                    <tr>
                                        <th>Site</th>
                                        <th>Activity</th>
                                        <th>Subactivity</th>
                                        <th>Mode</th>
                                        <th>SAQ Objective</th>
                                        <th>Status</th>
                                    </tr>
                                    <tr>
                                        <td>Site</td>
                                        <td>Activity</td>
                                        <td>Subactivity</td>
                                        <td>Mode</td>
                                        <td>SAQ Objective</td>
                                        <td>Status</td>
                                    </tr>
                                    <tr>
                                        <td  class="bg-secondary p-2 text-white" colspan="6">January 6, 2021</td>
                                    </tr>
                                    <tr>
                                        <th>Site</th>
                                        <th>Activity</th>
                                        <th>Subactivity</th>
                                        <th>Mode</th>
                                        <th>SAQ Objective</th>
                                        <th>Status</th>
                                    </tr>
                                    <tr>
                                        <td>Site</td>
                                        <td>Activity</td>
                                        <td>Subactivity</td>
                                        <td>Mode</td>
                                        <td>SAQ Objective</td>
                                        <td>Status</td>
                                    </tr>
                                    <tr>
                                        <td  class="bg-secondary p-2 text-white" colspan="6">January 7, 2021</td>
                                    </tr>
                                    <tr>
                                        <th>Site</th>
                                        <th>Activity</th>
                                        <th>Subactivity</th>
                                        <th>Mode</th>
                                        <th>SAQ Objective</th>
                                        <th>Status</th>
                                    </tr>
                                    <tr>
                                        <td>Site</td>
                                        <td>Activity</td>
                                        <td>Subactivity</td>
                                        <td>Mode</td>
                                        <td>SAQ Objective</td>
                                        <td>Status</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>            
        </div>
    </div>

</div>


@endsection