<div class="row mb-3">
    <div class="col-12 align-right">
        <form id="create_pr_form">

            @php
                $json = json_decode($prmemo->value, true);
            @endphp

            @if ($activity == "Set Ariba PR Number to Sites")
                <div class="form-group">
                    <label for="pr_number">PR #</label>
                    <input type="text" name="pr_number" id="pr_number" class="form-control" {{ $activity == "Vendor Awarding of Sites" ? "disabled" : "" }}>
                    <small class="pr_number-error text-danger"></small>
                </div>
            
            @elseif ($activity == "Vendor Awarding of Sites")
            
                <div class="form-group">
                    <label for="vendor">Vendor</label>
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
                    <small class="text-danger vendor-error"></small>
                </div>
            @endif
            
            <div class="form-group">
                <label for="pr_file">PR File</label>
                <iframe class="embed-responsive-item" style="width:100%; min-height: 400px; height: 100%" src="/ViewerJS/#../files/pdf/{{ $json['file_name'] }}" allowfullscreen></iframe>
            </div>
            @if ($activity == "Set Ariba PR Number to Sites")
                
                <button type="button" class="float-right btn btn-shadow btn-success ml-1 approve_reject_pr" id="approve_pr" data-data_action="true" data-id="{{ $prmemo->id }}" data-sam_id="{{ $samid }}" data-activity_name="{{ $activity }}">Set PR</button>
            @elseif ($activity == "Vendor Awarding of Sites")
            
                <button type="button" class="float-right btn btn-shadow btn-success ml-1 approve_reject_pr" id="approve_pr" data-data_action="true" data-id="{{ $prmemo->id }}" data-sam_id="{{ $samid }}" data-activity_name="{{ $activity }}">Award to vendor</button>
            @else
                <button type="button" class="float-right btn btn-shadow btn-success ml-1 approve_reject_pr" id="approve_pr" data-data_action="true" data-id="{{ $prmemo->id }}" data-sam_id="{{ $samid }}" data-activity_name="{{ $activity }}">Approve PR</button>

                <button type="button" class="float-right btn btn-shadow btn-danger ml-1 reject_pr">Reject PR</button>
            @endif


            {{-- <button type="button" class="float-right btn btn-shadow btn-danger ml-1 approve_reject_pr d-none" id="reject_pr" data-data_action="false" data-id="{{ $prmemo->id }}" data-sam_id="{{ $samid }}" data-activity_name="{{ $activity }}">Reject PR</button> --}}
        </form>

        <div class="row reject_remarks d-none">
            <div class="col-12">
                <p class="message_p">Are you sure you want to reject PR Memo?</p>
                <form class="reject_form">
                    <div class="form-group">
                        <label for="remarks">Remarks:</label>
                        <textarea style="width: 100%;" name="remarks" id="remarks" rows="5" cols="100" class="form-control"></textarea>
                        <small class="text-danger remarks-error"></small>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-sm btn-shadow confirm_reject" id="reject_pr" data-data_action="false" data-id="{{ $prmemo->id }}" data-sam_id="{{ $samid }}" data-activity_name="{{ $activity }}">Reject PR</button>
                        
                        <button class="btn btn-secondary btn-sm btn-shadow cancel_reject">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    
    $(".approve_reject_pr, .confirm_reject").on("click", function(e){
        e.preventDefault();

        var data_action = $(this).attr('data-data_action');
        var activity_name = $(this).attr('data-activity_name');
        var id = $(this).attr('data-id');

        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        var button_id = data_action == "false" ? "reject_pr" : "approve_pr";
        
        var sam_id = $(this).attr('data-sam_id');

        var remarks = $("#remarks").val();

        if (activity_name == "Set Ariba PR Number to Sites") {
            var url = "/accept-reject-endorsement";
            
            $("#create_pr_form small").text("");
            var sam_id = [sam_id];
            var pr_number = $("#pr_number").val();

            var button_text = "Set PR";

            data = {
                sam_id : sam_id,
                activity_name : activity_name,
                data_action : data_action,
                pr_number : pr_number
            }
        } else if (activity_name == "Vendor Awarding of Sites") {
            var url = "/vendor-awarding-sites";
            
            $("#create_pr_form small").text("");
            var sam_id = sam_id;
            var vendor = $("#vendor").val();

            var button_text = "Award to vendor";

            data = {
                sam_id : sam_id,
                activity_name : activity_name,
                data_action : data_action,
                vendor : vendor
            }
        } else {
            $(".reject_form small").text("");
            var button_text = data_action == "false" ? "Reject PR" : "Approve PR";
            url = "/approve-reject-pr-memo";
            data = {
                sam_id : sam_id,
                activity_name : activity_name,
                data_action : data_action,
                id : id,
                remarks : remarks
            }
        }

        $.ajax({
        url: url,
            data: data,
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

                        $(".reject_form")[0].reset();

                        $("#"+button_id).removeAttr("disabled");
                        $("#"+button_id).text(button_text);
                    });
                } else {
                    
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $(".reject_form ." + index + "-error").text(data);
                            $("#create_pr_form ." + index + "-error").text(data);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }
                    
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

    $(".reject_pr").on("click", function(e){
        e.preventDefault();
        $("#create_pr_form").addClass("d-none");
        $(".reject_remarks").removeClass("d-none");

    });

    $(".cancel_reject").on("click", function(e){
        e.preventDefault();
        $("#create_pr_form").removeClass("d-none");
        $(".reject_remarks").addClass   ("d-none");

    });

    
    

</script>