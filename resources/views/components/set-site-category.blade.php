<div class="row file_preview d-none">
    <div class="col-12 mb-3">
        <button id="btn_back_to_file_list_2" class="mt-0 btn btn-secondary" type="button">Back to files</button>
    </div>
</div>
<div class="row mb-3">
    <div class="col-12 align-right">
        <form id="site_category_form">

            <div class="form-group">
                <label for="site_category">Site Category</label>
                <select name="site_category" id="site_category" class="form-control">
                    <option value="CONVENTIONAL - BRGY">CONVENTIONAL - BRGY</option>
                    <option value="CONVENTIONAL - HOA">CONVENTIONAL - HOA</option>
                    <option value="MILO - BRGY">MILO - BRGY</option>
                    <option value="MILO - HOA">MILO - HOA</option>
                    <option value="TRANSPORT - BRGY">TRANSPORT - BRGY</option>
                    <option value="TRANSPORT - HOA">TRANSPORT - HOA</option>
                    <option value="OPS CAB - BRGY">OPS CAB - BRGY</option>
                    <option value="OPS CAB - HOA">OPS CAB - HOA</option>
                </select>
            </div>
        </form>         

        <button class="float-right btn btn-shadow btn-success ml-1" id="site_category_btn" data-sub_activity_id="{{ $sub_activity_id }}" data-sam_id="{{ $sam_id }}" data-activity_name="{{ $sub_activity }}">Set Category</button>
    </div>
</div>

<script>
    $("#site_category_btn").on("click", function (){
        var sam_id = $(this).attr("data-sam_id");
        var sub_activity_id = $(this).attr("data-sub_activity_id");
        var activity_name = $(this).attr("data-activity_name");

        var site_category = $("#site_category").val();

        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");
        
        $.ajax({
            url: "/set-site-category",
            method: "POST",
            data: {
                sam_id : sam_id,
                sub_activity_id : sub_activity_id,
                activity_name : activity_name,
                site_category : site_category,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp) {
                if (!resp.error) {
                    $("#site_category_btn").removeAttr("disabled");
                    $("#site_category_btn").text("Set Category");

                    Swal.fire(
                        'Success',
                        resp.message,
                        'success'
                    )

                    $("#viewInfoModal").modal("hide");
                } else {
                    $("#site_category_btn").removeAttr("disabled");
                    $("#site_category_btn").text("Set Category");

                    Swal.fire(
                        'Error',
                        resp.message,
                        'error'
                    )
                }
            },
            error: function (resp) {
                $("#site_category_btn").removeAttr("disabled");
                $("#site_category_btn").text("Set Category");

                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )
            },
        });
    });
</script>