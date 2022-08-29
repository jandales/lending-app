<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Etto Lending Managenent System</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <script src="/node_modules/dist/js/index.min.js"></script>
        <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">
          {{-- <!-- @production
            @php
                $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);               
            @endphp
             <link rel="stylesheet" href="{{asset("build/".$manifest['resources/css/app.css']['file'])}}" >
             <script type="module" src="{{asset("build/".$manifest['resources/js/app.js']['file'])}}" ></script>           
        @else 
            @vite(['resources/css/app.css','resources/js/app.js'])
        @endproduction --> --}}

         @vite('resources/css/app.css')
    </head>
    <style>
        body{
            background: #f0f2f5;
        }
    </style>
    <body class="antialiased">
        <div id="app">

        </div>
         @vite('resources/js/app.js') 
    </body>
</html>
