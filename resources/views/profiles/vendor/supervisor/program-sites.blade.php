@extends('layouts.main')

@section('content')

    {{-- <x-assigned-sites mode="vendor"/> --}}
    <x-milestone-datatable ajaxdatatablesource="site-milestones" tableheader="Program Sites" activitytype="vendor"/>

@endsection


@section('modals')

    <x-milestone-modal />

@endsection

@section('js_script')

<script>
    //////////////////////////////////////
    var profile_id = 3;
    var table_to_load = 'program_sites';
    var main_activity = '';

    //////////////////////////////////////
</script>

<script type="text/javascript" src="/js/getCols.js"></script>  
<script type="text/javascript" src="/js/DTmaker.js"></script>  
<script type="text/javascript" src="/js/modal-loader.js"></script>  


@endsection