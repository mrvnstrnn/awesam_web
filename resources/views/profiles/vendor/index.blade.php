@extends('layouts.main')

@section('content')

{{-- <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
    <li class="nav-item">
        <a role="tab" class="nav-link active"
            id="tab-0" data-toggle="tab" href="#tab-content-0">
            <span>Basic Calendar</span>
        </a>
    </li>
    <li class="nav-item">
        <a role="tab" class="nav-link" id="tab-1"
            data-toggle="tab" href="#tab-content-1">
            <span>List View</span>
        </a>
    </li>
    <li class="nav-item">
        <a role="tab" class="nav-link" id="tab-2"
            data-toggle="tab" href="#tab-content-2">
            <span>Background Events</span>
        </a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
    <div class="tab-pane tabs-animation fade" id="tab-content-1" role="tabpanel">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div id="calendar-list"></div>
            </div>
        </div>
    </div>
    <div class="tab-pane tabs-animation fade" id="tab-content-2" role="tabpanel">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div id="calendar-bg-events"></div>
            </div>
        </div>
    </div>
</div> --}}


@endsection

@section('menu')

    @include('profiles.vendor.menu')

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
