@extends('layouts.app')

@section('post-assets')

    <link href="/css/auth.css" rel="stylesheet">
@endsection

@section('content')



    <body class="main-bg">
    <div class="login-container text-c animated flipInX">
        <div>
            <img src="/images/jgv-nohn-logo_450x450_2.png" alt="logo" style="max-height: 200px">
        </div>
        <h3 class="text-whitesmoke">Biermeter-Pokal Nohn {{now()->year}}</h3>
        <div class="container-content text-white">
            <form method="POST" action="{{ route('login') }}" class="margin-t">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Username" name="username" required>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="*****" name="password" required>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <button type="submit" class="form-button button-l margin-b">Anmelden</button>

            </form>
            <p class="margin-t text-whitesmoke"><small> Biermeter-Pokal Nohn &copy; {{now()->year}}</small> </p>
        </div>
    </div>
    </body>
@endsection
