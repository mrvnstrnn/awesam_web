@extends('layouts.main')

@section('content')

    <x-tower-co-table actor="STS" />     

@endsection


@section('modals')

    <x-tower-co-modal actor="STS" />

@endsection


@section('js_script')

    <script>
        //////////////////////////////////////
        var actor = 'sts';
        //////////////////////////////////////
    </script>

    <script src="/js/towerco.js"></script>

@endsection
