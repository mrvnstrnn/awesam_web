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
                            <i class="header-icon lnr-calendar-full icon-gradient bg-ripe-malin"></i>
                            RTB Declaration
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="d-none d-md-table-cell">SAM ID</th>
                                            <th>RTB Date</th>
                                            <th>Site</th>
                                            <th class="text-center  d-none d-sm-table-cell">Technology</th>
                                            <th class="text-center  d-none d-sm-table-cell">PLA ID</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td  class="modalDataEndorsement  d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                COLOC-102200
                                            </td>
                                            <td  class="modalDataEndorsement d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                2021-01-01
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
                                            <td  class="modalDataEndorsement  d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                COLOC-102200
                                            </td>
                                            <td  class="modalDataEndorsement d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                2021-01-01
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
                                            <td  class="modalDataEndorsement  d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                COLOC-102200
                                            </td>
                                            <td  class="modalDataEndorsement d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                2021-01-01
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
                                            <td  class="modalDataEndorsement  d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                COLOC-102200
                                            </td>
                                            <td  class="modalDataEndorsement d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                2021-01-01
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
                                            <td  class="modalDataEndorsement  d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                COLOC-102200
                                            </td>
                                            <td  class="modalDataEndorsement d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                2021-01-01
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
                            <i class="header-icon lnr-calendar-full icon-gradient bg-ripe-malin"></i>
                            RTB Declaration
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="d-none d-md-table-cell">SAM ID</th>
                                            <th>RTB Date</th>
                                            <th>Site</th>
                                            <th class="text-center  d-none d-sm-table-cell">Technology</th>
                                            <th class="text-center  d-none d-sm-table-cell">PLA ID</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td  class="modalDataEndorsement  d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                IBS-102200
                                            </td>
                                            <td  class="modalDataEndorsement d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                2021-01-01
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
                                            <td  class="modalDataEndorsement  d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                IBS-102200
                                            </td>
                                            <td  class="modalDataEndorsement d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                2021-01-01
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
                                            <td  class="modalDataEndorsement  d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                IBS-102200
                                            </td>
                                            <td  class="modalDataEndorsement d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                2021-01-01
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
                                            <td  class="modalDataEndorsement  d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                IBS-102200
                                            </td>
                                            <td  class="modalDataEndorsement d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                2021-01-01
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
                                            <td  class="modalDataEndorsement  d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                IBS-102200
                                            </td>
                                            <td  class="modalDataEndorsement d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                2021-01-01
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_script')
    <script>
        $(document).on("click", ".modalDataEndorsement", function(){
            $(".modal-title").text($(this).attr('data-endorsement'));
            $("#modal-endorsement").modal("show");
        });
    </script>
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