<div class="row border-bottom">
    <div class="col-12">
        <button class="btn_switch_back_to_actions btn btn-shadow btn-secondary btn-sm mb-3">Back to Actions</button>                                            
        <button class="btn_switch_back_to_candidates d-none btn btn-shadow btn-secondary btn-sm mb-3">Back to Site Options</button>                                            
    </div>
</div>

{{-- <div class="row pt-4">
    <div class="col-md-12">
        <H5 id="active_action">{{ $sub_activity }}</H5>
    </div>
</div>
 --}}

<div class="row p-0">
    <div class="col-12">
        <div class="table-responsive aepm_table_div pt-4">
            <H3>{{ $sub_activity }}</H3>
            <hr>
            <div id="map"></div>
            <table class="table table-hover table-inverse" id="aepm_table">
                <thead class="thead-inverse">
                    <tr>
                        <th>Rank</th>
                        <th>Lessor</th>
                        <th>Distance</th>
                        <th>Approved SSDS</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>

            <H3 class="mt-5">Survey Representative's Signature</H3>
            @if ($message = Session::get('success'))
            <div class="alert alert-success  alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">×</button>  
                <strong>{{ $message }}</strong>
            </div>
            @endif
            <form class="signature_form">
                {{-- <form method="POST" action="{{ route('signature_pad.store') }}"> --}}
                <input type="hidden" name="sam_id" id="sam_id" value="{{ $sam_id }}">
                <div id="signatures">
                    <div class="row pt-4 pb-3">
                        <div class="col-9"><h5>Site Acquisition</h5><small>Site Acquisition</small></div>
                        <div class="col-3 text-right">
                            <button id="clear4" class="clear btn btn-sm btn-danger">Clear</button>
                        </div>
                    </div>
                    <div id="sig4" class="sigbox" style=""></div>
                    <textarea id="signature4" name="signature4" style="display: none"></textarea>
                    <small class="signature4-errors text-danger"></small>

                    <hr>
                    
                    <div class="row pt-4 pb-3">
                        <div class="col-9"><h5>Regional Performance Management</h5><small>Regional Performance Management</small></div>
                        <div class="col-3 text-right">
                            <button id="clear1" class="clear btn btn-sm btn-danger">Clear</button>
                        </div>
                    </div>
                    <div id="sig1" class="sigbox" style=""></div>
                    <textarea id="signature1" name="signature1" style="display: none"></textarea>
                    <small class="signature1-errors text-danger"></small>
    
                    <hr>

                    <div class="row pt-4 pb-3">
                        <div class="col-9"><h5>Transmission Network Engineering</h5><small>Transmission Network Engineering</small></div>
                        <div class="col-3 text-right">
                            <button id="clear2" class="clear btn btn-sm btn-danger">Clear</button>
                        </div>
                    </div>
                    <div id="sig2" class="sigbox" style=""></div>
                    <textarea id="signature2" name="signature2" style="display: none"></textarea>
                    <small class="signature2-errors text-danger"></small>

                    <hr>

                    <div class="row pt-4 pb-3">
                        <div class="col-9"><H5>Access Facilities Engineering</h5><small>Access Facilities Engineering</small></div>
                        <div class="col-3 text-right">
                            <button id="clear3" class="clear btn btn-sm btn-danger">Clear</button>
                        </div>
                    </div>
                    <div id="sig3" class="sigbox" style=""></div>
                    <textarea id="signature3" name="signature3" style="display: none"></textarea>
                    <small class="signature3-errors text-danger"></small>

                </div>

                <button class="btn btn-sm btn-shadow btn-primary submit_signature" type="button">Submit Signature</button>
            </form>

        </div>
        <div class="form_data d-none">
            @include('layouts.ssds-form')
        </div>
    </div>
</div>

{{-- <div class="row pt-3">
    <div class="col-12 text-right">
        <button class="btn btn-sm btn-shadow  btn-primary mark_as_complete {{ $is_match == 'match' ? "" : "d-none" }}">Mark as Complete</button>
    </div>
</div> --}}


@php

    $NP = \DB::table('site')
        ->where('sam_id', $sam_id)
        ->select('NP_latitude', 'NP_longitude', 'NP_radius')
        ->get();
    
