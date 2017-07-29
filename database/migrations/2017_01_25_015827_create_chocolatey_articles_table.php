<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateChocolateyArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chocolatey_articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 125);
            $table->string('description', 255);
            $table->text('content');
            $table->string('author', 50);
            $table->string('categories', 255);
            $table->string('imageUrl', 255);
            $table->string('thumbnailUrl', 255);
            $table->integer('roomId')->default(0);
            $table->timestamps();
        });

        DB::table('chocolatey_articles')->insert([[
            'title'        => 'Welcome to Chocolatey',
            'description'  => "You had successfully installed Chocolatey. Now let's drink a cup of Hot Chocolate?",
            'content'      => "<b>It's good see that you chosed right!</b><br><h4>Chocolatey</h4> it's the right choose. We're glad you chosed us.<br><i>- Claudio Santoro</i>",
            'author'       => 'System',
            'categories'   => 'technical.updates',
            'imageUrl'     => 'https://habboo-a.akamaihd.net/web_images/habbo-web-articles/lpromo_gen15_51.png',
            'thumbnailUrl' => 'https://habboo-a.akamaihd.net/web_images/habbo-web-articles/lpromo_gen15_51_thumb.png',
            'created_at'   => time(),
        ]]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chocolatey_articles');
    }
}
