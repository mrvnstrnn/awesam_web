<div class="modal fade" id="viewInfoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" style="background-color: transparent; border: 0">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="main-card mb-3 card ">

                        <div class="dropdown-menu-header">
                            <div class="dropdown-menu-header-inner bg-dark">
                                <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                                <div class="menu-header-content btn-pane-right">
                                    <h5 class="menu-header-title">
                                        Doc Validation
                                    </h5>
                                </div>
                            </div>
                        </div> 

                        <div class="modal-body">

                            <div class="row file_preview d-none">
                                <div class="col-12 mb-3">
                                    <button id="btn_back_to_file_list" class="mt-0 btn btn-secondary" type="button">Back to files</button>
                                    <button class="float-right mt-0 btn btn-success approve_reject_doc_btns" data-action="approve" type="button">Approve Document</button>
                                    <button class="mr-2 float-right mt-0 btn btn-transition btn-outline-danger approve_reject_doc_btns" data-action="reject" type="button">Reject Document</button>
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
                                                    ->select('sub_activity_value.*', 'sub_activity.sub_activity_name', 'sub_activity.sub_activity_id')
                                                    ->join('sub_activity', 'sub_activity_value.sub_activity_id', 'sub_activity.sub_activity_id')
                                                    ->where('sub_activity_value.sam_id', $site[0]->sam_id)
                                                    ->where('sub_activity.action', 'doc upload')
                                                    ->orderBy('sub_activity_value.sub_activity_id')
                                                    ->get();

                                    $keys_datas = $datas->groupBy('sub_activity_id')->keys();
                                @endphp

                                @forelse ($datas->groupBy('sub_activity_id') as $data)
                                    @php $status_collect = collect(); @endphp
                                    @for ($i = 0; $i < count($data); $i++)
                                        @php
                                            $json_status = json_decode( $data[$i]->value );

                                            if ( isset($json_status->validators) ) {
                                                for ($j=0; $j < count($json_status->validators); $j++) { 
                                                    if (\Auth::user()->profile_id == $json_status->validators[$j]->profile_id) {
                                                        $status_collect->push( $json_status->validators[$j]->status );
                                                    }
                                                }
                                            } else {
                                                $status_collect->push( $data[$i]->status );
                                            }
                                            // $status_collect->push( $data[$i]->status );
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
                                                $border = "border-success";
                                            } else if ( in_array( 'denied', $status_collect->all() ) && in_array( 'pending', $status_collect->all() ) ) {
                                                $icon_color = "secondary";
                                                $border = "border-secondary";
                                            } else if ( in_array( 'pending', $status_collect->all() ) ) {
                                                $icon_color = "secondary";
                                                $border = "border-secondary";
                                            } else {
                                                $icon_color = "danger";
                                                $border = "border-danger";
                                            }
                                        @endphp
                                        
                                        <div class="col-md-4 col-sm-4 view_file col-12 mb-2 dropzone_div_{{ $data[0]->sub_activity_id }}" style="cursor: pointer;" data-value="{{ json_encode($data) }}" data-sub_activity_name="{{ $data[0]->sub_activity_name }}" data-id="{{ $data[0]->id }}" data-status="{{ $data[0]->status }}" data-sam_id="{{ $site[0]->sam_id }}" data-activity_id="{{ $site[0]->activity_id }}" data-site_category="{{ $site[0]->site_category }}" data-sub_activity_id="{{ $data[0]->sub_activity_id }}">
                                            <div class="child_div_{{ $data[0]->sub_activity_id }}">
                                                <div class="dz-message text-center align-center border {{ $border }}" style='padding: 25px 0px 15px 0px;'>
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

                            <div class="row confirmation_message text-center pt-2 pb-5 d-none">
                                <div class="col-12">
                                    <div class="swal2-icon swal2-question swal2-animate-question-icon" style="display: flex;"><span class="swal2-icon-text">?</span></div>
                                    <p>Are you sure you want to <b></b> the document of <span class="sub_activity_name"></span>?</p>

                                    <textarea placeholder="Please enter your reason..." name="text_area_reason" id="text_area_reason" cols="30" rows="5" class="form-control mb-3"></textarea>
                                    <small class="reason-error text-danger"></small><br>
                                    
                                    <button type="button" class="btn btn-secondary btn-sm cancel_reject_approve">Cancel</button>
                                    <button type="button" class="btn btn-sm approve_reject_doc_btns_final">Confirm</button>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/js/dropzone/dropzone.js"></script>

