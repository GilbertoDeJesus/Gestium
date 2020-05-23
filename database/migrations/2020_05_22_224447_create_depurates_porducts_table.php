<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepuratesPorductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() 
    {
        Schema::create('depurates_porducts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('products_id');
            $table->unsignedBigInteger('depurates_id');
            $table->decimal('monto',8,2);
            $table->timestamps();
            $table->foreign('products_id')->references('id')->on('products'); 
            $table->foreign('depurates_id')->references('id')->on('depurates');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('depurates_porducts');
    }
}
