<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{--    <link href="https://cdn.jsdelivr.net/npm/beercss@3.0.8/dist/cdn/beer.min.css" rel="stylesheet" />--}}
    {{--    <script type="module" src="https://cdn.jsdelivr.net/npm/beercss@3.0.8/dist/cdn/beer.min.js"></script>--}}
    {{--    <script type="module" src="https://cdn.jsdelivr.net/npm/material-dynamic-colors@0.1.5/dist/cdn/material-dynamic-colors.min.js"></script>--}}
</head>
<body class="secondary-color" style="background-color: #d0cfcd">
    <div id="app">
        <main class=" p-3 p-sm-3 p-md-5">
            <div class="container">
                <div class="row bg-white" style="padding: 20px; font-size: 20px; border-radius: 15px">
                    <div class="col-12">
                        <h1>Auswertung Bierpokal</h1>
                        <h5>Im Durchschnitt wurde alle {{$total_arvg}}min ein Meter Bier verkauft.</h5>
                        <table class="table">
                            <tr>
                                <th>Verein</th>
                                <th>Anzahl</th>
                                <th>im ∅ Durchschnitt</th>
                            </tr>
                            @foreach($clubs as $club)
                                <tr>
                                    <td>{{$club["club"]}}</td>
                                    <td>{{$club["total"]}}</td>
                                    <td>alle {{$club["arvg"]}} min</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
<style>
    html {
        height: 100%;
        width: 100%
    }
    main {

    }
    body {
        background-color: #d0cfcd !important;
        background-image: url(/images/nohn_background.jpg);
        background-size: 100%;
        background-repeat: no-repeat;
        background-position: center bottom;
        background-attachment: fixed;
        color: #000 !important;
    }
</style>
</html>


