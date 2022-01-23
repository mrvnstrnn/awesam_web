

<div class="modal-body">
    <ul class="tabs-animated body-tabs-animated nav mb-4">
        <li class="nav-item">
            <a role="tab" class="nav-link active" id="tab-action-to-complete" data-toggle="tab" href="#tab-content-action-to-complete">
                <span>Checklists</span>
                {{-- <span class="badge badge-pill badge-success">{{ count($sub_activities) }}</span> --}}
            </a>
        </li>
        
        <li class="nav-item">
            <a role="tab" class="nav-link" id="tab-file" data-toggle="tab" href="#tab-content-file">
                <span>Files</span>
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane tabs-animation fade active show" id="tab-content-action-to-complete" role="tabpanel">
            <div class="row file_preview d-none">
                <div class="col-12 mb-3">
                    <button id="btn_back_to_file_list" class="mt-0 btn btn-secondary" type="button">Back to files</button>
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
                    $datas = \DB::table('sub_activity_value')
                                    ->select('sub_activity_value.*', 'sub_activity.sub_activity_name', 'sub_activity.sub_activity_id', 'sub_activity.requires_validation', 'sub_activity.activity_id')
                                    ->join('sub_activity', 'sub_activity_value.sub_activity_id', 'sub_activity.sub_activity_id')
                                    ->where('sub_activity_value.sam_id', $site[0]->sam_id)
                                    ->where('sub_activity_value.type', 'doc_upload')
                                    ->orderBy('sub_activity_value.sub_activity_id')
                                    ->get();
            
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
            
                {{-- <div class="row"> --}}
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Submitted By</th>
                                        <th>File</th>
                                        <th>Date Submitted</th>
                                        <th>Date Approved</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $datas_file = \DB::table('sub_activity_value')
                                                        ->select('users.name', 'sub_activity_value.*', 'sub_activity.sub_activity_name', 'sub_activity.sub_activity_id', 'sub_activity.requires_validation', 'sub_activity.activity_id')
                                                        ->join('sub_activity', 'sub_activity_value.sub_activity_id', 'sub_activity.sub_activity_id')
                                                        ->join('users', 'users.id', 'sub_activity_value.user_id')
                                                        ->where('sub_activity_value.sam_id', $site[0]->sam_id)
                                                        ->where('sub_activity_value.type', 'doc_upload')
                                                        ->where('sub_activity_value.status', 'approved')
                                                        ->orderBy('sub_activity_value.sub_activity_id')
                                                        ->get();   
                                    @endphp
                                    @foreach ($datas_file as $data_file)
                                        @php
                                            $file_name = json_decode($data_file->value);
                                        @endphp
                                        <tr>
                                            <td scope="row">
                                                {{ $data_file->name }}
                                                {{-- <input type="checkbox" name="checkbox{{$data_file->id}}" id="checkbox{{$data_file->id}}"> --}}
                                            </td>
                                            <td>{{ $file_name->file }}</td>
                                            <td>{{ date('M d, Y', strtotime($data_file->date_created) ) }}</td>
                                            <td>{{ isset($data_file->date_approved) ? date('M d, Y', strtotime($data_file->date_approved) ) : "No Data" }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                {{-- </div> --}}
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
                    
                    <button class="float-right btn btn-shadow btn-danger btn-accept-endorsement-confirmation" id="btn-false" data-complete="false" data-sam_id="{{ $site[0]->sam_id }}" data-site_category="{{ $site[0]->site_category }}" data-activity_id="{{ $site[0]->activity_id }}">Reject Site</button>
                </div>
            </div>
        </div>
        <div class="tab-pane tabs-animation fade" id="tab-content-file" role="tabpanel">
            <img src="/images/construction.gif" width="100%"/>
            <h5>activity_source: File</h5>
            <div class="text-danger">Missing or incorrect component defintion in stage_activities_profiles tables or the source link doesnt have the correct activity_source attribute</div>
        </div>
    </div>
</div>

<script>

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
        // var activity_name = "{{ preg_replace("/[^A-Za-z0-9\-]/", "_", strtolower($site[0]->activity_name)) }}";
        var program_id = "{{ $site[0]->program_id }}";
        var activity_name = "hard_copy_site_management";

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

            data = {
                sam_id : sam_id,
                data_complete : data_complete,
                activity_name : activity_name,
                program_id : program_id,
                site_category : site_category,
                activity_id : activity_id,
                type : type,
                text_area_reason : remarks,
            }
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
        }

        $.ajax({
            url: '/accept-reject-endorsement',
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

