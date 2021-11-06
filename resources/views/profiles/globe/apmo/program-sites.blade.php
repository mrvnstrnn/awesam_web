@extends('layouts.main')

@section('content')
    <style>
        tr {
            cursor: pointer;
        }
    </style>

    {{-- <x-assigned-sites mode="vendor"/> --}}
    {{-- <x-milestone-datatable ajaxdatatablesource="site-milestones" tableheader="Program Sites" activitytype="all"/> --}}

    @php
        
        $table_columns = \DB::table('table_fields')
                            ->where('table_name', "program_sites")
                            ->where('program_id', 3)
                            ->orderBy('field_sort', 'asc')
                            ->get();

    @endphp



    <div class="row mt-5">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="dropdown-menu-header"> 
                    <div class="dropdown-menu-header-inner px-2 p-3 bg-primary">
                        <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/abstract2.jpg');"></div>
                        <div class="menu-header-content btn-pane-right d-flex justify-content-between button_header_area">
                            <h5 class="menu-header-title">
                                <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
                                {{  Request::path() }}
                            </h5>
                        </div>
                    </div>
                </div> 
    
                <div class="card-body" style="overflow-x: auto; max-width: 100%;">

                    <table 
                    id="datatable-coloc-program-sites" 
                    class="table-sm align-middle mb-0 table table-bordered table-striped table-hover dynamic-datatable"
                    data-href="/get-datatable"
                    data-program_id="3" 
                    data-table_loaded="false" 
                    data-type="Program Sites"
                    style="min-width:100%"
                    >

                    <thead>
                        <tr>
                            @foreach ($table_columns as $field)
                                <th>{{ $field->field_name }}</th>                            
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table> 
            
                </div>
            </div>
    
        </div>
    </div>    

    {{-- <script type="text/javascript" src="/vendors/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> --}}
@endsection


@section('modals')

    <x-milestone-modal />

@endsection

@section('js_script')

{{-- <script type="text/javascript" src="/js/modal-loader.js"></script>   --}}

<script>

var cols = [
    @php
        foreach ($table_columns as $column){
            echo "{ data : '" . $column->source_field . "' },";
        }
    @endphp
];


$(document).ready(() => {

    $('.dynamic-datatable').on('click', '.show_action_modal_tr', function(e){
    // $('.dynamic-datatable').on( 'click', 'tbody tr', function (e) {

    e.preventDefault();

    loader = "<img src='/images/awesam_loader.png' width='200px;' alt-text='Loading...'/>";
    $.blockUI({ message: loader, css:{backgroundColor: "transparent", border: '0px;'} });

    // $(".ajax_content_box").attr("data-sam_id", $(this).attr('data-sam_id'));
    // $(".ajax_content_box").attr("data-activity", $(this).attr('data-activity'));

    var site = $(this).attr("data-site");
    var sam_id = $(this).attr('data-sam_id');
    var activity_source = $(this).parent().parent().attr("data-type");


    $.ajax({
        url: "/get-component",
        method: "POST",
        data: {
            site : site,
            sam_id : sam_id,
            activity_source : activity_source,
            bypass_activity_profiles : true,
        },

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            },

        success: function (resp){
            $('.ajax_content_box').html("");   
            $('.ajax_content_box').html(resp);   

            $.unblockUI();
            $('#viewInfoModal').modal('show');


        },
        complete: function(){
        },
        error: function (resp){
            toastr.error(resp.message, "Error");
        }
    });

    })


$("#datatable-coloc-program-sites").DataTable({
    processing: true,
    serverSide: false,
    ajax: {
        url: "/datatable-data/3/1/program sites",
        type: 'GET',

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    },

    language: {
        "processing": "<img src='/images/awesam_loader.png' width='120px;' alt-text='Loading...'/>",
    },

    dataSrc: function(json){
        return json.data;
    },

    createdRow: function (row, data, dataIndex) {
                    // if (data.activities != undefined) {
                    //     var activity_names = JSON.parse( JSON.stringify(data.activities.replace(/&quot;/g,'"')) );

                    //     var activity_name = JSON.parse(activity_names) != null ? JSON.parse(activity_names).activity_name : "";
                    // } else {
                    // }

                    // $(row).attr('data-site_all', JSON.stringify(data));
                    // $(row).attr('data-activity', data.activity_name);
                    $(row).addClass('show_action_modal_tr');
                    // $(row).attr('data-activity', JSON.parse(activity_name) != null ? JSON.parse(activity_name).activity_name : "");
                    // $(row).attr('data-site', data.site_name);
                    $(row).attr('data-sam_id', data.sam_id);
                    $(row).attr('data-site', data.site_name);
                    // $(row).attr('data-main_activity', main_activity);
                    // $(row).attr('data-profile', data.profile_id);
                    // $(row).attr('data-what_table', $(whatTable).attr('id'));
                    // $(row).attr('data-issue_id', data.issue_id ? data.issue_id : "");

                    // $(row).attr('data-program_id', data.program_id ? data.program_id : "");
                    // $(row).attr('data-vendor_id', data.vendor_id ? data.vendor_id : "");
                    // $(row).attr('data-site_category', data.site_category);
                    // $(row).attr('data-activity_id', data.activity_id);
    },

    columns: cols,

    columnDefs: [ 
        {
            "targets": [ "site_name" ],
            "visible": true,
            "searchable": true,
            "render": function ( data, type, row ) {
                if (row['region_name'] == undefined || row['province_name'] == undefined || row['lgu_name'] == undefined) {
                    return '<div class="font-weight-bold">' + data +'</div><div></div><div> <small>'+ row['sam_id'] + '</small></div>';
                } else {
                    return '<div class="font-weight-bold">' + data +'</div><div><small>' + row['region_name'] + ' > ' + row['province_name'] + ' > ' + row['lgu_name'] + '</small></div><div> <small>'+ row['sam_id'] + '</small></div>';
                }
            },
        },
        {
            "targets": [ "sam_id" ],
            "visible": false,
            "searchable": true,
        },
        {
            "targets": [ "activity_name" ],
            "visible": true,
            "searchable": true,
            "render": function ( data, type, row ) {

                var varDate = new Date(row['end_date']);
                var today = new Date();
                today.setHours(0,0,0,0);

                if(varDate >= today) {
                    badge_color = "success";
                    date_text = row['start_date'] + ' to ' +row['end_date'];

                } else {
                    badge_color = "danger";
                    const diffTime = Math.abs(today - varDate);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
                    date_text = diffDays + " days delayed";
                                                
                }

                
                return '<div class="badge badge-' + badge_color + ' text-sm mb-0 px-2 py-1">' + data +'</div>' + 
                        '<div><small>'+ date_text +'</small></div>'
            },
        }

    ]


    }); 

});

</script>    


@endsection