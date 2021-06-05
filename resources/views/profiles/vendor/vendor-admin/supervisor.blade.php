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
                        Supervisors
                    </div>      
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="employee-verification-table" class="align-middle mb-0 table table-borderless table-striped table-hover" data-href="{{ route('vendor_supervisors') }}">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
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
                    <h5 class="modal-title">Supervisor Details</h5>
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