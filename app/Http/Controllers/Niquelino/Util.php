<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 24/02/2018
 * Time: 12:36
 */

namespace App\Http\Controllers\Niquelino;


class Util {

    public static function convertBtcToReal($btc) {
        $url = "https://api.coinmarketcap.com/v1/ticker/bitcoin/?convert=BRL";
        $data = Util::request($url)[0];
        $usd = bcmul($btc, $data['price_usd'], 2);
        $brl = bcmul($btc, $data['price_brl'], 2);
        return array(
            'brl' => $brl,
            'usd' => $usd
        );
    }
    public static function convertBtcDolar($btc) {
        $url = "https://api.coinmarketcap.com/v1/ticker/bitcoin/?convert=BRL";
        $data = Util::request($url)[0];
        $usd = bcmul($btc, $data['price_usd'], 2);
        $brl = bcmul($btc, $data['price_brl'], 2);
        return array(
            'brl' => $brl,
            'usd' => $usd
        );
    }

    private static function request($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $data = curl_exec($ch);
        curl_close($ch);
        return json_decode($data, true);
    }

}