@php
    $site_status = \DB::connection('mysql2')
        ->table('view_sites_activity_progress')
        ->select('site_name', 'sam_id', 'site_category','activity_name', 'progress', 'agent_id')
        // ->whereJsonContains('site_agent', [
        //     'user_id' => \Auth::id()
        // ])
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

@foreach ($site_status as $site_)
    <div class="pl-3 py-2 border-bottom mx-1 site_progress" data-sam_id="{{ $site_->sam_id }}" data-main_activity="assigned site" data-site="{{ $site_->site_name }}">
        <div class="row">
        <div class="col-3 ml-1" style="max-width: 55px; padding:0">
            <div class="circle-progress circle-progress-primary d-inline-block">
                <small><span class="site_progress">{{ $site_->progress }}</span></small>
            </div>
        </div>
        {{-- <i class="ml-3 mt-1 header-icon lnr-location icon-gradient bg-mixed-hopes"></i> --}}
        <div class="ml-0 col-9">
            <div class="" style="  width: 400px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 14px;
            font-weight: bold;
          ">{{ $site_->site_name }}</div>
            <div class="badge badge-dark" style="font-size: 9px !important;">{{ $site_->activity_name }}</div>
            <div>
            <small>{{ $site_->sam_id }} {{ $site_->site_category == "none" ? "" : $site_->site_category }}</small>
            </div>
        </div>
        </div>
    </div>
@endforeach


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

    }
)


</script>
