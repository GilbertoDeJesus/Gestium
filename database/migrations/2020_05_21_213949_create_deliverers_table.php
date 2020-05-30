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
            $table->date('fecha_nacimiento')->nullable();
            $table->date('fecha_contratacion');
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
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
