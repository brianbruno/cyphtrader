<?php
/**
 * Created by PhpStorm.
 * User: brian
 * Date: 13/04/2019
 * Time: 13:46
 */

namespace App\Http\Controllers\Homebroker;

use App\Http\Controllers\Controller;
use App\User;
use App\UserSistema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class BrokerController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        return view('homebroker.index');
    }

}