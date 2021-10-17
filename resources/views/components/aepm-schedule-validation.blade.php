<style>
    .modal-dialog{
        -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -o-box-shadow: 0 5px 15px rgba(0,0,0,0);
        box-shadow: 0 5px 15px rgba(0,0,0,0);
    }   
</style>
<div class="modal fade" id="viewInfoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="background-color: transparent; border: 0">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="main-card mb-3 card">

                        <div class="dropdown-menu-header">
                            <div class="dropdown-menu-header-inner bg-dark">
                                <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                                <div class="menu-header-content btn-pane-right">
                                    <h5 class="menu-header-title">
                                        {{ $site_name }}
                                    </h5>
                                </div>
                            </div>
                        </div> 

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <H5 id="active_action">{{ $activity }}</H5>
                                </div>
                            </div>

                            <div class="row pb-3 border-bottom">
                                <div class="col-12">
                                    @php
                                        if($count > 0){
                                            $control = ''
                                        }
                                    @endphp
                                    <button class="btn btn-sm btn-shadow btn-primary confirm_schedule pull-right {{ $count > 0 ? "" : "d-none" }}">JTSS Sched Confirmed</button>
                                </div>
                            </div>

                            <div class="row p-3">
                                <div class="col-12">
                                    <div class="table-responsive aepm_table_div">
                                        <div id="map"></div>
                                        <table class="table table-hover table-inverse" id="aepm_table">
                                            <thead class="thead-inverse">
                                                <tr>
                                                    <th>Lessor</th>
                                                    {{-- <th>Address</th> --}}
                                                    <th>Latitude</th>
                                                    <th>Longitude</th>
                                                    <th>Distance</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="form_data d-none">
                                        <div class="row form_div border-bottom pt-3 pb-2">
                                            <div class="col-12">
                                                <ul class="tabs-animated-shadow tabs-animated nav">
                                                    <li class="nav-item">
                                                        <a role="tab" class="nav-link active" id="tab-c-0" data-toggle="tab" href="#tab-animated-0" aria-selected="true">
                                                            <span>Schedule</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a role="tab" class="nav-link" id="tab-c-1" data-toggle="tab" href="#tab-animated-1" aria-selected="false">
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
                                                    <div class="tab-pane active" id="tab-animated-0" role="tabpanel">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div id="datepicker" style="width:100% !important;"></div>
                                                            </div>
                                                            <div class="col-6">
                                                                <form class="set_schedule_form">
                                                                    <div class="position-relative form-group">
                                                                        <label for="jtss_schedule" class="col-sm-12 col-form-label">JTSS Date</label>
                                                                        <input type="input" class="form-control" name="jtss_schedule" id="jtss_schedule" readonly>
                                                                        <small class="text-danger jtss_schedule-error"></small>
                                                                    </div>
                                                                    <div class="position-relative form-group">
                                                                        <label for="remarks" class="">Remarks</label>
                                                                        <textarea name="remarks" id="remarks" class="form-control"></textarea>                                                                        
                                                                        <small class="text-danger remarks-error"></small>
                                                                    </div>
                                                                    <button class="btn btn-sm btn-shadow btn-success set_schedule pull-right" id="single_btn" data-value="single" type="button">Set Schedule</button>
                                                                    <button class="btn btn-sm btn-shadow btn-primary set_schedule pull-right mr-1" id="all_btn" data-value="all" type="button">Set Schedule to all</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tab-animated-1" role="tabpanel">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@php

    $NP = \DB::table('site')
        ->where('sam_id', $sam_id)
        ->select('NP_latitude', 'NP_longitude')
        ->get();
    
@endphp


{{-- GOOGLE MAPS --}}

<style type="text/css">
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
    #map {
      height: 300px;
    }

    /* Optional: Makes the sample page fill the window. */
    html,
    body {
      height: 100%;
      margin: 0;
      padding: 0;
    }
    .ui-datepicker,
    .ui-datepicker-calendar {
    width: 100%;
    }
    .ui-datepicker,
    .ui-datepicker-calendar {
        min-height: 220px;
    }
</style>

<script>

    function initMap(markers) {

        var NP_latitude = {!! json_encode($NP[0]->NP_latitude) !!};
        var NP_longitude = {!! json_encode($NP[0]->NP_longitude) !!};

        const nominal_point = { lat: parseFloat(NP_latitude), lng: parseFloat(NP_longitude)};

        const map = new google.maps.Map(document.getElementById("map"), {
            center: nominal_point,
            zoom: 16,
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
            radius: 300,
        });

        let infoWindow = new google.maps.InfoWindow({
        });

        infoWindow.open(map);

    }

</script>


