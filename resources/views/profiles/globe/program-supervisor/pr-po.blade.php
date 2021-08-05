@extends('layouts.main')

@section('content')
<style>
    .modal-dialog{
        -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
        -o-box-shadow: 0 5px 15px rgba(0,0,0,0);
        box-shadow: 0 5px 15px rgba(0,0,0,0);
    }   
</style>    

    <x-milestone-datatable ajaxdatatablesource="site-milestones" tableheader="PR / PO" activitytype="site prmemo"/>

@endsection

@section('modals')

    <x-milestone-modal />

@endsection

@section('js_script')

<script>
    //////////////////////////////////////
    var profile_id = 9;
    var table_to_load = 'pr_po';

    //////////////////////////////////////
</script>

<script type="text/javascript" src="/js/getCols.js"></script>
<script type="text/javascript" src="/js/DTmaker.js"></script>
<script type="text/javascript" src="/js/modal-loader.js"></script>

@endsection