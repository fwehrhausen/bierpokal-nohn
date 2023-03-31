@extends('layouts.app')

@section('content')

    <div class="row">

        <div class="col-10">
            <div class="row">
                @foreach($clubs as $club)
                    <!--div class="col-sm-12 col-md-6 col-lg-3 mb-4"-->


                    <div class="col-2 mb-4">
                        <div class="card">
                            <!--a href="/theke/$club->id/add-meter" class="stretched-link"></a-->
                            <h4 class="card-header">{{$club->name}} </h4>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                <h5 class="card-title">Meter: {{$club->bought_meter_beers_count}}</h5>
                                <p class="card-text"><i class="far fa-clock"></i> letzter
                                    um: {{$club->last_bought_meter_beer_at}}</p>
                                    </div>
                                    <div class="col-6">
                                        <a href="/theke/{{$club->id}}/add-meter"><i class="fa-solid fa-circle-plus text-secondary" style="font-size: 5rem"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-2">
            <h3>Offene Bestellungen</h3>
            <table class="table table-responsive">
                @forelse($openMeters as $openMeter)
                    <tr>
                        <td>
                            <a href="#" style="font-size: 40px;"><i class="fa-solid fa-square-check text-success"></i></a>
                        </td>
                        <td>
                            <h4>{{$openMeter["club"]["name"]}}</h4>
                            <p>um {{\Carbon\Carbon::parse($openMeter["created_at"])->timezone('Europe/Berlin')->toTimeString()}}</p>
                        </td>
                        <td>
                            <a href="#" style="font-size: 16px;"><i class="fa-solid fa-trash text-danger"></i></a>
                        </td>
                    </tr>
                @empty

                    <tr><td>Keine offenen Bestellungen</td></tr>
             @endforelse
            </table>
        </div>


    </div>

@endsection
