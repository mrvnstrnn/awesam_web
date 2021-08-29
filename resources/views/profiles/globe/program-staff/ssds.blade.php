@extends('layouts.main')

@section('content')

  <x-milestone-datatable ajaxdatatablesource="site-milestones" tableheader="SSDS" activitytype="ssds"/>

@endsection


@section('modals')

    {{-- <x-milestone-modal /> --}}
    <div class="ajax_content_box"></div>

@endsection

@section('js_script')
<script>
    //////////////////////////////////////
    var profile_id = 8;
    var table_to_load = 'ssds';
    var main_activity = 'SSDS';
 
    //////////////////////////////////////

    $(document).on('hidden.bs.modal', '#viewInfoModal', function (event) {
      $( "#"+$(".ajax_content_box").attr("data-what_table") ).DataTable().ajax.reload();
    });
</script>

<script type="text/javascript" src="/js/getCols.js"></script>  
<script type="text/javascript" src="/js/DTmaker.js"></script>  
<script type="text/javascript" src="/js/modal-loader.js"></script>  

@endsection