@extends('layouts.main')

@section('content')

<style>
    .widget-content-left.flex2 {
        display: none;
    }

    .widget-content-wrapper:hover .widget-content-left.flex2 {
        display: block !important;
    }
    
    .modalDataSite {
        cursor: pointer;
    }
</style>

    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
        <li class="nav-item">
            <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab" href="#tab-content-0">
                <span>COLOC</span>
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
                                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 150px;">Agent</th>
                                            <th>SAM ID</th>
                                            <th>Technology</th>
                                            <th>Site</th>
                                            <th>PLA ID</th>
                                            <th >Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="modalDataSite" data-sites="COLOC-102200">
                                            <td>
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left mr-3">
                                                            <div class="widget-content-left">
                                                                <img width="40" class="rounded-circle"
                                                                    src="images/avatars/4.jpg" alt="">
                                                            </div>
                                                        </div>
                                                        <div class="widget-content-left flex2">
                                                            <div class="widget-heading">John Doe</div>
                                                            <div class="widget-subheading opacity-7">Quezon City</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                COLOC-102200
                                            </td>
                                            <td style="width: 150px;">
                                                <div class="badge badge-success">L9</div>
                                            </td>
                                            <td>
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left flex2">
                                                            <div class="widget-heading">
                                                                <a href="#NEOPOLITAN-IV-C1"  data-toggle="modal" data-target=".bd-example-modal-lg" >
                                                                NEOPOLITAN-IV-C1
                                                                </a>
                                                            </div>
                                                            <div class="widget-subheading opacity-7">Quezon City</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width: 150px;">
                                                NCR788
                                            </td>
                                            <td style="width: 30%">
                                                <div class="progress" style="min-height: 8px; height: 20px; max-width: 100%">
                                                    <div class="progress-bar stage-text stage5 stage-active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="17" style="width: 9.1%;">
                                                    </div>
                                                    <div class="progress-bar stage-text stage6 stage-disabled" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="17" style="width: 9.1%;">
                                                    </div>
                                                </div>
                                                POST BUILD DOCUMENTS                                   
                                            </td>
                                        </tr>
                                        <tr class="modalDataSite" data-sites="COLOC-102201">
                                            <td>
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left mr-3">
                                                            <div class="widget-content-left">
                                                                <img width="40" class="rounded-circle"
                                                                    src="images/avatars/4.jpg" alt="">
                                                            </div>
                                                        </div>
                                                        <div class="widget-content-left flex2">
                                                            <div class="widget-heading">John Doe</div>
                                                            <div class="widget-subheading opacity-7">Quezon City</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                COLOC-102201
                                            </td>
                                            <td style="width: 150px;">
                                                <div class="badge badge-success">L21</div>
                                            </td>
                                            <td>
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left flex2">
                                                            <div class="widget-heading">
                                                                <a href="#NEOPOLITAN-IV-C1"  data-toggle="modal" data-target=".bd-example-modal-lg" >
                                                                NEOPOLITAN-IV-C1
                                                                </a>
                                                            </div>
                                                            <div class="widget-subheading opacity-7">Quezon City</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width: 150px;">
                                                NCR788
                                            </td>
                                            <td>
                                                <div class="progress" style="min-height: 8px; height: 20px;  max-width: 100%">
                                                    <div class="progress-bar stage-text stage3 stage-active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="17" style="width: 9.1%;">
                                                    </div>
                                                    <div class="progress-bar stage-text stage4 stage-disabled" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="17" style="width: 27.3%;">
                                                    </div>
                                                    <div class="progress-bar stage-text stage5 stage-disabled" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="17" style="width: 27.3%;">
                                                    </div>
                                                    <div class="progress-bar stage-text stage6 stage-disabled" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="17" style="width: 18.2%;">
                                                    </div>
                                                </div>       
                                                PRE BUILD DOCUMENTS                                     
                                            </td>
                                        </tr>
                                        <tr class="modalDataSite" data-sites="COLOC-102202">
                                            <td>
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left mr-3">
                                                            <div class="widget-content-left">
                                                                <img width="40" class="rounded-circle"
                                                                    src="images/avatars/4.jpg" alt="">
                                                            </div>
                                                        </div>
                                                        <div class="widget-content-left flex2">
                                                            <div class="widget-heading">John Doe</div>
                                                            <div class="widget-subheading opacity-7">Quezon City</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                COLOC-102202
                                            </td>
                                            <td style="width: 150px;">
                                                <div class="badge badge-success">L9</div>
                                            </td>
                                            <td>
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left flex2">
                                                            <div class="widget-heading">
                                                                <a href="#NEOPOLITAN-IV-C1"  data-toggle="modal" data-target=".bd-example-modal-lg" >
                                                                    VILLA-VERDE-01
                                                                </a>                           
                                                            </div>
                                                            <div class="widget-subheading opacity-7">Quezon City</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width: 150px;">
                                                NCR788
                                            </td>
                                            <td>
                                                <div class="progress" style="min-height: 8px; height: 20px; max-width: 100%">
                                                    <div class="progress-bar stage-text stage6 stage-active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="17" style="width: 18.2%;">
                                                    </div>
                                                </div>
                                                CONTRACT                                          
                                            </td>
                                        </tr>
                                        <tr class="modalDataSite" data-sites="COLOC-102203">
                                            <td>
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left mr-3">
                                                            <div class="widget-content-left">
                                                                <img width="40" class="rounded-circle"
                                                                    src="images/avatars/4.jpg" alt="">
                                                            </div>
                                                        </div>
                                                        <div class="widget-content-left flex2">
                                                            <div class="widget-heading">John Doe</div>
                                                            <div class="widget-subheading opacity-7">Quezon City</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>    
                                            <td>
                                                COLOC-102203
                                            </td>
                                            <td style="width: 150px;">
                                                <div class="badge badge-success">L21</div>
                                            </td>
                                            <td>
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left flex2">
                                                            <div class="widget-heading">
                                                                <a href="#NEOPOLITAN-IV-C1"  data-toggle="modal" data-target=".bd-example-modal-lg" >
                                                                    VILLA-VERDE-01
                                                                </a>
                                                            </div>
                                                            <div class="widget-subheading opacity-7">Quezon City</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width: 150px;">
                                                NCR788
                                            </td>
                                            <td>
                                                <div class="progress" style="min-height: 8px; height: 20px; max-width: 100%">
                                                    <div class="progress-bar stage-text stage1 stage-active" role="progressbar" aria-valuenow="16" aria-valuemin="0" aria-valuemax="0" style="width: 18.2%;">
                                                    </div>
                                                    <div class="progress-bar stage-text stage2 stage-disabled" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="17" style="width: 9.1%;">
                                                    </div>
                                                    <div class="progress-bar stage-text stage3 stage-disabled" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="17" style="width: 9.1%;">
                                                    </div>
                                                    <div class="progress-bar stage-text stage4 stage-disabled" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="17" style="width: 18.2%;">
                                                    </div>
                                                    <div class="progress-bar stage-text stage5 stage-disabled" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="17" style="width: 18.2%;">
                                                    </div>
                                                    <div class="progress-bar stage-text stage6 stage-disabled" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="17" style="width: 18.2%;">
                                                    </div>
                                                </div>
                                                SITE ENDORSEMENT                                            
                                            </td>                              
                                        </tr>
                                        <tr class="modalDataSite" data-sites="COLOC-102204">
                                            <td>
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left mr-3">
                                                            <div class="widget-content-left">
                                                                <img width="40" class="rounded-circle"
                                                                    src="images/avatars/4.jpg" alt="">
                                                            </div>
                                                        </div>
                                                        <div class="widget-content-left flex2">
                                                            <div class="widget-heading">John Doe</div>
                                                            <div class="widget-subheading opacity-7">Quezon City</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                COLOC-102204
                                            </td>
                                            <td style="width: 150px;">
                                                <div class="badge badge-success">L9</div>
                                            </td>
                                            <td>
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left flex2">
                                                            <div class="widget-heading">
                                                                <a href="#NEOPOLITAN-IV-C1"  data-toggle="modal" data-target=".bd-example-modal-lg" >
                                                                    GUADANOVILLE-XX
                                                                </a>
                                                            </div>
                                                            <div class="widget-subheading opacity-7">Quezon City</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width: 150px;">
                                                NCR788
                                            </td>
                                            <td>
                                                <div class="progress" style="min-height: 8px; height: 20px;  max-width: 100%">
                                                    <div class="progress-bar stage-text stage3 stage-active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="17" style="width: 9.1%;">
                                                    </div>
                                                    <div class="progress-bar stage-text stage4 stage-disabled" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="17" style="width: 27.3%;">
                                                    </div>
                                                    <div class="progress-bar stage-text stage5 stage-disabled" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="17" style="width: 27.3%;">
                                                    </div>
                                                    <div class="progress-bar stage-text stage6 stage-disabled" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="17" style="width: 18.2%;">
                                                    </div>
                                                </div>                                            
                                                PRE BUILD DOCUMENTS                                       
                                            </td>
                                        </tr>
                                        <tr class="modalDataSite" data-sites="COLOC-102205">
                                            <td>
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left mr-3">
                                                            <div class="widget-content-left">
                                                                <img width="40" class="rounded-circle"
                                                                    src="images/avatars/4.jpg" alt="">
                                                            </div>
                                                        </div>
                                                        <div class="widget-content-left flex2">
                                                            <div class="widget-heading">John Doe</div>
                                                            <div class="widget-subheading opacity-7">Quezon City</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                COLOC-102205
                                            </td>
                                            <td style="width: 150px;">
                                                <div class="badge badge-success">L21</div>
                                            </td>
                                            <td>
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left flex2">
                                                            <div class="widget-heading">
                                                                <a href="#NEOPOLITAN-IV-C1"  data-toggle="modal" data-target=".bd-example-modal-lg" >
                                                                    GUADANOVILLE-XX
                                                                </a>
                                                            </div>
                                                            <div class="widget-subheading opacity-7">Quezon City</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width: 150px;">
                                                NCR788
                                            </td>
                                            <td>
                                                <div class="progress" style="min-height: 8px; height: 20px;  max-width: 100%">
                                                    <div class="progress-bar stage-text stage3 stage-active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="17" style="width: 9.1%;">
                                                    </div>
                                                    <div class="progress-bar stage-text stage4 stage-disabled" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="17" style="width: 27.3%;">
                                                    </div>
                                                    <div class="progress-bar stage-text stage5 stage-disabled" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="17" style="width: 27.3%;">
                                                    </div>
                                                    <div class="progress-bar stage-text stage6 stage-disabled" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="17" style="width: 18.2%;">
                                                    </div>
                                                </div>
                                                PRE BUILD DOCUMENTS                                       
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
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_script')
    <script>
        $(document).on("click", ".modalDataSite", function(){
            $(".modal-title").text($(this).attr('data-sites'));
            $("#modal-assigned-sites").modal("show");
        });
    </script>
@endsection

@section('modals')


    <div class="modal fade" id="modal-assigned-sites" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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