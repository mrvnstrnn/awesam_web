@extends('layouts.main')

@section('content')

<style>
    .modalTerminate {
        cursor: pointer;
    }
</style>

<div class="main-card mb-3 card">
    <div class="card-body">
        <table style="width: 100%;" id="vendor-list-table" data-href="{{ route('vendor.list', 'listVendor') }}" class="table table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th>SEC Reg. Name</th>
                    <th>Acronym</th>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

@endsection

@section('modals')
    <div class="modal fade" id="terminationModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <p>Are you sure you want to terminate <b class="vendor_sec_reg_name"></b>?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary terminate_button" data-href="{{ route('terminate.vendor') }}">Terminate</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_script')
    <script src="{{ asset('js/sts-vendor-admin.js') }}"></script>
@endsection