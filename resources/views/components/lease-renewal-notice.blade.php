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

<button class="btn btn-primary btn-lg btn-shadow text-white pull-right mark_as_complete" type="button">Mark as Complete</button>

<script>
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