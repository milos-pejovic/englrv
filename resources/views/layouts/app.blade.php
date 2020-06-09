<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <style>

        .level-label-wrap {
            display: inline-block; 
            background: #ddd;
            margin-right: 8px;
            border-radius: 3px;
        }
        
        .level-label-wrap:hover {
            background-color: #a1cbef;
        }

        .selected-level {
            background-color: #a1cbef;
        }

        .level-label-wrap input {
            display: none;
        }

        .level-label {
            cursor: pointer;
            padding: 0 2px;
        }

        .table-single-exercise {
            border-top: 2px solid gray;
            display: inline-block;
            width: 100%;
        }

        .exercise-search .form-control {
            background-color: #eee;
        }

        .single-exercase-result-template {
            display: none;
        }

        .form-control {
            color: #000;
        }

        .exercise-tag {
            display: inline-block; 
            background-color: lightgray; 
            margin: 2px 4px 2px 0; 
            padding: 0 6px;
        }

        .search-form-div {
            margin-bottom: 10px;
        }

        .search-results-header {
            padding: 5px 10px;
            background: #454d55;
            color: #fff;
        }

        .spinner {
            display: inline-block;
            width: 40px;
            height: 40px;
        }

        .searching-for-exercises {
            display: inline-block;
            font-size: 15px;
            color: #2176bd;
        }

        .spinner-wrap {
            display: none;
        }

        .exercise-search .search-button {
            margin: 8px 0;
        }

        .result-formating-controls {
            margin-top: 10px;
            margin-bottom: 0;
        }

    </style>

    <link rel="stylesheet" href="/css/exercise.css">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
