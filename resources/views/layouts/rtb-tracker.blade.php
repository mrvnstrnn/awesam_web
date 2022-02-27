@section("modals")

    <div class="modal fade" id="rtb_tracker_modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
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
                    <div class="table-responsive table_rtbd">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section("js_script")
    <script>
        $(document).ready( function () {
            $(".milestone_sites").on("click", function (){

                var activity_id = $(this).attr("data-activity_id");
                var category = $(this).attr("data-category");

                if ( activity_id != undefined ) {

                    if ( activity_id == 0 ) {
                        $(".table_rtbd").html(
                            "<table class='table table-hover' id='rtb_tracker_table'>" +
                                "<thead>" +
                                    "<tr>" +
                                        "<th>Site Name</th>" +
                                        "<th>SAM ID</th>" +
                                        "<th>Region</th>" +
                                        "<th>Vendor</th>" +
                                        "<th>RTB Date</th>" +
                                        "<th>RTB Date Approved</th>" +
                                    "</tr>" +
                                "</thead>" +
                            "</table>"
                        );

                        $("#rtb_tracker_modal").modal("show");
                        $('#rtb_tracker_table').dataTable().fnDestroy();

                        $('#rtb_tracker_table').DataTable({
                            processing: true,
                            serverSide: true,
                            dom: 'Blfrtip',
                            buttons: [
                                'csv', 'excel', 'pdf'
                            ],
                            aLengthMenu: [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
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
                                { data: "vendor_acronym" },
                                { data: "rtb_declaration_date" },
                                { data: "date_approved" },
                            ],
                        });
                    } else {
                        $(".table_rtbd").html(
                            "<table class='table table-hover' id='rtb_tracker_table'>" +
                                "<thead>" +
                                    "<tr>" +
                                        "<th>Site Name</th>" +
                                        "<th>SAM ID</th>" +
                                        "<th>Region</th>" +
                                        "<th>Vendor</th>" +
                                    "</tr>" +
                                "</thead>" +
                            "</table>"
                        );

                        $("#rtb_tracker_modal").modal("show");
                        $('#rtb_tracker_table').dataTable().fnDestroy();

                        $('#rtb_tracker_table').DataTable({
                            processing: true,
                            serverSide: true,
                            dom: 'Blfrtip',
                            buttons: [
                                'csv', 'excel', 'pdf'
                            ],
                            aLengthMenu: [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
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
                                { data: "vendor_acronym" },
                            ],
                        });
                    }
                }
            });
        });
    </script>
@endsection