<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->integer('id', 1)->unsigned()->nullable(false);
	        $table->tinyInteger('open')->default(1)->nullable(false);
	        $table->string('market', 32)->nullable(false);
	        $table->integer('bot_id')->nullable(false);
	        $table->tinyInteger('canceled')->default(0)->nullable(false);
	        $table->tinyInteger('finished')->default(0)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operations');
    }
}
