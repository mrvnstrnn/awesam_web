<form class="ssds_form pt-3">
    <H3>SSDS Details</H3>
    <hr>
    <input type="hidden" name="sam_id" id="sam_id" value="{{ isset($sam_id) ? $sam_id : $site[0]->sam_id }}">
    <input type="hidden" name="sub_activity_id" id="sub_activity_id" value="{{ isset($sub_activity_id) ? $sub_activity_id : '' }}">
    <input type="hidden" name="program_id" id="program_id" value="{{ isset($program_id) ? $program_id : $site[0]->program_id }}">
    <input type="hidden" name="site_category" id="site_category" value="{{ isset($site_category) ? $site_category : $site[0]->site_category }}">
    <input type="hidden" name="activity_id" id="activity_id" value="{{ isset($activity_id) ? $activity_id : $site[0]->activity_id }}">
    <input type="hidden" name="id" id="id">
    <div class="position-relative row form-group">
        <label for="lessor" class="col-sm-4 col-form-label">Name of Owner</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="lessor" name="lessor" placeholder="Name of Owner" readonly>
            <small class="text-danger lessor-errors"></small>
        </div>
    </div>
    <div class="position-relative row form-group">
        <label for="contact_number" class="col-sm-4 col-form-label">Contact Number</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="contact_number" name="contact_number" placeholder="Contact Number" readonly>
            <small class="text-danger contact_number-errors"></small>
        </div>
    </div>
    <div class="position-relative row form-group">
        <label for="address" class="col-sm-4 col-form-label">Street Address</label>
        <div class="col-sm-8">
            <textarea name="address" id="address" class="form-control" placeholder="Address" readonly></textarea>
            <small class="text-danger address-errors"></small>
        </div>
    </div>
    <div class="position-relative row form-group">
        <label for="region" class="col-sm-4 col-form-label">Region</label>
        <div class="col-sm-8">
                <input type="text" class="form-control" id="region_new" name="region_new" readonly>
                <input type="hidden" class="form-control" id="region" name="region">
            <small class="text-danger region-errors"></small>
        </div>
    </div>
    <div class="position-relative row form-group">
        <label for="province" class="col-sm-4 col-form-label">Province</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="province_new" name="province_new" readonly>
            <input type="hidden" class="form-control" id="province" name="province">
            <small class="text-danger province-errors"></small>
        </div>
    </div>
    <div class="position-relative row form-group">
        <label for="lgu" class="col-sm-4 col-form-label">City / Municipality</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="lgu_new" name="lgu_new" readonly>
            <input type="hidden" class="form-control" id="lgu" name="lgu">
            <small class="text-danger lgu-errors"></small>

        </div>
    </div>

    <div class="position-relative row form-group">
        <label for="latitude" class="col-sm-4 col-form-label">Coordinates</label>
        <div class="col-sm-4">
            <input type="number" class="form-control" id="latitude" name="latitude" placeholder="Latitude" readonly>
            <small class="text-danger latitude-errors"></small>
        </div>
        <div class="col-sm-4">
            <input type="number" class="form-control" id="longitude" name="longitude" placeholder="Longitude" readonly>
            <small class="text-danger longitude-errors"></small>
        </div>
    </div>
    <div class="position-relative row form-group">
        <label for="distance_from_nominal_point" class="col-sm-4 col-form-label">Distance from Nominal Point</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="distance_from_nominal_point" name="distance_from_nominal_point" placeholder="Distance from Nominal Point" readonly>
            <small class="text-danger distance_from_nominal_point-errors"></small>
        </div>
    </div>
    <div class="position-relative row form-group">
        <label for="site_type" class="col-sm-4 col-form-label">Site Type</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="site_type" name="site_type" readonly>
            <small class="text-danger site_type-errors"></small>

        </div>
    </div>
    <div class="position-relative row form-group">
        <label for="building_no_of_floors" class="col-sm-4 col-form-label">Building (No. of floors)</label>
        <div class="col-sm-8">
            <input type="number" class="form-control" id="building_no_of_floors" name="building_no_of_floors" placeholder="Building (No. of floors)" readonly>
            <small class="text-danger building_no_of_floors-errors"></small>
        </div>
    </div>
    <div class="position-relative row form-group">
        <label for="area_size" class="col-sm-4 col-form-label">Area Size</label>
        <div class="col-sm-8">
            <input type="number" class="form-control" id="area_size" name="area_size" placeholder="Area Size" readonly>
            <small class="text-danger area_size-errors"></small>
        </div>
    </div>
    <div class="position-relative row form-group">
        <label for="property_use" class="col-sm-4 col-form-label">Property Use</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="property_use" name="property_use" readonly>
            <small class="text-danger property_use-errors"></small>
        </div>
    </div>
    <div class="position-relative row form-group">
        <label for="right_of_way_access" class="col-sm-4 col-form-label">Right of Way Access</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="right_of_way_access" name="right_of_way_access" readonly>
            <small class="text-danger right_of_way_access-errors"></small>
        </div>
    </div>

    <div id="accordion" class="accordion-wrapper mb-3">
        {{-- <div class="card">
            <div id="headingOne" class="card-header">
                <button type="button" data-toggle="collapse" data-target="#collapseOne1" aria-expanded="false" aria-controls="collapseOne" class="text-left m-0 p-0 btn btn-link btn-block collapsed">
                    <h5 class="m-0 p-0">Property Details</h5>
                </button>
            </div>
            <div data-parent="#accordion" id="collapseOne1" aria-labelledby="headingOne" class="collapse" style="">
                <div class="card-body">
        
                </div>
            </div>
        </div> --}}
        <div class="card">
            <div id="headingTwo" class="b-radius-0 card-header">
                <button type="button" data-toggle="collapse" data-target="#collapseOne2" aria-expanded="false" aria-controls="collapseTwo" class="text-left m-0 p-0 btn btn-link btn-block collapsed">
                    <h5 class="m-0 p-0">
                        Site Acquisition
                    </h5>
                </button>
            </div>
            <div data-parent="#accordion" id="collapseOne2" class="collapse" style="">
                <div class="card-body">
                    <div class="position-relative row form-group">
                        <label for="site_rank" class="col-sm-4 col-form-label">Rank</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="site_rank" name="site_rank" placeholder="Rank" readonly>
                            <small class="text-danger site_rank-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="type_of_property" class="col-sm-4 col-form-label">Type of Property</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="type_of_property" name="type_of_property" readonly>
                            <small class="text-danger type_of_property-errors"></small>
                        </div>
                    </div>
                    <h4>Lease Details</h4>
                    <div class="position-relative row form-group">
                        <label for="lease_term" class="col-sm-4 col-form-label">Lease Term</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="lease_term" name="lease_term" placeholder="Lease Term" readonly>
                            <small class="text-danger lease_term-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="lease_rate" class="col-sm-4 col-form-label">Lease Rate</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="lease_rate" name="lease_rate" placeholder="Lease Rate" readonly>
                            <small class="text-danger lease_rate-errors"></small>
                        </div>
                    </div>  
                    <div class="position-relative row form-group">
                        <label for="advance_rental" class="col-sm-4 col-form-label">Advance Rental</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="advance_rental" name="advance_rental" placeholder="Advance Rental" readonly>
                            <small class="text-danger advance_rental-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="deposit" class="col-sm-4 col-form-label">Deposit</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="deposit" name="deposit" placeholder="Deposit" readonly>
                            <small class="text-danger deposit-errors"></small>
                        </div>
                    </div>
                    <hr>
                    <h4>Property Document Availability</h4>
                    <div class="position-relative row form-group">
                        <label for="tct" class="col-sm-4 col-form-label">TCT</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="tct" name="tct" placeholder="TCT" readonly>
                            <small class="text-danger tct-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="tax_declaration" class="col-sm-4 col-form-label">Tax Declaration</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="tax_declaration" name="tax_declaration" placeholder="Tax Declaration" readonly>
                            <small class="text-danger tax_declaration-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="tax_receipt" class="col-sm-4 col-form-label">Tax Receipt</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="tax_receipt" name="tax_receipt" placeholder="Tax Receipt" readonly>
                            <small class="text-danger tax_receipt-errors"></small>
                        </div>
                    </div> 
                    <div class="position-relative row form-group">
                        <label for="tax_clearance" class="col-sm-4 col-form-label">Tax Clearance</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="tax_clearance" name="tax_clearance" placeholder="Tax Clearance" readonly>
                            <small class="text-danger tax_clearance-errors"></small>
                        </div>
                    </div>
                    {{-- <div class="position-relative row form-group">
                        <label for="property_use" class="col-sm-4 col-form-label">Property Use</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="property_use" name="property_use" placeholder="Property Use">
                            <small class="text-danger property_use-errors"></small>
                        </div>
                    </div> --}}
                    <hr>
                    <h4>Social Acceptability</h4>
                    <div class="position-relative row form-group">
                        <label for="hoa_will_issue_consent" class="col-sm-4 col-form-label">HOA will issue consent</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="hoa_will_issue_consent" name="hoa_will_issue_consent" readonly>
                                <option value="">HOA will issue consent</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="neighbors" class="col-sm-4 col-form-label">Neighbors</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="neighbors" name="neighbors" readonly>
                                <option value="">Neighbors</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="brgy_will_issue_consent" class="col-sm-4 col-form-label">BRGY. will issue consent</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="brgy_will_issue_consent" name="brgy_will_issue_consent" readonly>
                                <option value="">BRGY. will issue consent</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="no_neighbors" class="col-sm-4 col-form-label">No neighbors</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="no_neighbors" name="no_neighbors" readonly>
                                <option value="">No neighbors</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="position-relative row form-group">
                        <label for="restriction_on_the_use_of_property" class="col-sm-4 col-form-label">Restriction on the use of property</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="restriction_on_the_use_of_property" name="restriction_on_the_use_of_property" placeholder="Restriction on the use of property" readonly>
                            <small class="text-danger restriction_on_the_use_of_property-errors"></small>
                        </div>
                    </div>
                    {{-- <div class="position-relative row form-group">
                        <label for="right_of_way_access" class="col-sm-4 col-form-label">Right of way access</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="right_of_way_access" name="right_of_way_access" placeholder="Right of way access">
                            <small class="text-danger right_of_way_access-errors"></small>
                        </div>
                    </div> --}}
                    <div class="position-relative row form-group">
                        <label for="site_aquisition_remarks" class="col-sm-4 col-form-label">Remarks</label>
                        <div class="col-sm-8">
                            <textarea name="site_aquisition_remarks" class="form-control" id="site_aquisition_remarks" cols="30" rows="10" readonly></textarea>
                            <small class="text-danger site_aquisition_remarks-errors"></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div id="headingThree" class="card-header">
                <button type="button" data-toggle="collapse" data-target="#collapseOne3" aria-expanded="true" aria-controls="collapseThree" class="text-left m-0 p-0 btn btn-link btn-block">
                    <h5 class="m-0 p-0">
                        Radio Network Engineering
                    </h5>
                </button>
            </div>
            <div data-parent="#accordion" id="collapseOne3" class="collapse" style="">
                <div class="card-body">
                    <div class="position-relative row form-group">
                        <label for="rank_antenna" class="col-sm-4 col-form-label">Rank</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="rank_antenna" name="rank_antenna" placeholder="Rank" readonly>
                            <small class="text-danger rank_antenna-errors"></small>
                        </div>
                    </div>
                    <h4>Sector 1</h4>
                    <div class="position-relative row form-group">
                        <label for="antenna_height_s1" class="col-sm-4 col-form-label">Antenna Height</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="antenna_height_s1" name="antenna_height_s1" placeholder="Antenna Height" readonly>
                            <small class="text-danger antenna_height_s1-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="antenna_orientation_s1" class="col-sm-4 col-form-label">Antenna Orientation</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="antenna_orientation_s1" name="antenna_orientation_s1" placeholder="Antenna Orientation" readonly>
                            <small class="text-danger antenna_orientation_s1-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="antenna_type_s1" class="col-sm-4 col-form-label">Antenna Type</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="antenna_type_s1" name="antenna_type_s1" placeholder="Antenna Type" readonly>
                            <small class="text-danger antenna_type_s1-errors"></small>
                        </div>
                    </div>   
                    <h4>Sector 2</h4>
                    <div class="position-relative row form-group">
                        <label for="antenna_height_s2" class="col-sm-4 col-form-label">Antenna Height</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="antenna_height_s2" name="antenna_height_s2" placeholder="Antenna Height" readonly>
                            <small class="text-danger antenna_height_s2-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="antenna_orientation_s2" class="col-sm-4 col-form-label">Antenna Orientation</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="antenna_orientation_s2" name="antenna_orientation_s2" placeholder="Antenna Orientation" readonly>
                            <small class="text-danger antenna_orientation_s2-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="antenna_type_s2" class="col-sm-4 col-form-label">Antenna Type</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="antenna_type_s2" name="antenna_type_s2" placeholder="Antenna Type" readonly>
                            <small class="text-danger antenna_type_s2-errors"></small>
                        </div>
                    </div>  
                    <h4>Sector 3</h4>
                    <div class="position-relative row form-group">
                        <label for="antenna_height_s3" class="col-sm-4 col-form-label">Antenna Height</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="antenna_height_s3" name="antenna_height_s3" placeholder="Antenna Height" readonly>
                            <small class="text-danger antenna_height_s3-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="antenna_orientation_s3" class="col-sm-4 col-form-label">Antenna Orientation</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="antenna_orientation_s3" name="antenna_orientation_s3" placeholder="Antenna Orientation" readonly>
                            <small class="text-danger antenna_orientation_s3-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="antenna_type_s3" class="col-sm-4 col-form-label">Antenna Type</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="antenna_type_s3" name="antenna_type_s3" placeholder="Antenna Type" readonly>
                            <small class="text-danger antenna_type_s3-errors"></small>
                        </div>
                    </div>   
                    <h4>Sector 4</h4>
                    <div class="position-relative row form-group">
                        <label for="antenna_height_s4" class="col-sm-4 col-form-label">Antenna Height</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="antenna_height_s4" name="antenna_height_s4" placeholder="Antenna Height" readonly>
                            <small class="text-danger antenna_height_s4-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="antenna_orientation_s4" class="col-sm-4 col-form-label">Antenna Orientation</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="antenna_orientation_s4" name="antenna_orientation_s4" placeholder="Antenna Orientation" readonly>
                            <small class="text-danger antenna_orientation_s4-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="antenna_type_s4" class="col-sm-4 col-form-label">Antenna Type</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="antenna_type_s4" name="antenna_type_s4" placeholder="Antenna Type" readonly>
                            <small class="text-danger antenna_type_s4-errors"></small>
                        </div>
                    </div>        
                    <hr>
                    <h4>Target Coverage</h4>
                    <div class="position-relative row form-group">
                        <label for="target_coverage_s1" class="col-sm-4 col-form-label">Target Coverage S1</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="target_coverage_s1" name="target_coverage_s1" placeholder="Target Coverage S1" readonly>
                            <small class="text-danger target_coverage_s1-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="target_coverage_s2" class="col-sm-4 col-form-label">Target Coverage S2</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="target_coverage_s2" name="target_coverage_s2" placeholder="Target Coverage S2" readonly>
                            <small class="text-danger target_coverage_s2-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="target_coverage_s3" class="col-sm-4 col-form-label">Target Coverage S3</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="target_coverage_s3" name="target_coverage_s3" placeholder="Target Coverage S3" readonly>
                            <small class="text-danger target_coverage_s3-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="target_coverage_s4" class="col-sm-4 col-form-label">Target Coverage S4</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="target_coverage_s4" name="target_coverage_s4" placeholder="Target Coverage S4" readonly>
                            <small class="text-danger target_coverage_s4-errors"></small>
                        </div>
                    </div>
                    <hr>
                    <h4>Existing Coverage</h4>
                    <div class="position-relative row form-group">
                        <label for="cell_id_sc_code" class="col-sm-4 col-form-label">Cell ID / SC Code</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="cell_id_sc_code" name="cell_id_sc_code" placeholder="Cell ID / SC Code" readonly>
                            <small class="text-danger cell_id_sc_code-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="rxlev_rscp" class="col-sm-4 col-form-label">Rxlev / RSCP</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="rxlev_rscp" name="rxlev_rscp" placeholder="Rxlev / RSCP" readonly>
                            <small class="text-danger rxlev_rscp-errors"></small>
                        </div>
                    </div>
                    <hr>
                    <div class="position-relative row form-group">
                        <label for="bsc_homing" class="col-sm-4 col-form-label">BSC Homing</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="bsc_homing" name="bsc_homing" placeholder="BSC Homing" readonly>
                            <small class="text-danger bsc_homing-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="site_categorys" class="col-sm-4 col-form-label">Site Category</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="site_categorys" name="site_categorys" placeholder="Site Category" readonly>
                            <small class="text-danger site_categorys-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="fsr_option" class="col-sm-4 col-form-label">FSR Option</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="fsr_option" name="fsr_option" readonly>
                                <option value="">FSR Option</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="equipment" class="col-sm-4 col-form-label">Equipment</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="equipment" name="equipment" readonly>
                                <option value="">Equipment</option>
                                <option value="indoor">Indoor</option>
                                <option value="outdoor">Outdoor</option>
                            </select>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="elevation" class="col-sm-4 col-form-label">Elevation</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="elevation" name="elevation" placeholder="Elevation" readonly>
                            <small class="text-danger elevation-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="configuration" class="col-sm-4 col-form-label">Configuration</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="configuration" name="configuration" placeholder="Configuration" readonly>
                            <small class="text-danger configuration-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="engineering_remarks" class="col-sm-4 col-form-label">Comments / Remarks / Landmarks</label>
                        <div class="col-sm-8">
                            <textarea name="engineering_remarks" class="form-control" id="engineering_remarks" cols="30" rows="10" readonly></textarea>
                            <small class="text-danger engineering_remarks-errors"></small>
                        </div>
                    </div>
                    <hr>
                    <h4>Proximity Checklist</h4>
                    <h5 class='pt-3'>Existing Site</h5>
                    <div class="position-relative row form-group">
                        <label for="with_existing_globe_neighboring_site" class="col-sm-4 col-form-label">With existing globe neighboring site</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="with_existing_globe_neighboring_site" name="with_existing_globe_neighboring_site" readonly>
                                <option value="">With existing globe neighboring site</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="exisitng_site_name_phase_no" class="col-sm-4 col-form-label">Site Name / Phase No.</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="exisitng_site_name_phase_no" name="exisitng_site_name_phase_no" placeholder="Site Name / Phase No." readonly>
                            <small class="text-danger exisitng_site_name_phase_no-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="existing_site_address" class="col-sm-4 col-form-label">Site Address</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="existing_site_address" name="existing_site_address" placeholder="Site Address" readonly>
                            <small class="text-danger existing_site_address-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="existing_approx_distance" class="col-sm-4 col-form-label">Approx Distance to the proposed site</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="existing_approx_distance" name="existing_approx_distance" placeholder="Approx Distance to the proposed site" readonly>
                            <small class="text-danger existing_approx_distance-errors"></small>
                        </div>
                    </div>

                    <h5>Future Site</h5>
                    <div class="position-relative row form-group">
                        <label for="with_future_globe_site" class="col-sm-4 col-form-label">With Future Globe Site</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="with_future_globe_site" name="with_future_globe_site" readonly>
                                <option value="">With Future Globe Site</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="future_site_name_phase_no" class="col-sm-4 col-form-label">Site Name / Phase No.</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="future_site_name_phase_no" name="future_site_name_phase_no" placeholder="Site Name / Phase No." readonly>
                            <small class="text-danger future_site_name_phase_no-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="future_site_address" class="col-sm-4 col-form-label">Site Address</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="future_site_address" name="future_site_address" placeholder="Site Address" readonly>
                            <small class="text-danger future_site_address-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="future_approx_distance" class="col-sm-4 col-form-label">Approx Distance to the proposed site</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="future_approx_distance" name="future_approx_distance" placeholder="Approx Distance to the proposed site" readonly>
                            <small class="text-danger future_approx_distance-errors"></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div id="headingFour" class="card-header">
                <button type="button" data-toggle="collapse" data-target="#collapseOne4" aria-expanded="true" aria-controls="collapseFour" class="text-left m-0 p-0 btn btn-link btn-block">
                    <h5 class="m-0 p-0">
                        Transmission Network Engineering
                    </h5>
                </button>
            </div>
            <div data-parent="#accordion" id="collapseOne4" class="collapse" style="">
                <div class="card-body">
                    <h4>Site A</h4>
                    <div class="position-relative row form-group">
                        <label for="site_a_acl" class="col-sm-4 col-form-label">ACL</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="site_a_acl" name="site_a_acl" placeholder="ACL" readonly>
                            <small class="text-danger site_a_acl-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="site_a_azimuth" class="col-sm-4 col-form-label">AZIMUTH</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="site_a_azimuth" name="site_a_azimuth" placeholder="AZIMUTH" readonly>
                            <small class="text-danger site_a_azimuth-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="site_a_antenna_size" class="col-sm-4 col-form-label">Antenna Size</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="site_a_antenna_size" name="site_a_antenna_size" placeholder="Antenna Size" readonly>
                            <small class="text-danger site_a_antenna_size-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="site_a_microwave_type_capacity" class="col-sm-4 col-form-label">Microwave Type & Capacity</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="site_a_microwave_type_capacity" name="site_a_microwave_type_capacity" placeholder="Microwave Type & Capacity" readonly>
                            <small class="text-danger site_a_microwave_type_capacity-errors"></small>
                        </div>
                    </div>
                    <h4>Site B (Preferred Link Up)</h4>
                    <div class="position-relative row form-group">
                        <label for="site_b_acl" class="col-sm-4 col-form-label">ACL</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="site_b_acl" name="site_b_acl" placeholder="ACL" readonly>
                            <small class="text-danger site_b_acl-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="site_b_azimuth" class="col-sm-4 col-form-label">AZIMUTH</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="site_b_azimuth" name="site_b_azimuth" placeholder="AZIMUTH" readonly>
                            <small class="text-danger site_b_azimuth-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="site_b_antenna_size" class="col-sm-4 col-form-label">Antenna Size</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="site_b_antenna_size" name="site_b_antenna_size" placeholder="Antenna Size" readonly>
                            <small class="text-danger site_b_antenna_size-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="site_b_microwave_type_capacity" class="col-sm-4 col-form-label">Microwave Type & Capacity</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="site_b_microwave_type_capacity" name="site_b_microwave_type_capacity" placeholder="Microwave Type & Capacity" readonly>
                            <small class="text-danger site_b_microwave_type_capacity-errors"></small>
                        </div>
                    </div>
                    <h4>Site C (Other Possible Link Up)</h4>
                    <div class="position-relative row form-group">
                        <label for="site_c_acl" class="col-sm-4 col-form-label">ACL</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="site_c_acl" name="site_c_acl" placeholder="ACL" readonly>
                            <small class="text-danger site_c_acl-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="site_c_azimuth" class="col-sm-4 col-form-label">AZIMUTH</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="site_c_azimuth" name="site_c_azimuth" placeholder="AZIMUTH" readonly>
                            <small class="text-danger site_c_azimuth-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="site_c_antenna_size" class="col-sm-4 col-form-label">Antenna Size</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="site_c_antenna_size" name="site_c_antenna_size" placeholder="Antenna Size" readonly>
                            <small class="text-danger site_c_antenna_size-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="site_c_microwave_type_capacity" class="col-sm-4 col-form-label">Microwave Type & Capacity</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="site_c_microwave_type_capacity" name="site_c_microwave_type_capacity" placeholder="Microwave Type & Capacity" readonly>
                            <small class="text-danger site_c_microwave_type_capacity-errors"></small>
                        </div>
                    </div>
                    <hr>
                    <div class="position-relative row form-group">
                        <label for="lease_line_availability" class="col-sm-4 col-form-label">Lease Line Availabilty</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="lease_line_availability" name="lease_line_availability" readonly>
                                <option value="">Lease Line Availabilty?</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                            <small class="text-danger tap_to_lessor-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="loading_no_of_antenna" class="col-sm-4 col-form-label">Loading / No. of antenna</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="loading_no_of_antenna" name="loading_no_of_antenna" placeholder="Loading / No. of antenna" readonly>
                            <small class="text-danger loading_no_of_antenna-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="transmission_remarks" class="col-sm-4 col-form-label">Comments / Remarks</label>
                        <div class="col-sm-8">
                            <textarea name="transmission_remarks" class="form-control" id="transmission_remarks" cols="30" rows="10" readonly></textarea>
                            <small class="text-danger transmission_remarks-errors"></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div id="headingFive" class="card-header">
                <button type="button" data-toggle="collapse" data-target="#collapseOne5" aria-expanded="true" aria-controls="collapseFive" class="text-left m-0 p-0 btn btn-link btn-block">
                    <h5 class="m-0 p-0">
                        Civil Works / Facilities Engineering
                    </h5>
                </button>
            </div>
            <div data-parent="#accordion" id="collapseOne5" class="collapse" style="">
                <div class="card-body">
                    <div class="position-relative row form-group">
                        <label for="tap_to_lessor" class="col-sm-4 col-form-label">Tap to Lessor</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="tap_to_lessor" name="tap_to_lessor" readonly>
                                <option value="">Tap to Lessor?</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                            <small class="text-danger tap_to_lessor-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="tap_to_neighbor" class="col-sm-4 col-form-label">Tap to Neighbor</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="tap_to_neighbor" name="tap_to_neighbor" readonly>
                                <option value="">Tap to Neighbor?</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                            <small class="text-danger certificate_of_title-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="distance_to_tapping_point" class="col-sm-4 col-form-label">Distance to Tapping Point</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="distance_to_tapping_point" name="distance_to_tapping_point" placeholder="Distance to Tapping Point" readonly>
                            <small class="text-danger distance_to_tapping_point-errors"></small>
                        </div>
                    </div>                
                </div>
            </div>
        </div>
        <div class="card">
            <div id="headingSix" class="card-header">
                <button type="button" data-toggle="collapse" data-target="#collapseOne6" aria-expanded="true" aria-controls="collapseSix" class="text-left m-0 p-0 btn btn-link btn-block">
                    <h5 class="m-0 p-0">
                        Permanent Power
                    </h5>
                </button>
            </div>
            <div data-parent="#accordion" id="collapseOne6" class="collapse" style="">
                <div class="card-body">
                    <div class="position-relative row form-group">
                        <label for="meralco" class="col-sm-4 col-form-label">Meralco</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="meralco" name="meralco" readonly>
                                <option value="">Meralco?</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                            <small class="text-danger meralco-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="localcoop" class="col-sm-4 col-form-label">Local COOP</label>
                    @php
                        $localcoops = \DB::table('local_coop')->orderBy('coop_name')->get();
                    @endphp
        
                        <div class="col-sm-8">
                            <select class="form-control" id="localcoop" name="localcoop" readonly>
                                <option value="">Local COOP?</option>
                                <optgroup label="Not LocalCOOP">
                                    <option value="no">No</option>
                                </optgroup>
                                <optgroup label="Local COOPs">
                                    @foreach($localcoops as $localcoop)
                                    <option value="no">{{ $localcoop->coop_full_name }} ({{ $localcoop->coop_name }})</option>
                                    @endforeach
                                </optgroup>
                            </select>
                            <small class="text-danger localcoop-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="genset_availability" class="col-sm-4 col-form-label">Genset Availability</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="genset_availability" name="genset_availability" readonly>
                                <option value="">Genset Availability?</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                            <small class="text-danger genset_availability-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="distance_to_nearby_transmission_line" class="col-sm-4 col-form-label">Distance to Nearby Transmission Line</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="distance_to_nearby_transmission_line" name="distance_to_nearby_transmission_line" placeholder="Distance to Nearby Transmission Line" readonly>
                            <small class="text-danger distance_to_nearby_transmission_line-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="distance_from_creek_river" class="col-sm-4 col-form-label">Distance from Creek/River</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="distance_from_creek_river" name="distance_from_creek_river" placeholder="Distance from Creek/River" readonly>
                            <small class="text-danger distance_from_creek_river-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="distance_from_national_road" class="col-sm-4 col-form-label">Distance from National Road</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="distance_from_national_road" name="distance_from_national_road" placeholder="Distance from National Road" readonly>
                            <small class="text-danger distance_from_national_road-errors"></small>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="demolition_of_existing_structure" class="col-sm-4 col-form-label">Demolition of Existing Structure</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="demolition_of_existing_structure" name="demolition_of_existing_structure" placeholder="Demolition of Existing Structure" readonly>
                            <small class="text-danger demolition_of_existing_structure-errors"></small>
                        </div>
                    </div>                
                </div>
            </div>
        </div>
    </div>            
</form>