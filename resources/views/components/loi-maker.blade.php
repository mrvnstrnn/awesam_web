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

    $(".form_html").on("click", ".save_create_loi_to_renew_btn", function(e){
        e.stopPropagation();
        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        $.ajax({
            url: "/save-loi",
            method: "POST",
            data: $(".create_loi_to_renew_form, .site_data_form").serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp) {
                if (!resp.error) {

                    $(".create_loi_to_renew_form")[0].reset();

                    Swal.fire(
                        'Success',
                        resp.message,
                        'success'
                    )
                    
                    $(".save_create_loi_to_renew_btn").removeAttr("disabled");
                    $(".save_create_loi_to_renew_btn").text("Save LOI");
                    $(".btn_switch_back_to_actions").trigger("click");
                    // $("#viewInfoModal").modal("hide");
                } else {
                    
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $(".create_loi_to_renew_form ." + index + "-error").text(data);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }

                    $(".save_create_loi_to_renew_btn").removeAttr("disabled");
                    $(".save_create_loi_to_renew_btn").text("Save LOI");
                }
            },
            error: function (resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )

                $(".save_create_loi_to_renew_btn").removeAttr("disabled");
                $(".save_create_loi_to_renew_btn").text("Save LOI");
            }
        });
    });


    
    // $(document).on("change", "#from_date", function(e){
    //     e.preventDefault();

    //     if(!$('#terms_in_years').val()){
    //         console.log('set terms');
    //     } else {
    //         console.log(moment().add(7, 'years'));
    //     }
    // });


    


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
                    // $("#lessor").val("{{ $program_renewal->lessor }}").attr("readonly", "readonly");
                    $("#lessor").val("{{ $program_renewal->lessor }}");
                    $("#cell_site_address").val("{{ $program_renewal->site_address }}");
                    $("#expiration_date").val("{{ $program_renewal->expiration }}");
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

    $(".form_html").on("change", "#new_terms_start_date, #terms_in_years", function(e){
        var terms_in_years = $("#terms_in_years").val();
        var new_terms_start_date = $("#new_terms_start_date").val();
        if ( terms_in_years != null && new_terms_start_date != null ) {
            var terms_in_years = $("#terms_in_years").val();
            var new_terms_start_date = new Date($("#new_terms_start_date").val());

            new_date = new_terms_start_date.setFullYear(new_terms_start_date.getFullYear() + +terms_in_years);

            new_new_terms_start_date = new Date(new_date)

            date_day = (new_new_terms_start_date.getDate()) < 10 ? "0" + (new_new_terms_start_date.getDate()) : new_new_terms_start_date.getDate();
            let formatted_new_date =  new_new_terms_start_date.getFullYear() + "-" + ( new_new_terms_start_date.getMonth() + 1 ) + "-" + date_day;

            $("#new_terms_end_date").val(formatted_new_date);
        }
    });
</script>