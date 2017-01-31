<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChocolateyShopPaymentCheckoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chocolatey_shop_payment_checkout', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category', 50)->default('online');
            $table->string('country', 50)->default('all');
            $table->integer('item')->default(1);
            $table->integer('method')->default(1);
            $table->string('redirect', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chocolatey_shop_payment_checkout');
    }
}
