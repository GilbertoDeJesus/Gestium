<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepurateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depurate_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('depurate_id');
            $table->integer('cantidad');
            $table->double('tipoMovimiento');
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('depurate_id')->references('id')->on('depurates');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('depurate_product');
    }
}
