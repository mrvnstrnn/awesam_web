@extends('layouts.main')

@section('content')

    <x-tower-co-table actor="RAM" />     

@endsection


@section('modals')

    <x-tower-co-modal actor="RAM" />
    <x-tower-co-multi-modal actor="RAM" />

@endsection


@section('js_script')

    <script>
        //////////////////////////////////////
        var actor = 'ram';
        //////////////////////////////////////
    </script>

    <script src="/js/towerco.js"></script>

@endsection
