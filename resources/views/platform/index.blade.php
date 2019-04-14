@extends('platform.layouts.app')

@section('content')
    <div id="homePage">
        <div class="row mt-3 align-items-center">
            <div class="col col-lg-8">
                <div class="row mt-1">
                    <div class="col-lg-6">
                        <div class="card border-blue-grey-darken-4">
                            <div class="card-header border-blue-grey-darken-4"><span class="plataforma-titulo-cartao">Saldo Niquelino</span><niquelino-mini-lucro-dia class="float-right"></niquelino-mini-lucro-dia></div>
                            <div class="card-body plataforma-corpo-cartao">
                                <i class="fab fa-bitcoin fa-5x float-right"></i>
                                <h2 class="card-title">{{ $saldo }} BTC</h2>
                                <p class="card-text">R$ 0,00 | U$ 0,00 | 0%</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card border-blue-grey-darken-4">
                            <div class="card-header border-blue-grey-darken-4 plataforma-titulo-cartao">Ordens executadas hoje</div>
                            <div class="card-body plataforma-corpo-cartao">
                                <i class="fas fa-exchange-alt fa-5x float-right"></i>
                                <h1>0</h1>
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
                                <h1>{{ $ordensAbertas }}</h1>
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

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection