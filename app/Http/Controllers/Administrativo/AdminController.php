<?php
/**
 * Created by PhpStorm.
 * User: brian
 * Date: 13/04/2019
 * Time: 13:46
 */

namespace App\Http\Controllers\Administrativo;

use App\Http\Controllers\Controller;
use App\User;
use App\UserSistema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        return view('administrativo.index', ['usuarios' => User::all()]);
    }

    public function adicionarUsuario() {
        return view('administrativo.adicionar-usuario', ['usuariosSistema' => UserSistema::all()]);
    }

    public function salvarUsuario(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:60',
            'email' => 'required|string|email|max:255|unique:users_portal',
        ]);

        $return = array('resultado' => false, 'mensagem' => 'Não processado');

        if ($validator->fails()) {
            $return['validator'] = $validator->errors();
            $return['mensagem'] = 'Preencha todos os campos obrigatórios.';

            $view = redirect()->to('administrativo/adicionar-usuario')->with(['resultado' => $return]);
        } else {

            try {
                DB::beginTransaction();

                $usuarioSistema = new UserSistema();
                $usuarioSistema->name = $request->name;
                $usuarioSistema->k = 'x';
                $usuarioSistema->s = 'y';
                $usuarioSistema->telegram_key = 'z';
                $usuarioSistema->telegram_channel = 'canal_telegram';
                $usuarioSistema->btcusdt_stop_value = '4717.00000000';
                $usuarioSistema->active = '1';
                $usuarioSistema->save();

                $usuario = new User();
                $usuario->id_user = $usuarioSistema->id;
                $usuario->email = $request->email;
                $usuario->name = $request->name;
                $usuario->password = Hash::make($request->password);
                $usuario->save();


                DB::commit();
                $return['resultado'] = true;
                $return['mensagem'] = 'Usuário cadastrado com sucesso';
                $view = redirect()->to('administrativo')->with(['resultado' => $return, 'usuarios' => User::all()]);

            } catch (\Exception $e) {

                DB::rollBack();
                $return['mensagem'] = $e->getMessage();
                $view = redirect()->to('administrativo/adicionar-usuario')->with(['resultado' => $return]);
            }
        }

        return $view;
    }

    public function delete($id) {
        $return = array('resultado' => false, 'mensagem' => 'Não processado');
        try {
            DB::beginTransaction();

            if ($id == Auth::user()->id) {
                throw new \Exception("Não é permitido excluir o próprio usuário.");
            } else if ($id == 1) {
                throw new \Exception("Não é permitido excluir o usuário padrão.");
            }
            $user = User::find($id);
            $user->delete();

            DB::commit();
            $return['resultado'] = true;
            $return['mensagem'] = 'Usuário excluído com sucesso';

        } catch (\Exception $e) {
            DB::rollBack();
            $return['mensagem'] = $e->getMessage();
        }

        return view('administrativo.index', ['resultado' => $return, 'usuarios' => User::all()]);
    }

}