<?php

namespace App\Http\Controllers;

use App\Operation;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $operacoes = Operation::where('open', '=', '1')
            ->where('bot_id', '=', Auth::user()->id_user)
            ->count();

        if (Auth::user()->id_user != null) {
            $balanco = Auth::user()->bot()->balances()->orderBy('timestamp', 'desc')->first();

            $ordensExecutadas =  DB::table('orders')
                ->join('operations', 'operations.id', '=', 'orders.operation_id')
                ->join('users', 'users.id', '=', 'operations.id')
                ->join('users_portal', 'users_portal.id_user', '=', 'users.id')
                ->where('users_portal.id', Auth::user()->id)
                ->whereRaw('DATE_FORMAT(orders.created_in,\'%d/%m/%Y\') = ?', [date('d/m/Y')])->count();
        } else {
            $ordensExecutadas = 0;
        }

        if (empty($balanco)) {
            $saldo = "0,000000";
        } else {
            $saldo = str_replace('.', ',', $balanco->btc_value);
        }


        return view('platform.index', ['ordensAbertas' => $operacoes, 'saldo' => $saldo, 'ordensExecutadas' => $ordensExecutadas]);
    }
}
