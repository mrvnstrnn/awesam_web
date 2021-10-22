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


                        <div class="modal-body">
                            <div class="row p-0">
                                <div class="col-12">
                                    <form class="elas_form">
                                        <div class="form-group">
                                            <label for="elas_reference"></label>
                                            <input type="text" name="elas_reference" id="elas_reference" class="form-control" placeholder="eLas References">
                                            <small class="elas_reference-errors text-danger"></small>
                                        </div>
                                        <div class="form-group">
                                            <label for="elas_filing_date"></label>
                                            <input type="date" name="elas_filing_date" id="elas_filing_date" class="form-control" placeholder="eLas Filing Date">
                                            <small class="elas_filing_date-errors text-danger"></small>
                                        </div>
                                        <div class="form-group">
                                            <label for="elas_approval_date"></label>
                                            <input type="date" name="elas_approval_date" id="elas_approval_date" class="form-control" placeholder="eLas Approval Date">
                                            <small class="elas_approval_date-errors text-danger"></small>
                                        </div>
                                        
                                        <div class="form-group">
                                            <button class="btn btn-sm btn-shadow btn-primary" type="button">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="row pt-3">
                                <div class="col-12 text-right">
                                    <button class="btn btn-sm btn-shadow btn-primary mark_as_complete" type="button">Mark as Complete</button>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@php

    $NP = \DB::table('site')
        ->where('sam_id', $sam_id)
        ->select('NP_latitude', 'NP_longitude', 'NP_radius')
        ->get();
    
@endphp

{{-- <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css"> --}}
<style>
    .kbw-signature { width: 100%; height: 150px; border: 1px solid black;}
    .sigbox canvas{ width: 100% !important; height: auto;}

</style>  


<style type="text/css">

    .modal-dialog{
        -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -o-box-shadow: 0 5px 15px rgba(0,0,0,0);
        box-shadow: 0 5px 15px rgba(0,0,0,0);
    } 
</style>

<script>


    $(document).ready(function() {

        $(".mark_as_complete").on("click", function() {
            $(".mark_as_complete").attr("disabled", "disabled");
            $(".mark_as_complete").text("Processing...");

            var sam_id = ["{{ $sam_id }}"];
            var activity_name = "mark_as_complete";
            var site_category = ["{{ $site_category }}"];
            var activity_id = ["{{ $activity_id }}"];
            var program_id = "{{ $program_id }}";

            $.ajax({
                url: "/accept-reject-endorsement",
                method: "POST",
                data: {
                    sam_id : sam_id,
                    activity_name : activity_name,
                    site_category : site_category,
                    activity_id : activity_id,
                    program_id : program_id,
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

                        $(".mark_as_complete").removeAttr("disabled");
                        $(".mark_as_complete").text("Mark as Complete");

                        $("#viewInfoModal").modal("hide");
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )

                        $(".mark_as_complete").removeAttr("disabled");
                        $(".mark_as_complete").text("Mark as Complete");
                    }
                },
                error: function (resp) {
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )

                    $(".mark_as_complete").removeAttr("disabled");
                    $(".mark_as_complete").text("Mark as Complete");
                }
            });

        });
        
    });
</script>
