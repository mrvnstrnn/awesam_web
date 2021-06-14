<div class="app-header-right">
    
    <div class="header-dots">
        
        {{-- HEADER BUTTON : GRID --}}
        <div class="dropdown">
            <button type="button" aria-haspopup="true" aria-expanded="false"
                data-toggle="dropdown" class="p-0 mr-2 btn btn-link">
                <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                    <span class="icon-wrapper-bg bg-primary"></span>
                    <i class="icon text-primary ion-android-apps"></i>
                </span>
            </button>

            {{-- HEADER OVERLAY : GRID DASHBAORD --}}
            @include('layouts.header.grid_dashboard')

        </div>


        {{-- HEADER BUTTON : NOTIFICATION --}}
        <div class="dropdown">

        <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="p-0 mr-2 btn btn-link">
            <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                <span class="icon-wrapper-bg bg-danger"></span>
                <i class="icon text-danger icon-anim-pulse ion-android-notifications"></i>
                <span class="badge badge-dot badge-dot-sm badge-danger">Notifications</span>
            </span>
        </button>        

            {{-- HEADER OVERLAY : NOTIFICATIONS --}}
            @include('layouts.header.notification_box')

        </div>
                    
    </div>

    {{-- HEADER USER INFO --}}
        
    <div class="header-btn-lg pr-0">
        <div class="widget-content p-0">
            <div class="widget-content-wrapper">

                <div class="widget-content-left">
                    <div class="btn-group">
                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                            @if (!is_null(\Auth::user()->getUserDetail()->first()))
                                @if (\Auth::user()->getUserDetail()->first()->image != "")
                                    <img width="42" height="42" class="rounded-circle" src="{{ asset('files/'.\Auth::user()->getUserDetail()->first()->image) }}" alt="">
                                @else
                                    <img width="42" height="42" class="rounded-circle" src="images/avatars/4.jpg" alt="">
                                @endif
                            @else
                                <img width="42" height="42" class="rounded-circle" src="images/avatars/4.jpg" alt="">
                            @endif
                            
                            {{-- <img width="42" height="42" class="rounded-circle" src="{{ 
                                !is_null(\Auth::user()->getUserDetail()->first()) || \Auth::user()->getUserDetail()->first()->image != '' ? asset('files/' .  \Auth::user()->getUserDetail()->first()->image) : 'images/avatars/4.jpg'
                            }}" alt=""> --}}
                            <i class="fa fa-angle-down ml-2 opacity-8"></i>
                        </a>

                        {{-- HEADER OVERLAY : USER MENU --}}
                        @include('layouts.header.user_menu')

                    </div>
                </div>
                
                {{-- HEADER : USER DETAILS --}}
                <div class="widget-content-left  ml-3 header-user-info">
                    <div class="widget-heading"> {{ ucwords(Auth::user()->name) }}</div>
                    <div class="widget-subheading"> {{ ucwords(Auth::user()->getUserProfile()->profile) }}</div>
                </div>

                <div class="header-btn-lg">
                    <button type="button" class="hamburger hamburger--elastic open-right-drawer">
                        {{-- <span class="hamburger-box"> --}}
                        <span class="pe-7s-chat fa-2x">
                            {{-- <span class="hamburger-inner"></span> --}}
                        </span>
                    </button>
                </div>
                
            </div>
        </div>
    </div>

</div>
