<div class="row">
    <div class="col-lg-6">
        <div id="datepicker" class=""></div>
    </div>
    <div class="col-lg-6">
        <form>
            <div class="form-row"> 
                <div class="col-md-12">
                    <div class="position-relative form-group">
                        @php
                            $json = json_decode($rtbdeclaration->value, true);
                        @endphp
                        <label for="rtb_declaration_date">Date Declaration</label>
                        <input type="text" id="rtb_declaration_date" name="rtb_declaration_date" value="{{ date("m/d/Y", strtotime($json['rtb_declaration_date'] )) }}" class="form-control" readonly />
                    </div>        
                </div>
            </div>
            <div class="form-row"> 
                <div class="col-md-12">
                    <div class="position-relative form-group">
                        <label for="rtb_declaration">RTB Declaration</label>
                        {{-- <select name="rtb_declaration" id="rtb_declaration" class="form-control">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select> --}}
                        <input type="text" name="rtb_declaration" id="rtb_declaration" value="{{ $json['rtb_declaration'] }}" class="form-control" readonly>
                    </div>        
                </div>
            </div>
            <div class="form-row"> 
                <div class="col-md-12">
                    <div class="position-relative form-group">
                        <label for="remarks" rows="6" class="">Remarks</label>
                        <textarea class="form-control" id="remarks" name="remarks" style="height: 95px;"></textarea>
                        <small class="remarks-error text-danger"></small>
                    </div>        
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row mb-3 border-top pt-3">
    <div class="col-12 align-right">
        <button class="float-right btn btn-shadow btn-success declaration_approve_reject" id="declaration_approve" data-action="true" data-sam_id="{{ $rtbdeclaration->sam_id }}">Approve RTB Declaration</button>                                            
        <button class="float-right btn btn-shadow btn-danger mr-2 declaration_approve_reject" id="declaration_reject" data-action="false" data-sam_id="{{ $rtbdeclaration->sam_id }}">Reject</button>                                            
    </div>
</div>


<script>

    $(document).ready(function(){

    
        $(".declaration_approve_reject").on("click", function(e) {
            e.preventDefault();
            var sam_id = $(this).attr("data-sam_id");
            var action = $(this).attr("data-action");
            var remarks = $("#remarks").val();
            var activity_name = "rtb_declation_approval";


            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            var message = action == "false" ? "Reject" : "Approve RTB Declaration";
            var button_id = action == "false" ? "declaration_reject" : "declaration_approve";
            
            $("small").text("");

            $.ajax({
                url: "/approve-reject-rtb",
                method: "POST",
                data: {
                    sam_id : sam_id,
                    action : action,
                    remarks : remarks,
                    activity_name : activity_name
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(resp){
                    if(!resp.error){
                        $("#"+$(".ajax_content_box").attr("data-what_table")).DataTable().ajax.reload(function(){
                            $("#viewInfoModal").modal("hide");

                            $("#"+button_id).removeAttr("disabled");
                            $("#"+button_id).text(message);

                            Swal.fire(
                                'Success',
                                resp.message,
                                'success'
                            )
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

                        $("#"+button_id).removeAttr("disabled");
                        $("#"+button_id).text(message);
                    }
                },
                error: function(resp){
                    Swal.fire(
                        'Error',
                        resp.message,
                        'error'
                    )
                    $("#"+button_id).removeAttr("disabled");
                    $("#"+button_id).text(message);
                }
            });
        });
    })
</script>
