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
                        <th>Lessor</th>
                        {{-- <th>Latitude</th>
                        <th>Longitude</th> --}}
                        <th>Distance</th>
                        <th>Rank</th>
                        <th>SSDS</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="form_data d-none">
            <ul class="tabs-animated-shadow tabs-animated nav mt-2">
                <li class="nav-item">
                    <a role="tab" class="nav-link active" id="tab-c-0" data-toggle="tab" href="#tab-animated-0" aria-selected="true">
                        <span>Ranking</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a role="tab" class="nav-link" id="tab-c-1" data-toggle="tab" href="#tab-animated-1" aria-selected="false">
                        <span>Details</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab-animated-0" role="tabpanel">
                    <form class="ranking_form">
                        <div class="form-group">
                            <input type="hidden" name="hidden_id" id="hidden_id">
                            <label for="rank"></label>
                            <select name="rank" id="rank" class="form-control">
                                <option value="">Please select a rank</option>
                                @for ($i = 1; $i <= $count_ssds; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <small class="rank-errors text-danger"></small>
                        </div>

                        <div class="form-group">
                            <button type="button" class="btn btn-primary btn-sm btn-shadow submit_ranking">Submit Ranking</button>
                        </div>
                    </form>
                </div>
                
                <div class="tab-pane" id="tab-animated-1" role="tabpanel">
                    <div class="row form_div border-bottom pt-3 pb-2">
                        <div class="col-12">
                            @include('layouts.ssds-form')
                        </div>
                    </div>
                </div>
            </div>
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
        ->select('NP_latitude', 'NP_longitude', 'NP_radius')
        ->where('sam_id', $sam_id)
        ->get();
    
@endphp

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


    function load_ssds(id){

        $('.ssds_form')[0].reset();

        $(".set_schedule").attr("data-id", id);
        $(".form_data").removeClass("d-none");
        $(".aepm_table_div").addClass("d-none");

        $(".btn_switch_back_to_actions").addClass("d-none");
        $(".btn_switch_back_to_candidates").removeClass("d-none");
            

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
                        $("#hidden_id").val(resp.message.id);

                    $.each(json, function(index, data) {
                        $("#"+index).val(data);
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
            },
        });
    }        

    $(document).ready(function() {


        $(".btn_switch_back_to_actions").on("click", function(){
            $("#actions_box").addClass('d-none');
            $("#actions_list").removeClass('d-none');
        });  

        var sam_id = "{{ $sam_id }}";
        var status = "jtss_ssds_ranking";
        $('#aepm_table').DataTable({
            processing: true,
            serverSide: true,
            select: true,
            order: [ 1, "asc" ],
            ajax: {
                // url: "/get-site-candidate/" + "{{ $sam_id }}" + "/jtss_ssds_ranking",
                // type: 'GET'
                url: "/get-site-candidate",
                type: 'POST',
                data : {
                    sam_id : sam_id,
                    status : status
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
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
                { data: "lessor" },
                // { data: "address" },
                // { data: "latitude" },
                // { data: "longitude" },
                { data: "distance", className: "text-center" },
                { data: "rank", className: "text-center" },
                { data: "rank", className: "text-right", render: function(row){
                    toggle_button = '<div>' +
                                    '<button class="ml-2 mb-2 mt-2 btn btn-secondary ssds-details">SSDS Details</button>'  +
                                    '</div>';                    
                    return toggle_button;
                }},
                // { data: "rank", className: "text-center", render: function(row){

                //     toggle_button = '<div>' +
                //                     '<select class="ranking_select btn btn-primary ml-2 mb-2 mt-2">' +
                //                         '<option value="0">Set Rank</option>' +
                //                         '<option value="1">Rank 1</option>' +
                //                         '<option value="2">Rank 2</option>' +
                //                     '</select>' +
                //                     '</div>';                    
                //     return toggle_button;
                // }},
                // { data: "rank", className: "text-right", render: function(row){

                //     toggle_button = '<div>' +
                //                     '<button class="ml-2 mb-2 mt-2 btn btn-secondary ssds-details">SSDS Details</button>'  +
                //                     '</div>';                    
                //     return toggle_button;
                // }},
            ],
            "initComplete": function( settings, json){
                initMap(json.data);
            },
            rowCallback: function ( row, data ) {

                    $( ".ranking_select", row).on('change',  function(data) {
                        console.log($(this).val());
                    });
                    

                    $('.ssds-details', row).on( 'click', function(row, xdata){
                        load_ssds(data.id);
                    });
            },


        });

        $(".submit_ranking").on("click", function (e) {
            e.preventDefault();

            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            $(".ranking_form small").text("");

            $.ajax({
                url: '/submit-ranking',
                method: 'POST',
                data: $('.ranking_form, .ssds_form').serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp){
                    if (!resp.error) {
                        $("#aepm_table").DataTable().ajax.reload(function () {
                            Swal.fire(
                                'Success',
                                resp.message,
                                'success'
                            )

                            $(".ranking_form")[0].reset();

                            $(".btn_switch_back_to_candidates").trigger("click");
                            $(".submit_ranking").removeAttr("disabled");
                            $(".submit_ranking").text("Submit SSDS");
                        });
                    } else {
                        if (typeof resp.message === 'object' && resp.message !== null) {
                            $.each(resp.message, function(index, data) {
                                $(".ranking_form ." + index + "-errors").text(data);
                            });
                        } else {
                            Swal.fire(
                                'Error',
                                resp.message,
                                'error'
                            )
                        }

                        $(".submit_ranking").removeAttr("disabled");
                        $(".submit_ranking").text("Submit SSDS");
                    }
                },
                error: function (resp) {
                    
                    Swal.fire(
                        'Error',
                        resp,
                        'error'
                    )

                    $(".submit_ranking").removeAttr("disabled");
                    $(".submit_ranking").text("Submit SSDS");
                }
            });
        });

        $(".btn_switch_back_to_candidates").on("click", function(e){
            e.preventDefault();

            $(".btn_switch_back_to_actions").removeClass("d-none");
            $(".btn_switch_back_to_candidates").addClass("d-none");

            $(".form_data").addClass("d-none");
            $(".aepm_table_div").removeClass("d-none");

        });

        // $("#aepm_table").on("click", "tr", function(e){
        //     e.preventDefault();

        //     $('.ssds_form')[0].reset();

        //     if($(this).hasClass('selected') != true){
        //         $("#aepm_table tbody tr").removeClass('selected');
        //         $(this).addClass('selected');
        //     } else {
        //         $(this).removeClass('selected');
        //     }

        //     var id = $(this).attr('data-id');

        //     if($('#aepm_table tbody tr.selected').length > 0){
        //         $(".set_schedule").attr("data-id", id);
        //         $(".form_data").removeClass("d-none");
        //         $(".aepm_table_div").addClass("d-none");

        //         $(".btn_switch_back_to_actions").addClass("d-none");
        //         $(".btn_switch_back_to_candidates").removeClass("d-none");
                
                
        //     } else {
        //         $(".form_data").addClass("d-none");
        //     }

        //     $(".set_schedule").attr("data-id", id);

        //     $.ajax({
        //         url: "/get-ssds-schedule/" + id,
        //         method: "GET",
        //         success: function (resp) {
        //             if (!resp.error) {
        //                 var json = JSON.parse(resp.message.value);
        //                 if (resp.message != null) {
        //                     $("#jtss_schedule").val(json.jtss_schedule);
        //                 } else {
        //                     $("#jtss_schedule").val("");
        //                 }

        //                 if (resp.is_null == 'yes') {
        //                     $("#id").val(resp.message.id);
        //                 }

        //                 $("#hidden_id").val(resp.message.id);

        //                 $.each(json, function(index, data) {
        //                     $("#"+index).val(data);
        //                 });
        //             } else {
        //                 Swal.fire(
        //                     'Error',
        //                     resp.message,
        //                     'error'
        //                 )
        //             }
        //         },
        //         error: function (resp) {
                    
        //             Swal.fire(
        //                 'Error',
        //                 resp,
        //                 'error'
        //             )
        //         },
        //     });
        // });

        $(".mark_as_complete").on("click", function() {
            $(this).attr("disabled", "disabled");
            $(this).text("Processing...");

            var sam_id = ["{{ $sam_id }}"];
            var sub_activity_id = "{{ $sub_activity_id }}";
            var activity_name = "{{ $sub_activity }}";
            var site_category = ["{{ $site_category }}"];
            var activity_id = ["{{ $activity_id }}"];
            var program_id = "{{ $program_id }}";

            $.ajax({
                url: "/accept-reject-endorsement",
                method: "POST",
                data: {
                    sam_id : sam_id,
                    sub_activity_id : sub_activity_id,
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
