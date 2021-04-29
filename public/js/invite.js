$(document).ready(() => {
    if($("#firsttime_login").val() == 0){
        $("#firsttimeModal").modal({backdrop: 'static', keyboard: false});
    }

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

    $(".update_password").on('click', function(){
        $.ajax({
            url: $(this).attr('data-href'),
            method: 'POST',
            data: $("#passwordUpdateForm").serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp) {
                if (!resp.error) {
                    $("#passwordUpdateForm")[0].reset();
                    toastr.success(resp.message, 'Success');
                    $("#firsttimeModal").modal('hide');
                } else {
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $("#" + index + "-error").text(data);
                        });
                    } else {
                        toastr.error(resp.message, 'Error');
                    }
                }
            },
            error: function (resp) {
                toastr.error(resp.message, 'Error');
            }
        });
    });
});