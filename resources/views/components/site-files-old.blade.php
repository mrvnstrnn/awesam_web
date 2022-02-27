<div class="card-body">
    <div class="row file_previews d-none">
        <div class="col-12 mb-3">
            <button id="btn_back_to_file_list_file_2" class="mt-0 btn btn-secondary" type="button">Back to files</button>
        </div>
        
        <div class="col-12 link_url">
        </div>

        <div class="col-12 file_viewers">
        </div>
        
        <div class="col-12 file_viewer_lists pt-3">
        </div>
    </div>

    <div class="row file_lists">
        @php
            // $datas = \DB::select('call `files_dropzone`("' .  $sam_id . '")');
            $datas = \DB::table('sub_activity_value')
                            ->select('sub_activity_value.*', 'sub_activity.sub_activity_name', 'sub_activity.program_id', 'sub_activity.category', 'sub_activity.sub_activity_id', 'sub_activity.activity_id')
                            ->join('sub_activity', 'sub_activity_value.sub_activity_id', 'sub_activity.sub_activity_id')
                            ->where('sub_activity_value.sam_id', $sam_id)
                            ->where('sub_activity_value.type', 'doc_upload')
                            ->orderBy('sub_activity_value.sub_activity_id')
                            ->orderBy('sub_activity_value.value->active_status', 'desc')
                            ->get();
            
            $unique_activity_id = array_unique(array_column($datas->all(), 'activity_id'));

            $activities = \DB::table('stage_activities')
                                ->select('activity_id', 'activity_name')
                                ->where('program_id', $datas->all()[0]->program_id)
                                ->where('category', $datas->all()[0]->category)
                                ->whereIn('activity_id', $unique_activity_id )
                                ->get();

        @endphp

        @foreach ($activities as $activity)
            <h5 class="w-100">{{ $activity->activity_name }}</h5>
            @forelse ($datas->all() as $data)
                @php
                    $json_file = json_decode($data->value);
                @endphp
                @if ($activity->activity_id == $data->activity_id)
                    @if (is_null($json_file->file))
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
                            $uploaded_files = $json_file->file;

                                // if (pathinfo($uploaded_files[0]->value, PATHINFO_EXTENSION) == "pdf") {
                                //     $extension = "fa-file-pdf";
                                // } else if (pathinfo($uploaded_files[0]->value, PATHINFO_EXTENSION) == "png" || pathinfo($uploaded_files[0]->value, PATHINFO_EXTENSION) == "jpeg" || pathinfo($uploaded_files[0]->value, PATHINFO_EXTENSION) == "jpg") {
                                //     $extension = "fa-file-image";
                                // } else {
                                //     $extension = "fa-file";
                                // }

                                if (pathinfo($uploaded_files, PATHINFO_EXTENSION) == "pdf") {
                                    $extension = "fa-file-pdf";
                                } else if (pathinfo($uploaded_files, PATHINFO_EXTENSION) == "png" || pathinfo($uploaded_files, PATHINFO_EXTENSION) == "jpeg" || pathinfo($uploaded_files, PATHINFO_EXTENSION) == "jpg") {
                                    $extension = "fa-file-image";
                                } else {
                                    $extension = "fa-file";
                                }

                            $icon_color = "";
                            
                            // foreach($data as $approved){
                                if($data->status == "approved"){
                                    $icon_color = "success";
                                } else {
                                    $icon_color = "secondary";
                                }
                            // }

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
            <div class="divider col-12"></div>
        @endforeach

        <input type="hidden" name="hidden_sam_id" value="{{ $sam_id }}">
    </div>
</div>
<script>  
    
    $(".view_file_lists").on("click", function (){

        var extensions = ["pdf", "jpg", "png"];

        console.log($(this));

        // if ($(this).attr('data-is_temp') == '1') {
        //     $(".link_url").html(
        //         '<a href="https://www.appsheet.com/template/gettablefileurl?appName=COLOCV2r-1419547&tableName=FILES&fileName=FILES_Files_%2F791dd2c7.UPLOAD_FILE.053429.pdf&appVersion=1.000699&signature=8278929bb83de2e6558c5f4f088f048ef78fb2dbcf13f4545b6c36c3cd6c5722e6b49614504e2a76a85831192396c318">Insert Link Here.</a>'
        //     );
        // }

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
                    $(row).attr('data-is_temp', data.is_temp);
                    // $(row).attr('data-status', data.status);
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

        // if ($(this).attr('data-is_temp') == '1') {
        //     $(".link_url").html(
        //         '<a href="https://www.appsheet.com/template/gettablefileurl?appName=COLOCV2r-1419547&tableName=FILES&fileName='++'&appVersion=1.000699&signature=8278929bb83de2e6558c5f4f088f048ef78fb2dbcf13f4545b6c36c3cd6c5722e6b49614504e2a76a85831192396c318">Insert Link Here.</a>'
        //     );
        // }

        $("#hidden_filename").val(value);
                
        $('.file_viewers').html('');
        $('.file_viewers').html(htmltoload);
    });

</script>

