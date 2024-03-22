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
                            <h4 class="card-header">
                                {{$club->name}}
                            </h4>
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <h5 class="card-title">Meter:<br>
                                            {{$club->bought_meter_beers_count}}
                                        </h5>

                                    </div>
                                    <div class="col-6">
                                        <a href="/theke/{{$club->id}}/add-meter" style="margin-top: -50px; padding-top: -20px">
                                            <i
                                                class="fa-solid fa-circle-plus text-success"
                                                style="font-size: 4.5rem"></i></a>
                                    </div>
                                </div>
                                <div class="row border-top mt-2">

                                    <div class="col-6 text-center pt-3">
                                        <h6 class="card-title @if($club->meters_in_circulation>=3) fw-bold text-danger @endif">im Umlauf: <br>{{$club->meters_in_circulation}}</h6>

                                    </div>
                                    <div class="col-6">
                                        <div class="mt-3 text-center">
                                            @if($club->meters_in_circulation > 0)
                                                <a href="/theke/{{$club->id}}/return-meter" class="btn btn-warning"><i
                                                        class="fa solid fa-undo"></i></a>
                                            @else
                                                <a href="/theke/{{$club->id}}/return-meter" class="btn btn-secondary"
                                                   disabled=""><i
                                                        class="fa solid fa-undo"></i></a>
                                            @endif
                                            Rückgabe
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                    <p class="card-text"><i class="far fa-clock"></i> letzter
                                        um: {{$club->last_bought_meter_beer_at}}</p>
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
                            <a href="/theke/{{$openMeter["id"]}}/finish" style="font-size: 40px;"><i
                                    class="fa-solid fa-square-check text-success"></i></a>
                        </td>
                        <td>
                            <h4>{{$openMeter["club"]["name"]}}</h4>
                            <p>
                                um {{\Carbon\Carbon::parse($openMeter["created_at"])->timezone('Europe/Berlin')->toTimeString()}}</p>
                        </td>
                        <td>
                            <a href="/theke/{{$openMeter["id"]}}/delete" style="font-size: 16px;"><i
                                    class="fa-solid fa-trash text-danger"></i></a>
                        </td>
                    </tr>
                @empty

                    <tr>
                        <td>Keine offenen Bestellungen</td>
                    </tr>
                @endforelse
            </table>
        </div>


    </div>

@endsection
