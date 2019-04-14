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
        return view('administrativo.adicionar-usuario');
    }

    public function salvarUsuario(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:60',
            'email' => 'required|string|email|max:255|unique:users_portal',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $return = array('resultado' => false, 'mensagem' => 'Não processado');

        if ($validator->fails()) {
            $return['validator'] = $validator->errors();
            $return['mensagem'] = 'Preencha todos os campos obrigatórios.';

            $view = redirect()->to('administrativo/adicionar-usuario')->with(['resultado' => $return]);
        } else {

            try {
                DB::beginTransaction();

                if (!empty($request->criarRobo) && $request->criarRobo != null) {
                    $usuarioSistema = new UserSistema();
                    $usuarioSistema->name = $request->name;
                    $usuarioSistema->k = 'x';
                    $usuarioSistema->s = 'y';
                    $usuarioSistema->telegram_key = 'z';
                    $usuarioSistema->telegram_channel = 'canal_telegram';
                    $usuarioSistema->btcusdt_stop_value = '4717.00000000';
                    $usuarioSistema->active = '1';
                    $usuarioSistema->save();

                    $id_user = $usuarioSistema->id;
                } else {
                    $id_user = null;
                }

                $usuario = new User();
                $usuario->id_user = $id_user;
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

    public function encontrarUsuario($id) {
        return view('administrativo.usuario', ['usuario' => User::where('id', $id)->first(), 'robos' => UserSistema::all()]);
    }

    public function editarUsuario(Request $request) {
        $validator = Validator::make($request->all(), [
            'id'    => 'required',
            'name'  => 'required|max:60',
            'email' => 'required|string|email|max:255',
        ]);

        $return = array('resultado' => false, 'mensagem' => 'Não processado');

        if ($validator->fails()) {
            $return['validator'] = $validator->errors();
            $return['mensagem'] = 'Preencha todos os campos obrigatórios.';

            $view = redirect()->to('administrativo/users/'.$request->id)->with(['resultado' => $return]);
        } else {

            try {
                DB::beginTransaction();

                $usuario = User::where('email', '=', $request->email)
                    ->where('id', '<>', $request->id)->count();
                if ($usuario > 0) {
                    throw new \Exception("E-mail já cadastrado. Digite um e-mail diferente.");
                }

                $usuario = User::find($request->id);
                $usuario->id_user = $request->id_user == 'null' ? null : $request->id_user;
                $usuario->email = $request->email;
                $usuario->name = $request->name;
                $usuario->password = Hash::make($request->password);
                $usuario->save();


                DB::commit();
                $return['resultado'] = true;
                $return['mensagem'] = 'Usuário alterado com sucesso';
                $view = redirect()->to('administrativo/users/'.$request->id)->with(['resultado' => $return, 'usuario' => User::where('id', $request->id)->first(), 'robos' => UserSistema::all()]);

            } catch (\Exception $e) {

                DB::rollBack();
                $return['mensagem'] = $e->getMessage();
                $view = redirect()->to('administrativo/users/'.$request->id)->with(['resultado' => $return]);
            }
        }

        return $view;
    }

}