@extends('layouts.main')

@section('content')

<div class="mb-3 card">
    <div class="card-header-tab card-header">
        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
            <i class="header-icon lnr-charts icon-gradient bg-happy-green"></i>
            Vendor Summary
        </div>
    </div>
    <div class="no-gutters row">
        <div class="col-sm-12 col-md-4 col-xl-4">
            <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                <div class="icon-wrapper rounded-circle">
                    <div class="icon-wrapper-bg opacity-9 bg-success"></div>
                    <i class="lnr-apartment text-white"></i>
                </div>
                <div class="widget-chart-content">
                    <div class="widget-subheading">Active Vendors</div>
                    <div class="widget-numbers">
                        <span>{{ count( \Auth::user()->vendor_list('listVendor') ) }}</span>
                    </div>
                    {{-- <div class="widget-description text-focus">
                        Increased by
                        <span class="text-success pl-1">
                            <i class="fa fa-angle-up"></i>
                            <span class="pl-1">7.35%</span>
                        </span>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4 col-xl-4">
            <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                <div class="icon-wrapper rounded-circle">
                    <div class="icon-wrapper-bg opacity-10 bg-warning"></div>
                    <i class="lnr-exit text-dark opacity-8"></i>
                </div>
                <div class="widget-chart-content">
                    <div class="widget-subheading">Offboarding</div>
                    <div class="widget-numbers">{{ count( \Auth::user()->vendor_list('OngoingOff') ) }}</div>
                    {{-- <div class="widget-description text-focus">
                        Decreased by
                        <span class="text-warning pl-1">
                            <i class="fa fa-angle-down"></i>
                            <span class="pl-1">9.10%</span>
                        </span>
                    </div> --}}
                </div>
            </div>
            <div class="divider m-0 d-md-none d-sm-block"></div>
        </div>
        <div class="col-sm-6 col-md-4 col-xl-4">
            <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                <div class="icon-wrapper rounded-circle">
                    <div class="icon-wrapper-bg opacity-9 bg-danger"></div>
                    <i class="lnr-unlink text-white"></i>
                </div>
                <div class="widget-chart-content">
                    <div class="widget-subheading">Terminated</div>
                    <div class="widget-numbers">
                        <span>{{ count( \Auth::user()->vendor_list('Complete') ) }}</span>
                    </div>
                    {{-- <div class="widget-description opacity-8 text-focus">
                        Increased by
                        <span class="text-danger pl-1">
                            <i class="fa fa-angle-up"></i>
                            <span class="pl-1">100%</span>
                        </span>
                    </div> --}}
                </div>
            </div>
            <div class="divider m-0 d-md-none d-sm-block"></div>
        </div>
    </div>
    <div class="text-center d-block p-3 card-footer">
        <a href="/vendorlist" id="view_vendors_btn" class="btn-pill btn-shadow btn-wide fsize-1 btn btn-primary btn-lg">
            <span class="mr-2 opacity-7">
                <i class="icon lnr-apartment text-white"></i>
            </span>
            <span class="mr-1 text-white">View Vendor List</span>
        </a>
    </div>
</div>

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