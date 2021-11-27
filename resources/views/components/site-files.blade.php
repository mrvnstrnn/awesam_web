<div class="card-body">
    <div class="row file_previews d-none">
        <div class="col-12 mb-3">
            <button id="btn_back_to_file_list_file_2" class="mt-0 btn btn-secondary" type="button">Back to files</button>
        </div>
        <div class="col-12 file_viewers">
        </div>
        <div class="col-12 file_viewer_lists pt-3">
        </div>
    </div>
    <div class="row file_lists">
        @php
            $datas = \DB::connection('mysql2')->select('call `files_dropzone`("' .  $sam_id . '")');

            $unique_activity_id = array_unique(array_column($datas, 'activity_id'));

            $activities = \DB::connection('mysql2')
                                ->table('stage_activities')
                                ->select('activity_id', 'activity_name')
                                ->where('program_id', $datas[0]->program_id)
                                ->whereIn('activity_id', $unique_activity_id )
                                ->get();

            // dd( $activities );
        @endphp

        @foreach ($activities as $activity)
            <h5 class="w-100">{{ $activity->activity_name }}</h5>
            @forelse ($datas as $data)
                @if ($activity->activity_id == $data->activity_id)
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
                        <div class="col-md-4 col-sm-4 view_file_lists col-12 mb-2 dropzone_div_{{ $data->sub_activity_id }}" style="cursor: pointer;" data-sub_activity_id="{{ $data->sub_activity_id }}" data-sam_id="{{ $sam_id }}" data-value="{{ json_encode($uploaded_files) }}">
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
                @endif
            @empty
                <div class="col-12 text-center">
                    <h3>No files here.</h3>
                </div>
            @endforelse
        @endforeach

        <input type="hidden" name="hidden_sam_id" value="{{ $sam_id }}">
    </div>
</div>
<script>  
    
    $(".view_file_lists").on("click", function (){

        var extensions = ["pdf", "jpg", "png"];

        var values = JSON.parse($(this).attr('data-value'));

        if( extensions.includes(JSON.parse(values[0].value).file.split('.').pop()) == true) {     
            htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 400px; height: 100%" src="/ViewerJS/#../files/' + JSON.parse(values[0].value).file + '" allowfullscreen></iframe>';
        } else {
          htmltoload = '<div class="text-center my-5"><a target="_blank" href="/files/' + JSON.parse(values[0].value).file + '"><i class="fa fa-fw display-1" aria-hidden="true" title="Copy to use file-excel-o"></i><H5>Download Document</H5></a><small>No viewer available; download the file to check.</small></div>';
        }
                
        $('.file_viewers').html('');
        $('.file_viewers').html(htmltoload);

        var sam_id = $(this).attr('data-sam_id');

        console.log(sam_id);

        $('.file_viewer_lists').html('');

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

        $('.file_viewer_lists').html(htmllist);
        $(".table_uploaded").attr("id", "table_uploaded_files_"+sub_activity_id);

        if (! $.fn.DataTable.isDataTable("#table_uploaded_files_"+sub_activity_id) ){
            $("#table_uploaded_files_"+sub_activity_id).DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/get-my-sub_act_value/"+sub_activity_id+"/"+sam_id,
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
        $('.file_previews').removeClass('d-none');

    });

    $("#btn_back_to_file_list_file_2").on("click", function (){
        $('.file_lists').removeClass('d-none');
        $('.file_previews').addClass('d-none');
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
                
        $('.file_viewers').html('');
        $('.file_viewers').html(htmltoload);
    });

</script>

