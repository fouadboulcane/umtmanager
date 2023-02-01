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
        Schema::create('articleables', function (Blueprint $table) {
            $table->unsignedBigInteger('articleable_id');
            $table->string('articleable_type');
            $table->unsignedBigInteger('article_id');
            $table->integer('quantity')->default(1);
            $table->integer('order_column')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_devi');
    }
};
