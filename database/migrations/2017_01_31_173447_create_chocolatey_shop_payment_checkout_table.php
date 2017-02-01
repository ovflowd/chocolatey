<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->integer('id');
            $table->string('category', 50)->default('online');
            $table->string('country', 50)->default('all');
            $table->integer('item')->default(1);
            $table->integer('method')->default(1);
            $table->string('redirect', 255);
            $table->primary('id', 'chocolatey_shop_payment_checkout_primary');
        });

        DB::update('ALTER TABLE chocolatey_shop_payment_checkout MODIFY COLUMN id INT AUTO_INCREMENT');
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
