<div class="row file_preview d-none">
    <div class="col-12 mb-3">
        <button id="btn_back_to_file_list" class="mt-0 btn btn-secondary" type="button">Back to files</button>
        <button id="btn_back_to_file_list" class="float-right mt-0 btn btn-success approve_reject_doc_btn" data-action="approve" type="button">Approve Document</button>
        <button id="btn_back_to_file_list" class="mr-2 float-right mt-0 btn btn-transition btn-outline-danger approve_reject_doc_btn" data-action="reject" type="button">Reject Document</button>
    </div>
    <div class="col-12 file_viewer">
    </div>
    <div class="col-12 file_viewer_list pt-3">
    </div>
</div>
<div class="row file_lists">
    @php
        $datas = \DB::connection('mysql2')->select('call `files_dropzone`("' .  $site[0]->sam_id . '", ' .  $site[0]->program_id . ', "")');
    @endphp

    @forelse ($datas as $data)
        @if (is_null($data->files))
            <div class="col-md-4 col-sm-4 col-12 mb-2 dropzone_div_{{ $data->sub_activity_id }}" style='min-height: 100px;'>
                <div class="dropzone dropzone_files" data-sam_id="{{ $site[0]->sam_id }}" data-sub_activity_id="{{ $data->sub_activity_id }}" data-sub_activity_name="{{ $data->sub_activity_name }}">
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

            @foreach ($uploaded_files as $item)
                @if ($item->status == "denied")
                    <div class="col-md-4 col-sm-4 col-12 mb-2 dropzone_div_{{ $data->sub_activity_id }}" style='min-height: 100px;'>
                        <div class="dropzone dropzone_files" data-sam_id="{{ $site[0]->sam_id }}" data-sub_activity_id="{{ $data->sub_activity_id }}" data-sub_activity_name="{{ $data->sub_activity_name }}">
                            <div class="dz-message">
                                <i class="fa fa-plus fa-3x"></i>
                                <p><small class="sub_activity_name{{ $data->sub_activity_id }}">{{ $data->sub_activity_name }}</small></p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-4 col-sm-4 view_file col-12 mb-2 dropzone_div_{{ $data->sub_activity_id }}" style="cursor: pointer;" data-value="{{ json_encode($uploaded_files) }}" data-sub_activity_name="{{ $data->sub_activity_name }}" data-id="{{ $uploaded_files[0]->id }}" data-status="{{ $uploaded_files[0]->status }}">
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
            @endforeach
        @endif
    @empty
        <div class="col-12 text-center">
            <h3>No files here.</h3>
        </div>
    @endforelse

    <input type="hidden" name="hidden_sam_id" value="{{ $site[0]->sam_id }}">
</div>

<div class="row confirmation_message pt-2 pb-5 d-none">
    <div class="col-12 text-center">
        <div class="swal2-icon swal2-question swal2-animate-question-icon" style="display: flex;"><span class="swal2-icon-text">?</span></div>
        <p>Are you sure you want to <b></b> the document of <span class="sub_activity_name"></span>?</p>

        <textarea placeholder="Please enter your reason..." name="text_area_reason" id="text_area_reason" cols="30" rows="5" class="form-control mb-3"></textarea>
        {{-- <small class="text_area_reason-error text-danger"></small> --}}
        
        <button type="button" class="btn btn-secondary btn-sm cancel_reject_approve">Cancel</button>
        <button type="button" class="btn btn-sm approve_reject_doc_btn_final">Confirm</button>
    </div>
</div>

<script src="/js/dropzone/dropzone.js"></script>

<script>  

    if ("{{ \Auth::user()->getUserProfile()->mode }}" == "vendor") {
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
                if (!resp.error){
                    var sam_id = this.element.attributes[1].value;
                    var sub_activity_id = this.element.attributes[2].value;
                    var sub_activity_name = this.element.attributes[3].value;
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
    }
    
    $(".view_file").on("click", function (){

        $(".approve_reject_doc_btn").attr("data-id", $(this).attr("data-id"));

        $(".approve_reject_doc_btn").attr("data-sub_activity_name", $(this).attr("data-sub_activity_name"))

        if ($(this).attr("data-status") == "pending"){
            $(".approve_reject_doc_btn").removeClass("d-none");
            // $(".approve_reject_doc_btn").removeAttr("disabled");
        } else {
            $(".approve_reject_doc_btn").addClass("d-none");
            // $(".approve_reject_doc_btn").attr("disabled", "disabled");
        }

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

        values.forEach(function(item, index){
            
            htmllist = "<tr>" + 
                            "<td>"  + item.id + "</td>" +
                            "<td>"  + item.value + "</td>" +
                            "<td>"  + item.status + "</td>" +
                            "<td>"  + item.date_created + "</td>" +
                        "</tr>";
        });

        htmllist = "<table class='table-bordered mb-0 table'>" + 
                        "<thead>" +
                            "<tr>" +                           
                                "<th>#</th>"+
                                "<th>file</th>"+
                                "<th>status</th>"+
                                "<th>timestamp</th>"+
                            "</tr>" +                           
                        "</thead>" +
                        "<tbody>" +
                            htmllist + 
                        "</tbody>" +
                    "</table>";

        $('.file_viewer_list').html(htmllist);

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

    $(document).on("click", ".approve_reject_doc_btn", function (){
        $(".confirmation_message").removeClass("d-none");
        $(".file_preview").addClass("d-none");


        $(".confirmation_message b").text($(this).attr("data-action"));
        $(".confirmation_message span.sub_activity_name").text($(this).attr("data-sub_activity_name"));
        $(".approve_reject_doc_btn_final").attr("data-action", $(this).attr("data-action") == "reject" ? "rejected" : "approved");
        $(".approve_reject_doc_btn_final").attr("data-id", $(this).attr("data-id"));

        if ($(this).attr("data-action") == "reject"){
            $(".confirmation_message textarea").removeClass("d-none");
            $(".approve_reject_doc_btn_final").addClass("btn-danger");
            $(".approve_reject_doc_btn_final").removeClass("btn-primary");
        } else {
            $(".confirmation_message textarea").addClass("d-none");
            $(".approve_reject_doc_btn_final").addClass("btn-primary");
            $(".approve_reject_doc_btn_final").removeClass("btn-danger");
        }
    });

    $(document).on("click", ".approve_reject_doc_btn_final", function (){
        var data_action = $(this).attr("data-action");
        var data_id = $(this).attr("data-id");

        var text_area_reason = $("#text_area_reason").val();

        $.ajax({
            url: "/doc-validation-approval",
            method: "POST",
            data: {
                action : data_action,
                id : data_id,
                reason : text_area_reason,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp){
                if (!resp.error){
                    Swal.fire(
                        'Success',
                        resp.message,
                        'success'
                    )
                    $("#text_area_reason").val("");

                    $(".file_lists").removeClass("d-none");
                    $(".confirmation_message").addClass("d-none");
                } else {
                    Swal.fire(
                        'Error',
                        resp.message[0],
                        'error'
                    )

                    // $(".file_lists").removeClass("d-none");
                    // $(".confirmation_message").addClass("d-none");
                }
            },
            error: function (resp){
                Swal.fire(
                    'Error',
                    resp.message,
                    'error'
                )
            },
        });
    });

    $(".cancel_reject_approve").on("click", function  (){
        $(".confirmation_message").addClass("d-none");
        $(".file_preview").removeClass("d-none");
    });

</script>

