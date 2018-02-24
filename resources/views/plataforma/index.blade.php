@extends('plataforma.layouts.app')

@section('content')
<div id="homePage">
    <div class="row align-items-center">
        <div class="col text-center">
            <div class="card text-white bg-teal-darken-4 mb-3" style="max-width: 18rem;">
                <div class="card-header">Lucro Niquelino</div>
                <div class="card-body">
                    <h5 class="card-title">{{ Niquelino::getLucroBitCoin(false, null) }} BTC</h5>
                    <p class="card-text">R$ {{ Niquelino::getLucroReal(false, null) }}</p>
                    <p class="card-text">U$ {{ Niquelino::getLucroDolar(false, null) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection