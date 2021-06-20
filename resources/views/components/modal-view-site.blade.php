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
                                        <iframe width="100%" height="300" style="border:0" loading="lazy" allowfullscreen
                                        src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCqSt-k7Mbt8IPdnBZ_fkMVeNu3CcBsCnM&q={{ $site[0]->site_address }}">
                                      </iframe>

                                        <span class="badge badge-dark text-lg mt-3 p-2" style="font-size: 12px;">{{ $site[0]->stage_name }}</span>
                                        <span class="badge badge-danger text-lg mt-3 p-2" style="font-size: 12px;">{{ $site[0]->activity_name }}</span>
                                        <div id="accordion" class="accordion-wrapper mt-3">
                                            <div class="card">
                                                <div id="headingTwo" class="b-radius-0 card-header">
                                                    <button type="button" data-toggle="collapse" data-target="#collapseDetails" aria-expanded="true" aria-controls="collapseTwo" class="text-left m-0 p-0 btn btn-link btn-block collapsed">
                                                        <h5 class="m-0 p-0">
                                                            <i class="pe-7s-map"></i>
                                                            Site Details
                                                        </h5>
                                                    </button>
                                                </div>
                                                <div data-parent="#accordion" id="collapseDetails" class="collapse show" style="">
                                                    <div class="card-body">
                                                        <form>
                                                            <div class="form-row mb-2 pb-2 border-bottom">
                                                                <div class="col-5">
                                                                    <label for="details_sam_id" class="mr-sm-2">SAM ID</label>
                                                                </div>
                                                                <div class="col-7">
                                                                    <input name="details_sam_id" id="details_sam_id" type="text" value="{{ $site[0]->sam_id }}" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="form-row mb-2 pb-2 border-bottom">
                                                                <div class="col-5">
                                                                    <label for="details_site_name" class="mr-sm-2">Site Name</label>
                                                                </div>
                                                                <div class="col-7">
                                                                    <input name="details_site_name" id="details_site_name" type="text" value="{{ $site[0]->site_name }}" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="form-row mb-2 pb-2 border-bottom">
                                                                <div class="col-5">
                                                                    <label for="details_address" class="mr-sm-2">Address</label>
                                                                </div>
                                                                <div class="col-7">
                                                                    <textarea name="details_address" id="details_address" type="text" class="form-control">{{ $site[0]->site_address }}</textarea>
                                                                </div>
                                                            </div>
                                                            {{-- <div class="form-row mb-2 pb-2 border-bottom">
                                                                <div class="col-5">
                                                                    <label for="details_latitude" class="mr-sm-2">Latitude</label>
                                                                </div>
                                                                <div class="col-7">
                                                                    <input name="details_latitude" id="details_latitude" type="text" value="{{ $site[0]->site_latitude }}" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="form-row mb-2 pb-2 border-bottom">
                                                                <div class="col-5">
                                                                    <label for="details_longitude" class="mr-sm-2">Longitude</label>
                                                                </div>
                                                                <div class="col-7">
                                                                    <input name="details_longitude" id="details_longitude" type="text" value="{{ $site[0]->site_longitude }}" class="form-control">
                                                                </div>
                                                            </div> --}}
                                                            <div class="form-row mb-2 pb-2 border-bottom">
                                                                <div class="col-5">
                                                                    <label for="details_endorsement_date" class="mr-sm-2">Endorsement Date</label>
                                                                </div>
                                                                <div class="col-7">
                                                                    <input name="details_endorsement_date" id="details_endorsement_date" type="text" value="{{ $site[0]->site_endorsement_date }}" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="form-row mb-2">
                                                                <div class="col-5">
                                                                    <label for="details_endorsement_acceptance_date" class="mr-sm-2">Endorsement Acceptance Date</label>
                                                                </div>
                                                                <div class="col-7">
                                                                    <input name="details_endorsement_acceptance_date" id="details_endorsement_acceptance_date" type="text" value="{{ $site[0]->site_endorsement_accepted_date }}" class="form-control">
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
                                                            <i class="pe-7s-global"></i>
                                                             Program Fields
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