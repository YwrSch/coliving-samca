<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-g">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        
        <style>
            body {
                background-color: #f5f5f5; /* Um fundo cinza claro para os cards */
            }
            .login-card { 
                margin-top: 10vh; 
                padding: 30px; 
            }
        </style>
    </head>
    <body>
        <div class="container custom-container">
            <div class="row">
                <div class="col s12 m10 offset-m1 l8 offset-l2">
                    
                    {{ $slot }}

                </div>
            </div>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        
        @stack('scripts')
    </body>
</html>