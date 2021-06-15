@extends('layouts.main')

@section('content')

    <x-milestone-datatable ajaxdatatablesource="site-milestones" tableheader="Site Approval" activitytype="site approval"/>

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

    <script>
        $(document).ready(() => {

            $('.assigned-sites-table').on( 'click', 'tbody tr', function (e) {
                e.preventDefault();
                if($(this).find("td").attr("colspan") != 4){
                    
                    $('.modal-body').html('');

                    iframe =  '';

                    $('.modal-body').html(iframe);

                    $('#viewInfoModal').modal('show');
                }

                // window.location.href = "/assigned-sites/" + $(this).attr('data-sam_id');
            });

        });    
    </script>


@endsection