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

<div class="action_box_content">
    <div class="row p-3">
        <div class="col-12">
            <div class="table-responsive aepm_table_div">
                <table class="table table-hover table-inverse" id="aepm_table">
                    <thead class="thead-inverse">
                        <tr>
                            <th>Lessor</th>
                            <th>Address</th>
                            {{-- <th>Latitude</th>
                            <th>Longitude</th> --}}
                            <th>Distance</th>
                            <th>Schedule</th>
                        </tr>
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
                                                            <input type="text" class="form-control" id="region_new" name="region_new" readonly>
                                                            <input type="hidden" class="form-control" id="region" name="region">
                                                            <small class="text-danger region-errors"></small>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="province" class="col-sm-4 col-form-label">Province</label>
                                                        <div class="col-sm-8">
                                                            {{-- <select class="form-control" name="province" id="province" data-name="address" disabled required autocomplete="off"></select> --}}
                        
                                                            <input type="text" class="form-control" id="province_new" name="province_new" readonly>
                                                            <input type="hidden" class="form-control" id="province" name="province">
                                                            <small class="text-danger province-errors"></small>
                                        
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="lgu" class="col-sm-4 col-form-label">City / Municipality</label>
                                                        <div class="col-sm-8">
                                                            {{-- <select class="form-control" name="lgu" id="lgu" data-name="address" disabled required autocomplete="off"></select> --}}
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
                                                        Availability of Property Documents
                                                    </h5>
                                                </button>
                                            </div>
                                            <div data-parent="#accordion" id="collapseOne2" class="collapse" style="">
                                                <div class="card-body">
                                                    <div class="position-relative row form-group">
                                                        <label for="certificate_of_title" class="col-sm-4 col-form-label">Certificate of Title</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" id="certificate_of_title" name="certificate_of_title">
                                                                <option value="">Certificate of Title</option>
                                                                <option value="yes">Yes</option>
                                                                <option value="no">No</option>
                                                            </select>
                                                            <small class="text-danger certificate_of_title-errors"></small>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="tax_declaration" class="col-sm-4 col-form-label">Tax Declaration</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" id="tax_declaration" name="tax_declaration">
                                                                <option value="">Tax Declaration</option>
                                                                <option value="yes">Yes</option>
                                                                <option value="no">No</option>
                                                            </select>
                                                            <small class="text-danger tax_declaration-errors"></small>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="tax_clearance" class="col-sm-4 col-form-label">Tax Clearance</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" id="tax_clearance" name="tax_clearance">
                                                                <option value="">Tax Clearance</option>
                                                                <option value="yes">Yes</option>
                                                                <option value="no">No</option>
                                                            </select>
                                                            <small class="text-danger tax_clearance-errors"></small>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="mortgaged" class="col-sm-4 col-form-label">Mortgaged</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" id="mortgaged" name="mortgaged">
                                                                <option value="">Mortgaged</option>
                                                                <option value="yes">Yes</option>
                                                                <option value="no">No</option>
                                                            </select>
                                                            <small class="text-danger mortgaged-errors"></small>
                                                        </div>
                                                    </div>                
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div id="headingThree" class="card-header">
                                                <button type="button" data-toggle="collapse" data-target="#collapseOne3" aria-expanded="true" aria-controls="collapseThree" class="text-left m-0 p-0 btn btn-link btn-block">
                                                    <h5 class="m-0 p-0">
                                                        Existing Telco in the Area
                                                    </h5>
                                                </button>
                                            </div>
                                            <div data-parent="#accordion" id="collapseOne3" class="collapse" style="">
                                                <div class="card-body">
                                                    <div class="position-relative row form-group">
                                                        <label for="tower_structure" class="col-sm-4 col-form-label">Tower Structure</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="tower_structure" name="tower_structure" placeholder="Tower Structure">
                                                            <small class="text-danger tower_structure-errors"></small>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="tower_height" class="col-sm-4 col-form-label">Tower Height</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="tower_height" name="tower_height" placeholder="Tower Height">
                                                            <small class="text-danger tower_height-errors"></small>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="swat_design" class="col-sm-4 col-form-label">Swat Design</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="swat_design" name="swat_design" placeholder="Swat Design">
                                                            <small class="text-danger swat_design-errors"></small>
                                                        </div>
                                                    </div>                
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div id="headingFour" class="card-header">
                                                <button type="button" data-toggle="collapse" data-target="#collapseOne4" aria-expanded="true" aria-controls="collapseFour" class="text-left m-0 p-0 btn btn-link btn-block">
                                                    <h5 class="m-0 p-0">
                                                        Social Acceptability
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
                                                        $localcoops = \DB::table('local_coop')->orderBy('coop_name')->get();
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
                                                    {{-- <th>Address</th> --}}
                                                    {{-- <th>Latitude</th>
                                                    <th>Longitude</th> --}}
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

            <div class="row reject_remarks d-none">
                <div class="col-12">
                    <p class="message_p"><b>Are you sure you want to request for another schedule?</b></p>
                    <form class="reject_form">
                        <div class="form-group">
                            <label for="remarks">Remarks:</label>
                            <textarea style="width: 100%;" name="remarks" id="remarks" rows="5" cols="100" class="form-control"></textarea>
                            <small class="text-danger remarks-error"></small>
                        </div>
                        <div class="form-group text-right">
                            <p class="message_p"  style="font-color: red !important;"><b>Warning: You can only request for a new schedule twice.</b></p>
                            <button class="btn btn-secondary btn-lg btn-shadow cancel_reject" type="button">Cancel</button>
                            <button class="btn btn-danger btn-lg btn-shadow approve_reject_sched" id="reject_btn" data-action="false" type="button">Request</button>                            
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <div class="row button_area pb-3 pt-3 border-top">
        <div class="col-12 text-right">
            <button class="btn btn-lg btn-shadow btn-danger mr-1  approve_reject_sched_confirm" id="reject_btn" data-action="false" type="button">Request Another Schedule</button>
            <button class="btn btn-lg btn-shadow btn-primary approve_reject_sched" id="approve_btn" data-action="true" type="button">Accept Schedule</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(".btn_switch_back_to_actions").on("click", function(){
            $("#actions_box").addClass('d-none');
            $("#actions_list").removeClass('d-none');
        });

        var sam_id = "{{ $sam_id }}";
        var status = "jtss_schedule_site";
        $('#aepm_table').DataTable({
            processing: true,
            serverSide: true,
            select: true,
            order: [ 1, "asc" ],
            ajax: {
                // url: "/get-site-candidate/" + "{{ $sam_id }}" + "/jtss_schedule_site",
                // type: 'GET'
                url: "/get-site-candidate",
                type: 'POST',
                data : {
                    sam_id : sam_id,
                    status : status
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
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
                { data: "address" },
                // { data: "latitude" },
                // { data: "longitude" },
                { data: "distance", className: "text-center", render: function(data){ return data + " m"}  },
                { data: "schedule", className: "text-right"  },
            ],
        });

        $("#tab-c-2").on("click", function (e) {
            e.preventDefault();

            if ( ! $.fn.DataTable.isDataTable('#aepm_rejected_table') ) {

                var sam_id = "{{ $sam_id }}";
                var status = "rejected_schedule";
                $('#aepm_rejected_table').DataTable({
                    processing: true,
                    serverSide: true,
                    select: true,
                    order: [ 1, "asc" ],
                    ajax: {
                        // url: "/get-site-candidate/" + "{{ $sam_id }}" + "/rejected_schedule",
                        // type: 'GET'

                        url: "/get-site-candidate",
                        type: 'POST',
                        data : {
                            sam_id : sam_id,
                            status : status
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
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
                url: "/get-jtss-schedule",
                method: "POST",
                data: {
                    id : id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
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

        $(".approve_reject_sched").on("click", function (e){
            e.preventDefault();

            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            var data_action = $(this).attr("data-action");

            var activity_id = ["{{ $activity_id }}"];
            var sam_id = ["{{ $sam_id }}"];
            var site_category = ["{{ $site_category }}"];
            var sub_activity = "{{ $sub_activity }}";
            var program_id = "{{ $program_id }}";

            if (data_action == "true") {
                var btn_text = "Approve";
                var id = "#approve_btn";

                var data = {
                    program_id : program_id,
                    activity_name : sub_activity,
                    sam_id : sam_id,
                    activity_id : activity_id,
                    site_category : site_category,
                    data_complete : data_action
                }
            } else {
                var btn_text = "Confirm";
                var id = "#reject_btn";
                var remarks = $("#remarks").val();

                var data = {
                    program_id : program_id,
                    activity_name : sub_activity,
                    sam_id : sam_id,
                    activity_id : activity_id,
                    site_category : site_category,
                    data_complete : data_action,
                    remarks : remarks,
                }
            }

            $.ajax({
                url: "/accept-reject-endorsement",
                method: "POST",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp) {
                    if (!resp.error){
                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )
                        $("#viewInfoModal").modal("hide");
                        $(id).removeAttr("disabled");
                        $(id).text(btn_text);

                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                        $(id).removeAttr("disabled");
                        $(id).text(btn_text);
                    }
                },
                error: function (file, resp) {
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )
                    $(id).removeAttr("disabled");
                    $(id).text(btn_text);
                }
            });
        });

        $(".approve_reject_sched_confirm").on("click", function (e) {
            $(".aepm_table_div").addClass("d-none");
            $(".form_data").addClass("d-none");
            $(".button_area").addClass("d-none");
            $(".reject_remarks").removeClass("d-none");
        });

        $(".cancel_reject").on("click", function (e) {
            $(".aepm_table_div").removeClass("d-none");
            $(".form_data").removeClass("d-none");
            $(".button_area").removeClass("d-none");
            $(".reject_remarks").addClass("d-none");
        });
    });
</script>