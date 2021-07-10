@extends('layouts.main')

@section('content')

    {{-- <x-assigned-sites mode="vendor"/> --}}
    <x-milestone-datatable ajaxdatatablesource="site-milestones" tableheader="Issue Validation" activitytype="all-site-issues"/>
    {{-- <x-issue-validation-datatable ajaxdatatablesource="site-milestones" tableheader="Issue Validation" activitytype="all"/> --}}

@endsection


@section('modals')

    <x-milestone-modal />

@endsection


@section('js_script')

<script>
    //////////////////////////////////////
    var profile_id = 8;
    var table_to_load = 'issue_valdation';
    var main_activity = "Issue Validation";
    //////////////////////////////////////
</script>

<script type="text/javascript" src="/js/getCols.js"></script>  
<script type="text/javascript" src="/js/DTmaker.js"></script>

<script type="text/javascript" src="/js/modal-issue-validation.js"></script>  

@endsection