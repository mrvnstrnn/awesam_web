<div class="form_html"></div>


<script>
    $(document).ready(function(){
        $.ajax({
            url: "/get-form/" + "{{ $site[0]->activity_id }}" + "/" + "Vendor Awarding",
            method: "GET"
            success: function (resp) {
                if (!resp.error) {
                    $(".form_html").html(resp.message);
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
</script>