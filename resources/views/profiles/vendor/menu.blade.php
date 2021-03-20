<ul class="vertical-nav-menu">
    <li class="app-sidebar__heading">{{ $profile }}</li>
    
    @if($active_slug == "")
    <li class="mm-active">
        <a class="mm-active" href="/">
    @else
    <li>
        <a href="/">
    @endif
            <i class="metismenu-icon pe-7s-home"></i>
            Home
        </a>
    </li>

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
                            
                            @if($submenu->slug == $active_slug)
                            <li class="mm-active">
                                <a class="mm-active" href=" {{ '/'.$submenu->slug }} ">
                            @else
                            <li>
                                <a href=" {{ '/'.$submenu->slug }} ">
                            @endif
                                    {{ $submenu->menu }}
                                </a> 
                            </li>
                        @endif
                    @endforeach
                </ul>
            @else
                @foreach ($profile_menu as $submenu)
                    @if($mainmenu->mainmenu == $submenu->level_two)
                        @if($submenu->slug == $active_slug)
                            <a class="mm-active" href=" {{ '/'.$submenu->slug }} ">
                        @else
                            <a href=" {{ '/'.$submenu->slug }} ">
                        @endif
                            <i class="{{ 'metismenu-icon pe-7s-'.$submenu->icon }}"></i>
                            {{ ucwords($mainmenu->mainmenu) }} 
                        </a>
                    @endif
                @endforeach
            @endif
        </li>
    @endforeach    

</ul>    

<x-globe.program.menu>

    @foreach ($program_direct_links as $mainmenu)
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
                            @if($submenu->slug == $active_slug)
                            <li class="mm-active">
                                <a class="mm-active" href=" {{ '/'.$submenu->slug }} ">
                            @else
                            <li>
                                <a href=" {{ '/'.$submenu->slug }} ">
                            @endif
                                    {{ $submenu->menu }}
                                </a> 
                            </li>
                        @endif
                    @endforeach
                </ul>
            @else
                @foreach ($profile_menu as $submenu)
                    @if($mainmenu->mainmenu == $submenu->level_two)
                        @if($submenu->slug == $active_slug)
                            <a class="mm-active" href=" {{ '/'.$submenu->slug }} ">
                        @else
                            <a href=" {{ '/'.$submenu->slug }} ">
                        @endif
                            <i class="{{ 'metismenu-icon pe-7s-'.$submenu->icon }}"></i>
                            {{ ucwords($mainmenu->mainmenu) }} 
                        </a>
                    @endif
                @endforeach
            @endif
        </li>
    @endforeach    

    {{-- <x-vendor.program.coloc /> --}}
    {{-- <x-globe.program.ibs />
    <x-globe.program.wireless />
    <x-globe.program.wireline />
    <x-globe.program.site_management /> --}}

</x-globe.program.menu>
