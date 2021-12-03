
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
    $(document).ready(function(){
        $.ajax({
            url: "/get-form/" + "827" + "/" + "{{ $site[0]->activity_name }}",
            method: "GET",
            // headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            // },
            success: function (resp) {
                if (!resp.error) {
                    $(".form_html").html(resp.message);

                    refx = JSON.parse( JSON.parse( JSON.stringify("{{ \Auth::user()->get_refx($site[0]->sam_id, 'refx') }}".replace(/&quot;/g,'"')) ) );

                    $.each(refx, function(index, data) {
                        $(".application_of_payment_form #" + index).val(data);
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

    $(".form_html").on("click", ".save_application_of_payment_btn", function(e) {
        e.preventDefault();
        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        var sam_id = "{{ $site[0]->sam_id }}";
        var site_category = "{{ $site[0]->site_category }}";
        var activity_id = "{{ $site[0]->activity_id }}";
        var program_id = "{{ $site[0]->program_id }}";

        $.ajax({
            url: "/approve-schedule-of-payment",
            method: "POST",
            data: $(".site_data_form").serialize(),
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

                        $(".save_application_of_payment_btn").removeAttr("disabled");
                        $(".save_application_of_payment_btn").text("Confirm Application of Payment");

                        $("#viewInfoModal").modal("hide");

                    });
                } else {
                    
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $(".endorsement_to_sts_backroom_form ." + index + "-error").text(data);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }

                    $(".save_application_of_payment_btn").removeAttr("disabled");
                    $(".save_application_of_payment_btn").text("Confirm Application of Payment");
                }
            },
            error: function (resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )

                $(".save_application_of_payment_btn").removeAttr("disabled");
                $(".save_application_of_payment_btn").text("Confirm Application of Payment");
            }
        });

    });
</script>