<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateChocolateyShopItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chocolatey_shop_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('countryCode', 5)->default('all');
            $table->string('categories', 125)->default('CREDITS');
            $table->integer('creditAmount')->default(0);
            $table->boolean('doubleCredits')->default(false);
            $table->integer('iconId')->default(7);
            $table->string('name', 255)->default('Purchase 0 Credits');
            $table->text('description')->default('');
            $table->string('price', 50)->default('US$ 0.00');
            $table->string('payment_methods', 125)->default('paypal');
        });

        DB::table('chocolatey_shop_items')->insert([
            ['countryCode' => 'us', 'categories' => 'HABBO_CLUB', 'iconId' => 5, 'name' => 'Habbo Club - 1 month'],
            ['countryCode' => 'us', 'categories' => 'BUILDERS_CLUB', 'iconId' => 6, 'name' => 'Builders Club - 1 month'],
        ]);

        DB::table('chocolatey_shop_items')->insert([
            ['countryCode' => 'us', 'creditAmount' => 600, 'name' => '600 Credits & Diamonds'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chocolatey_shop_items');
    }
}
