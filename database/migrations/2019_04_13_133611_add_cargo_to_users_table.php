<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCargoToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_portal', function (Blueprint $table) {
            $table->integer('cargo')->default(1)->after('email')->comment('Cargo do usuario. 1 - Normal');
            $table->unsignedInteger('id_user')->default(null)->after('id')->comment('Usuario do sistema.');
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_portal', function (Blueprint $table) {
            //
        });
    }
}
