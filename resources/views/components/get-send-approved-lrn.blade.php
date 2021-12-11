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

@php
    $json = json_decode($files->value);
@endphp

<div class="row button_area pb-4">
    <div class="col-md-6 col-6">
        <a href="/files/{{ $json->file }}" download="{{ $json->file }}" class="btn btn-danger btn-lg btn-shadow text-white btn-block" type="button"><i class="fa fa-file-pdf" aria-hidden="true"></i> Download LRN</a>
    </div>

    <div class="col-md-6 col-6">
        <button class="btn btn-primary btn-lg btn-shadow text-white btn-block email_loi" type="button"><i class="fa fa-envelope" aria-hidden="true"></i> Email LRN</button>
    </div>
</div>

<div class="row loi_form_area d-none pb-4">
    <div class="col-12">
        <form class="email_loi_form">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                <input type="hidden" name="file_name" id="file_name" value="{{ $json->file }}">
                <small class="email-error text-danger"></small>
            </div>

            <div class="form-group">
                <button class="btn btn-primary btn-lg btn-shadow text-white pull-right submit_email_loi" type="button">Email LRN</button>
                <button class="btn btn-secondary btn-lg btn-shadow text-white pull-right cancel_email_loi mr-1" type="button">Cancel Email LRN</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(".btn_switch_back_to_actions").on("click", function(){
        $("#actions_box").addClass('d-none');
        $("#actions_list").removeClass('d-none');
    });

    $(".cancel_email_loi").on("click", function(){
        $(".button_area").removeClass('d-none');
        $(".loi_form_area").addClass('d-none');
    });

    $(".email_loi").on("click", function(){
        $(".button_area").addClass('d-none');
        $(".loi_form_area").removeClass('d-none');
    });

    $(".submit_email_loi").on("click", function(){
        
        $(".submit_email_loi").attr("disabled", "disabled");
        $(".submit_email_loi").text("Processing...");

        $(".cancel_email_loi").attr("disabled", "disabled");
        $(".cancel_email_loi").text("Processing...");

        $.ajax({
            url: "/email-lrn",
            method: "POST",
            data: $(".email_loi_form").serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp) {
                if (!resp.error) {

                    $(".email_loi_form")[0].reset();

                    Swal.fire(
                        'Success',
                        resp.message,
                        'success'
                    )
                    
                    $(".submit_email_loi").removeAttr("disabled");
                    $(".submit_email_loi").text("Email LRN");

                    $(".cancel_email_loi").removeAttr("disabled");
                    $(".cancel_email_loi").text("Cancel Email LRN");

                    $(".btn_switch_back_to_actions").trigger("click");
                } else {
                    
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $(".email_loi_form ." + index + "-error").text(data);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }

                    $(".submit_email_loi").removeAttr("disabled");
                    $(".submit_email_loi").text("Email LRN");

                    $(".cancel_email_loi").removeAttr("disabled");
                    $(".cancel_email_loi").text("Cancel Email LRN");
                }
            },
            error: function (resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )

                $(".submit_email_loi").removeAttr("disabled");
                $(".submit_email_loi").text("Email LRN");

                $(".cancel_email_loi").removeAttr("disabled");
                $(".cancel_email_loi").text("Cancel Email LRN");
            }
        });
    });

</script>