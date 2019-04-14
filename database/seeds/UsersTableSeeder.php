<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $usuario = new \App\User();
        $usuario->id_user = null;
        $usuario->email = 'admin@admin.com';
        $usuario->name = "Administrador";
        $usuario->password = Hash::make('administrador');
        $usuario->cargo = 2;
        $usuario->save();
    }
}
