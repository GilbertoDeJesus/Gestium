<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsSaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_sale', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->decimal('precio_venta',6,2);
            $table->decimal('precio_compra',6,2);
            $table->decimal('monto',6,2);
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('sale_id');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('sale_id')->references('id')->on('sales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_sale');
    }
}
