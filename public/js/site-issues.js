
    $("#start_date").flatpickr(
    { 
        maxDate: new Date()
    });


    if ( ! $.fn.DataTable.isDataTable('.my_table_issue') ) {
        $('.my_table_issue').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: $('.my_table_issue').attr('data-href'),
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            dataSrc: function(json){
                return json.data;
            },
            'createdRow': function( row, data, dataIndex ) {
                $(row).attr('data-id', data.issue_id);
                $(row).attr('style', "cursor: pointer");
            },
            columns: [
                { data: "id" },
                { data: "name" },
                { data: "start_date" },
                { data: "issue" },
                { data: "issue_details" },
                { data: "issue_status" },
            ],
        });
    }

    $('#btn_add_issue_cancel').on( 'click', function (e) {
        $('.add_issue_form').addClass('d-none');
        $('#btn_add_issue_switch').removeClass('d-none');
        $('#issue_table').removeClass('d-none');
        $(".add_remarks_issue_form").addClass("d-none");

    });

    $('#btn_add_issue_switch').on( 'click', function (e) {
        $('.add_issue_form').removeClass('d-none');
        $(this).addClass('d-none');
        $('#issue_table').addClass('d-none');
    });

    $("#issue_type").on("change", function (){
        if($(this).val() != ""){
            $("select[name=issue] option").remove();
            $.ajax({
                url: "/get-issue/"+$(this).val(),
                method: "GET",
                success: function (resp){
                    if(!resp.error){
                        resp.message.forEach(element => {
                            $("select[name=issue]").append(
                                '<option value="'+element.issue_type_id+'">'+element.issue+'</option>'
                            );
                        });
                    } else {
                        toastr.error(resp.message, "Error");
                    }
                },
                error: function (resp){
                    toastr.error(resp.message, "Error");
                }
            });
        }
    });

    $(".add_issue").on("click", function (){
        $("small").text("");
        $.ajax({
            url: "/add-issue",
            method: "POST",
            data: $(".add_issue_form").serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp){
                if(!resp.error){
                    $('.my_table_issue').DataTable().ajax.reload(function(){
                        $(".add_issue_form")[0].reset();
                        $('#btn_add_issue_cancel').trigger("click");
                        toastr.success(resp.message, "Success");
                        $( "#issue_table" ).fadeIn( "slow", function() {
                            $('#issue_table').removeClass('d-none');
                        }); 

                    });
                } else {
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $("." + index + "-error").text(data);
                        });
                    } else {
                        toastr.error(resp.message, 'Error');
                    }
                }
            },
            error: function (resp){
                toastr.error(resp.message, "Error");
            }
        });
    });

    $('.my_table_issue').on("click", "tr td", function(){
        if($(this).attr("colspan") != 6){
            $.ajax({
                url: "/get-issue/details/"+$(this).parent().attr('data-id'),
                method: "GET",
                success: function (resp){
                    if(!resp.error){
                        if(resp.message.issue_status == "cancelled"){
                            $(".cancel_issue").addClass("d-none");
                        } else {
                            $(".cancel_issue").removeClass("d-none");
                        }

                        $(".add_button_issue_div").addClass("d-none");
                        $("#issue_table").addClass("d-none");

                        $(".view_issue_form").removeClass("d-none");
                        $(".cancel_issue").attr("data-id", resp.message.issue_id);

                        $(".view_issue_form input[name=issue]").val(resp.message.issue);
                        $(".view_issue_form input[name=start_date]").val(resp.message.start_date);
                        $(".view_issue_form input[name=issue_type]").val(resp.message.issue_type);
                        $(".view_issue_form textarea[name=issue_details]").text(resp.message.issue_details);

                        
                        $(".add_remarks_issue_form #site_issue_id").val(resp.message.issue_id);

                        $('.table-list-issue').html("");
                        htmllist = '<div class="table-responsive table_issue_parent">' +
                            '<table class="table_issue_remarks align-middle mb-0 table table-borderless table-striped table-hover w-100">' +
                                '<thead>' +
                                    '<tr>' +
                                        '<th style="width: 5%">#</th>' +
                                        '<th style="width: 35%">Remarks</th>' +
                                        '<th>Status</th>' +
                                        '<th>Date Engage</th>' +
                                    '</tr>' +
                                '</thead>' +
                            '</table>' +
                        '</div>';

                        $('.table-list-issue').html(htmllist);
                        $(".table_issue_remarks").attr("id", "table_issue_child_"+resp.message.issue_id);

                        if (! $.fn.DataTable.isDataTable("#table_issue_child_"+resp.message.issue_id) ){
                            $("#table_issue_child_"+resp.message.issue_id).DataTable({
                                processing: true,
                                serverSide: true,
                                ajax: {
                                    url: "/get-site_issue_remarks/"+resp.message.issue_id,
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
                                    { data: "remarks" },
                                    { data: "status" },
                                    { data: "date_engage" },
                                ],
                            });
                        } else {
                            $("#table_issue_child_"+sub_activity_id).DataTable().ajax.reload();
                        }
                        
                    } else {
                        toastr.error(resp.message, "Error");
                    }
                },
                error: function (resp){
                    toastr.error(resp.message, "Error");
                }
            });
            
            $(".view_issue_form issue input[name=issue_id]").val();
        }
    });

    $(".btn_back_to_list").on("click", function(){
        $(".add_button_issue_div").removeClass("d-none");
        $("#issue_table").removeClass("d-none");
        $(".view_issue_form").addClass("d-none");
        $('.table-list-issue').html("");
        $(".add_remarks_issue_form").addClass("d-none");
    });

    $("#btn_add_remarks").on("click", function(){
        $(".add_remarks_issue_form").removeClass("d-none");
        $(".view_issue_form").addClass("d-none");
    });

    $(".btn_cancel_remarks").on("click", function(){
        $(".add_remarks_issue_form").addClass("d-none");
        $(".view_issue_form").removeClass("d-none");
    });

    $(".add_btn_remarks_submit").on("click", function(){

        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        var site_issue_id = $("#site_issue_id").val();

        $.ajax({
            url: "/add-remarks",
            method: "POST",
            data: $(".remarks_issue_form").serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp){
                if (!resp.error) {
                    $("#table_issue_child_"+site_issue_id).DataTable().ajax.reload(function(){
                        $(".remarks_issue_form")[0].reset();
                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )

                        $(".add_btn_remarks_submit").removeAttr("disabled");
                        $(".add_btn_remarks_submit").text("Add Remarks");
                    });

                    $(".my_table_issue").DataTable().ajax.reload();
                    
                } else {
                    Swal.fire(
                        'Error',
                        resp.message,
                        'error'
                    )

                    $(".add_btn_remarks_submit").removeAttr("disabled");
                    $(".add_btn_remarks_submit").text("Add Remarks");
                }
            },
            error: function(resp){
                Swal.fire(
                    'Error',
                    resp,
                    'success'
                )

                $(".add_btn_remarks_submit").removeAttr("disabled");
                $(".add_btn_remarks_submit").text("Add Remarks");
            }
        })
    });

    $(".cancel_issue").on("click", function(){
        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");
        $.ajax({
            url: "/cancel-my-issue/"+$(this).attr('data-id'),
            method: "GET",
            success: function (resp){
                if(!resp.error){
                    $('.my_table_issue').DataTable().ajax.reload(function(){
                        toastr.success(resp.message, "Succes");
                        $("#modal_issue").modal("hide");
                        $(".cancel_issue").removeAttr("disabled");
                        $(".cancel_issue").text("Cancel Issue");
                    });
                } else {
                    toastr.error(resp.message, "Error");
                    $(".cancel_issue").removeAttr("disabled");
                    $(".cancel_issue").text("Cancel Issue");
                }
            },
            error: function (resp){
                toastr.error(resp.message, "Error");
                $(".cancel_issue").removeAttr("disabled");
                $(".cancel_issue").text("Cancel Issue");
            }
        });
    });
