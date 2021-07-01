 <!doctype html>
 <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
     <head>
         
         <!-- CSRF Token -->
         <meta name="csrf-token" content="{{ csrf_token() }}">
 
         <title>{{ config('app.name', 'SAM') }}</title>
 
         <meta charset="utf-8">
         <meta http-equiv="X-UA-Compatible" content="IE=edge">
         <meta http-equiv="Content-Language" content="en">
         <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
         <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
         <meta name="description" content="ArchitectUI HTML Bootstrap 4 Dashboard Template">
 
         <!-- Disable tap highlight on IE -->
         <meta name="msapplication-tap-highlight" content="no">
         <link rel="stylesheet" href="/vendors/@fortawesome/fontawesome-free/css/all.min.css">
         <link rel="stylesheet" href="/vendors/ionicons-npm/css/ionicons.css">
         <link rel="stylesheet" href="/vendors/linearicons-master/dist/web-font/style.css">
         <link rel="stylesheet" href="/vendors/pixeden-stroke-7-icon-master/pe-icon-7-stroke/dist/pe-icon-7-stroke.css">
         <link href="/styles/css/base.css" rel="stylesheet">
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
 