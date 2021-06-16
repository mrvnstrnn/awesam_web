@extends('layouts.main')

@section('content')

    <x-milestone-datatable ajaxdatatablesource="site-doc-validation" tableheader="Document Validation" activitytype="doc validation"/>

@endsection


@section('modals')

    <style>

        .modal-dialog{
            overflow-y: initial !important
        }

        .modal-body {
            max-height: calc(100vh - 210px);
            overflow-y: auto;
        }

        .details_file {
            display: none !important;
        }

        .col_child:hover .details_file {
            display: block !important;
        }

        .file_name {
            cursor: pointer;
        }
    </style>

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

<script>
    $(document).ready(() => {

        $('.assigned-sites-table').on( 'click', 'tbody tr', function (e) {
            e.preventDefault();
            if($(this).find("td").attr("colspan") != 4){

                $("#viewInfoModal .modal-title").text($(this).attr("data-site"));

                $('.modal-body .col_list .col_child_list i, .modal-body .col_list .col_child_list p').remove();

                var data_info = JSON.parse($(this).attr('data-info').replace(/&quot;/g,'"'));

                var sam_id = $(this).attr('data-sam_id');
                // $('.modal-body').html('');

                $.ajax({
                    url: "/get-all-docs",
                    method: "POST",
                    data: {
                        data_info : data_info,
                        sam_id : sam_id,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (resp){

                        $('.modal-content').html(resp);

                        

                    },
                    error: function (resp){
                        toastr.error(resp.message, "Error");
                    }
                })
                .done(function(){
                    $('#viewInfoModal').modal('show');
                    $('.file_list_item').first().click();
                });
            }
        });

        
        $(document).on("click", ".file_list_item", function (e){
            e.preventDefault();
            console.log(this);


            $(".file_list_item").removeClass('active');
            $(this).addClass('active');
            
            $('.modal_preview_marker').text($(this).attr('data-sub_activity_name') + " : " + $(this).attr('data-value'))

            var extensions = ["pdf", "jpg", "png"];

            if( extensions.includes($(this).attr('data-value').split('.').pop()) == true) {     

                htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 400px; height: 100%" src="/ViewerJS/#../files/' + $(this).attr('data-value') + '" allowfullscreen></iframe>';
                $('.modal_preview_content').html(htmltoload);

            } else {
                htmltoload = '<div class="text-center my-5"><a href="/files/' + $(this).attr('data-value') + '"><i class="fa fa-fw display-1" aria-hidden="true" title="Copy to use file-excel-o"></i><H5>Download Document</H5></a><small>No viewer available; download the file to check.</small></div>';
                $('.modal_preview_content').html(htmltoload);
            }



        });


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