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
                    <th>Site Namesd</th>
                    <th>Lessor</th>
                    <th>Address</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Rank</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<div class="row pt-3 d-none"  id="ssds_form">
    <div class="col-md-12">
        <form class="ssds_form">
            <input type="hidden" name="hidden_id" id="hidden_id">
            <div class="position-relative row form-group">
                <label for="site_name" class="col-sm-4 col-form-label">Site Name</label>
                <div class="col-sm-8">
                    <input type="text" id="site_name" name="site_name" class="form-control" placeholder="Site Name" readonly>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="lessor" class="col-sm-4 col-form-label">Lessor</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="lessor" name="lessor" placeholder="Lessor" readonly>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="address" class="col-sm-4 col-form-label">Address</label>
                <div class="col-sm-8">
                    <textarea name="address" id="address" class="form-control" placeholder="Address" readonly></textarea>
                </div>
            </div>
            <div class="position-relative row form-group">
                <label for="latitude" class="col-sm-4 col-form-label">Location</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Latitude" readonly>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Longitude" readonly>
                </div>
            </div>
            <div class="divider"></div>
            <div class="position-relative row form-group file_lists">
                <label for="lessor_remarks" class="col-sm-12 col-form-label">SSDS Form & Property Documents</label>
            </div>
            <div class="position-relative row form-group">
                <div class="col-sm-12">
                    <button class="btn float-right btn-primary" id="btn_approve_ssds" type="button">Set As Approved Site</button>
                    <button class="btn float-right btn-ouline-secondary  mr-1" id="btn_cancel_ssds" type="button">Back to list</button>
                </div>
            </div>
        </form>

        <div class="file_viewer d-none">
            
        </div>
        <button class="btn float-right btn-secondary mr-1 d-none" id="btn_back_ssds" type="button">Back to form</button>

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

// $('#dtTable').DataTable();

$('#dtTable').on('click', 'tr', function(){
    $(".file_lists div").remove();
    var new_json = JSON.parse($(this).attr("data-value").replace(/&quot;/g,'"'));
    
    $("#site_name").val(new_json.site_name);
    $("#lessor").val(new_json.lessor);
    $("#longitude").val(new_json.longitude);
    $("#latitude").val(new_json.latitude);
    $("#address").text(new_json.address);
    $("#hidden_id").val($(this).attr("data-id"));

    for (let i = 0; i < new_json.file.length; i++) {
        $(".file_lists").append(
            '<div class="col-md-4 col-sm-4 view_file col-12 mb-2" data-file_name="'+new_json.file[i]+'" style="cursor: pointer;" data-value="">' +
                '<div class="child_div_">' +
                    '<div class="dz-message text-center align-center border" style="padding: 25px 0px 15px 0px;">' +
                        '<div>' +
                        '<i class="fa fa-file fa-3x text-dark"></i><br>' +
                        '<p><small>'+new_json.file[i]+'</small></p>' +
                        '</div>' +
                    '</div>' +
                    // '<i class="fa fa-check-circle fa-lg text-secondary" style="position: absolute; top:10px; right: 20px"></i><br>' +
                '</div>' +
            '</div>'
        );
    }

    $('#ssds_table').addClass('d-none');
    $('#ssds_form').removeClass('d-none');
});

$('#btn_cancel_ssds').on("click", function(){
    $('#ssds_table').removeClass('d-none');
    $('#ssds_form').addClass('d-none');
});

$('#btn_back_ssds').on("click", function(){
    // $('#ssds_table').removeClass('d-none');
    $('.ssds_form').removeClass('d-none');

    $('.file_viewer').addClass("d-none");
    $('#btn_back_ssds').addClass("d-none");
});


$(document).on("click", ".view_file", function (e){
    e.preventDefault();
    
    $(".ssds_form").addClass("d-none");

    var extensions = ["pdf", "jpg", "png"];

    var values = $(this).attr("data-file_name");

    if( extensions.includes(values.split('.').pop()) == true) {     
        htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 400px; height: 100%" src="/ViewerJS/#../files/' + values + '" allowfullscreen></iframe>';
    } else {
        htmltoload = '<div class="text-center my-5"><a href="/files/' + values + '"><i class="fa fa-fw display-1" aria-hidden="true" title="Copy to use file-excel-o"></i><H5>Download Document</H5></a><small>No viewer available; download the file to check.</small></div>';
    }
            
    $('.file_viewer').html('');
    $('.file_viewer').html(htmltoload);

    $('.file_viewer').removeClass("d-none");
    $('#btn_back_ssds').removeClass("d-none");
});

if (! $.fn.DataTable.isDataTable("#dtTable") ){
    $("#dtTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/get-jtss-site-table/{{ $sam_id }}",
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        },
        dataSrc: function(json){
            return json.data;
        },
        'createdRow': function( row, data, dataIndex ) {
            $(row).attr('data-id', data.id);
            $(row).addClass('rank_site');
            $(row).attr('style', 'cursor: pointer');
        },
        columns: [
            { data: "site_name" },
            { data: "lessor" },
            { data: "address" },
            { data: "latitude" },
            { data: "longitude" },
            { data: "rank" },
        ],
    });
} else {
    $("#dtTable").DataTable().ajax.reload();
}

$("#btn_approve_ssds").on("click", function () {
    
    $(this).attr("disabled", "disabled");
    $(this).text("Processing...");

    var id = $("#hidden_id").val();
    var vendor_id = $("#modal_site_vendor_id").val();
    var program_id = $("#modal_program_id").val();
    var activity_name = $(".ajax_content_box").attr("data-activity");
    // var sam_id = $(".ajax_content_box").attr("data-sam_id");

    var activity_id = "{{ $activity_id }}";
    var sam_id = "{{ $sam_id }}";
    var site_category = "{{ $site_category }}";
    var sub_activity = "{{ $sub_activity }}";

    // 'sub_activity' => $sub_activity,
    // 'sam_id' => $sam_id,
    // 'sub_activity_id' => $sub_activity_id,
    // 'program_id' => $program_id,
    // 'site_category' => $site_category,
    // 'activity_id' => $activity_id,
    // 'check_if_added' => $jtss_add_site,

    $.ajax({
        url: "/set-approve-site",
        method: "POST",
        data: {
            id : id,
            vendor_id : vendor_id,
            program_id : program_id,
            // activity_name : activity_name,
            activity_name : sub_activity,
            sam_id : sam_id,
            activity_id : activity_id,
            site_category : site_category,
        },
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
                    $("#viewInfoModal").modal("hide");
                    $("#btn_approve_ssds").removeAttr("disabled");
                    $("#btn_approve_ssds").text("Set As Approved Site");

                } else {
                    Swal.fire(
                        'Error',
                        resp.message,
                        'error'
                    )
                    $("#btn_approve_ssds").removeAttr("disabled");
                    $("#btn_approve_ssds").text("Set As Approved Site");
                }
            },
            error: function (file, resp) {
                Swal.fire(
                    'Error',
                    resp,
                    'error'
                )
                $("#btn_approve_ssds").removeAttr("disabled");
                $("#btn_approve_ssds").text("Set As Approved Site");
            }
    });
});


</script>
