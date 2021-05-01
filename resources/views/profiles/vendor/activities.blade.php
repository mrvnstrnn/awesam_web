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
                            Unassigned Sites
                        </div>
                        <div class="table-responsive">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center" >SAM ID</th>
                                        <th>Site</th>
                                        <th >Technology</th>
                                        <th >PLA ID</th>
                                        <th >Endorsement</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center" style="width: 150px;">
                                            4354
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
                                        <td>
                                            L9, L21
                                        </td>
                                        <td>
                                            NCR788
                                        </td>
                                        <td style="width: 150px;">
                                            Mar 5, 2021
                                        </td>
                                        <td class="text-center">
                                            <button type="button" id="PopoverCustomT-1" class="btn btn-primary btn-sm">Details</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="width: 150px;">
                                            4355
                                        </td>
                                        <td>
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left flex2">
                                                        <div class="widget-heading">VILLA-VERDE-01</div>
                                                        <div class="widget-subheading opacity-7">Caloocan North</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            L9, L21
                                        </td>
                                        <td>
                                            NCR900
                                        </td>
                                        <td style="width: 150px;">
                                            Mar 5, 2021
                                        </td>
                                        <td class="text-center">
                                            <button type="button" id="PopoverCustomT-2" class="btn btn-primary btn-sm">Details</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="width: 150px;">
                                            4356
                                        </td>
                                        <td>
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left flex2">
                                                        <div class="widget-heading">GUADANOVILLE-XX</div>
                                                        <div class="widget-subheading opacity-7">
                                                            Caloocan South
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            L9, L21
                                        </td>
                                        <td>
                                            NCR329
                                        </td>
                                        <td style="width: 150px;">
                                            Mar 5, 2021
                                        </td>
                                        <td class="text-center">
                                            <button type="button" id="PopoverCustomT-3" class="btn btn-primary btn-sm">Details</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="width: 150px;">
                                            4357
                                        </td>
                                        <td>
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left flex2">
                                                        <div class="widget-heading">JORDAN-PLAINS-VV</div>
                                                        <div class="widget-subheading opacity-7">Malabon</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            L9, L21
                                        </td>
                                        <td>
                                            NCR432
                                        </td>
                                        <td style="width: 150px;">
                                            Mar 5, 2021
                                        </td>
                                        <td class="text-center">
                                            <button type="button" id="PopoverCustomT-4" class="btn btn-primary btn-sm">Details</button>
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