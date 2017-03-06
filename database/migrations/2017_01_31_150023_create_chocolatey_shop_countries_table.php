<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChocolateyShopCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chocolatey_shop_countries', function (Blueprint $table) {
            $table->integer('id');
            $table->string('countryCode', 5)->default('all');
            $table->string('locale', 5)->nullable();
            $table->string('name', 50)->default('Global');
            $table->primary('id', 'chocolatey_shop_countries_primary');
        });

        DB::update('ALTER TABLE chocolatey_shop_countries MODIFY COLUMN id INT AUTO_INCREMENT');

        DB::table('chocolatey_shop_countries')->insert([
            ['countryCode' => 'all', 'name' => 'Global'],
            ['countryCode' => 'us', 'name' => 'USA'],
            ['countryCode' => 'br', 'name' => 'Brazil']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chocolatey_shop_countries');
    }
}
