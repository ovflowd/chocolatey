<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateChocolateyShopItemsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chocolatey_shop_items_categories', function (Blueprint $table) {
            $table->string('category_name', 50)->default('CREDITS');
            $table->primary('category_name', 'chocolatey_shop_items_categories_primary');
            $table->unique('category_name', 'chocolatey_shop_items_categories_unique');
        });

        DB::table('chocolatey_shop_items_categories')->insert([
            ['category_name' => 'HABBO_CLUB'],
            ['category_name' => 'BUNDLE'],
            ['category_name' => 'BUILDERS_CLUB'],
            ['category_name' => 'CREDITS'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chocolatey_shop_items_categories');
    }
}
