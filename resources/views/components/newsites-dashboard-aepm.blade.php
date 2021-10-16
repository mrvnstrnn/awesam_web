<div class="row">
    <div class="col-lg-3 col-md-12 col-sm-12">
        <div class="main-card mb-3 card">
            <div class="dropdown-menu-header py-3 bg-warning"   style=" background-image: url('/images/modal-background.jpeg'); background-size:150%;">
                <div class="row px-4">
                    <div class="menu-header-content btn-pane-right">
                        <h6 class="menu-header-title text-dark">
                            <i class="header-icon pe-7s-graph1 pe-lg mr-1"></i>
                            JTSS Requests
                        </h6>
                    </div>
                    <div class="btn-actions-pane-right actions-icon-btn">
                    </div>
                </div>
            </div>
            <div class="card-body pt-1 pb-1">
                <div class="row pt-3 pb-3 border-bottom request_region region_box" data-region="NCR">
                    <div class="col-6">
                        <h6>NCR</h6>
                    </div>
                    <div class="col-6 text-right">
                        <h6 id="request_NCR">0</h6>
                    </div>
                </div>
                <div class="row pb-3 pt-3 border-bottom request_region region_box" data-region="NLZ">
                    <div class="col-6">
                        <h6>NLZ</h6>
                    </div>
                    <div class="col-6 text-right">
                        <h6 id="request_NLZ">0</h6>
                    </div>
                </div>
                <div class="row pb-3 pt-3 border-bottom request_region region_box" data-region="SLZ">
                    <div class="col-6">
                        <h6>SLZ</h6>
                    </div>
                    <div class="col-6 text-right">
                        <h6 id="request_SLZ">0</h6>
                    </div>
                </div>
                <div class="row pb-3 pt-3 border-bottom request_region region_box" data-region="VIS">
                    <div class="col-6">
                        <h6>VIS</h6>
                    </div>
                    <div class="col-6 text-right">
                        <h6 id="request_VIS">0</h6>
                    </div>
                </div>
                <div class="row pb-3 pt-3 request_region region_box" data-region="MIN">
                    <div class="col-6">
                        <h6>MIN</h6>
                    </div>
                    <div class="col-6 text-right">
                        <h6 id="request_MIN">0</h6>
                    </div>
                </div>
                <div class="row pb-2 pt-0 request_region reset_map" data-region="">
                    <div class="col-12 text-center">
                        Reset Map View
                    </div>
                </div>
            </div>
        </div>
        <div class="main-card mb-3 card">
            <div class="dropdown-menu-header py-3 bg-warning"   style=" background-image: url('/images/modal-background.jpeg'); background-size:150%;">
                <div class="row px-4">
                    <div class="menu-header-content btn-pane-right">
                        <h6 class="menu-header-title text-dark">
                            <i class="header-icon pe-7s-graph1 pe-lg mr-1"></i>
                             Upcoming JTSS
                        </h6>
                    </div>
                    <div class="btn-actions-pane-right actions-icon-btn">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h6>NCR</h6>
                    </div>
                    <div class="col-6 text-right">
                        <h6>0</h6>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="row">
                    <div class="col-6">
                        <h6>NLZ</h6>
                    </div>
                    <div class="col-6 text-right">
                        <h6>0</h6>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="row">
                    <div class="col-6">
                        <h6>SLZ</h6>
                    </div>
                    <div class="col-6 text-right">
                        <h6>0</h6>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="row">
                    <div class="col-6">
                        <h6>VIS</h6>
                    </div>
                    <div class="col-6 text-right">
                        <h6>0</h6>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="row">
                    <div class="col-6">
                        <h6>MIN</h6>
                    </div>
                    <div class="col-6 text-right">
                        <h6>0</h6>
                    </div>
                </div>
            </div>
        </div>    
    </div>
    <div class="col-lg-9 col-md-12 col-sm-12">
        <div class="main-card mb-3 card">
            <div class="dropdown-menu-header py-3 bg-warning"   style=" background-image: url('/images/modal-background.jpeg'); background-size:150%;">
                <div class="row px-4">
                    <div class="menu-header-content btn-pane-right">
                        <h6 class="menu-header-title text-dark">
                            <i class="header-icon pe-7s-graph1 pe-lg mr-1"></i>
                            JTSS Schedule Requests
                        </h6>
                    </div>
                    <div class="btn-actions-pane-right actions-icon-btn">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="map"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col pt-3 pb-3">
        AEPM
    </div>
    @php
        $sites = \DB::connection('mysql2')
                            ->table("view_newsites_jtss_schedule_requests")
                            ->leftjoin("view_newsites_jtss_schedule_requests_candidate_list", "view_newsites_jtss_schedule_requests_candidate_list.sam_id", "view_newsites_jtss_schedule_requests.sam_id")
                            ->select("view_newsites_jtss_schedule_requests.*", "view_newsites_jtss_schedule_requests_candidate_list.candidate_list")
                            ->get();
    @endphp

    <input type="hidden" id="markers" value="{{ $sites->toJson() }}" />
