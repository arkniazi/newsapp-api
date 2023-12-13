<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('news_source_id');
            $table->string('title');
            $table->text('slug');
            $table->longText('description')->nullable();
            $table->text('source_url')->nullable();
            $table->text('thumbnail_url')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->string('author')->nullable();

            $table->index('category_id');
            $table->index('news_source_id');
            $table->index('published_at');

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('news_source_id')->references('id')->on('news_sources');
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
};
