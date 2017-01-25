<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAzurePhotosReportedCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('azure_user_photos_reported_categories', function (Blueprint $table) {
            $table->integer('report_category', 11);
            $table->string('description', 255);
            $table->primary('report_category');
        });

        DB::table('azure_user_photos_reported_categories')->insert([
            ['report_category' => '1', 'description' => 'Displays Sexual Content'],
            ['report_category' => '8', 'description' => 'Reveal Real Life Information'],
            ['report_category' => '19', 'description' => 'Contains Hate Speech'],
            ['report_category' => '20', 'description' => 'Advocates Violence or Harm'],
            ['report_category' => '32', 'description' => 'Promotes Illegal Activity']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('azure_user_photos_reported_categories');
    }
}
