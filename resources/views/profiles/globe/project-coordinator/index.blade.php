@extends('layouts.main')

@section('content')

    <x-milestone-datatable ajaxdatatablesource="localcoop" tableheader="Local Cooperatives" activitytype="all"/>

@endsection


@section('modals')

@include('layouts.localcoop')

@endsection


@section('js_script')

<script>
    //////////////////////////////////////
    var profile_id = 18;
    var table_to_load = 'local_coop';
    //////////////////////////////////////
</script>

<script type="text/javascript" src="/js/getCols.js"></script>  
<script type="text/javascript" src="/js/DTmaker.js"></script>  
<script type="text/javascript" src="/js/localcoop.js"></script>  


@endsection
