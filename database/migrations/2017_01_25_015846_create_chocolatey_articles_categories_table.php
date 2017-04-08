<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateChocolateyArticlesCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chocolatey_articles_categories', function (Blueprint $table) {
            $table->string('link', 50);
            $table->string('translate', 125);
            $table->primary('link', 'chocolatey_articles_categories_primary');
            $table->unique('link', 'chocolatey_articles_categories_unique');
        });

        DB::table('chocolatey_articles_categories')->insert([
            ['link' => 'all', 'translate' => 'NEWS_CATEGORY_ALL'],
            ['link' => 'ambassadors', 'translate' => 'NEWS_CATEGORY_AMBASSADORS'],
            ['link' => 'baw', 'translate' => 'NEWS_CATEGORY_BAW'],
            ['link' => 'campaign.activities', 'translate' => 'NEWS_CATEGORY_CAMPAIGNS_ACTIVITIES'],
            ['link' => 'credit.promo', 'translate' => 'NEWS_CATEGORY_CREDIT_PROMO'],
            ['link' => 'fansites', 'translate' => 'NEWS_CATEGORY_FANSITES'],
            ['link' => 'safety', 'translate' => 'NEWS_CATEGORY_SAFETY'],
            ['link' => 'technical.updates', 'translate' => 'NEWS_CATEGORY_TECHNICAL_UPDATES'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chocolatey_articles_categories');
    }
}
