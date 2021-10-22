<style>
    .modal-dialog{
        -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -o-box-shadow: 0 5px 15px rgba(0,0,0,0);
        box-shadow: 0 5px 15px rgba(0,0,0,0);
    }   
</style>
<div class="modal fade" id="viewInfoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="background-color: transparent; border: 0">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="main-card mb-3 card">

                        <div class="dropdown-menu-header">
                            <div class="dropdown-menu-header-inner bg-dark">
                                <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                                <div class="menu-header-content btn-pane-right">
                                    <h5 class="menu-header-title">
                                        {{ $site_name }}
                                    </h5>
                                </div>
                            </div>
                        </div> 

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <H5 id="active_action">{{ $activity }}</H5>
                                </div>
                            </div>

                            <div class="row pb-3 border-top pt-3">
                                <div class="col-12">
                                    <button class="btn btn-sm btn-shadow btn-primary confirm_schedule pull-right ">Approve Lease Contract</button>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {


        $(".confirm_schedule").on("click", function(e) {
            e.preventDefault();
            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            var sam_id = ["{{ $sam_id }}"];
            var activity_name = "{{ $activity }}";
            var site_category = ["{{ $site_category }}"];
            var activity_id = ["{{ $activity_id }}"];
            var program_id = "{{ $program_id }}";
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