$(document).ready(function (){
    $(".view_site_memo").on("click", function (){
        var value = $(this).attr("data-value");
        
        loader = '<div class="p-2">Loading...</div>';
        $.blockUI({ message: loader });

        $.ajax({
            url: "/get-site-memo/" + value,
            method: "GET",
            success: function (resp) {
                if (!resp.error) {
                    $('.ajax_content_box').html("");   
                    $('.ajax_content_box').html(resp);

                    $.unblockUI();

                    $("#view_pr_memo_site_modal").modal("show");
                } else {
                    $.unblockUI();
                    Swal.fire(
                        'Error',
                        resp.messag,
                        'error'
                    )
                }
            },
            error: function (resp) {
                $.unblockUI();
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )
            },
        });
    });
});