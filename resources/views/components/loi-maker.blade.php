<div class="row border-bottom">
    <div class="col-12">
        <button class="btn_switch_back_to_actions btn btn-shadow btn-secondary btn-sm mb-3">Back to Actions</button>                                            
    </div>
</div>

<div class="row pt-4">
    <div class="col-md-12">
        <H5 id="active_action">{{ $sub_activity }}</H5>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="form_html"></div>
        <form class="site_data_form">
            <input type="hidden" name="sam_id" id="sam_id" value="{{ $sam_id }}">
            <input type="hidden" name="sub_activity_id" id="sub_activity_id" value="{{ $sub_activity_id }}">
            <input type="hidden" name="site_category" id="site_category" value="{{ $site_category }}">
            <input type="hidden" name="program_id" id="program_id" value="{{ $program_id }}">
            <input type="hidden" name="activity_id" id="activity_id" value="{{ $activity_id }}">
        </form>
    </div>
</div>

<div class="row mt-3 mb-3">
    <div class="col-12">
        <div class="table_html"></div>
        <div class="file_div d-none">
            <div class="row">
                <div class="col-12">
                    <div class="file_viewer"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <button class="btn btn-lg btn-primary btn-shadow back_to_form">Back to form</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(".btn_switch_back_to_actions").on("click", function(){
        $("#actions_box").addClass('d-none');
        $("#actions_list").removeClass('d-none');
    });

    $(".table_html").html(
        '<div class="table-responsive table_uploaded_parent">' +
            '<table class="table_uploaded align-middle mb-0 table table-borderless table-striped table-hover w-100">' +
                '<thead>' +
                    '<tr>' +
                        '<th style="width: 5%">#</th>' +
                        '<th style="width: 35%">Filename</th>' +
                        '<th style="width: 15%">Status</th>' +
                        '<th style="width: 35%">Reason</th>' +
                        '<th>Date Uploaded</th>' +
                    '</tr>' +
                '</thead>' +
            '</table>' +
        '</div>'
    );

    if (! $.fn.DataTable.isDataTable(".table_uploaded") ){   
        $(".table_uploaded").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/get-uploaded-files/" + "{{ $sub_activity_id }}" + "/" + "{{ $sam_id }}",
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            dataSrc: function(json){
                return json.data;
            },
            'createdRow': function( row, data, dataIndex ) {
                $(row).attr('data-value', data.value);
                $(row).attr('style', 'cursor: pointer');
            },
            columns: [
                { data: "id" },
                { data: "value" },
                { data: "status" },
                { data: "reason" },
                { data: "date_created" },
            ],
        });
    } else {
        $(".table_uploaded").DataTable().ajax.reload();
    }

    $(".file_div").on("click", ".back_to_form", function () {
        $(".table_html").removeClass("d-none");
        $(".form_html").removeClass("d-none");
        $(".file_div").addClass("d-none");
    });

    $(".table_html").on("click", ".table_uploaded tr td", function () {

        var extensions = ["pdf", "jpg", "png"];

        var values = $(this).parent().attr('data-value');

        if( extensions.includes(values.split('.').pop()) == true) {     
            htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 400px; height: 100%" src="/ViewerJS/#../files/' + values + '" allowfullscreen></iframe>';
        } else {
            htmltoload = '<div class="text-center my-5"><a href="/files/' + values + '"><i class="fa fa-fw display-1" aria-hidden="true" title="Copy to use file-excel-o"></i><H5>Download Document</H5></a><small>No viewer available; download the file to check.</small></div>';
        }

        $(".file_viewer").html(htmltoload);

        $(".table_html").addClass("d-none");
        $(".form_html").addClass("d-none");
        $(".file_div").removeClass("d-none");
    });

    $(".form_html").on("click", ".save_create_loi_to_renew_btn", function(e){
        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        var sub_activity_id = "{{ $sub_activity_id }}";

        var company = $("#company").val();
        var vendor = $("#vendor").val();
        var lessor = $("#lessor").val();
        var facility_site_address = $("#facility_site_address").val();
        var expiration = $("#expiration").val();
        var undersigned_number = $("#undersigned_number").val();
        var undersigned_email = $("#undersigned_email").val();

        $.ajax({
            url: "/save-loi",
            method: "POST",
            data: $(".create_loi_to_renew_form, .site_data_form").serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp) {
                if (!resp.error) {

                    $(".table_uploaded").DataTable().ajax.reload(function () {

                        $(".create_loi_to_renew_form")[0].reset();

                        $("#company").val(company);
                        $("#vendor").val(vendor);
                        $("#lessor").val(lessor);
                        $("#facility_site_address").val(facility_site_address);
                        $("#expiration").val(expiration);
                        $("#undersigned_number").val(undersigned_number);
                        $("#undersigned_email").val(undersigned_email);

                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )

                        $(".action_to_complete_child"+sub_activity_id+" i.text-success").remove();

                        $(".action_to_complete_parent .action_to_complete_child"+sub_activity_id).append(
                            '<i class="fa fa-check-circle fa-lg text-success" style="right: 20px"></i>'
                        );

                        $(".save_create_loi_to_renew_btn").removeAttr("disabled");
                        $(".save_create_loi_to_renew_btn").text("Save LOI");
                        // $(".btn_switch_back_to_actions").trigger("click");
                    });

                    // $("#viewInfoModal").modal("hide");
                } else {
                    
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $(".create_loi_to_renew_form ." + index + "-error").text(data);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }

                    $(".save_create_loi_to_renew_btn").removeAttr("disabled");
                    $(".save_create_loi_to_renew_btn").text("Save LOI");
                }
            },
            error: function (resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )

                $(".save_create_loi_to_renew_btn").removeAttr("disabled");
                $(".save_create_loi_to_renew_btn").text("Save LOI");
            }
        });
    });
    
    $(document).ready(function(){
        $.ajax({
            url: "/get-form/" + "{{ $sub_activity_id }}" + "/" + "{{ $sub_activity }}",
            method: "GET",
            success: function (resp) {
                if (!resp.error) {
                    $(".form_html").html(resp.message);

                    var sam_id = "{{ $sam_id }}";
                    var program_id = "{{ $program_id }}";
                    var type = "loi";
                    $.ajax({
                        url: "/get-form-program-data",
                        method: "POST",
                        data : {
                            sam_id : sam_id,
                            program_id : program_id,
                            type : type,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (resp) {
                            if (!resp.error) {
                                $.each(resp.message, function(index, data) {
                                    $(".create_loi_to_renew_form #"+index).val(data);
                                    if (index == 'expiration') {
                                        expiration_date = data.split("/")
                                        new_expiration_date = [ expiration_date[1], expiration_date[0], expiration_date[2] ].join('-');
                                        
                                        $(".create_loi_to_renew_form #expiration_date").val(new_expiration_date);
                                    }
                                    if (index == 'site_address') {
                                        $(".create_loi_to_renew_form #facility_site_address").val(data);
                                    }
                                });
                                
                                $(".create_loi_to_renew_form #undersigned_email").val("{{ \Auth::user()->getUserDetail()->first()->email }}");
                                $(".create_loi_to_renew_form #undersigned_number").val("{{ \Auth::user()->getUserDetail()->first()->contact_no }}");
                            } else {
                                Swal.fire(
                                    'Error',
                                    resp.message,
                                    'error'
                                )
                            }
                        },
                        error: function (resp) {
                            Swal.fire(
                                'Error',
                                resp,
                                'error'
                            )
                        }
                    });

                } else {
                    Swal.fire(
                        'Error',
                        resp.message,
                        'error'
                    )
                }
            },
            error: function (resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )
            }
        });
    });

    $(".form_html").on("change", "#new_terms_start_date, #new_lease_terms_in_years", function(e){
        var new_lease_terms_in_years = $("#new_lease_terms_in_years").val();
        var new_terms_start_date = $("#new_terms_start_date").val();
        if ( new_lease_terms_in_years != null && new_terms_start_date != null ) {
            var new_lease_terms_in_years = $("#new_lease_terms_in_years").val();
            var new_terms_start_date = new Date($("#new_terms_start_date").val());

            new_date = new_terms_start_date.setFullYear(new_terms_start_date.getFullYear() + +new_lease_terms_in_years);

            new_new_terms_start_date = new Date(new_date);

            new_new_terms_start_date.setDate(new_new_terms_start_date.getDate() - 1);

            date_day = ( new_new_terms_start_date.getDate() ) < 10 ? "0" + (new_new_terms_start_date.getDate() ) : new_new_terms_start_date.getDate();

            var new_month = ( new_new_terms_start_date.getMonth() + 1 ) < 10 ?  "0" + ( new_new_terms_start_date.getMonth() + 1 ) : ( new_new_terms_start_date.getMonth() + 1 );
            let formatted_new_date =  new_new_terms_start_date.getFullYear() + "-" + new_month + "-" + date_day;

            $(".form_html #new_terms_end_date").val(formatted_new_date);

        }
    });
</script>