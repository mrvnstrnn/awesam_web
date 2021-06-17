@extends('layouts.main')

@section('content')

    <x-milestone-datatable ajaxdatatablesource="site-doc-validation" tableheader="Document Validation" activitytype="doc validation"/>

@endsection


@section('modals')

    <x-milestone-modal />

@endsection

@section('js_script')
<script>
    //////////////////////////////////////
    var profile_id = 8;
    var table_to_load = 'doc_validation';
    //////////////////////////////////////
</script>

<script type="text/javascript" src="/js/getCols.js"></script>  
<script type="text/javascript" src="/js/DTmaker.js"></script>  
<script type="text/javascript" src="/js/modal-doc-validation.js"></script>  

<script>
    $(document).ready(() => {

        $(document).on("click", ".btn_reject_approve", function (e){
            e.preventDefault();
            var data_id = $(this).attr("data-id");
            var data_action = $(this).attr("data-action");

            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            $.ajax({
                url: "/doc-validation-approve-reject/" + data_id + "/" + data_action,
                method: "GET",
                success: function (resp){
                    if (!resp.error){
                        toastr.success(resp.message, "Success");
                        $('#viewInfoModal').modal('hide');
                        $(this).removeAttr("disabled");
                        $(this).text("Test");
                    } else {
                        toastr.error(resp.message, "Error");
                        $(this).removeAttr("disabled");
                        $(this).text("Test");
                    }
                },
                error: function (resp){
                    toastr.error(resp.message, "Error");
                    $(this).removeAttr("disabled");
                    $(this).text("Test");
                }
            });
        });

        $(document).on("click", ".file_name", function(){
            console.log($(this).attr("data-id"));
            $("iframe").attr("src", "files/"+ $(this).text().replace(" ", ""));
            $(".btn_reject_approve").attr("data-id", $(this).attr("data-id"));
        })

    });    
</script>

@endsection