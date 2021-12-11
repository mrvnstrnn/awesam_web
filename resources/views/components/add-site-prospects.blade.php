<div class="row border-bottom">
    <div class="col-6">
        <button class="btn_switch_back_to_actions btn btn-shadow btn-secondary btn-sm mb-3">Back to Actions</button>
    </div>
</div>
<div class="row pt-4">
    <div class="col-12 col-md-6">
        <H4 id="active_action">{{ $sub_activity }}</H4>
    </div>
    <div class="col-12 col-md-6 align-right  text-right">
        <button class="add_site_button btn btn-outline btn-dark btn-sm mb-3 btn-shadow mr-1">Add Site</button>
        <button class="float-right btn-sm btn-shadow btn btn-primary complete_button_act {{ count($check_if_added) > 0 ? '' : 'd-none' }}">Submit to AEPM</button>
    </div>
</div>


<div class="row pt-3">
    <div class="col-md-12">
        <div id="map"></div>
    </div>
    <div class="col-md-12" id="map_message">
        <div > Please set the site candidate's location in the map</div>
    </div>
</div>
<div class="row pt-3" id="ssds_table">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table" id="dtTable">
                <thead>
                    <tr>
                        <th>Lessor</th>
                        <th>Address</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Distance</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Lessor</td>
                        <td>Address</td>
                        <td>Latitude</td>
                        <td>Longitude</td>
                        <td>Distance</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row pt-3 d-none" id="ssds_form">
    <div class="col-md-12">
        <form class="ssds_form">
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
                                        $regions = \DB::table('location_regions')->get();
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

            <input type="hidden" name="sam_id" value="{{ $sam_id }}">
            <input type="hidden" name="sub_activity_id" value="{{ $sub_activity_id }}">
            <input type="hidden" name="sub_activity_name" value="{{ $sub_activity }}">
            <input type="hidden" id="NP_latitude" name="NP_latitude" value="{{ $NP_latitude }}">
            <input type="hidden" id="NP_longitude" name="NP_longitude" value="{{ $NP_longitude }}">
            <input type="hidden" name="type" value="jtss_add_site">
            <input type="hidden" name="site_category" value="">
            <div class="position-relative row form-group ">
                <div class="col-sm-12">
                    <button class="btn float-right btn-primary" id="btn_save_ssds" type="button">Save Site</button>
                    <button class="btn float-right btn-ouline-secondary mr-1" id="btn_cancel_ssds" type="button">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="/js/dropzone/dropzone.js"></script>

<style type="text/css">
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
    #map {
      height: 400px;
    }

    /* Optional: Makes the sample page fill the window. */
    html,
    body {
      height: 100%;
      margin: 0;
      padding: 0;
    }
</style>



<script>

function haversine_distance(mk1, mk2) {
      var R = 3958.8; // Radius of the Earth in miles
      var rlat1 = mk1.position.lat() * (Math.PI/180); // Convert degrees to radians
      var rlat2 = mk2['lat'] * (Math.PI/180); // Convert degrees to radians
      var difflat = rlat2-rlat1; // Radian difference (latitudes)
      var difflon = (mk2['lng']-mk1.position.lng()) * (Math.PI/180); // Radian difference (longitudes)

      var d = 2 * R * Math.asin(Math.sqrt(Math.sin(difflat/2)*Math.sin(difflat/2)+Math.cos(rlat1)*Math.cos(rlat2)*Math.sin(difflon/2)*Math.sin(difflon/2)));
    //   return d * 1609.344;

      return Math.round(d * 1609.344, 2);

}

function Go_Add_Site_Details(){
    $("#ssds_form").removeClass('d-none');
    $("#map_message").addClass('d-none');

    $("#collapseOne1").addClass('show');

    $('#viewInfoModal').animate({
        scrollTop: $("#accordion").offset().top - 50
    }, 1000);

    $( "#lessor" ).focus();

}

@php

    $NP = \DB::table('site')
        ->select('NP_latitude', 'NP_longitude', 'NP_radius')
        ->where('sam_id', $sam_id)
        ->get();
    
@endphp