</div>


<style type="text/css">
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
    #map {
      height: 690px;
    }

    /* Optional: Makes the sample page fill the window. */
    html,
    body {
      height: 100%;
      margin: 0;
      padding: 0;
    }

    .region_box {
        cursor: pointer;
    }

    .reset_map {
        cursor: pointer;
    }

    .reset_map:hover {
        font-weight: bolder;
    }

    .region_box:hover {
        background-color:lightgoldenrodyellow;
    }

</style>


<script>

    function initMap() {

        const nominal_point = { lat: 12.769427314073992, lng: 121.97947377861085};

        const map = new google.maps.Map(document.getElementById("map"), {
            center: nominal_point,
            zoom: 7,
            mapTypeId: "roadmap",
        });

        return map;
    }

</script>


@section("js_script")

<script>
    $(document).ready(() => {

        map = initMap();

        markers = JSON.parse($('#markers').val());

        console.log(markers);

        const labels = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

        var request_NCR_total = 0;
        var request_NLZ_total = 0;
        var request_SLZ_total = 0;
        var request_VIS_total = 0;
        var request_MIN_total = 0;

        var infowindow = new google.maps.InfoWindow();
        var bounds = new google.maps.LatLngBounds();

        var boundsNCR = new google.maps.LatLngBounds();
        var boundsNLZ = new google.maps.LatLngBounds();
        var boundsSLZ = new google.maps.LatLngBounds();
        var boundsVIS = new google.maps.LatLngBounds();
        var boundsMIN = new google.maps.LatLngBounds();

        $.each(markers, function (key, marker) {

            nominal_point =  { lat: parseFloat(marker.NP_latitude), lng: parseFloat(marker.NP_longitude)};


            var marker = new google.maps.Marker({
                position: nominal_point, 
                label: labels[key++ % labels.length],
                map: map
            });

            var nominal_point_circle = new google.maps.Circle({
                strokeColor: "#FF0000",
                strokeOpacity: 0.8,
                strokeWeight: 1.5,
                fillColor: "#FF0000",
                fillOpacity: 0.1,
                map,
                center: nominal_point,
                radius: 300,
            });


            if(markers[key-1].sam_region_name == "NCR"){
                request_NCR_total = request_NCR_total + 1;
                boundsNCR.extend(marker.position);
            }
            else if(markers[key-1].sam_region_name == "NLZ"){
                request_NLZ_total = request_NLZ_total + 1;
                boundsNLZ.extend(marker.position);
            }
            else if(markers[key-1].sam_region_name == "SLZ"){
                request_SLZ_total = request_SLZ_total + 1;
                boundsSLZ.extend(marker.position);
            }
            else if(markers[key-1].sam_region_name == "VIS"){
                request_VIS_total = request_VIS_total + 1;
                boundsVIS.extend(marker.position);
            }
            else if(markers[key-1].sam_region_name == "MIN"){
                request_MIN_total = request_MIN_total + 1;
                boundsMIN.extend(marker.position);
            }


            google.maps.event.addListener(marker, 'click', (function(marker) {
                return function() {

                    infowindow.close();

                    infowindow.setContent(
                        "<div class='row' style='margin:0;'>" + 
                            "<div class='col-12'>" + 
                                "<H5>" + markers[key-1].site_name + "</h5>" +
                                "<table class='table table-bordered'>" +
                                    "<tr>" +
                                        "<td>Vendor</td>" +
                                        "<td>" + markers[key-1].vendor_acronym + "</td>" +
                                    "</tr>" +
                                    "<tr>" +
                                        "<td>Region</td>" +
                                        "<td>" + markers[key-1].sam_region_name + "</td>" +
                                    "</tr>" +
                                    "<tr>" +
                                        "<td>Province</td>" +
                                        "<td>" + markers[key-1].province_name + "</td>" +
                                    "</tr>" +
                                    "<tr>" +
                                        "<td>City / Municipality</td>" +
                                        "<td>" + markers[key-1].lgu_name + "</td>" +
                                    "</tr>" +
                                    "<tr>" +
                                        "<td>Candidates</td>" +
                                        "<td>" + markers[key-1].candidates + "</td>" +
                                    "</tr>" +
                                    "<tr>" +
                                        "<td>NP Latitude</td>" +
                                        "<td>" + markers[key-1].NP_latitude + "</td>" +
                                    "</tr>" +
                                    "<tr>" +
                                        "<td>NP Longitude</td>" +
                                        "<td>" + markers[key-1].NP_longitude + "</td>" +
                                    "</tr>" +
                                "</table>" +
                            "</div>" +
                        "</div>"
                    );

                    infowindow.open(map, marker);
                }
            })(marker, key));


            bounds.extend(marker.position);


        });

        google.maps.event.addListener(map, 'zoom_changed', function() {
                zoomChangeBoundsListener = 
                    google.maps.event.addListener(map, 'bounds_changed', function(event) {
                        if (this.getZoom() > 15 && this.initialZoom == true) {
                            // Change max/min zoom here
                            this.setZoom(17);
                            this.initialZoom = false;
                        }
                    // google.maps.event.removeListener(zoomChangeBoundsListener);
                });
        });

        map.initialZoom = true;
        map.fitBounds(bounds);

        $("#request_NCR").text(request_NCR_total);
        $("#request_NLZ").text(request_NLZ_total);
        $("#request_SLZ").text(request_SLZ_total);
        $("#request_VIS").text(request_VIS_total);
        $("#request_MIN").text(request_MIN_total);

        $(".request_region").on("click", function(){

            infowindow.close();

            if($(this).attr("data-region")=="NCR" && $('#request_NCR').text() != '0'){
                map.initialZoom = true;
                map.fitBounds(boundsNCR);                
            }
            else if($(this).attr("data-region")=="NLZ" && $('#request_NLZ').text() != '0'){
                map.initialZoom = true;
                map.fitBounds(boundsNLZ);                
            }
            else if($(this).attr("data-region")=="SLZ" && $('#request_SLZ').text() != '0'){
                map.initialZoom = true;
                map.fitBounds(boundsSLZ);                
            }
            else if($(this).attr("data-region")=="VIS" && $('#request_VIS').text() != '0'){
                map.initialZoom = true;
                map.fitBounds(boundsVIS);                
            }
            else if($(this).attr("data-region")=="MIN" && $('#request_MIN').text() != '0'){
                map.initialZoom = true;
                map.fitBounds(boundsMIN);                
            } 
            else {
                map.initialZoom = true;
                map.fitBounds(bounds);                
            }


        });


    });




</script>

@endsection