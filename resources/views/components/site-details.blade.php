<iframe width="100%" height="300" style="border:0" loading="lazy" allowfullscreen
src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCqSt-k7Mbt8IPdnBZ_fkMVeNu3CcBsCnM&q={{ str_replace("#","", $site[0]->site_address) }}">
</iframe>
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
                <x-site-fields :sitefields="$sitefields" />
            </div>
        </div>
    </div>
</div>                                        
