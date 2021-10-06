@extends('layouts.home')

@section('content')

<x-home-dashboard />


@endsection

@section('js_script')
    <script>
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            drawBasic();
        })    
    </script>
    
@endsection