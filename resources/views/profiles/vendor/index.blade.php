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

    {{-- @switch( $profile )
        @case('head')
            <x-vendor.menu.head />
            @break

        @case('manager')
            <x-vendor.menu.manager />
            @break
  
        @case('supervisor')
            <x-vendor.menu.supervisor />
            @break
            
        @case('agent')
            <x-vendor.menu.agent />
            @break

        @default

    @endswitch


    <x-globe.program.menu>

        <x-vendor.program.coloc />
        <x-globe.program.ibs />
        <x-globe.program.wireless />
        <x-globe.program.wireline />
        <x-globe.program.site_management />

    </x-globe.program.menu> --}}

    {{-- {{ $profile }} --}}
    <ul class="vertical-nav-menu">
        <li class="app-sidebar__heading">Agent</li>
        
        <li>
            <a href="/">
                <i class="metismenu-icon pe-7s-home"></i>
                Home
            </a>
        </li>

        {{-- Get Direct Link Menus --}}
        @foreach ($profile_direct_links as $mainmenu)
            <li> 
                @if($mainmenu->submenus > 1)
                    @php
                    $icon = explode(',', $mainmenu->icon);
                    @endphp
                    <a href="#">
                        <i class="{{ 'metismenu-icon pe-7s-' . $icon[0] }}"></i>
                        {{ ucwords($mainmenu->mainmenu) }} 
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>  
                    <ul>
                        @foreach ($profile_menu as $submenu)
                            @if($submenu->level_two == $mainmenu->mainmenu)
                                <li>
                                    <a href=" {{ '/'.$submenu->slug }} ">
                                        {{ $submenu->menu }}
                                    </a> 
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @else
                    @foreach ($profile_menu as $submenu)
                        @if($mainmenu->mainmenu == $submenu->level_two)
                            <a href="{{ $submenu->slug }}">
                                <i class="{{ 'metismenu-icon pe-7s-'.$submenu->icon }}"></i>
                                {{ ucwords($mainmenu->mainmenu) }} 
                            </a>
                        @endif
                    @endforeach
                @endif
            </li>
        @endforeach




    </ul>    

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
