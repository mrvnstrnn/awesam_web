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
            <table id="for-verification-table" class="align-middle mb-0 table table-borderless table-striped table-hover new-endorsement-table" data-href="{{ route('all.forverification') }}">
                <thead>
                    <tr>
                        <th>Name</th>
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
    <script src="{{ asset('js/vendor-admin.js') }}"></script>
{{-- =======
@extends('layouts.main')

@section('content')
    <style>
        .modalEmployeeVerification {
            cursor: pointer;
        }

        table {
            width: 100% !important;
        }
    </style> 
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                <i class="header-icon lnr-users icon-gradient bg-ripe-malin"></i>
                                 Employee Verification
                                </div>      
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="employee-verification-table" class="align-middle mb-0 table table-borderless table-striped table-hover new-endorsement-table" data-href="">
                                        <thead>
                                            <tr>
                                                <th class="d-none d-md-table-cell">First Name</th>
                                                <th class="d-none d-md-table-cell">Last Name</th>
                                                <th>Email</th>
                                                <th>Location</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="modalEmployeeVerification">
                                                <td>Test</td>
                                                <td>Employee</td>
                                                <td>test@email.com</td>
                                                <td>NCR > Quezon City</td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
@endsection

@section('js_script')
    <script src="{{ asset('js/vendor-admin.js') }}"></script>
@endsection

@section('modals')

    <div class="modal fade" id="modal-employee-verification" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Employee Verification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y: auto !important; max-height: calc(100vh - 210px);">
                    <div class="form-row content-data">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-accept-endorsement" data-complete="true" id="" data-href="">Verify Registration</button>
                </div>
            </div>
        </div>
    </div>

@endsection
>>>>>>> f0a098c1d31feddd32b7cea77c5b0dc8c05ecf6c --}}
@endsection