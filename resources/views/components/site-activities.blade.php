

<style>
    /* .list-group-item {
        cursor: pointer;
    } */
    .sub_activity {
        font-size: 11px;
        padding:3px 10px;
    }
    .sub_activity:hover {
        cursor: pointer;
        font-weight: bold;
    }

    .sub_activity::before {
        font-family: "Linearicons-Free";
        content: ">";
        margin-right: 3px;
    }

    .show_subs_btn {
        cursor: pointer;
        font-size: 20px;
    }
    .show_subs_btn:hover {
        cursor: pointer;
        font-weight: bold;
        color: blue;
    }

    .dropzone {
        min-height: 20px !important;
        border: 1px dashed #3f6ad8 !important;
        padding: unset !important;
    }

</style>

    @php
        $site = \DB::table('view_site')
                ->select('site_category', 'program_endorsement_date', 'activity_id')
                ->where('sam_id', $sam_id)
                ->first();

        if (!is_null($site)) {
            $activities = \DB::select('call GET_FORECAST(?,?,?)',array($sam_id, $site->program_endorsement_date, $site->site_category));
        }

    @endphp
        <div id="accordion" class="accordion-wrapper mb-3">

            <div class="card">
                <ul class="todo-list-wrapper list-group list-group-flush">

                    @foreach($activities as $activity)

                        @php
                            // if($activity->activity_complete == 'true'){
                            //     $activity_color = 'success';
                            //     $activity_badge = "done";
                            // } 
                            if ( $activity->activity_id < $site->activity_id ) {
                                $activity_color = 'success';
                                $activity_badge = "done";
                            } else {

                                if($activity->end_date <=  Carbon::today()){
                                    $activity_color = 'danger';
                                    $activity_badge = "delayed";
                                } else {
                                    if($activity->start_date >  Carbon::today()){

                                        $activity_color = 'secondary';
                                        $activity_badge = "Upcoming";

                                    } else {

                                        $activity_color = 'warning';
                                        $activity_badge = "On Schedule";

                                    }
                                }
                            }
                        @endphp

                        {{-- <li class="list-group-item activity_list_item" data-sam_id="{{ $sam_id }}" data-activity_id="{{ $activity->activity_id }}" data-activity_complete="{{ $activity->activity_complete }}" data-start_date="{{ $activity->start_date }}" data-end_date="{{ $activity->end_date }}" data-profile_id="{{ $activity->profile_id }}">
                             --}}
                        <li class="list-group-item activity_list_item" data-sam_id="{{ $sam_id }}" data-activity_id="{{ $activity->activity_id }}" data-start_date="{{ $activity->start_date }}" data-end_date="{{ $activity->end_date }}">
                            <div class="todo-indicator bg-{{ $activity_color }}"></div>
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-3 ml-2">
                                        <i class="pe-7s-note2 pe-2x"></i>
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">
                                            {{ $activity->activity_name }}
                                            <div class="badge badge-{{ $activity_color }} ml-2">{{ $activity_badge }}</div>
                                            {{-- @if ($activity->activity_complete == 'false')
                                            <div class="badge badge-primary ml-0">Active</div>
                                            @endif --}}
                                        </div>
                                        <div class="widget-subheading">
                                            <i>{{ $activity->start_date }} to {{ $activity->end_date }}</i>
                                        </div>
                                    </div>
                                    <div class="widget-content-right">
                                        {{-- <button class="border-0 btn btn-outline-light show_activity_modal" data-sam_id='{{ $sam_id }}' data-site='{{ $site_name}}' data-activity='{{ $activity->activity_name}}' data-main_activity='{{ $activity->activity_name}}' data-activity_id='{{ $activity->activity_id}}'> --}}
                                        <button class="border-0 btn btn-outline-light">
                                            {{-- @if($activity->activity_complete == 'true') --}}

                                                @if ( $activity->activity_id < $site->activity_id ) 
                                                <i class="fa fa-check fa-lg"></i>
                                                @elseif( $activity->activity_id == $site->activity_id )
                                                <i class="fa fa-bolt fa-lg"></i>
                                                @endif
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                
                </ul>                            
            </div>
        </div>                    




@section('js_script')

{{-- <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js" integrity="sha512-VQQXLthlZQO00P+uEu4mJ4G4OAgqTtKG1hri56kQY1DtdLeIqhKUp9W/lllDDu3uN3SnUNawpW7lBda8+dSi7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script src="js/vendor.activities.js"></script>
<script src="js/modal-loader.js"></script>
 --}}
<script>

    var mode = "today";


    $('.activity_list_item').each(function(index, element){

        start_date = new Date($(element).attr('data-start_date'));
        end_date = new Date($(element).attr('data-end_date'));
        date_today = new Date();

        var firstday_week = new Date(date_today.setDate(date_today.getDate() - date_today.getDay()));
        var lastday_week = new Date(date_today.setDate(date_today.getDate() - date_today.getDay() + 6));

        // console.log(lastday_week);

        if($(element).attr('data-profile_id') != "2"){
                $(element).addClass('d-none');
        }


        if($(element).attr('data-activity_complete') == "true"){
                $(element).addClass('d-none');
        }

        if($(element).attr('data-activity_complete') == ""){
                $(element).addClass('d-none');
        }

    });


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


    // Dropzone.autoDiscover = false;
    // $(".dropzone").dropzone({
    //     addRemoveLinks: true,
    //     maxFiles: 1,
    //     maxFilesize: 5,
    //     paramName: "file",
    //     url: "/upload-file",
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     },
    //     success: function (file, resp) {
    //         $("#form-upload  #file_name").val(resp.file);
    //         console.log(resp.message);
    //     },
    //     error: function (file, resp) {
    //         toastr.error(resp.message, "Error");
    //     }
    // });
</script>


@endsection