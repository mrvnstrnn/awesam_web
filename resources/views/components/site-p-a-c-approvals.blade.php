<div class="row file_preview d-none">
    <div class="col-12 mb-3">
        <button id="btn_back_to_file_list" class="mt-0 btn btn-secondary" type="button">Back to files</button>
        {{-- <button id="btn_back_to_file_list" class="float-right mt-0 btn btn-success" type="button">Approve Document</button> --}}
        {{-- <button id="btn_back_to_file_list" class="mr-2 float-right mt-0 btn btn-transition btn-outline-danger" type="button">Reject Document</button> --}}
    </div>
    <div class="col-12 file_viewer">
    </div>
    <div class="col-12 my-3">
        <b>Remarks: </b><p class="remarks_paragraph">Sample remarks</p>
    </div>
    <div class="col-12 file_viewer_list pt-3">
    </div>
</div>
<div class="row file_lists">
    @php
        // $datas = \DB::connection('mysql2')->select('call `files_dropzone`("' .  $site[0]->sam_id . '")');
        $datas = \DB::connection('mysql2')
                        ->table('sub_activity_value')
                        ->select('sub_activity_value.*', 'sub_activity.sub_activity_name')
                        ->join('sub_activity', 'sub_activity_value.sub_activity_id', 'sub_activity.sub_activity_id')
                        ->where('sub_activity_value.sam_id', $site[0]->sam_id)
                        ->where('sub_activity.action', 'doc upload')
                        ->orderBy('sub_activity_value.sub_activity_id')
                        ->get();

        $keys_datas = $datas->groupBy('sub_activity_name')->keys();
    @endphp

    @forelse ($datas->groupBy('sub_activity_name') as $data)
        @php $status_collect = collect(); @endphp
        @for ($i = 0; $i < count($data); $i++)
            @php
                $status_collect->push( $data[$i]->status );
            @endphp
        @endfor
        @if ( count( $status_collect->all() ) > 0 )
            @php

                if (pathinfo($data[0]->value, PATHINFO_EXTENSION) == "pdf") {
                    $extension = "fa-file-pdf";
                } else if (pathinfo($data[0]->value, PATHINFO_EXTENSION) == "png" || pathinfo($data[0]->value, PATHINFO_EXTENSION) == "jpeg" || pathinfo($data[0]->value, PATHINFO_EXTENSION) == "jpg") {
                    $extension = "fa-file-image";
                } else {
                    $extension = "fa-file";
                }

                $icon_color = "";
                if ( in_array( 'approved', $status_collect->all() ) ) {
                    $icon_color = "success";
                } else if ( in_array( 'denied', $status_collect->all() ) && in_array( 'pending', $status_collect->all() ) ) {
                    $icon_color = "secondary";
                } else if ( in_array( 'pending', $status_collect->all() ) ) {
                    $icon_color = "secondary";
                } else {
                    $icon_color = "danger";
                }
            @endphp
            
            <div class="col-md-4 col-sm-4 view_file col-12 mb-2 dropzone_div_{{ $data[0]->sub_activity_id }}" style="cursor: pointer;" data-value="{{ json_encode($data) }}" data-sub_activity_name="{{ $data[0]->sub_activity_name }}" data-id="{{ $data[0]->id }}" data-status="{{ $data[0]->status }}" data-sam_id="{{ $site[0]->sam_id }}" data-activity_id="{{ $site[0]->activity_id }}" data-site_category="{{ $site[0]->site_category }}" data-sub_activity_id="{{ $data[0]->sub_activity_id }}">
                <div class="child_div_{{ $data[0]->sub_activity_id }}">
                    <div class="dz-message text-center align-center border" style='padding: 25px 0px 15px 0px;'>
                        <div>
                        <i class="fa {{ $extension }} fa-3x text-dark"></i><br>
                        <p><small>{{ $data[0]->sub_activity_name }}</small></p>
                        </div>
                    </div>
                    @if($icon_color == "success")   
                        <i class="fa fa-check-circle fa-lg text-{{ $icon_color }}" style="position: absolute; top:10px; right: 20px"></i><br>
                    @elseif($icon_color == "danger")   
                        <i class="fa fa-times-circle fa-lg text-{{ $icon_color }}" style="position: absolute; top:10px; right: 20px"></i><br>
                    @endif
                </div>
            </div>
        @endif
    @empty
        <div class="col-12 text-center">
            <h3>No files here.</h3>
        </div>
    @endforelse

    <input type="hidden" name="hidden_filename" id="hidden_filename">
