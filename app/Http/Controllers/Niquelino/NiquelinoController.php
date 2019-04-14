<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 24/02/2018
 * Time: 15:32
 */

namespace App\Http\Controllers\Niquelino;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        $arrayRetorno = array('lucros' => [], 'horas' => [], 'status' => false, 'mensagem' => 'Não processado.');

        try {
            $lucros = [10, 25, 5, 9, 25, 5, 9, 25, 5, 9];
            $horas = ['07', '08', '09', '10', '08', '09', '10', '08', '09', '10'];
            $contador = '23';

            $hora = date('H', strtotime("-23 hour"));

           /* while(sizeof($horas)!= 24) {

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
            }*/

            $arrayRetorno['lucros'] = $lucros;
            $arrayRetorno['horas'] = $horas;
            $arrayRetorno['status'] = true;
        } catch (\Exception $e) {
            $arrayRetorno['mensagem'] = $e->getMessage();
        }

        return response()->json($arrayRetorno);
//        return $this->resposta($arrayLucro, 'json');
    }

    public function getLucroHojeMini () {
        $arrayRetorno = array('lucros' => [], 'horas' => [], 'status' => false, 'mensagem' => 'Não processado.');

        try {
            $lucros = [10, 25, 5, 9, 25, 5, 9, 25, 5, 9];
            $horas = ['07', '08', '09', '10', '08', '09', '10', '08', '09', '10'];

            if (Auth::user()->id_user != null) {
                $lucros = $horas = [];

                $balancos = Auth::user()->bot()->balances()->orderBy('timestamp', 'desc')->limit(15)->get();

                foreach ($balancos as $balanco) {
                    $lucros[] = $balanco->btc_value;
                    $horas[] = $balanco->timestamp;
                }
            }

            $arrayRetorno['lucros'] = $lucros;
            $arrayRetorno['horas'] = $horas;
            $arrayRetorno['status'] = true;
        } catch (\Exception $e) {
            $arrayRetorno['mensagem'] = $e->getMessage();
        }

        return response()->json($arrayRetorno);
//        $this->resposta($arrayLucro, 'json');
    }

}