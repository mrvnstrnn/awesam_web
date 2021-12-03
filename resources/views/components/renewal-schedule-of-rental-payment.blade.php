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

{{-- <button class="btn btn-shadow btn-lg btn-primary mark_as_complete">Mark as Complete</button> --}}

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

                    lrn = JSON.parse( JSON.parse( JSON.stringify("{{ \Auth::user()->get_lrn($sam_id, 'lrn') }}".replace(/&quot;/g,'"')) ) );

                    $.each(lrn, function(index, data) {
                        // console.log(index);
                        if (index == "start_date") {
                            indexNew = "contract_start";
                        } else if (index == "end_date") {
                            indexNew = "contract_end";
                        } else if (index == "lease_term") {
                            indexNew = "contract_term";
                        } else if (index == "final_negotiated_amount") {
                            indexNew = "monthly_rent";
                        } else {
                            indexNew = index;
                        }
                        $("#"+indexNew).val(data);
                    });
                    // if( (typeof lrn === "object" || typeof lrn === 'function') && (lrn !== null) ) {
                    //     $.each(lrn, function(index, data) {
                    //         $("#"+index).val(data);
                    //     });
                    // } else {
                    //     Swal.fire(
                    //         'Error',
                    //         "Can't process this right now.",
                    //         'error'
                    //     )
                    // }
                    
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

    $(".form_html").on("click", ".save_schedule_of_rental_payment_btn", function (e) {

    });

    $(".mark_as_complete").on("click", function() {
        $(".mark_as_complete").attr("disabled", "disabled");
        $(".mark_as_complete").text("Processing...");

        var sam_id = ["{{ $sam_id }}"];
        var activity_name = "mark_as_complete";
        var site_category = ["{{ $site_category }}"];
        var activity_id = ["{{ $activity_id }}"];
        var program_id = "{{ $program_id }}";

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
                    Swal.fire(
                        'Success',
                        resp.message,
                        'success'
                    )

                    $(".mark_as_complete").removeAttr("disabled");
                    $(".mark_as_complete").text("Mark as Complete");

                    $("#viewInfoModal").modal("hide");
                } else {
                    Swal.fire(
                        'Error',
                        resp.message,
                        'error'
                    )

                    $(".mark_as_complete").removeAttr("disabled");
                    $(".mark_as_complete").text("Mark as Complete");
                }
            },
            error: function (resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )

                $(".mark_as_complete").removeAttr("disabled");
                $(".mark_as_complete").text("Mark as Complete");
            }
        });

    });
</script>