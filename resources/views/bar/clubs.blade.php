@extends('layouts.app')

@section('content')

    <section class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col text-center mb-5">
                    <h1 class="text">Biermeter-Pokal Nohn 2023</h1>
                    <button class="btn btn-primary">Neuer Verein anlegen</button>
                </div>
            </div>
            <div class="row">
                @foreach($clubs as $club)
                    <div class="col-sm-12 col-md-6 col-lg-3 mb-4">

                            <div class="card text-white card-has-bg click-col">
                                <div class="card-img-overlay d-flex flex-column">

                                    <div class="card-body">
                                        <a href="/theke/{{$club->id}}/add-meter" class="stretched-link"></a>
                                        <small class="card-meta mb-2">Verein:</small>
                                        <h3 class="card-title mt-0 ">{{$club->name}}</h3>
                                        <h5 class="my-0 text-white d-block">
                                            Meter: {{$club->bought_meter_beers_count}}</h5>
                                        <small class="mt-3"><i class="far fa-clock"></i> letzter
                                            um: {{$club->last_bought_meter_beer_at}}</small>
                                    </div>
                                    <div class="card-footer">
                                        <div class="actions">

                                        </div>
                                    </div>

                                </div>
                            </div>

                    </div>
                @endforeach


            </div>

        </div>
    </section>
@endsection
