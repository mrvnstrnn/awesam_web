<div class="row">
    <div class="col-12">
        <div class="form_html"></div>
        <form class="site_data_form">
            <input type="hidden" name="sam_id" id="sam_id" value="{{ $site[0]->sam_id }}">
            <input type="hidden" name="site_category" id="site_category" value="{{ $site[0]->site_category }}">
            <input type="hidden" name="program_id" id="program_id" value="{{ $site[0]->program_id }}">
            <input type="hidden" name="activity_id" id="activity_id" value="{{ $site[0]->activity_id }}">
        </form>
    </div>
</div>

<script>
    $(document).on("click", ".save_elas_renewal_btn", function() {
        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        $(".elas_form small").text("");

        $.ajax({
            url: "/save-elas",
            method: "POST",
            data: $(".elas_renewal_form, .site_data_form").serialize(),
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

                        $(".save_elas_renewal_btn").removeAttr("disabled");
                        $(".save_elas_renewal_btn").text("Save eLAS");

                        $("#viewInfoModal").modal("hide");
                    }
                } else {
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $(".elas_renewal_form ." + index + "-error").text(data);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }

                    $(".save_elas_renewal_btn").removeAttr("disabled");
                    $(".save_elas_renewal_btn").text("Save eLAS");
                }
            },
            error: function (resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )

                $(".save_elas_renewal_btn").removeAttr("disabled");
                $(".save_elas_renewal_btn").text("Save eLAS");
            }
        });

    });

    $(document).ready(function(){
        $.ajax({
            url: "/get-form/" + "8" + "/" + "eLAS Renewal",
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