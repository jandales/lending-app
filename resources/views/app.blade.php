<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <script src="./TW-ELEMENTS-PATH/dist/js/index.min.js"></script>
        @production
            @php
                $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
               
            @endphp
             <link href="{{assets("build/".$manifest['resources/css/app.css']['file'])}}" rel="stylesheet">
             <script type="module" src="{{assets("build/".$manifest['resources/js/app.js']['file'])}}" ></script>
      
                
        @else
                
        @vite(['resources/css/app.css', 'resources/js/app.js']);
        @endproduction
      
    </head>
    <style>
        body{
            background: #f0f2f5;
        }
    </style>
    <body class="antialiased">
        <div id="app">

        </div>
        {{-- @vite('resources/js/app.js') --}}
    </body>
</html>
