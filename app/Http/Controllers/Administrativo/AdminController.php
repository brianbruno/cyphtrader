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
use mysql_xdevapi\Exception;

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

                    if (empty($request->bot_name) || empty($request->k) || empty($request->s) || empty($request->telegram_key) || empty($request->telegram_channel)) {
                        throw new \Exception("Para criar o robô você precisa preencher todos os campos relacionados a ele.");
                    }

                    $robos = UserSistema::where('name', '=', $request->bot_name)->count();

                    if ($robos > 0) {
                        throw new \Exception("Este nome de robô já está em uso.");
                    }

                    $usuarioSistema = new UserSistema();
                    $usuarioSistema->name = strtoupper(str_replace(' ', '', $request->bot_name));
                    $usuarioSistema->k = $request->k;
                    $usuarioSistema->s = $request->s;
                    $usuarioSistema->telegram_key = $request->telegram_key;
                    $usuarioSistema->telegram_channel = $request->telegram_channel;
                    $usuarioSistema->btcusdt_stop_value = '4717.00000000';
                    $usuarioSistema->active = '0';
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
                $view = redirect()->to('administrativo/users/'.$usuario->id)->with(['resultado' => $return, 'usuario' => $usuario]);

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

        $users = User::where('id_user', '<>', null)->where('id', '<>', $id)->get();
        foreach ($users as $user) {
            $data[] = $user->id_user;
        }

        $robos = UserSistema::whereNotIn('id', $data)->get();


        return view('administrativo.usuario', ['usuario' => User::where('id', $id)->first(), 'robos' => $robos]);
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

                $mensagemAdicional = "";

                $usuario = User::where('email', '=', $request->email)
                    ->where('id', '<>', $request->id)->count();
                if ($usuario > 0) {
                    throw new \Exception("E-mail já cadastrado. Digite um e-mail diferente.");
                }

                $usuario = User::find($request->id);

                $antigoUsuario = $usuario->id_user;
                $usuario->id_user = $request->id_user == 'null' ? null : $request->id_user;
                $usuario->email = $request->email;
                $usuario->name = $request->name;
                if (!empty($request->password) && strlen($request->password) >= 6) {
                    $usuario->password =  Hash::make($request->password);
                }

                $usuario->save();

                if ($request->id_user != 'null' && $antigoUsuario == $request->id_user) {
                    $usuarioSistema = UserSistema::find($usuario->id_user);

                    $usuarioSistema->k = $request->k;
                    $usuarioSistema->s = $request->s;
                    $usuarioSistema->telegram_key = $request->telegram_key;
                    $usuarioSistema->telegram_channel = $request->telegram_channel;
                    $usuarioSistema->btcusdt_stop_value = $request->btcusdt_stop_value;
                    $usuarioSistema->active = $request->active;
                    $usuarioSistema->save();

                } else {
                    $mensagemAdicional = "Nenhuma informação do robô foi alterada.";
                }


                DB::commit();
                $return['resultado'] = true;
                $return['mensagem'] = 'Usuário alterado com sucesso. '.$mensagemAdicional;
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