@extends('layouts.main')

@section('content')

    <x-tower-co-table actor="TOWERCO" />     

@endsection


@section('modals')

    <x-tower-co-modal actor="TOWERCO" />
    <x-tower-co-multi-modal actor="TOWERCO" />
    <x-tower-co-export-modal actor="TOWERCO" />

@endsection


@section('js_script')

    <script>
        //////////////////////////////////////
        var actor = 'towerco';
        //////////////////////////////////////
    </script>

    <script src="/js/towerco.js"></script>

@endsection
