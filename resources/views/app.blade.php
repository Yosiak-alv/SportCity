<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!--Icon-->
        <link rel="shortcut icon" href="/storage/img/homepage/Logo.ico">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
    <style>
        ::-moz-selection { /* Code for Firefox */
            color: white;
            background: rgb(76, 175, 80) ;
        }
    
        ::selection {
            color: white;
            background: rgb(76, 175, 80) ;
        }
        html{
            scroll-behavior: smooth;
        }
    </style>
</html>
