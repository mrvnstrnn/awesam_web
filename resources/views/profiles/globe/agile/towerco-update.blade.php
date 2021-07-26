@extends('layouts.main')

@section('content')

    <x-tower-co-table actor="AGILE" />     

@endsection


@section('modals')

    <x-tower-co-modal actor="AGILE" />

    <x-tower-co-multi-modal actor="AGILE" />

@endsection


@section('js_script')

    <script>
        //////////////////////////////////////
        var actor = 'agile';
        //////////////////////////////////////
    </script>

    <script src="/js/towerco.js"></script>

@endsection
