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
        Schema::table('invoices', function (Blueprint $table) {
            $table
                ->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('client_id')
                ->references('id')
                ->on('clients')
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
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropForeign(['client_id']);
        });
    }
};
