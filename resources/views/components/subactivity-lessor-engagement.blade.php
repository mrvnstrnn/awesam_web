<div class="row border-bottom">
    <div class="col-6">
        <button class="btn_switch_back_to_actions btn btn-shadow btn-secondary btn-sm mb-3">Back to Actions</button>                                            
    </div>
</div>

<div class="row pt-4">
    <div class="col-md-12">
        <H5 id="active_action">{{ $sub_activity }}</H5>
    </div>
</div>

<div id="action_lessor_engagement" class=''>
    <div class="row py-5 px-4" id="control_box">
        <div class="col-md-3 col-sm-6 col-xs-6 my-3 text-center contact-lessor" data-value="Call">
            <i class="fa fa-phone fa-4x" aria-hidden="true" title=""></i>
            <div class="pt-3"><small>Call</small></div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-6 my-3 text-center contact-lessor" data-value="Text">
            <i class="fa fa-mobile fa-4x" aria-hidden="true" title=""></i>
            <div class="pt-3"><small>Text</small></div>
        </div>
        <div class="col-md-3 col-sm-6 my-3 text-center contact-lessor" data-value="Email">
            <i class="fa fa-envelope fa-4x" aria-hidden="true" title=""></i>
            <div class="pt-3"><small>Email</small></div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-6 my-3 text-center contact-lessor" data-value="Site Visit">
            <i class="fa fa-location-arrow fa-4x" aria-hidden="true" title=""></i>
            <div class="pt-3"><small>Site Visit</small></div>

        </div>
    </div>
    <div class="row py-3 px-5 d-none" id="control_form">
        <div class="col-12 py-3">
        <form class="engagement_form">
            <div class="position-relative row form-group">
                <label for="lessor_date" class="col-sm-3 col-form-label">Date</label>
                <div class="col-sm-9">
                    <input type="text" id="lessor_date" name="lessor_date" class="form-control" readonly>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="lessor_method" class="col-sm-3 col-form-label">Method</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="lessor_method" name="lessor_method" readonly>
                </div>
            </div>
            
            <div class="position-relative row form-group">
                <label for="name" class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="name" name="name">
                    <small class="text-danger name-errors"></small>
                </div>
            </div>

            <div class="position-relative row form-group email_div d-none">
                <label for="email" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                    <input type="email" class="form-control" id="email" name="email">
                    <small class="text-danger email-errors"></small>
                </div>
            </div>

            <div class="position-relative row form-group">
                <label for="contact_no" class="col-sm-3 col-form-label">Contact Number</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="contact_no" name="contact_no">
                    <small class="text-danger contact_no-errors"></small>
                </div>
            </div>

            <div class="position-relative row form-group">
                <label for="lessor_remarks" class="col-sm-3 col-form-label">Remarks</label>
                <div class="col-sm-9">
                    <textarea name="lessor_remarks" id="lessor_remarks" class="form-control"></textarea>
                    <small class="text-danger lessor_remarks-errors"></small>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="lessor_approval" class="col-sm-3 col-form-label">Approval</label>
                <div class="col-sm-9">
                    <select name="lessor_approval" id="lessor_approval" class="form-control">
                        <option value="active">Approval not yet secured</option>
                        <option value="approved">Approval Secured</option>
                        <option value="denied">Lessor Rejected</option>
                    </select>
                    <small class="text-danger lessor_approval-errors"></small>
                </div>
            </div>
            <div class="position-relative row form-group">
                <div class="col-sm-10 offset-sm-3">
                    <button class="btn btn-lg btn-shadow btn-secondary cancel_engagement" type="button">Cancel Engagement</button>
                    <button class="btn btn-lg btn-shadow btn-primary save_engagement" type="button">Save Engagement</button>
                </div>
            </div>
        </form>
        </div>

    </div>
    <div class="row">
        <div class="col-12 table-responsive table_lessor_engage_parent">
            {{-- <table class="table_lessor align-middle mb-0 table table-borderless table-striped table-hover w-100">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Method</th>
                        <th>Remarks</th>
                        <th>Approved</th>
                    </tr>
                </thead>
            </table> --}}
        </div>
    </div>
</div>


