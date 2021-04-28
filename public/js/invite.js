$(document).ready(() => {
    $("#invite_btn").on('click', function(){
        $(this).text('Sending...');
        $.ajax({
            url: $(this).attr('data-href'),
            method: 'POST',
            data: $("#invitation_form").serialize(),
            success: function (resp) {
                if(!resp.error) {
                    toastr.success(resp.message, 'Success');
                    $("#invite_btn").text('Invite');
                } else {
                    
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $("#" + index + "-error").text(data);
                        });
                    } else {
                        toastr.error(resp.message, 'Error');
                    }
                    $("#invite_btn").text('Invite');
                }
            },

            error: function (resp) {
                toastr.error(resp.message, 'Error');
            }
        });
    });
});