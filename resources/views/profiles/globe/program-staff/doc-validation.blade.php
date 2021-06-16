@extends('layouts.main')

@section('content')

    <x-milestone-datatable ajaxdatatablesource="site-doc-validation" tableheader="Document Validation" activitytype="doc validation"/>

@endsection


@section('modals')

    <style>

        .modal-dialog{
            overflow-y: initial !important
        }

        .modal-body{
            height: 80vh;
            overflow-y: auto;
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

                $('.modal-body .col_list .col_child_list i, .modal-body .col_list .col_child_list p').remove();

                var data_info = JSON.parse($(this).attr('data-info').replace(/&quot;/g,'"'));
                var sam_id = $(this).attr('data-sam_id');
                $('.modal-body').html('');

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
                        if(!resp.error){
                            var iframe =  '';

                            $('.modal-body').html(
                                '<div class="row"><div class="col-lg-7 col-md-7 col-12 col_iframe">' +
                                    '<button type="button" class="btn btn-danger btn_reject_approve" data-action="denied">Reject</button>' +
                                    ' <button type="button" class="btn btn-primary btn_reject_approve" data-action="approved">Approve</button></div><div class="col-lg-5 col-md-5 col-12 col_list"></div></div>'
                            );

                            iframe =  '<div class="embed-responsive mt-3" style="height: 460px;">' +
                                '<iframe class="embed-responsive-item" src="files/' + resp.message[0].value + '" allowfullscreen></iframe>' +
                            '</div>';

                            $('.modal-body .col_iframe').append(iframe);
                            
                            $(".btn_reject_approve").attr("data-id", resp.message[0].id);

                            // $('.modal-body .col_list').html(
                            //     '<div class="row"><div class="col-lg-4 col-md-4 col-12 col_child_list"></div></div>'
                            // );

                            var ext = "";
                            var done = "";
                            for (let i = 0; i < resp.message.length; i++) {
                                if(resp.message[i].value.split('.').pop() == "pdf") {
                                    ext = "fa fa-file-pdf fa-3x";
                                } else {
                                    ext = "fa fa-file fa-3x";
                                }

                                if(resp.message[i].status == "denied") {
                                    done = "pe-7s-close";
                                } else if (resp.message[i].status == "approved") {
                                    done = "fa fa-check";
                                } else {
                                    done = "";
                                }
                                
                                $('.modal-body .col_list').append(
                                    '<i class="'+ext+'"></i>' + "<p class='d-flex mt-3 mb-0'><i class='"+done+"'></i>" + resp.message[i].value + "</p> <p class='mt-0'><b>Agent:</b> "+resp.message[i].firstname + " " +resp.message[i].lastname +"</p><br>"
                                );
                            }

                            $('#viewInfoModal').modal('show');

                        } else {
                            toastr.error(resp.message, "Error");
                        }
                    },
                    error: function (resp){
                        toastr.error(resp.message, "Error");
                    }
                });
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

    });    
</script>

@endsection