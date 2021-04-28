{{-- PROFILE MENU --}}

<ul class="vertical-nav-menu">
    <li class="app-sidebar__heading">{{ $profile }}</li>
    
    <li class="{{ $active_slug == "" ? 'mm-active' : '' }}">
        <a class="{{ $active_slug == "" ? 'mm-active' : '' }}" href="/">
            <i class="metismenu-icon pe-7s-home"></i>
            Home
        </a>
    </li>

    {{-- <li class="{{ \Route::currentRouteName() ==  $active_slug ? 'mm-active' : '' }}">
        <a class="{{ \Route::currentRouteName() == 'invite.employee' ? 'mm-active' : '' }}" href="{{ route('invite.employee') }}">
            <i class="metismenu-icon pe-7s-{{ $title_icon }}"></i>
            Invite
        </a>
    </li> --}}


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
                {{ ucwords($key) }} 
            </a>
        </li>
        @endif
    @endforeach
</ul>    

{{-- PROGRAM MENU --}}

<ul class="vertical-nav-menu">
    <li class="app-sidebar__heading {{ count($program_direct_links) < 1 ? 'd-none' :  ''}}">Program</li>

    @foreach ($program_direct_links as $key => $mainmenus)
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
                {{ ucwords($key) }} 
            </a>
        </li>
        @endif
    @endforeach

    {{-- @foreach ($program_direct_links as $mainmenu)
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
                            <li class="{{ $submenu->slug == $active_slug ? 'mm-active' : '' }}">
                                <a class="{{ $submenu->slug == $active_slug ? 'mm-active' : '' }}" href=" {{ '/'.$submenu->slug }} ">
                                    {{ $submenu->menu }}
                                </a> 
                            </li>
                        @endif
                    @endforeach
                </ul>
            @else
                @foreach ($profile_menu as $submenu)
                    @if($mainmenu->mainmenu == $submenu->level_two)
                            <a class="{{ $submenu->slug == $active_slug ? 'mm-active' : '' }}" href=" {{ '/'.$submenu->slug }} ">
                            <i class="{{ 'metismenu-icon pe-7s-'.$submenu->icon }}"></i>
                            {{ ucwords($mainmenu->mainmenu) }} 
                        </a>
                    @endif
                @endforeach
            @endif
        </li>
    @endforeach     --}}
</ul>
