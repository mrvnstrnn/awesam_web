<div class="row border-bottom">
    <div class="col-6">
        <button class="btn_switch_back_to_actions btn btn-shadow btn-secondary btn-sm mb-3">Back to Actions</button>                                            
    </div>
</div>
<div class="row pt-4">
    <div class="col-md-12">
        <H5 id="active_action">Schedule Advanced Site Hunting</H5>
    </div>
</div>
<div class="row pt-4">
    <div class="col-12">
        <form>
            <div class="form-row"> 
                <div class="col-md-5 col-12">
                    <div class="position-relative form-group">
                        <label for="site_schedule">Site Schedule</label>
                    </div>
                </div>
                <div class="col-md-7 col-12">
                    <div class="position-relative form-group">
                        <input type="text" id="site_schedule" name="site_schedule" class="flatpicker form-control" style="background-color: white;" />
                        <small class="site_schedule-error text-danger"></small>
                    </div>        
                </div>
            </div>
            <div class="form-row"> 
                <div class="col-md-5 col-12">
                    <div class="position-relative form-group">
                        <label for="remarks" class="">Remarks</label>
                    </div>
                </div>
                
                <div class="col-md-7 col-12">
                    <div class="position-relative form-group">
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

        $(".flatpicker").flatpickr();

        $("input[name=site_schedule]").flatpickr(
            { 
            minDate: new Date()
            }
        );

        $(".btn_switch_back_to_actions").on("click", function(){
            $("#actions_box").addClass('d-none');
            $("#actions_list").removeClass('d-none');
        });

        $('#datepicker').datepicker({
            minDate : 0
        });

        $("#datepicker").on("change",function(){
            var selected = $(this).val();
            $("#site_schedule").val(selected);
        });
    
        $(".set_schedule").on("click", function(e) {
            e.preventDefault();
            var sam_id = "{{ $sam_id }}";
            var site_vendor_id = $("#modal_site_vendor_id").val();
            var program_id = "{{ $program_id }}";
            var site_category = "{{ $site_category }}";
            var activity_id = "{{ $activity_id }}";
            var remarks = $("#remarks").val();
            var site_schedule = $("#site_schedule").val();
            var activity_name = "site_schedule";


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
                    site_schedule : site_schedule,
                    site_category : site_category,
                    activity_id : activity_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(resp){
                    if(!resp.error){
                        // $("#"+$(".ajax_content_box").attr("data-what_table")).DataTable().ajax.reload(function(){
                            $("#viewInfoModal").modal("hide");

                            $(".set_schedule").removeAttr("disabled");
                            $(".set_schedule").text("Set Schedule");

                            Swal.fire(
                                'Success',
                                resp.message,
                                'success'
                            )
                        // });
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
                        resp,
                        'error'
                    )
                    $(".set_schedule").removeAttr("disabled");
                    $(".set_schedule").text("Set Schedule");
                }
            });
        });
    })
</script>
