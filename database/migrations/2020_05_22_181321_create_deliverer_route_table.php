<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDelivererRouteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliverer_route', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('deliverer_id');
            $table->unsignedBigInteger('route_id');
            $table->timestamps();

            $table->foreign('deliverer_id')->references('id')->on('deliverers');
            $table->foreign('route_id')->references('id')->on('routes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deliverer_route');
    }
}
