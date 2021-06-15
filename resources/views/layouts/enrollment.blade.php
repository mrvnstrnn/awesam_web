<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Language" content="en">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>SAM</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
        <meta name="description" content="Site Acquisition and Management.">
        <!-- Disable tap highlight on IE -->
        <meta name="msapplication-tap-highlight" content="no">

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- <link href="./vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"> --> 
        <link rel="stylesheet" href="/vendors/@fortawesome/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="/vendors/ionicons-npm/css/ionicons.css">
        <link rel="stylesheet" href="/vendors/linearicons-master/dist/web-font/style.css">
        <link rel="stylesheet" href="/vendors/pixeden-stroke-7-icon-master/pe-icon-7-stroke/dist/pe-icon-7-stroke.css">
        <link href="/styles/css/base.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">

        <style>
            .stage1{
                background-color:blue;
            } 

            .stage2{
                background-color:blueviolet;
            } 

            .stage3{
                background-color: #C71585;
            } 

            .stage4{
                background-color:red;
            } 

            .stage5{
                background-color:orange;
            } 

            .stage6{
                background-color: yellowgreen;
            } 
            .stage7{
                background-color:green;
            } 

            .stage-text{
                font-size: 1.2em;
            }

            .stage-disabled{
                opacity: 0.4;
            }

            .stage-active{
                animation: progress-bar-stripes 1s linear infinite;
                background-image: linear-gradient(45deg, rgba(255,255,255,0.15) 25%, transparent 25%, transparent 50%, rgba(255,255,255,0.15) 50%, rgba(255,255,255,0.15) 75%, transparent 75%, transparent);
                background-size: 1rem 1rem;
            }

            .app-header__logo .logo-src:before {
                content: "SAM";
                font-size: 20px;
                /* vertical-align: middle; */
            }

            .app-header__logo .logo-src {
                background: none;
            }

            .dropzone {
                min-height: 20px !important;
                border: 1px dashed #3f6ad8 !important;
                padding: unset !important;
            }
        
        </style>    
    </head>

    <body>
        <div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar"> 

            {{-- HEADER MODULE --}}
            {{-- USE LAYOUT INCLUDE --}}
            @include('layouts.header.enrollment')
            
            <div class="app-main">

                @yield('content')
                
            </div>        
        </div>

        <div class="app-drawer-overlay d-none animated fadeIn"></div>








    <!-- plugin dependencies -->
    <script type="text/javascript" src="/vendors/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="/vendors/moment/moment.js"></script>
    <script type="text/javascript" src="/vendors/metismenu/dist/metisMenu.js"></script>
    {{-- <script type="text/javascript" src="/vendors/bootstrap4-toggle/js/bootstrap4-toggle.min.js"></script> --}}
    {{-- <script type="text/javascript" src="/vendors/jquery-circle-progress/dist/circle-progress.min.js"></script> --}}
    {{-- <script type="text/javascript" src="/vendors/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script> --}}
    {{-- <script type="text/javascript" src="/vendors/toastr/build/toastr.min.js"></script> --}}
    {{-- <script type="text/javascript" src="/vendors/jquery.fancytree/dist/jquery.fancytree-all-deps.min.js"></script> --}}
    {{-- <script type="text/javascript" src="/vendors/apexcharts/dist/apexcharts.min.js"></script> --}}
    {{-- <script type="text/javascript" src="./vendors/smartwizard/dist/js/jquery.smartWizard.min.js"></script> --}}


    {{-- <script type="text/javascript" src="/vendors/bootstrap-table/dist/bootstrap-table.min.js"></script>
    <script type="text/javascript" src="/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="/vendors/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <script type="text/javascript" src="/vendors/slick-carousel/slick/slick.min.js"></script> --}}


    <script type="text/javascript" src="/vendors/fullcalendar/dist/fullcalendar.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <!-- custome.js -->
    {{-- <script type="text/javascript" src="/js/charts/apex-charts.js"></script>
    <script type="text/javascript" src="/js/circle-progress.js"></script>
    <script type="text/javascript" src="/js/demo.js"></script>
    <script type="text/javascript" src="/js/scrollbar.js"></script>
    <script type="text/javascript" src="/js/toastr.js"></script>
    <script type="text/javascript" src="/js/treeview.js"></script>
    <script type="text/javascript" src="/js/form-components/toggle-switch.js"></script> --}}
    {{-- <script type="text/javascript" src="/js/form-components/form-wizard.js"></script> --}}

    {{-- <script type="text/javascript" src="/js/tables.js"></script>
    <script type="text/javascript" src="/js/carousel-slider.js"></script> --}}
    <script type="text/javascript" src="/js/app.js"></script>

    {{-- <script type="text/javascript" src="/js/calendar.js"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


    @yield('scripts')

    @yield('modals')
</body>
</html>