<script>
    $(document).ready(function() {

        $("#datepicker").datepicker({
            minDate : 0
        });
        $("#datepicker").on("change",function(){
            var selected = $(this).val();
            $("#jtss_schedule").val(selected);
        });

        $('#aepm_table').DataTable({
            processing: true,
            serverSide: true,
            select: true,
            order: [ 1, "asc" ],
            ajax: {
                url: "/get-site-candidate/" + "{{ $sam_id }}" + "/pending",
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
                { data: "latitude" },
                { data: "longitude" },
                { data: "distance", className: "text-center" },
                { data: "status", className: "text-right" },
            ],
            "initComplete": function( settings, json){
                initMap(json.data);
            }
        });

        $("#aepm_table").on("click", "tr", function(e){
            e.preventDefault();
            // $(".aepm_table_div").addClass("d-none");

            // $(".form_data").removeClass("d-none");


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

            // $.ajax({
            //     url: "/get-jtss-schedule/" + id,
            //     method: "GET",
            //     success: function (resp) {
            //         if (!resp.error) {
            //                 var json = JSON.parse(resp.message.value);
            //             if (resp.message != null) {
            //                 $("#jtss_schedule").val(json.jtss_schedule);
            //             } else {
            //                 $("#jtss_schedule").val("");
            //             }

            //             $.each(json, function(index, data) {
            //                 $("#"+index).val(data);
            //             });
            //         } else {
            //             Swal.fire(
            //                 'Error',
            //                 resp.message,
            //                 'error'
            //             )
            //         }
            //     },
            //     error: function (resp) {
                    
            //         Swal.fire(
            //             'Error',
            //             resp,
            //             'error'
            //         )
            //     },
            // });
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

        $(".set_schedule").on("click", function (e){
            e.preventDefault();
            var id = $(this).attr('data-id');
            var jtss_schedule = $("#jtss_schedule").val();
            var data_value = $(this).attr('data-value');
            var sam_id = "{{ $sam_id }}";

            $(".set_schedule_form small").text("");
            $(".set_schedule_form input").removeClass("is-invalid");

            if (data_value == "all") {
                var btn_text = "Set Schedule to all";
                var btn_id = "#all_btn";
            } else {
                var btn_text = "Set Schedule";
                var btn_id = "#single_btn";
            }

            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            $.ajax({
                url: "/set-schedule",
                method: "POST",
                data: {
                    jtss_schedule : jtss_schedule,
                    id : id,
                    data_value : data_value,
                    sam_id : sam_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp) {
                    if (!resp.error) {

                        $("#aepm_table").DataTable().ajax.reload(function () {
                            $(".back_to_table").trigger("click");

                            $("#jtss_schedule").val("");

                            Swal.fire(
                                'Success',
                                resp.message,
                                'success'
                            )

                            $(".form_data").addClass("d-none");

                            $(".confirm_schedule").removeClass("d-none");
                            $(btn_id).removeAttr("disabled");
                            $(btn_id).text(btn_text);
                        });

                    } else {
                        if (typeof resp.message === 'object' && resp.message !== null) {
                            $.each(resp.message, function(index, data) {
                                $(".set_schedule_form small." + index + "-error").text(data);
                                $(".set_schedule_form #" + index).addClass("is-invalid");
                            });
                        } else {
                            Swal.fire(
                                'Error',
                                resp.message,
                                'error'
                            )
                        }

                        $(btn_id).removeAttr("disabled");
                        $(btn_id).text(btn_text);
                    }
                },
                error: function (resp) {
                    
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )
                    $(btn_id).removeAttr("disabled");
                    $(btn_id).text(btn_text);
                },
            });
        });

        $(".confirm_schedule").on("click", function(e) {
            e.preventDefault();
            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            var sam_id = ["{{ $sam_id }}"];
            var activity_name = "{{ $activity }}";
            var site_category = ["{{ $site_category }}"];
            var activity_id = ["{{ $activity_id }}"];
            var program_id = "{{ $program_id }}";
            var data_complete = "true";

            $.ajax({
                url: "/accept-reject-endorsement",
                method: "POST",
                data: {
                    sam_id : sam_id,
                    activity_name : activity_name,
                    site_category : site_category,
                    activity_id : activity_id,
                    program_id : program_id,
                    data_complete : data_complete,
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
                        $(".confirm_schedule").removeAttr("disabled");
                        $(".confirm_schedule").text("JTSS Sched Confirmed");

                        $("#viewInfoModal").modal("hide");
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                        $(".confirm_schedule").removeAttr("disabled");
                        $(".confirm_schedule").text("JTSS Sched Confirmed");
                    }
                },
                error: function (resp) {
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )
                    $(".confirm_schedule").removeAttr("disabled");
                    $(".confirm_schedule").text("JTSS Sched Confirmed");
                }
            });

        });
    });
</script>