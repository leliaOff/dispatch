<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Dispatch</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <script>
            window.baseurl  = '{{ getenv('APP_URL') }}';
            window.user     = '{{ Auth::check() ? Auth::user()->name : "" }}';
        </script>

    </head>
    <body>
        <div id="app">
            <main-menu></main-menu>
            @auth
                <div id="manager" class="container">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="panel panel-default">
                                <router-view></router-view>                                
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div id="welcome">
                    <h1>Dispatch!</h1>
                    <h2>лучший сервис из всех других сервисов *</h2>
                    <hr/>
                    <p>* но это не точно</p>
                </div>
            @endauth
        </div>
        <script src="{{ url('js/app.js') }}"></script>
        
    </body>
</html>