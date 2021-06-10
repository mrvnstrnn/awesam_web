$(document).ready(function() {

    $('#tab-content-today').addClass('show');
    $('#tab-content-today').addClass('active');
    
    $(".show_subs_btn").on('click', function(e){
        e.preventDefault();
        
        // RESET
        $(".sub_activity_li").addClass('d-none');
        $('.show_subs_btn').html('<i class="float-right lnr-chevron-down-circle"></i>');


        $("#" + $(this).attr("data-show_li")).toggleClass('d-none');

        // alert($(this).attr("data-chevron"));

        if($(this).attr("data-chevron") === "down"){
            var chevronUp = '<i class="lnr-chevron-up-circle" data-toggle="tooltip" data-placement="left" title="" data-original-title="Show Sub Activities"></i>';
            $(this).attr('data-chevron','up');
            console.log('down to up');
        } else {
            var chevronUp = '<i class="lnr-chevron-down-circle" data-toggle="tooltip" data-placement="left" title="" data-original-title="Show Sub Activities"></i>';
            $(this).attr('data-chevron','down');
            console.log('up to down');
            $(".sub_activity_li").addClass('d-none');
            
        }

        $(this).html(chevronUp);
    });


    $(".activity_agent_filter").on('click', function(e){
        e.preventDefault();

        who = $(this).attr('data-agent_id');

        $(".agent_card").addClass('d-none');
        $(".agent_card_" + who).removeClass('d-none');

        $('.show_who').text($(this).text())

    });

    $(".activity_agent_filter_remove").on('click', function(e){
        e.preventDefault();

        $(".agent_card").removeClass('d-none');
        $('.show_who').text("ALL")


    });


    $(".sub_activity").on('click', function(e){
        e.preventDefault();

        if($(this).attr('data-action')=="doc maker"){

            $(".modal-title").text($(this).attr('data-sub_activity_name'));
            $('.modal-body').html("");

            $.ajax({
                url: "/loi-template",
                method: "GET",
                success: function(resp){
                    if(!resp.error){
                        $('.modal-body').html('<div id="summernote" name="editordata">' + resp.message + '</div>');

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

            var where = '#sub_activity_' + $(this).attr('data-sam_id') + "_" + $(this).attr('data-activity_id') + "_" + $(this).attr('data-mode');
            var sam_id = $(this).attr('data-sam_id');
            var sub_activity_id = $(this).attr('data-sub_activity_id');

            $('.lister').removeClass("d-none");
            $('.action_box').addClass("d-none");
            
            $(where + " .lister").toggleClass("d-none");
            $(where + " .action_box").toggleClass("d-none");

            $("#form-upload #sam_id").val($(this).attr('data-sam_id'));
            $("#form-upload #sub_activity_id").val($(this).attr('data-sub_activity_id'));

            $(where).find(".doc_upload_label").html($(this).attr('data-sub_activity_name'));

            $(".row.action_box .list-uploaded ul").remove();
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
                            if(resp.message[0].status == 'approved'){
                                $(".dropzone").addClass("d-none");
                                $(".upload_file").addClass("d-none");
                                $(".hr-border").removeClass("d-none");
                            }
                            $(".row.action_box .list-uploaded").append(
                                '<ul></ul>'
                            );
                            resp.message.forEach(element => {
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

                                $(".row.action_box .list-uploaded ul").append(
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
        $('.lister').removeClass("d-none");
        $('.action_box').addClass("d-none");
        $("a.dz-remove").trigger("click");
    });


    $(".download_pdf").on("click", function(){
        // console.log($('#summernote').summernote('code'));

        var data_summernote = $('#summernote').summernote('code');

        $.ajax({
            url: "/download-pdf",
            data: { data_summernote : data_summernote },
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp) {
                if(!resp.error){
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