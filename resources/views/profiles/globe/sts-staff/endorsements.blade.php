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
                <span>COLOC</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link" id="tab-1" data-toggle="tab" href="#tab-content-1">
                <span>IBS</span>
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
                            <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
                            Endorsements
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="new-endoresement-coloc-table" class="align-middle mb-0 table table-borderless table-striped table-hover new-endorsement-table" data-href="{{ route('all.getDataNewEndorsement', [\Auth::user()->profile_id, 3]) }}">
                                    <thead>
                                        <tr>
                                            <th style="width: 15px;">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" id="checkAll" class="custom-control-input">
                                                    <label class="custom-control-label" for="checkAll">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th class="d-none d-md-table-cell">Date Endorsed</th>
                                            <th class="d-none d-md-table-cell">SAM ID</th>
                                            <th>Site</th>
                                            <th class="text-center">Technology</th>
                                            <th class="text-center  d-none d-sm-table-cell">PLA ID</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="d-block text-right card-footer">
                            <button class="mr-2 btn-icon btn-icon-only btn btn-outline-danger">Reject</button>
                            <button class="btn-wide btn btn-success">Accept</button>
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
                            <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
                            Endorsements
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="new-endoresement-ibs-table" class="align-middle mb-0 table table-borderless table-striped table-hover new-endorsement-table" data-href="{{ route('all.getDataNewEndorsement', [\Auth::user()->profile_id, 4]) }}">
                                    <thead>
                                        <tr>
                                            <th style="width: 15px;">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" id="checkAll" class="custom-control-input">
                                                    <label class="custom-control-label" for="checkAll">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th class="d-none d-md-table-cell">Date Endorsed</th>
                                            <th class="d-none d-md-table-cell">SAM ID</th>
                                            <th>Site</th>
                                            <th class="text-center">Technology</th>
                                            <th class="text-center  d-none d-sm-table-cell">PLA ID</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="d-block text-right card-footer">
                            <button class="mr-2 btn-icon btn-icon-only btn btn-outline-danger">Reject</button>
                            <button class="btn-wide btn btn-success">Accept</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_script')
    <script src="{{ asset('js/sts-staff.js') }}"></script>
@endsection

@section('modals')

    <div class="modal fade" id="modal-endorsement" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                <div class="modal-body">
                    <div class="form-row content-data">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-accept-endorsement" data-complete="false" id="" data-href="{{ route('accept-reject.endorsement') }}">Reject</button>
                    <button type="button" class="btn btn-primary btn-accept-endorsement" data-complete="true" id="" data-href="{{ route('accept-reject.endorsement') }}" data-sam_id="TEST ACCEPT">Accept Endorsement</button>
                </div>
            </div>
        </div>
    </div>


@endsection