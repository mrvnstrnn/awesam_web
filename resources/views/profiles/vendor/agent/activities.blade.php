@extends('layouts.main')

@section('content')

    <style>
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

        .site_progress:hover {
            cursor: pointer;
            color: blue;
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
        // $activities = \DB::connection('mysql2')
        //     ->table('site_milestone')
        //     ->join('site', 'site_milestone.sam_id','site.sam_id' )
        //     ->distinct()
        //     ->where('site_agent_id', "=", \Auth::id())
        //     ->where('activity_complete', "=", 'false')
        //     ->get();

        // $site_status = \DB::connection('mysql2')
        //     ->table('site_milestone_status')
        //     ->where('site_agent_id', "=", \Auth::id())
        //     ->orderBy('sam_id')
        //     ->get();

        // $activities = \DB::connection('mysql2')
        //     ->table('site_milestone')
        //     ->select('sam_id', 'site_name', 'site_category', 'stage_id', 'stage_name', 'activity_id', 'activity_name', 'activity_type', 'activity_duration_days', 'activity_complete', 'profile_id', 'start_date', 'end_date')
        //     ->distinct()
        //     ->where('site_agent_id', "=", \Auth::id())
        //     ->get();

        // dd($sites);
    @endphp

    <div class="row">
        <div class="col-lg-6">
            <div class="main-card mb-3 card">
                <div class="dropdown-menu-header py-2 bg-warning border-bottom"   style=" background-image: url('/images/modal-background.jpeg'); background-size:cover;">
                    <div class="row px-4">
                        <div class="menu-header-content btn-pane-right">
                            <h5 class="menu-header-title text-dark">
                                <i class="header-icon pe-7s-date pe-lg font-weight-bold mr-1"></i>
                                 My Activities
                            </h5>
                        </div>
                        <div class="btn-actions-pane-right actions-icon-btn">
                            <button id="show-admin-tasks" type="button" aria-expanded="false" class="btn-icon btn-icon-only btn btn-link">
                                {{-- <i class="pe-7s-menu btn-icon-wrapper pe-2x font-weight-bold text-dark"></i> --}}
                                <i class="fa fa-fw fa-lg" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <ul class="todo-list-wrapper list-group list-group-flush" id="agent_activity_list">
                    <div class="loader-wrapper w-100 d-flex justify-content-center align-items-center">
                        <div class="loader">
                            <div class="ball-scale-multiple">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                </ul>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="main-card mb-3 card">
                <div class="dropdown-menu-header py-2 bg-warning border-bottom"   style=" background-image: url('/images/modal-background.jpeg'); background-size:cover;">
                    <div class="row px-4">
                        <div class="menu-header-content btn-pane-right">
                            <h5 class="menu-header-title text-dark">
                                <i class="header-icon pe-7s-graph1 pe-lg font-weight-bold mr-1"></i>
                                 Site Progress
                            </h5>
                        </div>
                        <div class="btn-actions-pane-right actions-icon-btn">
                            <button id="show-admin-tasks" type="button" aria-expanded="false" class="btn-icon btn-icon-only btn btn-link">
                                {{-- <i class="pe-7s-menu btn-icon-wrapper pe-2x font-weight-bold text-dark"></i> --}}
                                <i class="fa fa-fw fa-lg" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div id="agent_site_progress">
                    <div class="loader-wrapper w-100 d-flex justify-content-center align-items-center">
                        <div class="loader">
                            <div class="ball-scale-multiple">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('modals')

    <x-milestone-modal />

    <div id="admin-task-modal" class="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
            <div class="modal-header bg-dark"  style="background-image: url('/images/modal-background.jpeg'); background-size:cover;">
                <h5 class="modal-title text-dark">Add Admin Task</h5>
                <button type="button" class="close modal_close text-dark" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-0" >
                <form class="">
                    <div class="position-relative row form-group">
                        <label for="exampleEmail" class="col-sm-4 col-form-label">Task Type</label>
                        <div class="col-sm-8">
                            <select class="form-control">
                                <option>-</option>
                                <option>Online Meeting</option>
                                <option>Office Works</option>
                                <option>Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="exampleEmail" class="col-sm-4 col-form-label">Date</label>
                        <div class="col-sm-8">
                            <input name="task-date" id="task-date" placeholder="" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="exampleEmail" class="col-sm-4 col-form-label">Time</label>
                        <div class="col-sm-8">
                            <input name="task-date" id="task-date" placeholder="" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="exampleEmail" class="col-sm-4 col-form-label">Remarks</label>
                        <div class="col-sm-8">
                            <textarea class="form-control"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary modal_close"  data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary actor_update">Add</button>
            </div>
            </div>
        </div>
    </div>

@endsection


@section('js_script')

{{-- <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js" integrity="sha512-VQQXLthlZQO00P+uEu4mJ4G4OAgqTtKG1hri56kQY1DtdLeIqhKUp9W/lllDDu3uN3SnUNawpW7lBda8+dSi7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}} --}}
{{-- <script src="js/vendor.activities.js"></script>

{{-- <script src="js/modal-loader.js"></script> --}}



<script>


$(document).ready(() => {

    

    var sam_id = $('#modal_sam_id').val();

    $.ajax({
        url: "/modal-view-site-component/" + sam_id + "/agent-activities",
        method: "GET",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (resp){
            $('#agent_activity_list').html("");
            $('#agent_activity_list').html(resp);
        },
        error: function (resp){
            toastr.error(resp.message, "Error");
        }
    });

    $.ajax({
        url: "/modal-view-site-component/" + sam_id + "/agent-progress",
        method: "GET",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (resp){
            $('#agent_site_progress').html("");
            $('#agent_site_progress').html(resp);
        },
        error: function (resp){
            toastr.error(resp.message, "Error");
        }
    });

    $(document).on('click', '#show-admin-tasks', function(){
        $('#admin-task-modal').modal('show');
    });


});

$(document).on('hidden.bs.modal', '#viewInfoModal', function (event) {

    var loading =  '<div class="loader-wrapper w-100 d-flex justify-content-center align-items-center">' +
                   '<div class="loader">' +
                    '<div class="ball-scale-multiple">' +
                      '<div></div>' +
                      '<div></div>' +
                      '<div></div>' +
                    '</div>' +
                   '</div>' +
                   '</div>';

    $('#agent_activity_list').html(loading);


    var sam_id = $('#modal_sam_id').val();

    $.ajax({
        url: "/modal-view-site-component/" + sam_id + "/agent-activities",
        method: "GET",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (resp){
            $('#agent_activity_list').html("");
            $('#agent_activity_list').html(resp);
        },
        error: function (resp){
            toastr.error(resp.message, "Error");
        }
    });
})



var mode = "today";


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
            $(this)
                .find("small")
                .html("<span>" + stepValue.toFixed(2).substr(2) + "%<span>");
            });

    }
)



</script>


@endsection
