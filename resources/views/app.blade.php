<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Etto Lending Management System</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
       
        <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">

         @vite('resources/css/app.css')
    </head>
    <body class="antialiased font-sans bg-canvas text-slate-800">
        <div id="app">

        </div>
         @vite('resources/js/app.js') 
    </body>
</html>
