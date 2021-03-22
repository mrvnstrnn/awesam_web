@extends('layouts.main')

@section('content')
<ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
    <li class="nav-item">
        <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab" href="#tab-content-0">
            <span>Tasks</span>
        </a>
    </li>
    <li class="nav-item">
        <a role="tab" class="nav-link" id="tab-1" data-toggle="tab" href="#tab-content-1">
            <span>Documents</span>
        </a>
    </li>
</ul>
<div class="tab-content">

    <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
        <div class="row">
            <div class="col-md-4">
                <div class="card-shadow-primary card-border mb-3 card">
                    <div class="dropdown-menu-header">
                        <div class="dropdown-menu-header-inner bg-primary">
                            <div class="menu-header-image" style="background-image: url('images/dropdown-header/city2.jpg');"></div>
                            <div class="menu-header-content">
                                <div class="avatar-icon-wrapper avatar-icon-lg">
                                    <div class="avatar-icon rounded btn-hover-shine">
                                        <img src="/images/avatars/4.jpg" alt="Avatar 5">
                                    </div>
                                </div>
                                <div>
                                    <h5 class="menu-header-title">Jessica Walberg</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="scroll-area-sm">
                        <div class="scrollbar-container ps ps--active-y">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left center-elem mr-2">
                                                <i class="pe-7s-file text-muted fsize-2"></i>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Example file 1</div>
                                            </div>
                                            <div class="widget-content-right widget-content-actions">
                                                <button class="mr-1 btn-icon btn-icon-only btn btn-primary btn-sm">
                                                    <i class="pe-7s-tools btn-icon-wrapper"></i>
                                                </button>
                                                <button class="mr-1 btn-icon btn-icon-only btn btn-secondary btn-sm">
                                                    <i class="pe-7s-gym btn-icon-wrapper"></i>
                                                </button>
                                                <button class="btn-icon btn-icon-only btn btn-success btn-sm">
                                                    <i class="pe-7s-umbrella btn-icon-wrapper"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left center-elem mr-2">
                                                <i class="pe-7s-file text-muted fsize-2"></i>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Example file 2</div>
                                            </div>
                                            <div class="widget-content-right widget-content-actions">
                                                <button class="mr-1 btn-icon btn-icon-only btn btn-primary btn-sm">
                                                    <i class="pe-7s-tools btn-icon-wrapper"></i>
                                                </button>
                                                <button class="btn-icon btn-icon-only btn btn-success btn-sm">
                                                    <i class="pe-7s-umbrella btn-icon-wrapper"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left center-elem mr-2">
                                                <i class="pe-7s-file text-muted fsize-2"></i>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Example file 2</div>
                                            </div>
                                            <div class="widget-content-right widget-content-actions">
                                                <button class="mr-1 btn-icon btn-icon-only btn btn-primary btn-sm">
                                                    <i class="pe-7s-tools btn-icon-wrapper"></i>
                                                </button>
                                                <button class="btn-icon btn-icon-only btn btn-success btn-sm">
                                                    <i class="pe-7s-umbrella btn-icon-wrapper"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left center-elem mr-2">
                                                <i class="pe-7s-file text-muted fsize-2"></i>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Example file 2</div>
                                            </div>
                                            <div class="widget-content-right widget-content-actions">
                                                <button class="mr-1 btn-icon btn-icon-only btn btn-primary btn-sm">
                                                    <i class="pe-7s-tools btn-icon-wrapper"></i>
                                                </button>
                                                <button class="btn-icon btn-icon-only btn btn-success btn-sm">
                                                    <i class="pe-7s-umbrella btn-icon-wrapper"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left center-elem mr-2">
                                                <i class="pe-7s-file text-muted fsize-2"></i>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Example file 2</div>
                                            </div>
                                            <div class="widget-content-right widget-content-actions">
                                                <button class="mr-1 btn-icon btn-icon-only btn btn-primary btn-sm">
                                                    <i class="pe-7s-tools btn-icon-wrapper"></i>
                                                </button>
                                                <button class="btn-icon btn-icon-only btn btn-success btn-sm">
                                                    <i class="pe-7s-umbrella btn-icon-wrapper"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left center-elem mr-2">
                                                <i class="pe-7s-file text-muted fsize-2"></i>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Example file 2</div>
                                            </div>
                                            <div class="widget-content-right widget-content-actions">
                                                <button class="mr-1 btn-icon btn-icon-only btn btn-primary btn-sm">
                                                    <i class="pe-7s-tools btn-icon-wrapper"></i>
                                                </button>
                                                <button class="btn-icon btn-icon-only btn btn-success btn-sm">
                                                    <i class="pe-7s-umbrella btn-icon-wrapper"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 200px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 121px;"></div></div></div>
                    </div>
                    <div class="text-center d-block card-footer">
                        <button class="mr-2 border-0 btn-transition btn btn-outline-danger">Remove from list</button>
                        <button class="border-0 btn-transition btn btn-outline-success">Send Message</button>
                    </div>
                </div>                
            </div>
            <div class="col-md-8">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Basic</h5>
                        <div class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                            <div class="vertical-timeline-item vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in">
                                        <i class="badge badge-dot badge-dot-xl badge-success"></i>
                                    </span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <h4 class="timeline-title">All Hands Meeting</h4>
                                        <p>
                                            Lorem ipsum dolor sic amet, today at
                                            <a href="javascript:void(0);">12:00 PM</a>
                                        </p>
                                        <span class="vertical-timeline-element-date">10:30 PM</span>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-timeline-item vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in">
                                        <i class="badge badge-dot badge-dot-xl badge-warning"></i>
                                    </span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <p>Another meeting today, at
                                            <b class="text-danger">12:00 PM</b>
                                        </p>
                                        <p>Yet another one, at
                                            <span class="text-success">15:00 PM</span>
                                        </p>
                                        <span class="vertical-timeline-element-date">12:25 PM</span>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-timeline-item vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in">
                                        <i class="badge badge-dot badge-dot-xl badge-danger"></i>
                                    </span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <h4 class="timeline-title">Build the production release</h4>
                                        <p>
                                            Lorem ipsum dolor sit amit,consectetur eiusmdd tempor incididunt ut
                                            labore et dolore magna elit enim at minim veniam quis nostrud
                                        </p>
                                        <span class="vertical-timeline-element-date">15:00 PM</span>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-timeline-item vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in">
                                        <i class="badge badge-dot badge-dot-xl badge-primary"></i>
                                    </span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <h4 class="timeline-title text-success">Something not important</h4>
                                        <p>
                                            Lorem ipsum dolor sit amit,consectetur elit enim at minim veniam quis
                                            nostrud
                                        </p>
                                        <span class="vertical-timeline-element-date">15:00 PM</span>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-timeline-item vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in">
                                        <i class="badge badge-dot badge-dot-xl badge-success"></i>
                                    </span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <h4 class="timeline-title">All Hands Meeting</h4>
                                        <p>
                                            Lorem ipsum dolor sic amet, today at
                                            <a href="javascript:void(0);">12:00 PM</a>
                                        </p>
                                        <span class="vertical-timeline-element-date">10:30 PM</span>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-timeline-item vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in">
                                        <i class="badge badge-dot badge-dot-xl badge-warning"></i>
                                    </span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <p>Another meeting today, at
                                            <b class="text-danger">12:00 PM</b>
                                        </p>
                                        <p>Yet another one, at
                                            <span class="text-success">15:00 PM</span>
                                        </p>
                                        <span class="vertical-timeline-element-date">12:25 PM</span>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-timeline-item vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in">
                                        <i class="badge badge-dot badge-dot-xl badge-danger"></i>
                                    </span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <h4 class="timeline-title">Build the production release</h4>
                                        <p>
                                            Lorem ipsum dolor sit amit,consectetur eiusmdd tempor incididunt ut
                                            labore et dolore magna elit enim at minim veniam quis nostrud
                                        </p>
                                        <span class="vertical-timeline-element-date">15:00 PM</span>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-timeline-item vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in">
                                        <i class="badge badge-dot badge-dot-xl badge-primary"></i>
                                    </span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <h4 class="timeline-title text-success">Something not important</h4>
                                        <p>
                                            Lorem ipsum dolor sit amit,consectetur elit enim at minim veniam quis
                                            nostrud
                                        </p>
                                        <span class="vertical-timeline-element-date">15:00 PM</span>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-timeline-item vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in">
                                        <i class="badge badge-dot badge-dot-xl badge-success"></i>
                                    </span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <h4 class="timeline-title">All Hands Meeting</h4>
                                        <p>
                                            Lorem ipsum dolor sic amet, today at
                                            <a href="javascript:void(0);">12:00 PM</a>
                                        </p>
                                        <span class="vertical-timeline-element-date">10:30 PM</span>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-timeline-item vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in">
                                        <i class="badge badge-dot badge-dot-xl badge-warning"></i>
                                    </span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <p>Another meeting today, at
                                            <b class="text-danger">12:00 PM</b>
                                        </p>
                                        <p>Yet another one, at
                                            <span class="text-success">15:00 PM</span>
                                        </p>
                                        <span class="vertical-timeline-element-date">12:25 PM</span>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-timeline-item vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in">
                                        <i class="badge badge-dot badge-dot-xl badge-danger"></i>
                                    </span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <h4 class="timeline-title">Build the production release</h4>
                                        <p>
                                            Lorem ipsum dolor sit amit,consectetur eiusmdd tempor incididunt ut
                                            labore et dolore magna elit enim at minim veniam quis nostrud
                                        </p>
                                        <span class="vertical-timeline-element-date">15:00 PM</span>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-timeline-item vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in">
                                        <i class="badge badge-dot badge-dot-xl badge-primary"></i>
                                    </span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <h4 class="timeline-title text-success">Something not important</h4>
                                        <p>Lorem ipsum dolor sit amit,consectetur elit enim at minim veniam quis nostrud</p>
                                        <span class="vertical-timeline-element-date">15:00 PM</span>
                                    </div>
                                </div>
                            </div>
                        </div>
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