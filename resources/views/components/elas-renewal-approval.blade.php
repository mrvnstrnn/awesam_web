
{{-- <div class="row">
    <div class="col-12 approve_elas_div">
        <button class="btn-sm btn-shadow btn btn-block btn-primary mark_as_complete">Approved eLAS</button>
    </div>
</div> --}}

<div class="row">
    <div class="col-12">
        <div class="form_html"></div>
        <form class="site_data_form">@csrf
            <input type="hidden" name="sam_id" id="sam_id" value="{{ $site[0]->sam_id }}">
            <input type="hidden" name="site_category" id="site_category" value="{{ $site[0]->site_category }}">
            <input type="hidden" name="program_id" id="program_id" value="{{ $site[0]->program_id }}">
            <input type="hidden" name="activity_id" id="activity_id" value="{{ $site[0]->activity_id }}">
        </form>
    </div>
</div>

{{-- <button class="btn-sm btn-shadow btn btn-block btn-primary mark_as_complete">Approved eLAS</button> --}}

<script>
    $(".form_html").on("click", ".save_elas_approval_btn", function(e) {
        e.preventDefault();
        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        var sam_id = ["{{ $site[0]->sam_id }}"];
        var activity_name = "mark_as_complete";
        var site_category = ["{{ $site[0]->site_category }}"];
        var activity_id = ["{{ $site[0]->activity_id }}"];
        var program_id = "{{ $site[0]->program_id }}";

        $.ajax({
            url: "/elas-approval-confirm",
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

                        $(".save_elas_approval_btn").removeAttr("disabled");
                        $(".save_elas_approval_btn").text("Approved eLAS");

                        $("#viewInfoModal").modal("hide");

                    });
                } else {
                    Swal.fire(
                        'Error',
                        resp.message,
                        'error'
                    )

                    $(".save_elas_approval_btn").removeAttr("disabled");
                    $(".save_elas_approval_btn").text("Approved eLAS");
                }
            },
            error: function (resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )

                $(".save_elas_approval_btn").removeAttr("disabled");
                $(".save_elas_approval_btn").text("Approved eLAS");
            }
        });

    });

    $(document).ready(function(){
        $.ajax({
            url: "/get-form/" + "32" + "/" + "eLAS Approval",
            method: "GET",
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
</script>