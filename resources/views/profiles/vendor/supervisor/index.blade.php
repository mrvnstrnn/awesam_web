@extends('layouts.home')

@section('style')
    <style>
        .offline {
            -webkit-filter: grayscale(100%);
            filter: grayscale(100%);        
        }
    </style>
@endsection

@section('content')
<h3>Sites</h3>
<div class="row" style="margin-top: 20px;">
    <div class="col-md-6 col-lg-3">
        <div class="mb-3 card">
            <div class="widget-chart widget-chart2 text-left p-0">
                <div class="widget-chat-wrapper-outer">
                    <div class="widget-chart-content widget-chart-content-lg milestone-submilestones">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-gray.jpeg');   background-repeat: no-repeat; background-size: 100%;"></div>

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
    <div class="col-md-6 col-lg-3">
        <div class="mb-3 card">
            <div class="widget-chart widget-chart2 text-left p-0">
                <div class="widget-chat-wrapper-outer">
                    <div class="widget-chart-content widget-chart-content-lg milestone-submilestones" data-modal_title="Pre-BRGY Distribution" data-modal_ul="Pre_BRGY_Distribution">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-primary.jpeg');   background-repeat: no-repeat; background-size: 100%;"></div>

                        <div class="widget-chart-flex">
                            <div class="widget-title opacity-5 text-muted text-uppercase">
                                New Endorsements
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
    <div class="col-md-6 col-lg-3">
        <div class="mb-3 card">
            <div class="widget-chart widget-chart2 text-left p-0">
                <div class="widget-chat-wrapper-outer">
                    <div class="widget-chart-content widget-chart-content-lg milestone-submilestones"data-modal_title="Pre-ARTB Distribution"  data-modal_ul="Pre_ARTB_Distribution">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.10; height: 100%; width:100%; background-image: url('/images/milestone-orange-2.jpeg');   background-repeat: no-repeat; background-size: 100%;"></div>

                        <div class="widget-chart-flex">
                            <div class="widget-title opacity-5 text-muted text-uppercase">
                                Unassigned Sites
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
    <div class="col-md-6 col-lg-3">
        <div class="mb-3 card">
            <div class="widget-chart widget-chart2 text-left p-0">
                <div class="widget-chat-wrapper-outer">
                    <div class="widget-chart-content widget-chart-content-lg milestone-submilestones"data-modal_title="Pre-RTB Distribution" data-modal_ul="Pre_RTB_Distribution">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.15; height: 100%; width:100%; background-image: url('/images/milestone-green-2.jpeg');   background-repeat: no-repeat; background-size: 100%;"></div>

                        <div class="widget-chart-flex">
                            <div class="widget-title opacity-5 text-muted text-uppercase">
                                Sites w/ Issues
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
<div class="container"> 
    <div class="row" style="margin-left:-30px; margin-right: -30px;">
        <div class="col-12">
            <h3>My Team</h3>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mb-2 mt-1" style="text-align: center;">
                            <div>
                                <img class="rounded-circle" src="images/avatars/1.jpg" alt="" width="70">
                            </div>
                            <div style="text-align: center;">
                                <small>Test</small>
                            </div>
                        </div>
                        <div class="col mb-2 mt-1" style="text-align: center;">
                            <div>
                                <img class="rounded-circle" src="images/avatars/2.jpg" alt="" width="70">
                            </div>
                            <div style="text-align: center;">
                                <small>Test</small>
                            </div>
                        </div>
                        <div class="col mb-2 mt-1" style="text-align: center;">
                            <div>
                                <img class="rounded-circle offline" src="images/avatars/3.jpg" alt="" width="70">
                            </div>
                            <div style="text-align: center;">
                                <small>Test</small>
                            </div>
                        </div>
                        <div class="col mb-2 mt-1" style="text-align: center;">
                            <div>
                                <img class="rounded-circle offline" src="images/avatars/4.jpg" alt="" width="70">
                            </div>
                            <div style="text-align: center;">
                                <small>Test</small>
                            </div>
                        </div>
                        <div class="col mb-2 mt-1" style="text-align: center;">
                            <div>
                                <img class="rounded-circle" src="images/avatars/5.jpg" alt="" width="70">
                            </div>
                            <div style="text-align: center;">
                                <small>Test</small>
                            </div>
                        </div>
                        <div class="col mb-2" style="text-align: center;">
                            <div>
                                <img class="rounded-circle offline" src="images/avatars/6.jpg" alt="" width="70">
                            </div>
                            <div style="text-align: center;">
                                <small>Test</small>
                            </div>
                        </div>
                        <div class="col mb-2" style="text-align: center;">
                            <div>
                                <img class="rounded-circle" src="images/avatars/8.jpg" alt="" width="70">
                            </div>
                            <div style="text-align: center;">
                                <small>Test</small>
                            </div>
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