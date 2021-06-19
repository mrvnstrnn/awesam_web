<div class="row file_preview d-none">
    <div class="col-12">
        <button id="btn_back_to_file_list" class="mb-2 btn btn-danger float-right" type="button">Back to files</button>
    </div>
    <div class="col-12 file_viewer">
    </div>
</div>
<div class="row file_lists">
    @php
        // $datas = \App\Models\SubActivityValue::leftjoin("sub_activity", 'sub_activity.sub_activity_id', 'sub_activity_value.sub_activity_id')
        //                                             ->where('sub_activity_value.sam_id', $site[0]->sam_id)
        //                                             ->where('sub_activity_value.status', '!=', 'rejected')
        //                                             ->where('sub_activity.action', 'doc upload')
        //                                             ->get();
        
        $datas = \DB::connection('mysql2')->select('call `files_dropzone`("' .  $site[0]->sam_id . '", ' .  $site[0]->program_id . ', "")');
    // dd($datas);
    @endphp

    @forelse ($datas as $data)

    {{-- {{ dd($data) }} --}}
    @if (is_null($data->files))
        <div class="col-md-4 col-sm-4 col-12 mb-2 dropzone_div_{{ $data->sub_activity_id }}" style='min-height: 100px;'>
                <div class="dropzone dropzone_files" data-sam_id="{{ $site[0]->sam_id }}" data-sub_activity_id="{{ $data->sub_activity_id }}">
                    <div class="dz-message">
                        <i class="fa fa-plus fa-2x"></i>
                        <p><small>{{ $data->sub_activity_name }}</small></p>

                    </div>
                </div>
                {{-- <p>{{ $data->sub_activity_name }}</p> --}}
        </div>
    @else
        @foreach (json_decode($data->files) as $item)
            @php
                if (pathinfo($item->value, PATHINFO_EXTENSION) == "pdf") {
                    $extension = "fa-file-pdf";
                } else if (pathinfo($item->value, PATHINFO_EXTENSION) == "png" || pathinfo($item->value, PATHINFO_EXTENSION) == "jpeg" || pathinfo($item->value, PATHINFO_EXTENSION) == "jpg") {
                    $extension = "fa-file-image";
                } else {
                    $extension = "fa-file";
                }
            @endphp
            <div class="view_file col-md-4 col-sm-4 col-12 mb-2 dropzone_div_{{ $data->sub_activity_id }}" style="cursor: pointer;" data-value="{{ $item->value }}">
                {{-- <div class="child_div_{{ $data->sub_activity_id }}"> --}}
                    <div class="dz-message text-center align-center border" style='padding: 25px 0px 15px 0px;'>
                        <div>
                        <i class="fa {{ $extension }} fa-2x text-primary"></i><br>
                        {{-- <small>{{ $item->value }}</small> --}}
                        <p><small>{{ $data->sub_activity_name }}</small></p>
                        </div>
                    </div>
                {{-- </div> --}}
            </div>
        @endforeach
    @endif
    @empty
    <div class="col-12 text-center">
        <h3>No files here.</h3>
    </div>
    @endforelse
</div>
<script src="/js/dropzone/dropzone.js"></script>

<script>  
    Dropzone.autoDiscover = false;
    $(".dropzone_files").dropzone({
        addRemoveLinks: true,
        maxFiles: 1,
        maxFilesize: 1,
        paramName: "file",
        url: "/upload-file",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (file, resp) {
            var sam_id = this.element.attributes[1].value;
            var sub_activity_id = this.element.attributes[2].value;
            var file_name = resp.file;

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
                    $(".child_div_"+sub_activity_id).load(document.location.href + " .child_div_"+sub_activity_id );
                    console.log(resp.message);
                    toastr.success(resp.message, "Success");
                } else {
                    toastr.error(resp.message, "Error");
                }
            },
            error: function (file, response) {
                toastr.error(resp.message, "Error");
            }
            });
            
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

        htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 420px; height: 100%" src="/ViewerJS/#../files/' + $(this).attr('data-value') + '" allowfullscreen></iframe>';
                
        $('.file_viewer').html('');
        $('.file_viewer').html(htmltoload);

        $('.file_lists').addClass('d-none');
        $('.file_preview').removeClass('d-none');

    });

    $("#btn_back_to_file_list").on("click", function (){
        $('.file_lists').removeClass('d-none');
        $('.file_preview').addClass('d-none');
    });


</script>

