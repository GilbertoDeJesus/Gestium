<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepuratesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depurates', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_salida');
            $table->unsignedBigInteger('deliverer_id');
            $table->timestamps();
            $table->foreign('deliverer_id')->references('id')->on('deliverers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('depurates');
    }
}
