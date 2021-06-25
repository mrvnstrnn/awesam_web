<div class="row">
    <div class="col-lg-6">
        <div id="datepicker"></div>
    </div>
    <div class="col-lg-6">
        <form id="declare_rtb_form">
            <div class="form-row"> 
                <div class="col-md-12">
                    <div class="position-relative form-group">
                        <label for="rtb_declaration_date">Date Declaration</label>
                        <input type="text" id="rtb_declaration_date" name="rtb_declaration_date" class="form-control" readonly />
                        <small class="rtb_declaration_date-error text-danger"></small>
                    </div>        
                </div>
            </div>
            <div class="form-row"> 
                <div class="col-md-12">
                    <div class="position-relative form-group">
                        <label for="rtb_declaration" class="">RTB Declaration</label>
                        <select name="rtb_declaration" id="rtb_declaration" class="form-control">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                        <small class="rtb_declaration-error text-danger"></small>
                    </div>        
                </div>
            </div>
            {{-- <div class="form-row"> 
                <div class="col-md-12">
                    <div class="position-relative form-group">
                        <label for="exampleSelect" rows="6" class="">Remarks</label>
                        <textarea class="form-control" id="remarks" name="remarks" style="height: 95px;"></textarea>
                    </div>        
                </div>
            </div> --}}
        </form>
    </div>
</div>
<div class="row mb-3 border-top pt-3">
    <div class="col-12">
        <button class="float-right btn btn-shadow btn-success declare_rtb">Declare RTB</button>                                            
    </div>
</div>

<script>
    $(function() {
        $("#datepicker").datepicker();
        $("#datepicker").on("change",function(){
            var selected = $(this).val();
            $("#rtb_declaration_date").val(selected);
        });


        $(".declare_rtb").on("click", function (e){
            e.preventDefault();

            var sam_id = $("#details_sam_id").val();
            var rtb_declaration_date = $("#rtb_declaration_date").val();
            var rtb_declaration = $("#rtb_declaration").val();
            var site_vendor_id = $("#modal_site_vendor_id").val();
            var program_id = $("#modal_program_id").val();
            var activity_name = "rtb_declation";
            // var remarks = $("#remarks").val();

            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            $("small").text("");

            $.ajax({
                url: "/declare-rtb",
                method: "POST",
                data: {
                    sam_id : sam_id,
                    rtb_declaration_date : rtb_declaration_date,
                    rtb_declaration : rtb_declaration,
                    activity_name : activity_name,
                    site_vendor_id : site_vendor_id,
                    program_id : program_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(resp){
                    if(!resp.error){
                        $("#"+$(".ajax_content_box").attr("data-what_table")).DataTable().ajax.reload(function(){
                            $("#viewInfoModal").modal("hide");
                            $("#rtb_declaration_date").val("");

                            $(".declare_rtb").removeAttr("disabled");
                            $(".declare_rtb").text("Declare RTB");

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
                        $(".declare_rtb").removeAttr("disabled");
                        $(".declare_rtb").text("Declare RTB");
                    }
                },
                error: function(resp){
                    Swal.fire(
                        'Error',
                        resp.message,
                        'error'
                    )
                    $(".declare_rtb").removeAttr("disabled");
                    $(".declare_rtb").text("Declare RTB");
                }
            });
        });
    });


</script>
