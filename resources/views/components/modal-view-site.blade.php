<style>
.modal-dialog{
    -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
    -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
    -o-box-shadow: 0 5px 15px rgba(0,0,0,0);
    box-shadow: 0 5px 15px rgba(0,0,0,0);
}   

.dropzone {
    min-height: 20px !important;
    border: 2px dashed #3f6ad8 !important;
    border-radius: 10px;
    padding: unset !important;
}
</style>


<div class="modal fade" id="viewInfoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true"  data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" style="background-color: transparent; border: 0">
                <div class="row">

                    <div class="col-lg-8 col-md-12 col-sm-12">
                        <div class="main-card mb-3 card">
                            <div class="dropdown-menu-header">
                                <div class="dropdown-menu-header-inner bg-dark">
                                    <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                                    <div class="menu-header-content btn-pane-right">
                                        <div>
                                            <h5 class="menu-header-title">
                                                {{ $site[0]->site_name }}
                                                @if($site[0]->site_category != null)
                                                    <span class="mr-3 badge badge-secondary"><small>{{ $site[0]->site_category }}</small></span>
                                                @endif
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>                    
                            <div class="card-body mt-1">
                                <div class="row">
                                    <div class="col-12">
                                        <ul class="tabs-animated body-tabs-animated nav">
                                            <li class="nav-item">
                                                <a role="tab" class="nav-link active" id="tab-site_fields" data-toggle="tab" href="#tab-content-site_fields">
                                                    <span>Details</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a role="tab" class="nav-link" id="tab-site_activities" data-toggle="tab" href="#tab-content-site_activities">
                                                    <span>Activities</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a role="tab" class="nav-link" id="tab-forecast" data-toggle="tab" href="#tab-content-forecast">
                                                    <span>Forecast</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a role="tab" class="nav-link" id="tab-files" data-toggle="tab" href="#tab-content-files">
                                                    <span>Files</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a role="tab" class="nav-link" id="tab-issues" data-toggle="tab" href="#tab-content-issues">
                                                    <span>Issues</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a role="tab" class="nav-link" id="tab-site_chat" data-toggle="tab" href="#tab-content-site_chat">
                                                    <span>Site Chat</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="divider"></div>
                                <div class="tab-content">
                                    <div class="tab-pane tabs-animation fade " id="tab-content-site_activities" role="tabpanel">
                                        {{-- <x-view-site-activities :activities="$activities" :samid="$sam_id"/> --}}
                                    </div>
                                    <div class="tab-pane tabs-animation fade " id="tab-content-forecast" role="tabpanel">
                                        {{-- <div class="row">
                                            <div class="col-md-12">
                                                <div id="chart_div"></div>
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="tab-pane tabs-animation fade show active" id="tab-content-site_fields" role="tabpanel">
                                        <div class="mapouter"><div class="gmap_canvas"><iframe width="100%" height="250" id="gmap_canvas" src="https://maps.google.com/maps?q=quezon%20city&t=&z=17&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><style>.mapouter{position:relative;text-align:right;height:250px;width:100%;}</style><style>.gmap_canvas {overflow:hidden;background:none!important;height:250px;width:100%;}</style></div>
                                        </div>

                                        <div id="accordion" class="accordion-wrapper mt-3">
                                            <div class="card">
                                                <div id="headingTwo" class="b-radius-0 card-header">
                                                    <button type="button" data-toggle="collapse" data-target="#collapseDetails" aria-expanded="true" aria-controls="collapseTwo" class="text-left m-0 p-0 btn btn-link btn-block collapsed">
                                                        <h5 class="m-0 p-0">
                                                            <H5 class="mt-4">Site Details</H5>
                                                        </h5>
                                                    </button>
                                                </div>
                                                <div data-parent="#accordion" id="collapseDetails" class="collapse show" style="">
                                                    <div class="card-body">
                                                        <form>
                                                            <div class="form-row mb-2 pb-2 border-bottom">
                                                                <div class="col-5">
                                                                    <label for="test" class="mr-sm-2">SAM ID</label>
                                                                </div>
                                                                <div class="col-7">
                                                                    <input name="test" id="test" type="text" value="{{ $site[0]->sam_id }}" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="form-row mb-2 pb-2 border-bottom">
                                                                <div class="col-5">
                                                                    <label for="test" class="mr-sm-2">Site Name</label>
                                                                </div>
                                                                <div class="col-7">
                                                                    <input name="test" id="test" type="text" value="{{ $site[0]->site_name }}" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="form-row mb-2 pb-2 border-bottom">
                                                                <div class="col-5">
                                                                    <label for="test" class="mr-sm-2">Address</label>
                                                                </div>
                                                                <div class="col-7">
                                                                    <textarea name="test" id="test" type="text" class="form-control">{{ $site[0]->site_address }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-row mb-2 pb-2 border-bottom">
                                                                <div class="col-5">
                                                                    <label for="test" class="mr-sm-2">Latitude</label>
                                                                </div>
                                                                <div class="col-7">
                                                                    <input name="test" id="test" type="text" value="{{ $site[0]->site_latitude }}" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="form-row mb-2 pb-2 border-bottom">
                                                                <div class="col-5">
                                                                    <label for="test" class="mr-sm-2">Longitude</label>
                                                                </div>
                                                                <div class="col-7">
                                                                    <input name="test" id="test" type="text" value="{{ $site[0]->site_longitude }}" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="form-row mb-2 pb-2 border-bottom">
                                                                <div class="col-5">
                                                                    <label for="test" class="mr-sm-2">Endorsement Date</label>
                                                                </div>
                                                                <div class="col-7">
                                                                    <input name="test" id="test" type="text" value="{{ $site[0]->site_endorsement_date }}" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="form-row mb-2">
                                                                <div class="col-5">
                                                                    <label for="test" class="mr-sm-2">Endorsement Acceptance Date</label>
                                                                </div>
                                                                <div class="col-7">
                                                                    <input name="test" id="test" type="text" value="{{ $site[0]->site_endorsement_date }}" class="form-control">
                                                                </div>
                                                            </div>

                                                        </form>                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div id="headingThree" class="card-header">
                                                    <button type="button" data-toggle="collapse" data-target="#collapseSiteFields" aria-expanded="false" aria-controls="collapseThree" class="text-left m-0 p-0 btn btn-link btn-block">
                                                        <h5 class="m-0 p-0">
                                                            <H5 class="mt-4">Program Fields</H5>
                                                        </h5>
                                                    </button>
                                                </div>
                                                <div data-parent="#accordion" id="collapseSiteFields" class="collapse" style="">
                                                    <div class="card-body">
                                                        <x-site-fields :sitefields="$site_fields" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div class="tab-pane tabs-animation fade" id="tab-content-issues" role="tabpanel">
                                        
                                        <x-site-issues :site="$site" />
                                    </div>
                                    <div class="tab-pane tabs-animation fade" id="tab-content-files" role="tabpanel">
                                        <x-site-files :site="$site" />
                                    </div>
                                    <div class="tab-pane tabs-animation fade" id="tab-content-site_chat" role="tabpanel">
                                        <x-site-chat  :site="$site" />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                
                    <div class="col-lg-4 col-md-12 col-sm-12">

                        <div class="mb-3 profile-responsive card">
                            <div class="dropdown-menu-header">
                                <div class="dropdown-menu-header-inner bg-dark">
                                    <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                                    <div class="menu-header-content btn-pane-right">
                                        <div>
                                            <h5 class="menu-header-title">Site Status</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-0 card-body" style="position: relative;">
                                dsadas
                            </div>
                               
                        </div>                        
                    </div>                
                </div>
        </div>
    </div>
</div>