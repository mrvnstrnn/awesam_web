@extends('layouts.main')

@section('content')

    <x-milestone-datatable ajaxdatatablesource="site-milestones" tableheader="RTB Declaration" activitytype="set site value"/>


    {{-- <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header-tab card-header">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                    <i class="header-icon lnr-layers icon-gradient bg-ripe-malin"></i>
                    TEST
                </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <table id="test-table" 
                            class="align-middle mb-0 table table-borderless table-striped table-hover"
                            data-href="/assigned-sites/list/3/globe"
                            data-program_id="3" data-table_loaded="false">
                            <thead>
                                <tr>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>                        
                    </div>                
                </div>
            </div>
        </div>
    </div> --}}
    
@endsection


@section('modals')

    <x-milestone-modal />

@endsection

@section('js_script')
<script>
    //////////////////////////////////////
    var profile_id = 7;
    var table_to_load = 'site_approvals';
    //////////////////////////////////////

</script>

<script type="text/javascript" src="/js/getCols.js"></script>  
<script type="text/javascript" src="/js/DTmaker.js"></script>  
<script type="text/javascript" src="/js/modal-loader.js"></script>  



{{-- <script>

        var cols = getCols('3', table_to_load, profile_id);

        if(cols.length > 0){
            // Add Column Headers
            $.each(cols, function (k, colObj) {
                    str = '<th>' + colObj.name + '</th>';
                    $(str).appendTo($('#test-table').find("thead>tr"));
            });

            console.log(cols);

            
        }

        $('#test-table').DataTable({
            processing: true,
            serverSide: false,
            filter: true,
            searching: true,
            lengthChange: false,
            regex: true,
            ajax: {
                url: $('#test-table').attr('data-href'),
                type: 'GET',

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            columns: cols,
            
            language: {
                "processing": "<div style='padding: 20px; background-color: black; color: white;'><strong>Kinukuha ang datos</strong></div>",
            },


        }); 

</script> --}}


@endsection     