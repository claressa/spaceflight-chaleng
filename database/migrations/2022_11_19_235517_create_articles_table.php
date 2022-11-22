<?php

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('title'      , 500);
            $table->string('url'        , 500);
            $table->string('imageUrl'   , 500);
            $table->string('newsSite'   , 200);
            $table->string('summary'    , 500);
            $table->string('publishedAt', 100);
            $table->string('updatedAt'  , 100);
            $table->boolean('featured');
            $table->json('launches')->nullable();
            $table->json('events')->nullable();
            
            $table->timestamps();

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
