@extends('plataforma.layouts.app')

@section('content')
<div id="homePage">
    <div class="row mt-3 align-items-center">
        <div class="col col-lg-8">
            <div class="row mt-1">
                <div class="col-lg-6">
                    <div class="card border-blue-grey-darken-4">
                        <div class="card-header border-blue-grey-darken-4"><span class="plataforma-titulo-cartao">Lucro Niquelino</span><niquelino-mini-lucro-dia class="float-right"></niquelino-mini-lucro-dia></div>
                        <div class="card-body plataforma-corpo-cartao">
                            <i class="fab fa-bitcoin fa-5x float-right"></i>
                            <h2 class="card-title">{{ Niquelino::getLucroBitCoin(false, null) }} BTC</h2>
                            <p class="card-text">R$ {{ Niquelino::getLucroReal(false, null) }} | U$ {{ Niquelino::getLucroDolar(false, null) }} | {{ Niquelino::getProfit() }}%</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card border-blue-grey-darken-4">
                        <div class="card-header border-blue-grey-darken-4 plataforma-titulo-cartao">Ordens executadas hoje</div>
                        <div class="card-body plataforma-corpo-cartao">
                            <i class="fas fa-exchange-alt fa-5x float-right"></i>
                            <h1>{{ Niquelino::getOrdensCompra(date('d/m/Y')) + Niquelino::getOrdensVenda(date('d/m/Y')) }}</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-1">
                <div class="col-lg-6">
                    <div class="card border-blue-grey-darken-4">
                        <div class="card-header border-blue-grey-darken-4 plataforma-titulo-cartao">Saldo CyphTrader</div>
                        <div class="card-body plataforma-corpo-cartao">
                            <i class="far fa-credit-card fa-5x float-right"></i>
                            <h1>R$ 0,00</h1>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card border-blue-grey-darken-4">
                        <div class="card-header border-blue-grey-darken-4 plataforma-titulo-cartao">Ordens em aberto</div>
                        <div class="card-body plataforma-corpo-cartao">
                            <i class="fas fa-search fa-5x float-right"></i>
                            <h1>6</h1>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col col-lg-4">
            <niquelino-lucro-hoje></niquelino-lucro-hoje>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col col-lg-8">
            <div class="card text-white border-blue-grey-darken-4">
                <div class="card-header border-blue-grey-darken-4 plataforma-titulo-cartao">Últimas operações de venda</div>
                <div class="card-body plataforma-corpo-cartao">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">Moeda</th>
                            <th scope="col">Quantidade</th>
                            <th scope="col">Lucro (BTC)</th>
                            <th scope="col">Data</th>
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
        <div class="col col-lg-4">
            <niquelino-lucro-dia></niquelino-lucro-dia>
        </div>
    </div>


</div>
@endsection