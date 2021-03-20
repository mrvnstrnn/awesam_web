<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                {{-- <i class=" {{ "pe-7s-home" . " icon-gradient bg-mean-fruit" }}"></i> --}}
                @yield('title-icon')
            </div>
            <div>
                @yield('title')
                <div class="page-title-subheading">@yield('title-subheading')</div>
            </div>
        </div>
    </div>
</div>