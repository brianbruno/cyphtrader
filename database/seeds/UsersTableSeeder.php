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
        $usuario->id_user = 0;
        $usuario->email = 'admin@admin.com';
        $usuario->name = "administrador";
        $usuario->password = Hash::make('administrador');
        $usuario->save();
    }
}
