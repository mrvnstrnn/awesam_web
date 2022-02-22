@php

    $user_detail = \Auth::user()->getUserDetail()->first();

    $vendor = is_null($user_detail) ? NULL : $user_detail->vendor_id;

    $site_status = \DB::table('view_sites_activity_progress')
        ->select('site_name', 'sam_id', 'site_category','activity_name', 'progress', 'agent_id')
        // ->whereJsonContains('site_agent', [
        //     'user_id' => \Auth::id()
        // ])
        ->where('progress','<', 1)
        ->where('agent_id', \Auth::id())
        ->where('site_vendor_id', $vendor)
        ->distinct()
        ->orderBy('sam_id', 'asc')
        ->get();
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
@forelse ($site_status as $site_)
    <div class="pl-3 py-2 border-bottom mx-1 site_progress_row" data-activity_source="" data-sam_id="{{ $site_->sam_id }}" data-main_activity="assigned site" data-site="{{ $site_->site_name }}">
        <div class="row">
            <div class="col-3 ml-1" style="max-width: 55px; padding:0">
                <div class="circle-progress circle-progress-primary d-inline-block">
                    <small><span class="site_progress">{{ $site_->progress }}</span></small>
                </div>
            </div>
            <div class="ml-0 col-9 show_activity_modal"  data-sam_id="{{ $site_->sam_id }}" data-activity_source="site-progress">
                <div class="progressSiteName" style="">{{ $site_->site_name }}</div>
                <div class="badge badge-dark" style="font-size: 9px !important;">{{ $site_->activity_name }}</div>
                <div>
                <small>{{ $site_->sam_id }} {{ $site_->site_category == "none" ? "" : $site_->site_category }}</small>
                </div>
            </div>
        </div>
    </div>
@empty
    <h6 class="text-center">Nothing to see here.</h6>
@endforelse
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

