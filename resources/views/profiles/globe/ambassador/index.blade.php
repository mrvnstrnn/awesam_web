@extends('layouts.home')

@section('content')

    <x-home-dashboard />

@endsection


@section('modals')

@include('layouts.localcoop')

@endsection


@section('js_script')

<script>
    //////////////////////////////////////
    var profile_id = 24;
    var table_to_load = 'local_coop';
    //////////////////////////////////////
</script>

<script type="text/javascript" src="/js/getCols.js"></script>  
<script type="text/javascript" src="/js/DTmaker.js"></script>  
<script type="text/javascript" src="/js/localcoop.js"></script>  


@endsection
