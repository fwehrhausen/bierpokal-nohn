<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
          integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @yield('post-assets')

    {{--    <link href="https://cdn.jsdelivr.net/npm/beercss@3.0.8/dist/cdn/beer.min.css" rel="stylesheet" />--}}
    {{--    <script type="module" src="https://cdn.jsdelivr.net/npm/beercss@3.0.8/dist/cdn/beer.min.js"></script>--}}
    {{--    <script type="module" src="https://cdn.jsdelivr.net/npm/material-dynamic-colors@0.1.5/dist/cdn/material-dynamic-colors.min.js"></script>--}}
</head>
<body>
<div id="app">
    <main class="py-4">

        <section class="wrapper">
            <div class="container-fluid">
                @auth()
                    <div class="row">
                        <div class="col-11">
                            <div class="align-content-center">
                                <img src="/images/schild.png" style="max-height: 120px">

                                <a href="{{route('club.show-add')}}" class="btn btn-primary">Verein hinzufügen</a>
                            </div>
                        </div>
                        <div class="col-1">

                            <!-- Right Side Of Navbar -->
                            <ul class="navbar-nav ms-auto">
                                <!-- Authentication Links -->

                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                              class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </div>

                    </div>
                @endauth
                @yield('content')


            </div>
        </section>

    </main>
</div>
</body>
</html>
