<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 24/02/2018
 * Time: 12:30
 */

namespace App\Http\Controllers\Niquelino;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Niquelino extends Controller {


    public static function getLucroBitCoin ($json= true, $data = null, $hora = null) {
        bcscale(8);
        $ganhos = DB::connection('mysql_niquelino')->table('ORDERS')
            ->select(DB::raw('(QUANTITY * RATE) AS GANHO'))
            ->where('TYPE', 'LIMIT_SELL')
            ->whereNotNull('CLOSED')
            ->when($data, function ($query) use ($data) {
                if(isset($data))
                    return $query->where(DB::raw("date_format(ORDERS.CLOSED,'%d/%m/%Y')"), $data);
            })
            ->when($hora, function ($query) use ($hora) {
                if(isset($hora))
                    return $query->where(DB::raw("date_format(ORDERS.CLOSED,'%d/%m/%Y %H')"), $hora);
            })
            ->get();

        $lucro = 0.0;

        foreach ($ganhos as $ganho) {
            $lucro = $lucro + $ganho->GANHO;
        }
        $total = bcmul($lucro, '0.01000000');

        return $total;
    }

    public static function getLucroReal ($json= true, $data = null) {
        bcscale(8);

        $total = Niquelino::getLucroBitCoin(true, null);

        $conv = Util::convertBtcToReal($total);
        $totalBrl = number_format($conv['brl'], 2, ',', '.');

        return $totalBrl;
    }

    public static function getLucroDolar ($json= true, $data = null) {
        bcscale(8);

        $total = Niquelino::getLucroBitCoin(true, null);

        $conv = Util::convertBtcDolar($total);
        $totalUsd = number_format($conv['usd'], 2, ',', '.');

        return $totalUsd;
    }

    public static function getUltimasVendas () {

        bcscale(8);

        $ordens = DB::connection('mysql_niquelino')->table('ORDERS')
            ->select('MARKET', 'QUANTITY', DB::raw('(QUANTITY * RATE) AS GANHO'), DB::raw('DATE_FORMAT(CLOSED, "%d/%m/%Y %H:%i:%s") as CLOSED'))
            ->latest('CLOSED')
            ->where('TYPE', 'LIMIT_SELL')
            ->whereNotNull('CLOSED')
            ->limit(3)
            ->get();

        $vendas = $ordens;

        foreach ($vendas as $venda) {
            $venda->GANHO = bcmul($venda->GANHO, '0.01000000');
        }

        return $vendas;
    }

    public static function getOrdensVenda($data = null) {
        $ordens = DB::connection('mysql_niquelino')->table('ORDERS')
            ->select(DB::raw('count(TYPE) AS ORDERS'))
            ->where('TYPE', 'LIMIT_SELL')
            ->whereNotNull('CLOSED')
            ->when($data, function ($query) use ($data) {
                if(isset($data))
                    return $query->where(DB::raw("date_format(ORDERS.CLOSED,'%d/%m/%Y')"), $data);
            })
            ->get();

        return $ordens[0]->ORDERS;
    }

    public static function getOrdensCompra($data = null) {
        $ordens = DB::connection('mysql_niquelino')->table('ORDERS')
            ->select(DB::raw('count(TYPE) AS ORDERS'))
            ->where('TYPE', 'LIMIT_SELL')
            ->when($data, function ($query) use ($data) {
                if(isset($data))
                    return $query->where(DB::raw("date_format(ORDERS.OPENED,'%d/%m/%Y')"), $data);
            })
            ->get();

        return $ordens[0]->ORDERS;
    }

    public static function getProfit() {

        $lucro = Niquelino::getLucroBitCoin(true, null);
        $a = bcmul($lucro, '100.00000000');
        $b = bcdiv($a, '0.45000000', 2);//valor negociado

        return $b;
    }

}