$(document).ready(() => {
    $("#invite_btn").on('click', function(){
        $(this).text('Sending...');
        $.ajax({
            url: $(this).attr('data-href'),
            method: 'POST',
            data: $("#invitation_form").serialize(),
            success: function (resp) {
                if(!resp.error) {
                    console.log(resp.message);
                    $("#invite_btn").text('Invite');
                } else {
                    console.log(resp.message);
                    $("#invite_btn").text('Invite');
                }
            },

            error: function (resp) {
                console.log(resp.message);
            }
        });
    });
});