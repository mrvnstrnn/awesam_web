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

                    $(".btn_switch_back_to_actions").trigger("click");
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

                    $.each(get_program_renewal_old, function(index, data) {
                        // console.log(index);
                        if (index == 'rate_old') {
                            $(".savings_computation_form #old_terms_monthly_contract_amount").val(data);
                        } else if (index == 'escalation_old') {
                            $(".savings_computation_form #old_terms_escalation_rate").val(data);
                        } else if (index == 'tco_old') {
                            $(".savings_computation_form #old_exdeal_amount").val(data);
                        }
                    });

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


    // $(document).on("click", ".mark_as_complete", function() {
    //     $(this).attr("disabled", "disabled");
    //     $(".mark_as_complete").text("Processing...");

    //     var sam_id = ["{{ $sam_id }}"];
    //     var activity_name = "mark_as_complete";
    //     var site_category = ["{{ $site_category }}"];
    //     var activity_id = ["{{ $activity_id }}"];
    //     var program_id = "{{ $program_id }}";

    //     $.ajax({
    //         url: "/accept-reject-endorsement",
    //         method: "POST",
    //         data: {
    //             sam_id : sam_id,
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

    //                 $(".mark_as_complete").removeAttr("disabled");
    //                 $(".mark_as_complete").text("Mark as Complete");

    //                 $("#viewInfoModal").modal("hide");
    //             } else {
    //                 Swal.fire(
    //                     'Error',
    //                     resp.message,
    //                     'error'
    //                 )

    //                 $(".mark_as_complete").removeAttr("disabled");
    //                 $(".mark_as_complete").text("Mark as Complete");
    //             }
    //         },
    //         error: function (resp) {
    //             Swal.fire(
    //                 'Error',
    //                 resp,
    //                 'error'
    //             )

    //             $(".mark_as_complete").removeAttr("disabled");
    //             $(".mark_as_complete").text("Mark as Complete");
    //         }
    //     });

    // });
</script>