<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntryProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entry_product', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->decimal('precio_compra',8,2);
            $table->unsignedBigInteger('entry_id');
            $table->unsignedBigInteger('product_id');
            $table->timestamps();

            $table->foreign('entry_id')->references('id')->on('entries');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entry_product');
    }
}
