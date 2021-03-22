@extends('layouts.main')

@section('content')

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
                        <div class="card-header">
                            Assigned Sites
                        </div>
                        <div class="table-responsive">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center" >Agent</th>
                                        <th>Site</th>
                                        <th >Technology</th>
                                        <th >PLA ID</th>
                                        <th >Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center" style="width: 150px;">
                                            <img width="40" class="rounded-circle"
                                                src="/images/avatars/4.jpg" alt="">
                                        </td>
                                        <td>
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left flex2">
                                                        <div class="widget-heading">NEOPOLITAN-IV-C1</div>
                                                        <div class="widget-subheading opacity-7">Quezon City</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 150px;">
                                            <div class="badge badge-success">L9</div>
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
                                    <tr>
                                        <td class="text-center" style="width: 150px;">
                                            <img width="40" class="rounded-circle"
                                                src="/images/avatars/4.jpg" alt="">
                                        </td>
                                        <td>
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left flex2">
                                                        <div class="widget-heading">NEOPOLITAN-IV-C1</div>
                                                        <div class="widget-subheading opacity-7">Quezon City</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 150px;">
                                            <div class="badge badge-success">L21</div>
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
                                    <tr>
                                        <td class="text-center" style="width: 150px;">
                                            <img width="40" class="rounded-circle"
                                                src="/images/avatars/5.jpg" alt="">
                                        </td>
                                        <td>
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left flex2">
                                                        <div class="widget-heading">VILLA-VERDE-01                                                        </div>
                                                        <div class="widget-subheading opacity-7">Quezon City</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 150px;">
                                            <div class="badge badge-success">L9</div>
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
                                    <tr>
                                        <td class="text-center" style="width: 150px;">
                                            <img width="40" class="rounded-circle"
                                                src="/images/avatars/5.jpg" alt="">
                                        </td>
                                        <td>
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left flex2">
                                                        <div class="widget-heading">VILLA-VERDE-01</div>
                                                        <div class="widget-subheading opacity-7">Quezon City</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 150px;">
                                            <div class="badge badge-success">L21</div>
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
                                    <tr>
                                        <td class="text-center" style="width: 150px;">
                                            <img width="40" class="rounded-circle"
                                                src="/images/avatars/6.jpg" alt="">
                                        </td>
                                        <td>
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left flex2">
                                                        <div class="widget-heading">GUADANOVILLE-XX                                                        </div>
                                                        <div class="widget-subheading opacity-7">Quezon City</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 150px;">
                                            <div class="badge badge-success">L9</div>
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
                                    <tr>
                                        <td class="text-center" style="width: 150px;">
                                            <img width="40" class="rounded-circle"
                                                src="/images/avatars/6.jpg" alt="">
                                        </td>
                                        <td>
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left flex2">
                                                        <div class="widget-heading">GUADANOVILLE-XX                                                        </div>
                                                        <div class="widget-subheading opacity-7">Quezon City</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 150px;">
                                            <div class="badge badge-success">L21</div>
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