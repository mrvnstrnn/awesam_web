<style>
    .modal-dialog{
        -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -o-box-shadow: 0 5px 15px rgba(0,0,0,0);
        box-shadow: 0 5px 15px rgba(0,0,0,0);
    }   
</style>
<div class="row pb-3 border-top pt-3">
    <div class="col-12">
        <img src="{{ asset('images/construction.gif') }}" class="text-center">
        <button class="btn btn-sm btn-shadow btn-primary confirm_schedule pull-right ">Approve Lease Packge</button>
    </div>
</div>


<script>
    $(document).ready(function() {


        $(".confirm_schedule").on("click", function(e) {
            e.preventDefault();
            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            var sam_id = ["{{ $site[0]->sam_id }}"];
            var activity_name = "mark_as_complete";
            var site_category = ["{{ $site[0]->site_category }}"];
            var activity_id = ["{{ $site[0]->activity_id }}"];
            var program_id = "{{ $site[0]->program_id }}";
            var data_complete = "true";

            $.ajax({
                url: "/accept-reject-endorsement",
                method: "POST",
                data: {
                    sam_id : sam_id,
                    activity_name : activity_name,
                    site_category : site_category,
                    activity_id : activity_id,
                    program_id : program_id,
                    data_complete : data_complete,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp) {
                    if (!resp.error){
                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )
                        $(".confirm_schedule").removeAttr("disabled");
                        $(".confirm_schedule").text("JTSS Sched Confirmed");

                        $("#viewInfoModal").modal("hide");
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                        $(".confirm_schedule").removeAttr("disabled");
                        $(".confirm_schedule").text("JTSS Sched Confirmed");
                    }
                },
                error: function (resp) {
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )
                    $(".confirm_schedule").removeAttr("disabled");
                    $(".confirm_schedule").text("JTSS Sched Confirmed");
                }
            });

        });
    });
</script>