<div class="row file_preview d-none">
    <div class="col-12">
        <button id="btn_back_to_file_list" class="mb-2 btn btn-danger float-right" type="button">Back to files</button>
    </div>
    <div class="col-12 file_viewer">
    </div>
</div>
<div class="row file_lists">
    @php
        $datas = \DB::connection('mysql2')->select('call `files_dropzone`("' .  $site[0]->sam_id . '", ' .  $site[0]->program_id . ', "")');
    @endphp

    @forelse ($datas as $data)
        @if (is_null($data->files))
            <div class="col-md-4 col-sm-4 col-12 mb-2 dropzone_div_{{ $data->sub_activity_id }}" style='min-height: 100px;'>
                <div class="dropzone dropzone_files" data-sub_activity_name="{{ $data->sub_activity_name }}" data-sam_id="{{ $site[0]->sam_id }}" data-sub_activity_id="{{ $data->sub_activity_id }}">
                    <div class="dz-message">
                        <i class="fa fa-plus fa-2x"></i>
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

            @endphp
            <div class="col-md-4 col-sm-4 view_file col-12 mb-2 dropzone_div_{{ $data->sub_activity_id }}" style="cursor: pointer;" data-value="{{ $uploaded_files[0]->value }}">
                <div class="child_div_{{ $data->sub_activity_id }}">
                    <div class="dz-message text-center align-center border" style='padding: 25px 0px 15px 0px;'>
                        <div>
                        <i class="fa {{ $extension }} fa-2x text-primary"></i><br>
                        {{-- <small>{{ $item->value }}</small> --}}
                        <p><small>{{ $data->sub_activity_name }}</small></p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @empty
        <div class="col-12 text-center">
            <h3>No files here.</h3>
        </div>
    @endforelse

    <input type="hidden" name="hidden_sam_id" value="{{ $site[0]->sam_id }}">
    <input type="hidden" name="hidden_sub_activity_name">
</div>
<script src="/js/dropzone/dropzone.js"></script>

<script>  
    Dropzone.autoDiscover = false;
    $(".dropzone_files").dropzone({
        addRemoveLinks: true,
        maxFiles: 1,
        maxFilesize: 1,
        paramName: "file",
        params: {
            // sam_id: this.element.attributes[2].value
            sam_id: $("input[name=hidden_sam_id]").val(),
            sub_activity_name: $("input[name=hidden_sub_activity_name]").val(),
        },
        url: "/upload-file",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (file, resp) {
            if (!resp.error){
                var sam_id = this.element.attributes[1].value;
                var sub_activity_id = this.element.attributes[2].value;
                var file_name = resp.file;

                var sub_activity_name = $("small.sub_activity_name"+sub_activity_id).text();

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
                            
                            // $(".child_div_"+sub_activity_id).load(document.location.href + " .child_div_"+sub_activity_id );
                            
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
    
    $(".view_file").on("click", function (){

        var extensions = ["pdf", "jpg", "png"];
        if( extensions.includes($(this).attr('data-value').split('.').pop()) == true) {     
          
            htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 420px; height: 100%" src="/ViewerJS/#../files/' + $(this).attr('data-value') + '" allowfullscreen></iframe>';

        } else {

          htmltoload = '<div class="text-center my-5"><a href="/files/' + $(this).attr('data-value') + '"><i class="fa fa-fw display-1" aria-hidden="true" title="Copy to use file-excel-o"></i><H5>Download Document</H5></a><small>No viewer available; download the file to check.</small></div>';
        }
                
        $('.file_viewer').html('');
        $('.file_viewer').html(htmltoload);

        $('.file_lists').addClass('d-none');
        $('.file_preview').removeClass('d-none');

    });

    $("#btn_back_to_file_list").on("click", function (){
        $('.file_lists').removeClass('d-none');
        $('.file_preview').addClass('d-none');
    });


    $(".dropzone_files").on("click", function (){
        $("input[name=hidden_sub_activity_name]").val($(this).attr("data-sub_activity_name"));
    });

</script>

