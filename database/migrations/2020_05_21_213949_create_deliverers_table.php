<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliverersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliverers', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('aPaterno');
            $table->string('aMaterno');
            $table->date('fecha_nacimiento')->NULL;
            $table->date('fecha_contratacion');
            $table->string('telfono')->NULL;
            $table->string('email')->NULL;
            $table->boolean('status')->TRUE;
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
        Schema::dropIfExists('deliverers');
    }
}
