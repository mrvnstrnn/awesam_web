@extends('layouts.main')

@section('content')

    <x-tower-co-table actor="APMO-APM" />  

@endsection


@section('modals')

    <x-tower-co-modal actor="APMO-APM" />
    <x-tower-co-multi-modal actor="APMO-APM" />
    <x-tower-co-export-modal actor="APMO-APM" />


@endsection


@section('js_script')

    <script>
        //////////////////////////////////////
        var actor = 'apmo-apm';
        //////////////////////////////////////
    </script>

    <script src="/js/towerco.js"></script>

@endsection
