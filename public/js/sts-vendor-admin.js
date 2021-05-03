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
                    $(this).text("Add vendor");
                } else {
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $("#" + index + "-error").text(data);
                        });
                        $(this).text("Add vendor");
                    } else {
                        toastr.error(resp.message, 'Error');
                        $(this).text("Add vendor");
                    }
                }
            },
            error: function(resp) {
                toast.error(resp.message, 'Error');
                $(this).text("Add vendor");
            }
        });
    });
});