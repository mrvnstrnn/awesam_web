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

            var where = '#sub_activity_' + $(this).attr('data-sam_id') + "_" + $(this).attr('data-activity_id') + "_" + $(this).attr('data-mode') ;

            $('.lister').removeClass("d-none");
            $('.action_box').addClass("d-none");

            $(where + " .lister").toggleClass("d-none");
            $(where + " .action_box").toggleClass("d-none");

            $(where).find(".doc_upload_label").html($(this).attr('data-sub_activity_name'));


            console.log(where);
            console.log($(where).find(".doc_upload_label").html());
        }
    });

    $(".cancel_uploader").on('click', function(e){
        $('.lister').removeClass("d-none");
        $('.action_box').addClass("d-none");
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
        var file = new FormData(document.getElementById("form-upload"));

        var asd = document.getElementById("doc_upload").files;
        console.log(asd);
        $.ajax({
            url: "/upload-file",
            method: "POST", 
            data: {
                file : file
            },
            contentType: false,
            processData: false,
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


});        