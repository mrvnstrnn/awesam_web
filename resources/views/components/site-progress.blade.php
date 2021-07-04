@php
    $site_status = \DB::connection('mysql2')
        ->table('milestone_tracking')
        ->where('site_agent_id', "=", \Auth::id())
        ->where('activity_complete', "=", 'false')
        ->get();    
@endphp

@foreach ($site_status as $site_)
    <div class="row pl-3 py-2 border-bottom mx-1 site_progress" data-sam_id="{{ $site_->sam_id }}" data-main_activity="assigned site" data-site="{{ $site_->site_name }}">
        <div class="circle-progress circle-progress-primary d-inline-block">
            <small><span class="site_progress">{{ $site_->progress }}</span></small>
        </div>
        {{-- <i class="ml-3 mt-1 header-icon lnr-location icon-gradient bg-mixed-hopes"></i> --}}
        <div class="ml-0 col">
            <div class=""><H6 class='mb-0' style="font-weight: bold;">{{ $site_->site_name }} {{ $site_->site_category }}</H6></div>
            {{-- <div>
            {{ $site_->sam_id }} {{ $site_->site_category }}
            </div> --}}
            <div class="badge badge-dark">{{ $site_->activity_name }}</div>
        </div>   
    </div>
@endforeach


<script>
    var table_to_load = "";

    $('.circle-progress').each(function(index, element){
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
            $(this)
                .find("small")
                .html("<span>" + stepValue.toFixed(2).substr(2) + "%<span>");
            });

    });


</script>
