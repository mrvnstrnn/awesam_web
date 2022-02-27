<div class="row p-0">
    <div class="col-12">
        <form class="elas_form row">
            <div class="form-group col-12">
                <label for="elas_approval_date">Approval Date</label>
                <input type="date" name="elas_approval_date" id="elas_approval_date" class="flatpicker form-control" placeholder="eLas Approval Date" style="background-color: white;">
                <small class="elas_approval_date-errors text-danger"></small>
            </div>

            <div class="form-group col-12" id="action_doc_upload">
                <div class="dropzone dropzone_files_activities mt-0">
                    <div class="dz-message">
                        <i class="fa fa-plus fa-3x"></i>
                        <p><small class="sub_activity_name">Drag and Drop files here</small></p>
                    </div>
                </div>
            </div>

            <input type="hidden" name="sam_id" id="sam_id" value="{{ $site[0]->sam_id }}">
            <input type="hidden" name="site_category" id="site_category" value="{{ $site[0]->site_category }}">
            <input type="hidden" name="activity_id" id="activity_id" value="{{ $site[0]->activity_id }}">
            <input type="hidden" name="program_id" id="program_id" value="{{ $site[0]->program_id }}">
            <input type="hidden" name="data_complete" id="data_complete" value="true">
            <input type="hidden" name="activity_name" id="activity_name" value="submit_elas_approval">

            <div class="hidden_fields"></div>
            
            <div class="form-group col-12">
                <button class="btn pt-4btn-lg btn-shadow btn-success submit_elas" type="button">Submit eLAS Approval</button>
            </div>
        </form>
    </div>
</div>

<style type="text/css">

    .modal-dialog{
        -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -o-box-shadow: 0 5px 15px rgba(0,0,0,0);
        box-shadow: 0 5px 15px rgba(0,0,0,0);
    } 
</style>

<script src="/js/dropzone/dropzone.js"></script>

<script>
    $(document).ready(function() {

        $(".flatpicker").flatpickr();

        Dropzone.autoDiscover = false;
        $(".dropzone_files_activities").dropzone({
            addRemoveLinks: true,
            // maxFiles: 1,    
            paramName: "file",
            url: "/upload-file",
            removedfile: function(file) {
                file.previewElement.remove();
                $(".elas_form input#"+file.upload.uuid).remove();
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (file, resp) {
                if (!resp.error){
                    var file_name = resp.file;

                    $(".elas_form .hidden_fields").append(
                        '<input value="'+file_name+'" name="file[]" id="'+file.upload.uuid+'" type="hidden">'
                    );
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

        $(".submit_elas").on("click", function() {
            $(".submit_elas").attr("disabled", "disabled");
            $(".submit_elas").text("Processing...");

            // var activity_name = "submit_elas_approval";
            // var site_category = ["{{ $site[0]->site_category }}"];
            // var activity_id = ["{{ $site[0]->activity_id }}"];
            // var program_id = "{{ $site[0]->program_id }}";

            // var data_complete = "true";
            // var elas_approval_date = $("#elas_approval_date").val();

            $(".elas_form small").text("");

            $.ajax({
                url: "/accept-reject-endorsement",
                method: "POST",
                // data: {
                //     sam_id : sam_id,
                //     activity_name : activity_name,
                //     data_complete : data_complete,
                //     site_category : site_category,
                //     activity_id : activity_id,
                //     program_id : program_id,
                //     elas_approval_date : elas_approval_date,
                // },
                data: $(".elas_form").serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp) {
                    if (!resp.error){
                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )

                        $(".submit_elas").removeAttr("disabled");
                        $(".submit_elas").text("Submit eLAS Approval");

                        $(".elas_form input").remove();

                        $("#viewInfoModal").modal("hide");
                    } else {
                        if (typeof resp.message === 'object' && resp.message !== null) {
                            $.each(resp.message, function(index, data) {
                                $(".elas_form ." + index + "-errors").text(data);
                            });
                        } else {
                            Swal.fire(
                                'Error',
                                resp.message,
                                'error'
                            )
                        }

                        $(".submit_elas").removeAttr("disabled");
                        $(".submit_elas").text("Submit eLAS Approval");
                    }
                },
                error: function (resp) {
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )

                    $(".submit_elas").removeAttr("disabled");
                    $(".submit_elas").text("Submit eLAS Approval");
                }
            });

        });
        
    });
</script>