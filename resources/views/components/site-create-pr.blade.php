<div class="row mb-3">
    <div class="col-12 align-right">
        <form id="create_pr_form">
            <div class="form-group">
              <label for="reference_number">Reference #</label>
              <input type="text" name="reference_number" id="reference_number" class="form-control">
              <small class="text-danger reference_number-error"></small>
            </div>
            
            <div class="form-group">
                <label for="prepared_by_name">Prepared By</label>
                <input type="text" name="prepared_by_name" id="prepared_by_name" class="form-control" value="{{ \Auth::user()->name }}" readonly>
                <input type="hidden" name="prepared_by" id="prepared_by" value="{{ \Auth::id() }}">
            </div>

            <div class="form-group">
                <label for="pr_file">PR File</label>
                <input type="hidden" name="pr_file" id="pr_file" class="form-control">
                <div class="dropzone dropzone_files">
                    <div class="dz-message">
                        <i class="fa fa-plus fa-3x"></i>
                        <p><small class="sub_activity_name">{{ $site[0]->activity_name }}</small></p>
                    </div>
                </div>
                <small class="text-danger pr_file-error"></small>
            </div>

            <div class="form-group">
                <label for="vendor">Reference #</label>
                <select name="vendor" id="vendor" class="form-control">
                    @php
                        $vendors = \App\Models\Vendor::select("vendor.vendor_sec_reg_name", "vendor.vendor_id", "vendor.vendor_acronym")
                                                            ->join("vendor_programs", "vendor_programs.vendors_id", "vendor.vendor_id")
                                                            ->where("vendor_programs.programs", $site[0]->program_id)
                                                            ->get();
                    @endphp
                    @foreach ($vendors as $vendor)
                        <option value="{{ $vendor->vendor_id }}">{{ $vendor->vendor_sec_reg_name }} ({{ $vendor->vendor_acronym }})</option>
                    @endforeach
                </select>
                <small class="text-danger reference_no-error"></small>
            </div>
        </form>         

        <button class="float-right btn btn-shadow btn-success ml-1" id="create_pr_btn" data-activity_id="{{ $site[0]->activity_id }}" data-sam_id="{{ $site[0]->sam_id }}" data-activity_name="{{ $site[0]->activity_name }}">Create PR</button>
    </div>
</div>

<script src="/js/dropzone/dropzone.js"></script>
<script>

    Dropzone.autoDiscover = false;
    $(".dropzone_files").dropzone({
        addRemoveLinks: true,
        maxFiles: 1,
        maxFilesize: 1,
        paramName: "file",
        url: "/upload-file",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (file, resp) {
            if (!resp.error){
                $("#pr_file").val(resp.file);
                // $(".dropzone_files").addClass("d-none");
                // this.removeFile(file);
            } else {
                toastr.error(resp.message, "Error");
            }
        },
        error: function (file, resp) {
            toastr.error(resp.message, "Error");
        }
    });
    
    $(document).on("click", "#create_pr_btn", function(e){
        e.preventDefault();

        var sam_id = $(this).attr('data-sam_id');
        var activity_id = $(this).attr('data-activity_id');
        var activity_name = $(this).attr('data-activity_name');
        var reference_number = $("#reference_number").val();
        var prepared_by = $("#prepared_by").val();
        var pr_file = $("#pr_file").val();
        var vendor = $("#vendor").val();

        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        $("small").text("");
        $.ajax({
        url: '/add-create-pr',
            data: {
                sam_id : sam_id,
                reference_number : reference_number,
                prepared_by : prepared_by,
                pr_file : pr_file,
                vendor : vendor,
                activity_name : activity_name,
                activity_id : activity_id,
            },
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp){
                if(!resp.error){
                    $("#"+$(".ajax_content_box").attr("data-what_table")).DataTable().ajax.reload(function(){
                        $("#viewInfoModal").modal("hide");
                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )

                        $("#create_pr_btn").removeAttr("disabled");
                        $("#create_pr_btn").text("Create PR");
                    });
                } else {
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $("." + index + "-error").text(data);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }
                    
                    $("#create_pr_btn").removeAttr("disabled");
                    $("#create_pr_btn").text("Create PR");
                }
            },
            error: function(resp){
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )
                $("#create_pr_btn").removeAttr("disabled");
                $("#create_pr_btn").text("Create PR");
            }
        });

    });

</script>

