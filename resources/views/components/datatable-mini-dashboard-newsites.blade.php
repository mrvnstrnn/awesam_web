
{{-- NEWSITES MINI DASHBOARD --}}

@php
$minidash = $minidashboard->get();
@endphp


@if(in_array(\Auth::user()->profile_id, array(8, 9, 10)))
    
    {{-- NEW SITES PR/PO COUNTER  --}}
    @if (in_array($tableheader, array("New CLP", "PR Memo for Approval", "PR Issuance", "Vendor Awarding")))


        <div class="row mb-3 pb-3 text-center border-bottom">
            <div class="col-12">
                <div class="row">
                    @foreach ($minidash as $dash)
                        @if($dash->category == 'PR / PO')
                            <div class="col mt-2">
                                <div class="minidash_site_list" data-site_count="{{ $dash->count}}" data-activity_ids="{{ $dash->activity_ids }}" data-activity_id_count="{{$dash->activity_id_count}}" data-category="{{ $dash->category }}" data-milestone="{{ $dash->milestone }}">
                                    <h1 class="menu-header-title">{{ $dash->count }}</h1>
                                    <h6 class="menu-header-subtitle" style="font-size: 12px; cursor: pointer;" data-value="">{{ $dash->milestone }}</h6>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        {{-- NEW SITES PR/PO COUNTER  --}}
    @elseif (in_array($tableheader, array("PR Memo Pending Approval")) && \Auth::user()->profile_id == 8)


        <div class="row mb-3 pb-3 text-center border-bottom">
            <div class="col-12">
                <div class="row">
                    @foreach ($minidash as $dash)
                        @if($dash->category == 'PR / PO')
                            <div class="col mt-2">
                                <div class="minidash_site_list" data-site_count="{{ $dash->count}}" data-activity_ids="{{ $dash->activity_ids }}" data-activity_id_count="{{$dash->activity_id_count}}" data-category="{{ $dash->category }}" data-milestone="{{ $dash->milestone }}">
                                    <h1 class="menu-header-title">{{ $dash->count }}</h1>
                                    <h6 class="menu-header-subtitle" style="font-size: 12px; cursor: pointer;" data-value="">{{ $dash->milestone }}</h6>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

    {{-- NEW SITES  JTSS  COUNTER  --}}
    @elseif (in_array($tableheader, array("Site Hunting", "Joint Technical Site Survey", "SSDS")))

        <div class="row mb-3 pb-3 text-center border-bottom">
            <div class="col-12">
                <div class="row">
                    @foreach ($minidash as $dash)
                        @if($dash->category == 'SH / JTSS / SSDS')
                            <div class="col mt-2">
                                <div class="minidash_site_list" data-site_count="{{ $dash->count}}" data-activity_ids="{{ $dash->activity_ids }}" data-activity_id_count="{{$dash->activity_id_count}}" data-category="{{ $dash->category }}" data-milestone="{{ $dash->milestone }}">
                                    <h1 class="menu-header-title">{{ $dash->count }}</h1>
                                    <h6 class="menu-header-subtitle" style="font-size: 12px; cursor: pointer;" data-value="">{{ $dash->milestone }}</h6>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endif

@endif

<style>
    .minidash_site_list{
        cursor: pointer;
    }
</style>


@section('modals_2')

<div class="modal fade" id="minidashModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true"  data-keyboard="false">
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
                                            MILESTONE                                            
                                        </h5>
                                </div>
                            </div>
                        </div> 
                        <div class="card-body">
                            <table id="sites_table" class="align-middle mb-0 table table-borderless table-striped table-hover assigned-sites-table">
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

<script type="text/javascript" src="/vendors/jquery/dist/jquery.min.js"></script>

<script>
$(document).ready(() => {

    $('.minidash_site_list').on("click", function(){

        if($(this).attr('data-site_count')>0){

            $('#minidashModal').modal();
            $('#minidashModal .menu-header-title').text($(this).attr('data-category') + " : " + $(this).attr('data-milestone'));

            var ids = $(this).attr('data-activity_ids');

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

            $('#minidashModal .card-body').html(table);


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
                    url: "/newsites/get-site-by-activity-id/" + ids,
                    type: 'GET',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                },
                language: {
                "processing": "<div style='background-color:black; text-color: white; padding: 20px 10px; border: 3px solid black; border-radius: 20px;'>Loading Data...</div>",
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

        }
    })
});

</script>
