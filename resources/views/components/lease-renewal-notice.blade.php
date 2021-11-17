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

{{-- <form class="select_company_form">
    <input type="hidden" name="sub_activity" value="{{ $sub_activity }}">
    <div class="form-group">
        <label for="company">Companies</label>
        <select class="form-control" name="company" id="company">
            <option value="">Please select company</option>
            <option value="Bayantel">Bayantel</option>
            <option value="Globe">Globe</option>
            <option value="Innove">Innove</option>
        </select>
    </div>

    <div class="form-group">
        <label for="lrn_type">LRN Type</label>
        <select class="form-control" name="lrn_type" id="lrn_type">
        </select>
    </div>

    <div class="form-group">
        <button class="btn btn-primary btn-lg btn-shadow get_form" type="button">Get form</button>
    </div>
</form> --}}

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

    $(document).on("click", ".save_create_lease_renewal_notice_btn", function() {
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

                    $(".save_create_lease_renewal_notice_btn").removeAttr("disabled");
                    $(".save_create_lease_renewal_notice_btn").text("Create LRN");

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