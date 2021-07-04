@extends('layouts.main')

@section('content')

    <x-milestone-datatable ajaxdatatablesource="site-milestones" tableheader="RTB Declaration" activitytype="site approval"/>
    
@endsection


@section('modals')

    <x-milestone-modal />

@endsection

@section('js_script')
<script>
    //////////////////////////////////////
    var profile_id = 9;
    var table_to_load = 'site_approvals';
    //////////////////////////////////////

</script>

<script type="text/javascript" src="/js/getCols.js"></script>  
<script type="text/javascript" src="/js/DTmaker.js"></script>  
<script type="text/javascript" src="/js/modal-loader.js"></script>  


@endsection     