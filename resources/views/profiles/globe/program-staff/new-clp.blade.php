@extends('layouts.main')

@section('content')
<style>
    .modal-dialog{
        -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -o-box-shadow: 0 5px 15px rgba(0,0,0,0);
        box-shadow: 0 5px 15px rgba(0,0,0,0);
    }

    .select2-container .select2-selection--multiple .select2-selection__rendered {
        white-space: unset !important;
    }
</style>    

    <x-milestone-datatable ajaxdatatablesource="site-milestones" tableheader="New CLP" activitytype="new clp"/>

@endsection


@section('modals')

<div class="ajax_content_box"></div>

@endsection

@section('js_script')



<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    //////////////////////////////////////
    var profile_id = 8;
    var table_to_load = 'new_clp';
    // var main_activity = 'New Endorsements Globe';

    //////////////////////////////////////
</script>

<script type="text/javascript" src="/js/getCols.js"></script>  
<script type="text/javascript" src="/js/DTmaker.js"></script>  
<script type="text/javascript" src="/js/modal-loader.js"></script>  

<!-- PR PO Counter -->
{{-- <script type="text/javascript" src="/js/newsites_ajax_counter.js"></script>   --}}
<script type="text/javascript" src="{{ asset('/js/view_site_memo.js') }}"></script>

<script>

    // $(document).ready(function() {
    //     $(".table_financial_analysis table").DataTable().ajax.reload();
    // });

        $(".btn_create_pr").on("click", function(e){
            e.preventDefault();

            var program_id = $(this).attr('data-program');
            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            // loader = '<div class="p-2">Loading...</div>';
            // $.blockUI({ message: loader });

            $.ajax({
                url: "/get-create-pr-memo/" + program_id,
                method: "GET",
                // data: $(".pr_po_form").serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp){
                    // if (!resp.error) {
                        // $.unblockUI();

                        $(".btn_create_pr").removeAttr("disabled");
                        $(".btn_create_pr").text("Create PR Memo");

                        $(".ajax_content_box").html(resp);
                        // refresh_counters();

                        $("#craetePrPoModal").modal("show");
                    // } else {
                    //     Swal.fire(
                    //         'Error',
                    //         resp.message,
                    //         'error'
                    //     )
                    // }
                },
                error: function (resp){
                    // $.unblockUI();

                    $(".btn_create_pr").removeAttr("disabled");
                    $(".btn_create_pr").text("Create PR Memo");

                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )
                }
            });
        });
    // });
    

</script>




@endsection