function initMap(markers) {

    var NP_latitude = {!! json_encode($NP_latitude) !!};
    var NP_longitude = {!! json_encode($NP_longitude) !!};
    var NP_radius = {!! json_encode($NP[0]->NP_radius) !!};
    var site_region_id = {!! json_encode($site_region_id) !!};
    var site_province_id = {!! json_encode($site_province_id) !!};
    var site_lgu_id = {!! json_encode($site_lgu_id) !!};

    $('#region').val(site_region_id);
    $('#region').trigger("change");


    const nominal_point = { lat: parseFloat(NP_latitude), lng: parseFloat(NP_longitude)};

    const map = new google.maps.Map(document.getElementById("map"), {
        center: nominal_point,
        zoom: 16.5,
        mapTypeId: "roadmap",
    });

    var mk1 = new google.maps.Marker({position: nominal_point, map: map});

    var pinColor = "ffff00";
    var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
        new google.maps.Size(21, 34),
        new google.maps.Point(0,0),
        new google.maps.Point(10, 34));
    var pinShadow = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_shadow",
        new google.maps.Size(40, 37),
        new google.maps.Point(0, 0),
        new google.maps.Point(12, 35));


    var candidateinfowindow = new google.maps.InfoWindow({});


    $.each(markers, function(k, v){

        latlng = new google.maps.LatLng(v.latitude, v.longitude);

        candidate = new google.maps.Marker({
            position: latlng,
            map: map,
            icon: pinImage,
            shadow: pinShadow

        });


        candidate.addListener("click", () => {
            // Close the current InfoWindow.
            candidateinfowindow.close();

            latlng2 = new google.maps.LatLng(this.latitude, this.longitude);

            // Create a new InfoWindow.
            candidateinfowindow = new google.maps.InfoWindow({
                position: latlng2
            });

            candidateinfowindow.setContent("<div style='font-size: 20px; font-weight: bold;'>" + this.lessor + "<hr></div>"+
            '<div class="pt-2">Latitude: ' + this.latitude  + '</div>' +
            '<div class="pt-2">Longitude: ' + this.longitude  + '</div>' +
            '<div class="pt-2">Distance: ' + this.distance  + '</div>'
            );

            candidateinfowindow.open(map);

        });
                



    });


    const nominal_point_circle = new google.maps.Circle({
        strokeColor: "#FF0000",
        strokeOpacity: 0.8,
        strokeWeight: 1.5,
        fillColor: "#FF0000",
        fillOpacity: 0.1,
        map,
        center: nominal_point,
        radius: parseInt(NP_radius),
    });

    let infoWindow = new google.maps.InfoWindow({
    });

    infoWindow.open(map);

    // Configure the click listener.
    nominal_point_circle.addListener("click", (mapsMouseEvent) => {
        // Close the current InfoWindow.
        infoWindow.close();
        // Create a new InfoWindow.
        infoWindow = new google.maps.InfoWindow({
        position: mapsMouseEvent.latLng,
        });

        if($('#ssds_table').hasClass('d-none')==false){

        } else {

            let table = $('#dtTable').DataTable();

            if ( ! table.data().any() ) {
                rowCount = 1;
            } else {
                var rowCount = $('#dtTable tbody tr ').length + 1;


            }            

            var gps = mapsMouseEvent.latLng.toJSON() ;
            var distance = haversine_distance(mk1, gps);


            infoWindow.setContent("<div style='font-size: 20px; font-weight: bold;'>Site Candidate " + (rowCount) + "<hr></div>" +
            '<div class="pt-2">Latitude: ' + gps['lat']  + '</div>' +
            '<div class="pt-2">Longitude: ' + gps['lng']  + '</div>' +
            '<div class="pt-2">Distance: ' + distance  + ' meters</div>' +
            '<div class="pt-2 "><hr><button onclick="Go_Add_Site_Details()" class="btn btn-outline btn-dark btn-sm mb-3 btn-shadow mr-1">Set Details</button></div>'
            );

            $('#latitude').val(gps['lat']);
            $('#longitude').val(gps['lng']);
            $('#distance_from_nominal_point').val(distance);

            infoWindow.open(map);

        }


    });





}

</script>


