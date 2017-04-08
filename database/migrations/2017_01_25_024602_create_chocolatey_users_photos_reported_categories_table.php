<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateChocolateyUsersPhotosReportedCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chocolatey_users_photos_reported_categories', function (Blueprint $table) {
            $table->integer('report_category');
            $table->string('description', 255);
            $table->primary('report_category', 'chocolatey_users_photos_reported_categories_primary');
        });

        DB::table('chocolatey_users_photos_reported_categories')->insert([
            ['report_category' => '1', 'description' => 'Displays Sexual Content'],
            ['report_category' => '8', 'description' => 'Reveal Real Life Information'],
            ['report_category' => '19', 'description' => 'Contains Hate Speech'],
            ['report_category' => '20', 'description' => 'Advocates Violence or Harm'],
            ['report_category' => '32', 'description' => 'Promotes Illegal Activity'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chocolatey_users_photos_reported_categories');
    }
}
