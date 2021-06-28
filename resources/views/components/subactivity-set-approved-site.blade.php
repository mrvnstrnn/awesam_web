<div class="row border-bottom">
    <div class="col-6">
        <button class="btn_switch_back_to_actions btn btn-shadow btn-secondary btn-sm mb-3">Back to Actions</button>                                            
    </div>
</div>
<div class="row pt-4">
    <div class="col-md-12">
        <H5 id="active_action">Set Approved Site</H5>
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
                <label for="lessor_date" class="col-sm-4 col-form-label">Site Name</label>
                <div class="col-sm-8">
                    <input type="text" id="site_name" name="site_name" class="form-control" placeholder="Site Name">
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="lessor_method" class="col-sm-4 col-form-label">Lessor</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="lessor" name="lessor" placeholder="Lessor">
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="lessor_remarks" class="col-sm-4 col-form-label">Address</label>
                <div class="col-sm-8">
                    <textarea name="address" id="address" class="form-control" placeholder="Address"></textarea>
                    <small class="text-danger lessor_remarks-errors"></small>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="location" class="col-sm-4 col-form-label">Location</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Latitude">
                    <small class="text-danger lessor_remarks-errors"></small>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Longitude">
                    <small class="text-danger lessor_remarks-errors"></small>
                </div>
            </div>
            <div class="divider"></div>
            <div class="position-relative row form-group">
                <label for="lessor_remarks" class="col-sm-12 col-form-label">SSDS Form & Property Documents</label>
                <div class="col-md-4 col-sm-4 view_file col-12 mb-2 dropzone_div_" style="cursor: pointer;" data-value="">
                    <div class="child_div_">
                        <div class="dz-message text-center align-center border" style='padding: 25px 0px 15px 0px;'>
                            <div>
                            <i class="fa fa-file fa-3x text-dark"></i><br>
                            {{-- <small>{{ $item->value }}</small> --}}
                            <p><small>File Name</small></p>
                            </div>
                        </div>
                        <i class="fa fa-check-circle fa-lg text-secondary" style="position: absolute; top:10px; right: 20px"></i><br>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 view_file col-12 mb-2 dropzone_div_" style="cursor: pointer;" data-value="">
                    <div class="child_div_">
                        <div class="dz-message text-center align-center border" style='padding: 25px 0px 15px 0px;'>
                            <div>
                            <i class="fa fa-file fa-3x text-dark"></i><br>
                            {{-- <small>{{ $item->value }}</small> --}}
                            <p><small>File Name</small></p>
                            </div>
                        </div>
                        <i class="fa fa-check-circle fa-lg text-secondary" style="position: absolute; top:10px; right: 20px"></i><br>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 view_file col-12 mb-2 dropzone_div_" style="cursor: pointer;" data-value="">
                    <div class="child_div_">
                        <div class="dz-message text-center align-center border" style='padding: 25px 0px 15px 0px;'>
                            <div>
                            <i class="fa fa-file fa-3x text-dark"></i><br>
                            {{-- <small>{{ $item->value }}</small> --}}
                            <p><small>File Name</small></p>
                            </div>
                        </div>
                        <i class="fa fa-check-circle fa-lg text-secondary" style="position: absolute; top:10px; right: 20px"></i><br>
                    </div>
                </div>
    
            </div>
            <div class="position-relative row form-group ">
                <div class="col-sm-12">
                    <button class="btn float-right btn-primary" id="btn_save_ssds" type="button">Set As Approved Site</button>
                    <button class="btn float-right btn-ouline-secondary  mr-1" id="btn_cancel_ssds" type="button">Cancel</button>
                </div>
            </div>
        </form>

    </div>
</div>

<style>
    #ssds_table tr{
        cursor: pointer;
    }
    #ssds_table tbody tr:hover{
        background-color: gray;
        color: white;
    }
</style>

<script>

$(".btn_switch_back_to_actions").on("click", function(){
    $("#actions_box").addClass('d-none');
    $("#actions_list").removeClass('d-none');
    
    $("#actions_box").html('');

});

$('#dtTable').DataTable();

$('#dtTable').find('tbody', 'tr').on('click', function(){
    $('#ssds_table').addClass('d-none')
    $('#ssds_form').removeClass('d-none')
});

$('#btn_cancel_ssds').on("click", function(){
    $('#ssds_table').removeClass('d-none');
    $('#ssds_form').addClass('d-none');
});



</script>
