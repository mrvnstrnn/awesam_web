<div class="row border-bottom">
    <div class="col-12">
        <button class="btn_switch_back_to_actions btn btn-shadow btn-secondary btn-sm mb-3">Back to Actions</button>                                            
    </div>
</div>

<div class="row pt-4 pb-3">
    <div class="col-md-12">
        <H4 id="active_action">{{ $sub_activity }}</H4>
    </div>
</div>

<div class="row form_div">
    <div class="col-12">
        <div class="form_html"></div>
        <form class="site_data_form">
            <input type="hidden" name="sam_id" id="sam_id" value="{{ $sam_id }}">
            <input type="hidden" name="sub_activity_id" id="sub_activity_id" value="{{ $sub_activity_id }}">
            <input type="hidden" name="site_category" id="site_category" value="{{ $site_category }}">
            <input type="hidden" name="program_id" id="program_id" value="{{ $program_id }}">
            <input type="hidden" name="activity_id" id="activity_id" value="{{ $activity_id }}">
            <input type="hidden" name="form_generator_type" id="form_generator_type" value="savings computation">
        </form>
    </div>
</div>

<div class="row table_computation_div d-none">
</div>

<div class="row mt-3 mb-3">
    <div class="col-12">
        <div class="table_html"></div>
        <div class="file_div d-none">
            <div class="row">
                <div class="col-12">
                    <div class="file_viewer"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <button class="btn btn-lg btn-primary btn-shadow back_to_form">Back to form</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <button class="btn btn-shadow btn-lg btn-primary mark_as_complete" type="button">Mark as Complete</button> --}}

