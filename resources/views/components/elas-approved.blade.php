<div class="row p-0">
    <div class="col-12">
        <form class="elas_form row">
            <div class="form-group col">
                <label for="elas_reference">eLAS Reference ID</label>
                <input type="text" name="elas_reference" id="elas_reference" class="form-control" placeholder="eLas References">
                <small class="elas_reference-errors text-danger"></small>
            </div>
            <div class="form-group col">
                <label for="elas_filing_date">Filing Date</label>
                <input type="date" name="elas_filing_date" id="elas_filing_date" class="form-control" placeholder="eLas Filing Date">
                <small class="elas_filing_date-errors text-danger"></small>
            </div>
            <div class="form-group col">
                <label for="elas_approval_date">Approval Date</label>
                <input type="date" name="elas_approval_date" id="elas_approval_date" class="form-control" placeholder="eLas Approval Date">
                <small class="elas_approval_date-errors text-danger"></small>
            </div>
            
            <div class="form-group col-12">
                <button class="btn pt-4btn-lg btn-shadow btn-success" type="button">Update eLAS Details</button>
            </div>
        </form>
    </div>
</div>

<div class="row pt-3 pb-3 border-top">
    <div class="col-12 text-right">
        <button class="btn btn-lg btn-shadow btn-primary mark_as_complete" type="button">eLAS Complete</button>
    </div>
</div>

@php

    $NP = \DB::table('site')
        ->where('sam_id', $site[0]->sam_id)
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

            var sam_id = ["{{ $site[0]->sam_id }}"];
            var activity_name = "mark_as_complete";
            var site_category = ["{{ $site[0]->site_category }}"];
            var activity_id = ["{{ $site[0]->activity_id }}"];
            var program_id = "{{ $site[0]->program_id }}";

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
