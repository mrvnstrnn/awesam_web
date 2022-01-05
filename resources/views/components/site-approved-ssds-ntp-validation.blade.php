@php
    // dd($site);
@endphp

<div class="row p-0">
    <div class="col-12">
        <div class="table-responsive aepm_table_div pt-2">
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
        </div>
        <div class="form_data d-none">
            <div class="row border-bottom">
                <div class="col-12">                                        
                    <button class="btn_switch_back_to_candidates btn btn-shadow btn-secondary btn-sm mb-3">Back to Site Options</button>                                            
                </div>
            </div>
            @include('layouts.ssds-form')
        </div>
    </div>
</div>

<div class="row mt-3 pb-3 pt-3 border-bottom border-top mark_as_complete_div">
    <div class="col-12 text-right">
        <button class="btn btn-lg btn-shadow btn-primary mark_as_complete">Mark as Complete</button>
    </div>
</div>
@php

    $NP = \DB::table('site')
        ->where('sam_id', $site[0]->sam_id)
        ->select('NP_latitude', 'NP_longitude', 'NP_radius')
        ->get();
    
@endphp

{{-- <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css"> --}}
<style>
    .kbw-signature { width: 100%; height: 150px; border: 1px solid black;}
    .sigbox canvas{ width: 100% !important; height: auto;}

</style>  

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

    .modal-dialog{
        -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -o-box-shadow: 0 5px 15px rgba(0,0,0,0);
        box-shadow: 0 5px 15px rgba(0,0,0,0);
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

        function load_ssds(id){
            $(".aepm_table_div").addClass("d-none");
            $(".form_data").removeClass("d-none");
                

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

        $('#aepm_table').DataTable({
            processing: true,
            serverSide: true,
            select: true,
            order: [ 1, "asc" ],
            ajax: {
                url: "/get-site-candidate/" + "{{ $site[0]->sam_id }}" + "/jtss_approved",
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
                { data: "assds", className: "text-right" },
                { data: "", className: "text-right", render: function(row, data){
                    return '<button class="ml-2 mb-2 mt-2 btn btn-primary ssds-details">SSDS Details</button>';

                }},
                
            ],
            rowCallback: function ( row, data ) {
                // Set the checked state of the checkbox in the table
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

            $(".form_data").addClass("d-none");
            $(".aepm_table_div").removeClass("d-none");

        });

        $(".mark_as_complete_div .mark_as_complete").on("click", function() {
            $(".mark_as_complete").attr("disabled", "disabled");
            $(".mark_as_complete").text("Processing...");

            var sam_id = ["{{ $site[0]->sam_id }}"];
            var activity_name = "mark_as_complete";
            var site_category = ["{{ $site[0]->site_category }}"];
            var activity_id = ["{{ $site[0]->activity_id }}"];
            var program_id = "{{ $site[0]->program_id }}";

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

                        $(".mark_as_complete").removeAttr("disabled");
                        $(".mark_as_complete").text("Mark as Complete");

                        $("#viewInfoModal").modal("hide");
                    } else {
                        Swal.fire(
                            'Error',
                            resp.message,
                            'error'
                        )

                        $(".mark_as_complete").removeAttr("disabled");
                        $(".mark_as_complete").text("Mark as Complete");
                    }
                },
                error: function (resp) {
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )

                    $(".mark_as_complete").removeAttr("disabled");
                    $(".mark_as_complete").text("Mark as Complete");
                }
            });

        });


        
    });
</script>
