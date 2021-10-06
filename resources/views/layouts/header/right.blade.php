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
                {{-- <i class="icon text-danger icon-anim-pulse ion-android-notifications"></i> --}}
                <i class="icon text-danger ion-android-notifications"></i>

                @if (count(\Auth::user()->unreadNotifications) > 0)
                    <span class="badge badge-dot badge-dot-sm badge-danger">Notifications</span>
                @endif

                {{-- <span class="badge badge-dot badge-dot-sm badge-danger">Notifications</span> --}}

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
                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn" id="avatar2">
                            {{-- @if (!is_null(\Auth::user()->getUserDetail()->first()))
                                @if (\Auth::user()->getUserDetail()->first()->image != "")
                                    <img width="42" height="42" class="rounded-circle" src="{{ asset('files/'.\Auth::user()->getUserDetail()->first()->image) }}" alt="">
                                @else
                                    <img width="42" height="42" class="rounded-circle" src="images/no-image.jpg" alt="">
                                @endif
                            @else
                                <img width="42" height="42" class="rounded-circle" src="images/no-image.jpg" alt="">
                            @endif --}}
                            <img class="rounded-circle offline" src="images/avatars/4.jpg" alt="" width="42">
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

                {{-- <div class="header-btn-lg">
                    <button type="button" class="hamburger hamburger--elastic open-right-drawer">
                        <span class="pe-7s-chat fa-2x">
                        </span>
                    </button>
                </div> --}}
                
            </div>
        </div>
    </div>

</div>


<style>
    .sapMBtnInner {
        background-color: unset !important;
        background: unset;
        border: 0px;
    }

    .sapMBtnInner img {
        width: 100px !important;
    }
</style>

{{-- <script src="https://sapui5.hana.ondemand.com/resources/sap-ui-core.js" id="sap-ui-bootstrap" data-sap-ui-xx-bindingSyntax="complex" data-sap-ui-libs="sap.m" data-sap-ui-theme="sap_bluecrystal">
</script> --}}

{{-- <script>

    function generateAvatar(name){

        const fullName = name.split(' ');
        const initials = fullName.shift().charAt(0) + fullName.pop().charAt(0);

        var canvas = document.createElement('canvas');
        var radius = 30;
        var margin = 3;
        canvas.width = radius*2+margin*2;
        canvas.height = radius*2+margin*2;

        var ctx = canvas.getContext('2d');
        ctx.beginPath();
        ctx.arc(radius+margin,radius+margin,radius, 0, 2 * Math.PI, false);
        ctx.closePath();
        ctx.fillStyle = '#d92550';
        ctx.fill();
        ctx.fillStyle = "white";
        ctx.font = "bold 30px Arial";
        ctx.textAlign = 'center';
        ctx.fillText(initials, radius+5,radius*4/3+margin);
        return canvas.toDataURL();
    }

    
    var model = new sap.ui.model.json.JSONModel({
        name: "{{ ucwords(Auth::user()->firstname) }} " + " {{ ucwords(Auth::user()->lastname) }}"
    });

    new sap.m.Button({
        icon: { path: "/name", formatter: generateAvatar },
    }).setModel(model).placeAt("avatar");

    new sap.m.Button({
        icon: { path: "/name", formatter: generateAvatar },
    }).setModel(model).placeAt("avatar2");

</script> --}}
