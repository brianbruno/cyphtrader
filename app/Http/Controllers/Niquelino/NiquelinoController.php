<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 24/02/2018
 * Time: 15:32
 */

namespace App\Http\Controllers\Niquelino;

use App\Http\Controllers\Controller;


class NiquelinoController extends Controller {

    public function getLucroPorDia () {
        $dias = [];
        $lucros = [];
        $contador = '6';
        $arrayDataFormatado = [];

        array_push($dias, date('d/m/Y', strtotime("-6 day")),
            date('d/m/Y', strtotime("-5 day")), date('d/m/Y', strtotime("-4 day")),
            date('d/m/Y', strtotime("-3 day")), date('d/m/Y', strtotime("-2 day")),
            date('d/m/Y', strtotime('-1day')), date('d/m/Y'));

        foreach ($dias as $dia) {
            $lucroDia = Niquelino::getLucroBitCoin(false, $dia);
            array_push($lucros, $lucroDia);
            array_push($arrayDataFormatado, date('d/m', strtotime("-".$contador." day")));
            $contador--;
        }

        $arrayLucro = array("lucros" => $lucros, "dias" => $arrayDataFormatado);

        return $this->resposta($arrayLucro, 'json');
    }

    public function getLucroHoje () {
        $lucros = [];
        $horas = [];
        $contador = '23';

        $hora = date('H', strtotime("-23 hour"));

        while(sizeof($horas)!= 24) {

            if($hora < 0) {
                $hora = $hora + 24;
            }
            else if ($hora == 24) {
                $hora = '0';
            }

            $string = "-".$contador." hour";

            $proximaData = date('d/m/Y H', strtotime($string));


            $lucroDia = Niquelino::getLucroBitCoin(false, null, $proximaData);
            array_push($lucros, $lucroDia);
            array_push($horas, $hora.":00");
            $hora++;
            $contador--;
        }

        $arrayLucro = array("lucros" => $lucros, "horas" => $horas);

        return $this->resposta($arrayLucro, 'json');
    }

    public function getLucroHojeMini () {
        $lucros = [];
        $horas = [];
        $contador = '23';

        $hora = date('H', strtotime("-23 hour"));

        while(sizeof($horas)!= 24) {

            if($hora < 0) {
                $hora = $hora + 24;
            }
            else if ($hora == 24) {
                $hora = '0';
            }

            $string = "-".$contador." hour";

            $proximaData = date('d/m/Y H', strtotime($string));


            $lucroDia = Niquelino::getLucroBitCoin(false, null, $proximaData);
            $lucroDiaEmReais = Util::convertBtcToReal($lucroDia);
            array_push($lucros, $lucroDiaEmReais['brl']);
            array_push($horas, $hora.":00");
            $hora++;
            $contador--;
        }

        $arrayLucro = array("lucros" => $lucros, "horas" => $horas);

        return $this->resposta($arrayLucro, 'json');
    }

}