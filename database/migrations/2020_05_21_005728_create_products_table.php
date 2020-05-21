<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->boolean('meta');
            $table->string('descripcion');
            $table->decimal('precio_compra',8,2);
            $table->decimal('precio_venta',8,2);
            $table->integer('stock');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('provider_id');
            $table->timestamps();

            $table->foreign('provider_id')->references('id')->on('providers');
            $table->foreign('unit_id')->references('id')->on('units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
