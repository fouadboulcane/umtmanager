<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('facebook');
            $table->string('twitter');
            $table->string('linkedin');
            $table->string('google_plus');
            $table->string('digg');
            $table->string('youtube');
            $table->string('pinterest');
            $table->string('instagram');
            $table->string('github');
            $table->string('tumblr');
            $table->string('tiktok');
            $table->unsignedBigInteger('user_id');

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
        Schema::dropIfExists('social_links');
    }
};
