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
    var profile_id = 8;
    var table_to_load = 'site_approvals';
    //////////////////////////////////////

    $(document).on('hidden.bs.modal', '#viewInfoModal', function (event) {
      $( "#"+$(".ajax_content_box").attr("data-what_table") ).DataTable().ajax.reload();
    });
</script>

<script type="text/javascript" src="/js/getCols.js"></script>  
<script type="text/javascript" src="/js/DTmaker.js"></script>  
<script type="text/javascript" src="/js/modal-loader.js"></script>  

<script>
    $(document).on("click", '.export_datatable', function(e){

        e.preventDefault();
        window.confirm("Export data to excel");


    });
</script>


@endsection     




