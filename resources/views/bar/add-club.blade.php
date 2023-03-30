@extends('layouts.app')

@section('post-assets')

    <link href="/css/auth.css" rel="stylesheet">
@endsection

@section('content')



    <body class="main-bg">
    <div class="login-container text-c animated flipInX">
        <h3 class="text-whitesmoke">Vereins-Anmeldung</h3>
        <div class="container-content text-white">
            <form method="POST" action="{{ route('club.add') }}" class="margin-t">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" name="name" placeholder="Gruppen-Name" required>

                </div>

                <button type="submit" class="form-button button-l margin-b">Anlegen</button>

            </form>
            <p class="margin-t text-whitesmoke"><small> Biermeter-Pokal Nohn &copy; {{now()->year}}</small> </p>
        </div>
    </div>
    </body>
@endsection
