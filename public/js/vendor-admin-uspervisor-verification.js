$(document).ready(() => {
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
            $(row).addClass('getListAgent');
            $(row).attr('data-id', data.user_id);
        },
        columns: [
            { data: "user_id" },
            { data: "profile" },
            { data: "firstname" },
            { data: "lastname" },
            { data: "email" },
            { data: "number_agent" },
            { data: "action", className: "text-right" },
        ],
    });

    $('#employee-agents-table tbody').on('click', 'tr td:not(:last-child)', function () {
        $("#modal-employee-verification").modal("show");

        $(".content-data table").remove();

        var data_id = $(this).parent().attr("data-id");

        $(".change_supervisor").attr("data-is_id", data_id);

        html = '<table class="align-middle mb-0 table table-borderless table-striped table-hover agents-table">' +
                    '<thead>' +
                        '<tr>' +
                            '<th>User ID</th>' +
                            '<th>Firstname</th>' +
                            '<th>Lastname</th>' +
                            '<th>Email</th>' +
                            '<th>Action</th>' +
                        '</tr>' +
                    '</thead>' +
                '</table>';

        $(".content-data").html(html);

        $(".content-data .agents-table").attr("id", "agents"+data_id+"table");

        if ( ! $.fn.DataTable.isDataTable("#agents"+data_id+"table") ) {
            $("#agents"+data_id+"table").DataTable({
                processing: true,
                serverSide: true,
                // pageLength: 3,
                ajax: {
                    // url: "/vendor-agents/"+data_id,
                    url: "/vendor-agents",
                    data : {
                        data_id : data_id
                    },
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                dataSrc: function(json){
                    return json.data;
                },
                columns: [
                    { data: "user_id" },
                    { data: "firstname" },
                    { data: "lastname" },
                    { data: "email" },
                    { data: "action" },
                ],
            });
        } else {
            $("#agents"+data_id+"table").DataTable().ajax.reload();
        }

        // $(".modal-footer.assign-profile-footer").addClass("d-none");
        // $.ajax({
        //     url: "/get-agent-of-supervisor/"+data_id,
        //     method: "GET",
        //     success: function(resp) {
        //         if(!resp.error) {
        //             $(".content-data").append(
        //                 '<ul class="list-group"></ul>'
        //             );
        //             resp.message.forEach(element => {
        //                 $(".content-data ul").append(
        //                     '<li class="list-group-item"><i class="fa-2x pe-7s-user icon-gradient bg-malibu-beach"></i> '+element.firstname+ " "+element.lastname+ ' | '+element.region+' '+element.province+' '+element.lgu+'</span></li>'
        //                 );
        //             });
        //         } else {
        //             toastr.error(resp.message, "Error");
        //         }
        //     },
        //     error: function(resp) {
        //         toastr.error(resp.message, "Error");
        //     }
        // });
    });

    $(document).on("click", ".get_supervisor", function () {
        var user_id = $(this).attr("data-user_id");
        var is_id = $(this).attr("data-is_id");
        var name = $(this).attr("data-name");

        $("#modal-employee-verification .modal-title").text(name);
        
        $(".supervisor-data select option").remove();
        $.ajax({
            url: "/get-supervisor",
            method: "GET",
            success: function(resp){
                if (!resp.error) {
                    resp.message.forEach(element => {
                        $(".supervisor-data select").append(
                            '<option value="'+element.user_id+'">'+element.name+'</option>'
                        );
                    });

                    $('.supervisor-data #supervisor').val(is_id).trigger('change');
                    
                    // $('.supervisor_info_form #firstname').val(resp.user_detail.firstname);
                    // $('.supervisor_info_form #lastname').val(resp.user_detail.lastname);

                    $(".change_supervisor").attr("data-user_id", user_id);

                    
                    $(".supervisor-data").removeClass("d-none");
                    $(".content-data").addClass("d-none");
                } else {
                    toastr.error(resp.error, "Error");
                }
            },
            error: function(resp){
                toastr.error(resp, "Error");
            }
        });
    });

    $(document).on("click", ".change_supervisor", function () {
        var user_id = $(this).attr("data-user_id");
        var table_id = $(this).attr("data-is_id");
        var is_id = $("#modal-employee-verification #supervisor").val();
        
        $(".supervisor-data select option").remove();
        $.ajax({
            url: "/change-supervisor/"+user_id+"/"+is_id,
            method: "GET",
            success: function(resp){
                if (!resp.error) {
                    $("#agents"+table_id+"table").DataTable().ajax.reload();
                    $("#employee-agents-table").DataTable().ajax.reload();
                    
                    Swal.fire(
                        'Success',
                        resp.message,
                        'success'
                    )

                    $(".supervisor-data").addClass("d-none");
                    $(".content-data").removeClass("d-none");
                } else {
                    
                    Swal.fire(
                        'Error',
                        resp.message,
                        'error'
                    )
                }
            },
            error: function(resp){
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )
            }
        });
    });

    $(document).on("click", ".cancel_change", function (){
        $(".supervisor-data").addClass("d-none");
        $(".content-data").removeClass("d-none");
        $("#modal-employee-verification .modal-title").text("Agent");
    });

    $(document).on("click", ".disable_btn", function (){
        $("b.user_name_disable").text($(this).attr("data-name"));
        $("#disable_employee_modal").modal("show");
    });

    $(document).on("click", ".offboard_btn", function (){
        $("b.user_name_offboard").text($(this).attr("data-name"));
        $("#offboard_employee_modal").modal("show");
    });

    $("button.change-data").on("click", function(){
    // $(document).on("click", ".change-data", function(){

        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        var user_id = $(this).attr('data-user_id');
        var is_id = $("#supervisor").val();
        var profile = $("#profile").val();

        var program = [];
        var region = [];
        $.each($("input[type='checkbox'][name='program[]']:checked"), function(){
            program.push($(this).val());
        });

        $.each($("input[type='checkbox'][name='region[]']:checked"), function(){
            region.push($(this).val());
        });

        $.ajax({
            url: "/update-user-data",
            method: "POST",
            data: {
                user_id : user_id,
                is_id : is_id,
                program : program,
                region : region,
                profile : profile,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp) {
                if (!resp.error) {
                    $("#employee-agents-table").DataTable().ajax.reload(function () {
                        $("#modal-info-supervisor").modal("hide");
                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )

                        $(".change-data").removeAttr("disabled");
                        $(".change-data").text("Update Data");
                    });
                } else {
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $(".supervisor_info_form ." + index + "-error").text(data);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }

                    $(".change-data").removeAttr("disabled");
                    $(".change-data").text("Update Data");
                }
            },
            error: function (resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )

                $(".change-data").removeAttr("disabled");
                $(".change-data").text("Update Data");
            }
        });
    });

});