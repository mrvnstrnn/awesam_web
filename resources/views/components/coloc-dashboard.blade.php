{{-- <div class="row">
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
</div> --}}
{{-- <div class="row">
    @php
        $sites = \DB::connection('mysql2')
                            ->table("view_newsites_jtss_schedule_requests")
                            ->leftjoin("view_newsites_jtss_schedule_requests_candidate_list", "view_newsites_jtss_schedule_requests_candidate_list.sam_id", "view_newsites_jtss_schedule_requests.sam_id")
                            ->select("view_newsites_jtss_schedule_requests.*", "view_newsites_jtss_schedule_requests_candidate_list.candidate_list")
                            ->get();
    @endphp

    <input type="hidden" id="markers" value="{{ $sites->toJson() }}" />
</div> --}}


<style type="text/css">
    .milestone_sites {
        cursor: pointer;
    }

</style>


<style>
    .milestone-submilestones {
        cursor: pointer;
    }

    .milestone-submilestones:hover .milestone-bg{
        opacity: 0.5  !important;
        z-index: 1 !important;
    }

    .milestone-submilestones:hover .widget-title {
        opacity: 1  !important;
        color: black !important;
        text-shadow: 2px 2px white !important;
        z-index: 100 !important;
    }

    .milestone-submilestones:hover .widget-numbers{
        opacity: 1  !important;
        color: black !important;
        text-shadow: 2px 2px white !important;
        z-index: 100 !important;
    }
    
    .milestone-sites {
        cursor: pointer;
    }

    .milestone-sites:hover {
        background-color:black !important;
        color: white !important;
    }

    .milestone-sites:hover span{
        background-color:black !important;
        color: white !important;
    }

</style>


<div class="mb-3 card">
    <div class="tabs-lg-alternate card-header">
        <ul class="nav nav-justified">
            <li class="nav-item">
                <a data-toggle="tab" href="#tab-eg9-0" class="nav-link active">
                    <div class="widget-number">Milestones</div>
                </a>
            </li>
            <li class="nav-item">
                <a data-toggle="tab" href="#tab-eg9-1" class="nav-link">
                    <div class="widget-number">Productivity</div>
                </a>
            </li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane active" id="tab-eg9-0" role="tabpanel">
            <div class="card-body">
                <div class="row">
                    
                    @php
                        $activities = \DB::table('view_COLOC_dashboard_temp')
                                            ->get();
                    @endphp           

                    @foreach ($activities as $activity)                        
                        <div class="col-md-6 col-lg-3">
                            <div class="mb-3 card milestone_sites" data-activity_name="{{ $activity->activity_name}}" data-total="{{ $activity->counter}}" data-activity_id="{{ $activity->activity_id}}">
                                <div class="p-3">
                                    <div class="milestone-bg" style="position: absolute; left: 0px; top:0px; opacity: 0.15; height: 100%; width:100%; background-image: url('/images/milestone-blue-2.jpeg');   background-repeat: no-repeat; background-size: 100%;"></div>
                                    <div class="text-center" style="min-height: 40px;">
                                        <div class="text-muted text-uppercase" style="font-size:12px; overflow: hidden;">
                                            {{ $activity->activity_name}}
                                        </div>
                                    </div>
                                    <div class="text-center" style="font-weight: bolder; font-size: 40px;">
                                        {{ $activity->counter}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="tab-pane" id="tab-eg9-1" role="tabpanel">
            <div class="card-body">
                <style>
                    .assigned-sites-table {
                        cursor: pointer;
                    }
                
                    table {
                        width: 100% !important;
                    }
                </style> 
                <table id="dar-table" class="align-middle mb-0 table table-borderless table-striped table-hover assigned-sites-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Vendor</th>
                            <th>Supervisor</th>
                            <th>Agent</th>
                            <th>Site</th>
                            <th>Activity</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table> 
            </div>
        </div>
    </div>
</div>




{{-- MODAL --}}
@section('modals')
<div id="modal-milestone-sites" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-image: url('/images/milestone-orange.jpeg');   background-repeat: no-repeat; background-size: 100%; opacity: 0.75">
            <h5 class="modal-title" style="opacity: 1; color: black; z-index: 200; font-weight:bold; text-shadow: 1px 1px white;">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 my-2 text-center" >
                        <H1 id="header_total" style="letter-spacing: 5px; font-weight: bolder;"> 11</H1>
                    </div> 
                </div>       
                <div role="group" class="btn-group-sm nav btn-group">
                    <a data-toggle="tab" href="#tab-eg3-2" class="btn-shadow btn btn-secondary active">Sites</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-eg3-2" role="tabpanel">
                        <div class="sites pt-3">
                            <table id="sites_table" class="align-middle mb-0 table table-borderless table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Vendor</th>
                                        <th>Region</th>
                                        <th>Site</th>
                                        <th>Aging</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table> 
                        </div>
                    </div>
                </div>                    
            </div>
        </div>
    </div>
</div>
@endsection

{{-- SCRIPTS --}}

@section("js_script")

xs<script>
    $(document).ready(() => {

        $('.milestone_sites').on( 'click', function (e) {
            e.preventDefault();
            $('#modal-milestone-sites').modal("show");
            $("#header_total").text($(this).attr('data-total'));

            $(".modal-title").text($(this).attr('data-activity_name'));

            var table = '<table id="sites_table" class="align-middle mb-0 table table-borderless table-striped table-hover assigned-sites-table">' +
                            '<thead>' +
                                '<tr>' +
                                    '<th>Vendor</th>' +
                                    '<th>Region</th>' +
                                    '<th>Site</th>' +
                                    '<th>Aging</th>' +
                                '</tr>' +
                            '</thead>' +
                            '<tbody>' +
                            '</tbody>' +
                        '</table>';

            $('.sites').html(table);

            var ids = $(this).attr('data-activity_id');



            $('#sites_table').DataTable({
                processing: true,
                serverSide: false,
                filter: true,
                searching: true,
                lengthChange: true,
                responsive: true,
                stateSave: true,
                regex: true,
                ajax: {
                    url: "/ibs/get-site-by-activity-id/" + ids,
                    type: 'GET',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                },
                language: {
                    "processing": "<img src='/images/awesam_loader.png' width='120px;' alt-text='Loading...'/>",
                },

                columns: [
                    {data: "vendor_acronym"},
                    {data: "sam_region_name"},
                    {data: "site_name", render: function(data, type, row){
                        return  "<strong>" + data + "</strong>" + 
                                "<br><small>" + row['region_name'] + " > " + row["province_name"] + " > " + row["lgu_name"] + "</small>" +
                                "<br><small>" + row['activity_name'] + "</small>" +
                                "<br><small>" + row['sam_id'] + "</small>" 
                    }},
                    {data: "aging", className: "text-center"}
                ],
            }); 
        

        });
        
    });
</script>


<script>



        $("#dar-table").DataTable({
            processing: true,
            serverSide: false,
            filter: true,
            searching: true,
            lengthChange: true,
            responsive: true,
            stateSave: true,
            regex: true,
            ajax: {
                url: '/get-dar-dashboard/3',
                type: 'GET',

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
                        
            columns: [
                { data: "date_created" },
                { data: "vendor_acronym" },
                { data: null, render: function(data, type, row){ return row.IS_firstname + " " + row.IS_lastname; } },
                { data: null, render: function(data, type, row){ return row.firstname + " " + row.lastname; } },
                { data: null, render: function(data, type, row){ return row.site_name + "<br><small>" + row.sam_id + "</small>"; } },
                { data: "sub_activity_name" },
            ],
        }); 

</script>


@endsection
