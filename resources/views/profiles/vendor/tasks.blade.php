@extends('layouts.main')

@section('content')

    <ul class="tabs-animated body-tabs-animated nav">
        <li class="nav-item">
            <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab" href="#tab-content-0">
                <span>Today</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link" id="tab-1" data-toggle="tab" href="#tab-content-1">
                <span>Weekly</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#tab-content-2">
                <span>Monthly</span>
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="row">
                <div class="col-md-12 col-lg-6 col-xl-7">
                    <div class="card mb-3 widget-content">
                        <div class="widget-content-outer">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="widget-heading">Completed Tasks</div>
                                    <div class="widget-subheading">Tasks completed by agents today</div>
                                </div>
                                <div class="widget-content-right">
                                    <div class="widget-numbers text-success">10</div>
                                </div>
                            </div>
                            <div class="widget-progress-wrapper">
                                <div class="progress-bar-xl progress-bar-animated-alt progress">
                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="62.5" aria-valuemin="0" aria-valuemax="100" style="width: 65%;">
                                    </div>
                                </div>
                                <div class="progress-sub-label">
                                    <div class="sub-label-left">Completion Rate</div>
                                    <div class="sub-label-right">100%</div>
                                </div>
                            </div>
                        </div>
                    </div>                    
                    <div class="card-hover-shadow-2x mb-3 card">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                Tasks Today
                            </div>
                            <div class="btn-actions-pane-right text-capitalize actions-icon-btn">
                                <div class="btn-group dropdown">
                                    <button type="button" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" class="btn-icon btn-icon-only btn btn-link">
                                        <i class="pe-7s-menu btn-icon-wrapper"></i>
                                    </button>
                                    <div tabindex="-1" role="menu" aria-hidden="true"
                                        class="dropdown-menu-right rm-pointers dropdown-menu-shadow dropdown-menu-hover-link dropdown-menu">
                                        <h6 tabindex="-1" class="dropdown-header">Header</h6>
                                        <button type="button" tabindex="0" class="dropdown-item">
                                            <i class="dropdown-icon lnr-inbox"></i>
                                            <span>Menus</span>
                                        </button>
                                        <button type="button" tabindex="0" class="dropdown-item">
                                            <i class="dropdown-icon lnr-file-empty"></i>
                                            <span>Settings</span>
                                        </button>
                                        <button type="button" tabindex="0" class="dropdown-item">
                                            <i class="dropdown-icon lnr-book"></i>
                                            <span>Actions</span>
                                        </button>
                                        <div tabindex="-1" class="dropdown-divider"></div>
                                        <div class="p-3 text-right">
                                            <button class="mr-2 btn-shadow btn-sm btn btn-link">View Details</button>
                                            <button class="mr-2 btn-shadow btn-sm btn btn-primary">Action</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="nav">
                            <li class="nav-item">
                                <a data-toggle="tab" href="#tab-eg7-0" class="nav-link active">
                                    <img width="38" class="rounded-circle" src="/images/avatars/1.jpg" alt="">
                                </a>
                            </li>
                            <li class="nav-item">
                                <a data-toggle="tab" href="#tab-eg7-1" class="nav-link">
                                    <img width="38" class="rounded-circle" src="/images/avatars/2.jpg" alt="">
                                </a>
                            </li>
                            <li class="nav-item">
                                <a data-toggle="tab" href="#tab-eg7-2" class="nav-link">
                                    <img width="38" class="rounded-circle" src="/images/avatars/3.jpg" alt="">
                                </a>
                            </li>
                            <li class="nav-item">
                                <a data-toggle="tab" href="#tab-eg7-3" class="nav-link">
                                    <img width="38" class="rounded-circle" src="/images/avatars/4.jpg" alt="">
                                </a>
                            </li>
                        </ul>
                        <hr style='margin-top: 0px; margin-bottom:0.5em'>
                        <div class="scroll-area-md">
                            <div class="scrollbar-container">
                                <div class="p-4">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab-eg7-0" role="tabpanel">
                                                    <H4>Beck Collier</H4>
                                                    <div class="vertical-time-icons vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                                                        <div class="vertical-timeline-item vertical-timeline-element">
                                                            <div>
                                                                <div class="vertical-timeline-element-icon bounce-in">
                                                                    <div class="timeline-icon border-primary">
                                                                        <i class="lnr-license icon-gradient bg-night-fade"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="vertical-timeline-element-content bounce-in">
                                                                    <h4 class="timeline-title">All Hands Meeting</h4>
                                                                    <p>
                                                                        Lorem ipsum dolor sic amet, today at
                                                                        <a href="javascript:void(0);">12:00 PM</a>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="vertical-timeline-item vertical-timeline-element">
                                                            <div>
                                                                <div class="vertical-timeline-element-icon bounce-in">
                                                                    <div class="timeline-icon border-warning">
                                                                        <i class="lnr-cog fa-spin icon-gradient bg-happy-itmeo"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="vertical-timeline-element-content bounce-in">
                                                                    <p>Another meeting today, at
                                                                        <b class="text-danger">12:00 PM</b>
                                                                    </p>
                                                                    <p>Yet another one, at
                                                                        <span class="text-success">15:00 PM</span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="vertical-timeline-item vertical-timeline-element">
                                                            <div>
                                                                <div class="vertical-timeline-element-icon bounce-in">
                                                                    <div class="timeline-icon border-warning bg-warning">
                                                                        <i class="fa fa-archive fa-w-16 text-white"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="vertical-timeline-element-content bounce-in">
                                                                    <h4 class="timeline-title">Build the production release</h4>
                                                                    <p>
                                                                        Lorem ipsum dolor sit amit,consectetur eiusmdd tempor incididunt ut
                                                                        labore et dolore magna elit enim at minim veniam quis nostrud
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="vertical-timeline-item vertical-timeline-element">
                                                            <div>
                                                                <span class="vertical-timeline-element-icon bounce-in">
                                                                    <div class="timeline-icon bg-danger border-danger">
                                                                        <i class="pe-7s-cloud-upload text-white"></i>
                                                                    </div>
                                                                </span>
                                                                <div class="vertical-timeline-element-content bounce-in">
                                                                    <p>Another meeting today, at
                                                                        <b class="text-warning">12:00 PM</b>
                                                                    </p>
                                                                    <p>Yet another one, at
                                                                        <span class="text-dark">15:00 PM</span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                </div>
                                                <div class="tab-pane" id="tab-eg7-1" role="tabpanel">
                                                    <H4>Saim Melendez</H4>
                                                    <div class="vertical-time-icons vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                                                        <div class="vertical-timeline-item vertical-timeline-element">
                                                            <div>
                                                                <div class="vertical-timeline-element-icon bounce-in">
                                                                    <div class="timeline-icon border-primary">
                                                                        <i class="lnr-license icon-gradient bg-night-fade"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="vertical-timeline-element-content bounce-in">
                                                                    <h4 class="timeline-title">All Hands Meeting</h4>
                                                                    <p>
                                                                        Lorem ipsum dolor sic amet, today at
                                                                        <a href="javascript:void(0);">12:00 PM</a>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="vertical-timeline-item vertical-timeline-element">
                                                            <div>
                                                                <div class="vertical-timeline-element-icon bounce-in">
                                                                    <div class="timeline-icon border-warning">
                                                                        <i class="lnr-cog fa-spin icon-gradient bg-happy-itmeo"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="vertical-timeline-element-content bounce-in">
                                                                    <p>Another meeting today, at
                                                                        <b class="text-danger">12:00 PM</b>
                                                                    </p>
                                                                    <p>Yet another one, at
                                                                        <span class="text-success">15:00 PM</span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="vertical-timeline-item vertical-timeline-element">
                                                            <div>
                                                                <div class="vertical-timeline-element-icon bounce-in">
                                                                    <div class="timeline-icon border-warning bg-warning">
                                                                        <i class="fa fa-archive fa-w-16 text-white"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="vertical-timeline-element-content bounce-in">
                                                                    <h4 class="timeline-title">Build the production release</h4>
                                                                    <p>
                                                                        Lorem ipsum dolor sit amit,consectetur eiusmdd tempor incididunt ut
                                                                        labore et dolore magna elit enim at minim veniam quis nostrud
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="vertical-timeline-item vertical-timeline-element">
                                                            <div>
                                                                <span class="vertical-timeline-element-icon bounce-in">
                                                                    <div class="timeline-icon bg-danger border-danger">
                                                                        <i class="pe-7s-cloud-upload text-white"></i>
                                                                    </div>
                                                                </span>
                                                                <div class="vertical-timeline-element-content bounce-in">
                                                                    <p>Another meeting today, at
                                                                        <b class="text-warning">12:00 PM</b>
                                                                    </p>
                                                                    <p>Yet another one, at
                                                                        <span class="text-dark">15:00 PM</span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab-eg7-2" role="tabpanel">
                                                    <H4>Primrose Navarro</H4>
                                                    <div class="vertical-time-icons vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                                                        <div class="vertical-timeline-item vertical-timeline-element">
                                                            <div>
                                                                <div class="vertical-timeline-element-icon bounce-in">
                                                                    <div class="timeline-icon border-primary">
                                                                        <i class="lnr-license icon-gradient bg-night-fade"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="vertical-timeline-element-content bounce-in">
                                                                    <h4 class="timeline-title">All Hands Meeting</h4>
                                                                    <p>
                                                                        Lorem ipsum dolor sic amet, today at
                                                                        <a href="javascript:void(0);">12:00 PM</a>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="vertical-timeline-item vertical-timeline-element">
                                                            <div>
                                                                <div class="vertical-timeline-element-icon bounce-in">
                                                                    <div class="timeline-icon border-warning">
                                                                        <i class="lnr-cog fa-spin icon-gradient bg-happy-itmeo"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="vertical-timeline-element-content bounce-in">
                                                                    <p>Another meeting today, at
                                                                        <b class="text-danger">12:00 PM</b>
                                                                    </p>
                                                                    <p>Yet another one, at
                                                                        <span class="text-success">15:00 PM</span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="vertical-timeline-item vertical-timeline-element">
                                                            <div>
                                                                <div class="vertical-timeline-element-icon bounce-in">
                                                                    <div class="timeline-icon border-warning bg-warning">
                                                                        <i class="fa fa-archive fa-w-16 text-white"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="vertical-timeline-element-content bounce-in">
                                                                    <h4 class="timeline-title">Build the production release</h4>
                                                                    <p>
                                                                        Lorem ipsum dolor sit amit,consectetur eiusmdd tempor incididunt ut
                                                                        labore et dolore magna elit enim at minim veniam quis nostrud
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="vertical-timeline-item vertical-timeline-element">
                                                            <div>
                                                                <span class="vertical-timeline-element-icon bounce-in">
                                                                    <div class="timeline-icon bg-danger border-danger">
                                                                        <i class="pe-7s-cloud-upload text-white"></i>
                                                                    </div>
                                                                </span>
                                                                <div class="vertical-timeline-element-content bounce-in">
                                                                    <p>Another meeting today, at
                                                                        <b class="text-warning">12:00 PM</b>
                                                                    </p>
                                                                    <p>Yet another one, at
                                                                        <span class="text-dark">15:00 PM</span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>        
                                                </div>
                                                <div class="tab-pane" id="tab-eg7-3" role="tabpanel">
                                                    <H4>Primrose Navarro</H4>
                                                    <div class="vertical-time-icons vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                                                        <div class="vertical-timeline-item vertical-timeline-element">
                                                            <div>
                                                                <div class="vertical-timeline-element-icon bounce-in">
                                                                    <div class="timeline-icon border-primary">
                                                                        <i class="lnr-license icon-gradient bg-night-fade"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="vertical-timeline-element-content bounce-in">
                                                                    <h4 class="timeline-title">All Hands Meeting</h4>
                                                                    <p>
                                                                        Lorem ipsum dolor sic amet, today at
                                                                        <a href="javascript:void(0);">12:00 PM</a>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="vertical-timeline-item vertical-timeline-element">
                                                            <div>
                                                                <div class="vertical-timeline-element-icon bounce-in">
                                                                    <div class="timeline-icon border-warning">
                                                                        <i class="lnr-cog fa-spin icon-gradient bg-happy-itmeo"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="vertical-timeline-element-content bounce-in">
                                                                    <p>Another meeting today, at
                                                                        <b class="text-danger">12:00 PM</b>
                                                                    </p>
                                                                    <p>Yet another one, at
                                                                        <span class="text-success">15:00 PM</span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="vertical-timeline-item vertical-timeline-element">
                                                            <div>
                                                                <div class="vertical-timeline-element-icon bounce-in">
                                                                    <div class="timeline-icon border-warning bg-warning">
                                                                        <i class="fa fa-archive fa-w-16 text-white"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="vertical-timeline-element-content bounce-in">
                                                                    <h4 class="timeline-title">Build the production release</h4>
                                                                    <p>
                                                                        Lorem ipsum dolor sit amit,consectetur eiusmdd tempor incididunt ut
                                                                        labore et dolore magna elit enim at minim veniam quis nostrud
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="vertical-timeline-item vertical-timeline-element">
                                                            <div>
                                                                <span class="vertical-timeline-element-icon bounce-in">
                                                                    <div class="timeline-icon bg-danger border-danger">
                                                                        <i class="pe-7s-cloud-upload text-white"></i>
                                                                    </div>
                                                                </span>
                                                                <div class="vertical-timeline-element-content bounce-in">
                                                                    <p>Another meeting today, at
                                                                        <b class="text-warning">12:00 PM</b>
                                                                    </p>
                                                                    <p>Yet another one, at
                                                                        <span class="text-dark">15:00 PM</span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>        
                                                </div>
                                            </div>

                                    {{-- <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="38" class="rounded-circle" src="/images/avatars/1.jpg" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Beck Collier</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="vertical-time-icons vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                                                <div class="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                        <div class="vertical-timeline-element-icon bounce-in">
                                                            <div class="timeline-icon border-primary">
                                                                <i class="lnr-license icon-gradient bg-night-fade"></i>
                                                            </div>
                                                        </div>
                                                        <div class="vertical-timeline-element-content bounce-in">
                                                            <h4 class="timeline-title">All Hands Meeting</h4>
                                                            <p>
                                                                Lorem ipsum dolor sic amet, today at
                                                                <a href="javascript:void(0);">12:00 PM</a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                        <div class="vertical-timeline-element-icon bounce-in">
                                                            <div class="timeline-icon border-warning">
                                                                <i class="lnr-cog fa-spin icon-gradient bg-happy-itmeo"></i>
                                                            </div>
                                                        </div>
                                                        <div class="vertical-timeline-element-content bounce-in">
                                                            <p>Another meeting today, at
                                                                <b class="text-danger">12:00 PM</b>
                                                            </p>
                                                            <p>Yet another one, at
                                                                <span class="text-success">15:00 PM</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                        <div class="vertical-timeline-element-icon bounce-in">
                                                            <div class="timeline-icon border-warning bg-warning">
                                                                <i class="fa fa-archive fa-w-16 text-white"></i>
                                                            </div>
                                                        </div>
                                                        <div class="vertical-timeline-element-content bounce-in">
                                                            <h4 class="timeline-title">Build the production release</h4>
                                                            <p>
                                                                Lorem ipsum dolor sit amit,consectetur eiusmdd tempor incididunt ut
                                                                labore et dolore magna elit enim at minim veniam quis nostrud
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                        <span class="vertical-timeline-element-icon bounce-in">
                                                            <div class="timeline-icon bg-danger border-danger">
                                                                <i class="pe-7s-cloud-upload text-white"></i>
                                                            </div>
                                                        </span>
                                                        <div class="vertical-timeline-element-content bounce-in">
                                                            <p>Another meeting today, at
                                                                <b class="text-warning">12:00 PM</b>
                                                            </p>
                                                            <p>Yet another one, at
                                                                <span class="text-dark">15:00 PM</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="38" class="rounded-circle" src="/images/avatars/1.jpg" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Beck Collier</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul> --}}
                                </div>
                            </div>
                        </div>
                        <div class="d-block text-center card-footer">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-6 col-xl-5">
                    <div class="card-hover-shadow-2x mb-3 card">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                Agent Completion
                            </div>
                            <div class="btn-actions-pane-right text-capitalize actions-icon-btn">
                                <div class="btn-group dropdown">
                                    <button type="button" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" class="btn-icon btn-icon-only btn btn-link">
                                        <i class="pe-7s-menu btn-icon-wrapper"></i>
                                    </button>
                                    <div tabindex="-1" role="menu" aria-hidden="true"
                                        class="dropdown-menu-right rm-pointers dropdown-menu-shadow dropdown-menu-hover-link dropdown-menu">
                                        <h6 tabindex="-1" class="dropdown-header">Header</h6>
                                        <button type="button" tabindex="0" class="dropdown-item">
                                            <i class="dropdown-icon lnr-inbox"></i>
                                            <span>Menus</span>
                                        </button>
                                        <button type="button" tabindex="0" class="dropdown-item">
                                            <i class="dropdown-icon lnr-file-empty"></i>
                                            <span>Settings</span>
                                        </button>
                                        <button type="button" tabindex="0" class="dropdown-item">
                                            <i class="dropdown-icon lnr-book"></i>
                                            <span>Actions</span>
                                        </button>
                                        <div tabindex="-1" class="dropdown-divider"></div>
                                        <div class="p-3 text-right">
                                            <button class="mr-2 btn-shadow btn-sm btn btn-link">View Details</button>
                                            <button class="mr-2 btn-shadow btn-sm btn btn-primary">Action</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="scrollbar-container">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-3">
                                                    <img width="38" class="rounded-circle" src="/images/avatars/1.jpg" alt="">
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Beck Collier</div>
                                                    <div class="widget-subheading mt-1 opacity-10">
                                                        <div class="badge badge-pill badge-primary">Quezon City</div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="icon-wrapper m-0">
                                                        <div class="progress-circle-wrapper">
                                                            <div class="circle-progress d-inline-block circle-progress-alternate">
                                                                <small></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-3">
                                                    <img width="38" class="rounded-circle" src="/images/avatars/2.jpg" alt="">
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Angelo Hume</div>
                                                    <div class="widget-subheading mt-1 opacity-10">
                                                        <div class="badge badge-pill badge-primary">Quezon City</div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="icon-wrapper m-0">
                                                        <div class="progress-circle-wrapper">
                                                            <div class="circle-progress d-inline-block circle-progress-info">
                                                                <small></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-3">
                                                    <img width="38" class="rounded-circle" src="/images/avatars/2.jpg" alt="">
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Saim Melendez</div>
                                                    <div class="widget-subheading mt-1 opacity-10">
                                                        <div class="badge badge-pill badge-primary">Quezon City</div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="icon-wrapper m-0">
                                                        <div class="progress-circle-wrapper">
                                                            <div class="circle-progress d-inline-block circle-progress-danger">
                                                                <small></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-3">
                                                    <img width="38" class="rounded-circle" src="/images/avatars/3.jpg" alt="">
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Primrose Navarro</div>
                                                    <div class="widget-subheading mt-1 opacity-10">
                                                        <div class="badge badge-pill badge-primary">North Caloocan</div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="icon-wrapper m-0">
                                                        <div class="progress-circle-wrapper">
                                                            <div class="circle-progress d-inline-block circle-progress-success">
                                                                <small></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-3">
                                                    <img width="38" class="rounded-circle" src="/images/avatars/4.jpg" alt="">
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Finnlay Barton</div>
                                                    <div class="widget-subheading mt-1 opacity-10">
                                                        <div class="badge badge-pill badge-primary">North Caloocan</div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="icon-wrapper m-0">
                                                        <div class="progress-circle-wrapper">
                                                            <div class="circle-progress d-inline-block circle-progress-primary">
                                                                <small></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-3">
                                                    <img width="38" class="rounded-circle" src="/images/avatars/10.jpg" alt="">
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Johan Corbett</div>
                                                    <div class="widget-subheading mt-1 opacity-10">
                                                        <div class="badge badge-pill badge-primary">South Caloocan</div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="icon-wrapper m-0">
                                                        <div class="progress-circle-wrapper">
                                                            <div class="circle-progress d-inline-block circle-progress-dark">
                                                                <small></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="border-bottom-0 list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-3">
                                                    <img width="38" class="rounded-circle" src="/images/avatars/9.jpg" alt="">
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Kaja Wolfe</div>
                                                    <div class="widget-subheading mt-1 opacity-10">
                                                        <div class="badge badge-pill badge-primary">South Caloocan</div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="icon-wrapper m-0">
                                                        <div class="progress-circle-wrapper">
                                                            <div class="circle-progress d-inline-block circle-progress-success">
                                                                <small></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>

                            </div>
                        </div>
                        <div class="d-block text-center card-footer">
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="tab-pane tabs-animation fade" id="tab-content-1" role="tabpanel">
        </div>
        <div class="tab-pane tabs-animation fade" id="tab-content-2" role="tabpanel">
        </div>
    </div>

@endsection