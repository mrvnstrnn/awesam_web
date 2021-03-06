
<div class="row data_form">
    <div class="col-12">
        <div class="form_html"></div>
        <form class="site_data_form">@csrf
            <input type="hidden" name="sam_id" id="sam_id" value="{{ $site[0]->sam_id }}">
            <input type="hidden" name="site_category" id="site_category" value="{{ $site[0]->site_category }}">
            <input type="hidden" name="program_id" id="program_id" value="{{ $site[0]->program_id }}">
            <input type="hidden" name="activity_id" id="activity_id" value="{{ $site[0]->activity_id }}">
        </form>
        <div class="file_html">
            <div class="row"></div>
        </div>

        <div class="row file_div d-none">
            <div class="col-12 file_viewer">
            </div>

            <button class="btn btn-primary btn-shadow btn-lg bact_to_files m-2">Back to file list</button>
        </div>
    </div>
</div>

<div class="row reject_remarks d-none">
    <div class="col-12">
        <p class="message_p">Are you sure you want to reject this eLAS?</p>
        <form class="reject_form">
            <input type="hidden" name="action_file" id="action_file">
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

<script>
    $(".form_html").on("click", ".save_routing_of_lrn_for_sam_head_signature_btn", function(e) {
        e.preventDefault();
        $(".save_routing_of_lrn_for_sam_head_signature_btn").attr("disabled", "disabled");
        $(".save_routing_of_lrn_for_sam_head_signature_btn").text("Processing...");

        // $(".cancel_elas_approval_btn").attr("disabled", "disabled");
        // $(".cancel_elas_approval_btn").text("Processing...");

        $("#action_file").val($(this).attr("data-action"));

        $.ajax({
            url: "/elas-approval-confirm-sam-head",
            method: "POST",
            data: $(".routing_of_lrn_for_sam_head_signature_form, .site_data_form").serialize(),
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

                        $(".save_routing_of_lrn_for_sam_head_signature_btn").removeAttr("disabled");
                        $(".save_routing_of_lrn_for_sam_head_signature_btn").text("Route eLAS");

                        $("#viewInfoModal").modal("hide");

                    });
                } else {
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $(".routing_of_lrn_for_sam_head_signature_form ." + index + "-error").text(data);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }

                    $(".save_routing_of_lrn_for_sam_head_signature_btn").removeAttr("disabled");
                    $(".save_routing_of_lrn_for_sam_head_signature_btn").text("Route eLAS");
                }
            },
            error: function (resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )

                $(".save_routing_of_lrn_for_sam_head_signature_btn").removeAttr("disabled");
                $(".save_routing_of_lrn_for_sam_head_signature_btn").text("Route eLAS");
            }
        });

    });

    $(".form_html").on("click", ".cancel_routing_of_lrn_for_sam_head_signature_btn", function(e) {
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
            url: "/get-form/" + "833" + "/" + "Routing of LRN for SAM Head Signature",
            method: "GET",
            success: function (resp) {
                if (!resp.error) {
                    $(".form_html").html(resp.message);

                    var elas_renewal = JSON.parse("{{ json_decode(json_encode(\Auth::user()->get_lrn($site[0]->sam_id, 'elas_renewal'))); }}".replace(/&quot;/g,'"'));

                    $.each(elas_renewal, function(index, data) {
                        $(".routing_of_lrn_for_sam_head_signature_form #"+index).val(data);
                    });

                    $(".file_html .row div").remove();
                    $(".routing_of_lrn_for_sam_head_signature_form input#file").remove();

                    for (let i = 0; i < elas_renewal.file.length; i++) {

                        $(".routing_of_lrn_for_sam_head_signature_form").append(
                            '<input type="hidden" name="file[]" id="file" value="'+elas_renewal.file[i]+'">'
                        );

                        var file_ext = elas_renewal.file[i].split('.');

                        if (file_ext == "pdf") {
                            var extension = "fa-file-pdf";
                        } else if (file_ext == "png" || file_ext == "jpeg" || file_ext == "jpg") {
                            var extension = "fa-file-image";
                        } else {
                            var extension = "fa-file";
                        }

                        $(".file_html .row").append(
                            '<div class="col-md-4 col-sm-4 view_file col-12 mb-2 dropzone_div" array-id="'+i+'" style="cursor: pointer;">' +
                                '<div class="child_div">' +
                                    '<div class="dz-message text-center align-center border" style="padding: 25px 0px 15px 0px;">' +
                                        '<div>' +
                                        '<i class="fa ' + extension + ' fa-3x text-dark"></i><br>' +
                                        '<p><small class="file_name'+i+'">' + elas_renewal.file[i] + '</small></p>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>'
                        );
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
            }
        });
    });

    $(".file_html").on("click", ".dropzone_div", function () {
        var array_id = $(this).attr("array-id");
        var file_name = $(".dropzone_div small.file_name"+array_id).text();

        var extensions = ["pdf", "jpg", "png"];

        if( extensions.includes(file_name.split('.').pop()) == true) {     
            htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 400px; height: 100%" src="/ViewerJS/#../files/' + file_name + '" allowfullscreen></iframe>';
        } else {
          htmltoload = '<div class="text-center my-5"><a href="/files/' + file_name + '"><i class="fa fa-fw display-1" aria-hidden="true" title="Copy to use file-excel-o">???</i><H5>Download Document</H5></a><small>No viewer available; download the file to check.</small></div>';
        }
                
        $('.file_viewer').html('');
        $('.file_viewer').html(htmltoload);

        $('.file_div').removeClass('d-none');

        $('.file_html').addClass('d-none');
        $('.site_data_form').addClass('d-none');
        $('.form_html').addClass('d-none');
    });

    $(".file_div").on("click", "button.bact_to_files", function () {
        $('.file_div').addClass('d-none');

        $('.file_html').removeClass('d-none');
        $('.site_data_form').removeClass('d-none');
        $('.form_html').removeClass('d-none');
    });

    
</script>