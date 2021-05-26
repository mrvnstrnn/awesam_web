$(document).ready(() => {

    var vendor_table = [
        'vendor-list',
        'vendor-list-ongoing',
        'vendor-list-complete'
    ];

    for (let i = 0; i < vendor_table.length; i++) {
        $('#'+vendor_table[i]+'-table').DataTable({
            processing: true,
            serverSide: true,
            // pageLength: 3,
            ajax: {
                url: $('#'+vendor_table[i]+'-table').attr('data-href'),
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            dataSrc: function(json){
                return json.data;
            },
            columns: [
                // { data: "vendor_status" },
                { data: "vendor_sec_reg_name" },
                { data: "vendor_acronym" },
                { data: "vendor_name" },
                { data: "vendor_admin_email" },
                { data: "vendor_office_address" },
                { data: "action" },
            ],
        });
        
    }

    $('#vendor-sites-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: $("#vendor-sites-table").attr('data-href'),
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        },
        dataSrc: function(json){
            return json.data;
        },
        columns: [
            { data: "checkbox" },
            { data: "sam_id" },
            { data: "site_name" },
            { data: "site_address" },
            { data: "action" },
        ],
    }); 

    $(document).on("click", ".transferModal", function(){
        $(".transfer_button").attr('data-id', $(this).attr('data-id'));
        $("select#vendor option").remove();
        $.ajax({
            url: '/get-vendor',
            method: "GET",
            success: function(resp){
                if(!resp.error){
                    resp.message.forEach(element => {
                        $("select#vendor").append(
                            '<option value="'+element.id+'">'+element.email+'</option>'
                        );
                    });
                    $("#transferModal").modal("show");
                }else {
                    toastr.error(resp.message, "Error");
                }
            },
            error: function(resp){
                toastr.error(resp.message, "Error");
            }
        });
    });

    $(".transfer_button").on("click", function(){
        var vendor_id = $("select#vendor").val();
        var sam_id = $(".transfer_button").attr("data-id");
        $.ajax({
            url: $(this).attr('data-href'),
            method: "POST",
            data: {
                vendor_id : vendor_id,
                sam_id : sam_id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp){
                if(!resp.error){
                    $('#vendor-sites-table').DataTable().ajax.reload(function(){
                        toastr.success(resp.message, "Success");
                        $("#transferModal").modal("hide");
                    });
                }else {
                    toastr.error(resp.message, "Error");
                }
            },
            error: function(resp){
                toastr.error(resp.message, "Error");
            }
        });
    });

    $('.add_vendor').on('click', function(){
        var route = $(this).attr('data-href');

        $(this).text("Adding vendor...");

        $('.add_vendor').attr("disabled", "disabled");

        $("small").text("");

        $.ajax({
            url: route,
            method: 'POST',
            data: $("#addVendorForm").serialize(),
            success: function(resp) {
                if(!resp.error){
                    $("#addVendorForm")[0].reset();
                    toastr.success(resp.message, 'Success');
                    $(".add_vendor").text("Add vendor");
                    $(".add_vendor").removeAttr("disabled");
                } else {
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $("#" + index + "-error").text(data);
                        });
                    } else {
                        toastr.error(resp.message, 'Error');
                    }
                    $(".add_vendor").text("Add vendor");
                    $(".add_vendor").removeAttr("disabled");
                }
            },
            error: function(resp) {
                toastr.error(resp.message, 'Error');
                $(".add_vendor").removeAttr("disabled");
                $(".add_vendor").text("Add vendor");
            }
        });
    });

    $(".list_vendors").on('click', function(){
        $.ajax({
            url: $("#route_hidden").val(),
            method: 'GET',
            success: function (resp) {
                if(!resp.error){
                    $("table tbody tr").remove();

                    var color = '';
                    var text = '';
                    var html = '';
                    resp.message.forEach(element => {
                        color = element.vendor_saq_status == 1 ? 'success' : 'warning';
                        text = element.vendor_saq_status == 1 ? 'Active' : 'Ongoing accreditation';
                        
                        html = '<span class="badge badge-'+color+'">' +text+ '</span>';
                        $("table tbody").append('<tr><td><a href="javascript:void(0)" class="get_data_vendor" data-vendor="'+ element.vendor_id  +'">'+ element.vendor_sec_reg_name +'</a></td><td>'+ element.vendor_fullname +'</td><td>'+ element.vendor_admin_email +'</td><td>'+ element.vendor_program +'</td><td>'+ element.vendor_office_address +'</td><td>'+ html +'</td></tr>');
                    });

                    
                    $('#list_vendor_modal').modal('show');
                } else {
                    toastr.error(resp.message, 'Error');
                }
            },
            error: function (resp) {
                toastr.error(resp.message, 'Error');
            }
        });
    });

    $(document).on('click', ".get_data_vendor", function(){
        var id = $(this).attr('data-vendor');
        
        $.ajax({
            url: '/vendor-data/'+id,
            method: 'GET',
            success: function (resp) {
                if(!resp.error){
                    $('#list_vendor_modal').modal('hide');
                    $("#vendor_admin_email").val(resp.message.vendor_admin_email);
                    $("#vendor_fullname").val(resp.message.vendor_fullname);
                    $("#vendor_office_address").val(resp.message.vendor_office_address);
                    // $("#vendor_program").val(resp.message.vendor_program);
                    $("#vendor_sec_reg_name").val(resp.message.vendor_sec_reg_name);
                    $("#vendor_acronym").val(resp.message.vendor_acronym);
                    $("select #vendor_saq_status").val(resp.vendor_saq_status);
 
                    $("#vendor_id").val(resp.message.vendor_id);

                    $('input:radio[name=vendor_program_id]').filter('[value='+resp.message.vendor_program_id+']').prop('checked', true);

                    $("#vendor_saq_status option[value='"+resp.message.vendor_saq_status+"']").attr("selected", "selected");

                    $(".add_vendor").text('Update vendor');

                } else {
                    toastr.error(resp.message, 'Error');
                }
            },
            error: function (resp) {
                toastr.error(resp.message, 'Error');
            }
        });
    });

    $(".resetForm").on('click', function(){
        $("#addVendorForm")[0].reset();
        $(".add_vendor").text('Add vendor');
    });

    $(document).on('click', '.modalTerminate', function(){
        var id = $(this).attr('data-id');
        var data_statusb = $(this).attr('data-statusb');
        var vendor_sec_reg_name = $(this).attr('data-vendor_sec_reg_name');

        $(".vendor_sec_reg_name").text(vendor_sec_reg_name);

        $("#terminationModal").modal("show");

        $(".terminate_button").attr('data-id', id);
        $(".terminate_button").attr('data-statusb', data_statusb);
    });

    $(document).on("click", ".infoVendorModal", function(){
        $("#viewInfoForm")[0].reset();
        $(".vendor_profile b").remove();
        $(".vendor_profile li").remove();
        $.ajax({
            url: $(this).attr("data-href"),
            method: "GET",
            success: function(resp){
                if(!resp.error){
                    $("#vendor_sec_reg_name").val(resp.message.vendor_sec_reg_name);
                    $("#vendor_acronym").val(resp.message.vendor_acronym);
                    $("#vendor_office_address").val(resp.message.vendor_office_address);
                    $("#vendor_admin_name").val(resp.message.vendor_firstname + " " + resp.message.vendor_lastname);
                    $("#vendor_admin_email").val(resp.message.vendor_admin_email);
                    // toastr.success(resp.message, 'Success');

                    $(".vendor_profile").append('<b>Vendor Profile</b>');
                    resp.vendor_profiles.forEach(element => {
                        $(".vendor_profile").append(
                            '<li>'+element.profile_type+'</li>'
                        );
                    });
                } else {
                    toastr.error(resp.message, 'Error');
                }
            },
            error: function(resp){
                toastr.error(resp.message, 'Error');
            }
        });
        $("#viewInfoModal").modal("show");
    });

    $(document).on('click', '.terminate_button', function(){
        var id = $(this).attr('data-id');
        var data_statusb = $(this).attr('data-statusb');
        
        var var_id = '';

        if(data_statusb == 'listVendor'){
            var_id = '#vendor-list-table';
        } else if (data_statusb == 'OngoingOff'){
            var_id = '#vendor-list-ongoing-table';
        } else if (data_statusb == 'Complete'){
            var_id = '#vendor-list-complete-table';
        }

        var textWhile = "";
        var textAfter = "";

        if(data_statusb == 'listVendor'){
            textWhile = "Terminating...";
            textAfter = "Terminate";
        } else {
            textWhile = "Completing...";
            textAfter = "Complete";
        }
        $(".terminate_button").text(textWhile);

        $('.terminate_button').attr("disabled", "disabled");

        $.ajax({
            url: $(this).attr('data-href'),
            method: 'POST',
            data: {
                id : id,
                data_statusb : data_statusb
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp){
                if (!resp.error) {
                    // $(var_id).DataTable().ajax.reload(function(){
                    //     $("#terminationModal").modal("hide");
                    //     toastr.success(resp.message, 'Success');
                    // });

                    if(data_statusb == 'listVendor'){
                        $(var_id).DataTable().ajax.reload(function(){
                            $("#terminationModal").modal("hide");
                            toastr.success(resp.message, 'Success');
                            
                            $(".terminate_button").text(textAfter);
                            $(".terminate_button").removeAttr("disabled");
                        });
                    } else {
                        $("#vendor-list-ongoing-table").DataTable().ajax.reload(function(){
                            $("#terminationModal").modal("hide");
                            toastr.success(resp.message, 'Success');
                            
                            $(".terminate_button").text(textAfter);
                            $(".terminate_button").removeAttr("disabled");
                        });

                        $("#vendor-list-complete-table").DataTable().ajax.reload();
                    }
                } else {
                    toastr.error(resp.message, 'Error');
                            
                    $(".terminate_button").text(textAfter);
                    $(".terminate_button").removeAttr("disabled");
                }
            },
            error: function(resp){
                toastr.error(resp.message, 'Error');
                            
                $(".terminate_button").text(textAfter);
                $(".terminate_button").removeAttr("disabled");
            }
        });
    });


    // $('#agent-table').DataTable({
    //     processing: true,
    //     serverSide: true,
    //     ajax: {
    //         url: $("#agent-table").attr('data-href'),
    //         type: 'GET',
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //     },
    //     dataSrc: function(json){
    //         return json.data;
    //     },
    //     columns: [
    //         { data: "firstname" },
    //         { data: "lastname" },
    //         { data: "email" },
    //     ],
    // }); 

});