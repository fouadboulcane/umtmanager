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
        Schema::table('article_devi', function (Blueprint $table) {
            $table
                ->foreign('devi_id')
                ->references('id')
                ->on('devis')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('article_id')
                ->references('id')
                ->on('articles')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('article_devi', function (Blueprint $table) {
            $table->dropForeign(['devi_id']);
            $table->dropForeign(['article_id']);
        });
    }
};
