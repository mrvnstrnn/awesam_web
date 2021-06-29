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
        <div class="file_viewer"></div>
        <div class="table-responsive table_uploaded_parent"></div>
    </div>

    {{-- DOC MAKER --}}
    <div id="action_doc_maker" class='d-none'>
        <textarea id="summernote" name="editordata" style="height:300px;"></textarea>
        <button class="btn btn-shadow float-right btn-success btn-sm mt-3">Print to PDF</button> 
    </div>     

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

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

        $('.table_uploaded').on( 'click', 'tr td', function (e) {
            var extensions = ["pdf", "jpg", "png"];

            var values = $(this).parent().attr('data-value');

            console.log(values.split('.').pop());

            if( extensions.includes(values.split('.').pop()) == true) {     
                htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 400px; height: 100%" src="/ViewerJS/#../files/' + values + '" allowfullscreen></iframe>';
            } else {
                htmltoload = '<div class="text-center my-5"><a href="/files/' + values + '"><i class="fa fa-fw display-1" aria-hidden="true" title="Copy to use file-excel-o"></i><H5>Download Document</H5></a><small>No viewer available; download the file to check.</small></div>';
            }
                    
            $('.file_viewer').html('');
            $('.file_viewer').html(htmltoload);

            $('.file_viewer').removeClass("d-none");
        });


        $(".table_uploaded_parent").html(
            '<div class="table-responsive table_uploaded_parent">' +
                '<table class="table_uploaded align-middle mb-0 table table-borderless table-striped table-hover w-100">' +
                    '<thead>' +
                        '<tr>' +
                            '<th style="width: 5%">#</th>' +
                            '<th>Filename</th>' +
                            '<th style="width: 35%">Status</th>' +
                            '<th>Date Uploaded</th>' +
                        '</tr>' +
                    '</thead>' +
                '</table>' +
            '</div>'
        );

        $(".table_uploaded").attr("id", "table_uploaded_files_"+"{{ $sub_activity_id }}");

                
        if (! $.fn.DataTable.isDataTable('#table_uploaded_files_'+"{{ $sub_activity_id }}") ){   
            $('#table_uploaded_files_'+"{{ $sub_activity_id }}").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/get-my-uploaded-file-data/"+"{{ $sub_activity_id }}"+"/"+$(".ajax_content_box").attr("data-sam_id"),
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
                    $(row).attr('style', 'cursor: pointer');
                },
                columns: [
                    { data: "id" },
                    { data: "value" },
                    { data: "status" },
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
                maxFiles: 1,
                // maxFilesize: 1,
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
                        $("#action_doc_upload").addClass("d-none");
                        this.removeFile(file);
                        var sam_id = "{{ $sam_id }}";
                        var sub_activity_id = "{{ $sub_activity_id }}";
                        var sub_activity_name = "{{ $sub_activity }}";
                        var file_name = resp.file;

                        // var sub_activity_name = $(this).attr("data-sub_activity_name");

                        $.ajax({
                            url: "/upload-my-file",
                            method: "POST",
                            data: {
                                sam_id : sam_id,
                                sub_activity_id : sub_activity_id,
                                file_name : file_name,
                                sub_activity_name : sub_activity_name
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
                                        $(".btn_switch_back_to_actions").trigger("click");
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



    </script>    