<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->required();
            $table->decimal('monto',8,2);
            $table->string('observacion');
            $table->unsignedBigInteger('deliverer_id');
            $table->unsignedBigInteger('customer_id');
            $table->timestamps();

            $table->foreign('deliverer_id')->references('id')->on('deliverers');
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
