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

    $now = \Carbon\Carbon::now()->toDateString();
    $weekStartDate = \Carbon\Carbon::now()->subDays(7)->toDateString();

    $startOfYear = date('Y-m-d', strtotime('first day of january this year'));

    $vendor = \App\Models\UserDetail::select('user_details.vendor_id')
                                    ->where('user_id', \Auth::id())
                                    ->first();

    if (is_null($vendor->vendor_id)) {

        // $milestones_data = \DB::table("view_site")
        //                 ->select('stage_id', 'stage_name')
        //                 ->where('program_id', $programid)
        //                 ->groupBy('stage_id', 'stage_name')
        //                 ->get();

        $milestones = \DB::table("program_stages")
            ->select('stage_id', 'stage_name')
            ->where('program_id', $programid)
            ->get();
    } else {

        // $milestones_data = \DB::table("view_site")
        //                 ->select('stage_id', 'stage_name')
        //                 ->where('program_id', $programid)
        //                 ->where('view_site.vendor_id', $vendor->vendor_id)
        //                 ->groupBy('stage_id', 'stage_name')
        //                 ->get();
                        
        $milestones = \DB::table("program_stages")
            ->select('stage_id', 'stage_name')
            ->where('program_id', $programid)
            ->get();
                        
        // $milestones = \DB::table("program_stages")
        //     ->select('stage_id', 'stage_name', 
        //     \DB::raw('(SELECT COUNT(*) FROM view_site WHERE view_site.stage_id = program_stages.stage_id
        //     AND view_site.vendor_id = '.$vendor->vendor_id.'
        //     ) as program_stages_count
        //     ')
        //     )
        //     ->where('program_id', $programid)
        //     ->get();
    }

    // if ( $programid == 3 ) {
    //     $categories_array = ["none"];
    // } else if ( $programid == 4 ) {
    //     $categories_array = ["BAU", "RETROFIT", "REFARM"];
    // } else {
    //     $categories_array = ["none"];
    // }

    $i = 0;

@endphp

{{-- @if ( $programid == 3 || $programid == 4) --}}
    <div class="row">
        <div class="col-12">
            <h3 class="site_milestone_title">
                {{ $title }} from 
                {{-- <b>{{ date('M d, Y', strtotime($startOfYear)) }} - {{ date('M d, Y', strtotime($now)) }}</b> --}}
                <b>{{ $startOfYear }} - {{ $now }}</b>
            </h3>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">

            {{-- <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                @for ($j = 0; $j < count($categories_array); $j++)
                    <li class="nav-item">
                        @if ($j == 0)
                            @php
                                $active = "active";
                            @endphp
                        @else
                            @php
                                $active = "";
                            @endphp                
                        @endif
                        
                        @if($categories_array[$j] != "none" )
                            <a role="tab" class="nav-link {{ $active }}" id="tab-{{ $programid }}" data-toggle="tab" href="#tab-content-{{ $programid . "-" . $j }}">
                                <span>{{ $categories_array[$j] }}</span>
                            </a>
                        @endif
                    </li>
                @endfor
            </ul> --}}

            {{-- <div class="tab-content">
                @for ($j = 0; $j < count($categories_array); $j++)

                    <div class="tab-pane tabs-animation fade {{ $j == 0 ? "active show" : "" }}" id="tab-content-{{ $programid . "-" . $j }}" role="tabpanel">
                        
                        <div class="row">
                            <div class="col-12">
                                <form class="form_range_date_{{ $j }}">
                                    <input type="hidden" name="category" id="category" value="{{ $categories_array[$j] }}">
                                    <div class="form-row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="start_date">Start Date</label>
                                                <input type="text" name="start_date" id="start_date" class="form-control">
                                                <small class="text-danger start_date-error"></small>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="end_date">End Date</label>
                                                <input type="text" name="end_date" id="end_date" class="form-control">
                                                <small class="text-danger end_date-error"></small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-12">
                                            <button type="button" class="btn btn-sm btn-shadow btn-primary filter_btn mr-1" data-value="filter_me" data-count="{{ $j }}">Filter</button>
                                            <button type="button" class="btn btn-sm btn-shadow btn-danger filter_btn" data-value="clear_me">Clear Filter</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>

                        <div class="main-card mb-3 card">            
                            <div class="no-gutters row border">
                                @foreach ($milestones as $milestone)
                                    @php
                                        $i ++;
                                    @endphp
                                    <div class="col-sm-3 border">
                                        <div class="milestone-bg bg_img_{{ $i }}"></div>
                
                                        <div class="widget-chart widget-chart-hover milestone_sites">
                                            <div class="widget-numbers" id="stage_counter_{{ $categories_array[$j] }}_{{ strtolower(str_replace(" ", "", $milestone->stage_name)) }}">0</div>
                                            <div class="widget-subheading" id="stage_counter_label_{{ $milestone->stage_id }}">{{ $milestone->stage_name}}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endfor
            </div>   --}}

            <div class="row">
                <div class="col-12">
                    <form class="form_range_date">
                        {{-- <input type="hidden" name="category" id="category" value="{{ $categories_array[$j] }}"> --}}
                        <div class="form-row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="text" name="start_date" id="start_date" class="form-control">
                                    <small class="text-danger start_date-error"></small>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="text" name="end_date" id="end_date" class="form-control">
                                    <small class="text-danger end_date-error"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-12">
                                <button type="button" class="btn btn-sm btn-shadow btn-primary filter_btn mr-1" data-value="filter_me">Filter</button>
                                <button type="button" class="btn btn-sm btn-shadow btn-danger filter_btn" data-value="clear_me">Clear Filter</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <div class="main-card mb-3 card">            
                <div class="no-gutters row border">
                    @foreach ($milestones as $milestone)
                        @php
                            $i ++;
                        @endphp
                        <div class="col-sm-3 border">
                            <div class="milestone-bg bg_img_{{ $i }}"></div>
    
                            <div class="widget-chart widget-chart-hover milestone_sites">
                                <div class="widget-numbers" id="stage_counter_{{ strtolower(str_replace(" ", "", $milestone->stage_name)) }}">0</div>
                                <div class="widget-subheading" id="stage_counter_label_{{ $milestone->stage_id }}">{{ $milestone->stage_name}}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="text-center">
                <a href="/program-sites" class="btn-pill btn-shadow btn-wide fsize-1 btn btn-dark btn-md">
                    <span class="mr-2 opacity-7">
                        <i class="fa fa-cog fa-spin"></i>
                    </span>
                    <span class="">View Sites</span>
                </a>
            </div>

        </div>

    </div>
{{-- @endif --}}

