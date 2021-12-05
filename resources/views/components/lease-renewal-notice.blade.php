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

<script>
    $(".btn_switch_back_to_actions").on("click", function(){
        $("#actions_box").addClass('d-none');
        $("#actions_list").removeClass('d-none');
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

                    var get_program_renewal = JSON.parse("{{ json_encode(\Auth::user()->get_program_renewal($sam_id)); }}".replace(/&quot;/g,'"'));

                    var commercial_nego = JSON.parse("{{ json_decode(json_encode(\Auth::user()->get_lrn($sam_id, 'lessor_commercial_engagement'))); }}".replace(/&quot;/g,'"'));

                    $(".create_lease_renewal_notice_form #representative").val("{{ \Auth::user()->name }}");

                    // $.each(get_program_renewal, function(index, data) {
                    //     $(".create_lease_renewal_notice_form #"+index).val(data);

                    //     if (index == 'site_address') {
                    //         $(".create_lease_renewal_notice_form #lease_premises").val(data);
                    //     }
                    // });

                    $.each(commercial_nego, function(index, data) {
                        console.log(index + " - " + data);
                        $(".create_lease_renewal_notice_form #"+index).val(data);
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
                    Swal.fire(
                        'Success',
                        resp.message,
                        'success'
                    )

                    $(".create_lease_renewal_notice_form")[0].reset();

                    $(".action_to_complete_child"+"{{ $sub_activity_id }}"+" i.text-success").remove();

                    $(".action_to_complete_parent .action_to_complete_child"+"{{ $sub_activity_id }}").append(
                        '<i class="fa fa-check-circle fa-lg text-success" style="right: 20px"></i>'
                    );

                    $(".save_create_lease_renewal_notice_btn").removeAttr("disabled");
                    $(".save_create_lease_renewal_notice_btn").text("Create LRN");

                    $(".btn_switch_back_to_actions").trigger("click");
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

    $(".form_html").on("change", "#start_date, #lease_term", function(e){
        var lease_term = $("#lease_term").val();
        var start_date = $("#start_date").val();
        if ( lease_term != null && start_date != null ) {
            var lease_term = $("#lease_term").val();
            var start_date = new Date($("#start_date").val());

            new_date = start_date.setFullYear(start_date.getFullYear() + +lease_term);

            new_start_date = new Date(new_date)

            date_day = (new_start_date.getDate()) < 10 ? "0" + (new_start_date.getDate()) : new_start_date.getDate() ;
            let formatted_new_date =  new_start_date.getFullYear() + "-" + ( new_start_date.getMonth() + 1 ) + "-" + date_day;

            $("#end_date").val(formatted_new_date);
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

    $(".mark_as_complete").on("click", function() {
        $("#submit_not_assds").attr("disabled", "disabled");
        $("#submit_not_assds").text("Processing...");

        $("#submit_assds").attr("disabled", "disabled");
        $("#submit_assds").text("Processing...");

        var sam_id = ["{{ $sam_id }}"];
        var sub_activity_id = "{{ $sub_activity_id }}";
        var activity_name = "mark_as_complete";
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

                    $("#submit_not_assds").removeAttr("disabled");
                    $("#submit_not_assds").text("Mark as Complete");

                    $("#viewInfoModal").modal("hide");
                } else {
                    Swal.fire(
                        'Error',
                        resp.message,
                        'error'
                    )

                    $("#submit_not_assds").removeAttr("disabled");
                    $("#submit_not_assds").text("Mark as Complete");
                }
            },
            error: function (resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )

                $("#submit_not_assds").removeAttr("disabled");
                $("#submit_not_assds").text("Mark as Complete");
            }
        });

    });
</script>