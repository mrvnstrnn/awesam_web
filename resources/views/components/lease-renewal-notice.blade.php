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

<div class="row">
    <div class="col-12">
        <div class="form_html"></div>
        <form class="site_data_form">
            <input type="hidden" name="sam_id" id="sam_id" value="{{ $sam_id }}">
            <input type="hidden" name="sub_activity_id" id="sub_activity_id" value="{{ $sub_activity_id }}">
            <input type="hidden" name="site_category" id="site_category" value="{{ $site_category }}">
            <input type="hidden" name="program_id" id="program_id" value="{{ $program_id }}">
            <input type="hidden" name="activity_id" id="activity_id" value="{{ $activity_id }}">
        </form>
    </div>
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

<script>
    $(".btn_switch_back_to_actions").on("click", function(){
        $("#actions_box").addClass('d-none');
        $("#actions_list").removeClass('d-none');
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

                    // var get_program_renewal = JSON.parse("{{ json_encode(\Auth::user()->get_program_renewal($sam_id)); }}".replace(/&quot;/g,'"'));

                    var commercial_nego = JSON.parse("{{ json_decode(json_encode(\Auth::user()->get_lrn($sam_id, 'lessor_commercial_engagement'))); }}".replace(/&quot;/g,'"'));

                    $(".create_lease_renewal_notice_form #representative").val("{{ \Auth::user()->name }}");

                    // $.each(get_program_renewal, function(index, data) {
                    //     $(".create_lease_renewal_notice_form #"+index).val(data);

                    //     if (index == 'site_address') {
                    //         $(".create_lease_renewal_notice_form #lease_premises").val(data);
                    //     }
                    // });

                    $.each(commercial_nego, function(index, data) {
                        $(".create_lease_renewal_notice_form #"+index).val(data);
                        if (index == 'facility_site_address') {
                            $(".create_lease_renewal_notice_form #lease_premises").val(data);
                        }
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
            }
        });
    });

    $(".form_html").on("click", ".save_create_lease_renewal_notice_btn", function() {
        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        $(".create_lease_renewal_notice_form small").text("");

        $.ajax({
            url: "/save-lrn",
            method: "POST",
            data: $(".create_lease_renewal_notice_form, .site_data_form").serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp) {
                if (!resp.error){

                    $(".table_uploaded").DataTable().ajax.reload(function () {
                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )

                        // $(".create_lease_renewal_notice_form")[0].reset();

                        $(".action_to_complete_child"+"{{ $sub_activity_id }}"+" i.text-success").remove();

                        $(".action_to_complete_parent .action_to_complete_child"+"{{ $sub_activity_id }}").append(
                            '<i class="fa fa-check-circle fa-lg text-success" style="right: 20px"></i>'
                        );

                        $(".save_create_lease_renewal_notice_btn").removeAttr("disabled");
                        $(".save_create_lease_renewal_notice_btn").text("Create LRN");

                        $("#lrn").val("");
                        $("#final_negotiated_amount").val("");
                        $("#final_negotiated_advance_rent_months").val("");
                        $("#final_negotiated_advance_rent_amount").val("");
                        $("#other_conditions").val("");

                        $("#to_be_applied_on").val("");
                        $("#number_of_months_advance").val("");
                        $("#consideration_for_otp_only").val("");

                        $(".back_to_form").trigger("click");
                    });

                    // $(".btn_switch_back_to_actions").trigger("click");
                    // $("#viewInfoModal").modal("hide");
                } else {

                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $(".create_lease_renewal_notice_form ." + index + "-error").text(data);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }

                    $(".save_create_lease_renewal_notice_btn").removeAttr("disabled");
                    $(".save_create_lease_renewal_notice_btn").text("Create LRN");
                }
            },
            error: function (resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )

                $(".save_create_lease_renewal_notice_btn").removeAttr("disabled");
                $(".save_create_lease_renewal_notice_btn").text("Create LRN");
            }
        });
    });

    $(".form_html").on("change", "#new_terms_start_date, #new_lease_terms_in_years", function(e){
        var new_lease_terms_in_years = $("#new_lease_terms_in_years").val();
        var new_terms_start_date = $("#new_terms_start_date").val();
        if ( new_lease_terms_in_years != null && new_terms_start_date != null ) {
            var new_lease_terms_in_years = $("#new_lease_terms_in_years").val();
            var new_terms_start_date = new Date($("#new_terms_start_date").val());

            new_date = new_terms_start_date.setFullYear(new_terms_start_date.getFullYear() + +new_lease_terms_in_years);

            new_new_terms_start_date = new Date(new_date)

            date_day = (new_new_terms_start_date.getDate()) < 10 ? "0" + (new_new_terms_start_date.getDate()) : new_new_terms_start_date.getDate() ;
            let formatted_new_date =  new_new_terms_start_date.getFullYear() + "-" + ( new_new_terms_start_date.getMonth() + 1 ) + "-" + date_day;

            $("#new_terms_end_date").val(formatted_new_date);
        }
    });

    $(".form_html").on("change", "#escalation_rate", function(e){
        if ($(this).val() > 0 && $(this).val() < 101) {
            var percent = $(this).val() / 100;

            $(this).val(percent);
        } else if ($(this).val() > 101) {
            $(this).val(1);
        }
    });

    $(".form_html").on("change", "#final_negotiated_amount, #final_negotiated_advance_rent_months", function () {
        var final_negotiated_amount = $("#final_negotiated_amount").val();

        console.log(final_negotiated_amount);

        var final_negotiated_advance_rent_months = $("#final_negotiated_advance_rent_months").val();

        $("#final_negotiated_advance_rent_amount").val( final_negotiated_advance_rent_months * final_negotiated_amount );
        
    });

    $(".form_html").on("change", "#lessor_demand_advance_rent_months, #lessor_demand_monthly_contract_amount", function () {
        var lessor_demand_advance_rent_months = $("#lessor_demand_advance_rent_months").val();

        var lessor_demand_monthly_contract_amount = $("#lessor_demand_monthly_contract_amount").val();

        $("#lessor_demand_advance_rent_amount").val( lessor_demand_monthly_contract_amount * lessor_demand_advance_rent_months );
        
    });

    // $(".mark_as_complete").on("click", function() {
    //     $("#submit_not_assds").attr("disabled", "disabled");
    //     $("#submit_not_assds").text("Processing...");

    //     $("#submit_assds").attr("disabled", "disabled");
    //     $("#submit_assds").text("Processing...");

    //     var sam_id = ["{{ $sam_id }}"];
    //     var sub_activity_id = "{{ $sub_activity_id }}";
    //     var activity_name = "mark_as_complete";
    //     var site_category = ["{{ $site_category }}"];
    //     var activity_id = ["{{ $activity_id }}"];
    //     var program_id = "{{ $program_id }}";

    //     $.ajax({
    //         url: "/accept-reject-endorsement",
    //         method: "POST",
    //         data: {
    //             sam_id : sam_id,
    //             sub_activity_id : sub_activity_id,
    //             activity_name : activity_name,
    //             site_category : site_category,
    //             activity_id : activity_id,
    //             program_id : program_id,
    //         },
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: function (resp) {
    //             if (!resp.error){
    //                 Swal.fire(
    //                     'Success',
    //                     resp.message,
    //                     'success'
    //                 )

    //                 $("#submit_not_assds").removeAttr("disabled");
    //                 $("#submit_not_assds").text("Mark as Complete");

    //                 $("#viewInfoModal").modal("hide");
    //             } else {
    //                 Swal.fire(
    //                     'Error',
    //                     resp.message,
    //                     'error'
    //                 )

    //                 $("#submit_not_assds").removeAttr("disabled");
    //                 $("#submit_not_assds").text("Mark as Complete");
    //             }
    //         },
    //         error: function (resp) {
    //             Swal.fire(
    //                 'Error',
    //                 resp,
    //                 'error'
    //             )

    //             $("#submit_not_assds").removeAttr("disabled");
    //             $("#submit_not_assds").text("Mark as Complete");
    //         }
    //     });

    // });
</script>