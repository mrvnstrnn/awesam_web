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

    // $milestones = \DB::table($table)
    //                 ->select('stage_id', 'stage_name', DB::raw("SUM(counter) as counter"))
    //                 ->where('program_id', $programid)
    //                 ->groupBy('stage_id', 'stage_name')
    //                 ->get();

    $vendor = \App\Models\UserDetail::select('user_details.vendor_id')
                                    ->where('user_id', \Auth::id())
                                    ->first();

    if (is_null($vendor->vendor_id)) {

        $milestones_data = \DB::table("view_site")
                        ->select('stage_id', 'stage_name')
                        ->where('program_id', $programid)
                        ->groupBy('stage_id', 'stage_name')
                        ->get();

                        
        $milestones = \DB::table("program_stages")
            ->select('stage_id', 'stage_name')
            ->where('program_id', $programid)
            ->get();
    } else {

        $milestones_data = \DB::table("view_site")
                        ->select('stage_id', 'stage_name')
                        ->where('program_id', $programid)
                        ->where('view_site.site_vendor_id', $vendor->vendor_id)
                        ->groupBy('stage_id', 'stage_name')
                        ->get();
                        
        $milestones = \DB::table("program_stages")
            ->select('stage_id', 'stage_name', 
            \DB::raw('(SELECT COUNT(*) FROM view_site WHERE view_site.stage_id = program_stages.stage_id
            AND view_site.site_vendor_id = '.$vendor->vendor_id.'
            ) as program_stages_count
            ')
            )
            ->where('program_id', $programid)
            ->get();
    }



                    // dd($milestones);
    $i = 0;

@endphp

<div class="row">
    <div class="col-12">
        <h3>{{ $title }}</h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        @if($programid == 4)
        <div class=" my-2">
            <button class="btn-wide mr-2 btn-pill btn btn-sm btn-outline-dark active">ALL</button>
            <button class="btn-wide mr-2 btn-pill btn btn-sm btn-outline-dark">BAU</button>
            <button class="btn-wide mr-2 btn-pill btn btn-sm btn-outline-dark">REFARM</button>
            <button class="btn-wide mr-2 btn-pill btn btn-sm btn-outline-dark">RETROFIT</button>
        </div>
        @endif
        <div class="main-card mb-3 card">            
            <div class="no-gutters row border">
                @foreach ($milestones as $milestone)    
                @php
                    $i ++;
                @endphp                    
                <div class="col-sm-3 border">
                    <div class="milestone-bg bg_img_{{ $i }}"></div>

                    <div class="widget-chart widget-chart-hover milestone_sites">
                        {{-- <div class="widget-numbers" id="stage_counter_{{ $milestone->stage_id }}">- -</div> --}}
                        <div class="widget-numbers" id="stage_counter_{{ $milestone->stage_id }}">{{ isset($milestone->program_stages_count) ? $milestone->program_stages_count : 0 }}</div>
                        <div class="widget-subheading" id="stage_counter_label_{{ $milestone->stage_id }}">{{ $milestone->stage_name}}</div>
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
                <span class="">View Sites</span>
            </button>
        </div>
    </div>

</div>

@push("js_scripts")

<script>

// $(document).ready(() => {

//     var programid = "{{ $programid }}";

//     $.ajax({
//     url: "/site-ajax",
//     method: "POST",
//     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
//     data: {
//         type: "home_widgets_stage_counters",
//         programid: programid
//     },
//     success: function (resp){
//       if(!resp.error){

//         $.each(resp.message, function(k, v){

//             $('#stage_counter_'+resp.message[k].stage_id).text(resp.message[k].counter)

//         });


//       } else {
//         toastr.error(resp.message);
//       }
//     },
//     error: function (resp){
//       toastr.error(resp.message);
//     }
//   });


// });


</script>

@endpush
