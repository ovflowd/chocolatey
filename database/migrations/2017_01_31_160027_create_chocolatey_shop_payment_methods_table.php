<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateChocolateyShopPaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chocolatey_shop_payment_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('buttonLogoUrl', 255)->default('//habboo-a.akamaihd.net/c_images/cbs2_partner_logos/partner_logo_paypal_001.png');
            $table->string('buttonText', 255)->nullable();
            $table->string('localizationKey', 125)->default('paypal');
            $table->string('name', 125)->default('PayPal');
            $table->integer('category')->default(1);
            $table->boolean('disclaimer')->default(false);
            $table->text('smallPrint')->nullable();
        });

        DB::table('chocolatey_shop_payment_methods')->insert([
            ['name' => 'PayPal', 'localizationKey' => 'paypal'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chocolatey_shop_payment_methods');
    }
}
