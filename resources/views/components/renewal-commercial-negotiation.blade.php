<div class="row border-bottom">
    <div class="col-6">
        <button class="btn_switch_back_to_actions btn btn-shadow btn-secondary btn-sm mb-3">Back to Actions</button>                                            
    </div>
</div>

<div class="row pt-4">
    <div class="col-md-12">
        <H5 id="active_action">{{ $sub_activity }}</H5>
    </div>
</div>

<div id="action_lessor_engagement">
    <div class="row" id="control_box">
        <div class="col-md-3 col-sm-6 col-xs-6 my-3 text-center contact-lessor" data-value="Call">
            <i class="fa fa-phone fa-4x" aria-hidden="true" title=""></i>
            <div class="pt-3"><small>Call</small></div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-6 my-3 text-center contact-lessor" data-value="Text">
            <i class="fa fa-mobile fa-4x" aria-hidden="true" title=""></i>
            <div class="pt-3"><small>Text</small></div>
        </div>
        <div class="col-md-3 col-sm-6 my-3 text-center contact-lessor" data-value="Email">
            <i class="fa fa-envelope fa-4x" aria-hidden="true" title=""></i>
            <div class="pt-3"><small>Email</small></div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-6 my-3 text-center contact-lessor" data-value="Site Visit">
            <i class="fa fa-location-arrow fa-4x" aria-hidden="true" title=""></i>
            <div class="pt-3"><small>Site Visit</small></div>

        </div>
    </div>
    <div class="row d-none" id="control_form">
        <div class="col-12 py-3">
            <div class="form_html"></div>
        </div>

    </div>
    <div class="row">
        <div class="col-12 table-responsive table_lessor_engage_parent">
        </div>
    </div>
</div>

<div class="row d-none">
    <div class="col-12">
        <form class="site_data_form">
            <input type="hidden" name="sam_id" id="sam_id" value="{{ $sam_id }}">
            <input type="hidden" name="sub_activity_id" id="sub_activity_id" value="{{ $sub_activity_id }}">
            <input type="hidden" name="site_category" id="site_category" value="{{ $site_category }}">
            <input type="hidden" name="program_id" id="program_id" value="{{ $program_id }}">
            <input type="hidden" name="activity_id" id="activity_id" value="{{ $activity_id }}">
        </form>
    </div>
</div>

<script>
    $(".btn_switch_back_to_actions").on("click", function(){
        $("#actions_box").addClass('d-none');
        $("#actions_list").removeClass('d-none');
    });

    // cancel_commercial_negotiation_btn

    var sub_activity_id = "{{ $sub_activity_id }}";
    var sam_id = "{{ $sam_id }}";

    htmllist = '<table class="table_uploaded align-middle mb-0 table table-borderless table-striped table-hover w-100">' +
                    '<thead>' +
                        '<tr>' +
                            '<th style="width: 5%">#</th>' +
                            '<th>Method</th>' +
                            '<th>Contract Rate</th>' +
                            '<th>Escalation Rate</th>' +
                            '<th>Escalation Year</th>' +
                            '<th>Advance Rent Months</th>' +
                            '<th>Date Created</th>' +
                        '</tr>' +
                    '</thead>' +
                '</table>';

    $('.table_lessor_engage_parent').html(htmllist);
    $(".table_uploaded").attr("id", "table_lessor_engage_"+sub_activity_id);

    if (! $.fn.DataTable.isDataTable("#table_lessor_engage_"+sub_activity_id) ){
        $("#table_lessor_engage_"+sub_activity_id).DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/get-commercial-engagement/"+sub_activity_id+"/"+sam_id,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            dataSrc: function(json){
                return json.data;
            },
            columns: [
                { data: "id" },
                { data: "method" },
                { data: "lessor_demand_contract_rate" },
                { data: "lessor_demand_escalation_rate" },
                { data: "lessor_demand_escalation_year" },
                { data: "lessor_demand_advance_rent_months" },
                { data: "date_created" },
            ],
        });
    } else {
        $("#table_lessor_engage_"+sub_activity_id).DataTable().ajax.reload();
    }

    $(document).on("click", ".contact-lessor", function(){
        $('#control_box').addClass('d-none');
        $('#control_form').removeClass('d-none');

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;

        var value = $(this).attr("data-value");
        
        $.ajax({
            url: "/get-form/" + "{{ $sub_activity_id }}" + "/" + "{{ $sub_activity }}",
            method: "GET",
            success: function (resp) {
                if (!resp.error) {
                    $(".form_html").html(resp.message);

                    $("#method").val(value);
                    $("#date").val(today);
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
            }
        });
    });

    $(".form_html").on("click", ".save_commercial_negotiation_btn", function () {
        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        $(".commercial_negotiation_form small").text("");

        var method = $("#method").val();
        var today = $("#date").val();

        $.ajax({
            url: "/save-commecial-negotiation",
            method: "POST",
            data: $(".commercial_negotiation_form, .site_data_form").serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp) {
                if (!resp.error) {
                    $('#table_lessor_engage_'+sub_activity_id).DataTable().ajax.reload(function (){
                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )

                        $(".commercial_negotiation_form")[0].reset();

                        $("#method").val(method);
                        $("#date").val(today);
                        if ( $("#approval").val() == "Approval Secured" ) {
                            $("#viewInfoModal").modal("hide");
                        }

                        $(".save_commercial_negotiation_btn").removeAttr('disabled');
                        $(".save_commercial_negotiation_btn").text('Save Commercial Negotiation');
                    });
                } else {
                    
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $(".commercial_negotiation_form ." + index + "-error").text(data);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }
                    
                    $(".save_commercial_negotiation_btn").removeAttr('disabled');
                    $(".save_commercial_negotiation_btn").text('Save Commercial Negotiation');
                }
            },
            error: function (resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )
                
                $(".save_commercial_negotiation_btn").removeAttr('disabled');
                $(".save_commercial_negotiation_btn").text('Save Commercial Negotiation');
            }
        });
    });

</script>