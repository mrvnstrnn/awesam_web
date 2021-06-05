@extends('layouts.main')

@section('content')
<div class="main-card mb-3 card">
    <div class="card-header-tab card-header">
        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
        <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
        For Verification
        </div>      
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="for-verification-table" class="align-middle mb-0 table table-borderless table-striped table-hover new-endorsement-table w-100" data-href="{{ route('all.forverification') }}">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Profile</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Email</th>
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
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Employee Verification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y: auto !important; max-height: calc(100vh - 210px);">
                    <div class="form-row mt-3 px-3">
                        <div class="col-md-5">
                            <H5>Employee Details</H5>
                        </div>
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="position-relative form-group">
                                        <label for="fullname">Full Name</label>
                                        <input name="fullname" id="fullname" placeholder="Fullname" type="text" class="form-control" readonly>
                                    </div>
                                    <small class="fullname-error text-danger"></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="divider"></div>
                    <div class="form-row mt-3 px-3">
                        <div class="col-md-5">
                            <H5>Employment Details</H5>
                        </div>
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="position-relative form-group">
                                        <label for="designation">Designation</label>
                                        <select name="designation" id="designation"  class="form-control" readonly required>
                                            <option value="2">Agent</option>
                                            <option value="3">Supervisor</option>
                                        </select>
                                    </div>
                                    <small class="designation-error text-danger"></small>
                                </div>
                                <div class="col-md-12">
                                    <div class="position-relative form-group">
                                        <label for="employment_classification">Employment Classification</label>
                                        <select name="employment_classification" id="employment_classification" readonly class="form-control" required>
                                            <option value="regular">Regular</option>
                                            <option value="subcon">Sub Contractor</option>
                                        </select>
                                    </div>
                                    <small class="employment_classification-error text-danger"></small>
                                </div>
                                <div class="col-md-12">
                                    <div class="position-relative form-group">
                                        <label for="employment_status">Employment Status</label>
                                        <select name="employment_status" id="employment_status"  class="form-control" required>
                                            <option value="active">Active</option>
                                        </select>
                                    </div>
                                    <small class="employment_status-error text-danger"></small>
                                </div>
                                <div class="col-md-12">
                                    <div class="position-relative form-group">
                                        <label for="hiring_date">Hiring Date</label>
                                        <input name="hiring_date" id="hiring_date" placeholder="2021-05-27" readonly type="text" class="flatpicker form-control" style="background-color: white;" required>
                                    </div>
                                    <small class="hiring_date-error text-danger"></small>
                                </div>                
                            </div>
                        </div>
                    </div>

                    <div class="divider supervisor_area d-none"></div>
                    <div class="form-row mt-3 px-3 supervisor_area d-none">
                        <div class="col-md-5">
                            <H5>Immediate Supervisor</H5>
                        </div>
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="position-relative form-group supervisor_select">
                                        {{-- @php
                                            $my_supervisors = App\Models\UserDetail::join('users', 'user_details.user_id', 'users.id')
                                                                                    ->where('user_details.IS_id', \Auth::id())
                                                                                    ->where('users.profile_id', 3)
                                                                                    ->get();
                                        @endphp --}}

                                        <select class="form-control selectpicker" name="mysupervisor" id="mysupervisor" style="width: 100%;">
                                            {{-- <option value="">Please select supervisor</option> --}}
                                            {{-- @foreach ($my_supervisors as $my_supervisor)
                                                <option value="">{{ $my_supervisor->email }}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="divider agent_area d-none"></div>
                    <div class="form-row mt-3 px-3 agent_area d-none">
                        <div class="col-md-5">
                            <H5>Program</H5>
                        </div>
                        <div class="col-md-7">
                            <div class="row">
                                @php
                                    $vendors = App\Models\UserDetail::where('user_id', \Auth::id())->first();
                                    $programs = App\Models\VendorProgram::select('program.program_id', 'program.program')
                                                        ->join('program', 'program.program_id', 'vendor_programs.programs')
                                                        ->where('vendor_programs.vendors_id', $vendors->vendor_id)
                                                        ->get();
                                @endphp

                                @foreach ($programs as $program)
                                <div class="col-md-4 mb-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="vendor_program_id{{ $program->program_id  }}" name="vendor_program_id" value="{{ $program->program_id  }}">
                                        <label class="form-check-label" for="vendor_program_id{{ $program->program_id  }}">{{ $program->program }}</label>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-assign-profile" data-href="{{ route("assign.profile") }}">Approve Employee</button>
                </div>
            </div>
        </div>
    </div>
@endsection