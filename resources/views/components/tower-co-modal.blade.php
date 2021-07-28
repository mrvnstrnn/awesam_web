<style>
    .dropzone {
        min-height: 20px !important;
        border: 2px dashed #3f6ad8 !important;
        border-radius: 10px;
        padding: unset !important;
    }
</style>
<div id="towerco_details" class="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header "  style=" background-image: url('/images/modal-background.jpeg'); background-size:cover;">
            <h5 class="modal-title text-dark">Coop Details</h5>
            <button type="button" class="close modal_close text-dark" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body pb-0" >
            <div class="card mb-0" style="box-shadow: none;">
                <div class="card-header">
                    <ul class="nav nav-justified">
                        <li class="nav-item">
                            <a data-toggle="tab" href="#tab-towerco-details" class="nav-link active">Details</a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" href="#tab-towerco-actor" class="nav-link">{{ $actor }}</a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" href="#tab-towerco-documents" class="nav-link">Documents</a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" href="#tab-towerco-logs" class="nav-link">Logs</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-towerco-details" role="tabpanel" style="max-height: 400px; overflow-y: auto; overflow-x:hidden;">
                        </div>
                        <div class="tab-pane" id="tab-towerco-actor" role="tabpanel"  style="max-height: 400px; overflow-y: auto; overflow-x:hidden;">
                        </div>
                        <div class="tab-pane" id="tab-towerco-documents" role="tabpanel">
                            <input type="hidden" name="serial_number" id="serial_number">
                            <div>
                                <H5>TSSR @if (\Auth::user()->profile_id == 21)<i class="fa fa-fw fa-md tssr_upload" style="cursor: pointer" aria-hidden="true"></i>@endif</H5>
                                {{-- <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 20%;">Date</th>
                                            <th>File Name</th>
                                            <th style="width: 20%;">Uploaded By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Date</td>
                                            <td>File Name</td>
                                            <td>Uploaded By</td>
                                        </tr>
                                    </tbody>
                                </table> --}}
                                <div class="col-12 file_viewer_tssr">
                                </div>
                                <div class="col-12 file_viewer_tssr_list pt-3">
                                </div>

                                @if (\Auth::user()->profile_id == 21)
                                <div class="col-12 mb-2 dropzone_div_tssr d-none" style='min-height: 100px;'>
                                    <div class="dropzone dropzone_files" data-activity="tssr">
                                        <div class="dz-message">
                                            <i class="fa fa-plus fa-3x"></i>
                                            <p><small>TSSR</small></p>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-secondary btn-sm btn-shadow my-3 back_to_tssr">Back to tssr list</button>
                                </div>
                                @endif
                            </div>
                            <hr>
                            <div>
                                <H5>RTB DOCS @if (\Auth::user()->profile_id == 8)<i class="fa fa-fw fa-md rtb_upload" style="cursor: pointer" aria-hidden="true"></i>@endif</H5>
                                <div class="col-12 file_viewer_rtb">
                                </div>
                                <div class="col-12 file_viewer_rtb_list pt-3">
                                </div>

                                @if (\Auth::user()->profile_id == 8)
                                    <div class="col-12 mb-2 dropzone_div_rtb d-none" style='min-height: 100px;'>
                                        <div class="dropzone dropzone_files" data-activity="rtb">
                                            <div class="dz-message">
                                                <i class="fa fa-plus fa-3x"></i>
                                                <p><small>RTB</small></p>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-secondary btn-sm btn-shadow my-3 back_to_rtb">Back to rtb list</button>
                                    </div>
                                @endif

                                {{-- <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 20%;">Date</th>
                                            <th>File Name</th>
                                            <th style="width: 20%;">Uploaded By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Date</td>
                                            <td>File Name</td>
                                            <td>Uploaded By</td>
                                        </tr>
                                    </tbody>
                                </table> --}}
                            </div>
                        </div>
                        <div class="tab-pane table-responsive" id="tab-towerco-logs" role="tabpanel">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary modal_close"  data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary actor_update">Update</button>
        </div>
        </div>
    </div>
</div>

<script src="/js/dropzone/dropzone.js"></script>

<script>
    $(document).on("click", ".tssr_upload", function(){
        $(".dropzone_div_tssr").removeClass("d-none");
        $(".file_viewer_tssr").addClass("d-none");
        $(".file_viewer_tssr_list").addClass("d-none");
    });

    $(document).on("click", ".rtb_upload", function(){
        $(".dropzone_div_rtb").removeClass("d-none");
        $(".file_viewer_rtb").addClass("d-none");
        $(".file_viewer_rtb_list").addClass("d-none");
    });

    $(document).on("click", ".back_to_tssr", function(){
        $(".dropzone_div_tssr").addClass("d-none");
        $(".file_viewer_tssr").removeClass("d-none");
        $(".file_viewer_tssr_list").removeClass("d-none");
    });

    $(document).on("click", ".back_to_rtb", function(){
        $(".dropzone_div_rtb").addClass("d-none");
        $(".file_viewer_rtb").removeClass("d-none");
        $(".file_viewer_rtb_list").removeClass("d-none");
    });

    
    
    //upload file
    if("{{ \Auth::user()->profile_id == 21 || \Auth::user()->profile_id == 8 }}"){
        Dropzone.autoDiscover = false;
        $(".dropzone_files").dropzone({
            addRemoveLinks: true,
            maxFiles: 1,
            paramName: "file",
            url: "/upload-file",
            init: function() {
                this.on("maxfilesexceeded", function(file){
                    this.removeFile(file);
                });
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (file, resp) {
                this.removeFile(file);
                if (!resp.error){
                    var serial_number = $("input#serial_number").val();
                    var activity_name = this.element.attributes[1].value;;
                    var file_name = resp.file;

                    $.ajax({
                        url: "/upload-my-file-towerco",
                        method: "POST",
                        data: {
                            serial_number : serial_number,
                            activity_name : activity_name,
                            file_name : file_name,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (resp) {
                            if (!resp.error){
                                $("#table_uploaded_"+activity_name+"_files_"+serial_number).DataTable().ajax.reload(function(){
                                    
                                    Swal.fire(
                                        'Success',
                                        resp.message,
                                        'success'
                                    )

                                    $(".back_to_"+activity_name).trigger("click");
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
    }
</script>