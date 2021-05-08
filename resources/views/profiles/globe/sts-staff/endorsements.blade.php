@extends('layouts.main')

@section('content')
    <style>
        .modalDataEndorsement {
            cursor: pointer;
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
                                <table id="new-endoresement-table" class="align-middle mb-0 table table-borderless table-striped table-hover" data-href="{{ route('all.getDataNewEndorsement', \Auth::user()->profile_id) }}">
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
                                        {{-- <tr>
                                            <td>
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" id="checkbox_1" class="custom-control-input">
                                                    <label class="custom-control-label" for="checkbox_1">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td  class="modalDataEndorsement d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                2021-01-01
                                            </td>
                                            <td  class="modalDataEndorsement  d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                COLOC-102200
                                            </td>
                                            <td  class="modalDataEndorsement" data-endorsement="COLOC-102200">
                                                <div><strong>NEOPOLITAN-IV-C1</strong></div>
                                                <div><i>NCR > Quezon City</i></div>
                                            </td>
                                            <td  class="modalDataEndorsement text-center" data-endorsement="COLOC-102200">
                                                <div class="badge badge-success">L9</div>
                                            </td>
                                            <td  class="modalDataEndorsement text-center  d-none d-sm-table-cell" data-endorsement="COLOC-102200">
                                                NCR788
                                            </td>
                                        </tr> --}}
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
                                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 15px;">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" id="checkbox_0" class="custom-control-input">
                                                    <label class="custom-control-label" for="checkbox_0">&nbsp;</label>
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
                                        <tr>
                                            <td>
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" id="checkbox_1" class="custom-control-input">
                                                    <label class="custom-control-label" for="checkbox_1">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td  class="modalDataEndorsement d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                2021-01-01
                                            </td>
                                            <td  class="modalDataEndorsement  d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                IBS-102200
                                            </td>
                                            <td  class="modalDataEndorsement" data-endorsement="COLOC-102200">
                                                <div><strong>NEOPOLITAN-IV-C1</strong></div>
                                                <div><i>NCR > Quezon City</i></div>
                                            </td>
                                            <td  class="modalDataEndorsement text-center" data-endorsement="COLOC-102200">
                                                <div class="badge badge-success">L9</div>
                                            </td>
                                            <td  class="modalDataEndorsement text-center  d-none d-sm-table-cell" data-endorsement="COLOC-102200">
                                                NCR788
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" id="checkbox_2" class="custom-control-input">
                                                    <label class="custom-control-label" for="checkbox_2">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td  class="modalDataEndorsement d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                2021-01-01
                                            </td>
                                            <td  class="modalDataEndorsement  d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                IBS-102200
                                            </td>
                                            <td  class="modalDataEndorsement" data-endorsement="COLOC-102200">
                                                <div><strong>NEOPOLITAN-IV-C1</strong></div>
                                                <div><i>NCR > Quezon City</i></div>
                                            </td>
                                            <td  class="modalDataEndorsement text-center" data-endorsement="COLOC-102200">
                                                <div class="badge badge-success">L9</div>
                                            </td>
                                            <td  class="modalDataEndorsement text-center  d-none d-sm-table-cell" data-endorsement="COLOC-102200">
                                                NCR788
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" id="checkbox_3" class="custom-control-input">
                                                    <label class="custom-control-label" for="checkbox_3">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td  class="modalDataEndorsement d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                2021-01-01
                                            </td>
                                            <td  class="modalDataEndorsement  d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                IBS-102200
                                            </td>
                                            <td  class="modalDataEndorsement" data-endorsement="COLOC-102200">
                                                <div><strong>NEOPOLITAN-IV-C1</strong></div>
                                                <div><i>NCR > Quezon City</i></div>
                                            </td>
                                            <td  class="modalDataEndorsement text-center" data-endorsement="COLOC-102200">
                                                <div class="badge badge-success">L9</div>
                                            </td>
                                            <td  class="modalDataEndorsement text-center  d-none d-sm-table-cell" data-endorsement="COLOC-102200">
                                                NCR788
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" id="checkbox_4" class="custom-control-input">
                                                    <label class="custom-control-label" for="checkbox_4">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td  class="modalDataEndorsement d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                2021-01-01
                                            </td>
                                            <td  class="modalDataEndorsement  d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                IBS-102200
                                            </td>
                                            <td  class="modalDataEndorsement" data-endorsement="COLOC-102200">
                                                <div><strong>NEOPOLITAN-IV-C1</strong></div>
                                                <div><i>NCR > Quezon City</i></div>
                                            </td>
                                            <td  class="modalDataEndorsement text-center" data-endorsement="COLOC-102200">
                                                <div class="badge badge-success">L9</div>
                                            </td>
                                            <td  class="modalDataEndorsement text-center  d-none d-sm-table-cell" data-endorsement="COLOC-102200">
                                                NCR788
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" id="checkbox_5" class="custom-control-input">
                                                    <label class="custom-control-label" for="checkbox_5">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td  class="modalDataEndorsement d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                2021-01-01
                                            </td>
                                            <td  class="modalDataEndorsement  d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                IBS-102200
                                            </td>
                                            <td  class="modalDataEndorsement" data-endorsement="COLOC-102200">
                                                <div><strong>NEOPOLITAN-IV-C1</strong></div>
                                                <div><i>NCR > Quezon City</i></div>
                                            </td>
                                            <td  class="modalDataEndorsement text-center" data-endorsement="COLOC-102200">
                                                <div class="badge badge-success">L9</div>
                                            </td>
                                            <td  class="modalDataEndorsement text-center  d-none d-sm-table-cell" data-endorsement="COLOC-102200">
                                                NCR788
                                            </td>
                                        </tr>
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
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        Add rows here
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>


@endsection