<div class="row mb-3">
    <div class="col-12 align-right">
        <form id="create_pr_form">
            <div class="form-group">
                @php
                    $json = json_decode($pr->value, true);
                @endphp
              <label for="reference_number">Reference #</label>
              <input type="text" name="reference_number" id="reference_number" class="form-control" value="{{ $json['reference_number'] }}" readonly>
            </div>
            
            <div class="form-group">
                <label for="prepared_by_name">Prepared By</label>
                <input type="text" name="prepared_by_name" id="prepared_by_name" class="form-control" value="{{ $pr->name }}" readonly>
            </div>

            <div class="form-group">
                <label for="pr_file">PR File</label>
                <iframe class="embed-responsive-item" style="width:100%; min-height: 400px; height: 100%" src="/ViewerJS/#../files/{{ $json['pr_file'] }}" allowfullscreen></iframe>
            </div>

            <div class="form-group">
                <label for="vendor">Vendor</label>
                <input type="text" name="vendor" id="vendor" class="form-control" value="{{ $json['reference_number'] }}" readonly>
            </div>
        </form>         

        <button class="float-right btn btn-shadow btn-success ml-1 approve_reject_pr" id="approve_pr" data-data_action="true" data-id="{{ $pr->id }}" data-sam_id="{{ $site[0]->sam_id }}" data-activity_name="{{ $site[0]->activity_name }}">Approve PR</button>
        <button class="float-right btn btn-shadow btn-danger ml-1 approve_reject_pr" id="reject_pr" data-data_action="false" data-id="{{ $pr->id }}" data-sam_id="{{ $site[0]->sam_id }}" data-activity_name="{{ $site[0]->activity_name }}">Reject PR</button>
    </div>
</div>

<script src="/js/dropzone/dropzone.js"></script>
<script>
    
    $(document).on("click", ".approve_reject_pr", function(e){
        e.preventDefault();

        var sam_id = $(this).attr('data-sam_id');
        var activity_name = $(this).attr('data-activity_name');
        var data_action = $(this).attr('data-data_action');
        var id = $(this).attr('data-id');
        var vendor = $("#vendor").val();

        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        var button_text = data_action == "false" ? "Reject PR" : "Approve PR";
        var button_id = data_action == "false" ? "reject_pr" : "approve_pr";

        $("small").text("");
        $.ajax({
        url: '/approve-reject-pr',
            data: {
                sam_id : sam_id,
                vendor : vendor,
                activity_name : activity_name,
                data_action : data_action,
                id : id
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

                        $("#"+button_id).removeAttr("disabled");
                        $("#"+button_id).text(button_text);
                    });
                } else {
                    Swal.fire(
                        'Error',
                        resp.message,
                        'error'
                    )
                    
                    $("#"+button_id).removeAttr("disabled");
                    $("#"+button_id).text(button_text);
                }
            },
            error: function(resp){
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )
                $("#"+button_id).removeAttr("disabled");
                $("#"+button_id).text(button_text);
            }
        });

    });

</script>

