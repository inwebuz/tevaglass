<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('shop_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('type');
            $table->string('name')->nullable();
            $table->text('description_top')->nullable();
            $table->text('description')->nullable();
            $table->text('description_bottom')->nullable();
            $table->string('button_text')->nullable();
            $table->string('url')->nullable();
            $table->string('image')->nullable();
            $table->string('image_en')->nullable();
            $table->string('image_ru')->nullable();
            $table->string('image_uz')->nullable();
            $table->string('image_mobile')->nullable();
            $table->string('text_color')->nullable();
            $table->string('language')->nullable();
            $table->timestamp('active_from')->nullable();
            $table->timestamp('active_to')->nullable();
            $table->bigInteger('order')->default(0);
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('banners');
    }
}
