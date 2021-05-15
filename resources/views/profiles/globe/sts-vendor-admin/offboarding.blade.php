@extends('layouts.main')

@section('content')
    <style>
        .modalDataEndorsement {
            cursor: pointer;
        }

        table {
            width: 100% !important;
        }
    </style>

    <ul class="tabs-animated body-tabs-animated nav">
        <li class="nav-item">
            <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab" href="#tab-content-0">
                <span>ONGOING</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link" id="tab-1" data-toggle="tab" href="#tab-content-1">
                <span>COMPLETED</span>
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            <i class="header-icon lnr-exit icon-gradient bg-ripe-malin"></i>
                            Ongoing Offboarding
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table style="width: 100%;" id="vendor-list-ongoing-table" data-href="{{ route('vendor.list', 'OngoingOff') }}" class="table table-hover table-striped table-bordered">
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
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane tabs-animation fade" id="tab-content-1" role="tabpanel">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            <i class="header-icon lnr-exit   icon-gradient bg-ripe-malin"></i>
                            Offboarding Completed
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table style="width: 100%;" id="vendor-list-complete-table" data-href="{{ route('vendor.list', 'Complete') }}" class="table table-hover table-striped table-bordered">
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
                    </div>
                </div>
            </div>
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