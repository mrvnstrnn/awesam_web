@extends('layouts.main')

@section('content')


@endsection

@section('menu')

globe

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
