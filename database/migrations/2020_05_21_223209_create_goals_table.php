<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->boolean('producto_meta')->FALSE;
            $table->string('nombre_producto');
            $table->integer('numero_kilos');
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
        Schema::dropIfExists('goals');
    }
}
