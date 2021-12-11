@php
    if(\Auth::user()->profile_id == 2){
        $title = "My Productivity";
        $view_work_plan = "View My Work Plan";
        $view_dar = "View My DAR";

    }
    elseif(\Auth::user()->profile_id == 3){
        $title = "My Team's Productivity";
        $view_work_plan = "View Team's Work Plan";
        $view_dar = "View Team's DAR";
    } else {
        $title = "Productivity";
        $view_work_plan = "View Work Plan";
        $view_dar = "View DAR";
    }
@endphp
<div class="row">
    <div class="col-12">
        <h3>{{$title}}</h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="main-card mb-4 card">
            <div class="grid-menu grid-menu-3col">
                <div class="no-gutters row">
                    <div class="col-6 col-sm-6 col-md-4 col-lg-4">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-green-2.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>

                        <div class="widget-chart widget-chart-hover">
                            <div class="widget-numbers">10</div>
                            <div class="widget-subheading">Planned Activities</div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 col-lg-4">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-primary.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>
                        <div class="widget-chart widget-chart-hover">
                            <div class="widget-numbers">1</div>
                            <div class="widget-subheading">Unplanned Activities</div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 col-lg-4">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-orange.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>
                        <div class="widget-chart widget-chart-hover">
                            <div class="widget-numbers">1</div>
                            <div class="widget-subheading">Completed Activities</div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 col-lg-4">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-orange-2.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>
                        <div class="widget-chart widget-chart-hover">
                            <div class="widget-numbers">10%</div>
                            <div class="widget-subheading">Schedule Adherence</div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 col-lg-4">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-red.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>
                        <div class="widget-chart widget-chart-hover">
                            <div class="widget-numbers">10%</div>
                            <div class="widget-subheading">Planning Accuracy</div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 col-lg-4">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-green.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>
                        <div class="widget-chart widget-chart-hover">
                            <div class="widget-numbers">10%</div>
                            <div class="widget-subheading">Completion Rate</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
        <div class="text-center">
            <button class="btn-pill btn-shadow btn-wide fsize-1 btn btn-dark btn-md">
                <span class="mr-2 opacity-7">
                    <i class="fa fa-cog fa-spin"></i>
                </span>
                <span class="mr-1">{{ $view_work_plan }}</span>
            </button>
            <button class="btn-pill ml-2 btn-shadow btn-wide fsize-1 btn btn-dark btn-md">
                <span class="mr-2 opacity-7">
                    <i class="fa fa-cog fa-spin"></i>
                </span>
                <span class="mr-1">{{ $view_dar }}</span>
            </button>
        </div>
    </div>        
</div> 
<div class="divider"></div>
