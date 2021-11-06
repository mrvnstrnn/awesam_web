<div class="row border-bottom">
    <div class="col-6">
        <button class="btn_switch_back_to_actions btn btn-shadow btn-secondary btn-sm mb-3">Back to Actions</button>                                            
    </div>
    <div class="col-6 align-right  text-right">
        <button class="doc_maker_button btn btn-outline btn-outline-primary btn-sm mb-3">Document Maker</button>     

        <button class="doc_upload_button btn btn-outline btn-outline-primary btn-sm mb-3 d-none">Upload Document</button>                                            
    </div>
</div>

<div class="row pt-4">
    <div class="col-md-12">
        <H5 id="active_action">{{ $sub_activity }}</H5>
    </div>
</div>

<div class="action_box_content">

    {{-- DOC UPLOAD --}}
    <div id="action_doc_upload">
        <div class="dropzone dropzone_files_activities mt-0 mb-5">
            <div class="dz-message">
                <i class="fa fa-plus fa-3x"></i>
                <p><small class="sub_activity_name">Drag and Drop files here</small></p>
            </div>
        </div>                                            
        <div class="file_viewer pb-3 d-none">
            <div class="file"></div>
            <div class="reason_rejected"></div>
            <div class="button">
                <button class="my-3 btn btn-secondary btn-shadow btn-sm back_to_upload">Back to upload</button> <button class="my-3 btn btn-primary btn-shadow btn-sm add_remarks">Add remarks</button> 
            </div>
        </div>
        <div class="table-responsive table_uploaded_parent"></div>
    </div>

    {{-- DOC MAKER --}}
    <div id="action_doc_maker" class='d-none'>
        <textarea id="summernote" name="editordata" style="height:300px;"></textarea>
        <button class="btn btn-shadow float-right btn-success btn-sm mt-3">Print to PDF</button> 
    </div>

    <div class="remarks_div d-none">
        <form class="remarks_form">
            <div class="form-group">
                <input type="hidden" name="sam_id" id="sam_id">
                <input type="hidden" name="id" id="id">
                <label for="remarks">Remarks for <b></b></label>
                <textarea name="remarks" id="remarks" class="form-control w-100" rows="5"></textarea>
                <small class="remarks-errors text-danger"></small>
            </div>

            <button type="button" class="btn btn-primary btn-sm btn-shadow add_remarks_button">Add remarks</button> <button type="button" class="btn btn-secondary btn-sm btn-shadow cancel_remarks_button">Cancel</button>
        </form>
    </div>

    <script src="/js/dropzone/dropzone.js"></script>

    <script>
    
        $(".btn_switch_back_to_actions").on("click", function(){
            $("#actions_box").addClass('d-none');
            $("#actions_list").removeClass('d-none');
        });
    
        $('#active_action').text($(this).attr('data-sub_activity'));

        $('#summernote').summernote({
            height: 300,
            focus: true
        });

        $(".doc_maker_button").on("click", function(){
            $('#action_doc_upload').addClass('d-none');
            $('#action_doc_maker').removeClass('d-none');
            $(this).addClass('d-none');
            $('.doc_upload_button').removeClass('d-none')
        });

        $(".doc_upload_button").on("click", function(){
            $('#action_doc_upload').removeClass('d-none');
            $('#action_doc_maker').addClass('d-none');
            $(this).addClass('d-none');
            $('.doc_maker_button').removeClass('d-none');
        });


        $(".table_uploaded_parent").html(
            '<div class="table-responsive table_uploaded_parent">' +
                '<table class="table_uploaded align-middle mb-0 table table-borderless table-striped table-hover w-100">' +
                    '<thead>' +
                        '<tr>' +
                            '<th style="width: 5%">#</th>' +
                            '<th>Filename</th>' +
                            '<th style="width: 35%">Status</th>' +
                            '<th style="width: 35%">Reason</th>' +
                            '<th>Date Uploaded</th>' +
                        '</tr>' +
                    '</thead>' +
                '</table>' +
            '</div>'
        );

        $(".table_uploaded").attr("id", "table_uploaded_files_"+"{{ $sub_activity_id }}");


        $('.table_uploaded').on( 'click', 'tr td', function (e) {
            var extensions = ["pdf", "jpg", "png"];

            var values = $(this).parent().attr('data-value');

            $(".remarks_form b").text(values);

            if( extensions.includes(values.split('.').pop()) == true) {     
                htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 400px; height: 100%" src="/ViewerJS/#../files/' + values + '" allowfullscreen></iframe>';
            } else {
                htmltoload = '<div class="text-center my-5"><a href="/files/' + values + '"><i class="fa fa-fw display-1" aria-hidden="true" title="Copy to use file-excel-o"></i><H5>Download Document</H5></a><small>No viewer available; download the file to check.</small></div>';
            }

            $(".button .add_remarks").attr("data-id", $(this).parent().attr('data-id'));
            $(".button .add_remarks").attr("data-sam_id", $(this).parent().attr('data-sam_id'));
                    
            $('.file_viewer .file').html('');
            $('.file_viewer .file').html(htmltoload);

            
            $(".reason_rejected b").remove();
            $(".reason_rejected h3").remove();
            $(".reason_rejected span").remove();

            if ( $(this).parent().attr("data-status") == "denied"){
                $(".reason_rejected .rejected_p").text( $(this).attr("data-reason") );
                $(".reason_rejected").append(
                    '<h3><b>Rejected Reason: </b> <span>' + $(this).parent().attr("data-reason") + "</span></h"
                );

            } else {
                $(".reason_rejected b").remove();
                $(".reason_rejected h3").remove();
                $(".reason_rejected span").remove();
            }

            $('.file_viewer').removeClass("d-none");
            $('.dropzone').addClass("d-none");
        });

        $(document).on( 'click', '.back_to_upload', function (e) {
            e.preventDefault();
            
            $('.file_viewer').addClass("d-none");
            $('.dropzone').removeClass("d-none");
        });

        $(document).on( 'click', '.add_remarks', function (e) {

            e.preventDefault();

            $('.remarks_div').removeClass('d-none');
            $('#action_doc_upload').addClass('d-none');
            $('.file_viewer').addClass("d-none");
            $('.dropzone').addClass("d-none");

            $("#id").val($(this).attr('data-id'));
            $("#sam_id").val($(this).attr('data-sam_id'));

        });

        $(document).on( 'click', '.cancel_remarks_button', function (e) {

            e.preventDefault();

            $('.remarks_div').addClass('d-none');
            $('.file_viewer').removeClass("d-none");
            $('.dropzone').addClass("d-none");
            $('#action_doc_upload').removeClass("d-none");

        });

                
        if (! $.fn.DataTable.isDataTable('#table_uploaded_files_'+"{{ $sub_activity_id }}") ){   
            $('#table_uploaded_files_'+"{{ $sub_activity_id }}").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/get-uploaded-files/"+"{{ $sub_activity_id }}"+"/"+$(".ajax_content_box").attr("data-sam_id"),
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                dataSrc: function(json){
                    return json.data;
                },
                'createdRow': function( row, data, dataIndex ) {
                    $(row).attr('data-value', data.value);
                    $(row).attr('data-sam_id', data.sam_id);
                    $(row).attr('data-status', data.status);
                    $(row).attr('data-reason', data.reason);
                    $(row).attr('data-id', data.id);
                    $(row).attr('style', 'cursor: pointer');
                },
                columns: [
                    { data: "id" },
                    { data: "value" },
                    { data: "status" },
                    { data: "reason" },
                    { data: "date_created" },
                ],
            });
        } else {
            $('#table_uploaded_files_'+"{{ $sub_activity_id }}").DataTable().ajax.reload();
        }

        if ("{{ \Auth::user()->getUserProfile()->mode }}" == "vendor") {
            Dropzone.autoDiscover = false;
            $(".dropzone_files_activities").dropzone({
                addRemoveLinks: true,
                // maxFiles: 1,
                paramName: "file",
                url: "/upload-file",
                init: function() {
                    this.on("maxfilesexceeded", function(file){
                        this.removeFile(file);
                    });
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (file, resp) {
                    if (!resp.error){
                        var _this = this;
                        var file = file;
                        var sam_id = "{{ $sam_id }}";
                        var sub_activity_id = "{{ $sub_activity_id }}";
                        var sub_activity_name = "{{ $sub_activity }}";
                        var file_name = resp.file;
                        var site_category = "{{ $site_category }}";
                        var activity_id = "{{ $activity_id }}";
                        var program_id = "{{ $program_id }}";

                        $.ajax({
                            url: "/upload-my-file",
                            method: "POST",
                            data: {
                                sam_id : sam_id,
                                sub_activity_id : sub_activity_id,
                                file_name : file_name,
                                sub_activity_name : sub_activity_name,
                                site_category : site_category,
                                activity_id : activity_id,
                                program_id : program_id,
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (resp) {
                                if (!resp.error){

                                    $('#table_uploaded_files_'+"{{ $sub_activity_id }}").DataTable().ajax.reload(function(){
                                        $(".action_doc_upload").remove();
                                        Swal.fire(
                                            'Success',
                                            resp.message,
                                            'success'
                                        )
                                        
                                        _this.removeFile(file);

                                        $(".mark_complete_area").removeClass("d-none");

                                        $(".action_to_complete_parent .action_to_complete_child"+sub_activity_id).append(
                                            '<i class="fa fa-check-circle fa-lg text-success" style="position: absolute; top:10px; right: 20px"></i>'
                                        );

                                    });
                                    
                                } else {
                                    Swal.fire(
                                        'Error',
                                        resp.message,
                                        'error'
                                    )
                                }
                            },
                            error: function (file, response) {
                                Swal.fire(
                                    'Error',
                                    resp,
                                    'error'
                                )
                            }
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }
                },
                error: function (file, resp) {
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )
                }
            });
        }


        $(".add_remarks_button").on("click", function(e){
            
            e.preventDefault();

            $(this).attr('disabled', 'disabled');
            $(this).text('Processing...');

            $.ajax({
                url: "/add-remarks-file",
                method: "POST",
                data: $(".remarks_form").serialize(),
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

                        $(".remarks_form")[0].reset();

                        $(".cancel_remarks_button").trigger("click");

                        $(".add_remarks_button").removeAttr("disabled");
                        $(".add_remarks_button").text("Add remarks");

                    } else {

                        if (typeof resp.message === 'object' && resp.message !== null) {
                            $.each(resp.message, function(index, data) {
                                $("." + index + "-errors").text(data);
                            });
                        } else {
                            Swal.fire(
                                'Error',
                                resp.message,
                                'error'
                            )
                        }

                        $(".add_remarks_button").removeAttr("disabled");
                        $(".add_remarks_button").text("Add remarks");
                    }
                },
                error: function (resp) {
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )
                    $(".add_remarks_button").removeAttr("disabled");
                    $(".add_remarks_button").text("Add remarks");
                }
            })
        });



    </script>    