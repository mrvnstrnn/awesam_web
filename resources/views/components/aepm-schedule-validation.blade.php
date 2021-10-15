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
            <div class="row justify-content-center">
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
                                    <button class="btn btn-sm btn-shadow btn-primary confirm_schedule pull-right {{ $count > 0 ? "" : "d-none" }}">JTSS Sched Confirmed</button>
                                </div>
                            </div>

                            <div class="row p-3">
                                <div class="col-12">
                                    <div class="table-responsive pr_memo_table_div">
                                        <table class="table table-hover table-inverse" id="pr_memo_table">
                                            <thead class="thead-inverse">
                                                <tr>
                                                    <th>Lessor</th>
                                                    <th>Address</th>
                                                    <th>Latitude</th>
                                                    <th>Longitude</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>

                                    <div class="form_data d-none">
                                        <div class="row form_div d-none border-bottom pb-2">
                                            <div class="col-12" style="overflow-y: auto !important; max-height: calc(100vh - 210px);">
                                                <form class="ssds_form">
                                                    <div class="divider"></div>
                                                    <H5>Property Details</H5>
                                        
                                                    <div class="position-relative row form-group">
                                                        <label for="lessor" class="col-sm-4 col-form-label">Name of Owner</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="lessor" name="lessor" placeholder="Name of Owner" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="contact_number" class="col-sm-4 col-form-label">Contact Number</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="contact_number" name="contact_number" placeholder="Contact Number" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="address" class="col-sm-4 col-form-label">Street Address</label>
                                                        <div class="col-sm-8">
                                                            <textarea name="address" id="address" class="form-control" placeholder="Address" disabled></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="region" class="col-sm-4 col-form-label">Region</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="region" name="region" placeholder="Region" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="province" class="col-sm-4 col-form-label">Province</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="province" name="province" placeholder="Province" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="lgu" class="col-sm-4 col-form-label">City / Municipality</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="city" name="city" placeholder="City" disabled>
                                                        </div>
                                                    </div>
                                        
                                                    <div class="position-relative row form-group">
                                                        <label for="latitude" class="col-sm-4 col-form-label">Coordinates</label>
                                                        <div class="col-sm-4">
                                                            <input type="number" class="form-control" id="latitude" name="latitude" placeholder="Latitude" disabled>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <input type="number" class="form-control" id="longitude" name="longitude" placeholder="Longitude" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="distance_from_nominal_point" class="col-sm-4 col-form-label">Distance from Nominal Point</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="lessor" name="distance_from_nominal_point" placeholder="Distance from Nominal Point" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="site_type" class="col-sm-4 col-form-label">Site Type</label>
                                                        <div class="col-sm-8">                                                        
                                                            <input type="text" class="form-control" id="site_type" name="site_type" placeholder="Site Type" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="building_no_of_floors" class="col-sm-4 col-form-label">Building (No. of floors)</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="building_no_of_floors" name="building_no_of_floors" placeholder="Building (No. of floors)" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="area_size" class="col-sm-4 col-form-label">Area Size</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="area_size" name="area_size" placeholder="Area Size" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="lease_rate" class="col-sm-4 col-form-label">Lease Rate</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="lease_rate" name="lease_rate" placeholder="Lease Rate" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="property_use" class="col-sm-4 col-form-label">Property Use</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="property_use" name="property_use" placeholder="Property Use" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="right_of_way_access" class="col-sm-4 col-form-label">Right of Way Access</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="right_of_way_access" name="right_of_way_access" placeholder="Right of Way Access" disabled>
                                                        </div>
                                                    </div>
                                        
                                                    <div class="divider"></div>
                                                    <H5>Availability of Property Documents</H5>
                                                    <div class="position-relative row form-group">
                                                        <label for="certificate_of_title" class="col-sm-4 col-form-label">Certificate of Title</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="certificate_of_title" name="certificate_of_title" placeholder="Certificate of Title" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="tax_declaration" class="col-sm-4 col-form-label">Tax Declaration</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="tax_declaration" name="tax_declaration" placeholder="Tax Declaration" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="tax_clearance" class="col-sm-4 col-form-label">Tax Clearance</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="tax_clearance" name="tax_clearance" placeholder="Tax Clearance" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="mortgaged" class="col-sm-4 col-form-label">Mortgaged</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="mortgaged" name="mortgaged" placeholder="Mortgaged" disabled>
                                                        </div>
                                                    </div>
                                        
                                                    <div class="divider"></div>
                                                    <H5>Existing Telco in the Area</H5>
                                                    <div class="position-relative row form-group">
                                                        <label for="tower_structure" class="col-sm-4 col-form-label">Tower Structure</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="tower_structure" name="tower_structure" placeholder="Tower Structure" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="tower_height" class="col-sm-4 col-form-label">Tower Height</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="tower_height" name="tower_height" placeholder="Tower Height" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="swat_design" class="col-sm-4 col-form-label">Swat Design</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="swat_design" name="swat_design" placeholder="Swat Design" disabled>
                                                        </div>
                                                    </div>
                                        
                                                    <div class="divider"></div>
                                                    <H5>Social Acceptability</H5>
                                                    <div class="position-relative row form-group">
                                                        <label for="with_neighbors" class="col-sm-4 col-form-label">With Neighbors</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="with_neighbors" name="with_neighbors" placeholder="With Neighbors" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="with_history_of_opposition" class="col-sm-4 col-form-label">With History of Opposition</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="with_history_of_opposition" name="with_history_of_opposition" placeholder="With History of Opposition" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="with_hoa_restriction" class="col-sm-4 col-form-label">With HOA Restriction</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="with_hoa_restriction" name="with_hoa_restriction" placeholder="With HOA Restriction" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="with_brgy_restriction" class="col-sm-4 col-form-label">With Brgy Restriction</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="with_brgy_restriction" name="with_brgy_restriction" placeholder="With Brgy Restriction" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="with_lgu_restriction" class="col-sm-4 col-form-label">With LGU Restriction</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="with_lgu_restriction" name="with_lgu_restriction" placeholder="With LGU Restriction" disabled>
                                                        </div>
                                                    </div>
                                        
                                                    <div class="divider"></div>
                                                    <H5>Temporary Power</H5>
                                                    <div class="position-relative row form-group">
                                                        <label for="tap_to_lessor" class="col-sm-4 col-form-label">Tap to Lessor</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="tap_to_lessor" name="tap_to_lessor" placeholder="Tap to Lessor" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="tap_to_neighbor" class="col-sm-4 col-form-label">Tap to Neighbor</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="tap_to_neighbor" name="tap_to_neighbor" placeholder="Tap to Neighbor" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="distance_to_tapping_point" class="col-sm-4 col-form-label">Distance to Tapping Point</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="distance_to_tapping_point" name="distance_to_tapping_point" placeholder="Distance to Tapping Point" disabled>
                                                        </div>
                                                    </div>
                                        
                                                    <div class="divider"></div>
                                                    <H5>Permanent Power</H5>
                                        
                                                    <div class="position-relative row form-group">
                                                        <label for="meralco" class="col-sm-4 col-form-label">Meralco</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="meralco" name="meralco" placeholder="Meralco" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="localcoop" class="col-sm-4 col-form-label">Local COOP</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="localcoop" name="localcoop" placeholder="Local COOP" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="genset_availability" class="col-sm-4 col-form-label">Genset Availability</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="genset_availability" name="genset_availability" placeholder="Genset Availability" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="distance_to_nearby_transmission_line" class="col-sm-4 col-form-label">Distance to Nearby Transmission Line</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="distance_to_nearby_transmission_line" name="distance_to_nearby_transmission_line" placeholder="Distance to Nearby Transmission Line" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="distance_from_creek_river" class="col-sm-4 col-form-label">Distance from Creek/River</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="distance_from_creek_river" name="distance_from_creek_river" placeholder="Distance from Creek/River" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="distance_from_national_road" class="col-sm-4 col-form-label">Distance from National Road</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="distance_from_national_road" name="distance_from_national_road" placeholder="Distance from National Road" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="position-relative row form-group">
                                                        <label for="demolition_of_existing_structure" class="col-sm-4 col-form-label">Demolition of Existing Structure</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="demolition_of_existing_structure" name="demolition_of_existing_structure" placeholder="Tax Declaration" disabled>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-12">
                                                <button class="btn btn-sm btn-shadow btn-secondary hide_details" type="button">Hide Details</button>
                                            </div>
                                        </div>

                                        <div class="row set_schedule_form">
                                            <div class="col-12">
                                                <form class="set_schedule_form">
                                                    <div class="position-relative row form-group">
                                                        <div class="col-12">
                                                            <label for="jtss_schedule">JTSS Schedule</label>
                                                            <input type="date" class="flatpicker form-control" name="jtss_schedule" id="jtss_schedule">
                                                            <small class="text-danger jtss_schedule-error"></small>
                                                        </div>
                                                    </div>
                                                    <div class="text-center">
                                                        <a href="javascript:void(0)" class="show_details">Show details.</a>
                                                    </div>
                                                </form>
                                                <button class="btn btn-sm btn-shadow btn-primary set_schedule pull-right" type="button">Set Schedule</button>
                                                <button class="btn btn-sm btn-shadow btn-secondary back_to_table pull-right mr-1" type="button">Back to table</button>
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

