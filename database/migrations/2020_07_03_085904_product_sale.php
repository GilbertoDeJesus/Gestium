<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductSale extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sale', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->decimal('monto',6,2);
            $table->unsignedBigInteger('sale_id');
            $table->unsignedBigInteger('product_warehouse_movement_id');
            $table->timestamps();
            $table->foreign('sale_id')->references('id')->on('sales');
            $table->foreign('product_warehouse_movement_id')->references('warehouse_movement_id')->on('product_warehouse_movement');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_sale');
    }
}
