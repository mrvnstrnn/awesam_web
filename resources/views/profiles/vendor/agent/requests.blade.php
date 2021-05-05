@extends('layouts.main')

@section('content')

    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
        <li class="nav-item">
            <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab" href="#tab-content-0">
                <span>Active</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link" id="tab-1" data-toggle="tab" href="#tab-content-1">
                <span>Approved</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#tab-content-2">
                <span>Denied</span>
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
                            <i class="header-icon lnr-select icon-gradient bg-ripe-malin"></i>
                            Active Requests
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Type</th>
                                            <th class="text-left">Details</th>
                                            <th class="text-left">Reason</th>
                                            <th class="text-center">Activities</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center text-muted">#345</td>
                                            <td class="text-center">
                                                <div class="badge badge-success">LEAVE</div>
                                            </td>
                                            <td class="text-left">
                                                Mar 22 to 24
                                            </td>
                                            <td class="text-left">
                                                Apr 16 to 21
                                            </td>
                                            <td class="text-center">
                                                10
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center text-muted">#347</td>
                                            <td class="text-center">
                                                <div class="badge badge-success">LEAVE</div>
                                            </td>
                                            <td class="text-left">
                                                Apr 16 to 21
                                            </td>
                                            <td class="text-left">
                                                Apr 16 to 21
                                            </td>
                                            <td class="text-center">
                                                15
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center text-muted">#321</td>
                                            <td class="text-center">
                                                <div class="badge badge-danger">Absent</div>
                                            </td>
                                            <td class="text-left">
                                                Mar 20
                                            </td>
                                            <td class="text-left">
                                                Apr 16 to 21
                                            </td>
                                            <td class="text-center">
                                                3
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center text-muted">#55</td>
                                            <td class="text-center">
                                                <div class="badge badge-success">LEAVE</div>
                                            </td>
                                            <td class="text-left">
                                                Apr 1 to 5
                                            </td>
                                            <td class="text-left">
                                                Apr 16 to 21
                                            </td>
                                            <td class="text-center">
                                                15
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <ul class="pagination pagination-sm" style="margin-bottom: 0px;">
                                <li class="page-item">
                                    <a href="javascript:void(0);" class="page-link" aria-label="Previous">
                                        <span aria-hidden="true">«</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <li class="page-item active">
                                    <a href="javascript:void(0);" class="page-link">1</a>
                                </li>
                                <li class="page-item">
                                    <a href="javascript:void(0);" class="page-link" aria-label="Next">
                                        <span aria-hidden="true">»</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
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
                            <i class="header-icon lnr-thumbs-up icon-gradient bg-ripe-malin"></i>
                            Approved Requests
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Type</th>
                                            <th class="text-left">Details</th>
                                            <th class="text-left">Reason</th>
                                            <th class="text-center">Activities</th>
                                            <th class="text-center">Approval Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center text-muted">#345</td>
                                            <td class="text-center">
                                                <div class="badge badge-success">LEAVE</div>
                                            </td>
                                            <td class="text-left">
                                                Mar 22 to 24
                                            </td>
                                            <td class="text-left">
                                                Apr 16 to 21
                                            </td>
                                            <td class="text-center">
                                                10
                                            </td>
                                            <td class="text-center">
                                                April 1, 2021
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center text-muted">#347</td>
                                            <td class="text-center">
                                                <div class="badge badge-success">LEAVE</div>
                                            </td>
                                            <td class="text-left">
                                                Apr 16 to 21
                                            </td>
                                            <td class="text-left">
                                                Apr 16 to 21
                                            </td>
                                            <td class="text-center">
                                                15
                                            </td>
                                            <td class="text-center">
                                                April 1, 2021
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center text-muted">#321</td>
                                            <td class="text-center">
                                                <div class="badge badge-danger">Absent</div>
                                            </td>
                                            <td class="text-left">
                                                Mar 20
                                            </td>
                                            <td class="text-left">
                                                Apr 16 to 21
                                            </td>
                                            <td class="text-center">
                                                3
                                            </td>
                                            <td class="text-center">
                                                April 1, 2021
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center text-muted">#55</td>
                                            <td class="text-center">
                                                <div class="badge badge-success">LEAVE</div>
                                            </td>
                                            <td class="text-left">
                                                Apr 1 to 5
                                            </td>
                                            <td class="text-left">
                                                Apr 16 to 21
                                            </td>
                                            <td class="text-center">
                                                15
                                            </td>
                                            <td class="text-center">
                                                April 1, 2021
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <ul class="pagination pagination-sm" style="margin-bottom: 0px;">
                                <li class="page-item">
                                    <a href="javascript:void(0);" class="page-link" aria-label="Previous">
                                        <span aria-hidden="true">«</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <li class="page-item active">
                                    <a href="javascript:void(0);" class="page-link">1</a>
                                </li>
                                <li class="page-item">
                                    <a href="javascript:void(0);" class="page-link" aria-label="Next">
                                        <span aria-hidden="true">»</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane tabs-animation fade" id="tab-content-2" role="tabpanel">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            <i class="header-icon lnr-thumbs-down icon-gradient bg-ripe-malin"></i>
                            Denied Requests
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Type</th>
                                            <th class="text-left">Details</th>
                                            <th class="text-left">Reason</th>
                                            <th class="text-center">Activities</th>
                                            <th class="text-center">Date Denied</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center text-muted">#345</td>
                                            <td class="text-center">
                                                <div class="badge badge-success">LEAVE</div>
                                            </td>
                                            <td class="text-left">
                                                Mar 22 to 24
                                            </td>
                                            <td class="text-left">
                                                Apr 16 to 21
                                            </td>
                                            <td class="text-center">
                                                10
                                            </td>
                                            <td class="text-center">
                                                April 1, 2021
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center text-muted">#347</td>
                                            <td class="text-center">
                                                <div class="badge badge-success">LEAVE</div>
                                            </td>
                                            <td class="text-left">
                                                Apr 16 to 21
                                            </td>
                                            <td class="text-left">
                                                Apr 16 to 21
                                            </td>
                                            <td class="text-center">
                                                15
                                            </td>
                                            <td class="text-center">
                                                April 1, 2021
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center text-muted">#321</td>
                                            <td class="text-center">
                                                <div class="badge badge-danger">Absent</div>
                                            </td>
                                            <td class="text-left">
                                                Mar 20
                                            </td>
                                            <td class="text-left">
                                                Apr 16 to 21
                                            </td>
                                            <td class="text-center">
                                                3
                                            </td>
                                            <td class="text-center">
                                                April 1, 2021
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center text-muted">#55</td>
                                            <td class="text-center">
                                                <div class="badge badge-success">LEAVE</div>
                                            </td>
                                            <td class="text-left">
                                                Apr 1 to 5
                                            </td>
                                            <td class="text-left">
                                                Apr 16 to 21
                                            </td>
                                            <td class="text-center">
                                                15
                                            </td>
                                            <td class="text-center">
                                                April 1, 2021
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <ul class="pagination pagination-sm" style="margin-bottom: 0px;">
                                <li class="page-item">
                                    <a href="javascript:void(0);" class="page-link" aria-label="Previous">
                                        <span aria-hidden="true">«</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <li class="page-item active">
                                    <a href="javascript:void(0);" class="page-link">1</a>
                                </li>
                                <li class="page-item">
                                    <a href="javascript:void(0);" class="page-link" aria-label="Next">
                                        <span aria-hidden="true">»</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection