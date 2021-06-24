@php
    $site_status = \DB::connection('mysql2')
        ->table('site_milestone_status')
        ->where('sam_id', "=", $sam_id)
        ->get();    

    // dd($site_status[0]->progress);

@endphp


<div class="mb-3 profile-responsive card">
    <div class="dropdown-menu-header">
        <div class="dropdown-menu-header-inner bg-dark">
            <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg'); background-size: cover;"></div>
            <div class="menu-header-content btn-pane-right">
                <div>
                    <h5 class="menu-header-title">Site Status</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="p-0 card-body align-center text-center py-5" style="position: relative;">

        <div class="circle-progress circle-progress-modal d-inline-block">
            <small><span class="site_progress_modal">{{ $site_status[0]->progress }}</span></small>
        </div>
    </div>
</div> 

{{-- <div class="card-shadow-primary profile-responsive card-border mb-3 card">
    <div class="dropdown-menu-header">
        <div class="dropdown-menu-header-inner bg-dark">
            <div class="menu-header-image" style="background-image: url('images/dropdown-header/abstract2.jpg')"></div>
            <div class="menu-header-content btn-pane-right">
                <div class="avatar-icon-wrapper mr-2 avatar-icon-xl">
                    <div class="avatar-icon">
                        <img src="images/avatars/3.jpg" alt="Avatar 5">
                    </div>
                </div>
                <div>
                    <h5 class="menu-header-title">Mathew Mercer</h5>
                    <h6 class="menu-header-subtitle">Agent</h6>
                </div>
            </div>
        </div>
    </div>
    <ul class="list-group list-group-flush">
    </ul>
</div> --}}


<script>

        var progress = $('.site_progress_view_site').text();

        // console.log(progress);

        $('.circle-progress-modal').each(function(index, element){
        var progress = $(element).find('.site_progress_modal').text();

        // console.log(progress);

        $(element)
            .circleProgress({
            value: progress,
            size: 250,
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