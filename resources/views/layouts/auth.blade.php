 <!doctype html>
 <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
     <head>
         
         <!-- CSRF Token -->
         <meta name="csrf-token" content="{{ csrf_token() }}">
 
         <title>{{ config('app.name', 'aweSAM') }}</title>
 
         <meta charset="utf-8">
         <meta http-equiv="X-UA-Compatible" content="IE=edge">
         <meta http-equiv="Content-Language" content="en">
         <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
         <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
         <meta name="description" content="ArchitectUI HTML Bootstrap 4 Dashboard Template">
         <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
         <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
         <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
         <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
         <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
         <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
         <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
         <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
         <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
         <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
         <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
         <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
         <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
         <link rel="manifest" href="/manifest.json">
         <meta name="msapplication-TileColor" content="#ffffff">
         <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
         <meta name="theme-color" content="#ffffff">
         <!-- Disable tap highlight on IE -->
         <meta name="msapplication-tap-highlight" content="no">
         <link rel="stylesheet" href="/vendors/@fortawesome/fontawesome-free/css/all.min.css">
         <link rel="stylesheet" href="/vendors/ionicons-npm/css/ionicons.css">
         <link rel="stylesheet" href="/vendors/linearicons-master/dist/web-font/style.css">
         <link rel="stylesheet" href="/vendors/pixeden-stroke-7-icon-master/pe-icon-7-stroke/dist/pe-icon-7-stroke.css">
         <link href="/styles/css/base.css" rel="stylesheet">

         <meta property="og:image" content="{{ asset('images/awesam.png') }}" />
     </head>
     <body>
         <style>
             /* .app-logo-inverse:before {
                content: "SAM" !important;
                font-size: 30px !important;
                color: white;
            }

            .app-logo-inverse {
                    box-shadow: 0px 0px 5px #fff;

                background: none !important;
            } */
         </style>
         <div class="app-container app-theme-white body-tabs-shadow">
             <div class="h-100 bg-plum-plate bg-animation">
                 <div class="d-flex h-100 justify-content-center align-items-center">
                     <div class="mx-auto app-login-box col-md-8">
                             @yield('content')
                         <div class="text-center text-white opacity-8 mt-3">Copyright © Globe Telecoms - Site Acquisition & Management 2021</div>
                     </div>
                 </div>
             </div>
         </div>
     </body>
 </html>
 