</div>

@if (!is_null(\Auth::user()->getRtbApproved($site[0]->sam_id)) )
    <div class="row my-3">
        <div class="col-12">
            <b>RTB Approved Date: </b><span>{{ date('M d, Y h:m:s', strtotime(\Auth::user()->getRtbApproved($site[0]->sam_id)->date_approved)) }}</span><br>
            <b>Approved By: </b><span>{{ \Auth::user()->getRtbApproved($site[0]->sam_id)->name }}</span>
        </div>
    </div>
@endif

<div class="row mb-3 border-top pt-3">
    <div class="col-12 align-right">                                            
        <button class="float-right btn btn-shadow btn-success ml-1 btn-accept-endorsement" id="btn-true" data-complete="true" data-sam_id="{{ $site[0]->sam_id }}" data-site_category="{{ $site[0]->site_category }}" data-activity_id="{{ $site[0]->activity_id }}">Approve Site</button>
        <button class="float-right btn btn-shadow btn-danger btn-accept-endorsement" id="btn-false" data-complete="false" data-sam_id="{{ $site[0]->sam_id }}" data-site_category="{{ $site[0]->site_category }}" data-activity_id="{{ $site[0]->activity_id }}">Reject Site</button>                                      
    </div>
</div>

<script src="/js/dropzone/dropzone.js"></script>

