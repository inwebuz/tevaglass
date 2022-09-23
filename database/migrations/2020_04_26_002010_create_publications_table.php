<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('page_id')->nullable();
            $table->tinyInteger('type')->default(0);
            $table->string('author')->nullable();
            $table->string('name')->nullable();
            $table->string('short_name')->nullable();
            $table->string('slug')->nullable();
            $table->text('icon')->nullable();
            $table->text('image')->nullable();
            $table->text('background')->nullable();
            $table->text('images')->nullable();
            $table->text('description')->nullable();
            $table->mediumText('body')->nullable();
            $table->mediumText('additional_info')->nullable();
            $table->mediumText('video_code')->nullable();
            $table->text('file')->nullable();
            $table->text('file_name')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('featured')->default(0);
            $table->bigInteger('order')->default(1);
            $table->unsignedBigInteger('views')->default(0);
            $table->text('seo_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
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
        Schema::dropIfExists('publications');
    }
}
