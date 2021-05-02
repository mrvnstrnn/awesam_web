<div tabindex="-1" role="menu" aria-hidden="true"
class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right">
<div class="dropdown-menu-header">
    <div class="dropdown-menu-header-inner bg-plum-plate">
        <div class="menu-header-image" style="background-image: url('images/dropdown-header/abstract4.jpg');"></div>
        <div class="menu-header-content text-white">
            <h5 class="menu-header-title">Profile Switcher</h5>
            <h6 class="menu-header-subtitle">superuser easy profile switching</h6>
        </div>
    </div>
</div>
<div class="grid-menu grid-menu-xl grid-menu-3col">
    <div class="no-gutters row">
        <?php $roles = \Auth::user()->allRoles() ?>

        @foreach ($roles as $role)
            <div class="col-sm-6 col-xl-4">
                <a href='{{ route('profile.switcher', $role->id) }}' class="btn-icon-vertical btn-square btn-transition btn btn-outline-link {{ \Auth::user()->profile_id == $role->id ? 'disabled' : '' }}">
                    <i class="pe-7s-{{ $role->mode == 'vendor' ? 'user' : 'global' }} icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg mb-3"></i>
                    {{ ucfirst($role->mode) . ' : ' . $role->profile }}
                </a>
            </div>
        @endforeach
        {{-- <div class="col-sm-6 col-xl-4">
            <a href='/profile-switcher/vendor/head' class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                <i class="pe-7s-user icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg mb-3"></i>
                Vendor : Head
            </a>
        </div>
        <div class="col-sm-6 col-xl-4">
            <a href='/profile-switcher/vendor/manager' class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                <i class="pe-7s-user icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg mb-3"></i>
                Vendor : Manager
            </a>
        </div>
        <div class="col-sm-6 col-xl-4">
            <a href='/profile-switcher/vendor/supervisor' class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                <i class="pe-7s-user icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg mb-3"></i>
                Vendor : Supervisor
            </a>
        </div>
        <div class="col-sm-6 col-xl-4">
            <a href='/profile-switcher/vendor/agent' class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                <i class="pe-7s-user icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg mb-3"></i>
                Vendor : Agent
            </a>
        </div>
        <div class="col-sm-6 col-xl-4">
            <a href='/profile-switcher/globe/sts_head' class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                <i class="pe-7s-global icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg mb-3"></i>
                Globe : STS Head
            </a>
        </div>
        <div class="col-sm-6 col-xl-4">
            <a href='/profile-switcher/globe/sts_staff' class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                <i class="pe-7s-global icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg mb-3"></i>
                Globe : STS Staff
            </a>
        </div>
        <div class="col-sm-6 col-xl-4">
            <a href='/profile-switcher/globe/program_head' class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                <i class="pe-7s-global icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg mb-3"></i>
                Globe : Program Head
            </a>
        </div>
        <div class="col-sm-6 col-xl-4">
            <a href='/profile-switcher/globe/pprogram_supervisor' class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                <i class="pe-7s-global icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg mb-3"></i>
                Globe : Program Supervisor
            </a>
        </div>
        <div class="col-sm-6 col-xl-4">
            <a href='/profile-switcher/globe/program_staff' class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                <i class="pe-7s-global icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg mb-3"></i>
                Globe : Program Staff
            </a>
        </div> --}}
    </div>
</div>
</div>
