    $(document).ready(function () {
    // $('.show_activity_modal').on( 'click', function (e) {
    // });
        $('li').on('click','a', function(e){
            e.preventDefault();

            if($(this).attr('href')=='/'){
                window.location.replace('/');
            }
            else if($(this).attr('href')==' /local-coops '){
                window.location.replace('/local-coops');
            }

            else if($(this).attr('href')==' /add-issue '){
                $('#add_issue').modal('show');
            }

            else if($(this).attr('href')==' /add-engagement '){
                $('#add_engagement').modal('show');
            }

            else if($(this).attr('href')==' /add-contact '){
                $('#add_contact').modal('show');
            }  

            else if($(this).attr('href')==' /approval '){
                $('#approve_modal').modal('show');
            }   

            else if($(this).attr('href')==' /coop-issues '){
                $('#table-coop-issues-div').html('');

                $('#table-coop-issues-div').html('<table id="table-coop-issues" class="align-middle mb-0 table table-borderless table-striped table-hover w-100">' +
                    '<thead>' +
                        '<tr>' +
                            '<th>COOP</th>' +
                            '<th>Region</th>' +
                            '<th>Province</th>' +
                            '<th>Dependency</th>' +
                            '<th>Issue</th>' +
                            '<th>Description</th>' +
                            '<th>Status</th>' +
                            '<th>Aging</th>' +
                        '</tr>' +
                    '</thead>' +
                    '<tbody>' +
                    '</tbody>' +
                '</table>'
                );

                $('#coop_issues').modal('show');


                $("#table-coop-issues").DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "/localcoop-issues",
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    },
                    columns: [
                        { data: "coop_name" },
                        { data: "region" },
                        { data: "province" },
                        { data: "dependency" },
                        { 
                            data: "nature_of_issue", 
                            render: function ( data, type, row ) {
                                return row['issue'] + '<br><small>' + data + '</small>';
                            } 
                        },
                        { data: "description" },
                        { data: "status_of_issue" },
                        { data: "aging"},
                    ],
                });

            }   


        });

        

        $(document).on('change', '#nature_of_issue', function(e){
            e.preventDefault();
            
            // $('#issue')
            //     .find('option')
            //     .remove()
            //     .end()
            //     .append('<option value="">Select Issue</option>')
            //     .val('');
            
            $('select#issue option').remove();
            $("select#issue").attr("disabled", "disabled");

            if ($(this).val() != "") {
                $.ajax({
                    url: "/localcoop-get-issue-list/" + $(this).val(),
                    method: "GET",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (resp){
    
                        $('#issue').append('<option value="">Select Issue</option>');
                        resp.forEach(function(data) {
                            if ($("#nature_of_issue").val() == "") {
                                $("select#issue").removeAttr("disabled");
                                // $("#issue").append(new Option(data.issue, data.issue));
                                $("select#issue").append("<option value='" + data.issue + "'>" + data.issue + "</option>");
                            }
                        });                        
    
                    },
                    error: function (resp){
                        toastr.error(resp, "Error");
                    }
                });
            }



        });


        $(document).on('click', '#table-coop-issues tbody tr', function(e){
            e.preventDefault();
        });

        
    
        $('.assigned-sites-table').on('click', 'tbody tr', function(e){
            e.preventDefault();

            $("#btn_back_to_issues").trigger("click");
            $('#coop_details').modal('show');

            $('#coop_details').find('.modal-title').html('<i class="pe-7s-gleam pe-lg mr-2"></i>' + $(this).find('td:nth(1)').text());

            $('#tab-coop-details').html('');
            $('#contacts_table tbody').empty();
            $('#engagement_table tbody').empty();
            $('#issues_table tbody').empty();

            var id = JSON.parse($(this).attr('data-site_all')).id;

            $("#contacts_table").addClass("contacts_table"+id);
            $("#engagement_table").addClass("engagement_table"+id);
            $("#issues_table").addClass("issues_table"+id);
            $("#save_history").attr('data-issue_id', id);

            $("#hidden_program_id").val( $(this).parent().parent().attr('data-program_id') );
            
            $(".add_history_form select#user_id option").remove();

            $(".table_contact_parent").html(
                '<table class="table_contact_child align-middle mb-0 table table-borderless table-striped table-hover w-100">' +
                    '<thead>' +
                        '<tr>' +
                            '<th>Date</th>' +
                            '<th>Type</th>' +
                            '<th>Firstname</th>' +
                            '<th>Lastname</th>' +
                            '<th>Cellphone</th>' +
                            '<th>Email</th>' +
                            '<th></th>' +
                        '</tr>' +
                    '</thead>' +
                '</table>'
            );

            $(".table_engagements_parent").html(
                '<table class="table_engagements_child align-middle mb-0 table table-borderless table-striped table-hover w-100">' +
                    '<thead>' +
                        '<tr>' +
                            '<th>Date</th>' +
                            '<th>Type</th>' +
                            '<th>Result</th>' +
                            '<th>Remarks</th>' +
                        '</tr>' +
                    '</thead>' +
                '</table>'
            );

            $(".table_issues_parent").html(
                '<table class="table_issues_child align-middle mb-0 table table-borderless table-striped table-hover w-100">' +
                    '<thead>' +
                        '<tr>' +
                            '<th>Date</th>' +
                            '<th>Dependency</th>' +
                            '<th>Issue</th>' +
                            '<th>Description</th>' +
                            '<th>Issue Raised By</th>' +
                            '<th>Issue Raised By Name</th>' +
                            '<th>Date Of Issue</th>' +
                            '<th>Issue Assigned To</th>' +
                            '<th>Status of Issue</th>' +
                        '</tr>' +
                    '</thead>' +
                '</table>'
            );

            $(".table_contact_parent table").attr("id", "table_contact_child_" + id);
            $(".table_engagements_parent table").attr("id", "table_engagements_child_" + id);
            $(".table_issues_parent table").attr("id", "table_issues_child_" + id);

            $('#tab-coop-details button').remove();
            
            $.ajax({
                    url: "/localcoop-details/" + $(this).find('td:first').text(),
                    method: "GET",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (resp){

                        // console.log(resp[0]);
                        var columns = resp[0];
                        
                        var html = "";

                        Object.keys(columns).forEach(function (key, index){
                            var value_column = columns[key] == null ? "" : columns[key];
                            field_name = key.charAt(0).toUpperCase() + key.slice(1);
                            
                            className = field_name != "Id" ? "" : "d-none";
                            html = html + "<div class='row "+className+"'><div class='col-5'><label>" + field_name.split('_').join(' ') + "</label></div><div class='col-7'><input class='form-control mb-2' type='text' name='" + field_name + "' id='" + field_name + "' value='" + value_column + "' readonly /></div></div>";
                        });

                        $('#tab-coop-details').html(html);

                        if ($("#hidden_profile_id").val() == 24) {
                            $('#tab-coop-details').append(
                                "<button class='btn btn-success btn-sm btn-shadow edit_details_btn' type='button'>Edit</button> <div class='div_update_area_btn d-none'><button class='btn btn-secondary btn-sm btn-shadow cancel_details_btn' type='button'>Cancel</button> <button class='btn btn-primary btn-sm btn-shadow update_details_btn' type='button'>Update</button></div>"
                            );
                        }

                    },
                    error: function (resp){
                        toastr.error(resp, "Error");
                    }
            });

            if ( ! $.fn.DataTable.isDataTable("#table_contact_child_" + id) || ! $.fn.DataTable.isDataTable("#table_engagements_child_" + id) || ! $.fn.DataTable.isDataTable("#table_issues_child_" + id) ){
                $("#table_contact_child_" + id).DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "/localcoop-values-data/" + $(this).find('td:first').text() + "/contacts",
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    },
                    dataSrc: function(json){
                        return json.data;
                    },
                    "order": [[ 0, 'desc' ]],
                    columns: [
                        { data: "add_timestamp" },
                        { data: "type" },
                        { data: "firstname" },
                        { data: "lastname" },
                        { data: "cellphone" },
                        { data: "email" },
                        { data: "action" },
                    ],
                });

                $("#table_engagements_child_" + id).DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "/localcoop-values-data/" + $(this).find('td:first').text() + "/engagements",
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    },
                    'createdRow': function( row, data, dataIndex ) {
                        $(row).attr('data-value', JSON.stringify(data));
                        $(row).attr('style', 'cursor: pointer');
                    },
                    dataSrc: function(json){
                        return json.data;
                    },
                    "order": [[ 0, 'desc' ]],
                    columns: [
                        { data: "add_timestamp" },
                        { data: "engagement_type" },
                        { data: "result_of_engagement" },
                        { data: "remarks" },
                    ],
                });

                $("#table_issues_child_" + id).DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "/localcoop-values-data/" + $(this).find('td:first').text() + "/issues",
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    },
                    'createdRow': function( row, data, dataIndex ) {
                        $(row).attr('data-value', JSON.stringify(data));
                        $(row).attr('data-id', data.ID);
                        $(row).attr('style', 'cursor: pointer');
                    },
                    dataSrc: function(json){
                        return json.data;
                    },
                    "order": [[ 0, 'desc' ]],
                    columns: [
                        { data: "add_timestamp" },
                        { data: "dependency" },
                        { 
                            data: "nature_of_issue",
                            render: function ( data, type, row ) {
                                // console.log( JSON.parse(row['value'].replace(/&quot;/g,'"')).issue );
                                var issue = JSON.parse(row['value'].replace(/&quot;/g,'"')).issue == undefined ? "No data" : JSON.parse(row['value'].replace(/&quot;/g,'"')).issue;
                                return issue + '<br><small>' + data + '</small>';
                            } 
                        },
                        { data: "description" },
                        { data: "issue_raised_by" },
                        { data: "issue_raised_by_name" },
                        { data: "date_of_issue" },
                        { data: "issue_assigned_to" },
                        { data: "status_of_issue" },
                    ],
                });
            } else {
                $("#table_contact_child_" + id).DataTable().ajax.reload();
                $("#table_engagements_child_" + id).DataTable().ajax.reload();
                $("#table_issues_child_" + id).DataTable().ajax.reload();
            }

            $.ajax({
                    url: "/agent-based-program/"+$(this).parent().parent().attr('data-program_id'),
                    method: "GET",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (resp){
                        if (!resp.error) {
                            resp.message.forEach(element => {
                                $(".add_history_form select#user_id").append(
                                    '<option value="'+element.id+'">'+element.name+'</option>'
                                );
                            });
                        } else {
                            toastr.error(resp.message, "Error");
                        }
                    },
                    error: function (resp){
                        toastr.error(resp, "Error");
                    }
            });

        });

        $(document).on('click', '.table_issues_child tbody tr', function(e){
            e.preventDefault();

            if ($('.table_issues_parent tbody tr td').attr("colspan") != 9) {

                var value_data = JSON.parse($(this).attr('data-value'));

                $(".issue_form_view #coop").val(value_data.coop);
                $(".issue_form_view #dependency").val(value_data.dependency);
                $(".issue_form_view #nature_of_issue").val(value_data.nature_of_issue);
                $(".issue_form_view #issue").val(value_data.issue);
                $(".issue_form_view #description").text(value_data.description);
                $(".issue_form_view #issue_raised_by").val(value_data.issue_raised_by);
                $(".issue_form_view #issue_raised_by_name").val(value_data.issue_raised_by_name);
                $(".issue_form_view #date_of_issue").val(value_data.date_of_issue);
                $(".issue_form_view #issue_assigned_to").val(value_data.issue_assigned_to);
                $(".issue_form_view #status_of_issue").val(value_data.status_of_issue);

                $('#issue_table_box').addClass('d-none');
                $('#issue_history_box').removeClass('d-none');
                $('.issue_form_view').removeClass('d-none');

                $("#issue_id").val( $(this).attr("data-id") );

                var id = $(this).attr("data-id");

                $(".table_history_parent").html(
                    '<table class="table_history_child align-middle mb-0 table table-borderless table-striped table-hover w-100">' +
                        '<thead>' +
                            '<tr>' +
                                '<th>Date</th>' +
                                '<th>Staff</th>' +
                                '<th>Remarks</th>' +
                                '<th>Status</th>' +
                            '</tr>' +
                        '</thead>' +
                    '</table>'
                );
                
                $(".table_history_parent table").attr("id", "table_history_child_" + id);

                if (! $.fn.DataTable.isDataTable("#table_history_child_" + id) ){
                    $("#table_history_child_" + id).DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '/issue-history-data/'+ id,
                            type: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        },
                        dataSrc: function(json){
                            return json.data;
                        },
                        "order": [[ 0, 'desc' ]],
                        columns: [
                            { data: "add_timestamp" },
                            { data: "staff" },
                            { data: "remarks" },
                            { data: "status" },
                        ],
                    });
                } else {
                    $("#table_history_child_" + id).DataTable().ajax.reload();
                }
            }

        });

        $(document).on('click', '.table_engagements_child tbody tr', function(e){
            e.preventDefault();

            if ($('.table_engagements_child tbody tr td').attr("colspan") != 4) {
                var value_data = JSON.parse($(this).attr('data-value'));

                $(".engagement_form_view #coop").val(value_data.coop);
                $(".engagement_form_view #engagement_type").val(value_data.engagement_type);
                $(".engagement_form_view #result_of_engagement").val(value_data.result_of_engagement);
                $(".engagement_form_view #remarks").text(value_data.remarks);


                $('.engagement_form_view').removeClass('d-none');
                $('.table_engagements_parent').addClass('d-none');
            }

        });

        $(document).on('click', '.back_to_engagement_list', function(e){ 
            $('.engagement_form_view').addClass('d-none');
            $('.table_engagements_parent').removeClass('d-none');
        });

        $(document).on('click', '#btn_back_to_issues', function(e){

            $('#issue_table_box').removeClass('d-none');
            $('#issue_history_box').addClass('d-none');
            $('.issue_form_view').addClass('d-none');

        });

        $(document).on('click', '#btn_add_issue', function(e){

            $('#issue_history_box').addClass('d-none');
            $('#issue_add_box').removeClass('d-none');
            $('.issue_form_view').addClass('d-none');

            $(".add_history_title").text($(".issue_form_view #nature_of_issue").val());
            $(".add_history_desc").text($(".issue_form_view #issue").val());

        });
        
        $(document).on('click', '#btn_cancel_add_issues', function(e){

            $('#issue_history_box').removeClass('d-none');
            $('#issue_add_box').addClass('d-none');
            $('.issue_form_view').removeClass('d-none');

            $(".add_history_title").text("Add History");
            $(".add_history_desc").text("Description");

        });
        
        $(document).on("click", ".add_engagement", function () {
            var type = $(this).attr("data-type");
            var table_id = $(this).attr("data-issue_id");
            
            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            if (type == "engagements") {
                $(".engagement_form small").text("");
                var form_id = ".engagement_form";
                var data_serialize = $(form_id).serialize();
                var modal_id = "#add_engagement";
                var button_id = "#add_engagement_btn";
                var button_text = "Add Engagement";
            } else if (type == "contacts") {
                if ($('.contact_form_update #ID').val() != "") {
                    $(".contact_form_update small").text("");
                    var form_id = ".contact_form_update";
                    var data_serialize = $(form_id).serialize();
                    var button_id = "#btn_update_contact";
                    var button_text = "Update";
                } else {
                    $(".contact_form small").text("");
                    var form_id = ".contact_form";
                    var data_serialize = $(form_id).serialize();
                    var modal_id = "#add_contact";
                    var button_id = "#add_contact_btn";
                    var button_text = "Add Contact";
                }
            } else if (type == "issues") {
                $(".issue_form small").text("");
                var form_id = ".issue_form";
                var data_serialize = $(form_id).serialize();
                var modal_id = "#add_issue";
                var button_id = "#add_issue_btn";
                var button_text = "Add Issue";
            } else if (type == "issue_history") {
                var id = $("#hidden_program_id").val();
                var issue_id = $("#issue_id").val();
                $(".add_history_form small").text("");
                var form_id = ".add_history_form";
                var data_serialize = $(form_id).serialize();
                var modal_id = "#add_issue";
                var button_id = "#save_history";
                var button_text = "Save History";
            }
            
            $.ajax({
                url: "/add-coop-value",
                method: "POST",
                data: data_serialize,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp) {
                    if (!resp.error) {
                        if ($('.contact_form_update #ID').val() == "") {
                            $(modal_id).modal("hide");
                        }
                        $(form_id)[0].reset();
                        $(button_id).removeAttr("disabled");
                        $(button_id).text(button_text);

                        if ($(button_id).attr("data-type") == "issue_history") {
                            $("#btn_cancel_add_issues").trigger("click");
                            $("#table_history_child_" + issue_id).DataTable().ajax.reload();
                            $("#table_issues_child_" + table_id).DataTable().ajax.reload();
                        } else if ($('.contact_form_update #ID').val() != "") {
                            $(".table_contact_child").DataTable().ajax.reload();
                            $(".cancel_update").trigger("click");
                        }

                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )
                        $(button_id).removeAttr("disabled");
                        $(button_id).text(button_text);
                    } else {
                        if (typeof resp.message === 'object' && resp.message !== null) {
                            $.each(resp.message, function(index, data) {
                                $(form_id + " ." + index + "-error").text(data);
                            });
                        } else {
                            Swal.fire(
                                'Error',
                                resp.message,
                                'error'
                            )
                        }
                        $(button_id).removeAttr("disabled");
                        $(button_id).text(button_text);
                    }
                },
                error: function (resp) {
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )
                    $(button_id).removeAttr("disabled");
                    $(button_id).text(button_text);
                }
            });
        });

        $(document).on("click", ".edit_contact", function(e){
            e.preventDefault();

            var id = $(this).attr("data-id");
            var action = $(this).attr("data-action");

            $.ajax({
                url: "/edit-contact/"+id+"/"+action,
                method: "GET",
                success: function (resp) {
                    if (!resp.error) {
                        var value = JSON.parse(resp.message.value);
                        
                        $('.contact_form_update #coop').val(resp.message.coop).trigger('change');
                        $('.contact_form_update #contact_type').val(value.contact_type).trigger('change');

                        $('.contact_form_update #ID').val(resp.message.ID);
                        $('.contact_form_update #contact_number').val(value.contact_number);
                        $('.contact_form_update #email').val(value.email);
                        $('.contact_form_update #firstname').val(value.firstname);
                        $('.contact_form_update #lastname').val(value.lastname);
                        $('.contact_form_update #action').val("contacts");

                        $(".contact_div_edit").removeClass("d-none");
                        $(".table_contact_parent").addClass("d-none");
                    } else {
                        Swal.fire(
                            'Error',
                            resp.error,
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

        $(document).on("click", ".cancel_update", function (e) {
            e.preventDefault();

            $(".contact_div_edit").addClass("d-none");
            $(".table_contact_parent").removeClass("d-none");
        })

        $(document).on("click", ".modal_close", function (e) {
            e.preventDefault();

            $("#coop_details").modal("hide");
            $("#btn_cancel_add_issues").trigger("click");
            $("#btn_back_to_issues").trigger("click");
            $("a[href='#tab-coop-details']").trigger("click");
        });

        $(document).on("click", ".modal_close", function (e) {
            
        });

        $(document).on("click", ".edit_details_btn", function (e) {
            e.preventDefault();

            var Endorsement_tagging = $("#Endorsement_tagging").val();
            var Prioritization_tagging = $("#Prioritization_tagging").val();

            $("#Endorsement_tagging").removeAttr("readonly");
            $("#Prioritization_tagging").removeAttr("readonly");

            $(".div_update_area_btn").removeClass("d-none");
            $(".edit_details_btn").addClass("d-none");
        });

        $(document).on("click", ".cancel_details_btn", function (e) {
            e.preventDefault();

            $("#Endorsement_tagging").attr("readonly", "readonly");
            $("#Prioritization_tagging").attr("readonly", "readonly");

            $(".div_update_area_btn").addClass("d-none");
            $(".edit_details_btn").removeClass("d-none");
        });

        $(document).on("click", ".update_details_btn", function (e) {
            e.preventDefault();

            var id = $("#Id").val();
            var Endorsement_tagging = $("#Endorsement_tagging").val();
            var Prioritization_tagging = $("#Prioritization_tagging").val();
            var Coop_name = $("#Coop_name").val();

            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            $.ajax({
                url: "/update-coop-details",
                method: "POST",
                data: {
                    endorsement_tagging : Endorsement_tagging,
                    prioritization_tagging : Prioritization_tagging,
                    id : id,
                    coop_name : Coop_name,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp) {
                    if (!resp.error) {

                        $(".cancel_details_btn").trigger("click");

                        $(".update_details_btn").removeAttr("disabled");
                        $(".update_details_btn").text("Update");
                        
                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )
                    } else {

                        $(".update_details_btn").removeAttr("disabled");
                        $(".update_details_btn").text("Update");

                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }
                },
                error: function (resp) {

                    $(".update_details_btn").removeAttr("disabled");
                    $(".update_details_btn").text("Update");

                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )
                }
            });
        });


        $("#coop_approval_table").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/localcoop-details-approval",
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            createdRow: function (row, data) {
                $(row).attr('data-endorsement_tagging', JSON.parse(JSON.stringify(data)).endorsement_tagging);
                $(row).attr('data-prioritization_tagging', JSON.parse(JSON.stringify(data)).prioritization_tagging);
                $(row).attr('data-status', JSON.parse(JSON.stringify(data)).status);
                $(row).attr('data-id', data.ID);
            },
            columns: [
                { data: "coop" },
                { data: "prioritization_tagging" },
                { data: "endorsement_tagging" },
                { data: "status" },
                { data: "action" },
            ],
        });


        $(document).on("click", ".approve_disapprove_coop_detail", function (e) {
            e.preventDefault();

            $(".details_approval_area").removeClass("d-none");
            $(".coop_approval_table_area").addClass("d-none");

            var coop = $(this).attr("data-coop");
            var endorsement_tagging = $(this).attr("data-endorsement_tagging");
            var prioritization_tagging = $(this).attr("data-prioritization_tagging");

            $(".approve_reject_details").attr("data-id", $(this).attr("data-id"));
            $(".approve_reject_details").attr("data-status", $(this).attr("data-action"));

            if ($(this).attr("data-action") == "approved") {
                $("p.message_details").text("Are you sure you want to approve this details?");
                $(".approve_reject_details").text("Approve");
            } else {
                $("p.message_details").text("Are you sure you want to reject this details?");
                $(".approve_reject_details").text("Reject");
            }

            $("span.coop").text(coop);
            $("span.endorsement_tagging").text(endorsement_tagging);
            $("span.prioritization_tagging").text(prioritization_tagging);
        });

        $(document).on("click", ".approve_reject_details", function (e) {
            e.preventDefault();

            var id = $(this).attr("data-id");
            var status = $(this).attr("data-status");

            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            $.ajax({
                url: "/approve-change-details/" + id + "/" + status,
                method: "GET",
                success: function (resp) {
                    if (!resp.error) {

                        $("#coop_approval_table").DataTable().ajax.reload(function (){

                            $(".approve_reject_details").removeAttr("disabled");
                            $(".approve_reject_details").text("Approve");
                
                            Swal.fire(
                                'Success',
                                resp.message,
                                'success'
                            )
    
                            $(".cancel_details").trigger("click");
                        });

                    } else {
                        $(".approve_reject_details").removeAttr("disabled");
                        $(".approve_reject_details").text("Approve");

                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }
                },
                error: function (resp) {
                    $(".approve_reject_details").removeAttr("disabled");
                    $(".approve_reject_details").text("Approve");
        
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )
                }
            });
        });

        $(document).on("click", ".cancel_details", function (e) {
            e.preventDefault();

            $(".details_approval_area").addClass("d-none");
            $(".coop_approval_table_area").removeClass("d-none");
        });

});
