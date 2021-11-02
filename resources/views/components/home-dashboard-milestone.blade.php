@php
    if(\Auth::user()->profile_id == 2){
        $title = "My Site Milestones";
    }
    elseif(\Auth::user()->profile_id == 3){
        $title = "My Team's Site Milestones";
    }

    $milestones = \DB::table('view_COLOC_dashboard_agent')
                    ->orderBy('activity_id', 'asc') 
                    ->get();

@endphp

<div class="row">
    <div class="col-12">
        <h3>{{ $title }}</h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="main-card mb-3 card">
                <div class="no-gutters row">
                    @foreach ($milestones as $milestone)                        
                    <div class="col-sm-3 border">
                        {{-- <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.10; height: 100%; width:100%; background-image: url('/images/milestone-orange-2.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div> --}}

                        <div class="widget-chart widget-chart-hover milestone_sites"  data-activity_name="{{ $milestone->activity_name}}" data-total="{{ $milestone->counter}}" data-activity_id="{{ $milestone->activity_id}}">
                            <div class="widget-numbers">{{ $milestone->counter}}</div>
                            <div class="widget-subheading">{{ $milestone->activity_name}}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
        
        </div>
        <div class="text-center">
            <button class="btn-pill btn-shadow btn-wide fsize-1 btn btn-dark btn-md">
                <span class="mr-2 opacity-7">
                    <i class="fa fa-cog fa-spin"></i>
                </span>
                <span class="mr-1">View Assigned Sites</span>
            </button>
        </div>
    </div>

</div>