<script>  
    
    $(".view_file").on("click", function (e){

        e.preventDefault();

        var id = $(this).attr("data-id");

        $(".approve_reject_doc_btns").attr("data-id", id);

        $(".approve_reject_doc_btns").attr("data-sub_activity_name", $(this).attr("data-sub_activity_name"));
        $(".approve_reject_doc_btns").attr("data-activity_id", $(this).attr("data-activity_id"));
        $(".approve_reject_doc_btns").attr("data-site_category", $(this).attr("data-site_category"));
        
        var sub_activity_id = $(this).attr("data-sub_activity_id");
        $(".approve_reject_doc_btns").attr("data-sub_activity_id", sub_activity_id);

        if ($(this).attr("data-status") == "pending"){
            $(".approve_reject_doc_btns").removeClass("d-none");
        } else {
            $(".approve_reject_doc_btns").addClass("d-none");
        }

        var extensions = ["pdf", "jpg", "png"];

        var values = JSON.parse($(this).attr('data-value'));

        if( extensions.includes(values[0].value.split('.').pop()) == true) {     
            htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 400px; height: 100%" src="/ViewerJS/#../files/' + values[0].value + '" allowfullscreen></iframe>';
        } else {
          htmltoload = '<div class="text-center my-5"><a href="/files/' + values[0].value + '"><i class="fa fa-fw display-1" aria-hidden="true" title="Copy to use file-excel-o"></i><H5>Download Document</H5></a><small>No viewer available; download the file to check.</small></div>';
        }

        $("#hidden_filename").val(values[0].value);

        var sam_id = $(this).attr('data-sam_id');
                
        $('.file_viewer').html('');
        $('.file_viewer').html(htmltoload);

        $('.file_viewer_list').html('');

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

        remarks_file(id, sam_id);

        if (! $.fn.DataTable.isDataTable("#table_uploaded_files_"+sub_activity_id) ){
            $("#table_uploaded_files_"+sub_activity_id).DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/get-uploaded-files/"+sub_activity_id+"/"+sam_id,
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

    $(document).on("click", ".table_uploaded tr", function (e) {
        e.preventDefault();
        var extensions = ["pdf", "jpg", "png"];

        var sam_id = $("#modal_sam_id").val();
        var value = $(this).attr("data-value");
        var id = $(this).attr("data-id");
        var sub_activity_id = $(this).attr("data-sub_activity_id");

        remarks_file(id, sam_id);
        $(".approve_reject_doc_btns").attr("data-sub_activity_id", sub_activity_id);
        $(".approve_reject_doc_btns").attr("data-id", id);

        if ($(this).attr("data-status") == "pending"){
            $(".approve_reject_doc_btns").removeClass("d-none");
        } else {
            $(".approve_reject_doc_btns").addClass("d-none");
        }


        if( extensions.includes(value.split('.').pop()) == true) {     
            htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 400px; height: 100%" src="/ViewerJS/#../files/' + value + '" allowfullscreen></iframe>';
        } else {
          htmltoload = '<div class="text-center my-5"><a href="/files/' + value + '"><i class="fa fa-fw display-1" aria-hidden="true" title="Copy to use file-excel-o"></i><H5>Download Document</H5></a><small>No viewer available; download the file to check.</small></div>';
        }

        $("#hidden_filename").val(value);
                
        $('.file_viewer').html('');
        $('.file_viewer').html(htmltoload);
    });

    $("#btn_back_to_file_list").on("click", function (){
        $('.file_lists').removeClass('d-none');
        $('.file_preview').addClass('d-none');
    });


    $(".dropzone_files").on("click", function (){
        $("input[name=hidden_sub_activity_name]").val($(this).attr("data-sub_activity_name"));
    });

    // $(".file_preview").off().on("click", ".approve_reject_doc_btns", function (e){
    $(".file_preview").on("click", ".approve_reject_doc_btns", function (e){
        e.preventDefault();
        $(".confirmation_message").removeClass("d-none");
        $(".file_preview").addClass("d-none");


        $(".confirmation_message b").text($(this).attr("data-action"));
        $(".confirmation_message span.sub_activity_name").text($(this).attr("data-sub_activity_name"));
        $(".approve_reject_doc_btns_final").attr("data-action", $(this).attr("data-action") == "reject" ? "rejected" : "approved");
        $(".approve_reject_doc_btns_final").attr("data-id", $(this).attr("data-id"));
        $(".approve_reject_doc_btns_final").attr("data-sub_activity_id", $(this).attr("data-sub_activity_id"));
        $(".approve_reject_doc_btns_final").attr("data-activity_id", $(this).attr("data-activity_id"));
        $(".approve_reject_doc_btns_final").attr("data-site_category", $(this).attr("data-site_category"));

        if ($(this).attr("data-action") == "reject"){
            $(".confirmation_message textarea").removeClass("d-none");
            $(".approve_reject_doc_btns_final").addClass("btn-danger");
            $(".approve_reject_doc_btns_final").removeClass("btn-primary");
        } else {
            $(".confirmation_message textarea").addClass("d-none");
            $(".approve_reject_doc_btns_final").addClass("btn-primary");
            $(".approve_reject_doc_btns_final").removeClass("btn-danger");
        }
    });
    // confirmation_message
    $(".confirmation_message").off().on("click", ".approve_reject_doc_btns_final", function (e){
        e.preventDefault();
        var data_action = $(this).attr("data-action");
        var data_id = $(this).attr("data-id");
        var sub_activity_id = $(this).attr("data-sub_activity_id");
        var activity_id = $(this).attr("data-activity_id");
        var site_category = $(this).attr("data-site_category");

        var text_area_reason = $("#text_area_reason").val();

        var site_vendor_id = $("#modal_site_vendor_id").val();
        var program_id = $("#modal_program_id").val();

        // var sam_id = $("#details_sam_id").val();
        var sam_id = "{{ $site[0]->sam_id }}"
        var filename = $("#hidden_filename").val();

        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        $(".confirmation_message small").text("");

        $.ajax({
            url: "/doc-validation-approval",
            method: "POST",
            data: {
                action : data_action,
                id : data_id,
                reason : text_area_reason,
                sam_id : sam_id,
                filename : filename,
                site_vendor_id : site_vendor_id,
                program_id : program_id,
                activity_id : activity_id,
                site_category : site_category,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp){
                if (!resp.error){
                    $(".approve_reject_doc_btns_final").removeAttr("disabled");
                    $(".approve_reject_doc_btns_final").text("Confirm");

                    $(".dropzone_div_"+sub_activity_id).attr("data-status", data_action);

                    Swal.fire(
                        'Success',
                        resp.message,
                        'success'
                    )
                    $("#text_area_reason").val("");

                    if (data_action == "approved") {
                        $(".child_div_"+sub_activity_id).append(
                            '<i class="fa fa-check-circle fa-lg text-success" style="position: absolute; top:10px; right: 20px"></i><br>'
                        );
                    } else {
                        $(".child_div_"+sub_activity_id).append(
                            '<i class="fa fa-times-circle fa-lg text-danger" style="position: absolute; top:10px; right: 20px"></i><br>'
                        );
                    }
                    
                    $(".file_lists").removeClass("d-none");
                    $(".confirmation_message").addClass("d-none");
                } else {
                    
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $(".confirmation_message ." + index + "-error").text(data);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }
                    
                    $(".approve_reject_doc_btns_final").removeAttr("disabled");
                    $(".approve_reject_doc_btns_final").text("Confirm");
                }
            },
            error: function (resp){
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )
                    $(".approve_reject_doc_btns_final").removeAttr("disabled");
                    $(".approve_reject_doc_btns_final").text("Confirm");
            },
        });
    });

    $(".cancel_reject_approve").on("click", function  (){
        $(".confirmation_message").addClass("d-none");
        $(".file_preview").removeClass("d-none");
    });

</script>

