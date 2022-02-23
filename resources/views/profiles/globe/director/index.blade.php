@extends('layouts.home')

@section('content')

<x-home-dashboard />

@endsection

@include('layouts.rtb-tracker')

@section('js_script')
    <script>
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            drawBasic();
        });
    </script>
    
@endsection
