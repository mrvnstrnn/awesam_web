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

<div class="row form_div">
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

<div class="row table_computation_div d-none">
    <div class="col-12">
        <h6>If there is a change of Tax Application:</h6>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center">Type of Lessor</th>
                        <th class="text-center">Tax Application (VAT/EWT)</th>
                        <th class="text-center">Contract Rate</th>
                        <th class="text-center">Add: 12% VAT</th>
                        <th class="text-center">Less: 5% EWT</th>
                        <th class="text-center">Net Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Old Terms:</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Lessors Demand: </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>New Terms: </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>*Amount Used:</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="table-responsive mt-3">
            <table class="table table-bordered table-hover summary_table">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-center">Years</th>
                        <th rowspan="2" colspan="2" class="text-center">Period</th>
                        <th colspan="2" class="text-center">Per Contract</th>
                        <th colspan="2" class="text-center">Lessor Demand</th>
                        <th colspan="2" class="text-center">New Terms</th>
                        <th colspan="2" class="text-center">Savings</th>
                    </tr>
                    <tr>
                        <th>Monthly</th>
                        <th>Annual</th>
                        <th>Monthly</th>
                        <th>Annual</th>
                        <th>Monthly</th>
                        <th>Annual</th>
                        <th>Monthly</th>
                        <th>Annual</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div class="table-responsive mt-3">
            <table class="table table-bordered table-hover summary_exdeal_table">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-center">Other Consideration</th>
                        <th colspan="2" class="text-center">Per Contract</th>
                        <th colspan="2" class="text-center">Lessor Demand</th>
                        <th colspan="2" class="text-center">New Terms</th>
                        <th class="text-center">Savings</th>
                    </tr>
                    <tr>
                        <th>Particulars</th>
                        <th>Total Amount</th>
                        <th>Particulars</th>
                        <th>Total Amount</th>
                        <th>Particulars</th>
                        <th>Total Amount</th>
                        <th>Full Term</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <button class="btn btn-lg btn-shadow btn-primary back_to_form pull-right">Back to form</button>
    </div>
</div>

<button class="btn btn-shadow btn-lg btn-primary mark_as_complete" type="button">Mark as Complete</button>

<script>
    $(".btn_switch_back_to_actions").on("click", function(){
        $("#actions_box").addClass('d-none');
        $("#actions_list").removeClass('d-none');
    });

    $(document).on("click", ".save_savings_computation_btn", function () {
        var start_date = new Date($("#start_date").val());
        var end_date = new Date($("#end_date").val());

        var exdeal_request = $("#exdeal_request").val();

        var now = new Date();

        $(".summary_table tbody tr").remove();
        $(".summary_exdeal_table tbody tr").remove();

        var i = 1;
        var count = 1;
        for (var d = new Date(start_date); d < end_date; d.setFullYear(d.getFullYear() + 1)) {
            count = i++;
            new_date = new Date(d);

            let formatted_old_date = new_date.getFullYear() + "-" + new_date.getDate() + "-" + (new_date.getMonth() + 1);
            
            oldLoop = new_date.setFullYear(new_date.getFullYear() + 1);

            newLoop = new Date(oldLoop)
            let formatted_new_date = newLoop.getFullYear() + "-" + newLoop.getDate() + "-" + (newLoop.getMonth() + 1);
            
            $(".summary_table tbody").append(
                "<tr>" +
                    "<td>" + count + "</td>" +
                    "<td>" + formatted_old_date + "</td>" +
                    "<td>" + formatted_new_date + "</td>" +
                    "<td></td>" +
                    "<td></td>" +
                    "<td></td>" +
                    "<td></td>" +
                    "<td></td>" +
                    "<td></td>" +
                    "<td></td>" +
                    "<td></td>" +
                "<tr>"
            );
        }

        $(".summary_exdeal_table tbody").append(
            "<tr>" +
                "<td>" + exdeal_request + "</td>" +
                "<td></td>" +
                "<td></td>" +
                "<td></td>" +
                "<td></td>" +
                "<td></td>" +
                "<td></td>" +
                "<td></td>" +
            "<tr>"
        );

        $(".form_div").addClass("d-none");
        $(".table_computation_div").removeClass("d-none");
    });

    $(document).on("click", ".back_to_form", function () {
        $(".form_div").removeClass("d-none");
        $(".table_computation_div").addClass("d-none");
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

                    if( (typeof lrn === "object" || typeof lrn === 'function') && (lrn !== null) ) {
                        $.each(lrn, function(index, data) {
                            $("#"+index).val(data);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            "Can't process this right now.",
                            'error'
                        )
                    }
                    
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