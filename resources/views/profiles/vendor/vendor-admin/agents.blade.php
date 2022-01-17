@extends('layouts.main')

@section('content')
<div class="main-card mb-3 card">
    <div class="card-header-tab card-header">
        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
        <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
        Agents
        </div>      
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="employee-agents-table" class="align-middle mb-0 table table-borderless table-striped table-hover" data-href="{{ route('vendor_agents') }}">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Profile</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Email</th>
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
    <script src="{{ asset('js/vendor-admin-verification.js') }}"></script>
@endsection

@section('modals')
    <div class="modal fade" id="modal-employee-verification" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agents</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y: auto !important; max-height: calc(100vh - 210px);">
                    <div class="form-row content-data">
                        {{-- <select name="profile" id="profile" class="form-control">
                            <option value="2">Agent</option>
                            <option value="3">Supervisor</option>
                        </select> --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-assign-profile" data-href="{{ route("assign.profile") }}">Approve Employee</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-info" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Vendor Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y: auto !important; max-height: calc(100vh - 210px);">

                    <form class="agent_info_form">
                        <div class="form-row">
                            <div class="col-12 profile_div">
                                <label for="profile">Profile</label>
                                <select name="profile" id="profile" class="form-control">
                                    <option value="2">Agent</option>
                                    <option value="3">Supervisor</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 supervisor_div">
                                <label for="supervisor">Supervisor</label>
                                <select name="supervisor" id="supervisor" class="form-control"></select>
                            </div>
                        </div>
                        <div class="form-row col-12">
                            <label for="">Program</label>
                            <div class="col-12 vendor_program_div"></div>
                        </div>
                        <div class="form-row col-12">
                            <label for="region">Region</label>
                            <div class="row" id="region_div">
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
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-change-info change-data">Update Data</button>
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
        $(".agent_info_form .profile_div").on("change", "#profile", function () {
            if ($(this).val() == 3) {
                $(".agent_info_form .supervisor_div").addClass("d-none");
            } else {
                $(".agent_info_form .supervisor_div").removeClass("d-none");
            }
        });
    </script>
@endsection