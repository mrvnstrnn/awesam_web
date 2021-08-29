<style>
    .modal-dialog{
        -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -o-box-shadow: 0 5px 15px rgba(0,0,0,0);
        box-shadow: 0 5px 15px rgba(0,0,0,0);
    }   
</style>

<div class="modal fade" id="viewInfoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true"  data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" style="background-color: transparent; border: 0">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="main-card mb-3 card ">
                        <div class="dropdown-menu-header">
                            <div class="dropdown-menu-header-inner bg-dark">
                                <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                                <div class="menu-header-content btn-pane-right">
                                        <h5 class="menu-header-title">
                                            {{ $activity }}
                                        </h5>
                                </div>
                            </div>
                        </div> 

                        <div class="card-body">
                            <div class="row p-3 complete_button_area {{ count($jtss_sites) == count($jtss_sites_json) ? '' : 'd-none' }}">
                                <div class="col-12">
                                    <button class="float-right btn-sm btn-shadow btn btn-primary complete_button_act">MARK AS COMPLETED</button>
                                </div>
                            </div>
                            <div class="row p-3" id="jtss-site-table-parent">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table" id="jtss-site-table">
                                            <thead>
                                                <tr>
                                                    <th>Site Name</th>
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
                            </div>
                            <div class="row p-3 d-none ssds_view_parent">
                                <div class="col-md-12">
                                    <form class="ssds_form_view">
                                        <input type="hidden" name="hidden_id" id="hidden_id">
                                        <input type="hidden" name="hidden_sam_id" id="hidden_sam_id">
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
                                        <div class="position-relative row form-group">
                                            <label for="rank_number" class="col-sm-4 col-form-label">Rank</label>
                                            <div class="col-8">
                                                <input type="number" class="form-control" id="rank_number" name="rank_number" placeholder="Rank">
                                                <small class="text-danger rank_number-error"></small>
                                            </div>
                                        </div>
                                        <div class="divider"></div>
                                        <div class="position-relative row form-group">
                                            <label for="lessor_remarks" class="col-sm-12 col-form-label">SSDS Form & Property Documents</label>
                                        </div>
                                        <div class="row file_lists"></div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="file_viewer d-none"></div>
                                                <button class="btn float-right btn-secondary mr-1 d-none" id="btn_back_ssds" type="button">Back to form</button>
                                            </div>
                                        </div>

                                        <div class="position-relative row form-group mt-3">
                                            <div class="col-sm-12">
                                                <button class="btn float-right btn-primary" id="btn_set_rank" type="button">Set Rank</button>
                                                <button class="btn float-right btn-ouline-secondary mr-1" id="btn_cancel_set_rank" type="button">Back to list</button>
                                            </div>
                                        </div>
                                    </form>
                            
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        if (! $.fn.DataTable.isDataTable("#jtss-site-table") ){
            $("#jtss-site-table").DataTable({
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
            $("#jtss-site-table").DataTable().ajax.reload();
        }

        $("#btn_cancel_set_rank").on("click", function (e) {
            $(".ssds_view_parent").addClass("d-none");
            $("#jtss-site-table-parent").removeClass("d-none");
        });

        $(document).on("click", ".rank_site", function (e) {
            e.preventDefault();

            var id = $(this).attr("data-id");

            $.ajax({
                url: "/view-jtss-site/" + id,
                type: "GET",
                success: function (resp) {
                    if (!resp.error) {
                        $(".ssds_view_parent").removeClass("d-none");
                        $("#jtss-site-table-parent").addClass("d-none");

                        $(".file_lists .view_file").remove();

                        $("#site_name").val(resp.message.site_name);
                        $("#lessor").val(resp.message.lessor);
                        $("#address").val(resp.message.address);
                        $("#latitude").val(resp.message.latitude);
                        $("#longitude").val(resp.message.longitude);
                        $("#hidden_id").val(resp.id);
                        $("#hidden_sam_id").val(resp.sam_id);

                        for (let i = 0; i < resp.message.file.length; i++) {
                            $(".file_lists").append(
                                "<div class='col-md-4 col-sm-4 view_file col-12 mb-2' style='cursor: pointer;' data-value='"+ resp.message.file[i] +"'>" +
                                    "<div class='dz-message text-center align-center border' style='padding: 25px 0px 15px 0px;'>" +
                                        "<i class='fa fa-file-pdf fa-3x text-dark'></i><br>" +
                                        "<p><small>" + resp.message.file[i] + "</small></p>" +
                                    "</div>" +
                                "</div>"
                            );
                        }

                        // Swal.fire(
                        //     'Success',
                        //     resp.message,
                        //     'success'
                        // )
                        // $(".rank_site").removeAttr("disabled");
                        // $(".rank_site").text("Set Rank");
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                        // $(".rank_site").removeAttr("disabled");
                        // $(".rank_site").text("Set Rank");
                    }
                },
                error: function (resp) {
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )
                    // $(".rank_site").removeAttr("disabled");
                    // $(".rank_site").text("Set Rank");
                }
            });
        });

        $("#btn_set_rank").click(function (e) {
            e.preventDefault();

            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            var id = $("#hidden_id").val();
            var rank_number = $("#rank_number").val();
            var sam_id = $("#hidden_sam_id").val();

            $.ajax({
                url: "/set-rank-site",
                method: "POST",
                data: {
                    id : id,
                    rank_number : rank_number,
                    sam_id : sam_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp){
                    if (!resp.error) {
                        $("#jtss-site-table").DataTable().ajax.reload(function () {
                            Swal.fire(
                                'Success',
                                resp.message,
                                'success'
                            )

                            $("#btn_cancel_set_rank").trigger("click");
                            $("#btn_set_rank").removeAttr("disabled");
                            $("#btn_set_rank").text("Set Rank");

                            $("#rank_number").val("");

                            if (resp.done) {
                                $(".complete_button_area").removeClass("d-none");
                            }
                        });
                    } else {
                        if (typeof resp.message === 'object' && resp.message !== null) {
                            $.each(resp.message, function(index, data) {
                                $("." + index + "-error").text(data);
                            });
                        } else {
                            Swal.fire(
                                'Error',
                                resp.message,
                                'error'
                            )
                        }
                        
                        $("#btn_set_rank").removeAttr("disabled");
                        $("#btn_set_rank").text("Set Rank");
                    }
                },
                error: function (resp) {
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )
                    $("#btn_set_rank").removeAttr("disabled");
                    $("#btn_set_rank").text("Set Rank");
                }
            });
        });

        $(".complete_button_act").on("click", function() {
            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            var sam_id = ["{{ $sam_id }}"];
            var activity_name = "{{ $activity }}";
            var site_category = ["{{ $site_category }}"];
            var activity_id = ["{{ $activity_id }}"];
            var program_id = "{{ $program_id }}";

            $.ajax({
                url: "/accept-reject-endorsement",
                method: "POST",
                data: {
                    sam_id : sam_id,
                    activity_name : activity_name,
                    site_category : site_category,
                    activity_id : activity_id,
                    program_id : program_id,
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
                        $(".complete_button_act").removeAttr("disabled");
                        $(".complete_button_act").text("MARK AS COMPLETE");

                        $("#viewInfoModal").modal("hide");
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )
                        $(".complete_button_act").removeAttr("disabled");
                        $(".complete_button_act").text("MARK AS COMPLETE");
                    }
                },
                error: function (resp) {
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )
                    $(".complete_button_act").removeAttr("disabled");
                    $(".complete_button_act").text("MARK AS COMPLETE");
                }
            });

        });

        $(document).on("click", ".view_file", function (e){
            e.preventDefault();

            var extensions = ["pdf", "jpg", "png"];

            var values =  $(this).attr('data-value');

            if( extensions.includes(values.split('.').pop()) == true) {     
                htmltoload = '<iframe class="embed-responsive-item" style="width:100%; min-height: 400px; height: 100%" src="/ViewerJS/#../files/' + values + '" allowfullscreen></iframe>';
            } else {
            htmltoload = '<div class="text-center my-5"><a target="_blank" href="/files/' + values + '"><i class="fa fa-fw display-1" aria-hidden="true" title="Copy to use file-excel-o"></i><H5>Download Document</H5></a><small>No viewer available; download the file to check.</small></div>';
            }
                    
            $('.file_viewer').html('');
            $('.file_viewer').html(htmltoload);

            $(".file_viewer").removeClass("d-none");
            $(".file_lists").addClass("d-none");
            $("#btn_back_ssds").removeClass("d-none");
        });

        $(document).on("click", "#btn_back_ssds", function (e){
            e.preventDefault();
            
            $(".file_viewer").addClass("d-none");
            $("#btn_back_ssds").addClass("d-none");
            $(".file_lists").removeClass("d-none");
        });
        
        
    });
</script>