<script>
    $(".btn_switch_back_to_actions").on("click", function(){
        $("#actions_box").addClass('d-none');
        $("#actions_list").removeClass('d-none');
    });

    $(".form_html").on("click", ".save_savings_computation_btn", function () {
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        var exdeal_request = $("#exdeal_request").val();

        var sam_id = ["{{ $sam_id }}"];
        var activity_name = "mark_as_complete";
        var site_category = ["{{ $site_category }}"];
        var activity_id = ["{{ $activity_id }}"];
        var program_id = "{{ $program_id }}";

        $.ajax({
            url: "/get-form-generator-view",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: 
                    $('.savings_computation_form, .site_data_form').serialize()
            ,
            success: function (resp) {
                if (!resp.error) {
                    $(".table_computation_div").html(resp);


                    // console.log(resp.message);

                    // if( (typeof lrn === "object" || typeof lrn === 'function') && (lrn !== null) ) {



                    // } else {
                    //     Swal.fire(
                    //         'Error',
                    //         "Can't process this right now.",
                    //         'error'
                    //     )
                    // }
                    
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


        $(".form_div").addClass("d-none");
        $(".table_computation_div").removeClass("d-none");
    });

    $(document).on("click", ".back_to_form", function () {
        $(".form_div").removeClass("d-none");
        $(".table_computation_div").addClass("d-none");
    });

    $(".table_computation_div").on("click", ".save_computation", function () {
        
        $(".save_computation").attr("disabled", "disabled");
        $(".save_computation").text("Processing...");

        $.ajax({
            url: "/save-saving-computation",
            method: "POST",
            data: $(".savings_computation_form, .site_data_form").serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp) {
                if (!resp.error) {
                    
                    $(".table_uploaded").DataTable().ajax.reload(function () {
                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )

                        $(".save_computation").removeAttr("disabled");
                        $(".save_computation").text("Save Computation");

                        $(".action_to_complete_child"+"{{ $sub_activity_id }}"+" i.text-success").remove();

                        $(".action_to_complete_parent .action_to_complete_child"+"{{ $sub_activity_id }}").append(
                            '<i class="fa fa-check-circle fa-lg text-success" style="right: 20px"></i>'
                        );

                        $(".back_to_form").trigger("click");

                    });
                } else {
                    
                    Swal.fire(
                        'Error',
                        resp.message,
                        'error'
                    )

                    $(".save_computation").removeAttr("disabled");
                    $(".save_computation").text("Save Computation");
                }
            },
            error: function (resp) {

                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )

                $(".save_computation").removeAttr("disabled");
                $(".save_computation").text("Save Computation");
            }
        });
    });

    $(document).ready(function(){

        $.ajax({
            url: "/get-form/" + "{{ $sub_activity_id }}" + "/" + "{{ $sub_activity }}",
            method: "GET",
            // headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            // },
            success: function (resp) {
                if (!resp.error) {
                    $(".form_html").html(resp.message);

                    lrn = JSON.parse( JSON.parse( JSON.stringify("{{ \Auth::user()->get_lrn($sam_id, 'lrn') }}".replace(/&quot;/g,'"')) ) );
                    var get_program_renewal_old = JSON.parse("{{ json_encode(\Auth::user()->get_program_renewal_old($sam_id)); }}".replace(/&quot;/g,'"'));
// console.log(get_program_renewal_old);
                    $("input[type=number]").val(0);
                    $.each(get_program_renewal_old, function(index, data) {
                        // console.log(index);
                        if (index == 'rate_old') {
                            $(".savings_computation_form #old_terms_monthly_contract_amount").val(data == null || data == "" || data == "NULL" ? 0 : data);
                        } else if (index == 'escalation_old') {
                            $(".savings_computation_form #old_terms_escalation_rate").val(data == null || data == "" || data == "NULL" ? 0 : data);
                        }
                    });

                    $(".savings_computation_form #old_exdeal_amount").val(1);

                    if( (typeof lrn === "object" || typeof lrn === 'function') && (lrn !== null) ) {
                        $.each(lrn, function(index, data) {
                            $(".savings_computation_form #"+index).val(data);

                            if ( index == "lessor_demand_monthly_contract_amount" ) {
                                $(".savings_computation_form #new_terms_monthly_contract_amount").val(data);
                            } else if ( index == "lessor_demand_escalation_rate" ) {
                                $(".savings_computation_form #new_terms_escalation_rate").val(data);
                            } else if ( index == "lessor_demand_escalation_year" ) {
                                $(".savings_computation_form #new_terms_escalation_year").val(data);
                            } else if ( index == "lessor_demand_exdeal_request" ) {
                                $(".savings_computation_form #new_terms_exdeal_request").val(data);
                            } else if ( index == "old_exdeal_particulars" ) {
                                $(".savings_computation_form #new_terms_exdeal_particulars").val(data);
                            }
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            "Can't process this right now.",
                            'error'
                        )
                    }
                    
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

    $(".form_html").on("change", "#old_terms_escalation_rate, #new_terms_escalation_rate", function(e){
        if ($(this).val() > 0 && $(this).val() < 101) {
            var percent = $(this).val() / 100;

            $(this).val(percent);
        } else if ($(this).val() > 101) {
            $(this).val(1);
        }
    });

    $(".table_html").html(
        '<div class="table-responsive table_uploaded_parent">' +
            '<table class="table_uploaded align-middle mb-0 table table-borderless table-striped table-hover w-100">' +
                '<thead>' +
                    '<tr>' +
                        '<th style="width: 5%">#</th>' +
                        '<th style="width: 35%">Filename</th>' +
                        '<th style="width: 15%">Status</th>' +
                        '<th style="width: 35%">Reason</th>' +
                        '<th>Date Uploaded</th>' +
                    '</tr>' +
                '</thead>' +
            '</table>' +
        '</div>'
    );

    if (! $.fn.DataTable.isDataTable(".table_uploaded") ){   
        $(".table_uploaded").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/get-uploaded-files/" + "{{ $sub_activity_id }}" + "/" + "{{ $sam_id }}",
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
                { data: "id" },
                { data: "value" },
                { data: "status" },
                { data: "reason" },
                { data: "date_created" },
            ],
        });
    } else {
        $(".table_uploaded").DataTable().ajax.reload();
    }

    $(".file_div").on("click", ".back_to_form", function () {
        $(".table_html").removeClass("d-none");
        $(".form_html").removeClass("d-none");
        $(".file_div").addClass("d-none");
    });

    $(".table_html").on("click", ".table_uploaded tr td", function () {

        var extensions = ["pdf", "jpg", "png"];

        var values = $(this).parent().attr('data-value');

        if( extensions.includes(values.split('.').pop()) == true) {     
            htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 400px; height: 100%" src="/ViewerJS/#../files/' + values + '" allowfullscreen></iframe>';
        } else {
            htmltoload = '<div class="text-center my-5"><a href="/files/' + values + '"><i class="fa fa-fw display-1" aria-hidden="true" title="Copy to use file-excel-o"></i><H5>Download Document</H5></a><small>No viewer available; download the file to check.</small></div>';
        }

        $(".file_viewer").html(htmltoload);

        $(".table_html").addClass("d-none");
        $(".form_html").addClass("d-none");
        $(".file_div").removeClass("d-none");
    });

</script>