@extends('layouts.main')

@section('content')

<div class="row">
<div class="col-md-6 col-lg-3">
        <div class="mb-3 card">
            <div class="widget-chart widget-chart2 text-left p-0">
                <div class="widget-chat-wrapper-outer">
                    <div class="widget-chart-content widget-chart-content-lg milestone-submilestones">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-gray.jpeg');   background-repeat: no-repeat; background-size: 100%;"></div>

                        <div class="widget-chart-flex">
                            <div class="widget-title  text-muted text-uppercase">
                                LOCALCOOP
                            </div>
                        </div>
                        <div class="widget-numbers">
                            <span class="opacity-10 text-secondary pr-2">
                                <i class="fa fa-upload"></i>
                            </span>
                            <span id="totals_localcoop" class="totals_dashboard">0</span>
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
                    <div class="widget-chart-content widget-chart-content-lg milestone-submilestones">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-gray.jpeg');   background-repeat: no-repeat; background-size: 100%;"></div>

                        <div class="widget-chart-flex">
                            <div class="widget-title  text-muted text-uppercase">
                                New Sites
                            </div>
                        </div>
                        <div class="widget-numbers">
                            <span class="opacity-10 text-secondary pr-2">
                                <i class="fa fa-upload"></i>
                            </span>
                            <span id="totals_newsites" class="totals_dashboard">0</span>
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
                    <div class="widget-chart-content widget-chart-content-lg milestone-submilestones">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-gray.jpeg');   background-repeat: no-repeat; background-size: 100%;"></div>

                        <div class="widget-chart-flex">
                            <div class="widget-title  text-muted text-uppercase">
                                COLOC
                            </div>
                        </div>
                        <div class="widget-numbers">
                            <span class="opacity-10 text-secondary pr-2">
                                <i class="fa fa-upload"></i>
                            </span>
                            <span id="totals_coloc" class="totals_dashboard">0</span>
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
                    <div class="widget-chart-content widget-chart-content-lg milestone-submilestones">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-gray.jpeg');   background-repeat: no-repeat; background-size: 100%;"></div>

                        <div class="widget-chart-flex">
                            <div class="widget-title  text-muted text-uppercase">
                                IBS
                            </div>
                        </div>
                        <div class="widget-numbers">
                            <span class="opacity-10 text-secondary pr-2">
                                <i class="fa fa-upload"></i>
                            </span>
                            <span id="totals_ibs" class="totals_dashboard">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-lg-3">
        <div class="mb-3 card">
            <div class="widget-chart widget-chart2 text-left p-0">
                <div class="widget-chat-wrapper-outer">
                    <div class="widget-chart-content widget-chart-content-lg milestone-submilestones">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-gray.jpeg');   background-repeat: no-repeat; background-size: 100%;"></div>

                        <div class="widget-chart-flex">
                            <div class="widget-title  text-muted text-uppercase">
                                TowerCo
                            </div>
                        </div>
                        <div class="widget-numbers">
                            <span class="opacity-10 text-secondary pr-2">
                                <i class="fa fa-upload"></i>
                            </span>
                            <span id="totals_towerco" class="totals_dashboard">0</span>
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
                    <div class="widget-chart-content widget-chart-content-lg milestone-submilestones">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-gray.jpeg');   background-repeat: no-repeat; background-size: 100%;"></div>

                        <div class="widget-chart-flex">
                            <div class="widget-title  text-muted text-uppercase">
                                FTTH
                            </div>
                        </div>
                        <div class="widget-numbers">
                            <span class="opacity-10 text-secondary pr-2">
                                <i class="fa fa-upload"></i>
                            </span>
                            <span id="totals_ftth" class="totals_dashboard">0</span>
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
                    <div class="widget-chart-content widget-chart-content-lg milestone-submilestones">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-gray.jpeg');   background-repeat: no-repeat; background-size: 100%;"></div>

                        <div class="widget-chart-flex">
                            <div class="widget-title  text-muted text-uppercase">
                                MWAN
                            </div>
                        </div>
                        <div class="widget-numbers">
                            <span class="opacity-10 text-secondary pr-2">
                                <i class="fa fa-upload"></i>
                            </span>
                            <span id="totals_mwan" class="totals_dashboard">0</span>
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
                    <div class="widget-chart-content widget-chart-content-lg milestone-submilestones">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-gray.jpeg');   background-repeat: no-repeat; background-size: 100%;"></div>

                        <div class="widget-chart-flex">
                            <div class="widget-title  text-muted text-uppercase">
                                Renewal
                            </div>
                        </div>
                        <div class="widget-numbers">
                            <span class="opacity-10 text-secondary pr-2">
                                <i class="fa fa-upload"></i>
                            </span>
                            <span id="totals_renewal" class="totals_dashboard">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection