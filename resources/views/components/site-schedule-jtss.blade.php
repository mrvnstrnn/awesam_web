<div class="row border-bottom">
    <div class="col-6">
        <button class="btn_switch_back_to_actions btn btn-shadow btn-secondary btn-sm mb-3">Back to Actions</button>                                            
    </div>
</div>

<div class="row pt-4">
    <div class="col-md-12">
        <H5 id="active_action">Schedule JTSS</H5>
    </div>
</div>

<div class="row pt-4">
    <div class="col-lg-6">
        <div id="datepicker" class=""></div>
    </div>
    <div class="col-lg-6">
        <form>
            <div class="form-row"> 
                <div class="col-md-12">
                    <div class="position-relative form-group">
                        <label for="jtss_schedule">JTSS Schedule</label>
                        <input type="text" id="jtss_schedule" name="jtss_schedule" value="" class="form-control" readonly />
                        <small class="jtss_schedule-error text-danger"></small>
                    </div>        
                </div>
            </div>
            <div class="form-row"> 
                <div class="col-md-12">
                    <div class="position-relative form-group">
                        <label for="remarks" class="">Remarks</label>
                        <textarea class="form-control"  rows="10" id="remarks" name="remarks" style="height: 175px;"></textarea>
                        <small class="remarks-error text-danger"></small>
                    </div>        
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row mb-3 border-top pt-3 mt-2">
    <div class="col-12 align-right">
        <button class="float-right btn btn-shadow btn-success set_schedule" id="set_schedule" data-action="true" data-sam_id="">Set Schedule</button>                                            
    </div>
</div>


<script>

    $(document).ready(function(){

        $('#datepicker').datepicker({
            minDate : 0
        });

        $(".btn_switch_back_to_actions").on("click", function(){
            $("#actions_box").addClass('d-none');
            $("#actions_list").removeClass('d-none');
        });

        $("#datepicker").on("change",function(){
            var selected = $(this).val();
            $("#jtss_schedule").val(selected);
        });
    
        $(".set_schedule").on("click", function(e) {
            e.preventDefault();
            var sam_id = $("#modal_sam_id").val();
            var site_vendor_id = $("#modal_site_vendor_id").val();
            var program_id = $("#modal_program_id").val();
            var remarks = $("#remarks").val();
            var jtss_schedule = $("#jtss_schedule").val();
            var activity_name = "jtss_schedule";


            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");
            
            $("small.text-danger").text("");

            $.ajax({
                url: "/schedule-jtss",
                method: "POST",
                data: {
                    sam_id : sam_id,
                    remarks : remarks,
                    activity_name : activity_name,
                    site_vendor_id : site_vendor_id,
                    program_id : program_id,
                    jtss_schedule : jtss_schedule,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(resp){
                    if(!resp.error){
                        $("#"+$(".ajax_content_box").attr("data-what_table")).DataTable().ajax.reload(function(){
                            $("#viewInfoModal").modal("hide");

                            $(".set_schedule").removeAttr("disabled");
                            $(".set_schedule").text("Set Schedule");

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

                        $(".set_schedule").removeAttr("disabled");
                        $(".set_schedule").text("Set Schedule");
                    }
                },
                error: function(resp){
                    Swal.fire(
                        'Error',
                        resp.message,
                        'error'
                    )
                    $(".set_schedule").removeAttr("disabled");
                    $(".set_schedule").text("Set Schedule");
                }
            });
        });
    })
</script>
