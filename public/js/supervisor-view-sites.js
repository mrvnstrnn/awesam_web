$(document).ready(function() {


    $(".subactivity_action_switch").on('click', function(e){
        e.preventDefault();

        var sam_id = $(this).attr('data-sam_id');
        var sub_activity_id = $(this).attr('data-sub_activity_id');


        if($(this).attr('data-action')=="doc maker"){

            $(".modal-title").text($(this).attr('data-sub_activity_name'));
            $('.modal-body').html("");

            $.ajax({
                url: "/loi-template",
                method: "GET",
                success: function(resp){
                    if(!resp.error){
                        $('.modal-body').html('<div id="summernote" name="editordata">' + resp.message + '</div>');

                        $("input[name=sam_id]").val(sam_id);
                        $("input[name=sub_activity_id]").val(sub_activity_id);

                        $("textarea").text(resp.message);
                        $('#summernote').summernote({
                            height: 300,
                            minHeight: null,
                            maxHeight: null,
                            focus: true, 
                        });
                        $("#modal-sub_activity").modal("show");
                    } else {
                        toastr.error(resp.message, "Error");
                    }
                },
                error: function(resp){
                    toastr.error(resp.message, "Error");
                },
            });
            // var content = "Sample";
        }

        else if($(this).attr('data-action')=="doc upload"){

            // var where = '#subactivity_' + $(this).attr('data-sam_id') + "_" + $(this).attr('data-activity_id') + "_" + $(this).attr('data-mode');
            var where = '#subactivity_' + $(this).attr('data-activity_id');

            $('.subactivity_action_list').removeClass("d-none");
            $('.subactivity_action').addClass("d-none");

            console.log(where);
            
            $(where + " .subactivity_action_list").toggleClass("d-none");
            $(where + " .subactivity_action").toggleClass("d-none");

            $("#form-upload #sam_id").val($(this).attr('data-sam_id'));
            $("#form-upload #sub_activity_id").val($(this).attr('data-sub_activity_id'));

            $(where).find(".doc_upload_label").html($(this).attr('data-sub_activity_name'));

            $(".row.subactivity_action .list-uploaded ul").remove();
            $.ajax({
                url: "/get-my-uploaded-file",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    sam_id : sam_id,
                    sub_activity_id : sub_activity_id,
                },
                success: function(resp){

                    if(!resp.error){
                        console.log(resp.message);
                        if(resp.message.length < 1) {
                            $(".dropzone").removeClass("d-none");
                            $(".upload_file").removeClass("d-none");
                            $(".hr-border").addClass("d-none");
                        } else {
                            var ext = "";
                            var status = "";
                            console.log(resp.message[0].status);

                            $(".row.subactivity_action .list-uploaded").append(
                                '<ul></ul>'
                            );
                            resp.message.forEach(element => {

                                if(element.status == 'approved'){
                                    $(".dropzone").addClass("d-none");
                                    $(".upload_file").addClass("d-none");
                                    $(".hr-border").removeClass("d-none");
                                }

                                if(element.value.split('.').pop() == 'pdf'){
                                    ext = "fa-file-pdf";
                                } else {
                                    ext = "fa-file";
                                }

                                if(element.status == "pending") {
                                    status = "fa-spinner text-warning";
                                } else if (element.status == "approved") {
                                    status = "fa-check text-success";
                                } else if (element.status == "denied"){
                                    status = "fa-times text-danger";
                                }

                                $(".row.subactivity_action .list-uploaded ul").append(
                                    '<li><i class="fa '+ext+'"></i> '+element.value+'<i class="ml-4 fa '+status+'"></i></li>'
                                );
                            });
                        }
                    } else {
                        toastr.error(resp.message, "Error");
                    }
                },
                error: function(resp){
                    toastr.error(resp.message, "Error");
                }
            });
        }
    });

    $(".cancel_uploader").on('click', function(e){
        $('.subactivity_action_list').removeClass("d-none");
        $('.subactivity_action').addClass("d-none");
        // $("a.dz-remove").trigger("click");
    });

    $(".upload_file").on("click", function (e){

        e.preventDefault();

        var sam_id = $("#form-upload #sam_id").val();
        var sub_activity_id = $("#form-upload #sub_activity_id").val();
        var file_name = $("#form-upload #file_name").val();

        $.ajax({
            url: "/upload-my-file",
            method: "POST", 
            data: {
                sam_id : sam_id,
                sub_activity_id : sub_activity_id,
                file_name : file_name,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp) {
                if(!resp.error){
                    sam_id = $("#form-upload #sam_id").val("");
                    sub_activity_id = $("#form-upload #sub_activity_id").val("");
                    file_name = $("#form-upload #file_name").val("");

                    $(".cancel_uploader").trigger("click");
                    toastr.success(resp.message, "Success");
                } else {
                    toastr.error(resp.message, "Error");
                }
            },
            error: function(resp) {
                toastr.error(resp.message, "Error");
            }
        });
    });


});