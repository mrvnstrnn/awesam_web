$(document).ready(() => {
    $('#for-verification-table').DataTable({
        processing: true,
        serverSide: true,
        // pageLength: 3,
        ajax: {
            url: $("#for-verification-table").attr('data-href'),
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        },
        dataSrc: function(json){
            return json.data;
        },
        'createdRow': function(row, data) {

            var suffix = data.suffix == null ? "" : data.suffix;
            $(row).attr('data-user_id', data.user_id);
            $(row).attr('data-profile_id', data.designation);
            $(row).attr("data-info", JSON.stringify(data));
            $(row).attr('data-employeename', data.firstname + " " + data.lastname + " " + suffix);
            $(row).addClass('modalSetProfile');
        },
        columns: [
            { data: "user_id" },
            { data: "profile" },
            { data: "firstname" },
            { data: "lastname" },
            { data: "email" },
            // { data: "status" },
        ],
    });

    $('#pending-table').DataTable({
        processing: true,
        serverSide: true,
        // pageLength: 3,
        ajax: {
            url: $("#pending-table").attr('data-href'),
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        },
        dataSrc: function(json){
            return json.data;
        },
        // 'createdRow': function(row, data) {

        //     var suffix = data.suffix == null ? "" : data.suffix;
        //     $(row).attr('data-user_id', data.user_id);
        //     $(row).attr('data-profile_id', data.designation);
        //     $(row).attr("data-info", JSON.stringify(data));
        //     $(row).attr('data-employeename', data.firstname + " " + data.lastname + " " + suffix);
        //     $(row).addClass('modalSetProfile');
        // },
        columns: [
            // { data: "user_id" },
            // { data: "profile" },
            { data: "firstname" },
            { data: "lastname" },
            { data: "email" },
        ],
    });


    $('#employee-agents-table').DataTable({
        processing: true,
        serverSide: true,
        // pageLength: 3,
        ajax: {
            url: $('#employee-agents-table').attr('data-href'),
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        },
        dataSrc: function(json){
            return json.data;
        },
        'createdRow': function(row, data) {
            console.log("test");
            $(row).addClass('getListAgent');
            $(row).attr('data-id', data.user_id);
        },
        columns: [
            { data: "user_id" },
            { data: "profile" },
            { data: "firstname" },
            { data: "lastname" },
            { data: "email" },
            { data: "action", className: "text-right" },
            // { data: "number_agent" },
        ],
    });


    $('#for-verification-table tbody').on('click', 'tr td:not(first-child)', function () {
        $(".btn-assign-profile").attr('data-user_id', $( this ).parent().attr("data-user_id"));
        $(".btn-assign-profile").attr('data-profile_id', $( this ).parent().attr("data-profile_id"));

        if($( this ).attr("colspan") != 5){
            var data = JSON.parse($( this ).parent().attr("data-info"));

            $("#fullname").val(data.firstname+" "+data.lastname);
            $('#designation').val(data.designation).trigger('change');

            // if (data.designation == 3) {
            //     $('#mysupervisor').val("").trigger('change');
            //     $(".supervisor_area").addClass("d-none");
            // } else {
            //     $(".supervisor_area").removeClass("d-none");
            // }

            $('#employment_classification').val(data.employment_classification).trigger('change');
            $('#employment_status').val(data.employment_status).trigger('change');
            $('#hiring_date').val(data.hiring_date);
    
            $('#suffix').val(data.suffix);
            $('#nickname').val(data.nickname);
            $('#birthday').val(data.birthday);
            $('#gender').val(data.gender);
            $('#email').val(data.email);
            $('#contact_no').val(data.contact_no);
            $('#landline').val(data.landline);
    
            $("#modal-employee-verification").modal("show");
            $(".modal-footer .btn-assign-profile").removeClass("d-none");

            $(".supervisor_select select option").remove();
    
            if(data.designation != null){
                if($( this ).parent().attr("data-profile_id") == 2){
                    $(".supervisor_area").removeClass('d-none');
                    // $(".agent_area").removeClass('d-none');
    
                    $('.supervisor-data select option').remove();
                    $.ajax({
                        url: '/get-supervisor',
                        method: "GET",
                        success: function (resp) {
                            if(!resp.error){
                                $('.supervisor-data').removeClass("d-none");
                                $('.supervisor_select select').append("<option value=''>Select supervisor</option>");
                                resp.message.forEach(element => {
                                    $('.supervisor_select select').append("<option value="+element.id+">"+element.name+"</option>");
                                });
                            } else {
                                toastr.error(resp.message, "Error");
                            }
                        },
                        error: function (resp) {
                            toastr.error(resp.message, "Error");
                        }
                    });
                } else {
                    $(".supervisor_area").addClass('d-none');
                    // $(".agent_area").addClass('d-none');
                }
            } else {
                $(".modal-footer.button-assign").addClass("d-none");
            }
        }
        
        // window.location.href = "/chapters/"+data;
    } );

    $("#designation").on("change", function () {
        if ($(this).val() == 3) {
            $('#mysupervisor').val("").trigger('change');
            $(".supervisor_area").addClass("d-none");
        } else {
            $(".supervisor_area").removeClass("d-none");
        }
    });

    $(document).on( 'click', '.btn-assign-profile', function (e) {
         e.preventDefault();

        var user_id = $(this).attr('data-user_id');
        // var profile_id = $(this).attr('data-profile_id');
        var profile_id = $("#designation").val();

        var mysupervisor = $("#mysupervisor").val();
        
        var inputElements = document.getElementsByName('vendor_program_id');

        $(this).attr('disabled', 'disabled');
        $(this).text('Processing...');

        checkbox_id = [];
        for(var i=0; inputElements[i]; ++i){
            if(inputElements[i].checked){
                checkbox_id.push(inputElements[i].value);
            }
        }

        $.ajax({
            url: '/assign-profile',
            method: "POST",
            data: {
                user_id : user_id,
                profile_id : profile_id,
                checkbox_id : checkbox_id,
                mysupervisor : mysupervisor,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp) {
                if(!resp.error){
                    $('#for-verification-table').DataTable().ajax.reload(function(){
                        toastr.success(resp.message, "Success");
                        $("#modal-employee-verification").modal("hide");

                        $(".btn-assign-profile").removeAttr('disabled');
                        $(".btn-assign-profile").text('Approve Employee');
                    });
                } else {
                    toastr.error(resp.message, "Error");
                    $(".btn-assign-profile").removeAttr('disabled');
                    $(".btn-assign-profile").text('Approve Employee');
                }
            },
            error: function (resp) {
                toastr.error(resp.message, "Error");
                $(".btn-assign-profile").removeAttr('disabled');
                $(".btn-assign-profile").text('Approve Employee');
            }
        });
    });

    // $('#employee-agents-table tbody').on('click', 'tr', function () {
    //     $("#modal-employee-verification").modal("show");

    //     $(".content-data ul").remove();

    //     var data_id = $(this).attr("data-id");

    //     // $(".modal-footer.assign-profile-footer").addClass("d-none");
    //     $.ajax({
    //         url: "/get-agent-of-supervisor/"+data_id,
    //         method: "GET",
    //         success: function(resp) {
    //             if(!resp.error) {
    //                 $(".content-data").append(
    //                     '<ul class="list-group"></ul>'
    //                 );
    //                 resp.message.forEach(element => {
    //                     $(".content-data ul").append(
    //                         '<li class="list-group-item"><i class="fa-2x pe-7s-user icon-gradient bg-malibu-beach"></i> '+element.firstname+ " "+element.lastname+ ' | '+element.region+' '+element.province+' '+element.lgu+'</span></li>'
    //                     );
    //                 });
    //             } else {
    //                 toastr.error(resp.message, "Error");
    //             }
    //         },
    //         error: function(resp) {
    //             toastr.error(resp.message, "Error");
    //         }
    //     });
    // });

    $(document).on("click", ".update-data", function () {
        var user_id = $(this).attr("data-value");
        var vendor_id = $(this).attr("data-vendor_id");
        var is_id = $(this).attr("data-is_id");

        $(".change-data").attr("data-user_id", user_id);
        
        $("#modal-info #supervisor option").remove();
        $("#modal-info .vendor_program_div div").remove();

        $.ajax({
            url: "/get-user-data/" + user_id + "/" + vendor_id + "/" + is_id,
            method: "GET",
            success: function (resp) {
                if (!resp.error) {
                    $("#modal-info").modal("show");
;
                    resp.supervisor.forEach(element => {
                        $("#modal-info #supervisor").append(
                            '<option value="'+element.id+'">'+element.name+'</option>'
                        );
                    });
                    
                    resp.vendor_program.forEach(element => {
                        $(".vendor_program_div").append(
                            '<div class="col-4">' +
                            '<input class="form-check-input" type="checkbox" value="'+element.program_id+'" name="program[]" id="checkbox'+element.program_id+'">' +
                            '<label class="form-check-label" for="checkbox'+element.program_id+'">' +
                                element.program +
                            '</label>' +
                            '</div>'
                        );
                    });

                    
                    $('#supervisor').val(is_id).trigger('change');

                    resp.user_data.forEach(element => {
                        $("input[type=checkbox][value='" + element.program_id + "']").prop('checked', true);
                    });
                    
                } else {
                    toastr.error(resp.message, "Error");
                }
            },
            error: function (resp) {
                toastr.error(resp, "Error");
            }
        });
    });

    $(document).on("click", ".change-data", function(){
        var user_id = $(this).attr('data-user_id');
        var is_id = $("#supervisor").val();

        var program = [];
        $.each($("input[type='checkbox']:checked"), function(){
            program.push($(this).val());
        });

        $.ajax({
            url: "/update-user-data",
            method: "POST",
            data: {
                user_id : user_id,
                is_id : is_id,
                program : program,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp) {
                if (!resp.error) {
                    $("#employee-agents-table").DataTable().ajax.reload(function () {
                        $("#modal-info").modal("hide");
                        toastr.success(resp.message, "Success");
                    });
                } else {
                    toastr.error(resp.message, "Error");
                }
            },
            error: function (resp) {
                toastr.error(resp, "Error");
            }
        });
    });

    
    $(document).on("click", ".disable_btn", function (){
        $("b.user_name_disable").text($(this).attr("data-name"));
        $("#disable_employee_modal").modal("show");
    });

    $(document).on("click", ".offboard_btn", function (){
        $("b.user_name_offboard").text($(this).attr("data-name"));
        $("#offboard_employee_modal").modal("show");
    });

});