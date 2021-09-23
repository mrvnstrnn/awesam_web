@extends('layouts.main')

@section('content')

    @include('profiles.dar_content')

@endsection

@section("js_script")


    @include('profiles.dar_js')
<!-- PR PO Counter -->
<script type="text/javascript" src="/js/newsites_ajax_counter.js"></script>  

@endsection