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

    $(document).on("click", ".save_loi_to_renew_btn", function(e){
        e.preventDefault();

        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        $.ajax({
            url: "/save-loi",
            method: "POST",
            data: $(".loi_to_renew_form, .site_data_form").serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp) {
                if (!resp.error) {

                    // $(".loi_to_renew_form")[0].reset();

                    Swal.fire(
                        'Success',
                        resp.message,
                        'success'
                    )
                    
                    $(".save_loi_to_renew_btn").removeAttr("disabled");
                    $(".save_loi_to_renew_btn").text("Save LOI");
                } else {
                    
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $(".loi_to_renew_form ." + index + "-error").text(data);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }

                    $(".save_loi_to_renew_btn").removeAttr("disabled");
                    $(".save_loi_to_renew_btn").text("Save LOI");
                }
            },
            error: function (resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )

                $(".save_loi_to_renew_btn").removeAttr("disabled");
                $(".save_loi_to_renew_btn").text("Save LOI");
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
                    $("#lessor").val("{{ $program_renewal->lessor }}").attr("readonly", "readonly");
                    $("#lessor_address").val("{{ $program_renewal->site_address }}").attr("readonly", "readonly");
                    $("#expiration_date").val("{{ $program_renewal->expiration }}").attr("readonly", "readonly");
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