@endphp

{{-- <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css"> --}}
<style>
    .kbw-signature { width: 100%; height: 150px; border: 1px solid black;}
    .sigbox canvas{ width: 100% !important; height: auto;}

</style>  


<script type="text/javascript">

    var sig1 = $('#sig1').signature({syncField: '#signature1', syncFormat: 'PNG'});
    var sig2 = $('#sig2').signature({syncField: '#signature2', syncFormat: 'PNG'});
    var sig3 = $('#sig3').signature({syncField: '#signature3', syncFormat: 'PNG'});
    var sig4 = $('#sig4').signature({syncField: '#signature4', syncFormat: 'PNG'});

    $('#clear1').click(function(e) {
        e.preventDefault();
        sig1.signature('clear');
        $("#signature1").val('');
    });

    $('#clear2').click(function(e) {
        e.preventDefault();
        sig2.signature('clear');
        $("#signature2").val('');
    });

    $('#clear3').click(function(e) {
        e.preventDefault();
        sig3.signature('clear');
        $("#signature3").val('');
    });

    $('#clear4').click(function(e) {
        e.preventDefault();
        sig4.signature('clear');
        $("#signature4").val('');
    });


</script>


{{-- GOOGLE MAPS --}}

<style type="text/css">
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
    #map {
      height: 300px;
    }

    /* Optional: Makes the sample page fill the window. */
    html,
    body {
      height: 100%;
      margin: 0;
      padding: 0;
    }
</style>

<script>

    function initMap(markers) {

        var NP_latitude = {!! json_encode($NP[0]->NP_latitude) !!};
        var NP_longitude = {!! json_encode($NP[0]->NP_longitude) !!};
        var NP_radius = {!! json_encode($NP[0]->NP_radius) !!};

        const nominal_point = { lat: parseFloat(NP_latitude), lng: parseFloat(NP_longitude)};

        const map = new google.maps.Map(document.getElementById("map"), {
            center: nominal_point,
            zoom: 16,
            mapTypeId: "roadmap",
        });

        var mk1 = new google.maps.Marker({position: nominal_point, map: map});

        var pinColor = "ffff00";
        var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
            new google.maps.Size(21, 34),
            new google.maps.Point(0,0),
            new google.maps.Point(10, 34));
        var pinShadow = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_shadow",
            new google.maps.Size(40, 37),
            new google.maps.Point(0, 0),
            new google.maps.Point(12, 35));


        var candidateinfowindow = new google.maps.InfoWindow({});


        $.each(markers, function(k, v){

            latlng = new google.maps.LatLng(v.latitude, v.longitude);

            candidate = new google.maps.Marker({
                position: latlng,
                map: map,
                icon: pinImage,
                shadow: pinShadow

            });


            candidate.addListener("click", () => {
                // Close the current InfoWindow.
                candidateinfowindow.close();

                latlng2 = new google.maps.LatLng(this.latitude, this.longitude);

                // Create a new InfoWindow.
                candidateinfowindow = new google.maps.InfoWindow({
                    position: latlng2
                });

                candidateinfowindow.setContent("<div style='font-size: 20px; font-weight: bold;'>" + this.lessor + "<hr></div>"+
                '<div class="pt-2">Latitude: ' + this.latitude  + '</div>' +
                '<div class="pt-2">Longitude: ' + this.longitude  + '</div>' +
                '<div class="pt-2">Distance: ' + this.distance  + '</div>'
                );

                candidateinfowindow.open(map);

            });
                    



        });

        const nominal_point_circle = new google.maps.Circle({
            strokeColor: "#FF0000",
            strokeOpacity: 0.8,
            strokeWeight: 1.5,
            fillColor: "#FF0000",
            fillOpacity: 0.1,
            map,
            center: nominal_point,
            radius: parseInt(NP_radius),
        });

        let infoWindow = new google.maps.InfoWindow({
        });

        infoWindow.open(map);

    }

</script>

