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

    <x-pr-po-pending-datatable ajaxdatatablesource="site-milestones" tableheader="PR Memo Pending Approval" activitytype="pr memo pending approval"/>
    <x-pr-po-datatable ajaxdatatablesource="site-milestones" tableheader="PR Memo List" activitytype="pr memo approved"/>

@endsection
 

@section('modals')

<div class="ajax_content_box"></div>

@endsection

@section('js_script')

<script>
    //////////////////////////////////////
    var profile_id = 8;
    var table_to_load = 'pr_memo';
    // var main_activity = 'New Endorsements Globe';

    //////////////////////////////////////
</script>

<script type="text/javascript" src="/js/getCols.js"></script>  
<script type="text/javascript" src="/js/DTmaker.js"></script>  
<script type="text/javascript" src="/js/modal-loader.js"></script>
<!-- PR PO Counter -->
<script type="text/javascript" src="/js/newsites_ajax_counter.js"></script>  

@endsection