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


    public static function getLucroBitCoin ($json= true, $data = null) {
        bcscale(8);
        $ganhos = DB::connection('mysql_niquelino')->table('ORDERS')
            ->select(DB::raw('(QUANTITY * RATE) AS GANHO'))
            ->where('TYPE', 'LIMIT_SELL')
            ->whereNotNull('CLOSED')
            ->when($data, function ($query) use ($data) {
                if(isset($data))
                    return $query->where(DB::raw("date_format(ORDERS.CLOSED,'%d/%m/%Y')"), $data);
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

}