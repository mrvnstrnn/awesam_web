<ul class="tabs-animated body-tabs-animated nav">
    <li class="nav-item">
        <a role="tab" class="nav-link active" id="tab-dar" data-toggle="tab" href="#tab-content-dar">
            <span>Daily Activity Report</span>
        </a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane tabs-animation fade active show" id="tab-content-dar" role="tabpanel">
        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="dropdown-menu-header">
                        <div class="dropdown-menu-header-inner bg-dark">
                            <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                            <div class="menu-header-content btn-pane-right">
                                <h5 class="menu-header-title">
                                    <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
                                    Daily Activity Report
                                </h5>
                            </div>
                        </div>
                    </div> 
]                    <div class="card-body" style="overflow-x: scroll">

                        <div class="table-responsive">
                            <x-dar-table />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
