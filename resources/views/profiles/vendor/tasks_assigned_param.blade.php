@extends('layouts.main')

@section('content')
<ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
    <li class="nav-item">
        <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab" href="#tab-content-0">
            <span>Activities</span>
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
            <div class="col-md-6">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Site Timeline</h5>
                        <div class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                            <div class="vertical-timeline-item vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in">
                                        <i class="badge badge-dot badge-dot-xl badge-success"></i>
                                    </span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <h4 class="timeline-title text-success">PMO ENDORSEMENT</h4>
                                        <p>
                                            Lorem ipsum dolor sic amet, today at
                                            <a href="javascript:void(0);">12:00 PM</a>
                                        </p>
                                        <span class="vertical-timeline-element-date">Mar 1</span>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-timeline-item vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in">
                                        <i class="badge badge-dot badge-dot-xl badge-success"></i>
                                    </span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <h4 class="timeline-title text-warning">PRE-NEGOTIATION</h4>
                                        <p>
                                            Lorem ipsum dolor sic amet, today at
                                            <a href="javascript:void(0);">12:00 PM</a>
                                        </p>
                                        <span class="vertical-timeline-element-date">Apr 10</span>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-timeline-item vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in">
                                        <i class="badge badge-dot badge-dot-xl badge-success"></i>
                                    </span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <h4 class="timeline-title">LESSOR NEGOTIATION</h4>
                                        <p>
                                            Lorem ipsum dolor sic amet, today at
                                            <a href="javascript:void(0);">12:00 PM</a>
                                        </p>
                                        <span class="vertical-timeline-element-date">May 10</span>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-timeline-item vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in">
                                        <i class="badge badge-dot badge-dot-xl badge-success"></i>
                                    </span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <h4 class="timeline-title">RTB</h4>
                                        <p>
                                            Lorem ipsum dolor sic amet, today at
                                            <a href="javascript:void(0);">12:00 PM</a>
                                        </p>
                                        <span class="vertical-timeline-element-date">Jun 10</span>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-timeline-item vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in">
                                        <i class="badge badge-dot badge-dot-xl badge-success"></i>
                                    </span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <h4 class="timeline-title">PAC</h4>
                                        <p>
                                            Lorem ipsum dolor sic amet, today at
                                            <a href="javascript:void(0);">12:00 PM</a>
                                        </p>
                                        <span class="vertical-timeline-element-date">Jul 10</span>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-timeline-item vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in">
                                        <i class="badge badge-dot badge-dot-xl badge-success"></i>
                                    </span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <h4 class="timeline-title">FAC</h4>
                                        <p>
                                            Lorem ipsum dolor sic amet, today at
                                            <a href="javascript:void(0);">12:00 PM</a>
                                        </p>
                                        <span class="vertical-timeline-element-date">Aug 10</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
            </div>
            <div class="col-md-6">
                <div class="card-shadow-primary profile-responsive card-border mb-3 card">
                    <div class="dropdown-menu-header">
                        <div class="dropdown-menu-header-inner bg-danger">
                            <div class="menu-header-image" style="background-image: url('/images/dropdown-header/abstract1.jpg')"></div>
                            <div class="menu-header-content btn-pane-right">
                                <div class="avatar-icon-wrapper mr-2 avatar-icon-xl">
                                    <div class="avatar-icon">
                                        <img src="/images/avatars/3.jpg" alt="Avatar 5">
                                    </div>
                                </div>
                                <div>
                                    <h5 class="menu-header-title">Mathew Mercer</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                        </li>
                        <li class="list-group-item">
                        </li>
                        <li class="list-group-item">
                        </li>
                        <li class="list-group-item">
                        </li>
                    </ul>
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