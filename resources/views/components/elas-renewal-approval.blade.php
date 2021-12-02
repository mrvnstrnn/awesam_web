
<div class="row">
    <div class="col-12 approve_elas_div">
        <button class="btn-sm btn-shadow btn btn-block btn-primary mark_as_complete">Approved eLAS</button>
    </div>
</div>

<script>
    $(".approve_elas_div").on("click", ".mark_as_complete", function(e) {
        e.preventDefault();
        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        var sam_id = ["{{ $site[0]->sam_id }}"];
        var activity_name = "mark_as_complete";
        var site_category = ["{{ $site[0]->site_category }}"];
        var activity_id = ["{{ $site[0]->activity_id }}"];
        var program_id = "{{ $site[0]->program_id }}";

        $.ajax({
            url: "/accept-reject-endorsement",
            method: "POST",
            data: {
                sam_id : sam_id,
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

                    $("table[data-program_id="+"{{ $site[0]->program_id }}"+"]").DataTable().ajax.reload(function(){
                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )

                        $(".mark_as_complete").removeAttr("disabled");
                        $(".mark_as_complete").text("Approved eLAS");

                        $("#viewInfoModal").modal("hide");

                    });
                } else {
                    Swal.fire(
                        'Error',
                        resp.message,
                        'error'
                    )

                    $(".mark_as_complete").removeAttr("disabled");
                    $(".mark_as_complete").text("Approved eLAS");
                }
            },
            error: function (resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )

                $(".mark_as_complete").removeAttr("disabled");
                $(".mark_as_complete").text("Approved eLAS");
            }
        });

    });
</script>