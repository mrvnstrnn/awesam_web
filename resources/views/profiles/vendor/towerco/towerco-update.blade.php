@extends('layouts.main')

@section('content')

    <x-tower-co-table actor="TowerCo" />     

@endsection


@section('modals')

    <x-tower-co-modal actor="TowerCo" />
    <x-tower-co-multi-modal actor="TowerCo" />

@endsection


@section('js_script')

    <script>
        //////////////////////////////////////
        var actor = 'towerco';
        //////////////////////////////////////
    </script>

    <script src="/js/towerco.js"></script>

@endsection
