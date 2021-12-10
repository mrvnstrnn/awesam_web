@extends('layouts.main')

@section('style')

    @include('profiles.view_site_style');

@endsection

@section('content')

    @include('profiles.view_site_content');

@endsection

@section('modals')

    @include('profiles.view_site_modal');

@endsection

@section('js_script')

    @include('profiles.view_site_js');

@endsection