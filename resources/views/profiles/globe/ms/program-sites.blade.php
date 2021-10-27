@extends('layouts.main')

@section('content')

<x-milestone-datatable ajaxdatatablesource="site-milestones" tableheader="Program Sites" activitytype="all"/>

@endsection

@section('modals')

    <x-milestone-modal />

@endsection


@section('js_script')

<script>
    //////////////////////////////////////
    var profile_id = 6;
    var table_to_load = 'program_sites';
    var main_activity = 'Program Sites';
    //////////////////////////////////////
</script>

<script type="text/javascript" src="/js/getCols.js"></script>  
<script type="text/javascript" src="/js/DTmaker.js"></script>  
<script type="text/javascript" src="/js/modal-loader.js"></script>  


{{-- <script>

    
$('.assigned-sites-table').on( 'click', 'tbody tr', function (e) {
    e.preventDefault();

    window.location.href = "/assigned-sites/" + $(this).attr('data-sam_id');
});
</script>
 --}}


@endsection