<div class="app-header header-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="app-header__content">
        <div class="app-header-right">
    
        
            {{-- HEADER USER INFO --}}
                
            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
        
                        <div class="widget-content-left">
                            <div class="btn-group">
                                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                    @if (!is_null(\Auth::user()->getUserDetail()->first()))
                                        @if (!is_null(\Auth::user()->getUserDetail()->first()->image))
                                            <img width="42" height="42" class="rounded-circle offline" src="{{ asset('files/'.\Auth::user()->getUserDetail()->first()->image) }}" alt="">
                                        @else
                                            <img width="42" height="42" class="rounded-circle offline" src="images/no-image.jpg" alt="">
                                        @endif
                                    @else
                                        <img width="42" height="42" class="rounded-circle offline" src="images/no-image.jpg" alt="">
                                    @endif
                                    <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                </a>
        
                                {{-- HEADER OVERLAY : USER MENU --}}
                                @include('layouts.header.user_menu')
        
                            </div>
                        </div>
                        
                        {{-- HEADER : USER DETAILS --}}
                        <div class="widget-content-left  ml-3 header-user-info">
                            <div class="widget-content-left mr-3">
                                <img class="rounded-circle" src="assets/images/avatars/1.jpg" alt="" width="42">
                            </div>
                            <div class="widget-heading"> {{ ucwords(Auth::user()->name) }}</div>
                            <div class="widget-subheading"> {{ ucwords(Auth::user()->profile) }}</div>
                        </div>
                        
                    </div>
                </div>
            </div>
        
        </div>
        
    </div>
</div>
