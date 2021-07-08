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
        {{-- <link href="./vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
        <link rel="stylesheet" href="/vendors/@fortawesome/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="/vendors/ionicons-npm/css/ionicons.css">
        <link rel="stylesheet" href="/vendors/linearicons-master/dist/web-font/style.css">
        <link rel="stylesheet" href="/vendors/pixeden-stroke-7-icon-master/pe-icon-7-stroke/dist/pe-icon-7-stroke.css">
        <link href="/styles/css/base.css" rel="stylesheet">
        <script src="//www.gstatic.com/cv/js/sender/v1/cast_sender.js?loadCastFramework=1"></script>

        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> --}}

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.css" integrity="sha512-oe8OpYjBaDWPt2VmSFR+qYOdnTjeV9QPLJUeqZyprDEQvQLJ9C5PCFclxwNuvb/GQgQngdCXzKSFltuHD3eCxA==" crossorigin="anonymous" referrerpolicy="no-referrer" />


        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="/js/dropzone/dropzone.js"></script>

        
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

        <script type="text/javascript" src="https://unpkg.com/webcam-easy/dist/webcam-easy.min.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

        <script
            id="sap-ui-bootstrap"
            src="https://openui5.hana.ondemand.com/resources/sap-ui-core.js"
            data-sap-ui-theme="sap_belize"
            data-sap-ui-libs="sap.m, sap.ui.layout, sap.tnt"
            data-sap-ui-resourceroots='{"Quickstart": "./"}'
            data-sap-ui-async="true"
        ></script>
        <script>
            sap.ui.getCore().attachInit(function () {
                sap.ui.require(["sap/ui/core/mvc/XMLView"], function (XMLView) {
                XMLView.create({ viewName: "Quickstart.App" }).then(function (oView) {
                    oView.placeAt("content");
                });
                });
            });
        </script>
        

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

            .modal { overflow: auto !important; }


            /* .app-sidebar.sidebar-shadow:hover {
                width: 220px !important;
                min-width: 220px !important;
            }
            
            .app-sidebar .app-sidebar__inner {
                padding: 2px 1rem 1rem !important;
            } */

    .loader .modal-dialog{
        display: table;
        position: relative;
        margin: 0 auto;
        top: calc(50% - 24px);
    }

    .bd-example-modal-lg .modal-dialog .modal-content{
        background-color: transparent;
        border: none;
    }            

        </style>    
        
        @yield('style')

    </head>

    <body>
        <div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar"> 
            {{-- closed-sidebar-mobile closed-sidebar --}}
            {{-- HEADER MODULE --}}
            {{-- USE LAYOUT INCLUDE --}}
            @include('layouts.header.index')
            
            <div class="app-main">

                {{-- SIDEBAR MODULE --}}
                <div class="app-sidebar sidebar-shadow">
                    <div class="app-header__logo">
                        <div class="logo-src"></div>
                        <div class="header__pane ml-auto">
                            <div>
                                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
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
                    <div class="scrollbar-sidebar">
                        <div class="app-sidebar__inner">
                            
                            {{-- SIDEBAR CONTENT --}}
                            @include('layouts.sidebar.menu')
                
                        </div>
                    </div>
                </div>    
                
                {{-- MAIN MODULE --}}
                <div class="app-main__outer">
                    <div class="app-main__inner">

                        {{-- INNER TITLE --}}
                        @include('layouts.inner.title')

                        {{-- MAIN CONTENT --}}
                        @yield('content')

                    </div>    

                    {{-- Footer --}}
                    {{-- @include('layouts.footer.index') --}}

                </div>
            </div>       
        </div>

        {{-- <div class="app-drawer-overlay d-none animated fadeIn"></div> --}}

    <!-- plugin dependencies -->
    <script type="text/javascript" src="/vendors/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="/vendors/moment/moment.js"></script>
    <script type="text/javascript" src="/vendors/metismenu/dist/metisMenu.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    {{-- <script type="text/javascript" src="/vendors/bootstrap4-toggle/js/bootstrap4-toggle.min.js"></script> --}}
    <script type="text/javascript" src="/vendors/jquery-circle-progress/dist/circle-progress.min.js"></script>
    {{-- <script type="text/javascript" src="/vendors/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script> --}}
    {{-- <script type="text/javascript" src="/vendors/toastr/build/toastr.min.js"></script> --}}
    {{-- <script type="text/javascript" src="/vendors/jquery.fancytree/dist/jquery.fancytree-all-deps.min.js"></script> --}}
    <script type="text/javascript" src="/vendors/apexcharts/dist/apexcharts.min.js"></script>
    {{-- <script type="text/javascript" src="/vendors/bootstrap-table/dist/bootstrap-table.min.js"></script> --}}
    {{-- <script type="text/javascript" src="/vendors/datatables.net/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script type="text/javascript" src="/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script> --}}
    {{-- <script type="text/javascript" src="/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script> --}}
    {{-- <script type="text/javascript" src="/vendors/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script> --}}
    <script type="text/javascript" src="/vendors/slick-carousel/slick/slick.min.js"></script>
    {{-- <script type="text/javascript" src="/vendors/fullcalendar/dist/fullcalendar.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js" integrity="sha512-iusSCweltSRVrjOz+4nxOL9OXh2UA0m8KdjsX8/KUUiJz+TCNzalwE0WE6dYTfHDkXuGuHq3W9YIhDLN7UNB0w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="/vendors/block-ui/jquery.blockUI.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- custome.js -->
    {{-- <script type="text/javascript" src="/js/charts/apex-charts.js"></script> --}}
    {{-- <script type="text/javascript" src="/js/circle-progress.js"></script> --}}
    <script type="text/javascript" src="/js/demo.js"></script>
    {{-- <script type="text/javascript" src="/js/scrollbar.js"></script> --}}
    {{-- <script type="text/javascript" src="/js/toastr.js"></script> --}}
    {{-- <script type="text/javascript" src="/js/treeview.js"></script> --}}
    {{-- <script type="text/javascript" src="/js/form-components/toggle-switch.js"></script> --}}
    {{-- <script type="text/javascript" src="/js/tables.js"></script> --}}
    {{-- <script type="text/javascript" src="/js/carousel-slider.js"></script> --}}
    <script type="text/javascript" src="/js/app.js"></script>

    {{-- <script type="text/javascript" src="/js/calendar.js"></script> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

    <script type="module" src="/js/echo.js"></script>

    <script>
        $(document).on("click", ".mark_as_unread", function (e) {
            e.preventDefault();

            var id = $(this).attr("data-id");
            var action = $(this).attr("data-action");

            console.log("clicked");

            $.ajax({
                url: "/read-notification/"+id+"/"+action,
                method: "GET",
                success: function (resp) {
                    if (!resp.error) {
                        $( ".notification_area" ).load(window.location.href + " .vertical-timeline-item.vertical-timeline-element" );
                        $( ".counter_notif" ).load(window.location.href + " .counter_notif span" );

                        toastr.success(resp.message, "Success");
                    } else {
                        toastr.error(resp.message, "Error");
                    }
                },
                error: function (resp) {
                    toastr.error(resp, "Error");
                }
            });
        });
    </script>
    
    @yield('js_script')


    {{-- <div class="modal fade" id="loaderModal" tabindex="-1" role="dialog" aria-labelledby="loaderModal" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="z-index: 3000 !important;">
        <div class="modal-dialog modal-dialog-centered" role="document" style="box-shadow: none !important; place-content: center;">
            <div class="font-icon-wrapper bg-white">
                <div class="loader-wrapper d-flex justify-content-center align-items-center">
                    <div class="loader">
                        <div class="line-scale-pulse-out">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                        <p>Processing...</p>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    @yield('modals')
    
</body>
</html>