<script>
    $(document).ready(function() {
        $('#pr_memo_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/get-site-candidate/" + "{{ $sam_id }}",
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
                { data: "address" },
                { data: "latitude" },
                { data: "longitude" },
                { data: "status" },
            ],
        });

        $(".flatpicker").flatpickr();

        $("input[name=jtss_schedule]").flatpickr(
            { 
            minDate: new Date()
            }
        );


        $("#pr_memo_table").on("click", "tr.add_schedule", function(e){
            e.preventDefault();
            $(".pr_memo_table_div").addClass("d-none");

            $(".form_data").removeClass("d-none");

            var id = $(this).attr('data-id');

            $(".set_schedule").attr("data-id", id);

            // $.ajax({
            //     url: "",
            //     method: "GET",
            //     success: function (resp) {
            //         if (!resp.error) {

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

        $(".show_details").on("click", function (){
            $(".form_div").removeClass("d-none");
            $(".set_schedule_form").addClass("d-none");
        });

        $(".hide_details").on("click", function (){
            $(".form_div").addClass("d-none");
            $(".set_schedule_form").removeClass("d-none");
        });

        $(".back_to_table").on("click", function (){
            $(".form_data").addClass("d-none");
            $(".pr_memo_table_div").removeClass("d-none");
        });

        $(".set_schedule").on("click", function (e){
            e.preventDefault();
            var id = $(this).attr('data-id');
            var jtss_schedule = $("#jtss_schedule").val();

            $(".set_schedule_form small").text("");
            $(".set_schedule_form input").removeClass("is-invalid");

            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            $.ajax({
                url: "/set-schedule",
                method: "POST",
                data: {
                    jtss_schedule : jtss_schedule,
                    id : id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp) {
                    if (!resp.error) {

                        $("#pr_memo_table").DataTable().ajax.reload(function () {
                            $(".back_to_table").trigger("click");

                            $("#jtss_schedule").val("");

                            $(".confirm_schedule").removeClass("d-none");
                            $(".set_schedule").removeAttr("disabled");
                            $(".set_schedule").text("Set Schedule");
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

                        $(".set_schedule").removeAttr("disabled");
                        $(".set_schedule").text("Set Schedule");
                    }
                },
                error: function (resp) {
                    
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )
                    $(".set_schedule").removeAttr("disabled");
                    $(".set_schedule").text("Set Schedule");
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