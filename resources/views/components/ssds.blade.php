<div class="row border-bottom">
    <div class="col-12">
        <button class="btn_switch_back_to_actions btn btn-shadow btn-secondary btn-sm mb-3">Back to Actions</button>                                            
    </div>
</div>

<div class="row pt-4">
    <div class="col-md-12">
        <H5 id="active_action">{{ $sub_activity }}</H5>
    </div>
</div>

<div class="row p-3">
    <div class="col-12">
        <div class="table-responsive aepm_table_div">
            <table class="table table-hover table-inverse" id="aepm_table">
                <thead class="thead-inverse">
                    <tr>
                        <th>Lessor</th>
                        <th>Distance</th>
                        <th>Schedule</th>
                </thead>
            </table>
        </div>
        <div class="form_data d-none">
            <div class="row form_div border-bottom pt-3 pb-2">
                <div class="col-12">
                    <ul class="tabs-animated-shadow tabs-animated nav">
                        <li class="nav-item">
                            <a role="tab" class="nav-link active" id="tab-c-1" data-toggle="tab" href="#tab-animated-1" aria-selected="false">
                                <span>Details</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a role="tab" class="nav-link" id="tab-c-2" data-toggle="tab" href="#tab-animated-2" aria-selected="false">
                                <span>History</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-animated-1" role="tabpanel">
                            <form class="ssds_form pt-3">
                                <div id="accordion" class="accordion-wrapper mb-3">
                                    <div class="card">
                                        <div id="headingOne" class="card-header">
                                            <button type="button" data-toggle="collapse" data-target="#collapseOne1" aria-expanded="false" aria-controls="collapseOne" class="text-left m-0 p-0 btn btn-link btn-block collapsed">
                                                <h5 class="m-0 p-0">Property Details</h5>
                                            </button>
                                        </div>
                                        <div data-parent="#accordion" id="collapseOne1" aria-labelledby="headingOne" class="collapse" style="">
                                            <div class="card-body">
                                                <div class="position-relative row form-group">
                                                    <label for="lessor" class="col-sm-4 col-form-label">Name of Owner</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="lessor" name="lessor" placeholder="Name of Owner">
                                                        <small class="text-danger lessor-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="contact_number" class="col-sm-4 col-form-label">Contact Number</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="contact_number" name="contact_number" placeholder="Contact Number">
                                                        <small class="text-danger contact_number-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="address" class="col-sm-4 col-form-label">Street Address</label>
                                                    <div class="col-sm-8">
                                                        <textarea name="address" id="address" class="form-control" placeholder="Address"></textarea>
                                                        <small class="text-danger address-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="region" class="col-sm-4 col-form-label">Region</label>
                                                    <div class="col-sm-8">
                                                        @php
                                                            $regions = \DB::connection('mysql2')->table('location_regions')->get();
                                                        @endphp
                                                        <select class="form-control" id="region" name="region" data-name="address">
                                                            <option value="">Select Region</option>
                                                            @foreach ($regions as $region)
                                                            <option value="{{ $region->region_id }}">{{ $region->region_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <small class="text-danger region-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="province" class="col-sm-4 col-form-label">Province</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" name="province" id="province" data-name="address" disabled required autocomplete="off"></select>
                                                        <small class="text-danger province-errors"></small>
                                    
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="lgu" class="col-sm-4 col-form-label">City / Municipality</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" name="lgu" id="lgu" data-name="address" disabled required autocomplete="off"></select>
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
                                                        <select class="form-control" id="site_type" name="site_type">
                                                            <option value="">Select Site Type</option>
                                                            <option value="greenfield">Greenfield</option>
                                                            <option value="rooftop">Rooftop</option>
                                                        </select>
                                                        <small class="text-danger site_type-errors"></small>
                                    
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="building_no_of_floors" class="col-sm-4 col-form-label">Building (No. of floors)</label>
                                                    <div class="col-sm-8">
                                                        <input type="number" class="form-control" id="building_no_of_floors" name="building_no_of_floors" placeholder="Building (No. of floors)">
                                                        <small class="text-danger building_no_of_floors-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="area_size" class="col-sm-4 col-form-label">Area Size</label>
                                                    <div class="col-sm-8">
                                                        <input type="number" class="form-control" id="area_size" name="area_size" placeholder="Area Size">
                                                        <small class="text-danger area_size-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="lease_rate" class="col-sm-4 col-form-label">Lease Rate</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="lease_rate" name="lease_rate">
                                                            <option value="">Select Lease Rate</option>
                                                            <option value="7,000 - 15,000">7,000 - 15,000</option>
                                                            <option value="16,000 - 24,999">16,000 - 24,999</option>
                                                            <option value="25,000 and above">25,000 and above</option>
                                                        </select>
                                                        <small class="text-danger lease_rate-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="property_use" class="col-sm-4 col-form-label">Property Use</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="property_use" name="property_use">
                                                            <option value="">Property Use</option>
                                                            <option value="Private">Private</option>
                                                            <option value="Commercial">Commercial</option>
                                                            <option value="Government">Government</option>
                                                            <option value="Agricultural">Agricultural</option>
                                                            <option value="Industrial">Industrial</option>
                                                        </select>
                                                        <small class="text-danger property_use-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="right_of_way_access" class="col-sm-4 col-form-label">Right of Way Access</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="right_of_way_access" name="right_of_way_access">
                                                            <option value="">Right of Way Access</option>
                                                            <option value="24/7">Available 24/7</option>
                                                            <option value="limited">Limited</option>
                                                        </select>
                                                        <small class="text-danger right_of_way_access-errors"></small>
                                                    </div>
                                                </div>
                                    
                                            </div>
                                        </div>
                                    </div>
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
                                                        <input type="text" class="form-control" id="site_rank" name="site_rank" placeholder="Rank">
                                                        <small class="text-danger site_rank-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="type_of_property" class="col-sm-4 col-form-label">Type of Property</label>
                                                    <div class="col-sm-8">
                                                        <div class="row">
                                                            <div class="col-md-4 col-12">
                                                                <input type="radio" class="form-check-input" name="type_of_property" id="type_of_property_1" value="Open Lot">
                                                                Open Lot
                                                            </div>
                                                            <div class="col-md-4 col-12">
                                                                <input type="radio" class="form-check-input" name="type_of_property" id="type_of_property_2" value="Building">
                                                                Building
                                                            </div>
                                                            <div class="col-md-4 col-12">
                                                                <input type="radio" class="form-check-input" name="type_of_property" id="type_of_property_3" value="Co Location to Existing Structure">
                                                                Co Location to Existing Structure
                                                            </div>
                                                        </div>
                                                        <small class="text-danger type_of_property-errors"></small>
                                                    </div>
                                                </div>
                                                <h3>Lease Details</h3>
                                                <div class="position-relative row form-group">
                                                    <label for="lease_term" class="col-sm-4 col-form-label">Lease Term</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="lease_term" name="lease_term" placeholder="Lease Term">
                                                        <small class="text-danger lease_term-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="lease_rate" class="col-sm-4 col-form-label">Lease Rate</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="lease_rate" name="lease_rate" placeholder="Lease Rate">
                                                        <small class="text-danger lease_rate-errors"></small>
                                                    </div>
                                                </div>  
                                                <div class="position-relative row form-group">
                                                    <label for="advance_rental" class="col-sm-4 col-form-label">Advance Rental</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="advance_rental" name="advance_rental" placeholder="Advance Rental">
                                                        <small class="text-danger advance_rental-errors"></small>
                                                    </div>
                                                </div>
                                                <hr>
                                                <h3>Property Document Availability</h3>
                                                <div class="position-relative row form-group">
                                                    <label for="tct" class="col-sm-4 col-form-label">TCT</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="tct" name="tct" placeholder="TCT">
                                                        <small class="text-danger tct-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="tax_declaration" class="col-sm-4 col-form-label">Tax Declaration</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="tax_declaration" name="tax_declaration" placeholder="Tax Declaration">
                                                        <small class="text-danger tax_declaration-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="tax_receipt" class="col-sm-4 col-form-label">Tax Receipt</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="tax_receipt" name="tax_receipt" placeholder="Tax Receipt">
                                                        <small class="text-danger tax_receipt-errors"></small>
                                                    </div>
                                                </div> 
                                                <div class="position-relative row form-group">
                                                    <label for="tax_clearance" class="col-sm-4 col-form-label">Tax Clearance</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="tax_clearance" name="tax_clearance" placeholder="Tax Clearance">
                                                        <small class="text-danger tax_clearance-errors"></small>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="position-relative row form-group">
                                                    <label for="property_use" class="col-sm-4 col-form-label">Property Use</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="property_use" name="property_use" placeholder="Property Use">
                                                        <small class="text-danger property_use-errors"></small>
                                                    </div>
                                                </div>
                                                <hr>
                                                <h3>Social Acceptability</h3>
                                                <div class="position-relative row form-group">
                                                    <label for="hoa_will_issue_consent" class="col-sm-4 col-form-label">HOA will issue consent</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="hoa_will_issue_consent" name="hoa_will_issue_consent">
                                                            <option value="">HOA will issue consent</option>
                                                            <option value="yes">Yes</option>
                                                            <option value="no">No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="neighbors" class="col-sm-4 col-form-label">Neighbors</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="neighbors" name="neighbors">
                                                            <option value="">Neighbors</option>
                                                            <option value="yes">Yes</option>
                                                            <option value="no">No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="brgy_will_issue_consent" class="col-sm-4 col-form-label">BRGY. will issue consent</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="brgy_will_issue_consent" name="brgy_will_issue_consent">
                                                            <option value="">BRGY. will issue consent</option>
                                                            <option value="yes">Yes</option>
                                                            <option value="no">No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="no_neighbors" class="col-sm-4 col-form-label">No neighbors</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="no_neighbors" name="no_neighbors">
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
                                                        <input type="text" class="form-control" id="restriction_on_the_use_of_property" name="restriction_on_the_use_of_property" placeholder="Restriction on the use of property">
                                                        <small class="text-danger restriction_on_the_use_of_property-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="right_of_way_access" class="col-sm-4 col-form-label">Right of way access</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="right_of_way_access" name="right_of_way_access" placeholder="Right of way access">
                                                        <small class="text-danger right_of_way_access-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="site_remarks" class="col-sm-4 col-form-label">Remarks</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="site_remarks" name="site_remarks" placeholder="Remarks">
                                                        <small class="text-danger site_remarks-errors"></small>
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
                                                        <input type="text" class="form-control" id="rank_antenna" name="rank_antenna" placeholder="Rank">
                                                        <small class="text-danger rank_antenna-errors"></small>
                                                    </div>
                                                </div>
                                                <h3>Sector 1</h3>
                                                <div class="position-relative row form-group">
                                                    <label for="antenna_height_s1" class="col-sm-4 col-form-label">Antenna Height</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="antenna_height_s1" name="antenna_height_s1" placeholder="Antenna Height">
                                                        <small class="text-danger antenna_height_s1-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="antenna_orientation_s1" class="col-sm-4 col-form-label">Antenna Orientation</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="antenna_orientation_s1" name="antenna_orientation_s1" placeholder="Antenna Orientation">
                                                        <small class="text-danger antenna_orientation_s1-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="antenna_type_s1" class="col-sm-4 col-form-label">Antenna Type</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="antenna_type_s1" name="antenna_type_s1" placeholder="Antenna Type">
                                                        <small class="text-danger antenna_type_s1-errors"></small>
                                                    </div>
                                                </div>   
                                                <h3>Sector 2</h3>
                                                <div class="position-relative row form-group">
                                                    <label for="antenna_height_s2" class="col-sm-4 col-form-label">Antenna Height</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="antenna_height_s2" name="antenna_height_s2" placeholder="Antenna Height">
                                                        <small class="text-danger antenna_height_s2-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="antenna_orientation_s2" class="col-sm-4 col-form-label">Antenna Orientation</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="antenna_orientation_s2" name="antenna_orientation_s2" placeholder="Antenna Orientation">
                                                        <small class="text-danger antenna_orientation_s2-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="antenna_type_s2" class="col-sm-4 col-form-label">Antenna Type</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="antenna_type_s2" name="antenna_type_s2" placeholder="Antenna Type">
                                                        <small class="text-danger antenna_type_s2-errors"></small>
                                                    </div>
                                                </div>  
                                                <h3>Sector 3</h3>
                                                <div class="position-relative row form-group">
                                                    <label for="antenna_height_s3" class="col-sm-4 col-form-label">Antenna Height</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="antenna_height_s3" name="antenna_height_s3" placeholder="Antenna Height">
                                                        <small class="text-danger antenna_height_s3-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="antenna_orientation_s3" class="col-sm-4 col-form-label">Antenna Orientation</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="antenna_orientation_s3" name="antenna_orientation_s3" placeholder="Antenna Orientation">
                                                        <small class="text-danger antenna_orientation_s3-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="antenna_type_s3" class="col-sm-4 col-form-label">Antenna Type</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="antenna_type_s3" name="antenna_type_s3" placeholder="Antenna Type">
                                                        <small class="text-danger antenna_type_s3-errors"></small>
                                                    </div>
                                                </div>   
                                                <h3>Sector 4</h3>
                                                <div class="position-relative row form-group">
                                                    <label for="antenna_height_s4" class="col-sm-4 col-form-label">Antenna Height</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="antenna_height_s4" name="antenna_height_s4" placeholder="Antenna Height">
                                                        <small class="text-danger antenna_height_s4-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="antenna_orientation_s4" class="col-sm-4 col-form-label">Antenna Orientation</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="antenna_orientation_s4" name="antenna_orientation_s4" placeholder="Antenna Orientation">
                                                        <small class="text-danger antenna_orientation_s4-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="antenna_type_s4" class="col-sm-4 col-form-label">Antenna Type</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="antenna_type_s4" name="antenna_type_s4" placeholder="Antenna Type">
                                                        <small class="text-danger antenna_type_s4-errors"></small>
                                                    </div>
                                                </div>        
                                                <hr>
                                                <h3>Target Coverage</h3>
                                                <div class="position-relative row form-group">
                                                    <label for="target_coverage_s1" class="col-sm-4 col-form-label">Target Coverage S1</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="target_coverage_s1" name="target_coverage_s1" placeholder="Target Coverage S1">
                                                        <small class="text-danger target_coverage_s1-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="target_coverage_s2" class="col-sm-4 col-form-label">Target Coverage S2</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="target_coverage_s2" name="target_coverage_s2" placeholder="Target Coverage S2">
                                                        <small class="text-danger target_coverage_s2-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="target_coverage_s3" class="col-sm-4 col-form-label">Target Coverage S3</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="target_coverage_s3" name="target_coverage_s3" placeholder="Target Coverage S3">
                                                        <small class="text-danger target_coverage_s3-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="target_coverage_s4" class="col-sm-4 col-form-label">Target Coverage S4</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="target_coverage_s4" name="target_coverage_s4" placeholder="Target Coverage S4">
                                                        <small class="text-danger target_coverage_s4-errors"></small>
                                                    </div>
                                                </div>
                                                <hr>
                                                <h3>Existing Coverage</h3>
                                                <div class="position-relative row form-group">
                                                    <label for="cell_id_sc_code" class="col-sm-4 col-form-label">Cell ID / SC Code</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="cell_id_sc_code" name="cell_id_sc_code" placeholder="Cell ID / SC Code">
                                                        <small class="text-danger cell_id_sc_code-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="rxlev_rscp" class="col-sm-4 col-form-label">Rxlev / RSCP</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="rxlev_rscp" name="rxlev_rscp" placeholder="Rxlev / RSCP">
                                                        <small class="text-danger rxlev_rscp-errors"></small>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="position-relative row form-group">
                                                    <label for="bsc_homing" class="col-sm-4 col-form-label">BSC Homing</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="bsc_homing" name="bsc_homing" placeholder="BSC Homing">
                                                        <small class="text-danger bsc_homing-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="site_category" class="col-sm-4 col-form-label">Site Category</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="site_category" name="site_category" placeholder="Site Category">
                                                        <small class="text-danger site_category-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="fsr_option" class="col-sm-4 col-form-label">FSR Option</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="fsr_option" name="fsr_option">
                                                            <option value="">FSR Option</option>
                                                            <option value="yes">Yes</option>
                                                            <option value="no">No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="equipment" class="col-sm-4 col-form-label">Equipment</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="equipment" name="equipment">
                                                            <option value="">Equipment</option>
                                                            <option value="indoor">Indoor</option>
                                                            <option value="outdoor">Outdoor</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="elevation" class="col-sm-4 col-form-label">Elevation</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="elevation" name="elevation" placeholder="Elevation">
                                                        <small class="text-danger elevation-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="configuration" class="col-sm-4 col-form-label">Configuration</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="configuration" name="configuration" placeholder="Configuration">
                                                        <small class="text-danger configuration-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="engineering_remarks" class="col-sm-4 col-form-label">Comments / Remarks / Landmarks</label>
                                                    <div class="col-sm-8">
                                                        <textarea name="engineering_remarks" id="engineering_remarks" cols="30" rows="10"></textarea>
                                                        <small class="text-danger configuration-errors"></small>
                                                    </div>
                                                </div>
                                                <hr>
                                                <h3>Proximity Checklist</h3>
                                                <h2>Existing Site</h2>
                                                <div class="position-relative row form-group">
                                                    <label for="with_existing_globe_neighboring_site" class="col-sm-4 col-form-label">With existing globe neighboring site</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="with_existing_globe_neighboring_site" name="with_existing_globe_neighboring_site">
                                                            <option value="">With existing globe neighboring site</option>
                                                            <option value="yes">Yes</option>
                                                            <option value="no">No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="exisitng_site_name_phase_no" class="col-sm-4 col-form-label">Site Name / Phase No.</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="exisitng_site_name_phase_no" name="exisitng_site_name_phase_no" placeholder="Site Name / Phase No.">
                                                        <small class="text-danger exisitng_site_name_phase_no-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="existing_site_address" class="col-sm-4 col-form-label">Site Address</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="existing_site_address" name="existing_site_address" placeholder="Site Address">
                                                        <small class="text-danger existing_site_address-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="existing_approx_distance" class="col-sm-4 col-form-label">Approx Distance to the proposed site</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="existing_approx_distance" name="existing_approx_distance" placeholder="Approx Distance to the proposed site">
                                                        <small class="text-danger existing_approx_distance-errors"></small>
                                                    </div>
                                                </div>
                                                <h2>Future Site</h2>
                                                <div class="position-relative row form-group">
                                                    <label for="with_future_globe_site" class="col-sm-4 col-form-label">With Future Globe Site</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="with_future_globe_site" name="with_future_globe_site">
                                                            <option value="">With Future Globe Site</option>
                                                            <option value="yes">Yes</option>
                                                            <option value="no">No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="future_site_name_phase_no" class="col-sm-4 col-form-label">Site Name / Phase No.</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="future_site_name_phase_no" name="future_site_name_phase_no" placeholder="Site Name / Phase No.">
                                                        <small class="text-danger future_site_name_phase_no-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="future_site_address" class="col-sm-4 col-form-label">Site Address</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="future_site_address" name="future_site_address" placeholder="Site Address">
                                                        <small class="text-danger future_site_address-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="future_approx_distance" class="col-sm-4 col-form-label">Approx Distance to the proposed site</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="future_approx_distance" name="future_approx_distance" placeholder="Approx Distance to the proposed site">
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
                                                <div class="position-relative row form-group">
                                                    <label for="with_neighbors" class="col-sm-4 col-form-label">With Neighbors</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="with_neighbors" name="with_neighbors">
                                                            <option value="">With Neighbors?</option>
                                                            <option value="yes">Yes</option>
                                                            <option value="no">No</option>
                                                        </select>
                                                        <small class="text-danger with_neighbors-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="with_history_of_opposition" class="col-sm-4 col-form-label">With History of Opposition</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="mortgaged" name="with_history_of_opposition">
                                                            <option value="">With History of Opposition?</option>
                                                            <option value="yes">Yes</option>
                                                            <option value="no">No</option>
                                                        </select>
                                                        <small class="text-danger with_history_of_opposition-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="with_hoa_restriction" class="col-sm-4 col-form-label">With HOA Restriction</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="with_hoa_restriction" name="with_hoa_restriction">
                                                            <option value="">With HOA Restriction?</option>
                                                            <option value="yes">Yes</option>
                                                            <option value="no">No</option>
                                                        </select>
                                                        <small class="text-danger with_hoa_restriction-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="with_brgy_restriction" class="col-sm-4 col-form-label">With Brgy Restriction</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="with_brgy_restriction" name="with_brgy_restriction">
                                                            <option value="">With Brgy Restriction?</option>
                                                            <option value="yes">Yes</option>
                                                            <option value="no">No</option>
                                                        </select>
                                                        <small class="text-danger with_brgy_restriction-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="with_lgu_restriction" class="col-sm-4 col-form-label">With LGU Restriction</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="with_lgu_restriction" name="with_lgu_restriction">
                                                            <option value="">With LGU Restriction?</option>
                                                            <option value="yes">Yes</option>
                                                            <option value="no">No</option>
                                                        </select>
                                                        <small class="text-danger with_lgu_restriction-errors"></small>
                                                    </div>
                                                </div>                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div id="headingFive" class="card-header">
                                            <button type="button" data-toggle="collapse" data-target="#collapseOne5" aria-expanded="true" aria-controls="collapseFive" class="text-left m-0 p-0 btn btn-link btn-block">
                                                <h5 class="m-0 p-0">
                                                    Temporary Power
                                                </h5>
                                            </button>
                                        </div>
                                        <div data-parent="#accordion" id="collapseOne5" class="collapse" style="">
                                            <div class="card-body">
                                                <div class="position-relative row form-group">
                                                    <label for="tap_to_lessor" class="col-sm-4 col-form-label">Tap to Lessor</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="tap_to_lessor" name="tap_to_lessor">
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
                                                        <select class="form-control" id="tap_to_neighbor" name="tap_to_neighbor">
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
                                                        <input type="number" class="form-control" id="distance_to_tapping_point" name="distance_to_tapping_point" placeholder="Distance to Tapping Point">
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
                                                        <select class="form-control" id="meralco" name="meralco">
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
                                                    $localcoops = \DB::connection('mysql2')->table('local_coop')->orderBy('coop_name')->get();
                                                @endphp
                                    
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="localcoop" name="localcoop">
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
                                                        <select class="form-control" id="genset_availability" name="genset_availability">
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
                                                        <input type="number" class="form-control" id="distance_to_nearby_transmission_line" name="distance_to_nearby_transmission_line" placeholder="Distance to Nearby Transmission Line">
                                                        <small class="text-danger distance_to_nearby_transmission_line-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="distance_from_creek_river" class="col-sm-4 col-form-label">Distance from Creek/River</label>
                                                    <div class="col-sm-8">
                                                        <input type="number" class="form-control" id="distance_from_creek_river" name="distance_from_creek_river" placeholder="Distance from Creek/River">
                                                        <small class="text-danger distance_from_creek_river-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="distance_from_national_road" class="col-sm-4 col-form-label">Distance from National Road</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="distance_from_national_road" name="distance_from_national_road" placeholder="Distance from National Road">
                                                        <small class="text-danger distance_from_national_road-errors"></small>
                                                    </div>
                                                </div>
                                                <div class="position-relative row form-group">
                                                    <label for="demolition_of_existing_structure" class="col-sm-4 col-form-label">Demolition of Existing Structure</label>
                                                    <div class="col-sm-8">
                                                        <input type="number" class="form-control" id="demolition_of_existing_structure" name="demolition_of_existing_structure" placeholder="Demolition of Existing Structure">
                                                        <small class="text-danger demolition_of_existing_structure-errors"></small>
                                                    </div>
                                                </div>                
                                            </div>
                                        </div>
                                    </div>
                                </div>            
                            </form>               
                        </div>
                        <div class="tab-pane" id="tab-animated-2" role="tabpanel">
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-hover table-inverse" id="aepm_rejected_table">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th>Lessor</th>
                                                <th>Schedule</th>
                                                <th>Reason</th>
                                                <th>Status</th>
                                                <th>Date Rejected</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>                                                
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $(".btn_switch_back_to_actions").on("click", function(){
            $("#actions_box").addClass('d-none');
            $("#actions_list").removeClass('d-none');
        });


        $('#aepm_table').DataTable({
            processing: true,
            serverSide: true,
            select: true,
            order: [ 1, "asc" ],
            ajax: {
                url: "/get-site-candidate/" + "{{ $sam_id }}" + "/jtss_schedule_site",
                type: 'GET'
            },
            dataSrc: function(json){
                return json.data;
            },
            'createdRow': function( row, data, dataIndex ) {
                $(row).attr('data-id', data.id);
                $(row).addClass('add_schedule');
                $(row).attr('style', 'cursor: pointer;');
            },
            columns: [
                { data: "lessor" },
                // { data: "address" },
                // { data: "latitude" },
                // { data: "longitude" },
                { data: "distance", className: "text-center" },
                { data: "schedule" },
            ],
        });

        $("#aepm_table").on("click", "tr", function(e){
            e.preventDefault();

            if($(this).hasClass('selected') != true){
                $("#aepm_table tbody tr").removeClass('selected');
                $(this).addClass('selected');
            } else {
                $(this).removeClass('selected');
            }

            if($('#aepm_table tbody tr.selected').length > 0){
                var id = $(this).attr('data-id');
                $(".set_schedule").attr("data-id", id);
                $(".form_data").removeClass("d-none");
            } else {
                $(".form_data").addClass("d-none");
            }

            $(".set_schedule").attr("data-id", id);

            $.ajax({
                url: "/get-jtss-schedule/" + id,
                method: "GET",
                success: function (resp) {
                    if (!resp.error) {
                            var json = JSON.parse(resp.message.value);
                        if (resp.message != null) {
                            $("#jtss_schedule").val(json.jtss_schedule);
                        } else {
                            $("#jtss_schedule").val("");
                        }

                        $.each(json, function(index, data) {
                            $("#"+index).val(data);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }
                },
                error: function (resp) {
                    
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )
                },
            });
        });

        $("#tab-c-2").on("click", function (e) {
            e.preventDefault();

            if ( ! $.fn.DataTable.isDataTable('#aepm_rejected_table') ) {

                $('#aepm_rejected_table').DataTable({
                    processing: true,
                    serverSide: true,
                    select: true,
                    order: [ 1, "asc" ],
                    ajax: {
                        url: "/get-site-candidate/" + "{{ $sam_id }}" + "/rejected_schedule",
                        type: 'GET'
                    },
                    dataSrc: function(json){
                        return json.data;
                    },
                    'createdRow': function( row, data, dataIndex ) {
                        $(row).attr('data-id', data.id);
                        $(row).addClass('add_schedule');
                        $(row).attr('style', 'cursor: pointer;');
                    },
                    columns: [
                        { data: "lessor" },
                        { data: "schedule" },
                        { data: "reason" },
                        { data: "status" },
                        { data: "date_approved" },
                    ],
                });

            } else {
                $('#aepm_rejected_table').DataTable().ajax.reload();
            }
        });
    });
</script>