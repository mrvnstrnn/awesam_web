$(document).ready(() => {

    $('.add_vendor').on('click', function(){
        var route = $(this).attr('data-href');

        $(this).text("Adding vendor...");

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
                } else {
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $("#" + index + "-error").text(data);
                        });
                    } else {
                        toastr.error(resp.message, 'Error');
                    }
                    $(".add_vendor").text("Add vendor");
                }
            },
            error: function(resp) {
                toastr.error(resp.message, 'Error');
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

});