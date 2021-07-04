<div class="row file_preview d-none">
    <div class="col-12 mb-3">
        <button id="btn_back_to_file_list_2" class="mt-0 btn btn-secondary" type="button">Back to files</button>
    </div>
    <div class="col-12 file_viewer">
    </div>
    <div class="col-12 file_viewer_list pt-3">
    </div>
</div>
<div class="row file_lists">
    @php
        $datas = \DB::connection('mysql2')->select('call `files_dropzone`("' .  $sam_id . '")');
    @endphp

    @forelse ($datas as $data)
        @if (is_null($data->files))
            <div class="col-md-4 col-sm-4 col-12 mb-2 dropzone_div_{{ $data->sub_activity_id }}" style='min-height: 100px;'>
                <div class="dropzone dropzone_files" data-sam_id="{{ $sam_id }}" data-sub_activity_id="{{ $data->sub_activity_id }}" data-sub_activity_name="{{ $data->sub_activity_name }}">
                    <div class="dz-message">
                        <i class="fa fa-plus fa-3x"></i>
                        <p><small class="sub_activity_name{{ $data->sub_activity_id }}">{{ $data->sub_activity_name }}</small></p>
                    </div>
                </div>
            </div>
        @else
            @php
                $uploaded_files = json_decode($data->files);

                if (pathinfo($uploaded_files[0]->value, PATHINFO_EXTENSION) == "pdf") {
                    $extension = "fa-file-pdf";
                } else if (pathinfo($uploaded_files[0]->value, PATHINFO_EXTENSION) == "png" || pathinfo($uploaded_files[0]->value, PATHINFO_EXTENSION) == "jpeg" || pathinfo($uploaded_files[0]->value, PATHINFO_EXTENSION) == "jpg") {
                    $extension = "fa-file-image";
                } else {
                    $extension = "fa-file";
                }

                $icon_color = "";
                foreach($uploaded_files as $approved){
                    if($approved->status == "approved"){
                        $icon_color = "success";
                    } else {
                        $icon_color = "secondary";
                    }
                }

            @endphp
            <div class="col-md-4 col-sm-4 view_file col-12 mb-2 dropzone_div_{{ $data->sub_activity_id }}" style="cursor: pointer;" data-sub_activity_id="{{ $data->sub_activity_id }}" data-value="{{ json_encode($uploaded_files) }}">
                <div class="child_div_{{ $data->sub_activity_id }}">
                    <div class="dz-message text-center align-center border" style='padding: 25px 0px 15px 0px;'>
                        <div>
                        <i class="fa {{ $extension }} fa-3x text-dark"></i><br>
                        <p><small>{{ $data->sub_activity_name }}</small></p>
                        </div>
                    </div>
                     @if($icon_color == "success")   
                    <i class="fa fa-check-circle fa-lg text-{{ $icon_color }}" style="position: absolute; top:10px; right: 20px"></i><br>
                    @endif
                </div>
            </div>
        @endif
    @empty
        <div class="col-12 text-center">
            <h3>No files here.</h3>
        </div>
    @endforelse

    <input type="hidden" name="hidden_sam_id" value="{{ $sam_id }}">
</div>
<script src="/js/dropzone/dropzone.js"></script>

<script>  
    if ("{{ \Auth::user()->profile_id }}" == 2) {
        Dropzone.autoDiscover = false;
        $(".dropzone_files").dropzone({
            addRemoveLinks: true,
            maxFiles: 1,
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
                    var sam_id = this.element.attributes[1].value;
                    var sub_activity_id = this.element.attributes[2].value;
                    var sub_activity_name = this.element.attributes[3].value;
                    var file_name = resp.file;

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

                                var ext = file_name.split('.').pop();

                                var class_name = "";

                                if (ext == "pdf") {
                                    class_name = "fa-file-pdf";
                                } else if (ext == "png" || ext == "jpeg" || ext == "jpg") {
                                    class_name = "fa-file-image";
                                } else {
                                    class_name = "fa-file";
                                }

                                $(".dropzone_div_"+sub_activity_id+ " .dropzone_files").remove();

                                $(".dropzone_div_"+sub_activity_id).append(
                                    '<div class="child_div_'+sub_activity_id+'">' +
                                        '<div class="dz-message text-center align-center border" style="padding: 25px 0px 15px 0px;"">' +
                                            '<div>' +
                                                '<i class="fa '+class_name+' fa-2x text-primary"></i><br>' +
                                                '<p><small>'+sub_activity_name+'</small></p>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>'
                                );
                                
                                toastr.success(resp.message, "Success");
                            } else {
                                toastr.error(resp.message, "Error");
                            }
                        },
                        error: function (file, response) {
                            toastr.error(resp.message, "Error");
                        }
                    });
                } else {
                    toastr.error(resp.message, "Error");
                }
            },
            error: function (file, resp) {
                toastr.error(resp.message, "Error");
            }
        });
    }
    
    $(".view_file").on("click", function (){

        var extensions = ["pdf", "jpg", "png"];

        var values = JSON.parse($(this).attr('data-value'));

        if( extensions.includes(values[0].value.split('.').pop()) == true) {     
            htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 400px; height: 100%" src="/ViewerJS/#../files/' + values[0].value + '" allowfullscreen></iframe>';
        } else {
          htmltoload = '<div class="text-center my-5"><a href="/files/' + values[0].value + '"><i class="fa fa-fw display-1" aria-hidden="true" title="Copy to use file-excel-o"></i><H5>Download Document</H5></a><small>No viewer available; download the file to check.</small></div>';
        }
                
        $('.file_viewer').html('');
        $('.file_viewer').html(htmltoload);

        $('.file_viewer_list').html('');

        var sub_activity_id = $(this).attr("data-sub_activity_id");

        htmllist = '<div class="table-responsive table_uploaded_parent">' +
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
            '</div>';

        $('.file_viewer_list').html(htmllist);
        $(".table_uploaded").attr("id", "table_uploaded_files_"+sub_activity_id);

        if (! $.fn.DataTable.isDataTable("#table_uploaded_files_"+sub_activity_id) ){
            $("#table_uploaded_files_"+sub_activity_id).DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/get-my-sub_act_value/"+sub_activity_id,
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
                    $(row).attr('data-status', data.status);
                    $(row).attr('data-id', data.id);
                    $(row).attr('data-sub_activity_id', data.sub_activity_id);
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
            $("#table_uploaded_files_"+sub_activity_id).DataTable().ajax.reload();
        }

        $('.file_lists').addClass('d-none');
        $('.file_preview').removeClass('d-none');

    });

    $("#btn_back_to_file_list_2").on("click", function (){
        $('.file_lists').removeClass('d-none');
        $('.file_preview').addClass('d-none');
    });


    $(".dropzone_files").on("click", function (){
        $("input[name=hidden_sub_activity_name]").val($(this).attr("data-sub_activity_name"));
    });

    $(document).on("click", ".table_uploaded tr", function (e) {
        var extensions = ["pdf", "jpg", "png"];

        var value = $(this).attr("data-value");

        if( extensions.includes(value.split('.').pop()) == true) {     
            htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 400px; height: 100%" src="/ViewerJS/#../files/' + value + '" allowfullscreen></iframe>';
        } else {
          htmltoload = '<div class="text-center my-5"><a href="/files/' + value + '"><i class="fa fa-fw display-1" aria-hidden="true" title="Copy to use file-excel-o"></i><H5>Download Document</H5></a><small>No viewer available; download the file to check.</small></div>';
        }

        $("#hidden_filename").val(value);
                
        $('.file_viewer').html('');
        $('.file_viewer').html(htmltoload);
    });

</script>

