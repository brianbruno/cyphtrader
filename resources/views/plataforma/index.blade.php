@extends('plataforma.layouts.app')

@section('content')
<div id="homePage">
    <div class="row mt-3 align-items-center">
        <div class="col col-lg-3">
            <div class="card text-white bg-teal-darken-4">
                <div class="card-header">Lucro Niquelino</div>
                <div class="card-body">
                    <i class="fab fa-bitcoin fa-5x float-right"></i>
                    <h5 class="card-title">{{ Niquelino::getLucroBitCoin(false, null) }} BTC</h5>
                    <p class="card-text">R$ {{ Niquelino::getLucroReal(false, null) }}</p>
                    <p class="card-text">U$ {{ Niquelino::getLucroDolar(false, null) }}</p>
                    <div class="card-footer text-muted">
                        Atualizado em: {{ Date("d/m/Y H:i ") }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col col-lg-9">
            <div class="card text-white bg-teal-darken-4">
                <div class="card-header">Últimas operações de venda</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">Moeda</th>
                            <th scope="col">Quantidade</th>
                            <th scope="col">Lucro (BTC)</th>
                            <th scope="col">Data da venda</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse (Niquelino::getUltimasVendas() as $operacao)
                            <tr>
                                <th>{{ $operacao->MARKET }}</th>
                                <td>{{ $operacao->QUANTITY }}</td>
                                <td>{{ $operacao->GANHO }}</td>
                                <td>{{ $operacao->CLOSED }}</td>
                            </tr>
                            @empty
                            <p>Nenhuma venda :(</p>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col col-lg-6">
            <niquelino-lucro-hoje></niquelino-lucro-hoje>
        </div>
        <div class="col col-lg-6">
            <niquelino-lucro-dia></niquelino-lucro-dia>
        </div>
    </div>


</div>
@endsection