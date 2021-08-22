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

        <div class="confirm_schedule_button d-none">
            <button class="float-right btn btn-shadow btn-primary confirm_schedule" id="confirm_schedule" data-action="true">Confirm Schedule</button>
            <button class="float-right btn btn-shadow btn-secondary mr-1 back_button_sched" id="back_button_sched">Back</button>
        </div>
    </div>
</div>

<div class="row mb-3 border-top my-3">
    <div class="col-12 table_scheduled_jtss d-none">
        <h3>JTSS List of Schedule</h3>
        <div class="row"></div>
    </div>
</div>


<script>

    $(document).ready(function(){

        $('#datepicker').datepicker({
            minDate : 0
        });

        $(".back_button_sched").on("click", function (e) {
            e.preventDefault();

            $("form")[0].reset();
            $(".confirm_schedule_button").addClass('d-none');
            $(".set_schedule").removeClass('d-none');
        })

        $(".btn_switch_back_to_actions").on("click", function(){
            $("#actions_box").addClass('d-none');
            $("#actions_list").removeClass('d-none');
        });

        $("#datepicker").on("change",function(){
            var selected = $(this).val();
            $("#jtss_schedule").val(selected);
        });

        if ("{{ count( \Auth::user()->check_schedule_jtss($samid) ) }}" == 0) {
            $(".table_scheduled_jtss").addClass("d-none");
        } else {
            $(".table_scheduled_jtss").removeClass("d-none");
        }

        $(".table_scheduled_jtss").html(
            '<div class="table-responsive table_scheduled_jtss_parent">' +
                '<table class="table_scheduled_jtss_child align-middle mb-0 table table-borderless table-striped table-hover w-100">' +
                    '<thead>' +
                        '<tr>' +
                            '<th style="width: 5%">#</th>' +
                            '<th>Remarks</th>' +
                            '<th style="width: 35%">Status</th>' +
                            '<th style="width: 35%">Date Scheduled</th>' +
                            '<th style="width: 35%">Date Created</th>' +
                        '</tr>' +
                    '</thead>' +
                '</table>' +
            '</div>'
        );

        $(".table_scheduled_jtss_child").attr("id", "table_scheduled_jtss_" +  "{{ $samid }}");

        if (! $.fn.DataTable.isDataTable('#table_scheduled_jtss_'+  "{{ $samid }}") ){   
            $('#table_scheduled_jtss_'+  "{{ $samid }}").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/get-my-scheduled-jtss/"+ "{{ $samid }}",
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                dataSrc: function(json){
                    return json.data;
                },
                'createdRow': function( row, data, dataIndex ) {
                    $(row).attr('data-remarks', JSON.parse(data.value.replace(/&quot;/g,'"')).remarks );
                    $(row).attr('data-jtss_schedule', JSON.parse(data.value.replace(/&quot;/g,'"')).jtss_schedule );
                    $(row).attr('data-id', data.id);
                    $(row).addClass('schedule_jtss_data');
                    $(row).attr('style', 'cursor: pointer');
                },
                columns: [
                    { data: "id" },
                    { data: "remarks" },
                    { data: "status_sched" },
                    { data: "jtss_schedule" },
                    { data: "date_created" },
                ],
            });
        } else {
            $('#table_scheduled_jtss_'+  "{{ $samid }}").DataTable().ajax.reload();
        }
    
        $(".set_schedule").on("click", function(e) {
            e.preventDefault();
            var sam_id = "{{ $samid }}";
            var site_vendor_id = $("#modal_site_vendor_id").val();
            var program_id = $("#modal_program_id").val();
            var remarks = $("#remarks").val();
            var jtss_schedule = $("#jtss_schedule").val();
            var activity_name = "jtss_schedule";
            var status = "jtss_scheduled";


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
                    status : status,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(resp){
                    if(!resp.error){
                        $("#"+$(".ajax_content_box").attr("data-what_table")).DataTable().ajax.reload(function(){
                            // $("#viewInfoModal").modal("hide");

                            $(".set_schedule").removeAttr("disabled");
                            $(".set_schedule").text("Set Schedule");

                            Swal.fire(
                                'Success',
                                resp.message,
                                'success'
                            )
                        });

                        $('#table_scheduled_jtss_'+  "{{ $samid }}").DataTable().ajax.reload();
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

        $(document).on("click", ".schedule_jtss_data", function (e){
            e.preventDefault();

            var remarks = $(this).attr('data-remarks');
            var id = $(this).attr('data-id');
            var jtss_schedule = $(this).attr('data-jtss_schedule');

            $("form #jtss_schedule").val(jtss_schedule);
            $("form #remarks").val(remarks);

            $(".confirm_schedule").attr("data-id", id);

            $(".confirm_schedule_button").removeClass('d-none');
            $(".set_schedule").addClass('d-none');
        });

        $(document).on("click", ".confirm_schedule", function (e) { 
            e.preventDefault();

            var sam_id = ["{{ $samid }}"];
            var activity_id = ["{{ $activityid }}"];
            var site_category = ["{{ $sitecategory }}"];
            var program_id = $("#modal_program_id").val();
            var id = $(this).attr('data-id');

            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            $.ajax({
                url: "/confirm-schedule",
                method: "POST",
                data : {
                    sam_id : sam_id,
                    activity_id : activity_id,
                    site_category : site_category,
                    program_id : program_id,
                    id : id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp) {
                    if (!resp.error) {
                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )

                        $(".confirm_schedule").removeAttr("disabled");
                        $(".confirm_schedule").text("Confirm Schedule");

                        $("#viewInfoModal").modal("hide");
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )

                        $(".confirm_schedule").removeAttr("disabled");
                        $(".confirm_schedule").text("Confirm Schedule");
                    }
                },
                error: function (resp) {
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )

                    $(".confirm_schedule").removeAttr("disabled");
                    $(".confirm_schedule").text("Confirm Schedule");
                }
            });
        });
    })
</script>
