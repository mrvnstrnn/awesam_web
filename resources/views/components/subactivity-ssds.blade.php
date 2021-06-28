<div class="row border-bottom">
    <div class="col-6">
        <button class="btn_switch_back_to_actions btn btn-shadow btn-secondary btn-sm mb-3">Back to Actions</button>                                            
    </div>
    <div class="col-6 align-right  text-right">
        <button class="add_site_button btn btn-outline btn-outline-primary btn-sm mb-3">Add Site</button>     
    </div>
</div>
<div class="row pt-4">
    <div class="col-md-12">
        <H5 id="active_action">Add SSDS</H5>
    </div>
</div>
<div class="row pt-3" id="ssds_table">
    <div class="col-md-12">
        <table class="table" id="dtTable">
            <thead>
                <tr>
                    <th>Site Name</th>
                    <th>Lessor</th>
                    <th>Address</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Site Name</td>
                    <td>Lessor</td>
                    <td>Address</td>
                    <td>Latitude</td>
                    <td>Longitude</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row pt-3 d-none"  id="ssds_form">
    <div class="col-md-12">
        <form class="">
            <div class="position-relative row form-group">
                <label for="site_name" class="col-sm-4 col-form-label">Site Name</label>
                <div class="col-sm-8">
                    <input type="text" id="site_name" name="site_name" class="form-control" placeholder="Site Name">
                    <small class="text-danger site_name-errors"></small>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="lessor" class="col-sm-4 col-form-label">Lessor</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="lessor" name="lessor" placeholder="Lessor">
                    <small class="text-danger lessor-errors"></small>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="address" class="col-sm-4 col-form-label">Address</label>
                <div class="col-sm-8">
                    <textarea name="address" id="address" class="form-control" placeholder="Address"></textarea>
                    <small class="text-danger address-errors"></small>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="latitude" class="col-sm-4 col-form-label">Location</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Latitude">
                    <small class="text-danger latitude-errors"></small>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Longitude">
                    <small class="text-danger longitude-errors"></small>
                </div>
            </div>
            <div class="divider"></div>
            <div class="position-relative row form-group">
                <label for="file_documents" class="col-sm-12 col-form-label">SSDS Form & Property Documents</label>
                <div class="dropzone dropzone_files_activities mx-3 mt-0 w-100">
                    <div class="dz-message">
                        <i class="fa fa-plus fa-3x"></i>
                        <p><small class="sub_activity_name">Drag and Drop files here</small></p>
                    </div>
                </div>                                            
            </div>
            <div class="position-relative row form-group ">
                <div class="col-sm-12">
                    <button class="btn float-right btn-primary" id="btn_save_ssds" type="button">Save Site</button>
                    <button class="btn float-right btn-ouline-secondary  mr-1" id="btn_cancel_ssds" type="button">Cancel</button>
                </div>
            </div>
        </form>

    </div>
</div>

<script src="/js/dropzone/dropzone.js"></script>

<script>
    
    $(".btn_switch_back_to_actions").on("click", function(){
        $("#actions_box").addClass('d-none');
        $("#actions_list").removeClass('d-none');
        
        $("#actions_box").html('');

    });

    $('#dtTable').DataTable();

    $('.add_site_button').on("click", function(){
        $(".add_site_button").addClass('d-none');
        $('#ssds_table').addClass('d-none');
        $('#ssds_form').removeClass('d-none');
    });

    $('#btn_cancel_ssds').on("click", function(){

        $(".add_site_button").removeClass('d-none');
        $('#ssds_table').removeClass('d-none');
        $('#ssds_form').addClass('d-none');
    });

    if ("{{ \Auth::user()->getUserProfile()->mode }}" == "vendor") {
            Dropzone.autoDiscover = false;
            $(".dropzone_files_activities").dropzone({
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
                    if (!resp.error){
                        var sam_id = "{{ $sam_id }}";
                        var sub_activity_id = "{{ $sub_activity_id }}";
                        var sub_activity_name = "{{ $sub_activity }}";
                        var file_name = resp.file;

                        // $.ajax({
                        //     url: "/upload-my-file",
                        //     method: "POST",
                        //     data: {
                        //         sam_id : sam_id,
                        //         sub_activity_id : sub_activity_id,
                        //         file_name : file_name,
                        //         sub_activity_name : sub_activity_name
                        //     },
                        //     headers: {
                        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        //     },
                        //     success: function (resp) {
                        //         if (!resp.error){

                        //             $('#table_uploaded_files_'+"{{ $sub_activity_id }}").DataTable().ajax.reload(function(){
                        //                 $(".action_doc_upload").remove();
                        //                 Swal.fire(
                        //                     'Success',
                        //                     resp.message,
                        //                     'success'
                        //                 )
                        //             });
                                    
                        //         } else {
                        //             Swal.fire(
                        //                 'Error',
                        //                 resp.message,
                        //                 'error'
                        //             )
                        //         }
                        //     },
                        //     error: function (file, response) {
                        //         Swal.fire(
                        //             'Error',
                        //             resp,
                        //             'error'
                        //         )
                        //     }
                        // });
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
        }

</script>