@push("js_scripts")

<script>

$(document).ready(() => {

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

    $("input[name=start_date], input[name=end_date]").flatpickr();

    var ajax_start_date = "{{ $startOfYear }}";
    var ajax_end_date = "{{ $now }}";

    $.ajax({
        url: "/get-milestone-per-program",
        method: "POST",
        data: {
            start_date : ajax_start_date,
            end_date : ajax_end_date
            // category : ajax_category
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (resp) {
            if (!resp.error) {
                $.each(resp.message, function(index, data) {
                    $( "#stage_counter_" + data.stage_name.toLowerCase().split(' ').join('') ).text(data.count);
                });
            } else {
                Swal.fire(
                    'Error',
                    resp.message,
                    'error'
                )
            }
        },
        error: function (resp) {
            Swal.fire(
                'Error',
                resp,
                'error'
            )
        }
    })

    $(".filter_btn").on("click", function () {

        $(".milestone_sites .widget-numbers").text("0");
        // var count = $(this).attr("data-count");

        if ( $(this).attr("data-value") == "filter_me" ) {
            // var category = $(".form_range_date_ #category").val();
            var start_date = $(".form_range_date #start_date").val();
            var end_date = $(".form_range_date #end_date").val();

            $(".site_milestone_title b").text(start_date + " - " + end_date);
        } else {
            var start_date = "{{ $startOfYear }}";
            var end_date = "{{ $now }}";
            
            $("#start_date").val("");
            $("#end_date").val("");

            $(".site_milestone_title b").text(start_date + " - " + end_date);
        }

        $.ajax({
            url: "/get-milestone-per-program",
            method: "POST",
            data: {
                start_date : start_date,
                end_date : end_date,
                // category : category,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp) {
                if (!resp.error) {
                    $.each(resp.message, function(index, data) {
                        // $("#stage_counter_" + category + "_" + data.stage_name.toLowerCase().split(' ').join('')).text(data.count);
                        $("#stage_counter_" + data.stage_name.toLowerCase().split(' ').join('')).text(data.count);
                    });
                } else {
                    Swal.fire(
                        'Error',
                        resp.message,
                        'error'
                    )
                }
            },
            error: function (resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )
            }
        })
    });

});


</script>

@endpush
