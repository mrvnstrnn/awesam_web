$('.assigned-sites-table').on( 'click', 'tbody tr', function (e) {
    e.preventDefault();

    $.ajax({
        url: "/get-site-issue-details/" + $(this).attr("data-issue_id") + "/" + $(this).attr("data-what_table"),
        method: "GET",
        success: function (resp) {
            if (!resp.error) {
                $('.ajax_content_box').html("");   
                $('.ajax_content_box').html(resp);

                $.unblockUI();
                $('#viewInfoModal').modal('show');
            } else {
                toastr.error(resp, "Error");
            }
        },
        error: function (resp) {
            toastr.error(resp, "Error");
        }
    });

});

$(document).on( 'click', '.resolve_issue', function (e) {
    e.preventDefault();

    var table = $(this).attr("data-what_table");
    $.ajax({
        url: "/resolve-issue/" + $("#hidden_issue_id").val(),
        method: "GET",
        success: function (resp) {
            if (!resp.error) {
                $("#" + table ).DataTable().ajax.reload(function(){
                    Swal.fire(
                        'Success',
                        resp.message,
                        'success'
                    )
                    $('#viewInfoModal').modal('hide');
                });
            } else {
                Swal.fire(
                    'Error',
                    resp.message,
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