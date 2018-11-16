<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->integer('id', 1)->unsigned()->nullable(false);
            $table->string('type', 32)->nullable(false);
	        $table->integer('operation_id')->unsigned()->nullable(false);
	        $table->string('qtty', 32)->nullable(false);
	        $table->string('price', 32)->nullable(false);
	        $table->string('fee', 32)->nullable(false);
	        $table->string('fee_asset', 32)->nullable(false);
	        $table->string('exchange_id', 32)->nullable(false);
	        $table->tinyInteger('canceled')->default(0)->nullable(false);
	        $table->tinyInteger('finished')->default(0)->nullable(false);
            $table->timestamps();

            $table->foreign('operation_id')->references('id')->on('operations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
