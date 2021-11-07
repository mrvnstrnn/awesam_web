@php
    if(\Auth::user()->profile_id == 2){
        $title = "My Site Milestones";
        $table = 'view_milestone_stages_globe';
    }
    elseif(\Auth::user()->profile_id == 3){
        $title = "My Team's Site Milestones";
        $table = 'view_milestone_stages_globe';
    }
    else{
        $title = "Site Milestones";
        $table = 'view_milestone_stages_globe';
    }

    $milestones = \DB::table($table)
                    ->select('stage_id', 'stage_name', DB::raw("SUM(counter) as counter"))
                    ->groupBy('stage_id', 'stage_name')
                    ->get();
    $i = 0;

@endphp

<div class="row">
    <div class="col-12">
        <h3>{{ $title }}</h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="main-card mb-3 card">
                <div class="no-gutters row border">
                    @foreach ($milestones as $milestone)    
                    @php
                        $i ++;
                    @endphp                    
                    <div class="col-sm-3 border">
                        <div class="milestone-bg bg_img_{{ $i }}"></div>

                        <div class="widget-chart widget-chart-hover milestone_sites">
                            <div class="widget-numbers">{{ $milestone->counter}}</div>
                            <div class="widget-subheading">{{ $milestone->stage_name}}</div>
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
                <span class="mr-1">View Sites</span>
            </button>
        </div>
    </div>

</div>
