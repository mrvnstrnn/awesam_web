<div class="row">
    <div class="col-12">
        <h3>My Sites</h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="main-card mb-4 card">
            <div class="grid-menu grid-menu-4col">
                <div class="no-gutters row">
                    <div class="col-6 col-sm-6 col-md-3 col-lg-3">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-gray.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>
                        <div class="widget-chart widget-chart-hover  widget-chart2 text-left p-0">
                            <div class="widget-chat-wrapper-outer">
                                <div class="widget-chart-content widget-chart-content-lg milestone-submilestones"data-modal_title="Pre-RTB Distribution" data-modal_ul="Pre_RTB_Distribution">
                                    <div class="widget-chart-flex">
                                        <div class="widget-title opacity-10   text-uppercase">
                                            Assigned Sites
                                        </div>
                                    </div>
                                    <div class="widget-numbers">
                                        <div class="widget-chart-flex">
                                            <div>
                                                <span class="opacity-10 text-secondary pr-2">
                                                    <i class="fa fa-location-arrow"></i>
                                                </span>
                                                <span>{{ \DB::connection('mysql2')->select('call `counter_vendor_agent_supervisor`('. \Auth::id() .')')[0]->counter }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-3 col-lg-3">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-red.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>
                        <div class="widget-chart widget-chart-hover  widget-chart2 text-left p-0">
                            <div class="widget-chat-wrapper-outer">
                                <div class="widget-chart-content widget-chart-content-lg milestone-submilestones"data-modal_title="Pre-RTB Distribution" data-modal_ul="Pre_RTB_Distribution">
                                    <div class="widget-chart-flex">
                                        <div class="widget-title opacity-10   text-uppercase">
                                            Sites w/ Issues
                                        </div>
                                    </div>
                                    <div class="widget-numbers">
                                        <div class="widget-chart-flex">
                                            <div>
                                                <span class="opacity-10 text-danger pr-2">
                                                    <i class="fa fa-list-ol"></i>
                                                </span>
                                                <span>{{ \DB::connection('mysql2')->select('call `counter_vendor_agent_supervisor`('. \Auth::id() .')')[1]->counter }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-3 col-lg-3">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-orange-2.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>
                        <div class="widget-chart widget-chart-hover  widget-chart2 text-left p-0">
                            <div class="widget-chat-wrapper-outer">
                                <div class="widget-chart-content widget-chart-content-lg milestone-submilestones"data-modal_title="Pre-RTB Distribution" data-modal_ul="Pre_RTB_Distribution">
                                    <div class="widget-chart-flex">
                                        <div class="widget-title opacity-10   text-uppercase">
                                            Doc Validation
                                        </div>
                                    </div>
                                    <div class="widget-numbers">
                                        <div class="widget-chart-flex">
                                            <div>
                                                <span class="opacity-10 text-warning pr-2">
                                                    <i class="fa fa-file-contract"></i>
                                                </span>
                                                <span>{{ \DB::connection('mysql2')->select('call `counter_vendor_agent_supervisor`('. \Auth::id() .')')[2]->counter }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-3 col-lg-3">
                        <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.30; height: 100%; width:100%; background-image: url('/images/milestone-green-2.jpeg');   background-repeat: no-repeat; background-size: 200%;"></div>
                        <div class="widget-chart widget-chart-hover  widget-chart2 text-left p-0">
                            <div class="widget-chat-wrapper-outer">
                                <div class="widget-chart-content widget-chart-content-lg milestone-submilestones"data-modal_title="Pre-RTB Distribution" data-modal_ul="Pre_RTB_Distribution">
                                    <div class="widget-chart-flex">
                                        <div class="widget-title opacity-10   text-uppercase">
                                            Completed Sites
                                        </div>
                                    </div>
                                    <div class="widget-numbers">
                                        <div class="widget-chart-flex">
                                            <div>
                                                <span class="opacity-10 text-success pr-2">
                                                    <i class="fa fa-angle-double-right"></i>
                                                </span>
                                                <span>{{ \DB::connection('mysql2')->select('call `counter_vendor_agent_supervisor`('. \Auth::id() .')')[3]->counter }}</span>
                                            </div>
                                        </div>
                                    </div>
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
