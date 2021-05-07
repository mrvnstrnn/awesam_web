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
            <a role="tab" class="nav-link" id="tab-0" data-toggle="tab" href="#tab-content-1">
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
                            <i class="header-icon lnr-checkmark-circle   icon-gradient bg-ripe-malin"></i>
                            Approvals
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="table-responsive">
                                    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="">Vendor</th>
                                                <th class="d-none d-md-table-cell">SAM ID</th>
                                                <th>Site</th>
                                                <th class="d-none d-md-table-cell">Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="4" class="text-center py-3">
                                                    All Cleared
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
    
                            </div>

                            {{-- <ul class="pagination pagination-sm justify-content-center" style="margin-bottom: 0px;">
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
                                    <a href="javascript:void(0);" class="page-link">2</a>
                                </li>
                                <li class="page-item">
                                    <a href="javascript:void(0);" class="page-link">3</a>
                                </li>
                                <li class="page-item">
                                    <a href="javascript:void(0);" class="page-link">4</a>
                                </li>
                                <li class="page-item">
                                    <a href="javascript:void(0);" class="page-link">5</a>
                                </li>
                                <li class="page-item">
                                    <a href="javascript:void(0);" class="page-link" aria-label="Next">
                                        <span aria-hidden="true">»</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul> --}}
                        </div>
                        {{-- <div class="d-block text-center card-footer">
                            <button class="mr-2 btn-icon btn-icon-only btn btn-outline-danger">Reject</button>
                            <button class="btn-wide btn btn-success">Accept</button>
                        </div> --}}
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
                            <i class="header-icon lnr-checkmark-circle   icon-gradient bg-ripe-malin"></i>
                            Approvals
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="table-responsive">
                                    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="">Vendor</th>
                                                <th class="d-none d-md-table-cell">SAM ID</th>
                                                <th>Site</th>
                                                <th class="d-none d-md-table-cell">Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td  class="modalDataEndorsement" data-endorsement="COLOC-102200">
                                                    Huawei
                                                </td>
                                                <td  class="modalDataEndorsement  d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                    COLOC-102200
                                                </td>
                                                <td  class="modalDataEndorsement" data-endorsement="COLOC-102200">
                                                    <div><strong>NEOPOLITAN-IV-C1</strong></div>
                                                    <div><i>NCR > Quezon City</i></div>
                                                </td>
                                                <td  class="modalDataEndorsement d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                    Document Approval
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  class="modalDataEndorsement" data-endorsement="COLOC-102200">
                                                    Huawei
                                                </td>
                                                <td  class="modalDataEndorsement  d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                    COLOC-102200
                                                </td>
                                                <td  class="modalDataEndorsement" data-endorsement="COLOC-102200">
                                                    <div><strong>NEOPOLITAN-IV-C1</strong></div>
                                                    <div><i>NCR > Quezon City</i></div>
                                                </td>
                                                <td  class="modalDataEndorsement d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                    Document Approval
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  class="modalDataEndorsement" data-endorsement="COLOC-102200">
                                                    Huawei
                                                </td>
                                                <td  class="modalDataEndorsement  d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                    COLOC-102200
                                                </td>
                                                <td  class="modalDataEndorsement" data-endorsement="COLOC-102200">
                                                    <div><strong>NEOPOLITAN-IV-C1</strong></div>
                                                    <div><i>NCR > Quezon City</i></div>
                                                </td>
                                                <td  class="modalDataEndorsement d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                    Document Approval
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  class="modalDataEndorsement" data-endorsement="COLOC-102200">
                                                    Huawei
                                                </td>
                                                <td  class="modalDataEndorsement  d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                    COLOC-102200
                                                </td>
                                                <td  class="modalDataEndorsement" data-endorsement="COLOC-102200">
                                                    <div><strong>NEOPOLITAN-IV-C1</strong></div>
                                                    <div><i>NCR > Quezon City</i></div>
                                                </td>
                                                <td  class="modalDataEndorsement d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                    Document Approval
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  class="modalDataEndorsement" data-endorsement="COLOC-102200">
                                                    Huawei
                                                </td>
                                                <td  class="modalDataEndorsement  d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                    COLOC-102200
                                                </td>
                                                <td  class="modalDataEndorsement" data-endorsement="COLOC-102200">
                                                    <div><strong>NEOPOLITAN-IV-C1</strong></div>
                                                    <div><i>NCR > Quezon City</i></div>
                                                </td>
                                                <td  class="modalDataEndorsement d-none d-md-table-cell" data-endorsement="COLOC-102200">
                                                    Document Approval
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
    
                            </div>

                            {{-- <ul class="pagination pagination-sm justify-content-center" style="margin-bottom: 0px;">
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
                                    <a href="javascript:void(0);" class="page-link">2</a>
                                </li>
                                <li class="page-item">
                                    <a href="javascript:void(0);" class="page-link">3</a>
                                </li>
                                <li class="page-item">
                                    <a href="javascript:void(0);" class="page-link">4</a>
                                </li>
                                <li class="page-item">
                                    <a href="javascript:void(0);" class="page-link">5</a>
                                </li>
                                <li class="page-item">
                                    <a href="javascript:void(0);" class="page-link" aria-label="Next">
                                        <span aria-hidden="true">»</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul> --}}
                        </div>
                        {{-- <div class="d-block text-center card-footer">
                            <button class="mr-2 btn-icon btn-icon-only btn btn-outline-danger">Reject</button>
                            <button class="btn-wide btn btn-success">Accept</button>
                        </div> --}}
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

    <div class="modal fade bd-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel" style="display: none; padding-right: 17px;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas
                        eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.
                    </p>
                    <p>
                        Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue
                        laoreet rutrum faucibus dolor auctor.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

@endsection