<script>
    $(".btn_switch_back_to_actions").on("click", function(){
        $("#actions_box").addClass('d-none');
        $("#actions_list").removeClass('d-none');
    });

    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    today = mm + '/' + dd + '/' + yyyy;

    $("#control_box").on("click", ".contact-lessor", function(){
        $('#control_box').addClass('d-none');
        $('#control_form').removeClass('d-none');

        $("#lessor_method").val($(this).attr("data-value"));
        $("#lessor_date").val(today);

        if ( $(this).attr("data-value") == 'Email' ) {
            $(".email_div").removeClass('d-none');
        } else {
            $(".email_div").addClass('d-none');
        }
    });

    var sub_activity_id = "{{ $sub_activity_id }}";
    var sam_id = "{{ $sam_id }}";

    htmllist = '<table class="table_uploaded align-middle mb-0 table table-borderless table-striped table-hover w-100">' +
                    '<thead>' +
                        '<tr>' +
                            '<th style="width: 5%">#</th>' +
                            '<th>Method</th>' +
                            '<th style="width: 35%">Remarks</th>' +
                            '<th style="width: 20%">Name</th>' +
                            '<th style="width: 15%">Email</th>' +
                            '<th style="width: 15%">Contact No</th>' +
                            '<th style="width: 10%">Status</th>' +
                            '<th>Date Approved</th>' +
                        '</tr>' +
                    '</thead>' +
                '</table>';

    $('.table_lessor_engage_parent').html(htmllist);
    $(".table_uploaded").attr("id", "table_lessor_engage_"+sub_activity_id);

    if (! $.fn.DataTable.isDataTable("#table_lessor_engage_"+sub_activity_id) ){
        $("#table_lessor_engage_"+sub_activity_id).DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/get-engagement/"+sub_activity_id+"/"+sam_id,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            dataSrc: function(json){
                return json.data;
            },
            columns: [
                { data: "id" },
                { data: "method" },
                { data: "value" },
                { data: "name" },
                { data: "email" },
                { data: "contact_no" },
                { data: "status" },
                { data: "date_created" },
            ],
        });
    } else {
        $("#table_lessor_engage_"+sub_activity_id).DataTable().ajax.reload();
    }

    $(".engagement_form").on("click", ".save_engagement", function (e){
        // e.preventDefault();
        var lessor_method = $("#lessor_method").val();
        var lessor_approval = $("#lessor_approval").val();
        var lessor_remarks = $("#lessor_remarks").val();
        var name = $("#name").val();
        var contact_no = $("#contact_no").val();
        var email = $("#email").val();
        var site_vendor_id = $("#modal_site_vendor_id").val();
        var program_id = "{{ $program_id }}";
        var sam_id = "{{ $sam_id }}";
        // var sub_activity_id = $(this).attr("data-sub_activity_id");
        var sub_activity_id = "{{ $sub_activity_id }}";
        var site_name = $("#viewInfoModal .menu-header-title").text();

        var activity_id = ["{{ $activity_id }}"];
        var site_category = ["{{ $site_category }}"];

        $(this).attr('disabled', 'disabled');
        $(this).text('Processing...');

        $("form.engagement_form small").text("");

        $.ajax({
            url: "/add-engagement",
            method: "POST",
            data: {
                lessor_method : lessor_method,
                lessor_approval : lessor_approval,
                lessor_remarks : lessor_remarks,
                sam_id : sam_id,
                sub_activity_id : sub_activity_id,
                site_name : site_name,
                site_vendor_id : site_vendor_id,
                program_id : program_id,
                activity_id : activity_id,
                site_category : site_category,
                name : name,
                contact_no : contact_no,
                email : email,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp){
                if (!resp.error) {

                    $('#table_lessor_engage_'+sub_activity_id).DataTable().ajax.reload(function (){
                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )

                        // $("#viewInfoModal").modal("hide");
                        $("#lessor_remarks").val("");
                        $(".save_engagement").removeAttr('disabled');
                        $(".save_engagement").text('Save Engagement');

                        $(".cancel_engagement").trigger("click");
                    });
                    
                } else {
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $("." + index + "-errors").text(data);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }
                    $(".save_engagement").removeAttr('disabled');
                    $(".save_engagement").text('Save Engagement');
                }
            },
            error: function (resp){
                Swal.fire(
                    'Error',
                    resp.message,
                    'error'
                )
                $(".save_engagement").removeAttr('disabled');
                $(".save_engagement").text('Save Engagement');
            }
        });
    });


    $(".engagement_form").on("click", ".cancel_engagement", function(){
        $('#control_box').removeClass('d-none');
        $('#control_form').addClass('d-none');
    });


</script>