<script>
    
    $(".view_file_site").on("click", function (e){
        e.preventDefault();

        var extensions = ["pdf", "jpg", "png"];

        var values = JSON.parse($(this).attr('data-value'));

        console.log(values);

        var sam_id = $(this).attr('data-sam_id');
        var sub_activity_id = $(this).attr('data-sub_activity_id');
        var id = values[0].id;

        if( extensions.includes(values[0].value.split('.').pop()) == true) {     
            htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 400px; height: 100%" src="/ViewerJS/#../files/' + values[0].value + '" allowfullscreen></iframe>';
        } else {
          htmltoload = '<div class="text-center my-5"><a href="/files/' + values[0].value + '"><i class="fa fa-fw display-1" aria-hidden="true" title="Copy to use file-excel-o"></i><H5>Download Document</H5></a><small>No viewer available; download the file to check.</small></div>';
        }
                
        $('.file_viewer').html('');
        $('.file_viewer').html(htmltoload);

        $('.file_viewer_list').html('');

        // values.forEach(function(item, index){
            
        //     htmllist = "<tr>" + 
        //                     "<td>"  + item.id + "</td>" +
        //                     "<td>"  + item.value + "</td>" +
        //                     "<td>"  + item.status + "</td>" +
        //                     "<td>"  + item.date_created + "</td>" +
        //                 "</tr>";
        // });

        // htmllist = "<table class='table-bordered mb-0 table'>" + 
        //                 "<thead>" +
        //                     "<tr>" +                           
        //                         "<th>#</th>"+
        //                         "<th>file</th>"+
        //                         "<th>status</th>"+
        //                         "<th>timestamp</th>"+
        //                     "</tr>" +                           
        //                 "</thead>" +
        //                 "<tbody>" +
        //                     htmllist + 
        //                 "</tbody>" +
        //             "</table>";

        htmllist = '<div class="table-responsive table_uploaded_parent">' +
                '<table class="table_uploaded align-middle mb-0 table table-borderless table-striped table-hover w-100">' +
                    '<thead>' +
                        '<tr>' +
                            '<th style="width: 5%">#</th>' +
                            '<th>Filename</th>' +
                            '<th style="width: 35%">Status</th>' +
                            '<th>Date Uploaded</th>' +
                            '<th>Date Approved</th>' +
                        '</tr>' +
                    '</thead>' +
                '</table>' +
            '</div>';

        $('.file_viewer_list').html(htmllist);
        $(".table_uploaded").attr("id", "table_uploaded_files_"+sub_activity_id);

        remarks_file(id, sam_id);

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
                    { data: "date_approved" },
                ],
            });
        } else {
            $("#table_uploaded_files_"+sub_activity_id).DataTable().ajax.reload();
        }

        $('.file_lists').addClass('d-none');
        $('.file_preview').removeClass('d-none');

    });

    function remarks_file (id, sam_id) {
        $.ajax({
            url: "/get-remarks-file/"+id+"/"+sam_id,
            method: "GET",
            success: function (resp) {
                if (!resp.error) {
                    if (resp.message == null) {
                        $(".remarks_paragraph").text("No remarks available.");
                    } else {
                        $(".remarks_paragraph").text(JSON.parse(resp.message.value).remarks);
                    }
                } else {
                    Swal.fire(
                        'Error',
                        resp.message,
                        'error'
                    )
                }
            },

            error: function (resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )
            },
        });
    }

    $("#btn_back_to_file_list").on("click", function (){
        $('.file_lists').removeClass('d-none');
        $('.file_preview').addClass('d-none');
    });


    $(".dropzone_files").on("click", function (){
        $("input[name=hidden_sub_activity_name]").val($(this).attr("data-sub_activity_name"));
    });

    $(".btn-accept-endorsement").click(function(e){
        e.preventDefault();

        var sam_id = [$(this).attr('data-sam_id')];
        var data_complete = $(this).attr('data-complete');
        var site_category = [$(this).attr('data-site_category')];
        var activity_id = [$(this).attr('data-activity_id')];
        var activity_name = $("#modal_activity_name").val();
        var site_vendor_id = [$("#modal_site_vendor_id").val()];
        var program_id = $("#modal_program_id").val();

        // if ("{{ \Auth::user()->profile_id }}" == 10) {
        //     activity_name = "pac_approval";
        // } else if ("{{ \Auth::user()->profile_id }}" == 14) {
        //     activity_name = "pac_director_approval";
        // } else if ("{{ \Auth::user()->profile_id }}" == 13) {
        //     activity_name = "pac_vp_approval";
        // } 

        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        $.ajax({
            url: '/accept-reject-endorsement',
            data: {
                sam_id : sam_id,
                data_complete : data_complete,
                activity_name : activity_name,
                site_vendor_id : site_vendor_id,
                program_id : program_id,
                site_category : site_category,
                activity_id : activity_id,
            },
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp){
                if(!resp.error){
                    $("#"+$(".ajax_content_box").attr("data-what_table")).DataTable().ajax.reload(function(){
                        $("#viewInfoModal").modal("hide");
                        toastr.success(resp.message, 'Success');
                        
                        $("#btn-"+data_complete).removeAttr("disabled");
                        $("#btn-"+data_complete).text(data_complete == "false" ? "Reject" : "Approve Site");
                        // $("#loaderModal").modal("hide");
                    });
                } else {
                    toastr.error(resp.message, 'Error');
                    $("#btn-"+data_complete).removeAttr("disabled");
                    $("#btn-"+data_complete).text(data_complete == "false" ? "Reject" : "Approve Site");
                }
            },
            error: function(resp){
                // $("#loaderModal").modal("hide");
                toastr.error(resp.message, 'Error');
                $("#btn-"+data_complete).removeAttr("disabled");
                $("#btn-"+data_complete).text(data_complete == "false" ? "Reject" : "Approve Site");
            }
        });

    });

</script>

