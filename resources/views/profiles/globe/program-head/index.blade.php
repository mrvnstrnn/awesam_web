@extends('layouts.main')

@section('content')

    @include('profiles.dar_content')

@endsection

@section('modals')
<div id="modal-milestone-submilestones" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-image: url('/images/milestone-orange.jpeg');   background-repeat: no-repeat; background-size: 100%; opacity: 0.75">
          <h5 class="modal-title" style="opacity: 1; color: black; z-index: 200; font-weight:bold; text-shadow: 1px 1px white;">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 my-2 text-center" >
                    <H1 id="header_total" style="letter-spacing: 5px; font-weight: bolder;"><i class="fa fa-angle-double-down"></i> 11</H1>
                </div> 
            </div>
            <ul id="PR_Created_Distribution" class="list-group list-group-flush d-none">
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">Open</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>0</span>
                                    <small class="text-danger pl-2">
                                        <i class="fa fa-angle-down"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>                                    
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.0909</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">For RAM Approval</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>1</span>
                                    <small class="text-danger pl-2">
                                        <i class="fa fa-angle-down"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">For NAM Approval</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>0</span>
                                    <small class="text-success pl-2">
                                        <i class="fa fa-angle-up"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.8181</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">For Arriba PR Issuance</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>9</span>
                                    <small class="text-warning pl-2">
                                        <i class="fa fa-angle-down"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.0909</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">Awaiting PO</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>1</span>
                                    <small class="text-danger pl-2">
                                        <i class="fa fa-angle-down"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>    
            <ul id="Pre_SSDS_NTP_Distribution" class="list-group list-group-flush  d-none">
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.0372</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">Pre-SSDS Pending</div>
                                <div class="widget-subheading">New</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>25</span>
                                    <small class="text-danger pl-2">
                                        <i class="fa fa-angle-down"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item ul-group-label">
                    <H4 class="mb-0 mt-2">Site Hunting</H4>
                </li>
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.1056</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">Advance Site Hunting Target Date</div>
                                <div class="widget-subheading">Site Hunting</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>71</span>
                                    <small class="text-success pl-2">
                                        <i class="fa fa-angle-up"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.1577</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">Advance Site Hunting Actual Date</div>
                                <div class="widget-subheading">Site Hunting</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>106</span>
                                    <small class="text-warning pl-2">
                                        <i class="fa fa-angle-down"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item ul-group-label">
                    <H4 class="mb-0 mt-3">JTSS</H4>
                </li>
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.1949</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">Target Survey Date</div>
                                <div class="widget-subheading">JTSS</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>131</span>
                                    <small class="text-danger pl-2">
                                        <i class="fa fa-angle-down"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.1130</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">Actual Survey Date</div>
                                <div class="widget-subheading">JTSS</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>76</span>
                                    <small class="text-success pl-2">
                                        <i class="fa fa-angle-up"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item ul-group-label">
                    <H4 class="mb-0 mt-2">SSDS</H4>
                </li>
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.0372</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">SSDS Uploaded</div>
                                <div class="widget-subheading">SSDS</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>25</span>
                                    <small class="text-success pl-2">
                                        <i class="fa fa-angle-up"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.0104</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">SSDS RAM Confirmed</div>
                                <div class="widget-subheading">SSDS</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>7</span>
                                    <small class="text-success pl-2">
                                        <i class="fa fa-angle-up"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.2992</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">Approved SSDS/NTP Uploaded</div>
                                <div class="widget-subheading">SSDS</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>202</span>
                                    <small class="text-success pl-2">
                                        <i class="fa fa-angle-up"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.0431</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">Approved SSDS/NTP Confirmed</div>
                                <div class="widget-subheading">SSDS</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>29</span>
                                    <small class="text-success pl-2">
                                        <i class="fa fa-angle-up"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>                
            <ul id="Pre_MOC_NTP_Distribution" class="list-group list-group-flush  d-none">
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.4</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">Pre-MOC Pending</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>769</span>
                                    <small class="text-danger pl-2">
                                        <i class="fa fa-angle-down"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>                                    
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.4</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">Lease Rate Negotiated</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>80</span>
                                    <small class="text-danger pl-2">
                                        <i class="fa fa-angle-down"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.4</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">eLAS Approved</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>67</span>
                                    <small class="text-success pl-2">
                                        <i class="fa fa-angle-up"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.4</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">Approved MOC/NTP Uploaded</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>263</span>
                                    <small class="text-warning pl-2">
                                        <i class="fa fa-angle-down"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.4</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">Approved MOC/NTP RAM Approved</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>184</span>
                                    <small class="text-danger pl-2">
                                        <i class="fa fa-angle-down"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>    
            <ul id="Pre_BRGY_Distribution" class="list-group list-group-flush  d-none">
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.4</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">Pre-BRGY Pending</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>76</span>
                                    <small class="text-danger pl-2">
                                        <i class="fa fa-angle-down"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>                                    
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.4</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">NC Uploaded</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>10</span>
                                    <small class="text-danger pl-2">
                                        <i class="fa fa-angle-down"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.4</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">HOA Uploaded</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>0</span>
                                    <small class="text-success pl-2">
                                        <i class="fa fa-angle-up"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.4</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">BRGY Resolution</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>5</span>
                                    <small class="text-warning pl-2">
                                        <i class="fa fa-angle-down"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>    
            <ul id="Pre_ARTB_Distribution" class="list-group list-group-flush  d-none">
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.4</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">Pre-ARTB Pending</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>152</span>
                                    <small class="text-danger pl-2">
                                        <i class="fa fa-angle-down"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>                                    
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.4</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">Geodetic / SE Scheduled</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>35</span>
                                    <small class="text-danger pl-2">
                                        <i class="fa fa-angle-down"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.4</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">Geodetic / SE Surveyed</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>12</span>
                                    <small class="text-success pl-2">
                                        <i class="fa fa-angle-up"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.4</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">Seg Plan / SI Uploaded</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>32</span>
                                    <small class="text-warning pl-2">
                                        <i class="fa fa-angle-down"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.4</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">LGU Applied</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>30</span>
                                    <small class="text-danger pl-2">
                                        <i class="fa fa-angle-down"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>    
            <ul id="Pre_RTB_Distribution" class="list-group list-group-flush  d-none">
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.4</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">Pre-RTB Pending</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>190</span>
                                    <small class="text-danger pl-2">
                                        <i class="fa fa-angle-down"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>                                    
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.4</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">Locational Clearance Uploaded</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>2</span>
                                    <small class="text-danger pl-2">
                                        <i class="fa fa-angle-down"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.4</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">Locational Clearance Confirmed</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>1</span>
                                    <small class="text-warning pl-2">
                                        <i class="fa fa-angle-down"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.4</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">National Govt Permits Uploaded</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>75</span>
                                    <small class="text-danger pl-2">
                                        <i class="fa fa-angle-down"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.4</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">National Govt Permits Confirmed</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>11</span>
                                    <small class="text-danger pl-2">
                                        <i class="fa fa-angle-down"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.4</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">Anciliary Permits Uploaded</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>32</span>
                                    <small class="text-danger pl-2">
                                        <i class="fa fa-angle-down"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.4</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">Anciliary Permits Confirmed</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>2</span>
                                    <small class="text-danger pl-2">
                                        <i class="fa fa-angle-down"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.4</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">Building Permit Uploaded</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>10</span>
                                    <small class="text-danger pl-2">
                                        <i class="fa fa-angle-down"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="circle-progress circle-progress-primary d-inline-block">
                                    <small><span class="site_progress">0.4</span></small>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">Building Permit Confirmed</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="font-size-xlg text-muted">
                                    <span>78</span>
                                    <small class="text-danger pl-2">
                                        <i class="fa fa-angle-down"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

            </ul>    

        </div>
      </div>
    </div>
  </div>
@endsection

@section("js_script")


    @include('profiles.dar_js')

@endsection