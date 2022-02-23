@extends('layouts.main')

@section('content')

    @include('profiles.dar_content')

@endsection

@include('layouts.rtb-tracker')

@section("js_script")

    @include('profiles.dar_js')

@endsection