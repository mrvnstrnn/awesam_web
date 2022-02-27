@extends('layouts.main')

@section('content')

<x-milestone-datatable ajaxdatatablesource="site-milestones" tableheader="My Approvals" activitytype="my_approvals"/>

@endsection

@section('modals')

    <x-milestone-modal />

@endsection

@section('js_script')

<script>
    //////////////////////////////////////
    var profile_id = 14;
    var table_to_load = 'my_approvals';
    var main_activity = 'Program Sites';

    //////////////////////////////////////
</script>

<script type="text/javascript" src="/js/getCols.js?{{ time() }}"></script>  
<script type="text/javascript" src="/js/DTmaker.js?{{ time() }}"></script>  
<script type="text/javascript" src="/js/modal-loader.js?{{ time() }}"></script>  

@endsection