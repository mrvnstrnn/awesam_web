{{-- PROFILE MENU --}}

<ul class="vertical-nav-menu">
    <li class="app-sidebar__heading">{{ Auth::user()->user_position }}</li>
    
    <li class="{{ $active_slug == "" ? 'mm-active' : '' }}">
        <a class="{{ $active_slug == "" ? 'mm-active' : '' }}" href="/">
            <i class="metismenu-icon pe-7s-home"></i>
            Home
        </a>
    </li>
    @foreach ($profile_direct_links as $key => $mainmenus)
        @if (count($mainmenus) > 1)
        <li>
            <a href="#">
                <i class="{{ 'metismenu-icon pe-7s-'.$mainmenus[0]->icon }}"></i>
                {{ ucwords($key) }}
                <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
            </a>

            <ul>
                @foreach ($mainmenus as $submenu)
                    <li class="{{ $submenu->slug == $active_slug ? 'mm-active' : '' }}">
                        <a class="{{ $submenu->slug == $active_slug ? 'mm-active' : '' }}" href=" {{ '/'.$submenu->slug }} ">
                            {{ $submenu->menu }}
                        </a> 
                    </li>
                @endforeach
            </ul>
        </li>
        @else
        <li class="{{ $active_slug == $mainmenus[0]->slug ? 'mm-active' : '' }}">
            <a class="{{ $mainmenus[0]->slug == $active_slug ? 'mm-active' : '' }}" href=" {{ '/'.$mainmenus[0]->slug }} ">
                <i class="{{ 'metismenu-icon pe-7s-'.$mainmenus[0]->icon }}"></i>
                {{ ucwords($mainmenus[0]->title) }} 
            </a>
        </li>
        @endif
    @endforeach
</ul>    

<ul class="vertical-nav-menu">
    <li class="app-sidebar__heading">Tasks</li>
        @foreach ($program_direct_links as $key => $mainmenus)

        {{-- @php
            dd($program_direct_links)
        @endphp --}}

        @if (count($mainmenus) > 1)
        <li>
            <a href="#">
                <i class="{{ 'metismenu-icon pe-7s-'.$mainmenus[0]->icon }}"></i>
                {{ ucwords($key) }}
                <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
            </a>
            <ul>
                @foreach ($mainmenus as $submenu)
                    <li class="{{ $submenu->slug == $active_slug ? 'mm-active' : '' }}">
                        <a class="{{ $submenu->slug == $active_slug ? 'mm-active' : '' }}" href=" {{ '/'.$submenu->slug }} ">
                            {{ $submenu->menu }}
                        </a> 
                    </li>
                @endforeach
            </ul>
        </li>
        @else
            <li class="{{ $active_slug == $mainmenus[0]->slug ? 'mm-active' : '' }}">
                <a class="{{ $mainmenus[0]->slug == $active_slug ? 'mm-active' : '' }}" href=" {{ '/'.$mainmenus[0]->slug }} ">
                    <i class="{{ 'metismenu-icon pe-7s-'.$mainmenus[0]->icon }}"></i>
                    {{ ucwords($mainmenus[0]->title) }} 
                </a>
            </li>
        @endif
    @endforeach
</ul>    
@if(\Auth::user()->profile_id == 2)
<ul class="vertical-nav-menu">
    @php
        $programs = \Auth::user()->getUserProgram();    
    @endphp

        @foreach ($programs as $program)
        <li class="app-sidebar__heading">{{ $program->program}}</li>
        @php
        $stages = \DB::table('program_stages')->where('program_id',$program->program_id)->get();
        @endphp

        @foreach ($stages as $stages)
        <li class="">
            <a class="">
                {{ $stages->stage_name }}
            </a> 
        </li>
        @endforeach
        @endforeach
</ul>    
@endif

