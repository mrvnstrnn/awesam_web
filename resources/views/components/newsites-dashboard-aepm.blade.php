<div class="row">
    <div class="col-lg-9 col-md-12 col-sm-12">
        <div class="main-card mb-3 card">
            <div class="dropdown-menu-header py-3 bg-warning"   style=" background-image: url('/images/modal-background.jpeg'); background-size:150%;">
                <div class="row px-4">
                    <div class="menu-header-content btn-pane-right">
                        <h6 class="menu-header-title text-dark">
                            <i class="header-icon pe-7s-graph1 pe-lg mr-1"></i>
                            Scheduled JTSS 
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
    <div class="col-lg-3 col-md-12 col-sm-12">
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
        <div class="main-card mb-3 card">
            <div class="dropdown-menu-header py-3 bg-warning"   style=" background-image: url('/images/modal-background.jpeg'); background-size:150%;">
                <div class="row px-4">
                    <div class="menu-header-content btn-pane-right">
                        <h6 class="menu-header-title text-dark">
                            <i class="header-icon pe-7s-graph1 pe-lg mr-1"></i>
                             Completed JTSS
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
        </div>    </div>
</div>
<div class="row">
    <div class="col">
        AEPM
    </div>
</div>


<style type="text/css">
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
    #map {
      height: 660px;
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

    function haversine_distance(mk1, mk2) {
        var R = 3958.8; // Radius of the Earth in miles
        var rlat1 = mk1.position.lat() * (Math.PI/180); // Convert degrees to radians
        var rlat2 = mk2['lat'] * (Math.PI/180); // Convert degrees to radians
        var difflat = rlat2-rlat1; // Radian difference (latitudes)
        var difflon = (mk2['lng']-mk1.position.lng()) * (Math.PI/180); // Radian difference (longitudes)

        var d = 2 * R * Math.asin(Math.sqrt(Math.sin(difflat/2)*Math.sin(difflat/2)+Math.cos(rlat1)*Math.cos(rlat2)*Math.sin(difflon/2)*Math.sin(difflon/2)));
        //   return d * 1609.344;

        return Math.round(d * 1609.344, 2);

    }

    function Go_Add_Site_Details(){
        $("#ssds_form").removeClass('d-none');
        $("#map_message").addClass('d-none');

        $("#collapseOne1").addClass('show');

        $('#viewInfoModal').animate({
            scrollTop: $("#accordion").offset().top - 50
        }, 1000);

        $( "#lessor" ).focus();

    }

    var map;

    function initMap() {

        const nominal_point = { lat: 12.769427314073992, lng: 121.97947377861085};

        const map = new google.maps.Map(document.getElementById("map"), {
            center: nominal_point,
            zoom: 5.9,
            mapTypeId: "roadmap",
        });

        map.setCenter(nominal_point);

        var mk1 = new google.maps.Marker({position: nominal_point, map: map});


        const nominal_point_circle = new google.maps.Circle({
            strokeColor: "#FF0000",
            strokeOpacity: 0.8,
            strokeWeight: 1.5,
            fillColor: "#FF0000",
            fillOpacity: 0.1,
            map,
            center: nominal_point,
            radius: 300,
        });

        let infoWindow = new google.maps.InfoWindow({
        });

        infoWindow.open(map);

        return map;


    }

</script>


@section("js_script")

<script>
    $(document).ready(() => {
        mapx = initMap();
    });
</script>

@endsection