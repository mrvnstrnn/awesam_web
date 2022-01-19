@extends('layouts.main')

@section('content')
<style>
    .getListAgent {
        cursor: pointer;
    }
</style>
<div class="main-card mb-3 card">
    <div class="card-header-tab card-header">
        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
        <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
        Supervisors
        </div>      
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="employee-agents-table" class="align-middle mb-0 table table-borderless table-striped table-hover new-endorsement-table" data-href="{{ route('vendor_supervisors') }}">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Profile</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Email</th>
                        <th>Number of Agent</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('js_script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs4/1.10.24/dataTables.bootstrap4.min.js" integrity="sha512-NQ2u+QUFbhI3KWtE0O4rk855o+vgPo58C8vvzxdHXJZu6gLu2aLCCBMdudH9580OmLisCC1lJg2zgjcJbnBMOQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="/js/vendor-admin-uspervisor-verification.js?{{ time() }}"></script>

    <script>

        $(document).on("click", ".update-data-supervisor", function () {
            var user_id = $(this).attr("data-value");
            var vendor_id = $(this).attr("data-vendor_id");
            var is_id = $(this).attr("data-is_id");

            $(".change-data").attr("data-user_id", user_id);
            $(".supervisor_info_form")[0].reset();
            
            $("#modal-info-supervisor #supervisor option").remove();
            $("#modal-info-supervisor .vendor_program_div div").remove();

            $.ajax({
                // url: "/get-user-data/" + user_id + "/" + vendor_id + "/" + is_id,
                url: "/get-user-data",
                method: "POST",
                data : {
                    user_id : user_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp) {
                    if (!resp.error) {
                        $("#modal-info-supervisor").modal("show");

                        resp.supervisor.forEach(element => {
                            $("#modal-info-supervisor .supervisor_info_form  #supervisor").append(
                                '<option value="'+element.id+'">'+element.name+'</option>'
                            );
                        });
                        
                        $('.supervisor_info_form #firstname').val(resp.user_detail.firstname);
                        $('.supervisor_info_form #lastname').val(resp.user_detail.lastname);
                        
                        resp.vendor_program.forEach(element => {
                            $(".supervisor_info_form .vendor_program_div").append(
                                '<div class="col-4">' +
                                '<input class="form-check-input" type="checkbox" value="'+element.program_id+'" name="program[]" id="checkbox'+element.program_id+'">' +
                                '<label class="form-check-label" for="checkbox'+element.program_id+'">' +
                                    element.program +
                                '</label>' +
                                '</div>'
                            );
                        });

                        
                        $('.supervisor_info_form #supervisor').val(is_id).trigger('change');
                        $('.supervisor_info_form #profile').val("3").trigger('change');

                        resp.user_data.forEach(element => {
                            $(".supervisor_info_form input[type=checkbox][value='" + element.program_id + "']").prop('checked', true);
                        });
                        
                    } else {
                        toastr.error(resp.message, "Error");
                    }
                },
                error: function (resp) {
                    toastr.error(resp, "Error");
                }
            });
        });

    </script>
@endsection

@section('modals')

    <div class="modal fade" id="modal-info-supervisor" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
            <div class="modal-content">
                <div class="dropdown-menu-header" style="paddng:0px !important;">
                    <div class="dropdown-menu-header-inner bg-dark">
                        <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                        <div class="menu-header-content btn-pane-right">
                            <div>
                                <h5 class="menu-header-title">
                                    User Edit
                                </h5>                                        
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="modal-body" style="overflow-y: auto !important; max-height: calc(100vh - 210px);">

                    <form class="supervisor_info_form">
                        <div class="form-row">
                            <div class="form-group col-md-4 col-12">
                                <label for="firstname">Firstname</label>
                            </div>
                            <div class="form-group col-md-8 col-12">
                                <input type="text" class="form-control" name="firstname" id="firstname" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4 col-12">
                                <label for="lastname">Lastname</label>
                            </div>
                            <div class="form-group col-md-8 col-12">
                                <input type="text" class="form-control" name="lastname" id="lastname" readonly>
                            </div>
                        </div>
                        
                        <div class="form-row profile_div">
                            <div class="form-group col-md-4 col-12">
                                <label for="profile">Profile</label>
                            </div>
                            <div class="form-group col-md-8 col-12">
                                <select name="profile" id="profile" class="form-control">
                                    <option value="2">Agent</option>
                                    <option value="3">Supervisor</option>
                                </select>
                                <small class="text-danger profile-error"></small>
                            </div>
                        </div>
                        
                        <div class="form-row supervisor_div">
                            <div class="form-group col-md-4 col-12">
                                <label for="supervisor">Supervisor</label>
                            </div>
                            <div class="form-group col-md-8 col-12">
                                <select name="supervisor" id="supervisor" class="form-control"></select>
                                <small class="text-danger is_id-error"></small>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-4 col-12">
                                <label for="">Program</label>
                            </div>
                            <div class="form-group col-md-8 col-12">
                                <div class="col-12 vendor_program_div"></div>
                                <small class="text-danger program-error"></small>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-4 col-12">
                                <label for="region">Region</label>
                            </div>
                            <div class="form-group col-md-8 col-12">
                                @php
                                    $user_detail = \DB::table('user_details')
                                                    ->select('vendor_id')
                                                    ->where('user_id', \Auth::user()->id)
                                                    ->first();
                                                        
                                    $user_programs = \DB::table('user_programs')
                                                        ->select('program_id')
                                                        ->where('user_id', \Auth::user()->id)
                                                        ->get()
                                                        ->pluck('program_id');

                                    if( count($user_programs) > 0){
                                        $sites = \DB::table('view_site')
                                                    ->select('sam_region_id')
                                                    ->where('vendor_id', $user_detail->vendor_id)
                                                    ->whereIn('program_id', $user_programs)
                                                    ->get()
                                                    ->groupBy('sam_region_id');

                                        if( !is_null($sites) ){
                                            $location_sam_regions = \DB::table('location_sam_regions')
                                                        ->whereIn('sam_region_id', $sites->keys())
                                                        ->get();
                                        } else {
                                            echo '<p>No region found.</p>';
                                        }
                                    } else {
                                        echo '<p>No user programs available.</p>';
                                    }
                                @endphp

                                @foreach ($location_sam_regions as $location_sam_region)
                                    <div class="col-4">
                                        <input name="region[]" class="regionInput" id="region{{ $location_sam_region->sam_region_id }}" type="checkbox" class="" value="{{ $location_sam_region->sam_region_id }}" >
                                        <label style="margin-left: 20px;" for="region{{ $location_sam_region->sam_region_id }}">{{ $location_sam_region->sam_region_name }}</label>
                                        </div>
                                @endforeach
                                <small class="text-danger region-error"></small>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-change-info change-data">Update Data</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-employee-verification" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agents</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y: auto !important; max-height: calc(100vh - 210px);">
                    
                    <div class="form-row">
                        <div class="form-group col-md-4 col-12">
                            <label for="firstname">Firstname</label>
                        </div>
                        <div class="form-group col-md-8 col-12">
                            <input type="text" class="form-control" name="firstname" id="firstname" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4 col-12">
                            <label for="lastname">Lastname</label>
                        </div>
                        <div class="form-group col-md-8 col-12">
                            <input type="text" class="form-control" name="lastname" id="lastname" readonly>
                        </div>
                    </div>

                    <div class="supervisor-data d-none">
                        
                        <div class="form-row">
                            <div class="form-group col-md-4 col-12">
                                <label for="supervisor">Lastname</label>
                            </div>
                            <div class="form-group col-md-8 col-12">
                                <select name="supervisor" id="supervisor" class="form-control"></select>
                            </div>
                        </div>

                        <div class="form-row mt-3">
                            <div class="col-12">
                                <button class="btn btn-sm btn-primary change_supervisor mr-1">Change Supervisor</button>
                                <button class="btn btn-sm btn-secondary cancel_change">Back to table</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-primary btn-assign-profile" data-href="{{ route("assign.profile") }}">Approve Employee</button> --}}
                    <button type="button" class="btn btn btn-secondary" data-dismiss="modal" aria-label="Close">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="disable_employee_modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Disable User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        Are you sure you want to disabled this user <b class="user_name_disable"></b>?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="offboard_employee_modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Offboard User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        Are you sure you want to offboard this user <b class="user_name_offboard"></b>?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(".supervisor_info_form .profile_div").on("change", "#profile", function () {
            console.log($(this).val());
            if ($(this).val() == 3) {
                $(".supervisor_info_form .supervisor_div").addClass("d-none");
            } else {
                $(".supervisor_info_form .supervisor_div").removeClass("d-none");
            }
        });
    </script>
@endsection