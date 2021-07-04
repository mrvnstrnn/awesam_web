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
<div class="row pt-3 d-none" id="ssds_form">
    <div class="col-md-12">
        <form class="ssds_form">
            <div class="position-relative row form-group">
                <label for="site_name" class="col-sm-4 col-form-label">Location</label>
                <div class="col-sm-8">
                    <input type="text" id="site_name" name="site_name" class="form-control" placeholder="Location">
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
                <label for="latitude" class="col-sm-4 col-form-label">Coordinates</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="latitude" name="latitude" placeholder="Latitude">
                    <small class="text-danger latitude-errors"></small>
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="longitude" name="longitude" placeholder="Longitude">
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
            <input type="hidden" name="sam_id" value="{{ $sam_id }}">
            <input type="hidden" name="sub_activity_id" value="{{ $sub_activity_id }}">
            <input type="hidden" name="sub_activity_name" value="{{ $sub_activity }}">
            <input type="hidden" name="type" value="advanced_site_hunting">
            <div class="position-relative row form-group ">
                <div class="col-sm-12">
                    <button class="btn float-right btn-primary" id="btn_save_ssds" type="button">Save Site</button>
                    <button class="btn float-right btn-ouline-secondary mr-1" id="btn_cancel_ssds" type="button">Cancel</button>
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

    $(document).ready(function () {
        if (! $.fn.DataTable.isDataTable("#dtTable") ){
            $("#dtTable").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/get-my-site/{{ $sub_activity_id }}/{{ $sam_id }}",
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
                    $(row).attr('style', 'cursor: pointer');
                },
                columns: [
                    { data: "sitename" },
                    { data: "lessor" },
                    { data: "address" },
                    { data: "latitude" },
                    { data: "longitude" },
                ],
            });
        } else {
            $("#dtTable").DataTable().ajax.reload();
        }
    })

    if ("{{ \Auth::user()->getUserProfile()->mode }}" == "vendor") {
        Dropzone.autoDiscover = false;
        $(".dropzone_files_activities").dropzone({
            addRemoveLinks: true,
            // maxFiles: 1,    
            paramName: "file",
            url: "/upload-file",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (file, resp) {
                if (!resp.error){
                    var file_name = resp.file;

                    $(".ssds_form").append(
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
    }

    $("#btn_save_ssds").on("click", function() {
        $(this).attr("disabled", "disabled");
        $(this).text("Processing...");

        $("small.text-danger").text("");
        $.ajax({
            url: "/add-ssds",
            method: "POST",
            data: $(".ssds_form").serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp) {
                if (!resp.error){

                    $("#dtTable").DataTable().ajax.reload(function(){
                        Swal.fire(
                            'Success',
                            resp.message,
                            'success'
                        )
                        $(".ssds_form")[0].reset();
                        $("#btn_save_ssds").removeAttr("disabled");
                        $("#btn_save_ssds").text("Save Site");
                        
                        $(".btn_switch_back_to_actions").trigger("click");
                    });

                } else {
                    if (typeof resp.message === 'object' && resp.message !== null) {
                        $.each(resp.message, function(index, data) {
                            $("." + index + "-errors").text(data);
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                    }
                    $("#btn_save_ssds").removeAttr("disabled");
                    $("#btn_save_ssds").text("Save Site");
                }
            },
            error: function (file, resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )
                $("#btn_save_ssds").removeAttr("disabled");
                $("#btn_save_ssds").text("Save Site");
            }
        });
    });

</script>