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
            <table id="employee-agents-table" class="align-middle mb-0 table table-borderless table-striped table-hover new-endorsement-table" data-href="{{ route('vendor_supervisors',[1]) }}">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Email</th>
                        <th>Number of Agent</th>
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
                    <h5 class="modal-title">Agents</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y: auto !important; max-height: calc(100vh - 210px);">
                    <div class="content-data">
                        {{-- <select name="profile" id="profile" class="form-control">
                            <option value="2">Agent</option>
                            <option value="3">Supervisor</option>
                        </select> --}}
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
@endsection