@extends('layouts.main')

@section('content')

    <x-milestone-datatable ajaxdatatablesource="site-milestones" tableheader="REFX" activitytype="refx process"/>

@endsection


@section('modals')

    <x-milestone-modal />

@endsection

@section('js_script')
<script>
    //////////////////////////////////////
    var profile_id = 30;
    var table_to_load = 'site_approvals';
    //////////////////////////////////////
</script>

<script type="text/javascript" src="/js/getCols.js"></script>  
<script type="text/javascript" src="/js/DTmaker.js"></script>  
<script type="text/javascript" src="/js/modal-loader.js"></script>  

@endsection     