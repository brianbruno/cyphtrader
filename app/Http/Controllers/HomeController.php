<?php

namespace App\Http\Controllers;

use App\Operation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
//        dump(Auth::user()->id_user);die;
//        $operacoes = 0;

        return view('platform.index', ['ordensAbertas' => $operacoes]);
    }
}
