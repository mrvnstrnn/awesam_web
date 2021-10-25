@php
    $site_status = \DB::connection('mysql2')
        ->table('view_sites_activity_progress')
        ->select('site_name', 'sam_id', 'site_category','activity_name', 'progress', 'agent_id')
        // ->whereJsonContains('site_agent', [
        //     'user_id' => \Auth::id()
        // ])
        ->where('progress','<', 1)
        ->where('agent_id', \Auth::id())
        ->distinct()
        ->orderBy('sam_id', 'asc')
        ->get();

    // $site_status = \DB::connection('mysql2')
    //     ->table('view_sites_activity')
    //     ->select('site_name', 'progress', 'sam_id', 'site_category','activity_name')
    //     ->whereJsonContains('site_agent', [
    //         'user_id' => \Auth::id()
    //     ])
    //     ->where('activity_complete', 'false')
    //     ->where('profile_id', 2)
    //     ->get();
@endphp
<style>
    .progressSiteName{
        width: 400px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 14px;
        font-weight: bold;    
    }
  
</style>
<div id="progress_list">
@foreach ($site_status as $site_)
    <div class="pl-3 py-2 border-bottom mx-1 site_progress_row" data-work_plan="" data-sam_id="{{ $site_->sam_id }}" data-main_activity="assigned site" data-site="{{ $site_->site_name }}">
        <div class="row">
            <div class="col-3 ml-1" style="max-width: 55px; padding:0">
                <div class="circle-progress circle-progress-primary d-inline-block">
                    <small><span class="site_progress">{{ $site_->progress }}</span></small>
                </div>
            </div>
            {{-- <i class="ml-3 mt-1 header-icon lnr-location icon-gradient bg-mixed-hopes"></i> --}}
            <div class="ml-0 col-9">
                <div class="progressSiteName" style="">{{ $site_->site_name }}</div>
                <div class="badge badge-dark" style="font-size: 9px !important;">{{ $site_->activity_name }}</div>
                <div>
                <small>{{ $site_->sam_id }} {{ $site_->site_category == "none" ? "" : $site_->site_category }}</small>
                </div>
            </div>
        </div>
        <div class="row border-top workPlan d-none" data-work_plan="">
            <div class="col-12">
                <H5 class="mt-4 mb-4 pl-3">Add Work Plan</H5>
                <form class="form">

                    <div class="row py-0 px-4" id="control_box_log">
                        <div class="col-md-3 col-sm-6 col-xs-6 my-3 text-center contact-lessor_log" data-value="Call">
                            <i class="fa fa-phone fa-4x" aria-hidden="true" title=""></i>
                            <div class="pt-3"><small>Call</small></div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6 my-3 text-center contact-lessor_log" data-value="Text">
                            <i class="fa fa-mobile fa-4x" aria-hidden="true" title=""></i>
                            <div class="pt-3"><small>Text</small></div>
                        </div>
                        <div class="col-md-3 col-sm-6 my-3 text-center contact-lessor_log" data-value="Email">
                            <i class="fa fa-envelope fa-4x" aria-hidden="true" title=""></i>
                            <div class="pt-3"><small>Email</small></div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6 my-3 text-center contact-lessor_log" data-value="Site Visit">
                            <i class="fa fa-location-arrow fa-4x" aria-hidden="true" title=""></i>
                            <div class="pt-3"><small>Site Visit</small></div>
                
                        </div>
                    </div>                    
                    <div class="form-group">
                        <div class="col-12">
                            <label >Milestone Activity</label>
                            <select class="form-control">
                                <option>Select Milestone Activity</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-12">
                            <label >Schedule Date</label>
                            <input class="form-control" type="text" />
                        </div>
                    </div>
                    <div class="form-group border-top">
                        <div class="col-12 text-right">
                            <button type="button" class="btn btn-lg btn-secondary cancel_work_plan">Cancel</button>
                            <button type="button" class="btn btn-lg btn-primary add_pr_po">Save Work Plan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
</div>

<script>

    $(document).find('.circle-progress').each(function(index, element){
        var progress = $(element).find('.site_progress').text();

        // console.log(progress);

        $(element)
            .circleProgress({
            value: progress,
            size: 50,
            lineCap: "round",
            fill: { gradient: ["#ff1e41"] },
            })
            .on("circle-animation-progress", function (event, progress, stepValue) {

            if ( stepValue.toFixed(2).substr(2) == 00) {
                percent = 100;
            } else {
                percent = stepValue.toFixed(2).substr(2);
            }
            
            $(this)
                .find("small")
                // .html("<span>" + stepValue.toFixed(2).substr(2) + "%<span>");
                .html("<span>" + percent + "%<span>");
            });

    });

    $(".site_progress_row").on("click", function(){
        
    });

    


</script>
