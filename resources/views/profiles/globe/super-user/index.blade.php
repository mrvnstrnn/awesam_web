@extends('layouts.main')

@section('content')

home

@endsection

@section('modals')
    <div class="modal fade" id="rtb_tracker_modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-lg">
                <div class="dropdown-menu-header">
                    <div class="dropdown-menu-header-inner bg-dark">
                        <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                        <div class="menu-header-content btn-pane-right">
                            <h5 class="menu-header-title">
                                RTB Tracker
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="rtb_tracker_table">
                            <thead>
                                <tr>
                                    <th>Site Name</th>
                                    <th>SAM ID</th>
                                    <th>Region</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_script')
<script>
    $(document).ready( function () {
        $(".milestone_sites").on("click", function (){

            var activity_id = $(this).attr("data-activity_id");
            var category = $(this).attr("data-category");

            if ( activity_id != undefined ) {

                $("#rtb_tracker_modal").modal("show");
                $('#rtb_tracker_table').dataTable().fnDestroy();

                
                $('#rtb_tracker_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "/get-site-based-on-activity-id",
                        method: "POST",
                        data : {
                            activity_id : activity_id,
                            category : category
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    },
                    dataSrc: function(json){
                        return json.data;
                    },
                    columns: [
                        { data: "site_name" },
                        { data: "sam_id" },
                        { data: "sam_region_name" },
                        // { data: "status" },
                    ],
                });

                // $.ajax({
                //     url: "/get-site-based-on-activity-id",
                //     method: "POST",
                //     data : {
                //         activity_id : activity_id,
                //         category : category
                //     },
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     },
                //     success: function (resp) {
                //         if (!resp.error) {
                //             console.log(resp.message);
                //         } else {
                //             Swal.fire(
                //                 'Error',
                //                 resp.message,
                //                 'error'
                //             )
                //         }
                //     },
                //     error: function (resp) {
                //         Swal.fire(
                //             'Error',
                //             resp,
                //             'error'
                //         )
                //     }
                // });
            }

        });
    });
</script>
@endsection