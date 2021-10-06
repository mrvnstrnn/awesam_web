@extends('layouts.home')

@section('content')

    <div class="row">
        <div class="col-12">
            <h3>My Sites</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="mb-3 card">
                <div class="widget-chart widget-chart2 text-left p-0">
                    <div class="widget-chat-wrapper-outer">
                        <div class="widget-chart-content widget-chart-content-lg milestone-submilestones">
                            <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-gray.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>

                            <div class="widget-chart-flex">
                                <div class="widget-title  text-muted text-uppercase">
                                    Assigned Sites
                                </div>
                            </div>
                            <div class="widget-numbers">
                                <span class="opacity-10 text-secondary pr-2">
                                    <i class="fa fa-upload"></i>
                                </span>
                                <span>1</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3 card">
                <div class="widget-chart widget-chart2 text-left p-0">
                    <div class="widget-chat-wrapper-outer">
                        <div class="widget-chart-content widget-chart-content-lg milestone-submilestones" data-modal_title="Pre-BRGY Distribution" data-modal_ul="Pre_BRGY_Distribution">
                            <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-primary.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>

                            <div class="widget-chart-flex">
                                <div class="widget-title opacity-5 text-muted text-uppercase">
                                    Sites w/ Issues
                                </div>
                            </div>
                            <div class="widget-numbers">
                                <span class="opacity-10 text-info">
                                    <i class="fa fa-list-ol"></i>
                                </span>
                                <span>0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3 card">
                <div class="widget-chart widget-chart2 text-left p-0">
                    <div class="widget-chat-wrapper-outer">
                        <div class="widget-chart-content widget-chart-content-lg milestone-submilestones"data-modal_title="Pre-ARTB Distribution"  data-modal_ul="Pre_ARTB_Distribution">
                            <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.10; height: 100%; width:100%; background-image: url('/images/milestone-orange-2.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>
    
                            <div class="widget-chart-flex">
                                <div class="widget-title opacity-5 text-muted text-uppercase">
                                    Ongoing Doc Validation
                                </div>
                            </div>
                            <div class="widget-numbers">
                                <div class="widget-chart-flex">
                                    <div>
                                        <span class="opacity-10 text-warning pr-2">
                                            <i class="fa fa-file-contract"></i>
                                        </span>
                                        <span>0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3 card">
                <div class="widget-chart widget-chart2 text-left p-0">
                    <div class="widget-chat-wrapper-outer">
                        <div class="widget-chart-content widget-chart-content-lg milestone-submilestones"data-modal_title="Pre-RTB Distribution" data-modal_ul="Pre_RTB_Distribution">
                            <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.15; height: 100%; width:100%; background-image: url('/images/milestone-green-2.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>
    
                            <div class="widget-chart-flex">
                                <div class="widget-title opacity-5 text-muted text-uppercase">
                                    Completed Sites
                                </div>
                            </div>
                            <div class="widget-numbers">
                                <div class="widget-chart-flex">
                                    <div>
                                        <span class="opacity-10 text-success pr-2">
                                            <i class="fa fa-angle-double-right"></i>
                                        </span>
                                        <span>0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="divider"></div>
    <div class="row">
        <div class="col-12">
            <h3>My Badges</h3>
        </div>
    </div>
    <div class="row p-2">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">                
                            <div class="star-box text-center">
                                <img src="/images/blue-star.png" width="40px">
                            </div>
                            <div class="star-box-type text-center" style="font-weight: bold; font-size: 14px !important;">
                                100
                            </div>
                            <div class="star-box-type text-center" style="font-size: 12px !important;">
                                Daily Login
                            </div>
                        </div>
                        <div class="col">
                            <div class="star-box text-center">
                                <img src="/images/blue-star.png" width="40px">
                            </div>
                            <div class="star-box-type text-center" style="font-weight: bold; font-size: 14px !important;">
                                100
                            </div>
                            <div class="star-box-type text-center" style="font-size: 12px !important;">
                                RTB Sites
                            </div>
                        </div>
                        <div class="col">
                            <div class="star-box text-center">
                                <img src="/images/blue-star.png" width="40px">
                            </div>
                            <div class="star-box-type text-center" style="font-weight: bold; font-size: 14px !important;">
                                100
                            </div>
                            <div class="star-box-type text-center" style="font-size: 12px !important;">
                                Completed Sites
                            </div>
                        </div>
                        <div class="col">
                            <div class="star-box text-center">
                                <img src="/images/blue-star.png" width="40px">
                            </div>
                            <div class="star-box-type text-center" style="font-weight: bold; font-size: 14px !important;">
                                100
                            </div>
                            <div class="star-box-type text-center" style="font-size: 12px !important;">
                                Sites w/ No Issue
                            </div>
                        </div>
                        <div class="col">
                            <div class="star-box text-center">
                                <img src="/images/blue-star.png" width="40px">
                            </div>
                            <div class="star-box-type text-center" style="font-weight: bold; font-size: 14px !important;">
                                100
                            </div>
                            <div class="star-box-type text-center" style="font-size: 12px !important;">
                                Attendance
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section("js_script")


@endsection