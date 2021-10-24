<div class="row border-bottom">
    <div class="col-12">
        <button class="btn_switch_back_to_actions btn btn-shadow btn-secondary btn-sm mb-3">Back to Actions</button>                                            
        <button class="btn_switch_back_to_candidates d-none btn btn-shadow btn-secondary btn-sm mb-3">Back to Site Options</button>                                            
    </div>
</div>

<div class="row">
    <div class="col-12">
        <H3 class="mt-3">{{ $sub_activity }}</H3>
        <hr>
        <div class="aepm_table_div pt-4 pb-3">
            <table class="table table-hover table-inverse" id="aepm_table">
                <thead class="thead-inverse">
                    <tr>
                        <th>Ranking</th>
                        <th>Lessor</th>
                        <th>SAQ Start</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
            <hr>
            <div class="text-right">
            <button class="ml-2  btn-lg btn btn-success submit_to_ram">Request Approval</button>
            </div>
        </div>
        <div class="form_data d-none">
            <form class="ssds_form pt-3">
                <input type="hidden" name="sam_id" id="sam_id" value="{{ $sam_id }}">
                <input type="hidden" name="sub_activity_id" id="sub_activity_id" value="{{ $sub_activity_id }}">
                <input type="hidden" name="program_id" id="program_id" value="{{ $program_id }}">
                <input type="hidden" name="site_category" id="site_category" value="{{ $site_category }}">
                <input type="hidden" name="activity_id" id="activity_id" value="{{ $activity_id }}">
                <input type="hidden" name="id" id="id">
                <div class="position-relative row form-group">
                    <label for="lessor" class="col-sm-4 col-form-label">Lessor Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="lessor" name="lessor" placeholder="Name of Owner">
                        <small class="text-danger lessor-errors"></small>
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="contact_number" class="col-sm-4 col-form-label">Contact Details</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="contact_number" name="contact_number" placeholder="">
                        <small class="text-danger contact_number-errors"></small>
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="bank_details" class="col-sm-4 col-form-label">Bank Details</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="bank_details" name="bank_details" placeholder="">
                        <small class="text-danger bank_details-errors"></small>
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="lease_term" class="col-sm-4 col-form-label">Lease Term</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="lease_term" name="lease_term" placeholder="">
                        <small class="text-danger lease_term-errors"></small>
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="lease_rate" class="col-sm-4 col-form-label">Lease Amount</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="lease_rate" name="lease_rate" placeholder="">
                        <small class="text-danger lease_rate-errors"></small>
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="escalation_rate" class="col-sm-4 col-form-label">Escalation Rate</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="escalation_rate" name="escalation_rate" placeholder="">
                        <small class="text-danger lessor-errors"></small>
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="escalation_year" class="col-sm-4 col-form-label">Escalation Year</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="escalation_year" name="escalation_year" placeholder="">
                        <small class="text-danger escalation_year-errors"></small>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="position-relative row form-group">
                    <label for="security_deposit" class="col-sm-4 col-form-label">Security Deposit (# of mos)</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="security_deposit" name="security_deposit" placeholder="">
                        <small class="text-danger security_deposit-errors"></small>
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="advance_rental" class="col-sm-4 col-form-label">Advance Rental (# of mos)</label>
                    <div class="col-sm-8">
                        <input type="numnber" class="form-control" id="advance_rental" name="advance_rental" placeholder="">
                        <small class="text-danger lessor-errors"></small>
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="commencement_date" class="col-sm-4 col-form-label">Commencement Date</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="commencement_date" name="commencement_date" placeholder="">
                        <small class="text-danger commencement_date-errors"></small>
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="row_agreement" class="col-sm-4 col-form-label">Row Agreement</label>
                    <div class="col-sm-8">  
                        <select class="form-control" id="row_agreement" name="row_agreement">
                            <option value="">Select ROW Agreement</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                        <small class="text-danger row_agreement-errors"></small>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="position-relative row form-group">
                    <label for="site_type" class="col-sm-4 col-form-label">Site Type</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="site_type" name="site_type">
                            <option value="">Select Site Type </option>
                            <option value="New">New</option>
                            <option value="SMC">SMC</option>
                            <option value="Bayan">Bayan</option>
                        </select>
                        <small class="text-danger site_type-errors"></small>
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="site_type" class="col-sm-4 col-form-label">Classification</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="site_type" name="site_type">
                            <option value="">Select Classification</option>
                            <option value="rooftop">Rooftop</option>
                            <option value="greenfield">Greenfield</option>
                        </select>
                        <small class="text-danger site_type-errors"></small>
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="property_classification" class="col-sm-4 col-form-label">Property Classification</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="property_classification" name="property_classification">
                            <option value="">Select Property Classification</option>
                            <option value="HOA">HOA</option>
                            <option value="Non-HOA">Non-HOA</option>
                            <option value="Under Ancestral Domain">Under Ancestral Domain</option>
                            <option value="DENR Property">DENR Property</option>
                            <option value="Agriculturan Land">Agriculturan Land</option>
                            <option value="Under Palawan">Under Palawan</option>
                        </select>
                        <small class="text-danger property_classification-errors"></small>
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="latitude" class="col-sm-4 col-form-label">Final Latitude</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="latitude" name="latitude">
                        <small class="text-danger latitude-errors"></small>
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="longitude" class="col-sm-4 col-form-label">Final Longitude</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="longitude" name="longitude">
                        <small class="text-danger longitude-errors"></small>
                    </div>
                </div>
                <div class="position-relative row form-group ">
                    <div class="col border-top pt-3 text-right">
                        <button class="ml-2  mt-2 mb-2 btn btn-primary save_lease" type="button">Save Lease Details</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
function load_ssds(id){
    $('.ssds_form')[0].reset();

    $(".set_schedule").attr("data-id", id);
    $(".form_data").removeClass("d-none");
    $(".aepm_table_div").addClass("d-none");

    $(".btn_switch_back_to_actions").addClass("d-none");
    $(".btn_switch_back_to_candidates").removeClass("d-none");
        

    $(".set_schedule").attr("data-id", id);


    $.ajax({
        url: "/get-sub-activity-value/" + id,
        method: "GET",
        success: function (resp) {
            if (!resp.error) {


                var json = JSON.parse(resp.message.value);
                
                console.log(json);

                $.each(json, function(index, data) {

                    if(index == 'site_type'){
                        $("#"+index + " > [value=" + data + "]").attr("selected", "true");
                    }

                    $("#"+index).val(data).change();
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
}        


$(document).ready(function() {


    $(".btn_switch_back_to_actions").on("click", function(){
        $("#actions_box").addClass('d-none');
        $("#actions_list").removeClass('d-none');
    });

    $(".btn_switch_back_to_candidates").on("click", function(e){
            e.preventDefault();

            $(".btn_switch_back_to_actions").removeClass("d-none");
            $(".btn_switch_back_to_candidates").addClass("d-none");

            $(".form_data").addClass("d-none");
            $(".aepm_table_div").removeClass("d-none");

    });


    $('#aepm_table').DataTable({
            processing: true,
            serverSide: true,
            select: true,
            order: [ 1, "asc" ],
            ajax: {
                url: "/get-site-candidate/" + "{{ $sam_id }}" + "/assds_lease_rate",
                type: 'GET'
            },
            dataSrc: function(json){
                return json.data;
            },
            'createdRow': function( row, data, dataIndex ) {
                // $(row).attr('data-id', data.id);
                $(row).attr('data-id', JSON.parse(data.value.replace(/&quot;/g,'"')).id );
                $(row).addClass('add_schedule');
                $(row).attr('style', 'cursor: pointer;');
            },
            columns: [
                { data: "distance", className: "text-left" },
                { data: "lessor" },
                { data: "distance", className: "text-center", render: function(row){
                    toggle_button = '';                    
                    return toggle_button;
                }},
                { data: "distance", className: "text-center", render: function(row){
                    toggle_button = 'Details Complete';                    
                    return toggle_button;
                }},
                { data: "distance", className: "text-right", render: function(row){
                    toggle_button = '<div>' +
                                    '<button class="ml-2 mb-2 mt-2 btn btn-primary ssds-details">Lease Details</button>'  +
                                    '</div>';                    
                    return toggle_button;
                }},
            ],
            rowCallback: function ( row, data ) {

                    $('.ssds-details', row).on( 'click', function(row, xdata){
                        load_ssds(data.id);
                    });
            },


            "initComplete": function( settings, json){
            }

    }); 

    $(".submit_to_ram").on("click", function() {
        $(".submit_to_ram").attr("disabled", "disabled");
        $(".submit_to_ram").text("Processing...");

        var sam_id = ["{{ $sam_id }}"];
        var sub_activity_id = "{{ $sub_activity_id }}";
        var activity_name = "{{ $sub_activity }}";
        var site_category = ["{{ $site_category }}"];
        var activity_id = ["{{ $activity_id }}"];
        var program_id = "{{ $program_id }}";

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

                    $(".submit_to_ram").removeAttr("disabled");
                    $(".submit_to_ram").text("Request Approval");

                    $("#viewInfoModal").modal("hide");
                } else {
                    Swal.fire(
                        'Error',
                        resp.message,
                        'error'
                    )

                    $(".submit_to_ram").removeAttr("disabled");
                    $(".submit_to_ram").text("Request Approval");
                }
            },
            error: function (resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )

                $(".submit_to_ram").removeAttr("disabled");
                $(".submit_to_ram").text("Request Approval");
            }
        });

    });


});
</script>