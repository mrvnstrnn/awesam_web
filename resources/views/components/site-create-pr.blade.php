<div class="row file_lists">
    <input type="hidden" name="hidden_sam_id" value="{{ $site[0]->sam_id }}">
</div>
<div class="row mb-3 border-top pt-3">
    <div class="col-12 align-right">                                            
        <button class="float-right btn btn-shadow btn-success ml-1" id="btn-accept-endorsement" data-complete="true" data-sam_id="{{ $site[0]->sam_id }}">Create PR</button>
        {{-- <button class="float-right btn btn-shadow btn-danger" id="btn-accept-endorsement" data-complete="false" data-sam_id="{{ $site[0]->sam_id }}">Reject Site</button>                                       --}}
    </div>
</div>


<script>
    
    $("#btn-accept-endorsement").click(function(e){
        e.preventDefault();

        var sam_id = [$(this).attr('data-sam_id')];
        var data_complete = $(this).attr('data-complete');

        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        $.ajax({
            url: '/accept-reject-endorsement',
            data: {
                sam_id : sam_id,
                data_complete : data_complete
            },
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp){
                if(!resp.error){
                    $("#"+$(".ajax_content_box").attr("data-what_table")).DataTable().ajax.reload(function(){
                        $("#viewInfoModal").modal("hide");
                        toastr.success(resp.message, 'Success');

                        $("#btn-accept-endorsement-"+data_complete).removeAttr("disabled");
                        $("#btn-accept-endorsement-"+data_complete).text(data_complete == "false" ? "Reject" : "Approve RTB Documents");
                        // $("#loaderModal").modal("hide");
                    });
                } else {
                    toastr.error(resp.message, 'Error');
                    $("#btn-accept-endorsement-"+data_complete).removeAttr("disabled");
                    $("#btn-accept-endorsement-"+data_complete).text(data_complete == "false" ? "Reject" : "Approve RTB Documents");
                }
            },
            error: function(resp){
                // $("#loaderModal").modal("hide");
                toastr.error(resp.message, 'Error');
                $("#btn-accept-endorsement-"+data_complete).removeAttr("disabled");
                $("#btn-accept-endorsement-"+data_complete).text(data_complete == "false" ? "Reject" : "Approve RTB Documents");
            }
        });

    });

</script>

