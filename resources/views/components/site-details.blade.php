@php
    
    $np = \DB::table('site')->where('sam_id', $site[0]->sam_id)->select('NP_latitude', 'NP_longitude')->get();

    if($np[0]->NP_latitude != '' || $np[0]->NP_longitude != ''){
        $query = $np[0]->NP_latitude . ',' . $np[0]->NP_longitude;
    } else {
        $query = str_replace("#","", $site[0]->site_address);
    }

@endphp
<iframe width="100%" height="300" style="border:0" loading="lazy" allowfullscreen
src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCqSt-k7Mbt8IPdnBZ_fkMVeNu3CcBsCnM&q={{ $query }}">
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
                            <input name="details_sam_id" id="details_sam_id" type="text" value="{{ $site[0]->sam_id }}" readonly class="form-control">
                        </div>
                    </div>
                    <div class="form-row mb-2 pb-2 border-bottom">
                        <div class="col-5">
                            <label for="details_site_name" class="mr-sm-2">Site Name</label>
                        </div>
                        <div class="col-7">
                            <input name="details_site_name" id="details_site_name" type="text" value="{{ $site[0]->site_name }}" readonly class="form-control">
                        </div>
                    </div>
                    <div class="form-row mb-2 pb-2 border-bottom">
                        <div class="col-5">
                            <label for="details_address" class="mr-sm-2">Address</label>
                        </div>
                        <div class="col-7">
                            <textarea name="details_address" id="details_address" type="text" readonly class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-row mb-2 pb-2 border-bottom">
                        <div class="col-5">
                            <label for="details_site_pr" class="mr-sm-2">PR</label>
                        </div>
                        <div class="col-7">
                            <input name="details_site_pr" id="details_site_pr" type="text" value="{{ isset($site[0]->site_pr) ? $site[0]->site_pr : "" }}" readonly class="form-control">
                        </div>
                    </div>
                    <div class="form-row mb-2 pb-2 border-bottom">
                        <div class="col-5">
                            <label for="details_site_po" class="mr-sm-2">PO</label>
                        </div>
                        <div class="col-7">
                            <input name="details_site_po" id="details_site_po" type="text" value="{{ isset($site[0]->site_po) ? $site[0]->site_po : "" }}" readonly class="form-control">
                        </div>
                    </div>
                    <div class="form-row mb-2 pb-2 border-bottom">
                        <div class="col-5">
                            <label for="details_site_program" class="mr-sm-2">Program</label>
                        </div>
                        <div class="col-7">
                            <input name="details_site_program" id="details_site_program" type="text" value="" readonly class="form-control">
                        </div>
                    </div>
                    <div class="form-row mb-2 pb-2 border-bottom">
                        <div class="col-5">
                            <label for="details_site_program" class="mr-sm-2">Tech</label>
                        </div>
                        <div class="col-7">
                            <input name="details_site_program" id="details_site_program" type="text" value="" readonly class="form-control">
                        </div>
                    </div>
                </form>                                                        
            </div>
        </div>
    </div>
    <div class="card">
        <div id="headingThree" class="card-header">
            <button type="button" data-toggle="collapse" data-target="#collapseSiteFields" aria-expanded="false" aria-controls="collapseThree" class="text-left m-0 p-0 btn btn-link btn-block">
                <h5 class="m-0 p-0 program_fields">
                    <i class="pe-7s-global"></i>
                        Program Fields
                </h5>
            </button>
        </div>
        <div data-parent="#accordion" id="collapseSiteFields" class="collapse" style="">
            <div class="card-body" id="site-modal-site_fields">
                <div class="loader-wrapper w-100 d-flex justify-content-center align-items-center">
                    <div class="loader">
                        <div class="ball-scale-multiple">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>        
            </div>
        </div>
    </div>
</div>                                        
