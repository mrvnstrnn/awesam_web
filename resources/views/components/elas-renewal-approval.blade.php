
{{-- <div class="row">
    <div class="col-12 approve_elas_div">
        <button class="btn-sm btn-shadow btn btn-block btn-primary mark_as_complete">Approved eLAS</button>
    </div>
</div> --}}

<div class="row data_form">
    <div class="col-12">
        <div class="form_html"></div>
        <form class="site_data_form">@csrf
            <input type="hidden" name="sam_id" id="sam_id" value="{{ $site[0]->sam_id }}">
            <input type="hidden" name="site_category" id="site_category" value="{{ $site[0]->site_category }}">
            <input type="hidden" name="program_id" id="program_id" value="{{ $site[0]->program_id }}">
            <input type="hidden" name="activity_id" id="activity_id" value="{{ $site[0]->activity_id }}">
        </form>
    </div>
</div>

<div class="row reject_remarks d-none">
    <div class="col-12">
        <p class="message_p">Are you sure you want to reject this eLAS?</p>
        <form class="reject_form">
            <div class="form-group">
                <label for="remarks">Remarks:</label>
                <textarea style="width: 100%;" name="remarks" id="remarks" rows="5" cols="100" class="form-control"></textarea>
                <small class="text-danger remarks-error"></small>
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-sm btn-shadow confirm_reject" data-action="false" type="button">Re-Negotiate eLAS</button>
                
                <button class="btn btn-secondary btn-sm btn-shadow cancel_reject" type="button">Cancel</button>
            </div>
        </form>
    </div>
</div>

{{-- <button class="btn-sm btn-shadow btn btn-block btn-primary mark_as_complete">Approved eLAS</button> --}}

<script src="/js/dropzone/dropzone.js"></script>