<script>


    $(document).ready(function() {


        $(".btn_switch_back_to_actions").on("click", function(){
            $("#actions_box").addClass('d-none');
            $("#actions_list").removeClass('d-none');
        });

        function load_ssds(id){

            // $('.ssds_form')[0].reset();

            // $(".set_schedule").attr("data-id", id);
            // $(".form_data").removeClass("d-none");
            // $(".aepm_table_div").addClass("d-none");

            $(".btn_switch_back_to_actions").addClass("d-none");
            $(".btn_switch_back_to_candidates").removeClass("d-none");
            $(".form_data").removeClass("d-none");
            $(".aepm_table_div").addClass("d-none");
                

            $(".set_schedule").attr("data-id", id);

            $.ajax({
                url: "/get-ssds-schedule/" + id,
                method: "GET",
                success: function (resp) {
                    if (!resp.error) {
                        var json = JSON.parse(resp.message.value);
                        if (resp.message != null) {
                            $("#jtss_schedule").val(json.jtss_schedule);
                        } else {
                            $("#jtss_schedule").val("");
                        }

                        if (resp.is_null == 'yes') {
                            $("#id").val(resp.message.id);
                        }

                        $.each(json, function(index, data) {
                            $("#"+index).val(data);
                        });

                        $("#hidden_id").val(resp.message.id);

                        $("#region_new").val(resp.location_regions.region_name);
                        $("#province_new").val(resp.location_provinces.province_name);
                        $("#lgu_new").val(resp.location_lgus.lgu_name);
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
                },
            });
        }

        $(".submit_signature").on("click", function (e){
            e.preventDefault();

            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            $(".signature_form small").text("");

            $.ajax({
                url: "/signature-pad/post",
                method: "POST",
                data: $(".signature_form").serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp) {
                    if (!resp.error) {
                            Swal.fire(
                                'Success',
                                resp.message,
                                'success'
                            )

                            $(".signature_form")[0].reset();

                            $('#clear1').trigger("click");
                            $('#clear2').trigger("click");
                            $('#clear3').trigger("click");
                            $('#clear4').trigger("click");
                            $(".submit_signature").removeAttr("disabled");
                            $(".submit_signature").text("Submit Signature");
                    } else {
                        if (typeof resp.message === 'object' && resp.message !== null) {
                            $.each(resp.message, function(index, data) {
                                $(".signature_form ." + index + "-errors").text(data);
                            });
                        } else {
                            Swal.fire(
                                'Error',
                                resp.message,
                                'error'
                            )
                        }

                        $(".submit_signature").removeAttr("disabled");
                        $(".submit_signature").text("Submit Signature");
                    }
                },
                error: function (resp) {
                    
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )

                    $(".submit_signature").removeAttr("disabled");
                    $(".submit_signature").text("Submit Signature");
                }
            });
        });

        function ToggleASSDS(id, status, data){

            let oldJSON = JSON.parse(data.replace(/&quot;/g,'"'));
            let newJSON = { ...oldJSON, hidden_id: id, assds: status}


            $.ajax({
                url: '/submit-assds',
                method: 'POST',                
                data: newJSON,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp){
                    if (!resp.error) {
                        console.log('loaded');
                        $("#aepm_table").DataTable().ajax.reload(function () {
                            Swal.fire(
                                'Success',
                                resp.message,
                                'success'
                            )

                            // $(".assds_form")[0].reset();

                            $(".btn_switch_back_to_candidates").trigger("click");
                            $(".submit_assds").removeAttr("disabled");
                            $(".submit_assds").text("Set as ASSDS");
                        });
                    } else {
                        if (typeof resp.message === 'object' && resp.message !== null) {
                            $.each(resp.message, function(index, data) {
                                $(".assds_form ." + index + "-errors").text(data);
                            });
                        } else {
                            Swal.fire(
                                'Error',
                                resp.message,
                                'error'
                            )
                        }

                        $(".submit_assds").removeAttr("disabled");
                        $(".submit_assds").text("Set as ASSDS");
                    }
                },
                error: function (resp) {
                    
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )

                    $(".submit_assds").removeAttr("disabled");
                    $(".submit_assds").text("Set as ASSDS");
                }
            });

        }

        $('#aepm_table').DataTable({
            processing: true,
            serverSide: true,
            select: true,
            order: [ 1, "asc" ],
            ajax: {
                url: "/get-site-candidate/" + "{{ $sam_id }}" + "/jtss_schedule_site_approved",
                type: 'GET'
            },
            dataSrc: function(json){
                return json.data;
            },
            'createdRow': function( row, data, dataIndex ) {
                // $(row).attr('data-id', data.id);
                $(row).attr('data-id', JSON.parse(data.value.replace(/&quot;/g,'"')).id );
                $(row).addClass('add_schedule');
                $(row).attr('style', 'cursor: pointer;');
            },
            columns: [
                { data: "rank" },
                { data: "lessor" },
                { data: "distance", className: "text-center" },
                { data: "assds", className: "text-right", render: function(row, data){

                    var assds = row.replace(/<\/?[^>]+>/gi, '');
                    if(assds=="yes"){
                        toggle_button = '<div class="toggle btn btn-success" data-toggle="toggle" role="button" ' +
                                            'style="width: 100px; height: 23px;"><input type="checkbox" data-toggle="toggle" data-onstyle="success">' +
                                            '<div class="toggle-group">' +
                                                '<label for="" class="btn btn-success toggle-on">ASSDS</label>' +
                                                '<label for="" class="btn btn-light toggle-off">No</label>' +
                                                '<span class="toggle-handle btn btn-light"></span><' +
                                            '/div>' + 
                                        '</div>';

                    } else {
                        toggle_button = '<div class="toggle btn btn-light off" data-toggle="toggle" role="button" ' +
                                            'style="width: 100px; height: 23px;"><input type="checkbox" data-toggle="toggle" data-onstyle="success">' +
                                            '<div class="toggle-group">' +
                                                '<label for="" class="btn btn-success toggle-on">ASSDS</label>' +
                                                '<label for="" class="btn btn-light toggle-off">No</label>' +
                                                '<span class="toggle-handle btn btn-light"></span><' +
                                            '/div>' + 
                                        '</div>';
                    }
                    action_button = '<div>' +
                                        toggle_button +
                                    '</div>';           

                    return action_button;
                }},

                { data: "", className: "text-right", render: function(row, data){
                    return '<button class="ml-2 mb-2 mt-2 btn btn-primary ssds-details">SSDS Details</button>';

                }},
                
            ],
            rowCallback: function ( row, data ) {
                // Set the checked state of the checkbox in the table

                    var value = JSON.parse(data.value.replace(/&quot;/g,'"'));

                    var xdata = data;
                    // console.log(value.assds);

                    $('.toggle', row).on( 'click', function(row, data){

                        if(value.assds == "yes"){

                            $(this).addClass('off');
                            $(this).addClass('btn-light');
                            $(this).removeClass('btn-success');
                            $(this).data('NO');

                            ToggleASSDS(xdata.id, "no", xdata.value);

                        } else {
                            $(this).addClass('btn-success');
                            $(this).removeClass('btn-light');
                            $(this).removeClass('off');
                            $(this).data('YES');

                            ToggleASSDS(xdata.id, "yes", xdata.value);

                        }
                        // if($(this).hasClass('btn-success')){ 
                            

                        // } else {
                        // }
                    });


                    $('.submit_assds_yes',row).on('click', function(row, data){  

                        if($(this).attr("data-status")=="yes"){
                            ToggleASSDS(xdata.id, "no", xdata.value);
                            $(this).attr("data-status", "no");
                        } else {
                            ToggleASSDS(xdata.id, "yes", xdata.value);
                            $(this).attr("data-status", "yes");
                        }
                    });

                    $('.ssds-details', row).on( 'click', function(row, xdata){
                        load_ssds(JSON.parse(data.value.replace(/&quot;/g,'"')).id);
                    });
            },


            "initComplete": function( settings, json){
                initMap(json.data);
            }

        });

        $(".btn_switch_back_to_candidates").on("click", function(e){
            e.preventDefault();

            $(".btn_switch_back_to_actions").removeClass("d-none");
            $(".btn_switch_back_to_candidates").addClass("d-none");

            $(".form_data").addClass("d-none");
            $(".aepm_table_div").removeClass("d-none");

        });


        
    });
</script>
