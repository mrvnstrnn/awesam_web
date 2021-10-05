@extends('layouts.main')

@section('content')

    <x-tower-co-table actor="AEPM" />  

@endsection


@section('modals')

    <x-tower-co-modal actor="AEPM" />
    <x-tower-co-multi-modal actor="AEPM" />
    <x-tower-co-export-modal actor="AEPM" />


@endsection


@section('js_script')

    <script>
        //////////////////////////////////////
        var actor = 'aepm';
        //////////////////////////////////////
    </script>

    <script src="/js/towerco.js"></script>

@endsection