<script>

    $(".btn_switch_back_to_actions").on("click", function(){
        $("#actions_box").addClass('d-none');
        $("#actions_list").removeClass('d-none');

        $("#actions_box").html('');

    });

    $('.add_site_button').on("click", function(){
        $(".add_site_button").addClass('d-none');
        $('#ssds_table').addClass('d-none');
        // $('#ssds_form').removeClass('d-none');
    });

    $('#btn_cancel_ssds').on("click", function(){

        $(".add_site_button").removeClass('d-none');
        $('#ssds_table').removeClass('d-none');
        $('#ssds_form').addClass('d-none');
    });

    $(document).ready(function () {


        if (! $.fn.DataTable.isDataTable("#dtTable") ){
             $("#dtTable").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/get-my-site/{{ $sub_activity_id }}/{{ $sam_id }}",
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },

                dataSrc: function(json){
                    return json.data;
                },

                'createdRow': function( row, data, dataIndex ) {
                    $(row).attr('data-value', data.value);
                    $(row).attr('style', 'cursor: pointer');
                },

                columns: [
                    { data: "lessor" },
                    { data: "address" },
                    { data: "latitude" },
                    { data: "longitude" },
                    { data: "distance" },
                ],

                "initComplete": function( settings, json){

                    initMap(json.data);
                }
                
            });


        } else {
            $("#dtTable").DataTable().ajax.reload(function (json){
                console.log(json);
            });
        }
    })

    $("select[data-name=address]").on('change', function(){

        var id = $(this).attr('id');
        var val = $(this).val();

        if(id == 'province') {
            if (val == '') {
                $("#lgu option").remove();
                $("#lgu").attr('disabled', 'disabled');
                return;
            }
        } else if (id == 'region') {
            if (val == '') {
                $("#province option").remove();
                $("#lgu option").remove();

                $("#province").attr('disabled', 'disabled');
                $("#lgu").attr('disabled', 'disabled');
                return;
            }
        } else {
            return;
        }

        $.ajax({
            url:  '/address',
            method: 'POST',
            data: {
                id : id,
                val : val
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp) {
                if(!resp.error){
                    if(resp.new_id) {
                        $("#"+resp.new_id+ " option").remove();
                        $("#"+resp.new_id).removeAttr('disabled');

                        if(id == 'region'){
                            $("#"+resp.new_id).append('<option value="">Please select province</option>');
                            resp.message.forEach(element => {
                                $("#"+resp.new_id).append('<option value="'+element.province_id+'">'+element.province_name+'</option>');
                            });
                        } else if (id == 'province'){
                            $("#"+resp.new_id).append('<option value="">Please select city</option>');
                            resp.message.forEach(element => {
                                $("#"+resp.new_id).append('<option value="'+element.lgu_id+'">'+element.lgu_name+'</option>');
                            });
                        }
                    }
                } else {
                    Swal.fire(
                        'Error',
                        resp.message,
                        'error'
                    )
                }
            },
            error: function(resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )
            }
        });
    });

    $("#btn_save_ssds").on("click", function() {
        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        $("form.ssds_form small").text("");
        $.ajax({
            url: "/add-site-candidates",
            method: "POST",
            data: $(".ssds_form").serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp) {
                if (!resp.error){

                    $("#dtTable").DataTable().ajax.reload(function(json){

                        // Dropzone.forElement(".dropzone_files_activities_ssds").removeAllFiles(true);

                        // $("input[name='file[]']").remove();

                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )
                        $(".ssds_form")[0].reset();
                        $("#btn_save_ssds").removeAttr("disabled");
                        $("#btn_save_ssds").text("Save Site");

                        // $(".btn_switch_back_to_actions").trigger("click");
                        $("#btn_cancel_ssds").trigger("click");

                        $(".complete_button_act").removeClass("d-none");

                        initMap(json.data);


                    });

                } else {
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $("." + index + "-errors").text(data);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }
                    $("#btn_save_ssds").removeAttr("disabled");
                    $("#btn_save_ssds").text("Save Site");
                }
            },
            error: function (file, resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )
                $("#btn_save_ssds").removeAttr("disabled");
                $("#btn_save_ssds").text("Save Site");
            }
        });

    });

    $(".complete_button_act").on("click", function() {
        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        var sam_id = ["{{ $sam_id }}"];
        var sub_activity_id = "{{ $sub_activity_id }}";
        var activity_name = "{{ $sub_activity }}";
        var site_category = ["{{ $site_category }}"];
        var activity_id = ["{{ $activity_id }}"];
        var program_id = "{{ $program_id }}";

        // alert("{{ $sub_activity }}")

        $.ajax({
            url: "/accept-reject-endorsement",
            method: "POST",
            data: {
                sam_id : sam_id,
                sub_activity_id : sub_activity_id,
                activity_name : activity_name,
                site_category : site_category,
                activity_id : activity_id,
                program_id : program_id,
            },
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
                    $(".complete_button_act").removeAttr("disabled");
                    $(".complete_button_act").text("MARK AS COMPLETE");

                    $("#viewInfoModal").modal("hide");
                } else {
                    Swal.fire(
                        'Error',
                        resp.message,
                        'error'
                    )
                    $(".complete_button_act").removeAttr("disabled");
                    $(".complete_button_act").text("MARK AS COMPLETE");
                }
            },
            error: function (resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )
                $(".complete_button_act").removeAttr("disabled");
                $(".complete_button_act").text("MARK AS COMPLETE");
            }
        });

    });

</script>
