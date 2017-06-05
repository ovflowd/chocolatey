<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateChocolateyShopPaymentCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chocolatey_shop_payment_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('country_code', 5)->default('all');
            $table->string('payment_type', 50)->default('online');
        });

        DB::table('chocolatey_shop_payment_categories')->insert([
            ['payment_type' => 'online', 'country_code' => 'all'],
            ['payment_type' => 'online', 'country_code' => 'us'],
            ['payment_type' => 'online', 'country_code' => 'br'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chocolatey_shop_payment_categories');
    }
}
