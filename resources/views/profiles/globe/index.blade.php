@extends('layouts.main')

@section('content')


@endsection

@section('menu')

    @switch( strtolower($profile) )

        @case('sts head')
            <x-globe.menu.sts_head />
            @break

        @case('sts staff')
            <x-globe.menu.sts_staff />
            @break

        @case('program head')
            <x-globe.menu.program_head />
            @break
  
        @case('program supervisor')
            <x-globe.menu.program_supervisor />
            @break
            
        @case('program staff')
            <x-globe.menu.program_staff />
            @break

        @default

    @endswitch

    <x-globe.program.menu>

        <x-globe.program.coloc />
        {{-- <x-globe.program.ibs />
        <x-globe.program.wireless />
        <x-globe.program.wireline />
        <x-globe.program.site_management /> --}}

    </x-globe.program.menu>

@endsection

@section('title')
    {{ $title }}
@endsection

@section('title-subheading')
    {{ $title_subheading }}
@endsection

@section('title-icon')

    <i class="pe-7s-home icon-gradient bg-mean-fruit"></i>

    {{-- icon from controller issue need to find a new way --}}
    {{-- to get variable info from UserController --}}
    {{-- {{ $title_icon }} --}}

@endsection
