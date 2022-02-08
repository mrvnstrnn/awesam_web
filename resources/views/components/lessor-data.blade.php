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
        <div class="aepm_table_div pt-4">
            <table class="table table-hover table-inverse" id="aepm_table">
                <thead class="thead-inverse">
                    <tr>
                        <th>Ranking</th>
                        <th>Lessor</th>
                        <th>Active Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
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
                    <label for="lessor" class="col-sm-4 col-form-label">Contact Details</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="lessor" name="lessor" placeholder="">
                        <small class="text-danger lessor-errors"></small>
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
                    <label for="lease_amount" class="col-sm-4 col-form-label">Lease Amount</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="lease_amount" name="lease_amount" placeholder="">
                        <small class="text-danger lease_amount-errors"></small>
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
                    <label for="classification" class="col-sm-4 col-form-label">Classification</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="classification" name="classification">
                            <option value="">Select Classificatio </option>
                            <option value="Rooftop">Rooftop</option>
                            <option value="Greenfield">Greenfield</option>
                        </select>
                        <small class="text-danger classification-errors"></small>
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
                    <label for="final_latitude" class="col-sm-4 col-form-label">Final Latitude</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="final_latitude" name="final_latitude">
                        <small class="text-danger final_latitude-errors"></small>
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="final_longitude" class="col-sm-4 col-form-label">Final Longitude</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="final_longitude" name="final_longitude">
                        <small class="text-danger final_longitude-errors"></small>
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
        url: "/get-ssds-schedule/" + id,
        method: "GET",
        success: function (resp) {
            if (!resp.error) {
                var json = JSON.parse(resp.message.value);
                if (resp.message != null) {
                    $("#jtss_schedule").val(json.jtss_schedule);
                } else {
                    $("#jtss_schedule").val("");
                }

                if (resp.is_null == 'yes') {
                    $("#id").val(resp.message.id);
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
                type: "POST",
                data: {
                    sam_id : sam_id,
                    status : status,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
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
                { data: "lessor" },
                { data: "distance", className: "text-center", render: function(row){
                    toggle_button = '<div>' +
                                    '<div class="toggle btn btn-success" data-toggle="toggle" role="button" ' +
                                        'style="width: 120px; height: 23px;"><input type="checkbox" checked="" data-toggle="toggle" data-onstyle="success">' +
                                        '<div class="toggle-group">' +
                                            '<label for="" class="btn btn-success toggle-on">Active Nego</label>' +
                                            '<label for="" class="btn btn-light toggle-off">No</label>' +
                                            '<span class="toggle-handle btn btn-light"></span><' +
                                        '/div>' + 
                                    '</div>' +
                                    '</div>';                    
                    return toggle_button;
                }},
                { data: "distance", className: "text-right", render: function(row){
                    toggle_button = '<div>' +
                                    '<button class="ml-2 mb-2 mt-2 btn btn-primary ssds-details">Set Lessor Data</button>'  +
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


});
</script>