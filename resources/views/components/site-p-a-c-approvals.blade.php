
<div class="modal-body">
    <div class="row file_preview d-none">
        <div class="col-12 mb-3">
            <button id="btn_back_to_file_list" class="mt-0 btn btn-secondary" type="button">Back to files</button>
            {{-- <button id="btn_back_to_file_list" class="float-right mt-0 btn btn-success" type="button">Approve Document</button> --}}
            <button class="mr-2 float-right mt-0 btn btn-transition btn-outline-danger approve_reject_doc_btns" data-action="reject" type="button">Reject Document</button>
        </div>

        <div class="col-12 link_url">
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
            // if (\Auth::user()->profile_id == 30) {
            //     $datas = \DB::table('sub_activity_value')
            //                     ->select('sub_activity_value.*', 'sub_activity.sub_activity_name', 'sub_activity.sub_activity_id', 'sub_activity.requires_validation', 'sub_activity.activity_id')
            //                     ->join('sub_activity', 'sub_activity_value.sub_activity_id', 'sub_activity.sub_activity_id')
            //                     ->where('sub_activity_value.sam_id', $site[0]->sam_id)
            //                     ->where('sub_activity_value.type', 'doc_upload')
            //                     ->whereNotIn('sub_activity.activity_id', ['6', '8', '11'])
            //                     ->orderBy('sub_activity_value.sub_activity_id')
            //                     ->get();
            // } else {
                $datas = \DB::table('sub_activity_value')
                                ->select('sub_activity_value.*', 'sub_activity.sub_activity_name', 'sub_activity.sub_activity_id', 'sub_activity.requires_validation', 'sub_activity.activity_id')
                                ->join('sub_activity', 'sub_activity_value.sub_activity_id', 'sub_activity.sub_activity_id')
                                ->where('sub_activity_value.sam_id', $site[0]->sam_id)
                                ->where('sub_activity_value.type', 'doc_upload')
                                ->orderBy('sub_activity_value.sub_activity_id')
                                ->get();
            // }

            $unique_activity_id = array_unique( array_column($datas->all(), 'activity_id') );

            $activities = \DB::table('stage_activities')
                            ->select('activity_id', 'activity_name')
                            ->where('program_id', $site[0]->program_id)
                            ->where('category', $site[0]->site_category)
                            ->whereIn('activity_id', $unique_activity_id )
                            ->distinct()
                            ->get();

            $keys_datas = $datas->groupBy('sub_activity_id')->keys();
        @endphp

        @foreach ($activities as $activity)
            <h5 class="w-100">{{ $activity->activity_name }}</h5>
            @forelse ($datas->groupBy('sub_activity_id') as $data)
                @if ($activity->activity_id == $data[0]->activity_id)
                    @php
                        $status_collect = collect();
                        $status_docs_collect = collect();
                    @endphp
                    @for ($i = 0; $i < count($data); $i++)
                        @php
                            if ($data[$i]->status == 'rejected') {
                                $status_collect->push( $data[$i]->status );
                            } else {
                                $json_status = json_decode( $data[$i]->value );
                                $json_status_first = json_decode( $data[0]->value );

                                if ( isset($json_status->validators) ) {
                                    for ($j=0; $j < count($json_status->validators); $j++) { 
                                        $status_collect->push( $json_status->validators[$j]->status );
                                        $status_file = $json_status_first->validators[$j]->status;
                                    }
                                } else {
                                    $status_collect->push( $data[$i]->status );
                                    $status_file = $data[0]->status;
                                }
                            }
                            // $status_collect->push( $data[$i]->status );
                        @endphp
                    @endfor
                    @if ( count( $status_collect->all() ) > 0 )
                        @php
                            $json_file_status = json_decode( $data[0]->value );
                            
                            if (pathinfo($json_file_status->file, PATHINFO_EXTENSION) == "pdf") {
                                $extension = "fa-file-pdf";
                            } else if (pathinfo($json_file_status->file, PATHINFO_EXTENSION) == "png" || pathinfo($json_file_status->file, PATHINFO_EXTENSION) == "jpeg" || pathinfo($json_file_status->file, PATHINFO_EXTENSION) == "jpg") {
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
                        
                        {{-- <div class="col-md-4 col-sm-4 view_file col-12 mb-2 dropzone_div_{{ $data[0]->sub_activity_id }}" style="cursor: pointer;" data-value="{{ json_encode($data) }}" data-sub_activity_name="{{ $data[0]->sub_activity_name }}" data-id="{{ $data[0]->id }}" data-status="{{ $status_file }}" data-sam_id="{{ $site[0]->sam_id }}" data-activity_id="{{ $site[0]->activity_id }}" data-site_category="{{ $site[0]->site_category }}" data-sub_activity_id="{{ $data[0]->sub_activity_id }}"> --}}
                            
                        <div class="col-md-4 col-sm-4 view_file col-12 mb-2 dropzone_div_{{ $data[0]->sub_activity_id }}" style="cursor: pointer;" data-value="{{ json_encode($data) }}" data-sub_activity_name="{{ $data[0]->sub_activity_name }}" data-id="{{ $data[0]->id }}" data-status="{{ $data[0]->status }}" data-sub_activity_id="{{ $data[0]->sub_activity_id }}" data-requires_validation="{{ $data[0]->requires_validation }}">
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
                @endif
            @empty
                <div class="col-12 text-center">
                    <h3>No files here.</h3>
                </div>
            @endforelse
        @endforeach

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
    {{-- @php
    dd($status_collect);
    @endphp --}}
    <div class="row reject_remarks d-none">
        <div class="col-12">
            <p class="message_p">Are you sure you want to reject this site <b></b>?</p>
            <form class="reject_form">
                <input type="hidden" name="type" id="type" value="reject_site">
                <div class="form-group">
                    <label for="remarks">Remarks:</label>
                    <textarea style="width: 100%;" name="remarks" id="remarks" rows="5" cols="100" class="form-control"></textarea>
                    <small class="text-danger remarks-error"></small>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-sm btn-shadow btn-accept-endorsement" id="btn-false" data-complete="false" data-sam_id="{{ $site[0]->sam_id }}" data-site_category="{{ $site[0]->site_category }}" data-activity_id="{{ $site[0]->activity_id }}" type="button">Confirm</button>
                    
                    <button class="btn btn-secondary btn-sm btn-shadow cancel_reject" type="button">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    @if (!is_null(\Auth::user()->getRtbApproved($site[0]->sam_id)) )
        <div class="row my-3">
            <div class="col-12">
                <b>RTB Approved Date: </b><span>{{ date('M d, Y h:m:s', strtotime(\Auth::user()->getRtbApproved($site[0]->sam_id)->date_approved)) }}</span><br>
                <b>Approved By: </b><span>{{ \Auth::user()->getRtbApproved($site[0]->sam_id)->name }}</span>
            </div>
        </div>
    @endif

    <div class="row mb-3 border-top pt-3 button_area_div">
        <div class="col-12 align-right">
            {{-- {{ in_array('rejected', $status_collect->all()) ? "d-none" : "" }} --}}
            <button class="float-right btn btn-shadow btn-success ml-1 btn-accept-endorsement" id="btn-true" data-complete="true" data-sam_id="{{ $site[0]->sam_id }}" data-site_category="{{ $site[0]->site_category }}" data-activity_id="{{ $site[0]->activity_id }}">Approve Site</button>
            
            {{-- <button class="float-right btn btn-shadow btn-danger btn-accept-endorsement-confirmation {{ in_array('rejected', $status_collect->all()) ? "" : "d-none" }}" id="btn-false" data-complete="false" data-sam_id="{{ $site[0]->sam_id }}" data-site_category="{{ $site[0]->site_category }}" data-activity_id="{{ $site[0]->activity_id }}">Reject Site</button> --}}
            <button class="float-right btn btn-shadow btn-danger btn-accept-endorsement-confirmation" id="btn-false" data-complete="false" data-sam_id="{{ $site[0]->sam_id }}" data-site_category="{{ $site[0]->site_category }}" data-activity_id="{{ $site[0]->activity_id }}">Reject Site</button>
        </div>
    </div>

</div>

<script>
    
    $(".view_file").on("click", function (e){
        e.preventDefault();

        var id = $(this).attr("data-id");
        $(".button_area_div").addClass("d-none");

        $(".approve_reject_doc_btns").attr("data-id", id);

        $(".approve_reject_doc_btns").attr("data-sub_activity_name", $(this).attr("data-sub_activity_name"));
        $(".approve_reject_doc_btns").attr("data-activity_id", $(this).attr("data-activity_id"));
        $(".approve_reject_doc_btns").attr("data-site_category", $(this).attr("data-site_category"));
        
        var sub_activity_id = $(this).attr("data-sub_activity_id");
        $(".approve_reject_doc_btns").attr("data-sub_activity_id", sub_activity_id);

        var extensions = ["pdf", "jpg", "png"];

        var values = JSON.parse($(this).attr('data-value'));

        var sam_id = "{{ $site[0]->sam_id }}";
        var sub_activity_id = $(this).attr('data-sub_activity_id');
        var id = values[0].id;

        $.ajax({
            url: "/get-link-old-data",
            method: "POST",
            data : {
                sub_activity_id : sub_activity_id,
                sam_id : sam_id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function ( resp ) {
                if ( !resp.error ) {
                    if (resp.message != null) {
                        $(".link_url").html(
                            '<a href="https://www.appsheet.com/template/gettablefileurl?appName=COLOCV2r-1419547&tableName=FILES&fileName='+resp.message.UPLOAD_FILE+'" target="_blank" class="mb-2 mr-2 btn-icon btn-shadow btn-outline-2x btn btn-outline-link pull-right pull-right"><i class="lnr-link btn-icon-wrapper"> </i>Appsheet File Link</a>'
                        );
                    }
                } else {
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )
                }
            },
            error: function ( resp ) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )
            }
        });

        if ($(this).attr("data-status") != "rejected"){
            if ($(this).attr("data-requires_validation") == 1) {
                $(".approve_reject_doc_btns").removeClass("d-none");
            } else {
                $(".approve_reject_doc_btns").addClass("d-none");
            }
        } else {
            $(".approve_reject_doc_btns").addClass("d-none");
        }

        if( extensions.includes(JSON.parse(values[0].value).file.split('.').pop()) == true) {     
            htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 400px; height: 100%" src="/ViewerJS/#../files/' + JSON.parse(values[0].value).file + '" allowfullscreen></iframe>';
        } else {
          htmltoload = '<div class="text-center my-5"><a href="/files/' + JSON.parse(values[0].value).file + '"><i class="fa fa-fw display-1" aria-hidden="true" title="Copy to use file-excel-o">???</i><H5>Download Document</H5></a><small>No viewer available; download the file to check.</small></div>';
        }
        
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
                            '<th style="width: 35%">Reason</th>' +
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
                    { data: "reason" },
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
        $(".button_area_div").removeClass("d-none");
    });

    $(".btn-accept-endorsement-confirmation").on("click", function (){
        $('.reject_remarks').removeClass('d-none');
        $('.button_area_div').addClass('d-none');
        $('.file_lists').addClass('d-none');
    });

    $(".cancel_reject").on("click", function (){
        $('.reject_remarks').addClass('d-none');
        $('.button_area_div').removeClass('d-none');
        $('.file_lists').removeClass('d-none');
    });

    $(".dropzone_files").on("click", function (){
        $("input[name=hidden_sub_activity_name]").val($(this).attr("data-sub_activity_name"));
    });

    $(".btn-accept-endorsement").click(function(e){
        e.preventDefault();

        var sam_id = ["{{ $site[0]->sam_id }}"];
        var data_complete = $(this).attr('data-complete');
        var site_category = ["{{ $site[0]->site_category }}"];
        var activity_id = ["{{ $site[0]->activity_id }}"];
        var activity_name = "{{ preg_replace("/[^A-Za-z0-9\-]/", "_", strtolower($site[0]->activity_name)) }}";
        var program_id = "{{ $site[0]->program_id }}";

        // if ("{{ \Auth::user()->profile_id }}" == 10) {
        //     activity_name = "pac_approval";
        // } else if ("{{ \Auth::user()->profile_id }}" == 14) {
        //     activity_name = "pac_director_approval";
        // } else if ("{{ \Auth::user()->profile_id }}" == 13) {
        //     activity_name = "pac_vp_approval";
        // } 

        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        $("#btn-false").attr("disabled", "disabled");
        $("#btn-false").text("Processing...");

        if (data_complete == "false") {
            var type = $("#type").val();
            var remarks = $("#remarks").val();
            var activity_names = "reject_site";

            data = {
                sam_id : sam_id,
                data_complete : data_complete,
                activity_name : activity_names,
                program_id : program_id,
                site_category : site_category,
                activity_id : activity_id,
                type : type,
                remarks : remarks,
            }

            // var url = "/reject-site";
        } else {
            data = {
                sam_id : sam_id,
                data_complete : data_complete,
                activity_name : activity_name,
                // site_vendor_id : site_vendor_id,
                program_id : program_id,
                site_category : site_category,
                activity_id : activity_id,
            }

            // var url = "/accept-reject-endorsement";
        }

        $.ajax({
            url: "/accept-reject-endorsement",
            data: data,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp){
                if(!resp.error){
                    $("#"+$(".ajax_content_box").attr("data-what_table")).DataTable().ajax.reload(function(){
                        $("#viewInfoModal").modal("hide");
                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )
                        
                        $("#btn-"+data_complete).removeAttr("disabled");
                        $("#btn-"+data_complete).text(data_complete == "false" ? "Reject" : "Approve Site");

                        $("#btn-false").removeAttr("disabled");
                        $("#btn-false").text("Reject Site");
                        // $("#loaderModal").modal("hide");
                    });
                } else {
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $(".reject_form ." + index + "-error").text(data);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }
                    $("#btn-"+data_complete).removeAttr("disabled");
                    $("#btn-"+data_complete).text(data_complete == "false" ? "Reject" : "Approve Site");

                        $("#btn-false").removeAttr("disabled");
                        $("#btn-false").text("Reject Site");
                }
            },
            error: function(resp){
                // $("#loaderModal").modal("hide");
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )
                $("#btn-"+data_complete).removeAttr("disabled");
                $("#btn-"+data_complete).text(data_complete == "false" ? "Reject" : "Approve Site");

                
                $("#btn-false").removeAttr("disabled");
                $("#btn-false").text("Reject Site");
            }
        });

    });

    $(".file_preview").on("click", ".approve_reject_doc_btns", function (e){
        e.preventDefault();

        $(".confirmation_message").removeClass("d-none");
        $(".file_preview").addClass("d-none");
        $(".button_area_div").addClass("d-none");

        $(".confirmation_message b").text($(this).attr("data-action"));
        $(".confirmation_message span.sub_activity_name").text($(this).attr("data-sub_activity_name"));

        $(".approve_reject_doc_btns_final").attr("data-action", $(this).attr("data-action") == "reject" ? "rejected" : "approved");
        $(".approve_reject_doc_btns_final").attr("data-id", $(this).attr("data-id"));
        // $(".approve_reject_doc_btns_final").attr("data-sub_activity_id", $(this).attr("data-sub_activity_id"));
        $(".approve_reject_doc_btns_final").attr("data-activity_id", $(this).attr("data-activity_id"));
        // $(".approve_reject_doc_btns_final").attr("data-site_category", $(this).attr("data-site_category"));

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

    $(".cancel_reject_approve").on("click", function  (){
        $(".confirmation_message").addClass("d-none");
        $(".file_preview").removeClass("d-none");
        $(".button_area_div").removeClass("d-none");
    });

    $(".confirmation_message").off().on("click", ".approve_reject_doc_btns_final", function (e){
        e.preventDefault();

        var data_action = $(this).attr("data-action");
        var data_id = $(this).attr("data-id");
        var sub_activity_id = $(this).attr("data-sub_activity_id");
        var activity_id = "{{ $site[0]->activity_id }}";
        var site_category = "{{ $site[0]->site_category }}";

        var text_area_reason = $("#text_area_reason").val();

        // var sam_id = $("#details_sam_id").val();
        var sam_id = "{{ $site[0]->sam_id }}";
        var program_id = "{{ $site[0]->program_id }}";

        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        $(".confirmation_message small").text("");

        $.ajax({
            url: "/doc-validation-approval-reviewer",
            method: "POST",
            data: {
                action : data_action,
                id : data_id,
                reason : text_area_reason,
                sam_id : sam_id,
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

                    $(".button_area_div").addClass("d-none");

                    if (data_action == "rejected") {
                        $(".btn-accept-endorsement").addClass("d-none");
                        $(".btn-accept-endorsement-confirmation").removeClass("d-none");
                    }
                    $(".button_area_div").removeClass("d-none");

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

</script>