<script>
    $(".form_html").on("click", ".save_elas_approval_btn", function(e) {
        e.preventDefault();
        $(".save_elas_approval_btn").attr("disabled", "disabled");
        $(".save_elas_approval_btn").text("Processing...");

        $(".elas_approval_form #action_file").val($(this).attr("data-action"));

        $.ajax({
            url: "/elas-approval-confirm",
            method: "POST",
            data: $(".elas_approval_form, .site_data_form").serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp) {
                if (!resp.error){

                    $("table[data-program_id="+"{{ $site[0]->program_id }}"+"]").DataTable().ajax.reload(function(){
                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )

                        Dropzone.forElement(".dropzone_files_activities").removeAllFiles(true);

                        $(".dropzone_files_activities input[name='file[]']").remove();

                        $(".save_elas_approval_btn").removeAttr("disabled");
                        $(".save_elas_approval_btn").text("Approved eLAS");

                        $("#viewInfoModal").modal("hide");

                    });
                } else {
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $(".elas_approval_form ." + index + "-error").text(data);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }

                    $(".save_elas_approval_btn").removeAttr("disabled");
                    $(".save_elas_approval_btn").text("Approved eLAS");

                }
            },
            error: function (resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )

                $(".save_elas_approval_btn").removeAttr("disabled");
                $(".save_elas_approval_btn").text("Approved eLAS");

            }
        });

    });

    $(".form_html").on("click", ".cancel_elas_approval_btn", function(e) {
        $(".reject_remarks").removeClass("d-none");
        $(".data_form").addClass("d-none");
    });

    $(".reject_form").on("click", ".cancel_reject", function(e) {
        $(".reject_remarks").addClass("d-none");
        $(".data_form").removeClass("d-none");
    });

    
    $(".reject_form").on("click", ".confirm_reject", function(e) {
        e.preventDefault();
        $(".confirm_reject").attr("disabled", "disabled");
        $(".confirm_reject").text("Processing...");

        $(".reject_form #action_file").val($(this).attr("data-action"));

        $.ajax({
            url: "/elas-approval-confirm",
            method: "POST",
            data: $(".reject_form, .site_data_form").serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp) {
                if (!resp.error){

                    $("table[data-program_id="+"{{ $site[0]->program_id }}"+"]").DataTable().ajax.reload(function(){
                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )

                        $(".confirm_reject").removeAttr("disabled");
                        $(".confirm_reject").text("Re-Negotiate eLAS");

                        $("#viewInfoModal").modal("hide");

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

                    $(".confirm_reject").removeAttr("disabled");
                    $(".confirm_reject").text("Re-Negotiate eLAS");

                }
            },
            error: function (resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )

                $(".confirm_reject").removeAttr("disabled");
                $(".confirm_reject").text("Re-Negotiate eLAS");

            }
        });

    });

    $(document).ready(function(){
        $.ajax({
            url: "/get-form/" + "32" + "/" + "eLAS Approval",
            method: "GET",
            success: function (resp) {
                if (!resp.error) {
                    $(".form_html").html(resp.message);

                    var elas_renewal = JSON.parse("{{ json_decode(json_encode(\Auth::user()->get_refx($site[0]->sam_id, 'elas_renewal'))); }}".replace(/&quot;/g,'"'));

                    $(".elas_approval_form").append(
                        '<div class="dropzone dropzone_files_activities mt-0 mb-5">' +
                            '<div class="dz-message">' +
                                '<i class="fa fa-plus fa-3x"></i>' +
                                '<p><small class="sub_activity_name">Drag and Drop files here</small></p>' +
                            '</div>' +
                        '</div>' +
                        '<small class="file-error text-danger"></small>'
                    );

                    $(".elas_approval_form, .reject_form").append(
                        '<input type="hidden" name="action_file" id="action_file">'
                    );

                    $.each(elas_renewal, function(index, data) {
                        $(".elas_approval_form #"+index).val(data);
                    });

                    Dropzone.autoDiscover = false;
                    $(".dropzone_files_activities").dropzone({
                        addRemoveLinks: true,
                        // maxFiles: 1,
                        paramName: "file",
                        url: "/renewal-upload-file",
                        // init: function() {
                        //     this.on("maxfilesexceeded", function(file){
                        //         this.removeFile(file);
                        //     });
                        // },
                        removedfile: function(file) {
                            file.previewElement.remove();
                            $(".elas_approval_form input#"+file.upload.uuid).remove();
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (file, resp) {
                            if (!resp.error){
                                var _this = this;
                                var file = file;
                                var sam_id = "{{ $site[0]->sam_id }}";
                                var sub_activity_name = "{{ $site[0]->activity_name }}";
                                var file_name = resp.file;
                                var site_category = "{{ $site[0]->site_category }}";
                                var activity_id = "{{ $site[0]->activity_id }}";
                                var program_id = "{{ $site[0]->program_id }}";

                                var file_id = file.upload.uuid;

                                $.ajax({
                                    url: "/renewal-upload-my-file",
                                    method: "POST",
                                    data: {
                                        sam_id : sam_id,
                                        file_name : file_name,
                                        sub_activity_name : sub_activity_name,
                                        site_category : site_category,
                                        activity_id : activity_id,
                                        program_id : program_id,
                                    },
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function (resp) {
                                        if (!resp.error){
                                            $(".elas_approval_form").append(
                                                '<input value="'+resp.message+'" name="file[]" id="'+ file_id +'" type="hidden">'
                                            );
                                        } else {
                                            Swal.fire(
                                                'Error',
                                                resp.message,
                                                'error'
                                            )
                                        }
                                    },
                                    error: function (file, response) {
                                        Swal.fire(
                                            'Error',
                                            resp,
                                            'error'
                                        )
                                    }
                                });
                            } else {
                                Swal.fire(
                                    'Error',
                                    resp.message,
                                    'error'
                                )
                            }
                        },
                        error: function (file, resp) {
                            Swal.fire(
                                'Error',
                                resp,
                                'error'
                            )
                        }
                    });
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
            }
        });
    });
</script>